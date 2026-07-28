<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\GeoZone;
use App\Models\ShippingMethod;
use App\Models\Offer;
use App\Models\OfferDiscount;
use App\Models\OfferOnProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OfferController extends Controller
{
    /**
     * Retrieve a paginated list of offers with optional search.
     */
    public function index(Request $request)
    {
        $query = Offer::with('discounts')->latest('id');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->ofType($request->input('type'));
        }

        $perPage = (int) $request->input('per_page', 10);
        $offers  = $query->paginate($perPage);

        return ApiResponse::success($offers, 'Offers retrieved successfully');
    }

    /**
     * Retrieve all offers for dropdown.
     */
    public function allOffers()
    {
        $offers = Cache::rememberForever('all_offers', function () {
            return Offer::select('id', 'name', 'slug')->get();
        });
        return ApiResponse::success($offers, 'All offers retrieved successfully');
    }

    /**
     * Retrieve data for zone-based offers.
     */
    public function getZoneData()
    {
        $geoZones = GeoZone::active()->get();
        $shippingMethod = ShippingMethod::where('status', 1)->where('code', 'zone_rate')->first();

        return ApiResponse::success([
            'geoZones' => $geoZones,
            'shippingMethod' => $shippingMethod
        ], 'Zone data retrieved successfully');
    }

    /**
     * Retrieve a single offer with all relationships.
     */
    public function show($id)
    {
        $offer = Offer::with(['discounts', 'targetItems'])->findOrFail($id);
        return ApiResponse::success($offer, 'Offer retrieved successfully');
    }

    /**
     * Store a new offer with discount and product targets.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                   => 'required|string|max:255',
            'key'                    => 'nullable|string|max:255',
            'description'            => 'required|string',
            'slug'                   => 'required|string|max:255',
            'alt_name'               => 'nullable|string|max:155',
            'offer_type'             => 'required|in:1,2',
            'offer_on'               => 'required|in:1,2',
            'qty'                    => 'nullable|integer|min:0',
            'on_amount'              => 'nullable|numeric|min:0',
            'discount_on'            => 'required|in:1,2,3',
            'start_date'             => 'required|date',
            'expire_date'            => 'required|date',
            'discount_calculate_on'  => 'nullable|in:1,2',  // 1=percentage, 2=fixed
            'discount_amount'        => 'nullable|numeric|min:0',
            'zone_discounts'         => 'nullable|array',
            'zone_discounts.*.geo_zone_id'           => 'required_with:zone_discounts|integer',
            'zone_discounts.*.shipping_method_id'    => 'nullable|integer',
            'zone_discounts.*.discount_calculate_on' => 'required_with:zone_discounts|in:1,2',
            'zone_discounts.*.discount_amount'       => 'required_with:zone_discounts|numeric|min:0',
            'products'               => 'nullable|array',
            'products.*'             => 'integer',
            'categories'             => 'nullable|array',
            'categories.*'           => 'integer',
            'brands'                 => 'nullable|array',
            'brands.*'               => 'integer',
            'all_products'           => 'nullable|boolean',
            'banner'                 => 'nullable|image|max:5120',
        ]);

        try {
            DB::beginTransaction();

            $offer = Offer::create([
                'name'        => $validated['name'],
                'key'         => $validated['key'] ?? 'general_offer',
                'description' => $validated['description'],
                'slug'        => $validated['slug'],
                'alt_name'    => $validated['alt_name'] ?? $validated['name'],
                'offer_type'  => $validated['offer_type'],
                'offer_on'    => $validated['offer_on'],
                'qty'         => $validated['qty'] ?? null,
                'on_amount'   => $validated['on_amount'] ?? 0,
                'discount_on' => $validated['discount_on'],
                'start_date'  => $validated['start_date'],
                'expire_date' => $validated['expire_date'],
            ]);

            // Create discount record(s)
            if (($validated['key'] ?? 'general_offer') === 'zone_based_offer' && !empty($validated['zone_discounts'])) {
                $zoneInserts = array_map(function ($zd) use ($offer) {
                    return [
                        'offer_id'              => $offer->id,
                        'geo_zone_id'           => $zd['geo_zone_id'],
                        'shipping_method_id'    => $zd['shipping_method_id'] ?? null,
                        'discount_calculate_on' => $zd['discount_calculate_on'],
                        'discount_amount'       => $zd['discount_amount'],
                        'created_at'            => now(),
                        'updated_at'            => now(),
                    ];
                }, $validated['zone_discounts']);
                OfferDiscount::insert($zoneInserts);
            } else {
                OfferDiscount::create([
                    'offer_id'              => $offer->id,
                    'discount_calculate_on' => $validated['discount_calculate_on'] ?? 1,
                    'discount_amount'       => $validated['discount_amount'] ?? 0,
                ]);
            }

            // Attach specific products
            if (!empty($validated['products'])) {
                $inserts = array_map(fn($id) => ['offer_id' => $offer->id, 'product_id' => $id], $validated['products']);
                OfferOnProduct::insert($inserts);
            }

            // Attach categories
            if (!empty($validated['categories'])) {
                $inserts = array_map(fn($id) => ['offer_id' => $offer->id, 'prod_cat_id' => $id], $validated['categories']);
                OfferOnProduct::insert($inserts);
            }

            // Attach brands
            if (!empty($validated['brands'])) {
                $inserts = array_map(fn($id) => ['offer_id' => $offer->id, 'brand_id' => $id], $validated['brands']);
                OfferOnProduct::insert($inserts);
            }

            // All products flag (no FK references, blank row)
            if (!empty($validated['all_products'])) {
                OfferOnProduct::create(['offer_id' => $offer->id]);
            }

            // Handle banner image upload
            if ($request->hasFile('banner')) {
                $file     = $request->file('banner');
                $filename = 'offer_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('uploads/offers/' . $offer->id, $filename, 'public');
                $offer->update(['banner' => $filename]);
            }

            DB::commit();

            return ApiResponse::success($offer->load(['discounts', 'targetItems']), 'Offer created successfully', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Failed to create offer', 500, [$e->getMessage()]);
        }
    }

    /**
     * Update an existing offer.
     */
    public function update(Request $request, $id)
    {
        $offer = Offer::findOrFail($id);

        $validated = $request->validate([
            'name'                   => 'required|string|max:255',
            'key'                    => 'nullable|string|max:255',
            'description'            => 'required|string',
            'slug'                   => 'required|string|max:255',
            'alt_name'               => 'nullable|string|max:155',
            'offer_type'             => 'required|in:1,2',
            'offer_on'               => 'required|in:1,2',
            'qty'                    => 'nullable|integer|min:0',
            'on_amount'              => 'nullable|numeric|min:0',
            'discount_on'            => 'required|in:1,2,3',
            'start_date'             => 'required|date',
            'expire_date'            => 'required|date',
            'discount_calculate_on'  => 'nullable|in:1,2',
            'discount_amount'        => 'nullable|numeric|min:0',
            'zone_discounts'         => 'nullable|array',
            'zone_discounts.*.geo_zone_id'           => 'required_with:zone_discounts|integer',
            'zone_discounts.*.shipping_method_id'    => 'nullable|integer',
            'zone_discounts.*.discount_calculate_on' => 'required_with:zone_discounts|in:1,2',
            'zone_discounts.*.discount_amount'       => 'required_with:zone_discounts|numeric|min:0',
            'products'               => 'nullable|array',
            'products.*'             => 'integer',
            'categories'             => 'nullable|array',
            'categories.*'           => 'integer',
            'brands'                 => 'nullable|array',
            'brands.*'               => 'integer',
            'all_products'           => 'nullable|boolean',
            'banner'                 => 'nullable|image|max:5120',
        ]);

        try {
            DB::beginTransaction();

            $offer->update([
                'name'        => $validated['name'],
                'key'         => $validated['key'] ?? $offer->key,
                'description' => $validated['description'],
                'slug'        => $validated['slug'],
                'alt_name'    => $validated['alt_name'] ?? $validated['name'],
                'offer_type'  => $validated['offer_type'],
                'offer_on'    => $validated['offer_on'],
                'qty'         => $validated['qty'] ?? null,
                'on_amount'   => $validated['on_amount'] ?? 0,
                'discount_on' => $validated['discount_on'],
                'start_date'  => $validated['start_date'],
                'expire_date' => $validated['expire_date'],
            ]);

            // Recreate discount record(s)
            OfferDiscount::where('offer_id', $offer->id)->delete();
            
            if (($validated['key'] ?? $offer->key) === 'zone_based_offer' && !empty($validated['zone_discounts'])) {
                $zoneInserts = array_map(function ($zd) use ($offer) {
                    return [
                        'offer_id'              => $offer->id,
                        'geo_zone_id'           => $zd['geo_zone_id'],
                        'shipping_method_id'    => $zd['shipping_method_id'] ?? null,
                        'discount_calculate_on' => $zd['discount_calculate_on'],
                        'discount_amount'       => $zd['discount_amount'],
                        'created_at'            => now(),
                        'updated_at'            => now(),
                    ];
                }, $validated['zone_discounts']);
                OfferDiscount::insert($zoneInserts);
            } else {
                OfferDiscount::create([
                    'offer_id'              => $offer->id,
                    'discount_calculate_on' => $validated['discount_calculate_on'] ?? 1,
                    'discount_amount'       => $validated['discount_amount'] ?? 0,
                ]);
            }

            // Recreate all target items
            OfferOnProduct::where('offer_id', $offer->id)->delete();

            if (!empty($validated['products'])) {
                $inserts = array_map(fn($pid) => ['offer_id' => $offer->id, 'product_id' => $pid], $validated['products']);
                OfferOnProduct::insert($inserts);
            }

            if (!empty($validated['categories'])) {
                $inserts = array_map(fn($cid) => ['offer_id' => $offer->id, 'prod_cat_id' => $cid], $validated['categories']);
                OfferOnProduct::insert($inserts);
            }

            if (!empty($validated['brands'])) {
                $inserts = array_map(fn($bid) => ['offer_id' => $offer->id, 'brand_id' => $bid], $validated['brands']);
                OfferOnProduct::insert($inserts);
            }

            if (!empty($validated['all_products'])) {
                OfferOnProduct::create(['offer_id' => $offer->id]);
            }

            if ($request->hasFile('banner')) {
                // 1. Delete old file if it exists
                if ($offer->banner) {
                    Storage::disk('public')->delete('uploads/offers/' . $offer->id . '/' . $offer->banner);
                }

                // 2. Upload new file
                $file = $request->file('banner');
                $filename = 'offer_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('uploads/offers/' . $offer->id, $filename, 'public');

                $offer->update(['banner' => $filename]);
            } elseif ($request->has('remove_banner') && $request->remove_banner == '1') {
                // 3. Handle explicit removal via a "Remove" button
                if ($offer->banner) {
                    Storage::disk('public')->delete('uploads/offers/' . $offer->id . '/' . $offer->banner);
                    $offer->update(['banner' => null]);
                }
            }
            // Handle banner image upload
            if ($request->hasFile('banner')) {
                // Delete old banner
                if ($offer->banner) {
                    Storage::disk('public')->delete('uploads/offers/' . $offer->id . '/' . $offer->banner);
                }
                $file     = $request->file('banner');
                $filename = 'offer_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('uploads/offers/' . $offer->id, $filename, 'public');
                $offer->update(['banner' => $filename]);
            }

            DB::commit();

            return ApiResponse::success($offer->load(['discounts', 'targetItems']), 'Offer updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Failed to update offer', 500, [$e->getMessage()]);
        }
    }

    /**
     * Permanently delete an offer and all its associated data and banner image.
     */
    public function destroy($id)
    {
        $offer = Offer::findOrFail($id);

        // Delete banner image folder
        if ($offer->banner) {
            Storage::disk('public')->deleteDirectory('uploads/offers/' . $offer->id);
        }

        // Cascade deletes are handled by DB constraint, but explicit for clarity
        OfferOnProduct::where('offer_id', $id)->delete();
        OfferDiscount::where('offer_id', $id)->delete();
        $offer->delete();

        return ApiResponse::success(null, 'Offer deleted successfully');
    }
}
