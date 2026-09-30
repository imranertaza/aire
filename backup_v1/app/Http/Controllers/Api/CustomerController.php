<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerLedger;
use App\Models\CustomerPointHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index(Request $request)
    {
        $query = Customer::latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'like', "%{$search}%")
                    ->orWhere('lastname', 'like', "%{$search}%")
                    ->orWhereRaw("CONCAT(firstname, ' ', lastname) like ?", ["%{$search}%"])
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->input('per_page', 10);
        $customers = $query->paginate($perPage);

        return ApiResponse::success($customers, 'Customers retrieved successfully');
    }

    /**
     * Store a newly created customer.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstname'    => 'required|string|max:32',
            'lastname'     => 'required|string|max:32',
            'email'        => 'required|email|max:96|unique:customers,email',
            'phone'        => 'required|string|min:10|max:12|unique:customers,phone',
            'password'     => 'required|string|min:6|max:30',
            'con_password' => 'required|string|same:password',
        ]);

        $customer = Customer::create([
            'firstname'  => $validated['firstname'],
            'lastname'   => $validated['lastname'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'],
            'password'   => Hash::make($validated['password']),
            'salt'       => Str::random(9),
            'ip'         => $request->ip(),
            'status'     => 1,
            'createdBy'  => Auth::id(),
        ]);

        return ApiResponse::success($customer, 'Customer created successfully');
    }

    /**
     * Display the specified customer.
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return ApiResponse::success($customer, 'Customer retrieved successfully');
    }

    /**
     * Update basic info of the customer.
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $rules = [
            'firstname' => 'required|string|max:32',
            'lastname'  => 'required|string|max:32',
            'email'     => 'required|email|max:96|unique:customers,email,' . $customer->id,
            'phone'     => 'required|string|min:10|max:12|unique:customers,phone,' . $customer->id,
        ];

        if ($request->filled('password')) {
            $rules['password']     = 'required|string|min:6|max:30';
            $rules['con_password'] = 'required|string|same:password';
        }

        $validated = $request->validate($rules);

        $data = [
            'firstname' => $validated['firstname'],
            'lastname'  => $validated['lastname'],
            'email'     => $validated['email'],
            'phone'     => $validated['phone'],
            'updatedBy' => Auth::id(),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        $customer->update($data);

        return ApiResponse::success($customer, 'Customer updated successfully');
    }



    /**
     * Remove the specified customer from storage.
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        // Delete photo
        if ($customer->pic && Storage::disk('public')->exists($customer->pic)) {
            Storage::disk('public')->delete($customer->pic);
        }

        $customer->delete();

        return ApiResponse::success(null, 'Customer deleted successfully');
    }

    /**
     * Retrieve customer ledger records.
     */
    public function ledger(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $perPage = (int) $request->input('per_page', 10);

        $ledger = CustomerLedger::where('customer_id', $customer->id)
            ->latest('id')
            ->paginate($perPage);

        return ApiResponse::success($ledger, 'Customer ledger retrieved successfully');
    }

    /**
     * Retrieve customer point history records.
     */
    public function point(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $perPage = (int) $request->input('per_page', 10);

        $points = CustomerPointHistory::where('customer_id', $customer->id)
            ->latest('id')
            ->paginate($perPage);

        return ApiResponse::success($points, 'Customer point history retrieved successfully');
    }
}
