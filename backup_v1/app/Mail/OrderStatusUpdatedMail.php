<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public string $statusName;
    public ?string $comment;

    /**
     * Create a new message instance.
     *
     * @param Order       $order
     * @param string      $statusName
     * @param string|null $comment
     */
    public function __construct(Order $order, string $statusName, ?string $comment = null)
    {
        $this->order = $order;
        $this->statusName = $statusName;
        $this->comment = $comment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $storeName = Setting::get('brand_name', Setting::get('store_name', config('app.name', 'Aire')));
        $fromEmail = Setting::get('send_from') ?: (Setting::get('mail_address') ?: (Setting::get('email') ?: config('mail.from.address')));

        return new Envelope(
            from: new \Illuminate\Mail\Mailables\Address($fromEmail, $storeName),
            subject: "Order #{$this->order->id} Status Updated: {$this->statusName} - {$storeName}",
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
        $currency = Setting::get('currency_symbol', '$');

        return new Content(
            view: 'emails.order-status-updated',
            with: [
                'order'        => $this->order,
                'statusName'   => $this->statusName,
                'comment'      => $this->comment,
                'storeName'    => $storeName,
                'storeEmail'   => $storeEmail,
                'storePhone'   => $storePhone,
                'currency'     => $currency,
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
