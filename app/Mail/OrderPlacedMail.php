<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPlacedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public bool $isAdminNotification;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     * @param bool  $isAdminNotification
     */
    public function __construct(Order $order, bool $isAdminNotification = false)
    {
        $this->order = $order;
        $this->isAdminNotification = $isAdminNotification;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $storeName = Setting::get('brand_name', Setting::get('store_name', config('app.name', 'Aire')));
        $fromEmail = Setting::get('send_from') ?: (Setting::get('mail_address') ?: (Setting::get('email') ?: config('mail.from.address')));

        if ($this->isAdminNotification) {
            $subject = "[New Order] Order #{$this->order->id} placed by {$this->order->firstname} {$this->order->lastname} - {$storeName}";
        } else {
            $subject = "Order Confirmation - Order #{$this->order->id} - {$storeName}";
        }

        return new Envelope(
            from: new \Illuminate\Mail\Mailables\Address($fromEmail, $storeName),
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $storeName = Setting::get('brand_name', Setting::get('store_name', config('app.name', 'Aire')));
        $storeEmail = Setting::get('send_from') ?: (Setting::get('mail_address') ?: (Setting::get('email') ?: config('mail.from.address')));
        $storePhone = Setting::get('phone', '');
        $storeAddress = Setting::get('address', '');
        $currency = Setting::get('currency_symbol', '$');

        return new Content(
            view: 'emails.order-placed',
            with: [
                'order'               => $this->order,
                'isAdminNotification' => $this->isAdminNotification,
                'storeName'           => $storeName,
                'storeEmail'          => $storeEmail,
                'storePhone'          => $storePhone,
                'storeAddress'        => $storeAddress,
                'currency'            => $currency,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
