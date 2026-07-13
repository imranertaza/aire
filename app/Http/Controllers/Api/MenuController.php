<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

/**
 * API Controller for managing website menus.
 *
 * Handles CRUD operations for menus (e.g., Main Menu, Footer Menu).
 * Menus can be linked to menu items for hierarchical navigation.
 */
class MenuController extends Controller
{
    /**
     * Display a paginated listing of menus.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $menus = Menu::latest()->paginate(10);

        return ApiResponse::success($menus, 'Menus fetched successfully');
    }

    /**
     * Store a newly created menu.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:150|unique:menus,name',
            'position' => 'nullable|string|max:150',
            'enabled'  => 'boolean',
        ]);

        // Default enabled to true if not provided
        $data['enabled'] = $data['enabled'] ?? true;

        $menu = Menu::create($data);

        return ApiResponse::success($menu, 'Menu created successfully');
    }

    /**
     * Display the specified menu.
     *
     * @param Menu $menu The menu instance (resolved via route model binding)
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Menu $menu)
    {
        return ApiResponse::success($menu, 'Menu fetched successfully');
    }

    /**
     * Update the specified menu.
     *
     * @param Request $request
     * @param Menu $menu The menu instance (resolved via route model binding)
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:150|unique:menus,name,' . $menu->id,
            'position' => 'nullable|string|max:150',
            'enabled'  => 'boolean',
        ]);

        $menu->update($data);

        return ApiResponse::success($menu, 'Menu updated successfully');
    }

    /**
     * Remove the specified menu.
     *
     * @param Menu $menu The menu instance (resolved via route model binding)
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return ApiResponse::success(null, 'Menu deleted successfully');
    }
}
