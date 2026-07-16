<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    /**
     * Retrieve a paginated list of coupons with optional search.
     */
    public function index(Request $request)
    {
        $query = Coupon::latest('id');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->input('per_page', 10);
        $coupons = $query->paginate($perPage);

        return ApiResponse::success($coupons, 'Coupons retrieved successfully');
    }

    /**
     * Retrieve all active coupons for dropdown.
     */
    public function allCoupons()
    {
        $coupons = Coupon::select('id', 'name', 'code')->where('status', 1)->get();
        return ApiResponse::success($coupons, 'All active coupons retrieved successfully');
    }

    /**
     * Retrieve a single coupon.
     */
    public function show($id)
    {
        $coupon = Coupon::with(['categories', 'shippingMethods', 'products'])->findOrFail($id);
        return ApiResponse::success($coupon, 'Coupon retrieved successfully');
    }

    /**
     * Store a new coupon.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'code'                => 'required|string|max:255|unique:coupons,code',
            'discount_type'       => 'required|in:1,2',
            'discount_on'         => 'required|in:1,2',
            'discount'            => 'required|numeric',
            'for_subscribed_user' => 'nullable|in:0,1',
            'for_registered_user' => 'nullable|in:0,1',
            'total_useable'       => 'nullable|integer',
            'date_start'          => 'required|date',
            'date_end'            => 'required|date',
            'status'              => 'required|in:0,1',
            'categories'          => 'nullable|array',
            'categories.*'        => 'integer|exists:product_categories,id',
            'shipping_methods'    => 'nullable|array',
            'shipping_methods.*'  => 'integer|exists:shipping_methods,id',
            'products'            => 'nullable|array',
            'products.*'          => 'integer|exists:products,id',
        ]);

        $validated['createdBy'] = Auth::id();
        $validated['updatedBy'] = Auth::id();

        try {
            DB::beginTransaction();

            $coupon = Coupon::create([
                'name'                => $validated['name'],
                'code'                => $validated['code'],
                'discount_type'       => $validated['discount_type'],
                'discount_on'         => $validated['discount_on'],
                'discount'            => $validated['discount'],
                'for_subscribed_user' => $validated['for_subscribed_user'] ?? 0,
                'for_registered_user' => $validated['for_registered_user'] ?? 0,
                'total_useable'       => $validated['total_useable'],
                'total_used'          => 0,
                'date_start'          => $validated['date_start'],
                'date_end'            => $validated['date_end'],
                'status'              => $validated['status'],
                'createdBy'           => Auth::id(),
                'updatedBy'           => Auth::id(),
            ]);

            if (!empty($validated['categories'])) {
                $coupon->categories()->sync($validated['categories']);
            }

            if (!empty($validated['shipping_methods'])) {
                $coupon->shippingMethods()->sync($validated['shipping_methods']);
            }

            if (!empty($validated['products'])) {
                $coupon->products()->sync($validated['products']);
            }

            DB::commit();

            return ApiResponse::success($coupon->load(['categories', 'shippingMethods', 'products']), 'Coupon created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Failed to create coupon', 500, [$e->getMessage()]);
        }
    }

    /**
     * Update an existing coupon.
     */
    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'code'                => 'required|string|max:255|unique:coupons,code,' . $coupon->id,
            'discount_type'       => 'required|in:1,2',
            'discount_on'         => 'required|in:1,2',
            'discount'            => 'required|numeric',
            'for_subscribed_user' => 'nullable|in:0,1',
            'for_registered_user' => 'nullable|in:0,1',
            'total_useable'       => 'nullable|integer',
            'date_start'          => 'required|date',
            'date_end'            => 'required|date',
            'status'              => 'required|in:0,1',
            'categories'          => 'nullable|array',
            'categories.*'        => 'integer|exists:product_categories,id',
            'shipping_methods'    => 'nullable|array',
            'shipping_methods.*'  => 'integer|exists:shipping_methods,id',
            'products'            => 'nullable|array',
            'products.*'          => 'integer|exists:products,id',
        ]);

        try {
            DB::beginTransaction();

            $coupon->update([
                'name'                => $validated['name'],
                'code'                => $validated['code'],
                'discount_type'       => $validated['discount_type'],
                'discount_on'         => $validated['discount_on'],
                'discount'            => $validated['discount'],
                'for_subscribed_user' => $validated['for_subscribed_user'] ?? 0,
                'for_registered_user' => $validated['for_registered_user'] ?? 0,
                'total_useable'       => $validated['total_useable'],
                'date_start'          => $validated['date_start'],
                'date_end'            => $validated['date_end'],
                'status'              => $validated['status'],
                'updatedBy'           => Auth::id(),
            ]);

            $coupon->categories()->sync($validated['categories'] ?? []);
            $coupon->shippingMethods()->sync($validated['shipping_methods'] ?? []);
            $coupon->products()->sync($validated['products'] ?? []);

            DB::commit();

            return ApiResponse::success($coupon->load(['categories', 'shippingMethods', 'products']), 'Coupon updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Failed to update coupon', 500, [$e->getMessage()]);
        }
    }

    /**
     * Toggle the status (active/inactive) of a coupon.
     */
    public function toggleStatus($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->status = $coupon->status == 1 ? 0 : 1;
        $coupon->updatedBy = Auth::id();
        $coupon->save();

        return ApiResponse::success([
            'status' => $coupon->status,
        ], $coupon->status == 1 ? 'Coupon active' : 'Coupon inactive');
    }

    /**
     * Permanently delete a coupon.
     */
    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);

        $coupon->categories()->detach();
        $coupon->shippingMethods()->detach();
        $coupon->products()->detach();

        $coupon->delete();

        return ApiResponse::success(null, 'Coupon deleted successfully');
    }
}
