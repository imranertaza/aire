<?php

namespace App\Services\Mail;

use App\Mail\OrderPlacedMail;
use App\Mail\OrderStatusUpdatedMail;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderMailService
{
    /**
     * Send order confirmation emails to both customer and store admin.
     *
     * @param Order $order
     * @return array [bool $customerSent, bool $adminSent]
     */
    public function sendOrderConfirmation(Order $order): array
    {
        $this->ensureRelationsLoaded($order);

        $customerSent = false;
        $adminSent = false;

        // 1. Send confirmation email to Customer
        $customerEmail = $order->email ?: $order->payment_email;
        if ($this->isValidEmail($customerEmail)) {
            try {
                Mail::to($customerEmail)->send(new OrderPlacedMail($order, false));
                $customerSent = true;
            } catch (\Throwable $e) {
                Log::error('OrderMailService: Failed to send customer confirmation email.', [
                    'order_id'  => $order->id,
                    'recipient' => $customerEmail,
                    'error'     => $e->getMessage(),
                ]);
            }
        }

        // 2. Send notification email to Store Admin
        $adminEmail = Setting::get('mail_address') ?: (Setting::get('email') ?: config('mail.from.address'));
        if ($this->isValidEmail($adminEmail)) {
            try {
                Mail::to($adminEmail)->send(new OrderPlacedMail($order, true));
                $adminSent = true;
            } catch (\Throwable $e) {
                Log::error('OrderMailService: Failed to send admin notification email.', [
                    'order_id'  => $order->id,
                    'recipient' => $adminEmail,
                    'error'     => $e->getMessage(),
                ]);
            }
        }

        return [
            'customer_sent' => $customerSent,
            'admin_sent'    => $adminSent,
        ];
    }

    /**
     * Send order status update notification to customer.
     *
     * @param Order       $order
     * @param string      $statusName
     * @param string|null $comment
     * @return bool
     */
    public function sendOrderStatusUpdate(Order $order, string $statusName, ?string $comment = null): bool
    {
        $this->ensureRelationsLoaded($order);

        $customerEmail = $order->email ?: $order->payment_email;
        if (! $this->isValidEmail($customerEmail)) {
            Log::warning('OrderMailService: Cannot send status update, customer email is invalid.', [
                'order_id' => $order->id,
                'email'    => $customerEmail,
            ]);
            return false;
        }

        try {
            Mail::to($customerEmail)->send(new OrderStatusUpdatedMail($order, $statusName, $comment));
            return true;
        } catch (\Throwable $e) {
            Log::error('OrderMailService: Failed to send order status update email.', [
                'order_id'  => $order->id,
                'recipient' => $customerEmail,
                'status'    => $statusName,
                'error'     => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Send a diagnostic test email to verify SMTP delivery.
     *
     * @param string $recipientEmail
     * @param string $type 'placed' | 'status' | 'raw'
     * @return array
     */
    public function sendTestEmail(string $recipientEmail, string $type = 'placed'): array
    {
        if (! $this->isValidEmail($recipientEmail)) {
            return [
                'success' => false,
                'message' => 'Invalid recipient email address.',
            ];
        }

        $storeName = Setting::get('brand_name', Setting::get('store_name', config('app.name', 'Aire')));
        $fromEmail = Setting::get('send_from') ?: (Setting::get('mail_address') ?: (Setting::get('email') ?: config('mail.from.address')));
        $order = Order::with(['items.product', 'items.options', 'orderStatus'])->latest()->first();

        try {
            if ($type === 'status' && $order) {
                Mail::to($recipientEmail)->send(
                    new OrderStatusUpdatedMail($order, 'Processing', 'This is a verified test notification sent from the Store Admin Panel.')
                );
                $mailType = "OrderStatusUpdatedMail (Order #{$order->id} -> Processing)";
            } elseif ($order && $type !== 'raw') {
                Mail::to($recipientEmail)->send(new OrderPlacedMail($order, false));
                $mailType = "OrderPlacedMail (Order #{$order->id})";
            } else {
                Mail::raw("Hello,\n\nThis is a verified diagnostic test email sent from {$storeName} to confirm SMTP mail delivery.\n\nBest regards,\n{$storeName}", function ($msg) use ($recipientEmail, $fromEmail, $storeName) {
                    $msg->to($recipientEmail)->from($fromEmail, $storeName)->subject("Test Email from {$storeName}");
                });
                $mailType = 'Raw Diagnostic Email';
            }

            return [
                'success'   => true,
                'message'   => "Test email successfully delivered to {$recipientEmail}!",
                'mail_type' => $mailType,
                'mailer'    => config('mail.default'),
                'smtp_host' => config('mail.mailers.smtp.host'),
                'smtp_port' => config('mail.mailers.smtp.port'),
                'from'      => $fromEmail,
            ];
        } catch (\Throwable $e) {
            return [
                'success'   => false,
                'message'   => $e->getMessage(),
                'error'     => $e->getMessage(),
                'mailer'    => config('mail.default'),
                'smtp_host' => config('mail.mailers.smtp.host'),
                'smtp_port' => config('mail.mailers.smtp.port'),
            ];
        }
    }

    /**
     * Ensure critical relationships are loaded on the Order model.
     *
     * @param Order $order
     * @return void
     */
    protected function ensureRelationsLoaded(Order $order): void
    {
        $relations = [];
        if (! $order->relationLoaded('items')) {
            $relations[] = 'items.product';
            $relations[] = 'items.options';
        }
        if (! $order->relationLoaded('orderStatus')) {
            $relations[] = 'orderStatus';
        }

        if (! empty($relations)) {
            $order->load($relations);
        }
    }

    /**
     * Validate an email address format.
     *
     * @param string|null $email
     * @return bool
     */
    protected function isValidEmail(?string $email): bool
    {
        return ! empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
