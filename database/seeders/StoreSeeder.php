<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Store::create([
            'name'        => 'Main Store',
            'description' => 'Primary store location and default store for the system.',
            'is_default'  => 1,
            'createdBy'   => 1,
            'updatedBy'   => 1,
        ]);
    }
}
