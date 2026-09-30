<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use App\Models\EmailCampaign;
use Illuminate\Http\Request;

class EmailCampaignController extends Controller
{
    /**
     * Get a list of all email campaigns for tracking.
     */
    public function index(Request $request)
    {
        $campaigns = EmailCampaign::orderBy('id', 'desc')->paginate(10);
        return ApiResponse::success($campaigns, 'Email campaigns fetched successfully.');
    }
}
