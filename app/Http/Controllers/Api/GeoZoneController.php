<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\GeoZone;
use App\Models\GeoZoneDetail;
use App\Models\Country;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class GeoZoneController extends Controller
{
    public function getCountries()
    {
        $countries = Country::where('status', 1)->get();
        return ApiResponse::success($countries, 'Countries retrieved');
    }

    public function getZones($countryId)
    {
        $zones = Zone::where('country_id', $countryId)->where('status', 1)->get();
        return ApiResponse::success($zones, 'Zones retrieved');
    }

    public function index(Request $request)
    {
        $query = GeoZone::query()->with('details.country', 'details.zone');

        if ($request->has('search') && $request->search != '') {
            $query->where('geo_zone_name', 'like', '%' . $request->search . '%')
                ->orWhere('geo_zone_description', 'like', '%' . $request->search . '%');
        }

        $perPage = $request->get('per_page', 10);
        $geoZones = $query->orderBy('sort_order', 'asc')->orderBy('id', 'desc')->paginate($perPage);

        return ApiResponse::success($geoZones, 'Geo Zones retrieved successfully');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'geo_zone_name' => 'required|string|max:155',
            'geo_zone_description' => 'nullable|string|max:300',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|integer|in:0,1',
            'details' => 'nullable|array',
            'details.*.country_id' => 'required|exists:countries,id',
            'details.*.zone_id' => 'required' // Can be 0
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation Error', $validator->errors()->toArray());
        }

        $data = $validator->validated();

        $details = $request->get('details', []);

        if ($this->check_exist_to_create($details)) {
            $geoZone = GeoZone::create([
                'geo_zone_name' => $data['geo_zone_name'],
                'geo_zone_description' => $data['geo_zone_description'] ?? null,
                'sort_order' => $data['sort_order'] ?? 0,
                'status' => $data['status'] ?? 1,
                'createdBy' => Auth::id()
            ]);

            foreach ($details as $detail) {
                GeoZoneDetail::create([
                    'geo_zone_id' => $geoZone->id,
                    'country_id' => $detail['country_id'],
                    'zone_id' => $detail['zone_id'],
                ]);
            }

            return ApiResponse::success($geoZone, 'Geo Zone created successfully', 201);
        }

        return ApiResponse::error('One or more Country and Zone mapping already exists!', 422);
    }

    public function show($id)
    {
        $geoZone = GeoZone::with('details.country', 'details.zone')->findOrFail($id);
        return ApiResponse::success($geoZone, 'Geo Zone retrieved successfully');
    }

    public function update(Request $request, $id)
    {
        $geoZone = GeoZone::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'geo_zone_name' => 'required|string|max:155',
            'geo_zone_description' => 'nullable|string|max:300',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|integer|in:0,1',
            'details' => 'nullable|array',
            'details.*.id' => 'nullable|exists:geo_zone_details,id',
            'details.*.country_id' => 'required|exists:countries,id',
            'details.*.zone_id' => 'required'
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation Error', $validator->errors()->toArray());
        }

        $data = $validator->validated();

        $details = $request->get('details', []);

        // We only check for existence if there are NEW details (no id)
        $newDetails = array_filter($details, function ($d) {
            return empty($d['id']);
        });

        if (count($newDetails) > 0 && !$this->check_exist_to_create($newDetails)) {
            return ApiResponse::error('One or more new Country and Zone mappings already exist!', 422);
        }

        $geoZone->update([
            'geo_zone_name' => $data['geo_zone_name'],
            'geo_zone_description' => $data['geo_zone_description'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'status' => $data['status'] ?? 1,
            'updatedBy' => Auth::id()
        ]);

        // Process details
        $existingDetailIds = [];
        foreach ($details as $detail) {
            if (!empty($detail['id'])) {
                $geoDetail = GeoZoneDetail::find($detail['id']);
                if ($geoDetail && $geoDetail->geo_zone_id == $geoZone->id) {
                    $geoDetail->update([
                        'country_id' => $detail['country_id'],
                        'zone_id' => $detail['zone_id']
                    ]);
                    $existingDetailIds[] = $geoDetail->id;
                }
            } else {
                $newDetail = GeoZoneDetail::create([
                    'geo_zone_id' => $geoZone->id,
                    'country_id' => $detail['country_id'],
                    'zone_id' => $detail['zone_id'],
                ]);
                $existingDetailIds[] = $newDetail->id;
            }
        }

        // Delete any details that were removed
        GeoZoneDetail::where('geo_zone_id', $geoZone->id)
            ->whereNotIn('id', $existingDetailIds)
            ->delete();

        return ApiResponse::success($geoZone, 'Geo Zone updated successfully');
    }

    public function destroy($id)
    {
        $geoZone = GeoZone::findOrFail($id);
        $geoZone->delete(); // Details will cascade delete based on migration
        return ApiResponse::success(null, 'Geo Zone deleted successfully');
    }

    public function updateStatus(Request $request, $id)
    {
        $geoZone = GeoZone::findOrFail($id);
        $geoZone->status = $geoZone->status == 1 ? 0 : 1;
        $geoZone->save();

        return ApiResponse::success($geoZone, 'Status updated successfully');
    }

    public function removeDetail($id)
    {
        $detail = GeoZoneDetail::findOrFail($id);
        $detail->delete();

        return ApiResponse::success(null, 'Detail removed successfully');
    }

    private function check_exist_to_create($detailsArray)
    {
        foreach ($detailsArray as $con) {
            $country_id = $con['country_id'];
            $zone_id = $con['zone_id'];

            if ($zone_id != 0) {
                $count = GeoZoneDetail::where('country_id', $country_id)->where('zone_id', $zone_id)->count();

                if ($count == 0) {
                    // Check if there is a mapping for ALL zones in this country
                    $countAll = GeoZoneDetail::where('country_id', $country_id)->where('zone_id', 0)->count();

                    if ($countAll > 0) {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                // If adding ALL zones (0), check if there is ANY mapping for this country
                $count = GeoZoneDetail::where('country_id', $country_id)->count();

                if ($count > 0) {
                    return false;
                }
            }
        }

        return true;
    }
}
