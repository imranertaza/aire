<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use App\Models\FundRequest;
use Illuminate\Http\Request;

class FundRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        $query = FundRequest::with(['customer', 'paymentMethod'])->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('amount', 'like', "%{$search}%")
                  ->orWhere('card_name', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $fundRequests = $query->paginate($perPage);
        return ApiResponse::success($fundRequests, 'Fund requests retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id'       => 'required|exists:customers,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'amount'            => 'required|numeric|min:0.01',
            'card_name'         => 'nullable|string|max:255',
            'card_number'       => 'nullable|string|max:255',
            'card_expiration'   => 'nullable|string|max:255',
            'card_cvc'          => 'nullable|string|max:255',
            'status'            => 'nullable|in:Pending,Complete,Canceled',
        ]);

        $fundRequest = FundRequest::create($validated);
        return ApiResponse::success($fundRequest, 'Fund request created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $fundRequest = FundRequest::with(['customer', 'paymentMethod'])->findOrFail($id);
        return ApiResponse::success($fundRequest, 'Fund request retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $fundRequest = FundRequest::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:Pending,Complete,Canceled',
        ]);

        $fundRequest->update($validated);
        return ApiResponse::success($fundRequest, 'Fund request updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fundRequest = FundRequest::findOrFail($id);
        $fundRequest->delete();

        return ApiResponse::success(null, 'Fund request deleted successfully');
    }
}
