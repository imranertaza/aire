<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Root Categories
        $electronics = ProductCategory::create([
            'parent_id'       => null,
            'category_name'   => 'Electronics',
            'description'     => 'All kinds of electronic devices and gadgets',
            'meta_title'      => 'Electronics',
            'meta_description' => 'Shop latest electronics and gadgets',
            'meta_keyword'    => 'electronics, gadgets, mobile, laptop',
            'image'           => 'https://placehold.co/600x400?text=Electronics',
            'alt_name'        => 'electronics',
            'header_menu'     => 1,
            'side_menu'       => 1,
            'sort_order'      => 1,
            'status'          => 1,
            'createdBy'       => 1,
            'updatedBy'       => 1,
        ]);

        $fashion = ProductCategory::create([
            'parent_id'       => null,
            'category_name'   => 'Fashion',
            'description'     => 'Clothing, footwear and accessories',
            'meta_title'      => 'Fashion & Apparel',
            'meta_description' => 'Trendy fashion and clothing collection',
            'meta_keyword'    => 'fashion, clothing, shoes, apparel',
            'image'           => 'https://placehold.co/600x400?text=Fashion',
            'alt_name'        => 'fashion',
            'header_menu'     => 1,
            'side_menu'       => 1,
            'sort_order'      => 2,
            'status'          => 1,
            'createdBy'       => 1,
            'updatedBy'       => 1,
        ]);

        // Child Categories
        ProductCategory::create([
            'parent_id'       => $electronics->id,
            'category_name'   => 'Smartphones',
            'description'     => 'Latest mobile phones and accessories',
            'meta_title'      => 'Smartphones',
            'meta_description' => 'Buy latest smartphones',
            'meta_keyword'    => 'mobile, smartphone, iphone, android',
            'image'           => 'https://placehold.co/600x400?text=Smartphones',
            'alt_name'        => 'smartphones',
            'header_menu'     => 0,
            'side_menu'       => 1,
            'sort_order'      => 1,
            'status'          => 1,
            'createdBy'       => 1,
            'updatedBy'       => 1,
        ]);

        ProductCategory::create([
            'parent_id'       => $electronics->id,
            'category_name'   => 'Laptops & Computers',
            'description'     => 'Laptops, desktops and computer accessories',
            'meta_title'      => 'Laptops & Computers',
            'meta_description' => 'Best laptops and computers',
            'meta_keyword'    => 'laptop, computer, notebook',
            'image'           => 'https://placehold.co/600x400?text=Laptops',
            'alt_name'        => 'laptops',
            'header_menu'     => 0,
            'side_menu'       => 1,
            'sort_order'      => 2,
            'status'          => 1,
            'createdBy'       => 1,
            'updatedBy'       => 1,
        ]);

        ProductCategory::create([
            'parent_id'       => $fashion->id,
            'category_name'   => 'Men\'s Clothing',
            'description'     => 'Fashion for men',
            'meta_title'      => 'Men\'s Clothing',
            'meta_description' => 'Stylish men fashion',
            'meta_keyword'    => 'mens fashion, shirts, jeans',
            'image'           => 'https://placehold.co/600x400?text=Mens+Clothing',
            'alt_name'        => 'mens-clothing',
            'header_menu'     => 0,
            'side_menu'       => 1,
            'sort_order'      => 1,
            'status'          => 1,
            'createdBy'       => 1,
            'updatedBy'       => 1,
        ]);
    }
}
