<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public Customer $customer;
    public string $resetUrl;
    public string $token;

    /**
     * Create a new message instance.
     *
     * @param Customer $customer
     * @param string   $resetUrl
     * @param string   $token
     */
    public function __construct(Customer $customer, string $resetUrl, string $token)
    {
        $this->customer = $customer;
        $this->resetUrl = $resetUrl;
        $this->token = $token;
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
            subject: "Password Reset Request - {$storeName}",
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

        return new Content(
            view: 'emails.customer-reset-password',
            with: [
                'customer'     => $this->customer,
                'resetUrl'     => $this->resetUrl,
                'token'        => $this->token,
                'storeName'    => $storeName,
                'storeEmail'   => $storeEmail,
                'storePhone'   => $storePhone,
                'storeAddress' => $storeAddress,
                'expireMinutes'=> config('auth.passwords.customers.expire', 60),
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
