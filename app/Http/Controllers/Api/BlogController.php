<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * API Controller for managing blog posts.
 *
 * Handles CRUD operations, status toggling, category assignment, and file management
 * for blog posts (supports main image and featured image).
 */
class BlogController extends Controller
{
    /**
     * Retrieve a paginated list of blogs with optional search.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Blog::latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('short_des', 'like', "%{$search}%")
                    ->orWhere('meta_title', 'like', "%{$search}%")
                    ->orWhere('meta_description', 'like', "%{$search}%")
                    ->orWhere('meta_keyword', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('per_page', 10);
        $blogs   = $query->paginate($perPage);

        return ApiResponse::success($blogs, 'Blogs retrieved successfully');
    }

    /**
     * Retrieve a single blog post by its slug along with related categories and parent categories.
     *
     * @param string $slug The unique slug of the blog post
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */
    public function show($id)
    {
        $blog = Blog::with('categories.parent')->findOrFail($id);
        return ApiResponse::success($blog, 'Blog retrieved successfully');
    }

    /**
     * Store a new blog post.
     *
     * Validates input, handles main and featured image uploads,
     * assigns creator/updater, sets publish date, and syncs categories.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'title'            => 'required|string|max:255',
                'slug'             => 'required|string|unique:blogs,slug',
                'short_des'        => 'required|string|max:255',
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
                'categories.*'     => 'exists:blog_categories,id',
            ],
            [
                'f_image.required' => 'The Featured image or video is required.',
                'f_image.image' => 'Please upload a valid image file.',
                'f_image.mimes' => 'We only support JPG, JPEG, PNG, WEBP, and GIF formats.',
                'f_image.max'   => 'That file is too big! Keep it under 2MB.',
                'image.required' => 'The Banner image or video is required.',
                'image.file' => 'Please upload a valid file.',
                'image.mimes' => 'Supported formats: JPG, JPEG, PNG, WEBP, GIF.',
                'image.max' => 'That file is too large! Keep it under 500MB.',
            ]
        );

        $validated['createdBy']    = Auth::id();
        $validated['updatedBy']    = Auth::id();
        $validated['publish_date'] = now();
        // Create blog first (without images)
        $blog = Blog::create($validated);

        // Handle main image
        if ($request->hasFile('image')) {
            $filename = uniqid('blog_image_') . '.' . $request->file('image')->getClientOriginalExtension();
            $path = $request->file('image')
                ->storeAs("blogs/{$blog->id}/images/image", $filename, 'public');
            $blog->update(['image' => $path]);
        }

        // Handle featured image
        if ($request->hasFile('f_image')) {
            $filename = uniqid('blog_f_image_') . '.' . $request->file('f_image')->getClientOriginalExtension();
            $path = $request->file('f_image')
                ->storeAs("blogs/{$blog->id}/images/f-image", $filename, 'public');
            $blog->update(['f_image' => $path]);
        }

        if (isset($validated['categories'])) {
            $blog->categories()->sync($validated['categories']);
        }

        return ApiResponse::success($blog, 'Blog created successfully');
    }


    /**
     * Update an existing blog post.
     *
     * Replaces images only if new files are uploaded (deletes old files),
     * updates updater ID, and syncs categories.
     *
     * @param Request $request
     * @param int $id The ID of the blog post to update
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $validated = $request->validate(
            [
                'title'            => 'required|string|max:255',
                'slug'             => [
                    'required',
                    'string',
                    Rule::unique('blogs', 'slug')->ignore($blog->id),
                ],
                'short_des'        => 'required|string|max:255',
                'description'      => 'required|string',
                'meta_title'       => 'nullable|string',
                'meta_keyword'     => 'nullable|string',
                'meta_description' => 'nullable|string',
                'image'            => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
                'f_image'          => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
                'alt_name'         => 'nullable|string|max:255',
                'status'           => ['required', Rule::in(['0', '1'])],
                'categories'       => 'required|array',
                'categories.*'     => 'exists:blog_categories,id',
            ],
            [
                'f_image.required' => 'The Featured image or video is required.',
                'f_image.image' => 'Please upload a valid image file.',
                'f_image.mimes' => 'We only support JPG, JPEG, PNG, WEBP, and GIF formats.',
                'f_image.max'   => 'That file is too big! Keep it under 2MB.',
                'image.required' => 'The Banner image or video is required.',
                'image.file' => 'Please upload a valid file.',
                'image.mimes' => 'Supported formats: JPG, JPEG, PNG, WEBP, GIF.',
                'image.max' => 'That file is too large! Keep it under 500MB.',
            ]
        );

        if ($request->remove_f_image == 1) {
            $request->validate(
                [
                    'f_image'          => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
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
        }
        if ($request->remove_image == 1) {
            if ($blog->image && Storage::disk('public')->exists($blog->image)) {
                Storage::disk('public')->delete($blog->image);
            }
            $validated['image'] = null;
        }
        $validated['updatedBy'] = Auth::id();

        // Handle main image replacement
        if ($request->hasFile('image')) {
            if ($blog->image && Storage::disk('public')->exists($blog->image)) {
                Storage::disk('public')->delete($blog->image);
            }

            $filename = uniqid('blog_image_') . '.' . $request->file('image')->getClientOriginalExtension();
            $validated['image'] = $request->file('image')
                ->storeAs("blogs/{$blog->id}/images/image", $filename, 'public');
        }

        // Handle featured image replacement
        if ($request->hasFile('f_image')) {
            if ($blog->f_image && Storage::disk('public')->exists($blog->f_image)) {
                Storage::disk('public')->delete($blog->f_image);
            }

            $filename = uniqid('blog_f_image_') . '.' . $request->file('f_image')->getClientOriginalExtension();
            $validated['f_image'] = $request->file('f_image')
                ->storeAs("blogs/{$blog->id}/images/f-image", $filename, 'public');
        }

        $blog->update($validated);

        if (isset($validated['categories'])) {
            $blog->categories()->sync($validated['categories']);
        }

        return ApiResponse::success($blog, 'Blog updated successfully');
    }


    /**
     * Toggle the publication status (active/inactive) of a blog post.
     *
     * @param string $slug The slug of the blog post
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */
    public function toggleStatus($id)
    {
        $blog            = Blog::findOrFail($id);
        $blog->status    = $blog->status == 1 ? "0" : "1";
        $blog->updatedBy = Auth::id();
        $blog->save();

        return ApiResponse::success([
            'status' => $blog->status,
        ], $blog->status == 1 ? 'Blog active' : 'Blog inactive');
    }

    /**
     * Permanently delete a blog post along with its associated images.
     *
     * @param string $slug The slug of the blog post to delete
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->image && Storage::disk('public')->exists($blog->image)) {
            Storage::disk('public')->delete($blog->image);
        }
        if ($blog->f_image && Storage::disk('public')->exists($blog->f_image)) {
            Storage::disk('public')->delete($blog->f_image);
        }

        $blog->delete();

        return ApiResponse::success(null, 'Blog deleted successfully');
    }
}
