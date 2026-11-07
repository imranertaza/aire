<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\FilterOption;
use App\Models\FilterOptionValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class FilterOptionController extends Controller
{
    /**
     * Retrieve a paginated list of filter options with their values.
     */
    public function index(Request $request)
    {
        $query = FilterOption::with('optionValues');

        // Optional view filter: 'catalog', 'guided_finder', or 'all'
        $view = $request->query('view');
        if ($view === 'guided_finder') {
            $query->where('show_in_guided_finder', 1)
                ->orderBy('guided_step_number', 'asc')
                ->orderBy('sort_order', 'asc');
        } elseif ($view === 'catalog') {
            $query->where('show_in_catalog', 1)
                ->orderBy('sort_order', 'asc');
        } else {
            $query->orderBy('sort_order', 'asc')->latest('id');
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('guided_question', 'like', "%{$search}%")
                    ->orWhere('guided_subtitle', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->input('per_page', 10);
        $options = $query->paginate($perPage);

        return ApiResponse::success($options, 'Filter options retrieved successfully');
    }

    /**
     * Retrieve a single filter option.
     */
    public function show($id)
    {
        $option = FilterOption::with('optionValues')->findOrFail($id);
        return ApiResponse::success($option, 'Filter option retrieved successfully');
    }

    /**
     * Retrieve all filter options for dropdowns.
     */
    public function allOptions()
    {
        Cache::forget('all_filter_options');
        $options = FilterOption::with('optionValues')->where('status', 1)->orderBy('sort_order', 'asc')->get();
        return ApiResponse::success($options, 'All filter options retrieved successfully');
    }


    /**
     * Store a new filter option and its values.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                     => 'required|string|max:155',
            'icon'                     => 'nullable|string|max:255',
            'type'                     => 'required|string|max:32',
            'sort_order'               => 'nullable|integer|min:0',
            'status'                   => 'required|in:0,1,true,false',
            'show_in_filter'           => 'nullable|in:0,1,true,false',
            'show_in_catalog'          => 'nullable|in:0,1,true,false',
            'show_in_guided_finder'    => 'nullable|in:0,1,true,false',
            'guided_step_number'       => 'nullable|integer|min:1|max:20',
            'guided_question'          => 'nullable|string|max:255',
            'guided_subtitle'          => 'nullable|string|max:255',
            'has_unknown_option'       => 'nullable|in:0,1,true,false',
            'unknown_option_label'     => 'nullable|string|max:100',
            'option_values'            => 'nullable|array',
            'option_values.*.name'       => 'required_with:option_values|string|max:155',
            'option_values.*.icon'       => 'nullable|string|max:255',
            'option_values.*.explanation'=> 'nullable|string|max:1000',
            'option_values.*.sort_order' => 'nullable|integer|min:0',
        ]);

        try {
            DB::beginTransaction();

            $showInFilter = filter_var($validated['show_in_filter'] ?? 1, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
            $showInCatalog = isset($validated['show_in_catalog'])
                ? (filter_var($validated['show_in_catalog'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0)
                : $showInFilter;

            $optionData = [
                'name'                  => $validated['name'],
                'icon'                  => $validated['icon'] ?? null,
                'type'                  => $validated['type'],
                'sort_order'            => $validated['sort_order'] ?? 0,
                'status'                => filter_var($validated['status'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'show_in_filter'        => $showInCatalog,
                'show_in_catalog'       => $showInCatalog,
                'show_in_guided_finder' => filter_var($validated['show_in_guided_finder'] ?? 0, FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'guided_step_number'    => $validated['guided_step_number'] ?? null,
                'guided_question'       => $validated['guided_question'] ?? null,
                'guided_subtitle'       => $validated['guided_subtitle'] ?? null,
                'has_unknown_option'    => filter_var($validated['has_unknown_option'] ?? 1, FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'unknown_option_label'  => $validated['unknown_option_label'] ?? "I don't know",
                'createdBy'             => Auth::id(),
                'updatedBy'             => Auth::id(),
            ];

            $option = FilterOption::create($optionData);

            if (!empty($validated['option_values'])) {
                foreach ($validated['option_values'] as $value) {
                    $option->optionValues()->create([
                        'name'        => $value['name'],
                        'icon'        => $value['icon'] ?? null,
                        'explanation' => $value['explanation'] ?? null,
                        'sort_order'  => $value['sort_order'] ?? 0,
                        'status'      => 1, // Default active
                        'createdBy'   => Auth::id(),
                        'updatedBy'   => Auth::id(),
                    ]);
                }
            }

            DB::commit();

            // Reload with relations to return
            $option->load('optionValues');

            return ApiResponse::success($option, 'Filter option created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Failed to create filter option', 500, [$e->getMessage()]);
        }
    }

    /**
     * Update an existing filter option.
     */
    public function update(Request $request, $id)
    {
        $option = FilterOption::findOrFail($id);

        $validated = $request->validate([
            'name'                     => 'required|string|max:155',
            'icon'                     => 'nullable|string|max:255',
            'type'                     => 'required|string|max:32',
            'sort_order'               => 'nullable|integer|min:0',
            'status'                   => 'required|in:0,1,true,false',
            'show_in_filter'           => 'nullable|in:0,1,true,false',
            'show_in_catalog'          => 'nullable|in:0,1,true,false',
            'show_in_guided_finder'    => 'nullable|in:0,1,true,false',
            'guided_step_number'       => 'nullable|integer|min:1|max:20',
            'guided_question'          => 'nullable|string|max:255',
            'guided_subtitle'          => 'nullable|string|max:255',
            'has_unknown_option'       => 'nullable|in:0,1,true,false',
            'unknown_option_label'     => 'nullable|string|max:100',
            'option_values'            => 'nullable|array',
            'option_values.*.id'         => 'nullable|integer',
            'option_values.*.name'       => 'required_with:option_values|string|max:155',
            'option_values.*.icon'       => 'nullable|string|max:255',
            'option_values.*.explanation'=> 'nullable|string|max:1000',
            'option_values.*.sort_order' => 'nullable|integer|min:0',
        ]);

        try {
            DB::beginTransaction();

            $showInFilter = filter_var($validated['show_in_filter'] ?? $option->show_in_filter, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
            $showInCatalog = isset($validated['show_in_catalog'])
                ? (filter_var($validated['show_in_catalog'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0)
                : $showInFilter;

            $optionData = [
                'name'                  => $validated['name'],
                'icon'                  => $validated['icon'] ?? null,
                'type'                  => $validated['type'],
                'sort_order'            => $validated['sort_order'] ?? 0,
                'status'                => filter_var($validated['status'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'show_in_filter'        => $showInCatalog,
                'show_in_catalog'       => $showInCatalog,
                'show_in_guided_finder' => filter_var($validated['show_in_guided_finder'] ?? 0, FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'guided_step_number'    => $validated['guided_step_number'] ?? null,
                'guided_question'       => $validated['guided_question'] ?? null,
                'guided_subtitle'       => $validated['guided_subtitle'] ?? null,
                'has_unknown_option'    => filter_var($validated['has_unknown_option'] ?? 1, FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'unknown_option_label'  => $validated['unknown_option_label'] ?? "I don't know",
                'updatedBy'             => Auth::id(),
            ];

            $option->update($optionData);

            $existingValueIds = [];
            if (!empty($validated['option_values'])) {
                foreach ($validated['option_values'] as $value) {
                    if (isset($value['id']) && $value['id']) {
                        // Update existing
                        $optionValue = FilterOptionValue::find($value['id']);
                        if ($optionValue) {
                            $optionValue->update([
                                'name'        => $value['name'],
                                'icon'        => $value['icon'] ?? null,
                                'explanation' => $value['explanation'] ?? null,
                                'sort_order'  => $value['sort_order'] ?? 0,
                                'updatedBy'   => Auth::id(),
                            ]);
                            $existingValueIds[] = $optionValue->id;
                        }
                    } else {
                        // Create new
                        $newOptionValue = $option->optionValues()->create([
                            'name'        => $value['name'],
                            'icon'        => $value['icon'] ?? null,
                            'explanation' => $value['explanation'] ?? null,
                            'sort_order'  => $value['sort_order'] ?? 0,
                            'status'      => 1,
                            'createdBy'   => Auth::id(),
                            'updatedBy'   => Auth::id(),
                        ]);
                        $existingValueIds[] = $newOptionValue->id;
                    }
                }
            }

            // Remove values that were removed in the UI
            $option->optionValues()->whereNotIn('id', $existingValueIds)->delete();

            DB::commit();

            // Reload with relations
            $option->load('optionValues');

            return ApiResponse::success($option, 'Filter option updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Failed to update filter option', 500, [$e->getMessage()]);
        }
    }

    /**
     * Toggle the status (active/inactive).
     */
    public function toggleStatus($id)
    {
        $option = FilterOption::findOrFail($id);
        $option->status = $option->status == 1 ? 0 : 1;
        $option->updatedBy = Auth::id();
        $option->save();

        return ApiResponse::success([
            'status' => $option->status,
        ], $option->status == 1 ? 'Filter option active' : 'Filter option inactive');
    }

    /**
     * Toggle the show_in_filter / show_in_catalog.
     */
    public function toggleShowInFilter($id)
    {
        return $this->toggleShowInCatalog($id);
    }

    /**
     * Toggle the show_in_catalog.
     */
    public function toggleShowInCatalog($id)
    {
        $option = FilterOption::findOrFail($id);
        $newVal = $option->show_in_catalog == 1 ? 0 : 1;
        $option->show_in_catalog = $newVal;
        $option->show_in_filter = $newVal;
        $option->updatedBy = Auth::id();
        $option->save();

        return ApiResponse::success([
            'show_in_catalog' => $option->show_in_catalog,
            'show_in_filter'  => $option->show_in_filter,
        ], $option->show_in_catalog == 1 ? 'Catalog filter enabled' : 'Catalog filter disabled');
    }

    /**
     * Toggle the show_in_guided_finder.
     */
    public function toggleShowInGuidedFinder($id)
    {
        $option = FilterOption::findOrFail($id);
        $option->show_in_guided_finder = $option->show_in_guided_finder == 1 ? 0 : 1;
        $option->updatedBy = Auth::id();
        $option->save();

        return ApiResponse::success([
            'show_in_guided_finder' => $option->show_in_guided_finder,
        ], $option->show_in_guided_finder == 1 ? 'Guided Finder step enabled' : 'Guided Finder step disabled');
    }

    /**
     * Delete an option and its values.
     */
    public function destroy($id)
    {
        $option = FilterOption::findOrFail($id);
        // Cascading delete is set in DB migration, but we can also manually delete or let DB handle it
        $option->delete();

        return ApiResponse::success(null, 'Filter option deleted successfully');
    }
}
