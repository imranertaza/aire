<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductOverview;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FixProductImagesSeeder extends Seeder
{
    public function run(): void
    {
        $realImages = [
            'themes/default/assets/img/airpro_mask_fb2.png',
            'themes/default/assets/img/aire_pro_s1.png',
            'themes/default/assets/img/aire_mini.png',
            'themes/default/assets/img/Air-Purify.png',
            'themes/default/assets/img/air-purifier.png',
            'themes/default/assets/img/AIRE-Pro-S1-Hero.png',
            'themes/default/assets/img/HEPA-H13-Macro.png',
            'themes/default/assets/img/Filter.png',
            'themes/default/assets/img/Filter-1.png',
            'themes/default/assets/img/product.png',
            'themes/default/assets/img/photograph.png',
            'themes/default/assets/img/apartments.png',
            'https://images.unsplash.com/photo-1585771724684-38269d6639fd?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1545259741-2ea3ebf61fa3?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1583863788434-e58a36330cf0?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1540518614846-7ede433c5173?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1595526114035-0d45ed16cfbf?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1581092335397-9583fe92d232?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1581092580497-e0d23cbdf1dc?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1584634731339-252c581abfc5?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1584744982491-665216d95f8b?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1584036561566-baf8f5f1b144?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1584467735815-f778f274e296?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1508873696983-2df57046475a?auto=format&fit=crop&w=800&q=80',
        ];

        $products = Product::all();
        echo "Validating and updating images for " . $products->count() . " products...\n";

        $updated = 0;
        foreach ($products as $idx => $p) {
            $img = $p->main_image;
            $needsFix = false;

            if (empty($img) || str_contains($img, 'placehold.co') || str_contains($img, 'placeholder')) {
                $needsFix = true;
            } elseif (!str_starts_with($img, 'http://') && !str_starts_with($img, 'https://')) {
                $norm = ltrim($img, '/');
                if (!file_exists(public_path($norm)) && !Storage::disk('public')->exists($norm)) {
                    $needsFix = true;
                }
            }

            if ($needsFix) {
                $replacement = $realImages[$idx % count($realImages)];
                $p->main_image = $replacement;
                $p->image = $replacement;
                $p->save();
                $updated++;
            }

            // Also check and update ProductOverview image
            $overview = ProductOverview::where('product_id', $p->id)->first();
            if ($overview) {
                $oImg = $overview->image;
                if (empty($oImg) || str_contains($oImg, 'placehold.co') || (!str_starts_with($oImg, 'http') && !file_exists(public_path(ltrim($oImg, '/'))) && !Storage::disk('public')->exists(ltrim($oImg, '/')))) {
                    $overview->image = $p->main_image;
                    $overview->save();
                }
            }
        }

        echo "Fixed {$updated} product image records with verified real assets!\n";
    }
}
