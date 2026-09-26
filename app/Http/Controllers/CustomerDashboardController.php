<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerLedger;
use App\Models\CustomerPointHistory;
use App\Models\FundRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CustomerDashboardController extends Controller
{
    /**
     * Display customer dashboard.
     * Eager-loads orderStatus to prevent N+1 queries and limits to 5 recent orders.
     */
    public function dashboard()
    {
        $customer = Auth::guard('customer')->user();
        $orders = Order::with('orderStatus')
            ->where('customer_id', $customer->id)
            ->latest('id')
            ->limit(5)
            ->get();

        return \theme_view('customer.dashboard', compact('customer', 'orders'));
    }

    /**
     * Display paginated orders list for the logged-in customer.
     * Eager-loads orderStatus to prevent N+1 queries on status_name.
     */
    public function customerOrders()
    {
        $customerId = Auth::guard('customer')->id();
        $orders = Order::with('orderStatus')
            ->where('customer_id', $customerId)
            ->latest('id')
            ->paginate(10);

        return \theme_view('customer.orders', compact('orders'));
    }

    /**
     * Display order details page.
     * Eager-loads orderStatus, products, and selected options.
     */
    public function customerOrderDetail(int $id)
    {
        $customerId = Auth::guard('customer')->id();
        $order = Order::with(['orderStatus', 'items.product', 'items.options'])
            ->where('id', $id)
            ->where('customer_id', $customerId)
            ->firstOrFail();

        $orderItems = $order->items;

        return \theme_view('customer.order-details', compact('order', 'orderItems'));
    }

    /**
     * Display a printable invoice for a specific order.
     */
    public function orderInvoice(int $id)
    {
        $customerId = Auth::guard('customer')->id();
        $order = Order::with(['orderStatus', 'items.product.images', 'items.options'])
            ->where('id', $id)
            ->where('customer_id', $customerId)
            ->firstOrFail();

        $orderItems = $order->items;

        return \theme_view('customer.invoice', compact('order', 'orderItems'));
    }

    /**
     * Display the customer profile edit form.
     */
    public function customerProfile()
    {
        $customer = Auth::guard('customer')->user();
        return \theme_view('customer.profile', compact('customer'));
    }

    /**
     * Handle profile update (personal info + optional password change).
     * Automatically cleans up old profile picture from disk to prevent storage bloat.
     */
    public function updateProfile(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'firstname'        => 'required|string|max:64',
            'lastname'         => 'required|string|max:64',
            'email'            => 'required|email|max:96|unique:customers,email,' . $customer->id,
            'phone'            => 'nullable|string|max:32',
            'current_password' => 'required_with:new_password',
            'new_password'     => 'nullable|string|min:6|confirmed',
            'pic'              => 'nullable|image|max:2048',
        ]);

        $customer->firstname = trim($request->firstname);
        $customer->lastname  = trim($request->lastname);
        $customer->email     = Str::lower(trim($request->email));
        $customer->phone     = $request->phone;

        // Change password if provided
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $customer->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
            }
            $customer->password = Hash::make($request->new_password);
        }

        // Upload profile picture and clean up previous image
        if ($request->hasFile('pic')) {
            if ($customer->pic && Storage::disk('public')->exists($customer->pic)) {
                Storage::disk('public')->delete($customer->pic);
            }
            $customer->pic = $request->file('pic')->store('customers/pics', 'public');
        }

        $customer->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Display customer wallet page.
     * Filters payment methods to only show active ones.
     */
    public function customerWallet()
    {
        $customer = Auth::guard('customer')->user();
        $fundRequests = FundRequest::with('paymentMethod')
            ->where('customer_id', $customer->id)
            ->latest('id')
            ->paginate(15);
        $paymentMethods = PaymentMethod::active()->get();

        return \theme_view('customer.wallet', compact('customer', 'fundRequests', 'paymentMethods'));
    }

    /**
     * Handle adding funds (wallet deposit request).
     * Validates that payment_method_id actually exists in payment_methods table.
     */
    public function customerAddFund(Request $request)
    {
        $customerId = Auth::guard('customer')->id();

        $request->validate([
            'amount'            => 'required|numeric|min:1',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'notes'             => 'nullable|string|max:255',
        ]);

        FundRequest::create([
            'customer_id'       => $customerId,
            'amount'            => $request->amount,
            'payment_method_id' => $request->payment_method_id,
            'notes'             => $request->notes,
            'status'            => 0,
        ]);

        return back()->with('success', true)->with('message', 'Your deposit request of $' . number_format($request->amount, 2) . ' has been submitted for review.');
    }

    /**
     * Display customer ledger statement page.
     */
    public function customerLedger()
    {
        $customer = Auth::guard('customer')->user();
        $ledgers = CustomerLedger::where('customer_id', $customer->id)
            ->latest('id')
            ->paginate(15);

        return \theme_view('customer.ledger', compact('customer', 'ledgers'));
    }

    /**
     * Display customer point history page.
     */
    public function customerPoints()
    {
        $customer = Auth::guard('customer')->user();
        $points = CustomerPointHistory::where('customer_id', $customer->id)
            ->latest('id')
            ->paginate(15);

        return \theme_view('customer.points', compact('customer', 'points'));
    }

    /**
     * Toggle product in/out of customer's persistent wishlist.
     */
    public function toggleWishlist(Request $request)
    {
        $productId = (int) $request->product_id;
        if (!$productId) {
            return response()->json(['success' => false, 'message' => 'Invalid product.'], 400);
        }

        $customer = Auth::guard('customer')->user();
        $list = json_decode($customer->wishlist ?? '[]', true) ?: [];

        if (in_array($productId, $list)) {
            $list = array_values(array_diff($list, [$productId]));
            $added = false;
            $msg = 'Removed from wishlist.';
        } else {
            $list[] = $productId;
            $added = true;
            $msg = 'Added to wishlist!';
        }

        $customer->wishlist = json_encode($list);
        $customer->save();

        return response()->json([
            'success'        => true,
            'added'          => $added,
            'message'        => $msg,
            'wishlist_count' => count($list),
        ]);
    }
}
