<?php

namespace App\Services\Customer;

use App\Models\Customer;
use App\Models\FundRequest;
use App\Services\Common\FileUploadService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CustomerProfileService
{
    public function __construct(
        protected FileUploadService $fileUploader
    ) {}
    /**
     * Get filtered, searched, and sorted paginated orders for a customer.
     *
     * @param Customer $customer
     * @param array $filters ['search' => ?string, 'status' => ?string, 'sort' => ?string, 'date' => ?string]
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getCustomerOrders(Customer $customer, array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = $customer->orders()->with(['orderStatus', 'items.product']);

        // Search by Order ID, Formatted Code (AIR-000105), Shipping details, or Product Name
        if (! empty($filters['search'])) {
            $search = trim((string) $filters['search']);
            $extractedId = preg_replace('/^(?:AIR-|ORD-|#)\s*/i', '', $search);

            $query->where(function ($q) use ($search, $extractedId) {
                if (is_numeric($extractedId)) {
                    $q->where('id', (int) $extractedId);
                } else {
                    $q->where('shipping_firstname', 'like', "%{$search}%")
                        ->orWhere('shipping_lastname', 'like', "%{$search}%")
                        ->orWhere('shipping_city', 'like', "%{$search}%")
                        ->orWhere('shipping_address_1', 'like', "%{$search}%")
                        ->orWhereHas('items', function ($iq) use ($search) {
                            $iq->where('name', 'like', "%{$search}%")
                                ->orWhereHas('product', function ($pq) use ($search) {
                                    $pq->where('name', 'like', "%{$search}%");
                                });
                        });
                }
            });
        }

        // Filter by Order Status ID
        if (! empty($filters['status']) && $filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        // Filter by Date period using Carbon
        if (! empty($filters['date']) && $filters['date'] !== 'all') {
            match ($filters['date']) {
                'today'         => $query->whereDate('created_at', Carbon::today()),
                'last_7_days'   => $query->where('created_at', '>=', Carbon::now()->subDays(7)->startOfDay()),
                'last_30_days'  => $query->where('created_at', '>=', Carbon::now()->subDays(30)->startOfDay()),
                'last_6_months' => $query->where('created_at', '>=', Carbon::now()->subMonths(6)->startOfDay()),
                'this_year'     => $query->whereYear('created_at', '=', Carbon::now()->year),
                default         => null,
            };
        }

        // Sorting
        $sort = $filters['sort'] ?? 'latest';
        match ($sort) {
            'oldest'     => $query->orderBy('id', 'asc'),
            'total_high' => $query->orderBy('total', 'desc'),
            'total_low'  => $query->orderBy('total', 'asc'),
            default      => $query->latest('id'),
        };

        return $query->paginate($perPage)->withQueryString();
    }
    /**
     * Update customer personal profile, password, and avatar image.
     *
     * @param Customer $customer
     * @param array $data
     * @param UploadedFile|null $pic
     * @throws ValidationException
     * @return void
     */
    public function updateProfile(Customer $customer, array $data, ?UploadedFile $pic = null): void
    {
        $customer->firstname = $data['firstname'];
        $customer->lastname  = $data['lastname'];
        $customer->email     = $data['email'];
        $customer->phone     = $data['phone'] ?? null;

        // Verify and change password if new_password is provided
        if (! empty($data['new_password'])) {
            if (! Hash::check($data['current_password'] ?? '', $customer->password)) {
                throw ValidationException::withMessages([
                    'current_password' => 'Current password is incorrect.',
                ]);
            }

            $customer->password = Hash::make($data['new_password']);
        }

        // Upload new picture and safely replace previous image in customer-scoped directory
        if ($pic instanceof UploadedFile) {
            $customer->pic = $this->fileUploader->replace(
                newFile: $pic,
                directory: "customers/{$customer->id}/avatar",
                oldPath: $customer->pic,
                customFilename: "avatar-{$customer->id}-" . time()
            );
        }

        $customer->save();
    }

    /**
     * Submit a new wallet fund deposit request for admin review.
     *
     * @param Customer $customer
     * @param array $data
     * @return FundRequest
     */
    public function createFundRequest(Customer $customer, array $data): FundRequest
    {
        return FundRequest::create([
            'customer_id'       => $customer->id,
            'amount'            => $data['amount'],
            'payment_method_id' => $data['payment_method_id'],
            'notes'             => $data['notes'] ?? null,
            'status'            => 'Pending',
        ]);
    }

    /**
     * Toggle a product in/out of the customer's persistent wishlist.
     *
     * @param Customer $customer
     * @param int $productId
     * @return array{added: bool, message: string, wishlist_count: int}
     */
    public function toggleWishlist(Customer $customer, int $productId): array
    {
        $list = json_decode((string) ($customer->wishlist ?? '[]'), true) ?: [];

        if (in_array($productId, $list, true)) {
            $list = array_values(array_diff($list, [$productId]));
            $added = false;
            $message = 'Removed from wishlist.';
        } else {
            $list[] = $productId;
            $added = true;
            $message = 'Added to wishlist!';
        }

        $customer->wishlist = json_encode($list);
        $customer->save();

        session()->put('favorites', $list);

        return [
            'added'          => $added,
            'is_favorite'    => $added,
            'message'        => $message,
            'count'          => count($list),
            'favorites_count'=> count($list),
            'wishlist_count' => count($list),
        ];
    }
}
