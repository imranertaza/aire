<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Services\Mail\OrderMailService;
use Illuminate\Support\Facades\Log;

class SendOrderPlacedNotification
{
    protected OrderMailService $mailService;

    /**
     * Create the event listener.
     */
    public function __construct(OrderMailService $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * Handle the event.
     */
    public function handle(OrderPlaced $event): array
    {
        try {
            return $this->mailService->sendOrderConfirmation($event->order);
        } catch (\Throwable $e) {
            Log::error('SendOrderPlacedNotification listener failed: ' . $e->getMessage(), [
                'order_id' => $event->order->id,
            ]);
            return [
                'customer_sent' => false,
                'admin_sent'    => false,
                'error'         => $e->getMessage(),
            ];
        }
    }
}
