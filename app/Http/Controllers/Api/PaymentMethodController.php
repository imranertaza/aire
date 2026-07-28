<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PaymentMethodController extends Controller
{
    /**
     * Retrieve a paginated list of payment methods.
     */
    public function index(Request $request)
    {
        $query = PaymentMethod::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%");
        }

        $perPage = (int) $request->input('per_page', 10);
        $methods = $query->paginate($perPage);

        return ApiResponse::success($methods, 'Payment methods retrieved successfully');
    }

    /**
     * Retrieve all active payment methods.
     */
    public function allMethods()
    {
        $methods = Cache::rememberForever('all_payment_methods', function () {
            return PaymentMethod::active()->select('id', 'name', 'code', 'image')->get();
        });
        return ApiResponse::success($methods, 'Active payment methods retrieved successfully');
    }

    /**
     * Toggle the status of a payment method.
     */
    public function updateStatus(Request $request, $id)
    {
        $method = PaymentMethod::findOrFail($id);
        $method->status = $method->status == 1 ? 0 : 1;
        $method->save();

        return ApiResponse::success($method, 'Status updated successfully');
    }

    /**
     * Retrieve settings for a specific payment method.
     */
    public function settings($id)
    {
        $method = PaymentMethod::findOrFail($id);
        return ApiResponse::success($method, 'Settings retrieved successfully');
    }

    /**
     * Update the settings, status, and image for a specific payment method.
     */
    public function updateSettings(Request $request, $id)
    {
        $method = PaymentMethod::findOrFail($id);

        if ($request->has('status')) {
            $method->status = $request->input('status');
        }

        if ($request->has('settings')) {
            // Because FormData sends strings, we need to decode if it's sent as JSON string
            $settingsData = $request->input('settings');
            if (is_string($settingsData)) {
                $settingsData = json_decode($settingsData, true);
            }
            $method->settings = $settingsData;
        }

        if ($request->remove_image == 1 && !$request->hasFile('image')) {
            if ($method->image && file_exists(public_path('images/payment/' . $method->image))) {
                @unlink(public_path('images/payment/' . $method->image));
            }
            $method->image = null;
        }

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
            ]);

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Delete old image if exists
            if ($method->image && file_exists(public_path('images/payment/' . $method->image))) {
                @unlink(public_path('images/payment/' . $method->image));
            }

            // Move new image
            $file->move(public_path('images/payment'), $filename);
            $method->image = $filename;
        }

        $method->save();

        return ApiResponse::success($method, 'Settings updated successfully');
    }
}
