<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\CustomerAddFundRequest;
use App\Http\Requests\Customer\CustomerProfileUpdateRequest;
use App\Http\Requests\Product\ProductActionRequest;
use App\Models\Customer;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use App\Services\Customer\CustomerProfileService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerDashboardController extends Controller
{
    public function __construct(
        protected CustomerProfileService $profileService
    ) {}

    /**
     * Display customer dashboard.
     * Eager-loads orderStatus to prevent N+1 queries and limits to 5 recent orders.
     */
    public function dashboard(): View
    {
        $customer = $this->currentCustomer();
        $orders = $customer->orders()
            ->with('orderStatus')
            ->latest('id')
            ->limit(5)
            ->get();

        return \theme_view('customer.dashboard', compact('customer', 'orders'));
    }

    /**
     * Display paginated, searchable, filterable, and sortable orders list for the logged-in customer.
     */
    public function customerOrders(Request $request): View
    {
        $customer = $this->currentCustomer();
        $filters = [
            'search' => $request->query('search'),
            'status' => $request->query('status'),
            'sort'   => $request->query('sort', 'latest'),
            'date'   => $request->query('date'),
        ];

        $orders = $this->profileService->getCustomerOrders($customer, $filters, 10);
        $orderStatuses = OrderStatus::all();

        return \theme_view('customer.orders', compact('customer', 'orders', 'orderStatuses', 'filters'));
    }

    /**
     * Display order details page.
     * Eager-loads orderStatus, products, and selected options.
     */
    public function customerOrderDetail(int $id): View
    {
        $customer = $this->currentCustomer();
        $order = $customer->orders()
            ->with(['orderStatus', 'items.product', 'items.options'])
            ->where('id', $id)
            ->firstOrFail();

        $orderItems = $order->items;

        return \theme_view('customer.order-details', compact('order', 'orderItems'));
    }

    /**
     * Display a printable invoice for a specific order.
     */
    public function orderInvoice(int $id): View
    {
        $customer = $this->currentCustomer();
        $order = $customer->orders()
            ->with(['orderStatus', 'items.product.images', 'items.options'])
            ->where('id', $id)
            ->firstOrFail();

        $orderItems = $order->items;

        return \theme_view('customer.invoice', compact('order', 'orderItems'));
    }

    /**
     * Display the customer profile edit form.
     */
    public function customerProfile(): View
    {
        $customer = $this->currentCustomer();

        return \theme_view('customer.profile', compact('customer'));
    }

    /**
     * Handle profile update (personal info, avatar upload, and optional password change).
     */
    public function updateProfile(CustomerProfileUpdateRequest $request): RedirectResponse
    {
        $customer = $this->currentCustomer();

        $this->profileService->updateProfile(
            customer: $customer,
            data: $request->validated(),
            pic: $request->file('pic')
        );

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Display customer wallet page.
     * Filters payment methods to only show active ones.
     */
    public function customerWallet(): View
    {
        $customer = $this->currentCustomer();
        $fundRequests = $customer->fundRequests()
            ->with('paymentMethod')
            ->latest('id')
            ->paginate(15);

        $paymentMethods = PaymentMethod::active()->get();

        return \theme_view('customer.wallet', compact('customer', 'fundRequests', 'paymentMethods'));
    }

    /**
     * Handle adding funds (wallet deposit request).
     */
    public function customerAddFund(CustomerAddFundRequest $request): RedirectResponse
    {
        $customer = $this->currentCustomer();

        $this->profileService->createFundRequest(
            customer: $customer,
            data: $request->validated()
        );

        return back()
            ->with('success', true)
            ->with('message', 'Your deposit request of $' . number_format($request->amount, 2) . ' has been submitted for review.');
    }

    /**
     * Display customer ledger statement page.
     */
    public function customerLedger(): View
    {
        $customer = $this->currentCustomer();
        $ledgers = $customer->ledgers()
            ->latest('id')
            ->paginate(15);

        return \theme_view('customer.ledger', compact('customer', 'ledgers'));
    }

    /**
     * Display customer point history page.
     */
    public function customerPoints(): View
    {
        $customer = $this->currentCustomer();
        $points = $customer->points()
            ->latest('id')
            ->paginate(15);

        return \theme_view('customer.points', compact('customer', 'points'));
    }

    /**
     * Toggle product in/out of customer's persistent wishlist.
     */
    public function toggleWishlist(ProductActionRequest $request): JsonResponse
    {
        $productId = (int) $request->validated('product_id');
        $customer = $this->currentCustomer();
        $result = $this->profileService->toggleWishlist($customer, $productId);

        return response()->json(array_merge(['success' => true], $result));
    }

    /**
     * Retrieve the currently authenticated customer instance.
     */
    protected function currentCustomer(): Customer
    {
        /** @var Customer $customer */
        $customer = Auth::guard('customer')->user();

        return $customer;
    }
}
