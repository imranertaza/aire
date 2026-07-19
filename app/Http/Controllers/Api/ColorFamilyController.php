<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use App\Models\ColorFamily;
use Illuminate\Http\Request;

class ColorFamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        $query = ColorFamily::latest();

        if ($search) {
            $query->where('color_name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
        }

        $colorFamilies = $query->paginate($perPage);
        return ApiResponse::success($colorFamilies, 'Color families retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'color_name' => 'required|string|max:255',
            'code'       => 'required|string|max:255',
        ]);

        $colorFamily = ColorFamily::create($validated);
        return ApiResponse::success($colorFamily, 'Color family created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $colorFamily = ColorFamily::findOrFail($id);
        return ApiResponse::success($colorFamily, 'Color family retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $colorFamily = ColorFamily::findOrFail($id);
        
        $validated = $request->validate([
            'color_name' => 'required|string|max:255',
            'code'       => 'required|string|max:255',
        ]);

        $colorFamily->update($validated);
        return ApiResponse::success($colorFamily, 'Color family updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $colorFamily = ColorFamily::findOrFail($id);
        $colorFamily->delete();

        return ApiResponse::success(null, 'Color family deleted successfully');
    }
}
