<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Order $order;
    public string $statusName;
    public ?string $comment;
    public bool $notifyCustomer;

    /**
     * Create a new event instance.
     *
     * @param Order       $order
     * @param string      $statusName
     * @param string|null $comment
     * @param bool        $notifyCustomer
     */
    public function __construct(Order $order, string $statusName, ?string $comment = null, bool $notifyCustomer = false)
    {
        $this->order = $order;
        $this->statusName = $statusName;
        $this->comment = $comment;
        $this->notifyCustomer = $notifyCustomer;
    }
}
