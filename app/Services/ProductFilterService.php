<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\FilterOption;
use App\Models\FilterOptionValue;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Slider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class ProductFilterService
 *
 * Encapsulates all storefront catalog filtering, wizard multi-step filtering,
 * category hierarchy traversal, option resolution, and dynamic aggregations.
 */
class ProductFilterService
{
    /**
     * Parse budget / price range string into min and max float values.
     * Handles formats: "under_500", "500-1000", "1000_2500", "2500+", "over_3000", "medium", "commercial", etc.
     *
     * @param string|null $val
     * @return array{min: float, max: float|null}|null
     */
    public function parseBudget(?string $val): ?array
    {
        if (empty($val) || $val === 'any' || $val === 'all') {
            return null;
        }

        $str = strtolower(trim((string) $val));
        $clean = str_replace(['$', '€', '£', ',', ' '], '', $str);

        // 1. Under / Below / Less than / Up to / 0 to X
        if (
            strpos($str, 'under') !== false ||
            strpos($str, 'below') !== false ||
            strpos($str, 'upto') !== false ||
            strpos($str, 'less') !== false ||
            strpos($str, 'entry') !== false ||
            strpos($str, '0_') === 0 ||
            strpos($str, '0-') === 0
        ) {
            if (preg_match('/(\d+)/', $clean, $m)) {
                return ['min' => 0.0, 'max' => (float) $m[1]];
            }
        }

        // 2. Over / Above / More than / Plus / + / Enterprise / 3000+
        if (
            strpos($str, 'over') !== false ||
            strpos($str, 'above') !== false ||
            strpos($str, 'more') !== false ||
            strpos($str, 'greater') !== false ||
            strpos($str, '+') !== false ||
            strpos($str, 'plus') !== false ||
            strpos($str, 'enterprise') !== false
        ) {
            if (preg_match('/(\d+)/', $clean, $m)) {
                return ['min' => (float) $m[1], 'max' => null];
            }
        }

        // 3. Between min and max: "500_1000", "1000_2500", "500-1000", "500_to_1000"
        if (preg_match('/(\d+)(?:-|–|_to_|to|_)(\d+)/', $clean, $m)) {
            return ['min' => (float) $m[1], 'max' => (float) $m[2]];
        }

        // 4. Named presets fallback
        return match ($str) {
            'entry', '0-500'          => ['min' => 0.0, 'max' => 500.0],
            'medium', '500-1000'      => ['min' => 500.0, 'max' => 1000.0],
            'commercial', '1000-1500', '1000-2500' => ['min' => 1000.0, 'max' => 2500.0],
            'premium', '1500-2000', '2500-5000'   => ['min' => 2500.0, 'max' => 5000.0],
            'industrial', '2000-3000' => ['min' => 2000.0, 'max' => 3000.0],
            default                   => null,
        };
    }

    /**
     * In-memory category hierarchy resolver (0 recursive DB queries via cached parent tree).
     *
     * @param array<int|string>|int|string $catIds
     * @return array<int>
     */
    public function getCategoryWithDescendantIds(array|int|string $catIds): array
    {
        $baseIds = array_filter(array_map('intval', (array) $catIds));
        if (empty($baseIds)) {
            return [];
        }

        $allCategoryPairs = Cache::remember('catalog_category_pairs_v1', 3600, function () {
            return ProductCategory::select('id', 'parent_id', 'slug', 'category_name')->get();
        });

        $categoriesByParent = [];
        foreach ($allCategoryPairs as $c) {
            $categoriesByParent[$c->parent_id][] = $c->id;
        }

        $allIds = $baseIds;
        $queue = $baseIds;

        while (!empty($queue)) {
            $nextQueue = [];
            foreach ($queue as $pId) {
                if (!empty($categoriesByParent[$pId])) {
                    foreach ($categoriesByParent[$pId] as $childId) {
                        $allIds[] = $childId;
                        $nextQueue[] = $childId;
                    }
                }
            }
            $queue = $nextQueue;
        }

        return array_values(array_unique($allIds));
    }

    /**
     * Resolve request input values (slugs or names) to exact FilterOptionValue IDs using static cached lookup.
     *
     * @param array<string|int>|string|int|null $reqValues
     * @param string|null $optionNameKeyword
     * @return array<int>
     */
    public function resolveOptionValueIds(array|string|int|null $reqValues, ?string $optionNameKeyword = null): array
    {
        if (empty($reqValues) || $reqValues === 'any' || $reqValues === 'all') {
            return [];
        }

        $reqList = array_map('strval', (array) $reqValues);

        $allDbOptionValues = Cache::remember('filter_all_option_values_v1', 3600, function () {
            return FilterOptionValue::with('filterOption:id,name')->get();
        });

        return $allDbOptionValues->filter(function ($ov) use ($reqList, $optionNameKeyword) {
            if ($optionNameKeyword) {
                $opt = $ov->filterOption;
                if ($opt && stripos($opt->name, $optionNameKeyword) === false) {
                    return false;
                }
            }
            $slug = Str::slug($ov->name, '_');
            return in_array($slug, $reqList, true)
                || in_array((string) $ov->id, $reqList, true)
                || in_array(strtolower($ov->name), array_map('strtolower', $reqList), true);
        })->pluck('id')->map(fn($id) => (int) $id)->toArray();
    }

    /**
     * Resolve category from ID, slug, or name.
     *
     * @param string|int|null $param
     * @return ProductCategory|null
     */
    public function resolveCategory(string|int|null $param): ?ProductCategory
    {
        if (empty($param) || $param === 'any' || $param === 'all') {
            return null;
        }

        if (is_numeric($param)) {
            return ProductCategory::with([
                'featuredTopProducts.images',
                'featuredMiddleProducts.images',
                'featuredBottomProducts.images',
                'children'
            ])->find((int) $param);
        }

        $slugKeyword = str_replace('_', '-', (string) $param);
        $nameKeyword = str_replace(['_', '-'], ' ', (string) $param);

        return ProductCategory::with([
            'featuredTopProducts.images',
            'featuredMiddleProducts.images',
            'featuredBottomProducts.images',
            'children'
        ])->where('slug', $slugKeyword)
            ->orWhere('slug', (string) $param)
            ->orWhere('category_name', $nameKeyword)
            ->orWhere('category_name', (string) $param)
            ->first();
    }

    /**
     * Resolve Top, Middle, and Bottom featured products for a category with cached site-wide fallbacks.
     *
     * @param ProductCategory|null $category
     * @param bool $skipUnused On AJAX requests, middle/bottom can be omitted to save resources
     * @return array{top: Product|null, middle: Product|null, bottom: Product|null}
     */
    public function resolveCategoryFeatured(?ProductCategory $category = null, bool $skipUnused = false): array
    {
        $top = $category?->featuredTopProducts?->first();
        $middle = $category?->featuredMiddleProducts?->first();
        $bottom = $category?->featuredBottomProducts?->first();

        if (!$top || (!$skipUnused && (!$middle || !$bottom))) {
            $fallbackFeatured = Cache::remember('site_default_featured_products', 3600, function () {
                return Product::where('status', 1)
                    ->where('featured', 1)
                    ->with(['categories', 'images'])
                    ->latest('id')
                    ->limit(3)
                    ->get();
            });

            $top = $top ?: ($fallbackFeatured->get(0) ?? null);
            if (!$skipUnused) {
                $middle = $middle ?: ($fallbackFeatured->get(1) ?? $top);
                $bottom = $bottom ?: ($fallbackFeatured->get(2) ?? $top);
            }
        }

        return [
            'top'    => $top,
            'middle' => $middle,
            'bottom' => $bottom,
        ];
    }

    /**
     * Apply all catalog & storefront filtering criteria to a Product query builder.
     *
     * @param Builder $query
     * @param array<string, mixed> $params
     * @return Builder
     */
    public function applyFilters(Builder $query, array $params): Builder
    {
        // 1. Search Query
        $search = trim((string) ($params['search'] ?? ''));
        if (!empty($search)) {
            $keywords = array_filter(explode(' ', $search), fn($k) => mb_strlen(trim($k)) >= 3);
            $query->where(function ($sq) use ($search, $keywords) {
                $sq->where('name', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('product_code', 'like', "%{$search}%")
                    ->orWhereHas('categories', fn($cq) => $cq->where('category_name', 'like', "%{$search}%"))
                    ->orWhereHas('description', function ($dq) use ($search) {
                        $dq->where('tag', 'like', "%{$search}%")
                            ->orWhere('meta_title', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%");
                    })
                    ->orWhereHas('productFilterOptions.filterOptionValue', function ($foq) use ($search) {
                        $foq->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('applications', function ($aq) use ($search) {
                        $aq->where('title', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%");
                    });

                if (!empty($keywords) && count($keywords) > 1) {
                    foreach ($keywords as $kw) {
                        $kw = trim($kw);
                        if (in_array(strtolower($kw), ['for', 'the', 'and', 'with', 'air', 'all'], true)) {
                            continue;
                        }
                        $sq->orWhere('name', 'like', "%{$kw}%")
                            ->orWhere('model', 'like', "%{$kw}%")
                            ->orWhereHas('productFilterOptions.filterOptionValue', fn($foq) => $foq->where('name', 'like', "%{$kw}%"))
                            ->orWhereHas('applications', fn($aq) => $aq->where('title', 'like', "%{$kw}%"));
                    }
                }
            });
        }

        // 2. Category Filter
        $categories = (array) ($params['category'] ?? []);
        $cleanCategories = array_filter($categories, fn($v) => !empty($v) && $v !== 'any' && $v !== 'all');

        if (!empty($cleanCategories)) {
            $allCategoryPairs = Cache::remember('catalog_category_pairs_v1', 3600, function () {
                return ProductCategory::select('id', 'parent_id', 'slug', 'category_name')->get();
            });

            $baseCatIds = [];
            foreach ($cleanCategories as $cVal) {
                $slugKeyword = str_replace('_', '-', (string) $cVal);
                $nameKeyword = str_replace(['_', '-'], ' ', (string) $cVal);
                $found = $allCategoryPairs->first(function ($cat) use ($cVal, $slugKeyword, $nameKeyword) {
                    return (string) $cat->id === (string) $cVal
                        || $cat->slug === $slugKeyword
                        || $cat->slug === (string) $cVal
                        || strcasecmp($cat->category_name, $nameKeyword) === 0
                        || strcasecmp($cat->category_name, (string) $cVal) === 0;
                });
                if ($found) {
                    $baseCatIds[] = $found->id;
                }
            }

            $allCatIds = $this->getCategoryWithDescendantIds($baseCatIds);
            if (!empty($allCatIds)) {
                $query->whereHas('categories', fn($cq) => $cq->whereIn('product_categories.id', $allCatIds));
            }
        } elseif (!empty($params['currentCategory'])) {
            $cat = $params['currentCategory'];
            $allCatIds = $this->getCategoryWithDescendantIds([$cat->id]);
            $query->whereHas('categories', fn($cq) => $cq->whereIn('product_categories.id', $allCatIds));
        }

        // 3. Dynamic Option-based Filters
        $dbOptions = $this->getActiveFilterOptions();
        $paramKeyMap = [
            'building type'    => 'building_type',
            'room / area type' => 'room_type',
            'room type'        => 'room_type',
            'area range (m²)'  => 'area_range',
            'area range'       => 'area_range',
            'occupancy'        => 'occupancy',
            'health concern'   => 'health_concern',
            'problem'          => 'problem',
            'solution needed'  => 'solution_needed',
            'budget range'     => 'budget',
            'budget'           => 'budget',
        ];

        foreach ($dbOptions as $opt) {
            $optNameLower = strtolower(trim($opt->name));
            $paramKey = $paramKeyMap[$optNameLower] ?? Str::slug($opt->name, '_');
            if ($paramKey === 'budget' || stripos($opt->name, 'budget') !== false) {
                continue; // Handled in budget block
            }

            $val = $params[$paramKey] ?? ($params[Str::slug($opt->name, '_')] ?? null);
            if (!empty($val) && $val !== 'any' && $val !== 'all') {
                $valIds = $this->resolveOptionValueIds($val, $opt->name);
                if (!empty($valIds)) {
                    $query->whereHas('productFilterOptions', fn($fq) => $fq->whereIn('filter_option_value_id', $valIds));
                }
            }
        }

        // 4. Budget / Price Range Filter
        $budget = $params['budget'] ?? null;
        if (!empty($budget) && $budget !== 'any' && $budget !== 'all') {
            $budgetList = is_array($budget) ? $budget : [$budget];
            $ranges = [];
            foreach ($budgetList as $bItem) {
                $parsed = $this->parseBudget((string) $bItem);
                if ($parsed) {
                    $ranges[] = $parsed;
                }
            }

            if (!empty($ranges)) {
                $query->where(function ($bq) use ($ranges) {
                    foreach ($ranges as $idx => $r) {
                        if ($r['max'] === null) {
                            $idx === 0
                                ? $bq->where('price', '>=', $r['min'])
                                : $bq->orWhere('price', '>=', $r['min']);
                        } elseif ($r['min'] <= 0) {
                            $idx === 0
                                ? $bq->where('price', '<=', $r['max'])
                                : $bq->orWhere('price', '<=', $r['max']);
                        } else {
                            $idx === 0
                                ? $bq->whereBetween('price', [$r['min'], $r['max']])
                                : $bq->orWhereBetween('price', [$r['min'], $r['max']]);
                        }
                    }
                });
            }
        }

        return $query;
    }

    /**
     * Build catalog filter sections, option counts, and parameter mappings for filter sidebar.
     * Uses progressive cascading filtering so each section only shows options available
     * in products matching preceding active selections.
     *
     * @param Request $request
     * @param array<string|int> $cleanCategories
     * @param ProductCategory|null $currentCategory
     * @return array<string, mixed>
     */
    public function buildCatalogFilterSections(Request $request, array $cleanCategories, ?ProductCategory $currentCategory = null): array
    {
        $dbOptions = $this->getActiveFilterOptions();
        $dbFilterCategories = $this->getActiveFilterCategories();

        $search = trim((string) $request->input('search', ''));

        $paramKeyMap = [
            'building type'    => 'building_type',
            'room / area type' => 'room_type',
            'room type'        => 'room_type',
            'area range (m²)'  => 'area_range',
            'area range'       => 'area_range',
            'occupancy'        => 'occupancy',
            'health concern'   => 'health_concern',
            'problem'          => 'problem',
            'solution needed'  => 'solution_needed',
            'budget range'     => 'budget',
            'budget'           => 'budget',
        ];

        // 1. Determine available categories based on search / active products
        $catCandidateQuery = Product::where('status', 1);
        if (!empty($search)) {
            $catCandidateQuery = $this->applyFilters($catCandidateQuery, ['search' => $search]);
        }
        $catCandidateProductIds = $catCandidateQuery->pluck('id')->toArray();

        $activeCatIdsWithProducts = !empty($catCandidateProductIds)
            ? DB::table('product_to_categories')
            ->whereIn('product_id', $catCandidateProductIds)
            ->pluck('category_id')
            ->unique()
            ->toArray()
            : [];

        $filterCategories = [];
        $selectedCatSlugsOrIds = array_map('strval', $cleanCategories);

        foreach ($dbFilterCategories as $cat) {
            $key = $cat->slug ?: (string) $cat->id;
            $catDescendantIds = $this->getCategoryWithDescendantIds([$cat->id]);

            $hasProducts = !empty(array_intersect($catDescendantIds, $activeCatIdsWithProducts));
            $isSelected = in_array((string) $cat->id, $selectedCatSlugsOrIds, true)
                || in_array((string) $cat->slug, $selectedCatSlugsOrIds, true)
                || ($currentCategory && ($currentCategory->id == $cat->id || $currentCategory->slug == $cat->slug));

            if ($hasProducts || $isSelected) {
                $filterCategories[$key] = $cat->category_name;
            }
        }

        $filterOptionTypes = [];
        foreach ($dbOptions as $opt) {
            $filterOptionTypes[$opt->name] = $opt->type ?? 'radio';
        }

        // 2. Cascading / Progressive filter sections:
        // Accumulate active filters progressively so each downstream section only displays
        // options that exist in products matching the upstream selections!
        $accumulatedFilters = [
            'search'          => $search,
            'category'        => $cleanCategories,
            'currentCategory' => $currentCategory,
        ];

        $dynamicFilterSections = [];
        $filterBuildingTypes = [];
        $filterRoomTypes = [];
        $filterAreaRanges = [];
        $filterOccupancies = [];
        $filterHealthConcerns = [];
        $filterProblems = [];
        $filterSolutions = [];
        $filterBudgets = [];

        foreach ($dbOptions as $opt) {
            $optNameLower = strtolower(trim($opt->name));
            $paramKey = $paramKeyMap[$optNameLower] ?? Str::slug($opt->name, '_');
            $isCheckbox = ($opt->type === 'checkbox');
            $inputName = $isCheckbox ? ($paramKey . '[]') : $paramKey;
            $reqValues = (array) $request->input($paramKey, []);
            $activeRadioVal = $request->input($paramKey, 'any');

            // Find candidate products matching all upstream filters accumulated so far
            $candidateQuery = Product::where('status', 1);
            $candidateQuery = $this->applyFilters($candidateQuery, $accumulatedFilters);
            $candidateProductIds = $candidateQuery->pluck('id')->toArray();

            $sectionOptions = [];
            $hasChecked = false;

            if ($paramKey === 'budget' || stripos($opt->name, 'budget') !== false) {
                $candidatePrices = !empty($candidateProductIds)
                    ? DB::table('products')
                    ->whereIn('id', $candidateProductIds)
                    ->pluck('price')
                    ->map(fn($p) => (float) $p)
                    ->toArray()
                    : [];

                foreach ($opt->optionValues as $ov) {
                    if (strtolower($ov->name) === 'any') {
                        continue;
                    }
                    $val = Str::slug($ov->name, '_') ?: $ov->name;
                    $label = $ov->name;
                    $isChecked = $isCheckbox ? in_array($val, $reqValues, true) : ($activeRadioVal === $val);
                    if ($isChecked) {
                        $hasChecked = true;
                    }

                    $parsedRange = $this->parseBudget($val) ?: $this->parseBudget($label);
                    $hasBudgetMatch = false;

                    if ($parsedRange && !empty($candidatePrices)) {
                        foreach ($candidatePrices as $pPrice) {
                            if ($parsedRange['max'] === null) {
                                if ($pPrice >= $parsedRange['min']) {
                                    $hasBudgetMatch = true;
                                    break;
                                }
                            } elseif ($parsedRange['min'] <= 0) {
                                if ($pPrice <= $parsedRange['max']) {
                                    $hasBudgetMatch = true;
                                    break;
                                }
                            } else {
                                if ($pPrice >= $parsedRange['min'] && $pPrice <= $parsedRange['max']) {
                                    $hasBudgetMatch = true;
                                    break;
                                }
                            }
                        }
                    }

                    // Show option ONLY if it exists in candidate products or is currently checked
                    if ($isChecked || $hasBudgetMatch) {
                        $sectionOptions[$val] = [
                            'label'      => $label,
                            'is_checked' => $isChecked,
                        ];
                        $filterBudgets[$val] = $label;
                    }
                }
            } else {
                $optValueIds = $opt->optionValues->pluck('id')->toArray();
                $candidateOptionCounts = !empty($candidateProductIds) && !empty($optValueIds)
                    ? DB::table('product_filter_options')
                    ->whereIn('product_id', $candidateProductIds)
                    ->whereIn('filter_option_value_id', $optValueIds)
                    ->select('filter_option_value_id', DB::raw('COUNT(DISTINCT product_id) as total'))
                    ->groupBy('filter_option_value_id')
                    ->pluck('total', 'filter_option_value_id')
                    ->toArray()
                    : [];

                foreach ($opt->optionValues as $ov) {
                    if (strtolower($ov->name) === 'any') {
                        continue;
                    }
                    $val = Str::slug($ov->name, '_') ?: $ov->name;
                    $label = $ov->name;
                    $isChecked = $isCheckbox ? in_array($val, $reqValues, true) : ($activeRadioVal === $val);
                    if ($isChecked) {
                        $hasChecked = true;
                    }

                    $hasMatch = !empty($candidateOptionCounts[(int) $ov->id]);

                    // Show option ONLY if it exists in candidate products or is currently checked
                    if ($isChecked || $hasMatch) {
                        $sectionOptions[$val] = [
                            'label'      => $label,
                            'is_checked' => $isChecked,
                        ];
                        match ($paramKey) {
                            'building_type'   => $filterBuildingTypes[$val] = $label,
                            'room_type'       => $filterRoomTypes[$val] = $label,
                            'area_range'      => $filterAreaRanges[$val] = $label,
                            'occupancy'       => $filterOccupancies[$val] = $label,
                            'health_concern'  => $filterHealthConcerns[$val] = $label,
                            'problem'         => $filterProblems[$val] = $label,
                            'solution_needed' => $filterSolutions[$val] = $label,
                            default           => null,
                        };
                    }
                }
            }

            if (!empty($sectionOptions)) {
                $dynamicFilterSections[] = [
                    'id'          => $opt->id,
                    'name'        => $opt->name,
                    'param_key'   => $paramKey,
                    'input_name'  => $inputName,
                    'type'        => $opt->type ?? 'radio',
                    'is_checkbox' => $isCheckbox,
                    'has_checked' => $hasChecked,
                    'options'     => $sectionOptions,
                    'sort_order'  => $opt->sort_order,
                ];
            }

            // If user selected value(s) for this section, add to accumulated filters for downstream sections
            $rawInputVal = $request->input($paramKey);
            if (!empty($rawInputVal) && $rawInputVal !== 'any' && $rawInputVal !== 'all') {
                $accumulatedFilters[$paramKey] = $rawInputVal;
            }
        }

        return compact(
            'dbOptions',
            'filterOptionTypes',
            'filterCategories',
            'dynamicFilterSections',
            'filterBuildingTypes',
            'filterRoomTypes',
            'filterAreaRanges',
            'filterOccupancies',
            'filterHealthConcerns',
            'filterProblems',
            'filterSolutions',
            'filterBudgets'
        );
    }

    /**
     * Multi-step filter wizard data with dynamic progress percentages.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getFilterStepsData(): array
    {
        return Cache::remember('filter_steps_data_v9', 86400, function () {
            $data = [];
            $stepNum = 1;

            // 1. Categories
            $filterCategories = ProductCategory::active()
                ->where('show_in_filter', 1)
                ->orderBy('sort_order')
                ->get();

            if ($filterCategories->count() > 0) {
                $options = [];
                foreach ($filterCategories as $cat) {
                    $catSlug = $cat->slug ?: Str::slug($cat->category_name, '_');
                    $catNameLower = strtolower($cat->category_name);

                    $icon = 'bi-grid';
                    if (str_contains($catNameLower, 'solution')) $icon = 'bi-box-seam';
                    elseif (str_contains($catNameLower, 'industry')) $icon = 'bi-building';
                    elseif (str_contains($catNameLower, 'tech')) $icon = 'bi-cpu';
                    elseif (str_contains($catNameLower, 'commercial')) $icon = 'bi-buildings';
                    elseif (str_contains($catNameLower, 'residential')) $icon = 'bi-house';

                    $options[] = [
                        'label' => $cat->category_name,
                        'icon'  => $icon,
                        'val'   => $catSlug,
                    ];
                }
                $options[] = ['label' => 'Any', 'icon' => 'bi-grid', 'val' => 'any'];

                $data[] = [
                    'stepNum'   => $stepNum,
                    'stepId'    => 'category',
                    'type'      => 'radio',
                    'stepType'  => 'radio',
                    'stepName'  => $stepNum . '. CATEGORIES',
                    'stepTitle' => 'Select Category',
                    'stepTag'   => 'CATEGORY SELECTION',
                    'options'   => $options,
                ];
                $stepNum++;
            }

            // 2. Dynamic DB Filter Options
            $dbOptions = FilterOption::with(['optionValues' => function ($q) {
                $q->where('status', 1)->orderBy('sort_order');
            }])
                ->where('status', 1)
                ->where('show_in_filter', 1)
                ->whereNotIn('name', ['Color', 'Size', 'Material'])
                ->orderBy('sort_order')
                ->get();

            foreach ($dbOptions as $opt) {
                $options = [];
                $defaultIcon = $opt->icon ?: 'bi-check-circle';

                if (!$opt->icon) {
                    $optNameLower = strtolower($opt->name);
                    if (str_contains($optNameLower, 'industry') || str_contains($optNameLower, 'building')) $defaultIcon = 'bi-building';
                    elseif (str_contains($optNameLower, 'room') || str_contains($optNameLower, 'area type')) $defaultIcon = 'bi-door-closed';
                    elseif (str_contains($optNameLower, 'area range')) $defaultIcon = 'bi-aspect-ratio';
                    elseif (str_contains($optNameLower, 'occupancy')) $defaultIcon = 'bi-people';
                    elseif (str_contains($optNameLower, 'health')) $defaultIcon = 'bi-shield-check';
                    elseif (str_contains($optNameLower, 'problem')) $defaultIcon = 'bi-exclamation-triangle';
                    elseif (str_contains($optNameLower, 'solution')) $defaultIcon = 'bi-box-seam';
                    elseif (str_contains($optNameLower, 'budget')) $defaultIcon = 'bi-cash-stack';
                }

                if ($opt->optionValues && $opt->optionValues->count() > 0) {
                    foreach ($opt->optionValues as $ov) {
                        if (strtolower($ov->name) === 'any') continue;

                        $valSlug = Str::slug($ov->name, '_');
                        $label = $ov->name;
                        $optNameLower = strtolower($opt->name);

                        if (str_contains($optNameLower, 'area range') && !str_contains(strtolower($ov->name), 'm²') && !str_contains(strtolower($ov->name), 'm2') && !str_contains(strtolower($ov->name), 'sq')) {
                            $label .= ' m²';
                        }
                        if (str_contains($optNameLower, 'occupancy') && !str_contains(strtolower($ov->name), 'person')) {
                            $label .= ($ov->name === '1' ? ' Person' : ' Persons');
                        }

                        $options[] = [
                            'label' => $label,
                            'icon'  => $ov->icon ?: $defaultIcon,
                            'val'   => $valSlug,
                        ];
                    }
                }
                $options[] = ['label' => 'Any', 'icon' => 'bi-grid', 'val' => 'any'];

                $data[] = [
                    'stepNum'   => $stepNum,
                    'stepId'    => Str::slug($opt->name, '_'),
                    'type'      => $opt->type ?: 'radio',
                    'stepType'  => $opt->type ?: 'radio',
                    'stepName'  => $stepNum . '. ' . strtoupper($opt->name),
                    'stepTitle' => 'Select ' . $opt->name,
                    'stepTag'   => strtoupper($opt->name),
                    'options'   => $options,
                ];

                $stepNum++;
            }

            $totalSteps = max(count($data), 1);
            foreach ($data as $index => $stepItem) {
                $num = $stepItem['stepNum'];
                $data[$index]['stepCount'] = 'STEP ' . $num . ' / ' . $totalSteps;
                $data[$index]['progressPct'] = round(($num / $totalSteps) * 100);
            }

            return $data;
        });
    }

    /**
     * Apply wizard API filters with fallback to Category FilterOptionValues.
     *
     * @param Builder $query
     * @param array<string, mixed> $params
     * @return Builder
     */
    public function applyWizardFilters(Builder $query, array $params): Builder
    {
        $category = $params['category'] ?? null;
        if (!empty($category) && $category !== 'any' && $category !== 'all') {
            $slugKeyword = str_replace('_', '-', (string) $category);
            $nameKeyword = str_replace(['_', '-'], ' ', (string) $category);

            $targetCategory = ProductCategory::where(function ($cq) use ($category, $slugKeyword, $nameKeyword) {
                $cq->where('slug', $slugKeyword)
                    ->orWhere('slug', (string) $category)
                    ->orWhere('category_name', $nameKeyword)
                    ->orWhere('category_name', (string) $category);
            })->first();

            $catValIds = $this->resolveOptionValueIds($category, 'Category');

            $query->where(function ($q) use ($targetCategory, $catValIds) {
                if ($targetCategory) {
                    $catIds = [$targetCategory->id];
                    if ($targetCategory->children && $targetCategory->children->count() > 0) {
                        $catIds = array_merge($catIds, $targetCategory->children->pluck('id')->toArray());
                    }
                    $q->whereHas('categories', fn($cq) => $cq->whereIn('product_categories.id', $catIds));
                }
                if (!empty($catValIds)) {
                    $q->orWhereHas('productFilterOptions', fn($fq) => $fq->whereIn('filter_option_value_id', $catValIds));
                }
            });
        }

        $optionFilters = [
            'building_type'   => 'Building',
            'room_type'       => 'Room',
            'area_range'      => 'Area',
            'occupancy'       => 'Occupancy',
            'health_concern'  => 'Health',
            'problem'         => 'Problem',
            'solution_needed' => 'Solution',
        ];

        foreach ($optionFilters as $paramKey => $keyword) {
            $val = $params[$paramKey] ?? null;
            if (!empty($val) && $val !== 'any' && $val !== 'all') {
                $valIds = $this->resolveOptionValueIds($val, $keyword);
                if (!empty($valIds)) {
                    $query->whereHas('productFilterOptions', fn($fq) => $fq->whereIn('filter_option_value_id', $valIds));
                }
            }
        }

        $budget = $params['budget'] ?? null;
        if (!empty($budget) && $budget !== 'any' && $budget !== 'all') {
            $parsedBudget = $this->parseBudget((string) $budget);
            if ($parsedBudget) {
                if ($parsedBudget['max'] === null) {
                    $query->where('price', '>=', $parsedBudget['min']);
                } elseif ($parsedBudget['min'] <= 0) {
                    $query->where('price', '<=', $parsedBudget['max']);
                } else {
                    $query->whereBetween('price', [$parsedBudget['min'], $parsedBudget['max']]);
                }
            }
        }

        return $query;
    }

    /**
     * Format a product entity into structured JSON for frontend wizard consumption.
     *
     * @param Product $p
     * @return array<string, mixed>
     */
    public function formatWizardProduct(Product $p): array
    {
        $firstCategory = $p->categories->first();
        $subCategory = $p->categories->skip(1)->first();
        $categoryName = $firstCategory?->category_name;
        $categoryBgColor = $firstCategory?->bg_color ?: '#00c853';
        $subtitle = $p->description?->tag ?: ($subCategory?->category_name ?: ($firstCategory?->alt_name ?: 'ENTERPRISE FILTRATION'));

        $cadr = $p->productAttributes->first(fn($a) => stripos($a->name, 'CADR') !== false)?->details ?? '550 m³/h';
        $grade = $p->productAttributes->first(fn($a) => stripos($a->name, 'Grade') !== false || stripos($a->name, 'Filter') !== false)?->details ?? 'HEPA H13';
        $desc = function_exists('getLimitedText') ? \getLimitedText(strip_tags($p->description?->description ?? ''), 140) : '';

        return [
            'id'                => $p->id,
            'name'              => $p->name,
            'model'             => $p->model ?? '',
            'brand'             => $p->brand->name ?? 'AIRE',
            'price'             => number_format((float) ($p->price ?? 0), 2),
            'raw_price'         => (float) ($p->price ?? 0),
            'main_image'        => function_exists('getImageUrl') ? getImageUrl($p->main_image) : ($p->main_image ?? ''),
            'slug'              => $p->slug ?: $p->id,
            'url'               => route('products.detail', $p->slug ?: $p->id),
            'category'          => $categoryName ?? 'Air Purifier',
            'category_bg_color' => $categoryBgColor,
            'subtitle'          => strtoupper($subtitle),
            'description'       => $desc,
            'cadr'              => $cadr,
            'filter_grade'      => $grade,
            'quantity'          => (int) ($p->quantity ?? 0),
        ];
    }

    /**
     * Compute available wizard cascading options given an array of matching product IDs.
     *
     * @param array<int> $matchingProductIds
     * @return array<string, array<string>>
     */
    public function computeWizardAvailableOptions(array $matchingProductIds): array
    {
        $availableOptions = [];
        if (empty($matchingProductIds)) {
            return $availableOptions;
        }

        $allDbOptionValues = Cache::remember('filter_all_option_values_v1', 3600, function () {
            return FilterOptionValue::with('filterOption:id,name')->get();
        });

        $validOptValueIds = DB::table('product_filter_options')
            ->whereIn('product_id', $matchingProductIds)
            ->pluck('filter_option_value_id')
            ->unique()
            ->toArray();

        foreach ($allDbOptionValues as $ov) {
            if (in_array((int) $ov->id, $validOptValueIds, true) && $ov->filterOption) {
                $optSlug = Str::slug($ov->filterOption->name, '_');
                $valSlug = Str::slug($ov->name, '_');
                $availableOptions[$optSlug][] = $valSlug;
            }
        }

        $matchingPrices = DB::table('products')
            ->whereIn('id', $matchingProductIds)
            ->pluck('price')
            ->map(fn($p) => (float) $p)
            ->toArray();

        $budgetOpt = Cache::remember('filter_budget_option_v1', 3600, function () {
            return FilterOption::with('optionValues')->where('status', 1)->where('name', 'like', '%budget%')->first();
        });

        if ($budgetOpt) {
            $bSlug = Str::slug($budgetOpt->name, '_');
            foreach ($budgetOpt->optionValues as $bVal) {
                if (strtolower($bVal->name) === 'any') continue;
                $bValSlug = Str::slug($bVal->name, '_') ?: $bVal->name;
                $parsedRange = $this->parseBudget($bValSlug) ?: $this->parseBudget($bVal->name);
                if ($parsedRange) {
                    foreach ($matchingPrices as $pPrice) {
                        if ($parsedRange['max'] === null && $pPrice >= $parsedRange['min']) {
                            $availableOptions[$bSlug][] = $bValSlug;
                            break;
                        } elseif ($parsedRange['min'] <= 0 && $pPrice <= $parsedRange['max']) {
                            $availableOptions[$bSlug][] = $bValSlug;
                            break;
                        } elseif ($pPrice >= $parsedRange['min'] && $pPrice <= $parsedRange['max']) {
                            $availableOptions[$bSlug][] = $bValSlug;
                            break;
                        }
                    }
                }
            }
        }

        return $availableOptions;
    }

    /**
     * Retrieve active filter options from DB with eager loaded option values.
     *
     * @return Collection<FilterOption>
     */
    public function getActiveFilterOptions(): Collection
    {
        return Cache::remember('filter_active_db_options', 3600, function () {
            return FilterOption::with(['optionValues' => function ($q) {
                $q->where('status', 1)->orderBy('sort_order');
            }])
                ->where('status', 1)
                ->where('show_in_filter', 1)
                ->whereNotIn('name', ['Color', 'Size', 'Material'])
                ->orderBy('sort_order')
                ->get();
        });
    }

    /**
     * Retrieve active filter categories.
     *
     * @return Collection<ProductCategory>
     */
    public function getActiveFilterCategories(): Collection
    {
        return Cache::remember('filter_active_categories', 3600, function () {
            return ProductCategory::active()
                ->where('show_in_filter', 1)
                ->orderBy('sort_order')
                ->get();
        });
    }

    /**
     * Retrieve sidebar ad sliders.
     *
     * @return Collection<Slider>
     */
    public function getSidebarAdSliders(): Collection
    {
        return Cache::remember('filter_ad_sliders', 3600, function () {
            return Slider::where('enabled', 1)
                ->where(function ($q) {
                    $q->where('key', 'filter')
                        ->orWhere('key', 'like', '%filter%')
                        ->orWhere('key', 'category_sidebar')
                        ->orWhere('key', 'like', '%category_sidebar%');
                })
                ->orderBy('order', 'asc')
                ->get();
        });
    }
}
