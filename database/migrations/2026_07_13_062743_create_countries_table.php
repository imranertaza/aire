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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128);
            $table->string('iso_code_2', 2)->index();
            $table->string('iso_code_3', 3)->index();
            $table->mediumText('address_format')->nullable();
            $table->boolean('postcode_required')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }
//     INSERT INTO countries (id, name, iso_code_2, iso_code_3, address_format, postcode_required, status, created_at)
// SELECT country_id, name, iso_code_2, iso_code_3, address_format, postcode_required, status, NOW()
// FROM cc_country;

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
