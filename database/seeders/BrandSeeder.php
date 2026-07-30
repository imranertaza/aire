<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;
class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name'       => 'Apple',
                'image'      => 'https://placehold.co/300x150?text=Apple',
                'alt_name'   => 'Apple Inc',
                'status'     => 1,
                'sort_order' => 1,
                'createdBy'  => 1,
            ],
            [
                'name'       => 'Samsung',
                'image'      => 'https://placehold.co/300x150?text=Samsung',
                'alt_name'   => 'Samsung Electronics',
                'status'     => 1,
                'sort_order' => 2,
                'createdBy'  => 1,
            ],
            [
                'name'       => 'Xiaomi',
                'image'      => 'https://placehold.co/300x150?text=Xiaomi',
                'alt_name'   => 'Mi',
                'status'     => 1,
                'sort_order' => 3,
                'createdBy'  => 1,
            ],
            [
                'name'       => 'Huawei',
                'image'      => 'https://placehold.co/300x150?text=Huawei',
                'alt_name'   => null,
                'status'     => 0,
                'sort_order' => 4,
                'createdBy'  => 1,
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
