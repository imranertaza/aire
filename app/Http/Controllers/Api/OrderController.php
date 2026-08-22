<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerPointHistory;
use App\Models\Module;
use App\Models\Order;
use App\Models\OrderCardDetail;
use App\Models\OrderHistory;
use App\Models\OrderItem;
use App\Models\OrderOption;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = Order::with('orderStatus')->latest('id');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('payment_firstname', 'like', "%{$search}%")
                    ->orWhere('payment_lastname', 'like', "%{$search}%")
                    ->orWhere('shipping_firstname', 'like', "%{$search}%")
                    ->orWhere('shipping_lastname', 'like', "%{$search}%")
                    ->orWhereRaw("CONCAT(payment_firstname, ' ', payment_lastname) like ?", ["%{$search}%"])
                    ->orWhere('payment_email', 'like', "%{$search}%")
                    ->orWhere('payment_phone', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->input('per_page', 10);
        $orders = $query->paginate($perPage);

        return ApiResponse::success($orders, 'Orders retrieved successfully');
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::with([
            'orderStatus',
            'items.product',
            'items.options',
            'options',
            'histories.orderStatus',
            'cardDetail',
            'customer'
        ])->findOrFail($id);

        $statuses = OrderStatus::all();

        return ApiResponse::success([
            'order' => $order,
            'statuses' => $statuses
        ], 'Order details retrieved successfully');
    }

    /**
     * Add a comments log entry to history, and update order status.
     */
    public function history(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'order_status_id' => 'required|exists:order_statuses,id',
            'comment'         => 'required|string',
            'notify'          => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($order, $validated) {
            // Insert history record
            OrderHistory::create([
                'order_id'        => $order->id,
                'order_status_id' => $validated['order_status_id'],
                'notify'          => $validated['notify'] ?? 0,
                'comment'         => $validated['comment'],
            ]);

            // Update order status
            $order->update(['status' => $validated['order_status_id']]);

            // Handle points return/deduction if status is Canceled (7)
            if ($validated['order_status_id'] == 7) {
                if ($order->customer_id) {
                    $pointModule = Module::where('module_key', 'point')->first();
                    if ($pointModule && $pointModule->status == 1) {
                        $customer = Customer::find($order->customer_id);
                        if ($customer) {
                            $pointToDeduct = (int) $order->total_point;
                            if ($pointToDeduct > 0) {
                                $newPoints = max(0, $customer->point - $pointToDeduct);

                                // Deduct from customer
                                $customer->update(['point' => $newPoints]);

                                // Log points history
                                CustomerPointHistory::create([
                                    'customer_id'      => $customer->id,
                                    'order_id'         => $order->id,
                                    'particulars'      => 'product purchase point return',
                                    'transaction_type' => 'Dr.',
                                    'point'            => $pointToDeduct,
                                    'rest_point'       => $newPoints,
                                    'created_by'       => Auth::id(),
                                ]);

                                // Set order total points to 0
                                $order->update(['total_point' => 0]);
                            }
                        }
                    }
                }
            }
        });

        return ApiResponse::success(null, 'Order history status updated successfully');
    }

    /**
     * Update order payment status.
     */
    public function paymentStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:Pending,Paid,Failed',
        ]);

        DB::transaction(function () use ($order, $validated) {
            $order->update(['payment_status' => $validated['status']]);

            // Grant points if payment status becomes Paid
            if ($validated['status'] === 'Paid') {
                if ($order->customer_id) {
                    $pointModule = Module::with('settings')->where('module_key', 'point')->first();
                    if ($pointModule && $pointModule->status == 1) {
                        $setting = $pointModule->settings->where('setting_key', 'point_par_doller')->first();
                        $multiplier = $setting ? (float)$setting->value : 1.0;

                        $customer = Customer::find($order->customer_id);
                        if ($customer) {
                            $pointsToAdd = (int) round($order->total * $multiplier);
                            $newPoints = $customer->point + $pointsToAdd;

                            // Credit customer
                            $customer->update(['point' => $newPoints]);

                            // Log point history
                            CustomerPointHistory::create([
                                'customer_id'      => $customer->id,
                                'order_id'         => $order->id,
                                'particulars'      => 'product purchase point',
                                'transaction_type' => 'Cr.',
                                'point'            => $pointsToAdd,
                                'rest_point'       => $newPoints,
                                'created_by'       => Auth::id(),
                            ]);

                            // Set order points
                            $order->update(['total_point' => $pointsToAdd]);
                        }
                    }
                }
            }
        });

        return ApiResponse::success(null, 'Payment status updated successfully');
    }

    /**
     * Add/Deduct points manually.
     */
    public function updatePoints(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:add,deduct',
            'amount' => 'required|integer|min:1',
        ]);

        if (!$order->customer_id) {
            return ApiResponse::error('Order is not linked to any customer', 422);
        }

        $customer = Customer::findOrFail($order->customer_id);

        DB::transaction(function () use ($order, $customer, $validated) {
            $amount = (int) $validated['amount'];
            $pointModule = Module::where('module_key', 'point')->first();

            if ($pointModule && $pointModule->status == 1) {
                if ($validated['status'] === 'add') {
                    $newPoints = $customer->point + $amount;

                    $customer->update(['point' => $newPoints]);

                    CustomerPointHistory::create([
                        'customer_id'      => $customer->id,
                        'order_id'         => $order->id,
                        'particulars'      => 'Point add by admin',
                        'transaction_type' => 'Cr.',
                        'point'            => $amount,
                        'rest_point'       => $newPoints,
                        'created_by'       => Auth::id(),
                    ]);

                    $order->update(['total_point' => $order->total_point + $amount]);
                } else {
                    $newPoints = max(0, $customer->point - $amount);

                    $customer->update(['point' => $newPoints]);

                    CustomerPointHistory::create([
                        'customer_id'      => $customer->id,
                        'order_id'         => $order->id,
                        'particulars'      => 'Point deducted by admin',
                        'transaction_type' => 'Dr.',
                        'point'            => $amount,
                        'rest_point'       => $newPoints,
                        'created_by'       => Auth::id(),
                    ]);

                    $order->update(['total_point' => max(0, $order->total_point - $amount)]);
                }
            }
        });

        return ApiResponse::success(null, 'Points updated successfully');
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        DB::transaction(function () use ($order) {
            // Delete dependent records
            OrderOption::where('order_id', $order->id)->delete();
            OrderItem::where('order_id', $order->id)->delete();
            OrderHistory::where('order_id', $order->id)->delete();
            OrderCardDetail::where('order_id', $order->id)->delete();
            $order->delete();
        });

        return ApiResponse::success(null, 'Order deleted successfully');
    }
}
