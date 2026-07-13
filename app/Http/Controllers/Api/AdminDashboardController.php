<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\CommitteeMember;
use App\Models\Event;
use App\Models\News;
use App\Models\Notice;
use App\Models\Player;
use App\Models\Post;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalPosts' => Post::count(),
            'totalNews' => News::count(),
            'totalNotices' => Notice::where('type', 0)->count(),
            'totalFixtures' => Notice::where('type', 1)->count(),
            'totalPlayers' => Player::count(),
            'totalMembers' => CommitteeMember::count(),
            'totalRunningEvents' => Event::where('type', 0)->count(),
            'totalUpcomingEvents' => Event::where('type', 1)->count(),
        ];

        return ApiResponse::success($stats, 'Dashboard statistics retrieved successfully');
    }
}
