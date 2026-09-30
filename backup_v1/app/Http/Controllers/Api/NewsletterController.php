<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        $query = Newsletter::with('customer')->latest();

        if ($search) {
            $query->where('email', 'like', "%{$search}%");
        }

        $newsletters = $query->paginate($perPage);
        return ApiResponse::success($newsletters, 'Newsletters retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:newsletters,email',
            'status' => 'nullable|in:0,1',
            'customer_id' => 'nullable|exists:customers,id'
        ]);

        $newsletter = Newsletter::create($validated);

        return ApiResponse::success($newsletter, 'Newsletter subscribed successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $newsletter = Newsletter::findOrFail($id);

        return ApiResponse::success($newsletter, 'Newsletter retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $newsletter = Newsletter::findOrFail($id);
        
        $validated = $request->validate([
            'email' => 'sometimes|email|unique:newsletters,email,'.$id,
            'status' => 'nullable|in:0,1',
            'customer_id' => 'nullable|exists:customers,id'
        ]);

        $newsletter->update($validated);

        return ApiResponse::success($newsletter, 'Newsletter updated successfully');
    }

    /**
     * Toggle the status of the specified resource.
     */
    public function toggleStatus(string $id)
    {
        $newsletter = Newsletter::findOrFail($id);
        $newsletter->status = $newsletter->status == 1 ? 0 : 1;
        $newsletter->save();

        return ApiResponse::success($newsletter, 'Newsletter status toggled successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $newsletter = Newsletter::findOrFail($id);
        $newsletter->delete();

        return ApiResponse::success(null, 'Newsletter deleted successfully');
    }
}
