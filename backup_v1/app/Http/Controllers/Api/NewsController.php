<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * API Controller for managing news articles.
 *
 * Handles CRUD operations, status toggling, and listing of news with optional search and pagination.
 */
class NewsController extends Controller
{
    /**
     * Retrieve a paginated list of news articles with optional search.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = News::latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('news_title', 'like', "%{$search}%")
                    ->orWhere('short_des', 'like', "%{$search}%")
                    ->orWhere('meta_title', 'like', "%{$search}%")
                    ->orWhere('meta_description', 'like', "%{$search}%")
                    ->orWhere('meta_keyword', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('per_page', 10);
        $news = $query->paginate($perPage);

        return ApiResponse::success($news, 'News retrieved successfully');
    }

    /**
     * Retrieve a single news article by its slug along with related categories and parent.
     *
     * @param string $slug The unique slug of the news article
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */
    public function show($id)
    {
        $news = News::with('categories.parent')->findOrFail($id);
        return ApiResponse::success($news, 'News retrieved successfully');
    }

    /**
     * Store a new news article.
     *
     * Validates input, handles file uploads for main image/video and featured image,
     * assigns creator/updater, and syncs categories.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'news_title'       => 'required|string|max:255',
            'slug'             => 'required|string|unique:news,slug',
            'short_des'        => 'required|string|max:255',
            'description'      => 'required|string',
            'meta_title'       => 'nullable|string',
            'meta_keyword'     => 'nullable|string',
            'meta_description' => 'nullable|string',
            'image'            => 'nullable|file|mimes:jpg,jpeg,png,webp,gif,mp4,avi,mov,wmv|max:500000',
            'f_image'          => 'required|image|mimes:jpg,jpeg,webp,png,gif|max:2048',
            'alt_name'         => 'nullable|string|max:255',
            'publish_date'     => 'nullable|date',
            'status'           => ['required', Rule::in(['0', '1'])],
            'featured'         => ['required', Rule::in([0, 1])],
            'categories'       => 'required|array',
            'categories.*'     => 'exists:news_categories,id',
        ], [
            'f_image.required' => 'The Featured image or video is required.',
            'f_image.image' => 'Please upload a valid image file.',
            'f_image.mimes' => 'We only support JPG, JPEG, PNG, and GIF formats.',
            'f_image.max'   => 'That file is too big! Keep it under 2MB.',
            'image.required' => 'The Banner image or video is required.',
            'image.file' => 'Please upload a valid file.',
            'image.mimes' => 'Supported formats: JPG, JPEG, PNG, GIF, MP4, AVI, MOV, WMV.',
            'image.max' => 'That file is too large! Keep it under 500MB.',
        ]);

        $validated['createdBy'] = Auth::id();
        $validated['updatedBy'] = Auth::id();
        $validated['publish_date'] = $request->input('publish_date', now());

        // Create news first (without images)
        $news = News::create($validated);

        // Handle main image
        if ($request->hasFile('image')) {
            $filename = uniqid('news_image_') . '.' . $request->file('image')->getClientOriginalExtension();
            $path = $request->file('image')
                ->storeAs("news/{$news->id}/images/image", $filename, 'public');
            $news->update(['image' => $path]);
        }

        // Handle featured image
        if ($request->hasFile('f_image')) {
            $filename = uniqid('news_f_image_') . '.' . $request->file('f_image')->getClientOriginalExtension();
            $path = $request->file('f_image')
                ->storeAs("news/{$news->id}/images/f-image", $filename, 'public');
            $news->update(['f_image' => $path]);
        }

        if (isset($validated['categories'])) {
            $news->categories()->sync($validated['categories']);
        }

        return ApiResponse::success($news, 'News created successfully');
    }


    /**
     * Update an existing news article.
     *
     * Handles validation, file replacement (deletes old files if new ones are uploaded),
     * updates updater ID, and syncs categories.
     *
     * @param Request $request
     * @param int $id The ID of the news article to update
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $validated = $request->validate(
            [
                'news_title'       => 'required|string|max:255',
                'slug'             => [
                    'required',
                    'string',
                    Rule::unique('news', 'slug')->ignore($news->id),
                ],
                'short_des'        => 'required|string|max:255',
                'description'      => 'required|string',
                'meta_title'       => 'nullable|string',
                'meta_keyword'     => 'nullable|string',
                'meta_description' => 'nullable|string',
                'image'            => 'nullable|file|mimes:jpg,jpeg,png,webp,gif,mp4,avi,mov,wmv|max:500000',
                'f_image'          => 'nullable|image|mimes:jpg,jpeg,webp,png,gif|max:2048',
                'alt_name'         => 'nullable|string|max:255',
                'status'           => ['required', Rule::in(['0', '1'])],
                'featured'         => ['required', Rule::in([0, 1])],
                'categories'       => 'required|array',
                'categories.*'     => 'exists:news_categories,id',
                'remove_image'     => 'nullable',
                'remove_f_image'   => 'nullable'
            ],
            [
                'f_image.image' => 'Please upload a valid image file.',
                'f_image.mimes' => 'We only support JPG, JPEG, PNG, WEBP, and GIF formats.',
                'f_image.max'   => 'That file is too big! Keep it under 2MB.',
                'f_image.required' => 'Featured Image is Required',
                'image.file' => 'Please upload a valid file.',
                'image.mimes' => 'Supported formats: JPG, JPEG, PNG, WEBP, GIF, MP4, AVI, MOV, WMV.',
                'image.max' => 'That file is too large! Keep it under 500MB.',
            ]
        );

        if ($request->remove_image == 1) {
            if ($news->image && Storage::disk('public')->exists($news->image)) {
                Storage::disk('public')->delete($news->image);
            }
            $validated['image'] = null;
        }
        if ($request->remove_f_image == 1) {
            $request->validate(
                [
                    'f_image' => 'required|image|mimes:jpg,jpeg,webp,png,gif|max:2048',
                ],
                [
                    'f_image.image' => 'Please upload a valid image file.',
                    'f_image.mimes' => 'We only support JPG, JPEG, PNG, WEBP,and GIF formats.',
                    'f_image.required' => 'Featured image is required',
                    'f_image.max'   => 'That file is too big! Keep it under 2MB.'
                ]
            );
        }

        $validated['updatedBy'] = Auth::id();

        // Handle main image/video replacement
        if ($request->hasFile('image')) {
            if ($news->image && Storage::disk('public')->exists($news->image)) {
                Storage::disk('public')->delete($news->image);
            }

            $filename = uniqid('news_image_') . '.' . $request->file('image')->getClientOriginalExtension();
            $validated['image'] = $request->file('image')
                ->storeAs("news/{$news->id}/images/image", $filename, 'public');
        }

        // Handle featured image replacement
        if ($request->hasFile('f_image')) {
            if ($news->f_image && Storage::disk('public')->exists($news->f_image)) {
                Storage::disk('public')->delete($news->f_image);
            }

            $filename = uniqid('news_f_image_') . '.' . $request->file('f_image')->getClientOriginalExtension();
            $validated['f_image'] = $request->file('f_image')
                ->storeAs("news/{$news->id}/images/f-image", $filename, 'public');
        }

        $news->update($validated);

        if (isset($validated['categories'])) {
            $news->categories()->sync($validated['categories']);
        }

        return ApiResponse::success($news, 'News updated successfully');
    }


    /**
     * Toggle the publication status (active/inactive) of a news article.
     *
     * @param string $slug The slug of the news article
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */
    public function toggleStatus($id)
    {
        $news = News::findOrFail($id);
        $news->status = $news->status == 1 ? 0 : 1;
        $news->updatedBy = Auth::id();
        $news->save();

        return ApiResponse::success([
            'status' => $news->status,
        ], $news->status == 1 ? 'News active' : 'News inactive');
    }

    /**
     * Permanently delete a news article along with its associated media files.
     *
     * @param string $slug The slug of the news article to delete
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */
    public function destroy($id)
    {
        $news = News::findOrFail($id);

        if ($news->image && Storage::disk('public')->exists($news->image)) {
            Storage::disk('public')->delete($news->image);
        }
        if ($news->f_image && Storage::disk('public')->exists($news->f_image)) {
            Storage::disk('public')->delete($news->f_image);
        }

        $news->delete();

        return ApiResponse::success(null, 'News deleted successfully');
    }
}
