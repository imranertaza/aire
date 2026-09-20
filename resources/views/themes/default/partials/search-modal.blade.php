<!-- AIRE Smart Search & Discovery Modal -->
<div class="aire-search-backdrop" id="aireSearchBackdrop"></div>

<div class="aire-search-modal" id="aireSearchModal" role="dialog" aria-modal="true" aria-labelledby="searchModalTitle"
    data-lenis-prevent>
    <div class="aire-search-modal-container">
        <!-- Floating Search Input Bar -->
        <form class="aire-search-bar" id="aireSearchForm" action="{{ route('products.filter') }}" method="GET">
            <div class="aire-search-input-wrap">
                <i class="bi bi-search aire-search-icon-input"></i>
                <input type="search" name="search" id="aireSearchInput" class="aire-search-input"
                    placeholder="Search products, solutions, or model numbers..." autocomplete="off" spellcheck="false">
                <button type="button" class="aire-search-clear d-none" id="aireSearchClear"
                    aria-label="Clear search text">
                    <i class="bi bi-x-circle-fill"></i>
                </button>
            </div>
            <button type="submit" class="aire-search-submit" aria-label="Submit search">
                <i class="bi bi-search"></i>
            </button>
        </form>

        <!-- Main Card Body -->
        <div class="aire-search-card">
            <!-- Modal Header -->
            <div class="aire-search-header d-flex align-items-center justify-content-between">
                <div>
                    <h3 class="aire-search-heading" id="searchModalTitle">Find the right air solution</h3>
                    <p class="aire-search-subheading">Search by product name, model number, requirement or application
                    </p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="aire-search-kbd-hint d-none d-md-inline-flex align-items-center gap-1">
                        Press <kbd>Enter</kbd> to search
                    </span>
                    <button type="button" class="aire-search-close-btn" id="aireSearchCloseBtn"
                        aria-label="Close search dialog">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>

            <!-- Guidance & Hints State (Shown when input is empty or query < 2 chars) -->
            <div class="aire-search-guidance" id="aireSearchGuidance">
                <!-- Popular Searches Section -->
                @php
                    $popularSearches = \Illuminate\Support\Facades\Cache::remember(
                        'aire_popular_searches_list',
                        1800,
                        function () use ($settings) {
                            $list = [];

                            // 1. Check if admin configured custom popular searches in Setting
                            if (!empty($settings['popular_searches'])) {
                                $raw = is_array($settings['popular_searches'])
                                    ? $settings['popular_searches']
                                    : preg_split('/[,\r\n]+/', (string) $settings['popular_searches']);
                                foreach ($raw as $item) {
                                    $term = trim($item);
                                    if (!empty($term)) {
                                        $list[] = [
                                            'keyword' => $term,
                                            'label' => $term,
                                        ];
                                    }
                                }
                            }

                            // 2. Otherwise dynamically fetch from Database
                            if (empty($list)) {
                                // Active Product Categories (excluding generic names)
                                $categories = \App\Models\ProductCategory::active()
                                    ->whereNotIn('category_name', [
                                        'Products',
                                        'All Products',
                                        'Uncategorized',
                                        'Default',
                                    ])
                                    ->where(function ($q) {
                                        $q->whereNull('parent_id')
                                            ->orWhere('show_in_filter', 1)
                                            ->orWhere('header_menu', 1);
                                    })
                                    ->take(4)
                                    ->pluck('category_name')
                                    ->toArray();

                                foreach ($categories as $catName) {
                                    $list[] = [
                                        'keyword' => $catName,
                                        'label' => $catName,
                                    ];
                                }

                                // Dynamic Filter Options (Problems, Requirements, Applications)
                                $filterValues = \App\Models\FilterOptionValue::whereHas('filterOption', function ($q) {
                                    $q->whereIn('name', [
                                        'Problem',
                                        'Requirement',
                                        'Solution',
                                        'Application',
                                        'Building',
                                        'Health Concern',
                                    ]);
                                })
                                    ->take(4)
                                    ->pluck('name')
                                    ->toArray();

                                foreach ($filterValues as $valName) {
                                    $list[] = [
                                        'keyword' => $valName,
                                        'label' => $valName,
                                    ];
                                }

                                // Product Model
                                $model = \App\Models\Product::where('status', 1)
                                    ->whereNotNull('model')
                                    ->where('model', '!=', '')
                                    ->latest('id')
                                    ->value('model');

                                if ($model) {
                                    $list[] = [
                                        'keyword' => $model,
                                        'label' => 'Model ' . $model,
                                    ];
                                }
                            }

                            // 3. Fallback defaults if database has no entries
                            if (empty($list)) {
                                $list = [
                                    ['keyword' => 'Air Purifier', 'label' => 'Air Purifier'],
                                    ['keyword' => 'ERV', 'label' => 'ERV'],
                                    ['keyword' => 'AHU', 'label' => 'AHU'],
                                    ['keyword' => 'PM2.5 Removal', 'label' => 'PM2.5 Removal'],
                                    ['keyword' => 'Hospital HVAC', 'label' => 'Hospital HVAC'],
                                    ['keyword' => 'Cleanroom', 'label' => 'Cleanroom'],
                                    ['keyword' => 'BAP-500', 'label' => 'Model BAP-500'],
                                    ['keyword' => 'Indoor Air Quality', 'label' => 'Indoor Air Quality'],
                                ];
                            }

                            // Add appropriate contextual icons
                            return array_map(function ($item) {
                                $kw = strtolower($item['keyword'] . ' ' . $item['label']);
                                $icon = 'bi bi-search';

                                if (
                                    str_contains($kw, 'erv') ||
                                    str_contains($kw, 'ahu') ||
                                    str_contains($kw, 'fresh air') ||
                                    str_contains($kw, 'humidity')
                                ) {
                                    $icon = 'bi bi-droplet-half text-primary';
                                } elseif (
                                    str_contains($kw, 'hospital') ||
                                    str_contains($kw, 'cleanroom') ||
                                    str_contains($kw, 'office') ||
                                    str_contains($kw, 'school') ||
                                    str_contains($kw, 'residential') ||
                                    str_contains($kw, 'hvac') ||
                                    str_contains($kw, 'building')
                                ) {
                                    $icon = 'bi bi-buildings text-primary';
                                } elseif (
                                    str_contains($kw, 'pm2.5') ||
                                    str_contains($kw, 'virus') ||
                                    str_contains($kw, 'filter') ||
                                    str_contains($kw, 'pathogen') ||
                                    str_contains($kw, 'allergen') ||
                                    str_contains($kw, 'voc')
                                ) {
                                    $icon = 'bi bi-shield-check text-primary';
                                } elseif (
                                    str_contains($kw, 'model') ||
                                    str_contains($kw, 'bap-') ||
                                    str_contains($kw, 'ap-') ||
                                    str_contains($kw, 'kj')
                                ) {
                                    $icon = 'bi bi-file-earmark-text text-primary';
                                }

                                $item['icon'] = $icon;
                                return $item;
                            }, array_slice($list, 0, 10));
                        },
                    );
                @endphp

                <div class="aire-popular-section">
                    <h5 class="aire-popular-title">Popular Searches</h5>
                    <div class="aire-popular-chips-wrap">
                        @foreach ($popularSearches as $chip)
                            <button type="button" class="aire-search-chip" data-keyword="{{ $chip['keyword'] }}">
                                <i class="{{ $chip['icon'] ?? 'bi bi-search' }}"></i> {{ $chip['label'] }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- "Not sure what you need?" Prompt Helper Card -->
                <div class="aire-not-sure-box">
                    <div class="d-flex align-items-center gap-3">
                        <div class="aire-not-sure-icon">
                            <i class="bi bi-lightbulb"></i>
                        </div>
                        <div class="aire-not-sure-content">
                            <div class="aire-not-sure-title">Not sure what you need?</div>
                            <p class="aire-not-sure-desc mb-0">
                                Type your requirement in simple words, like &ldquo;clean air for classroom&rdquo; or
                                &ldquo;reduce virus in hospital OT&rdquo;.
                            </p>
                        </div>
                    </div>
                    <button type="button" class="aire-btn-try-example" id="aireBtnTryExample">
                        Try an example <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </div>
            </div>

            <!-- Live Search Results State (Shown when query >= 2 chars) -->
            <div class="aire-search-results" id="aireSearchResults" style="display: none;"></div>
        </div>
    </div>
</div>
