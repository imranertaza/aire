<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

/**
 * Class PostController
 *
 * Handles CRUD operations for posts, including listing, searching,
 * creating, updating, toggling status, and deleting posts.
 * Also manages image uploads and category associations.
 */
class PostController extends Controller
{
    /**
     * Display a listing of posts with optional search and pagination.
     *
     * Applies search filters if provided in the request. Defaults to
     * paginated results, with per_page configurable via request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Post::latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('post_title', 'like', "%{$search}%")
                    ->orWhere('short_des', 'like', "%{$search}%")
                    ->orWhere('meta_title', 'like', "%{$search}%")
                    ->orWhere('meta_description', 'like', "%{$search}%")
                    ->orWhere('meta_keyword', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('per_page', 10);
        $posts   = $query->paginate($perPage);

        return ApiResponse::success($posts, 'Posts retrieved successfully');
    }

    /**
     * Display a single post by slug.
     *
     * Retrieves a post record using its unique slug, including related categories.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function show($id)
    {
        $post = Post::with('categories.parent')->findOrFail($id);
        return ApiResponse::success($post, 'Post retrieved successfully');
    }

    /**
     * Store a newly created post in storage.
     *
     * Validates request data, handles image uploads, creates a new post record,
     * and syncs category associations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'post_title'       => 'required|string|max:155',
                'slug'             => 'required|string|unique:posts,slug',
                'short_des'        => 'required|string|max:155',
                'description'      => 'required|string',
                'meta_title'       => 'nullable|string',
                'meta_keyword'     => 'nullable|string',
                'meta_description' => 'nullable|string',
                'image'            => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
                'f_image'          => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
                'alt_name'         => 'nullable|string|max:255',
                'publish_date'     => 'nullable|date',
                'status'           => ['required', Rule::in(['0', '1'])],
                'categories'       => 'required|array',
                'categories.*'     => 'exists:categories,id',
            ],
            [
                'f_image.required' => 'The Featured image is required.',
                'f_image.image' => 'Please upload a valid image file.',
                'f_image.mimes' => 'We only support JPG, JPEG, PNG, WEBP, and GIF formats.',
                'f_image.max'   => 'That file is too big! Keep it under 2MB.',
                'image.required' => 'The Banner image is required.',
                'image.file' => 'Please upload a valid file.',
                'image.mimes' => 'Supported formats: JPG, JPEG, PNG, WEBP, GIF.',
                'image.max' => 'That file is too large! Keep it under 500MB.',
            ]
        );

        $validated['createdBy']    = Auth::user()->id;
        $validated['updatedBy']    = Auth::user()->id;
        $validated['publish_date'] = $request->input('publish_date', now());

        // First create the post (without images)
        $post = Post::create($validated);

        // Handle image upload after we have the post ID
        if ($request->hasFile('image')) {
            $filename = uniqid('image_') . '.' . $request->file('image')->getClientOriginalExtension();
            $path = $request->file('image')
                ->storeAs("posts/{$post->id}/images/image", $filename, 'public');
            $post->update(['image' => $path]);
        }

        if ($request->hasFile('f_image')) {
            $filename = uniqid('f_image_') . '.' . $request->file('f_image')->getClientOriginalExtension();
            $path = $request->file('f_image')
                ->storeAs("posts/{$post->id}/images/f-image", $filename, 'public');
            $post->update(['f_image' => $path]);
        }

        // Sync categories
        if (isset($validated['categories'])) {
            $post->categories()->sync($validated['categories']);
        }

        return response()->json(['message' => 'Post created successfully', 'data' => $post], 201);
    }

    /**
     * Update the specified post in storage.
     *
     * Validates request data, updates the post record, replaces images if provided,
     * and syncs category associations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate(
            [
                'post_title'       => 'required|string|max:155',
                'slug'             => ['required', 'string', Rule::unique('posts', 'slug')->ignore($post->id)],
                'short_des'        => 'required|string|max:155',
                'description'      => 'required|string',
                'meta_title'       => 'nullable|string',
                'meta_keyword'     => 'nullable|string',
                'meta_description' => 'nullable|string',
                'image'            => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
                'f_image'          => 'sometimes|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
                'alt_name'         => 'nullable|string|max:255',
                'status'           => ['required', Rule::in(['0', '1'])],
                'categories'       => 'required|array',
                'categories.*'     => 'exists:categories,id',
            ],
            [
                'f_image.required' => 'The Featured image is required.',
                'f_image.image' => 'Please upload a valid image file.',
                'f_image.mimes' => 'We only support JPG, JPEG, PNG, and GIF formats.',
                'f_image.max'   => 'That file is too big! Keep it under 2MB.',
                'image.required' => 'The Banner image is required.',
                'image.file' => 'Please upload a valid file.',
                'image.mimes' => 'Supported formats: JPG, JPEG, PNG, GIF.',
                'image.max' => 'That file is too large! Keep it under 500MB.',
            ]
        );

        if ($request->remove_f_image) {
            $request->validate([
                'f_image'          => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            ], [
                'f_image.required' => 'The Featured image is required.',
                'f_image.image' => 'Please upload a valid image file.',
                'f_image.mimes' => 'We only support JPG, JPEG, PNG, and GIF formats.',
                'f_image.max'   => 'That file is too big! Keep it under 2MB.',
            ]);
        }
        if ($request->remove_image == 1) {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            $validated['image']   = null;
        }

        $validated['createdBy'] = Auth::user()->id;
        $validated['updatedBy'] = Auth::user()->id;

        // Handle main image
        if ($request->hasFile('image')) {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }

            $filename = uniqid('image_') . '.' . $request->file('image')->getClientOriginalExtension();
            $validated['image'] = $request->file('image')
                ->storeAs("posts/{$post->id}/images/image", $filename, 'public');
        }

        // Handle featured image
        if ($request->hasFile('f_image')) {
            if ($post->f_image && Storage::disk('public')->exists($post->f_image)) {
                Storage::disk('public')->delete($post->f_image);
            }

            $filename = uniqid('f_image_') . '.' . $request->file('f_image')->getClientOriginalExtension();
            $validated['f_image'] = $request->file('f_image')
                ->storeAs("posts/{$post->id}/images/f-image", $filename, 'public');
        }

        $post->update($validated);

        if (isset($validated['categories'])) {
            $post->categories()->sync($validated['categories']);
        }

        return response()->json(['message' => 'Post updated successfully', 'data' => $post], 200);
    }


    /**
     * Toggle the active/inactive status of a post.
     *
     * Finds a post by slug and switches its status between '0' (inactive) and '1' (active).
     *
     * @param  string  $slug
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function toggleStatus($id)
    {
        $post = Post::findOrFail($id);
        $post->status = $post->status === '1' ? '0' : '1';
        $post->save();

        return response()->json([
            'message' => $post->status === '1' ? 'Post active' : 'Post inactive',
            'status'  => $post->status,
        ]);
    }

    /**
     * Remove the specified post from storage.
     *
     * Deletes the post record and its associated images if present.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }
        if ($post->f_image && Storage::disk('public')->exists($post->f_image)) {
            Storage::disk('public')->delete($post->f_image);
        }

        $post->delete();

        return ApiResponse::success($post, 'Post deleted successfully');
    }
}
