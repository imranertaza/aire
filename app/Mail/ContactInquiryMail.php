<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactInquiryMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public array $contactData;

    /**
     * Create a new message instance.
     *
     * @param array $contactData
     */
    public function __construct(array $contactData)
    {
        $this->contactData = $contactData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $storeName = Setting::get('brand_name', Setting::get('store_name', config('app.name', 'AIRE Industries')));
        $fromEmail = Setting::get('send_from') ?: (Setting::get('mail_address') ?: (Setting::get('email') ?: config('mail.from.address', 'noreply@aireindustries.com')));
        $subject = 'New Contact Inquiry: ' . (!empty($this->contactData['subject']) ? $this->contactData['subject'] : 'General Customer Inquiry');

        $replyTo = [];
        if (!empty($this->contactData['email'])) {
            $replyTo[] = new Address($this->contactData['email'], $this->contactData['name'] ?? 'Visitor');
        }

        return new Envelope(
            from: new Address($fromEmail, $storeName),
            replyTo: $replyTo,
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $storeName  = Setting::get('brand_name', Setting::get('store_name', config('app.name', 'AIRE Industries')));
        $storeEmail = Setting::get('email', config('mail.from.address', 'info@aireindustries.com'));
        $storePhone = Setting::get('phone', '');

        return new Content(
            view: 'emails.contact-inquiry',
            with: [
                'contact'    => $this->contactData,
                'storeName'  => $storeName,
                'storeEmail' => $storeEmail,
                'storePhone' => $storePhone,
                'submittedAt'=> now()->format('F j, Y \a\t g:i A (T)'),
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
