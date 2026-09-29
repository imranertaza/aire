<?php

namespace App\Services\Coupon;

use App\Models\Coupon;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CouponService
{
    /**
     * Get currently applied coupon from session.
     */
    public function getAppliedCoupon(): ?Coupon
    {
        return session()->get('applied_coupon');
    }

    /**
     * Validate and apply coupon code to session.
     */
    public function validateAndApply(string $code, float $subtotal = 0.00): array
    {
        $code = trim($code);

        if (empty($code)) {
            return [
                'success' => false,
                'message' => 'Please enter a valid coupon code.',
            ];
        }

        $today = date('Y-m-d');
        $coupon = Coupon::where('code', $code)
            ->where('status', 1)
            ->where(function ($q) use ($today) {
                $q->whereNull('date_start')->orWhere('date_start', '<=', $today);
            })
            ->where(function ($q) use ($today) {
                $q->whereNull('date_end')->orWhere('date_end', '>=', $today);
            })
            ->first();

        if (!$coupon) {
            return [
                'success' => false,
                'message' => 'Invalid or expired coupon code.',
            ];
        }

        if ($coupon->total_useable !== null && $coupon->total_used >= $coupon->total_useable) {
            return [
                'success' => false,
                'message' => 'This coupon has reached its usage limit.',
            ];
        }

        $customerId = Auth::guard('customer')->id();

        if ($coupon->for_registered_user == 1 && !$customerId) {
            return [
                'success' => false,
                'message' => 'This coupon requires a registered customer account.',
            ];
        }

        if ($customerId) {
            $alreadyUsed = Order::where('customer_id', $customerId)
                ->where('comment', 'like', '%Coupon: ' . $code . '%')
                ->exists();

            if ($alreadyUsed) {
                return [
                    'success' => false,
                    'message' => 'You have already used this coupon code.',
                ];
            }
        }

        session()->put('applied_coupon', $coupon);
        $discount = $this->calculateDiscount($subtotal, 0.00, $coupon);

        return [
            'success'  => true,
            'message'  => 'Coupon code applied successfully!',
            'discount' => $discount,
            'coupon'   => $coupon,
        ];
    }

    /**
     * Remove applied coupon from session.
     */
    public function remove(): void
    {
        session()->forget('applied_coupon');
    }

    /**
     * Compute coupon discount amount.
     */
    public function calculateDiscount(float $subtotal, float $shippingCharge = 0.00, ?Coupon $coupon = null): float
    {
        $coupon = $coupon ?? $this->getAppliedCoupon();

        if (!$coupon) {
            return 0.00;
        }

        $discount = 0.00;

        if ($coupon->discount_on == 1) { // Product
            if ($coupon->discount_type == 1) { // Percentage
                $discount = $subtotal * ($coupon->discount / 100);
            } else { // Flat
                $discount = (float) $coupon->discount;
            }
        } else { // Shipping
            if ($coupon->discount_type == 1) {
                $discount = $shippingCharge * ($coupon->discount / 100);
            } else {
                $discount = (float) $coupon->discount;
            }
            if ($discount > $shippingCharge) {
                $discount = $shippingCharge;
            }
        }

        return (float) min($discount, $subtotal + $shippingCharge);
    }

    /**
     * Increment coupon total used count when order is placed.
     */
    public function incrementUsage(?Coupon $coupon = null): void
    {
        $coupon = $coupon ?? $this->getAppliedCoupon();
        if ($coupon) {
            $coupon->increment('total_used');
        }
    }
}
