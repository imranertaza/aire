<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CustomerDashboardController extends Controller
{
    /**
     * Display customer dashboard.
     */
    public function dashboard()
    {
        $customer = Auth::guard('customer')->user();
        $orders = \App\Models\Order::where('customer_id', $customer->id)->latest()->get();

        return \theme_view('customer.dashboard', compact('customer', 'orders'));
    }

    /**
     * Display paginated orders list for the logged-in customer.
     */
    public function customerOrders()
    {
        $customerId = Auth::guard('customer')->id();
        $orders = \App\Models\Order::where('customer_id', $customerId)
            ->latest()
            ->paginate(10);

        return \theme_view('customer.orders', compact('orders'));
    }

    /**
     * Display order details page.
     */
    public function customerOrderDetail(int $id)
    {
        $customerId = Auth::guard('customer')->id();
        $order = \App\Models\Order::where('id', $id)
            ->where('customer_id', $customerId)
            ->firstOrFail();

        $orderItems = \App\Models\OrderItem::with(['product', 'options'])
            ->where('order_id', $order->id)
            ->get();

        return \theme_view('customer.order-details', compact('order', 'orderItems'));
    }

    /**
     * Display a printable invoice for a specific order.
     */
    public function orderInvoice(int $id)
    {
        $customerId = Auth::guard('customer')->id();
        $order = \App\Models\Order::where('id', $id)
            ->where('customer_id', $customerId)
            ->firstOrFail();

        $orderItems = \App\Models\OrderItem::with('product')
            ->where('order_id', $order->id)
            ->get();

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
     */
    public function updateProfile(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'firstname'   => 'required|string|max:64',
            'lastname'    => 'required|string|max:64',
            'email'       => 'required|email|max:96|unique:customers,email,' . $customer->id,
            'phone'       => 'nullable|string|max:32',
            'new_password'  => 'nullable|string|min:6|confirmed',
            'pic'         => 'nullable|image|max:2048',
        ]);

        $customer->firstname = $request->firstname;
        $customer->lastname  = $request->lastname;
        $customer->email     = $request->email;
        $customer->phone     = $request->phone;

        // Change password if provided
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $customer->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
            }
            $customer->password = Hash::make($request->new_password);
        }

        // Upload profile picture
        if ($request->hasFile('pic')) {
            $path = $request->file('pic')->store('customers/pics', 'public');
            $customer->pic = $path;
            session()->put('customer_pic', $path);
        }

        $customer->save();

        // Refresh session data for compatibility
        session()->put('customer_name', $customer->firstname . ' ' . $customer->lastname);
        session()->put('customer_email', $customer->email);

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Display customer wallet page.
     */
    public function customerWallet()
    {
        $customer = Auth::guard('customer')->user();
        $fundRequests = \App\Models\FundRequest::with('paymentMethod')
            ->where('customer_id', $customer->id)
            ->latest('id')
            ->get();
        $paymentMethods = \App\Models\PaymentMethod::all();

        return \theme_view('customer.wallet', compact('customer', 'fundRequests', 'paymentMethods'));
    }

    /**
     * Handle adding funds (wallet deposit request).
     */
    public function customerAddFund(Request $request)
    {
        $customerId = Auth::guard('customer')->id();

        $request->validate([
            'amount'            => 'required|numeric|min:1',
            'payment_method_id' => 'required',
            'notes'             => 'nullable|string|max:255',
        ]);

        \App\Models\FundRequest::create([
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
        $ledgers = \App\Models\CustomerLedger::where('customer_id', $customer->id)
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
        $points = \App\Models\CustomerPointHistory::where('customer_id', $customer->id)
            ->latest('id')
            ->paginate(15);

        return \theme_view('customer.points', compact('customer', 'points'));
    }
}
