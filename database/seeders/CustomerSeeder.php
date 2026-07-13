<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $faker = Faker::create();
        $customers = [];

        for ($i = 0; $i < 5; $i++) {
            $customers[] = [
                'firstname'  => $faker->firstName(),
                'lastname'   => $faker->lastName(),
                'email'      => $faker->unique()->safeEmail(),
                // substr used just in case a localized phone string exceeds 32 chars
                'phone'      => substr($faker->e164PhoneNumber(), 0, 32), 
                'password'   => sha1('password123'), // 40 chars to fit your schema
                'balance'    => $faker->optional()->randomFloat(2, 0, 5000), // nullable
                'point'      => $faker->optional()->numberBetween(0, 1000),  // nullable
                'salt'       => Str::random(9),
                'wishlist'   => json_encode([$faker->numberBetween(1, 100), $faker->numberBetween(1, 100)]),
                'newsletter' => $faker->boolean(30), // 30% chance of being true
                'address_id' => $faker->numberBetween(1, 200),
                'ip'         => $faker->ipv4(),
                'status'     => $faker->boolean(80), // 80% chance of being active
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert in bulk for better performance
        DB::table('customers')->insert($customers);
    }
}
