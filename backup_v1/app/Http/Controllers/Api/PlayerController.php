<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * API Controller for managing player profiles.
 *
 * Handles CRUD operations, status toggling, image management, and automatic slug generation
 * based on name, sport, and country.
 */
class PlayerController extends Controller
{
    /**
     * Retrieve a paginated list of players with optional search.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Player::latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sport', 'like', "%{$search}%")
                    ->orWhere('position', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('per_page', 10);
        $players = $query->paginate($perPage);

        return ApiResponse::success($players, 'Players retrieved successfully');
    }

    /**
     * Retrieve a single player by its slug.
     *
     * @param string $slug The unique slug of the player
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */
    public function show($id)
    {
        $player = Player::findOrFail($id);
        return ApiResponse::success($player, 'Player retrieved successfully');
    }

    /**
     * Store a new player.
     *
     * Automatically generates a unique slug from name, sport, and country.
     * Handles optional image upload and assigns the authenticated user as creator.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'sport'             => 'required|string|max:255',
            'position'          => 'required|string|max:255',
            'team'              => 'required|string|max:255',
            'country'           => 'nullable|string|max:255',
            'birthdate'         => 'required|date',
            'height'            => 'nullable|string|max:50',
            'weight'            => 'nullable|string|max:50',
            'hometown'          => 'nullable|string|max:255',
            'asian_ranking'     => 'nullable|string|max:50',
            'national_ranking'  => 'nullable|string|max:50',
            'image'             => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'status'            => 'required|in:0,1',
        ]);

        // Generate a base slug and ensure uniqueness
        $baseSlug = Str::slug("{$validated['name']}-{$validated['sport']}" . ($validated['country'] ? "-{$validated['country']}" : ''));
        $slug = $baseSlug;
        $counter = 1;

        while (Player::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $validated['slug'] = $slug;

        // Assign creator (and updater for consistency)
        $validated['createdBy'] = Auth::id();
        $validated['updatedBy'] = Auth::id();

        // Create player first (without image)
        $player = Player::create($validated);

        // Handle image upload if present
        if ($request->hasFile('image')) {
            $filename = uniqid('player_image_') . '.' . $request->file('image')->getClientOriginalExtension();

            $path = $request->file('image')
                ->storeAs("players/{$player->id}/images", $filename, 'public');

            $player->update(['image' => $path]);
        }

        return ApiResponse::success($player, 'Player created successfully');
    }


    /**
     * Update an existing player.
     *
     * Regenerates the slug if name, sport, or country changes.
     * Replaces the image only if a new one is uploaded (deletes old image).
     *
     * @param Request $request
     * @param int $id The ID of the player to update
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $player = Player::findOrFail($id);

        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'sport'             => 'required|string|max:255',
            'position'          => 'nullable|string|max:255',
            'team'              => 'nullable|string|max:255',
            'country'           => 'nullable|string|max:255',
            'birthdate'         => 'nullable|date',
            'height'            => 'nullable|string|max:50',
            'weight'            => 'nullable|string|max:50',
            'hometown'          => 'nullable|string|max:255',
            'asian_ranking'     => 'nullable|string|max:50',
            'national_ranking'  => 'nullable|string|max:50',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'status'            => 'required|in:0,1',
        ]);

        // Regenerate slug with uniqueness check (excluding current record)
        $baseSlug = Str::slug("{$validated['name']}-{$validated['sport']}" . ($validated['country'] ? "-{$validated['country']}" : ''));
        $slug = $baseSlug;
        $counter = 1;

        while (Player::where('slug', $slug)->where('id', '!=', $player->id)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        if ($request->remove_image) {
            $request->validate([
                'image'=> 'required|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            ]);
        }

        $validated['slug'] = $slug;

        if ($request->hasFile('image')) {
            if ($player->image && Storage::disk('public')->exists($player->image)) {
                Storage::disk('public')->delete($player->image);
            }

            $filename = uniqid('player_image_') . '.' . $request->file('image')->getClientOriginalExtension();

            $validated['image'] = $request->file('image')
                ->storeAs("players/{$player->id}/images", $filename, 'public');
        }

        $validated['updatedBy'] = Auth::id();

        $player->update($validated);

        return ApiResponse::success($player, 'Player updated successfully');
    }


    /**
     * Toggle the publication status (active/inactive) of a player.
     *
     * @param string $slug The slug of the player
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */
    public function toggleStatus($id)
    {
        $player = Player::findOrFail($id);
        $player->status = $player->status == 1 ? 0 : 1;
        $player->updatedBy = Auth::id();
        $player->save();

        return ApiResponse::success([
            'status' => $player->status,
        ], $player->status == 1 ? 'Player active' : 'Player inactive');
    }

    /**
     * Permanently delete a player along with its associated image (if any).
     *
     * @param string $slug The slug of the player to delete
     * @return \Illuminate\Http\JsonResponse
     * @throws ModelNotFoundException
     */
    public function destroy($id)
    {
        $player = Player::findOrFail($id);
        if ($player->image && Storage::disk('public')->exists($player->image)) {
            Storage::disk('public')->delete($player->image);
        }

        $player->delete();

        return ApiResponse::success(null, 'Player deleted successfully');
    }
}
