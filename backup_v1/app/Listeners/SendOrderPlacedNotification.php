<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Services\Mail\OrderMailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendOrderPlacedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * The number of times the queued listener may be attempted.
     */
    public int $tries = 3;

    /**
     * Create the event listener.
     */
    public function __construct(
        protected OrderMailService $mailService
    ) {}

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
