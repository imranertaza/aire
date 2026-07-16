<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductFeedback;
use Illuminate\Database\Seeder;

class ProductFeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if we have products and customers
        $product = Product::first();
        
        // If no product exists, we can't seed product feedback
        if (!$product) {
            return;
        }

        $customer = Customer::first();
        if (!$customer) {
            $customer = Customer::create([
                'firstname' => 'John',
                'lastname' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone' => '1234567890',
                'password' => bcrypt('password'),
                'salt' => '123',
                'ip' => '127.0.0.1',
                'status' => 1,
            ]);
        }

        $feedbacks = [
            [
                'product_id' => $product->id,
                'customer_id' => $customer->id,
                'feedback_star' => 5,
                'feedback_text' => 'This product is absolutely amazing! Highly recommended.',
                'status' => 1,
            ],
            [
                'product_id' => $product->id,
                'customer_id' => $customer->id,
                'feedback_star' => 4,
                'feedback_text' => 'Good product, but shipping was a bit slow.',
                'status' => 1,
            ],
            [
                'product_id' => $product->id,
                'customer_id' => $customer->id,
                'feedback_star' => 3,
                'feedback_text' => 'Average product. It works fine but the quality could be better.',
                'status' => 0,
            ],
        ];

        foreach ($feedbacks as $fb) {
            ProductFeedback::create($fb);
        }
    }
}
