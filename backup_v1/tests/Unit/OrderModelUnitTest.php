<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\OrderItem;
use Tests\TestCase;

class OrderModelUnitTest extends TestCase
{
    public function test_order_number_accessor_formats_padded_string(): void
    {
        $order = new Order();
        $order->id = 42;

        $this->assertEquals('AIR-000042', $order->order_number);
    }

    public function test_order_number_accessor_handles_large_id(): void
    {
        $order = new Order();
        $order->id = 1234567;

        $this->assertEquals('AIR-1234567', $order->order_number);
    }

    public function test_order_item_total_accessor_calculates_price_times_quantity(): void
    {
        $item = new OrderItem([
            'price'    => 250.00,
            'quantity' => 3,
        ]);

        $this->assertEquals(750.00, $item->total);
    }

    public function test_order_item_total_accessor_prefers_final_price_if_set(): void
    {
        $item = new OrderItem([
            'price'       => 250.00,
            'quantity'    => 3,
            'total_price' => 750.00,
            'final_price' => 700.00, // with discount
        ]);

        $this->assertEquals(700.00, $item->total);
    }
}
