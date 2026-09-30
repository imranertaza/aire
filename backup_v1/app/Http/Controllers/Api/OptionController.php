<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\OptionValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class OptionController extends Controller
{
    /**
     * Retrieve a paginated list of options with their values.
     */
    public function index(Request $request)
    {
        $query = Option::with('optionValues')->orderBy('sort_order', 'asc')->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        $perPage = (int) $request->input('per_page', 10);
        $options = $query->paginate($perPage);

        return ApiResponse::success($options, 'Options retrieved successfully');
    }

    /**
     * Retrieve a single option.
     */
    public function show($id)
    {
        $option = Option::with('optionValues')->findOrFail($id);
        return ApiResponse::success($option, 'Option retrieved successfully');
    }

    /**
     * Retrieve all options for dropdowns.
     */
    public function allOptions()
    {
        $options = Cache::rememberForever('all_options', function () {
            return Option::with('optionValues')->where('status', 1)->orderBy('sort_order', 'asc')->get();
        });
        return ApiResponse::success($options, 'All options retrieved successfully');
    }


    /**
     * Store a new option and its values.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                     => 'required|string|max:155',
            'type'                     => 'required|string|max:32',
            'sort_order'               => 'nullable|integer|min:0',
            'status'                   => 'required|in:0,1,true,false',
            'option_values'            => 'nullable|array',
            'option_values.*.name'       => 'required_with:option_values|string|max:155',
            'option_values.*.sort_order' => 'nullable|integer|min:0',
        ]);

        try {
            DB::beginTransaction();

            $optionData = [
                'name'       => $validated['name'],
                'type'       => $validated['type'],
                'sort_order' => $validated['sort_order'] ?? 0,
                'status'     => filter_var($validated['status'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'createdBy'  => Auth::id(),
                'updatedBy'  => Auth::id(),
            ];

            $option = Option::create($optionData);

            if (!empty($validated['option_values'])) {
                foreach ($validated['option_values'] as $value) {
                    $option->optionValues()->create([
                        'name'       => $value['name'],
                        'sort_order' => $value['sort_order'] ?? 0,
                        'status'     => 1, // Default active
                        'createdBy'  => Auth::id(),
                        'updatedBy'  => Auth::id(),
                    ]);
                }
            }

            DB::commit();

            // Reload with relations to return
            $option->load('optionValues');

            return ApiResponse::success($option, 'Option created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Failed to create option', 500, [$e->getMessage()]);
        }
    }

    /**
     * Update an existing option.
     */
    public function update(Request $request, $id)
    {
        $option = Option::findOrFail($id);

        $validated = $request->validate([
            'name'                     => 'required|string|max:155',
            'type'                     => 'required|string|max:32',
            'sort_order'               => 'nullable|integer|min:0',
            'status'                   => 'required|in:0,1,true,false',
            'option_values'            => 'nullable|array',
            'option_values.*.id'         => 'nullable|integer',
            'option_values.*.name'       => 'required_with:option_values|string|max:155',
            'option_values.*.sort_order' => 'nullable|integer|min:0',
        ]);

        try {
            DB::beginTransaction();

            $optionData = [
                'name'       => $validated['name'],
                'type'       => $validated['type'],
                'sort_order' => $validated['sort_order'] ?? 0,
                'status'     => filter_var($validated['status'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
                'updatedBy'  => Auth::id(),
            ];

            $option->update($optionData);

            $existingValueIds = [];
            if (!empty($validated['option_values'])) {
                foreach ($validated['option_values'] as $value) {
                    if (isset($value['id']) && $value['id']) {
                        // Update existing
                        $optionValue = OptionValue::find($value['id']);
                        if ($optionValue && $optionValue->option_id == $option->id) {
                            $optionValue->update([
                                'name'       => $value['name'],
                                'sort_order' => $value['sort_order'] ?? 0,
                                'updatedBy'  => Auth::id(),
                            ]);
                            $existingValueIds[] = $optionValue->id;
                        }
                    } else {
                        // Create new
                        $newOptionValue = $option->optionValues()->create([
                            'name'       => $value['name'],
                            'sort_order' => $value['sort_order'] ?? 0,
                            'status'     => 1,
                            'createdBy'  => Auth::id(),
                            'updatedBy'  => Auth::id(),
                        ]);
                        $existingValueIds[] = $newOptionValue->id;
                    }
                }
            }

            // Delete values not present in the update payload
            $option->optionValues()->whereNotIn('id', $existingValueIds)->delete();

            DB::commit();

            $option->load('optionValues');

            return ApiResponse::success($option, 'Option updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Failed to update option', 500, [$e->getMessage()]);
        }
    }

    /**
     * Toggle the status (active/inactive).
     */
    public function toggleStatus($id)
    {
        $option = Option::findOrFail($id);
        $option->status = $option->status == 1 ? 0 : 1;
        $option->updatedBy = Auth::id();
        $option->save();

        return ApiResponse::success([
            'status' => $option->status,
        ], $option->status == 1 ? 'Option active' : 'Option inactive');
    }

    /**
     * Delete an option and its values.
     */
    public function destroy($id)
    {
        $option = Option::findOrFail($id);
        // Cascading delete is set in DB migration, but we can also manually delete or let DB handle it
        $option->delete();

        return ApiResponse::success(null, 'Option deleted successfully');
    }
}
