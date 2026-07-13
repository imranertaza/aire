<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\CommitteeMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * API Controller for managing committee members.
 *
 * Handles CRUD operations, status toggling, image management, and ordering of committee members.
 */
class CommitteeMemberController extends Controller
{
    /**
     * Retrieve a paginated list of committee members with optional search.
     *
     * Members are ordered by the 'order' field.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = CommitteeMember::orderBy('order');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('designation', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('per_page', 10);
        $members = $query->paginate($perPage);

        return ApiResponse::success($members, 'Committee members retrieved successfully');
    }

    /**
     * Retrieve a single committee member by ID.
     *
     * @param int $id The ID of the committee member
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */
    public function show($id)
    {
        $member = CommitteeMember::findOrFail($id);
        return ApiResponse::success($member, 'Committee member retrieved successfully');
    }

    /**
     * Store a new committee member.
     *
     * Handles optional image upload and assigns the authenticated user as creator.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:committee_members,slug',
            'designation' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'order'       => 'required|integer|min:0',
            'status'      => 'required|in:0,1',
        ]);

        $validated['createdBy'] = Auth::id();
        $validated['updatedBy'] = Auth::id();

        $member = CommitteeMember::create($validated);

        if ($request->hasFile('image')) {
            $filename = uniqid('committee_member_image_') . '.' . $request->file('image')->getClientOriginalExtension();

            $path = $request->file('image')
                ->storeAs("committee_members/{$member->id}/images", $filename, 'public');

            $member->update(['image' => $path]);
        }

        return ApiResponse::success($member, 'Committee member created successfully');
    }

    /**
     * Update an existing committee member.
     *
     * Replaces the image only if a new one is uploaded (deletes the old image).
     *
     * @param Request $request
     * @param int $id The ID of the committee member to update
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $member = CommitteeMember::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'order'       => 'required|integer|min:0',
            'status'      => 'required|in:0,1',
        ]);
        if ($request->remove_image == 1) {
            $request->validate([
                'image'       => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            ]);
        };

        if ($request->hasFile('image')) {
            if ($member->image && Storage::disk('public')->exists($member->image)) {
                Storage::disk('public')->delete($member->image);
            }

            $filename = uniqid('committee_member_image_') . '.' . $request->file('image')->getClientOriginalExtension();

            $validated['image'] = $request->file('image')
                ->storeAs("committee_members/{$member->id}/images", $filename, 'public');
        }

        $validated['updatedBy'] = Auth::id();

        $member->update($validated);

        return ApiResponse::success($member, 'Committee member updated successfully');
    }


    /**
     * Toggle the publication status (active/inactive) of a committee member.
     *
     * @param int $id The ID of the committee member
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */
    public function toggleStatus($id)
    {
        $member = CommitteeMember::findOrFail($id);
        $member->status = $member->status == 1 ? 0 : 1;
        $member->updatedBy = Auth::id();
        $member->save();

        return ApiResponse::success([
            'status' => $member->status,
        ], $member->status == 1 ? 'Member active' : 'Member inactive');
    }

    /**
     * Permanently delete a committee member along with its associated image (if any).
     *
     * @param int $id The ID of the committee member to delete
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */
    public function destroy($id)
    {
        $member = CommitteeMember::findOrFail($id);

        if ($member->image && Storage::disk('public')->exists($member->image)) {
            Storage::disk('public')->delete($member->image);
        }

        $member->delete();

        return ApiResponse::success(null, 'Committee member deleted successfully');
    }
}
