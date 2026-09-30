<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Admin\AdminDashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * AdminDashboardController constructor.
     *
     * @param AdminDashboardService $dashboardService
     */
    public function __construct(
        protected AdminDashboardService $dashboardService
    ) {}

    /**
     * Get real-time or cached e-commerce metrics and stats for the admin dashboard.
     *
     * Supports ?refresh=1 parameter to force clear cache and recalculate.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $forceRefresh = $request->boolean('refresh', false);

        $metrics = $this->dashboardService->getDashboardMetrics($forceRefresh);

        return ApiResponse::success($metrics, 'Dashboard statistics retrieved successfully');
    }
}
