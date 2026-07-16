<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;

class ShippingMethodController extends Controller
{
    /**
     * Retrieve all active shipping methods for dropdown/checkboxes.
     */
    public function allMethods()
    {
        $methods = ShippingMethod::select('id', 'name')->get();
        return ApiResponse::success($methods, 'All shipping methods retrieved successfully');
    }
}
