<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\ModuleSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ModuleController extends Controller
{
    public function index(Request $request)
    {
        $query = Module::withExists('settings');

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('module_key', 'like', '%' . $request->search . '%');
        }

        $perPage = $request->get('per_page', 10);
        $modules = $query->orderBy('id', 'asc')->paginate($perPage);

        return ApiResponse::success($modules, 'Modules retrieved successfully');
    }

    public function show($id)
    {
        $module = Module::with('settings')->findOrFail($id);
        return ApiResponse::success($module, 'Module retrieved successfully');
    }

    public function updateSettings(Request $request, $id)
    {
        $module = Module::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'settings' => 'required|array',
            'settings.*.setting_key' => 'required|string',
            'settings.*.value' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation Error', $validator->errors()->toArray());
        }

        DB::beginTransaction();
        try {
            foreach ($request->settings as $setting) {
                ModuleSetting::where('module_id', $module->id)
                    ->where('setting_key', $setting['setting_key'])
                    ->update(['value' => $setting['value']]);
            }
            DB::commit();
            return ApiResponse::success(null, 'Module Settings updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error('Failed to update settings: ' . $e->getMessage(), 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $module = Module::findOrFail($id);
        $module->status = $module->status == 1 ? 0 : 1;
        $module->save();

        return ApiResponse::success($module, 'Status updated successfully');
    }
}
