<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_no')->default(0)->comment('Invoice Number');
            $table->integer('store_id')->default(0)->comment('Associated Store ID');
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete()->comment('Associated Customer ID');
            $table->string('firstname', 32)->nullable()->comment('Customer First Name');
            $table->string('lastname', 32)->nullable()->comment('Customer Last Name');
            $table->string('email', 96)->nullable()->comment('Customer Email');
            $table->string('telephone', 32)->nullable()->comment('Customer Telephone');
            $table->string('payment_firstname', 32)->comment('Payment First Name');
            $table->string('payment_lastname', 32)->comment('Payment Last Name');
            $table->string('payment_address_1', 128)->comment('Payment Address Line 1');
            $table->string('payment_address_2', 128)->comment('Payment Address Line 2');
            $table->string('payment_city', 128)->comment('Payment City');
            $table->string('payment_postcode', 10)->comment('Payment Postcode');
            $table->string('payment_country', 128)->nullable()->comment('Payment Country');
            $table->integer('payment_country_id')->comment('Payment Country ID');
            $table->string('payment_phone', 32)->comment('Payment Phone Number');
            $table->string('payment_email', 255)->comment('Payment Email');
            $table->string('payment_method', 128)->comment('Selected Payment Method');
            $table->string('payment_transection_code', 128)->nullable()->comment('Transaction ID/Code');
            $table->string('shipping_firstname', 32)->nullable()->comment('Shipping Recipient First Name');
            $table->string('shipping_lastname', 32)->nullable()->comment('Shipping Recipient Last Name');
            $table->string('shipping_address_1', 128)->nullable()->comment('Shipping Address Line 1');
            $table->string('shipping_address_2', 128)->nullable()->comment('Shipping Address Line 2');
            $table->string('shipping_city', 128)->nullable()->comment('Shipping City');
            $table->string('shipping_postcode', 10)->nullable()->comment('Shipping Postcode');
            $table->string('shipping_country', 128)->nullable()->comment('Shipping Country');
            $table->integer('shipping_country_id')->nullable()->comment('Shipping Country ID');
            $table->string('shipping_phone', 32)->nullable()->comment('Shipping Phone Number');
            $table->string('shipping_method', 128)->nullable()->comment('Selected Shipping Method');
            $table->decimal('shipping_charge', 10, 4)->nullable()->comment('Shipping Cost Charge');
            $table->mediumText('comment')->nullable()->comment('Order Checkout Comment');
            $table->decimal('total', 15, 4)->default(0.0000)->comment('Order Total Cost before tax/discount');
            $table->double('total_point')->nullable()->comment('Loyalty Points Earned/Used');
            $table->integer('vat')->comment('VAT Percentage');
            $table->decimal('discount', 10, 4)->nullable()->comment('Applied Discount Amount');
            $table->decimal('final_amount', 10, 4)->comment('Grand Total Final Amount Paid');
            $table->tinyInteger('status')->default(1)->comment('Order Status ID. 1: Pending, 2: Processing, 3: Shipped, 5: Complete, 7: Canceled, 8: Denied, 9: Canceled Reversal, 10: Failed, 11: Refunded, 12: Reversed, 13: Chargeback, 14: Expired, 15: Processed, 16: Voided');
            $table->enum('payment_status', ['Pending', 'Paid', 'Failed'])->default('Pending')->comment('Payment Process Status');
            $table->string('PM_transaction_id', 100)->nullable()->comment('Payment Gateway Reference Transaction ID');
            $table->string('ip', 40)->comment('Checkout IP Address');
            $table->unsignedBigInteger('createdBy')->nullable();
            $table->unsignedBigInteger('updatedBy')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('customer_id');
            $table->index('status');
            $table->index('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
