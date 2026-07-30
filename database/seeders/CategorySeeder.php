<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{

    public function run(): void
    {
        // === Games CATEGORIES ===
        $electronics = $this->createCategory('Athletics', null, 1, 'electronics,gadgets,devices', 'https://placehold.co/600x400?text=Athletics');
        $fashion     = $this->createCategory('Football', null, 2, 'clothing,shoes,accessories', 'https://placehold.co/600x400?text=Football');
        $books       = $this->createCategory('Cricket', null, 3, 'books,novels,literature', 'https://placehold.co/600x400?text=Cricket');
        $home        = $this->createCategory('Badminton', null, 4, 'books,novels,literature', 'https://placehold.co/600x400?text=Badminton');
        $sports      = $this->createCategory('Swimming', null, 5, 'sports,gear,equipment', 'https://placehold.co/600x400?text=Swimming');
    }

    /**
     * Create or get existing category with default values
     */
    private function createCategory($name, $parentId, $sortOrder, $keywords = '', $image = '')
    {

        return Category::firstOrCreate(
            ['category_name' => $name, 'parent_id' => $parentId],
            [
                'slug'             => Str::slug($name),
                'breadcrumb'       => $name,
                'description'      => "$name and related products",
                'meta_title'       => $name,
                'meta_description' => "Shop for $name online at best prices",
                'meta_keyword'     => $keywords,
                'image'            => $image,
                'alt_name'         => "$name Alt",
                'sort_order'       => $sortOrder,
                'status'           => '1',
                'createdBy'        => 1,
                'updatedBy'        => 1,
            ]
        );
    }
}
