<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Database\Seeder;

class NewsCategoryMapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        News::all()->each(function ($news) {
            // If the news article does not have any category mapped, attach one
            if ($news->categories()->count() === 0) {
                $category = NewsCategory::inRandomOrder()->first();
                if ($category) {
                    $news->categories()->attach($category->id);
                }
            }
        });
    }
}
