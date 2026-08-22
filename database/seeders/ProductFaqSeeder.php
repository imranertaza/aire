<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductFaq;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductFaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->info('No products found to seed FAQs for.');
            return;
        }

        // Clean existing FAQs
        DB::table('product_faqs')->truncate();

        $faqTemplates = [
            [
                'question'   => 'How often should the HEPA H13/H14 filter be replaced?',
                'answer'     => 'Under standard indoor operating conditions, the medical-grade HEPA filter should be replaced every 6 to 12 months (or approximately 2,000–3,000 active runtime hours). The onboard sensor and companion mobile app will notify you when filter health reaches 10%.',
                'sort_order' => 1,
            ],
            [
                'question'   => 'What is the noise level during sleep or low-power mode?',
                'answer'     => 'Engineered with aerodynamic acoustic dampening and a precision DC motor, the unit operates at an ultra-quiet 21–24 dB in Night Mode—quieter than a whisper—ensuring undisturbed sleep with all status indicator lights automatically dimmed.',
                'sort_order' => 2,
            ],
            [
                'question'   => 'Does this system support Wi-Fi, Bluetooth, and Smart Home integrations?',
                'answer'     => 'Yes. It features dual-band Wi-Fi and Bluetooth 5.2 connectivity. You can monitor live PM2.5, VOC, temperature, and humidity levels through the AIRE iOS/Android app, and integrate with Apple HomeKit, Google Assistant, and Amazon Alexa.',
                'sort_order' => 3,
            ],
            [
                'question'   => 'How do I clean and maintain the pre-filter and internal sensors?',
                'answer'     => 'The outermost mesh pre-filter is washable and should be vacuumed or rinsed under lukewarm water once every 2–4 weeks. The laser particulate sensor can be cleaned by gently wiping the sensor lens with a dry cotton swab every 3 months.',
                'sort_order' => 4,
            ],
            [
                'question'   => 'What is the power consumption and energy efficiency rating?',
                'answer'     => 'The system consumes between 6W in Sleep Mode and up to 45W at maximum turbo output. It is Energy Star certified and designed for continuous 24/7 operation with minimal monthly electricity cost.',
                'sort_order' => 5,
            ],
        ];

        foreach ($products as $product) {
            $productFaqs = [];
            foreach ($faqTemplates as $tmpl) {
                $productFaqs[] = [
                    'product_id' => $product->id,
                    'question'   => str_replace('this system', $product->name, $tmpl['question']),
                    'answer'     => str_replace('the unit', $product->name, $tmpl['answer']),
                    'sort_order' => $tmpl['sort_order'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            ProductFaq::insert($productFaqs);
        }

        $this->command->info("Successfully seeded FAQs for {$products->count()} products.");
    }
}