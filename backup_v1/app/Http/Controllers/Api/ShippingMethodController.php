<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;
use App\Models\ShippingSetting;
use App\Models\WeightShippingSetting;
use App\Models\GeoZoneShippingRate;
use App\Models\GeoZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ShippingMethodController extends Controller
{
    /**
     * Retrieve all active shipping methods for dropdown/checkboxes.
     */
    public function allMethods()
    {
        $methods = Cache::rememberForever('all_shipping_methods', function () {
            return ShippingMethod::select('id', 'name')->get();
        });
        return ApiResponse::success($methods, 'All shipping methods retrieved successfully');
    }

    /**
     * Retrieve a paginated list of shipping methods.
     */
    public function index(Request $request)
    {
        $query = ShippingMethod::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
        }

        $perPage = (int) $request->input('per_page', 10);
        $methods = $query->paginate($perPage);

        return ApiResponse::success($methods, 'Shipping methods retrieved successfully');
    }

    /**
     * Toggle the status of a shipping method.
     */
    public function updateStatus(Request $request, $id)
    {
        $method = ShippingMethod::findOrFail($id);
        $method->status = $method->status == 1 ? 0 : 1;
        $method->save();

        return ApiResponse::success($method, 'Status updated successfully');
    }

    /**
     * Retrieve the settings for a specific shipping method.
     */
    public function settings($id)
    {
        $method = ShippingMethod::findOrFail($id);

        $data = [
            'shipping_method' => $method,
            'settings'        => ShippingSetting::where('shipping_method_id', $id)->get(),
        ];

        if ($method->code === 'weight') {
            $data['weight_settings'] = WeightShippingSetting::where('shipping_method_id', $id)->get();
        }

        if ($method->code === 'zone_rate') {
            $data['zone_rates'] = GeoZoneShippingRate::with('geoZone')->get(); // This table isn't bound to method id
            $data['geo_zones']  = GeoZone::all();
        }

        return ApiResponse::success($data, 'Settings retrieved successfully');
    }

    /**
     * Update the settings for a specific shipping method.
     */
    public function updateSettings(Request $request, $id)
    {
        $method = ShippingMethod::findOrFail($id);
        
        try {
            DB::beginTransaction();
            
            // 1. Status update
            if ($request->has('status')) {
                $method->update(['status' => $request->input('status')]);
            }

            // 2. Generic shipping settings
            if ($request->has('settings')) {
                foreach ($request->input('settings') as $setting) {
                    if (isset($setting['id']) && isset($setting['value'])) {
                        ShippingSetting::where('id', $setting['id'])
                            ->where('shipping_method_id', $id)
                            ->update(['value' => $setting['value']]);
                    }
                }
            }

            // 3. Weight Settings
            if ($method->code === 'weight' && $request->has('weight_settings')) {
                foreach ($request->input('weight_settings') as $ws) {
                    if (isset($ws['id'])) {
                        WeightShippingSetting::where('id', $ws['id'])->update([
                            'label' => $ws['label'],
                            'value' => $ws['value']
                        ]);
                    } else {
                        WeightShippingSetting::create([
                            'shipping_method_id' => $id,
                            'label' => $ws['label'],
                            'title' => 'Weight Rate',
                            'value' => $ws['value']
                        ]);
                    }
                }
            }

            // 4. Zone Rate Settings
            if ($method->code === 'zone_rate') {
                if ($request->has('zone_rates')) {
                    foreach ($request->input('zone_rates') as $zr) {
                        if (isset($zr['id'])) {
                            GeoZoneShippingRate::where('id', $zr['id'])->update([
                                'geo_zone_id' => $zr['geo_zone_id'],
                                'up_to_value' => $zr['up_to_value'],
                                'cost'        => $zr['cost'],
                            ]);
                        } else {
                            GeoZoneShippingRate::create([
                                'geo_zone_id' => $zr['geo_zone_id'],
                                'up_to_value' => $zr['up_to_value'],
                                'cost'        => $zr['cost'],
                            ]);
                        }
                    }
                }
            }

            DB::commit();
            return ApiResponse::success(null, 'Settings updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Failed to update settings', 500, [$e->getMessage()]);
        }
    }

    /**
     * Delete a geo zone rate record.
     */
    public function deleteZoneRate($id)
    {
        GeoZoneShippingRate::findOrFail($id)->delete();
        return ApiResponse::success(null, 'Zone rate deleted successfully');
    }

    /**
     * Delete a weight shipping setting.
     */
    public function deleteWeightRate($id)
    {
        WeightShippingSetting::findOrFail($id)->delete();
        return ApiResponse::success(null, 'Weight setting deleted successfully');
    }
}
