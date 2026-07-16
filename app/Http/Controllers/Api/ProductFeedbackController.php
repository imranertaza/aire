<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\ProductFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductFeedbackController extends Controller
{
    /**
     * Retrieve a paginated list of reviews/feedbacks with optional search.
     */
    public function index(Request $request)
    {
        $query = ProductFeedback::with(['product', 'customer'])->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('feedback_text', 'like', "%{$search}%")
                    ->orWhereHas('product', function ($pq) use ($search) {
                        $pq->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('customer', function ($cq) use ($search) {
                        $cq->where('firstname', 'like', "%{$search}%")
                            ->orWhere('lastname', 'like', "%{$search}%")
                            ->orWhereRaw("CONCAT(firstname, ' ', lastname) like ?", ["%{$search}%"]);
                    });
            });
        }

        $perPage = (int) $request->input('per_page', 10);
        $reviews = $query->paginate($perPage);

        return ApiResponse::success($reviews, 'Reviews retrieved successfully');
    }

    /**
     * Toggle the status (Active/Pending) of a review.
     */
    public function toggleStatus($id)
    {
        $review = ProductFeedback::findOrFail($id);
        $review->status = $review->status == 1 ? 0 : 1;
        $review->updated_by = Auth::id();
        $review->save();

        $statusStr = $review->status == 1 ? 'Active' : 'Inactive';
        return ApiResponse::success([
            'status' => $review->status,
        ], "Review status changed to {$statusStr}");
    }

    /**
     * Permanently delete a review.
     */
    public function destroy($id)
    {
        $review = ProductFeedback::findOrFail($id);
        $review->delete();

        return ApiResponse::success(null, 'Review deleted successfully');
    }
}
