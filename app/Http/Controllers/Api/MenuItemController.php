<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * API Controller for managing menu items (hierarchical navigation links).
 *
 * Supports nested menu structure with parent-child relationships,
 * custom link types (page, category, external URL), ordering, and bulk reordering.
 */
class MenuItemController extends Controller
{
    /**
     * Retrieve hierarchical menu items (top-level only) optionally filtered by menu_id.
     *
     * Returns nested structure ready for frontend tree components.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = MenuItem::with('children');

        if ($request->has('menu_id')) {
            $query->where('menu_id', $request->input('menu_id'));
        }

        $query->whereNull('parent_id');

        $items = $query->orderBy('order')->get();

        $transform = function ($item) use (&$transform) {
            return [
                'id'            => $item->id,
                'name'          => $item->name,
                'icon'          => $item->icon,
                'link'          => $item->url,
                'link_type'     => $item->link_type,
                'category_id'   => $item->category_id,
                'page_id'       => $item->page_id,
                'order'         => $item->order,
                'enabled'       => (bool) $item->enabled,
                '_newChildName' => '', // Helper for frontend (e.g., adding new child inline)
                'elements'      => $item->children->map($transform)->toArray(),
            ];
        };

        $data = $items->map($transform)->toArray();

        return ApiResponse::success($data, 'Menu items fetched successfully');
    }

    /**
     * Store a new menu item.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'menu_id'       => 'required|exists:menus,id',
            'name'          => 'required|string|max:255',
            'icon'          => 'nullable|string|max:255',
            'link_type'     => 'required|in:page,category,url',
            'page_id'       => 'nullable|required_if:link_type,page|exists:pages,id',
            'category_id'   => 'nullable|required_if:link_type,category|exists:categories,id',
            'url'           => 'nullable|required_if:link_type,url|string|max:500',
            'enabled'       => 'boolean',
            'parent_id'     => 'nullable|exists:menu_items,id',
            'order'         => 'nullable|integer|min:0',
        ], [
            'category_id.required' => 'Please select an event category.',
            'category_id.exists' => 'The selected event category does not exist.'
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation failed', 422, $validator->errors());
        }

        $validated = $validator->validated();
        $validated['enabled'] = $validated['enabled'] ? 1 : 0;

        $item = MenuItem::create($validated);

        return ApiResponse::success($item, 'Menu item created successfully', 201);
    }

    /**
     * Display a single menu item with its children.
     *
     * @param MenuItem $menuItem
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(MenuItem $menuItem)
    {
        $menuItem->load('children');

        return ApiResponse::success($menuItem, 'Menu item fetched successfully');
    }

    /**
     * Update an existing menu item.
     *
     * @param Request $request
     * @param MenuItem $menuItem
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, MenuItem $menuItem)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'sometimes|required|string|max:255',
            'icon'          => 'nullable|string|max:255',
            'link_type'     => 'sometimes|required|in:page,category,url',
            'page_id'       => 'nullable|required_if:link_type,page|exists:pages,id',
            'category_id'   => 'nullable|required_if:link_type,category|exists:categories,id',
            'url'           => 'nullable|required_if:link_type,string|string|max:500',
            'enabled'       => 'boolean',
            'parent_id'     => 'nullable|exists:menu_items,id',
            'order'         => 'nullable|integer|min:0',
        ], [
            'category_id.required' => 'Please select an event category.',
            'category_id.exists' => 'The selected event category does not exist.'
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation failed', 422, $validator->errors());
        }

        $menuItem->update($validator->validated());

        return ApiResponse::success($menuItem, 'Menu item updated successfully');
    }

    /**
     * Reorder menu items (supports nested structure).
     *
     * Accepts an array of items with id, order, and optional parent_id.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'menu_id'          => 'required|exists:menus,id',
            'items'            => 'required|array|min:1',
            'items.*.id'       => 'required|exists:menu_items,id',
            'items.*.order'    => 'required|integer|min:0',
            'items.*.parent_id' => 'nullable|exists:menu_items,id',
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['items'] as $itemData) {
                MenuItem::where('id', $itemData['id'])
                    ->where('menu_id', $validated['menu_id'])
                    ->update([
                        'order'     => $itemData['order'],
                        'parent_id' => $itemData['parent_id'] ?? null,
                    ]);
            }
        });

        return ApiResponse::success(null, 'Menu items reordered successfully');
    }

    /**
     * Delete a menu item (and optionally its children).
     *
     * @param MenuItem $menuItem
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(MenuItem $menuItem)
    {
        $menuItem->children()->delete();

        $menuItem->delete();

        return ApiResponse::success(null, 'Menu item deleted successfully');
    }
}
