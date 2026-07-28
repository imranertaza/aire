<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\ProductAttributeGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ProductAttributeGroupController extends Controller
{
    /**
     * Retrieve a paginated list of attribute groups.
     */
    public function index(Request $request)
    {
        $query = ProductAttributeGroup::orderBy('sort_order', 'asc')->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        $perPage = (int) $request->input('per_page', 10);
        $groups = $query->paginate($perPage);

        return ApiResponse::success($groups, 'Attribute groups retrieved successfully');
    }

    /**
     * Retrieve all attribute groups for dropdown.
     */
    public function allAttributeGroups()
    {
        $groups = Cache::rememberForever('all_attribute_groups', function () {
            return ProductAttributeGroup::select('id', 'name')->orderBy('sort_order', 'asc')->get();
        });
        return ApiResponse::success($groups, 'All attribute groups retrieved successfully');
    }

    /**
     * Retrieve a single attribute group.
     */
    public function show($id)
    {
        $group = ProductAttributeGroup::findOrFail($id);
        return ApiResponse::success($group, 'Attribute group retrieved successfully');
    }


    /**
     * Display a specific attribute group.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:155',
            'sort_order' => 'nullable|integer|min:0',
            'status'     => 'required|in:0,1,true,false',
        ]);

        $validated['createdBy'] = Auth::id();
        $validated['updatedBy'] = Auth::id();

        // Convert boolean status to tinyInt
        $validated['status'] = filter_var($validated['status'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;

        if (!isset($validated['sort_order'])) {
            $validated['sort_order'] = 0;
        }

        $group = ProductAttributeGroup::create($validated);

        return ApiResponse::success($group, 'Attribute group created successfully');
    }

    /**
     * Update an existing attribute group.
     */
    public function update(Request $request, $id)
    {
        $group = ProductAttributeGroup::findOrFail($id);

        $validated = $request->validate([
            'name'       => 'required|string|max:155',
            'sort_order' => 'nullable|integer|min:0',
            'status'     => 'required|in:0,1,true,false',
        ]);

        $validated['updatedBy'] = Auth::id();

        // Convert boolean status
        $validated['status'] = filter_var($validated['status'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;

        if (!isset($validated['sort_order'])) {
            $validated['sort_order'] = 0;
        }

        $group->update($validated);

        return ApiResponse::success($group, 'Attribute group updated successfully');
    }

    /**
     * Toggle the status (active/inactive).
     */
    public function toggleStatus($id)
    {
        $group = ProductAttributeGroup::findOrFail($id);
        $group->status = $group->status == 1 ? 0 : 1;
        $group->updatedBy = Auth::id();
        $group->save();

        return ApiResponse::success([
            'status' => $group->status,
        ], $group->status == 1 ? 'Attribute group active' : 'Attribute group inactive');
    }

    /**
     * Delete an attribute group.
     */
    public function destroy($id)
    {
        $group = ProductAttributeGroup::findOrFail($id);
        $group->delete();

        return ApiResponse::success(null, 'Attribute group deleted successfully');
    }
}
