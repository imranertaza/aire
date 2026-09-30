<?php

namespace App\Listeners;

use App\Events\OrderStatusUpdated;
use App\Services\Mail\OrderMailService;
use Illuminate\Support\Facades\Log;

class SendOrderStatusUpdateNotification
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
    public function handle(OrderStatusUpdated $event): array
    {
        if (! $event->notifyCustomer) {
            return ['customer_sent' => false, 'skipped' => true];
        }

        try {
            $sent = $this->mailService->sendOrderStatusUpdate($event->order, $event->statusName, $event->comment);
            return ['customer_sent' => $sent];
        } catch (\Throwable $e) {
            Log::error('SendOrderStatusUpdateNotification listener failed: ' . $e->getMessage(), [
                'order_id' => $event->order->id,
            ]);
            return ['customer_sent' => false, 'error' => $e->getMessage()];
        }
    }
}
