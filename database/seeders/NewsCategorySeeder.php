<?php

namespace Database\Seeders;

use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsCategorySeeder extends Seeder
{
    public function run(): void
    {
        $adminId = User::value('id') ?: 1;

        // Clean up legacy/irrelevant gaming categories
        $legacyCategories = ['Games', 'Sports', 'Entertainment', 'gaming', 'esports'];
        NewsCategory::whereIn('category_name', $legacyCategories)
            ->orWhereIn('slug', ['games', 'sports', 'entertainment'])
            ->delete();

        // === AIRE THEME & INDUSTRY NEWS CATEGORIES ===
        $categories = [
            [
                'name'        => 'Air Quality & Health',
                'slug'        => 'air-quality-health',
                'sort_order'  => 1,
                'description' => 'Medical research, allergen suppression, viral filtration, and scientific insights on indoor air quality and respiratory health.',
                'meta_title'  => 'Indoor Air Quality & Health Insights | AIRE News',
                'meta_desc'   => 'Explore clinical evidence, PM2.5 particulate reduction studies, and air hygiene guidelines for healthy living.',
                'keywords'    => 'indoor air quality, IAQ health, PM2.5 filtration, allergy relief, infection control, respiratory wellness',
            ],
            [
                'name'        => 'Technology & Innovation',
                'slug'        => 'technology-innovation',
                'sort_order'  => 2,
                'description' => 'Engineering breakthroughs in ductless heat recovery ventilators (ERV/HRV), smart brushless fans, and multi-stage filtration.',
                'meta_title'  => 'HVAC & Filtration Technology Innovations | AIRE',
                'meta_desc'   => 'Discover cutting-edge ductless ventilation engineering, IoT environmental monitoring, and ultra-quiet motor innovations.',
                'keywords'    => 'heat recovery ventilator, ductless ERV, smart air purifiers, brushless DC motors, IAQ sensors',
            ],
            [
                'name'        => 'Green Buildings & Energy',
                'slug'        => 'green-buildings-energy',
                'sort_order'  => 3,
                'description' => 'Sustainable architecture, LEED & WELL certification standards, and net-zero energy conservation strategies.',
                'meta_title'  => 'Green Building Architecture & Energy Recovery | AIRE',
                'meta_desc'   => 'Learn how high-efficiency heat recovery ventilation cores reduce carbon footprint and cut commercial HVAC power loads.',
                'keywords'    => 'energy recovery core, green building, LEED certification, net-zero HVAC, decarbonization, sustainable architecture',
            ],
            [
                'name'        => 'Corporate & Case Studies',
                'slug'        => 'corporate-case-studies',
                'sort_order'  => 4,
                'description' => 'Official AIRE corporate announcements, global installation case studies, enterprise milestones, and community projects.',
                'meta_title'  => 'Corporate Announcements & Project Case Studies | AIRE',
                'meta_desc'   => 'Latest AIRE Industries corporate developments, international cleanroom deployments, and commercial case studies.',
                'keywords'    => 'AIRE corporate, clean air case study, commercial installation, industry awards, cleanroom ventilation',
            ],
            [
                'name'        => 'Regulations & Standards',
                'slug'        => 'regulations-standards',
                'sort_order'  => 5,
                'description' => 'Global building compliance, ASHRAE 62.1/62.2, WHO air hygiene frameworks, and statutory air safety policies.',
                'meta_title'  => 'Clean Air Regulations & ASHRAE Compliance | AIRE',
                'meta_desc'   => 'Updates on international air quality legislation, infection risk mitigation standards, and statutory ventilation codes.',
                'keywords'    => 'ASHRAE standards, WHO air guidelines, clean air policy, building ventilation codes, statutory compliance',
            ],
        ];

        foreach ($categories as $cat) {
            NewsCategory::updateOrCreate(
                ['slug' => $cat['slug']],
                [
                    'category_name'    => $cat['name'],
                    'slug'             => $cat['slug'],
                    'parent_id'        => null,
                    'description'      => $cat['description'],
                    'meta_title'       => $cat['meta_title'],
                    'meta_description' => $cat['meta_desc'],
                    'meta_keyword'     => $cat['keywords'],
                    'image'            => 'themes/default/assets/img/Air-Purify.png',
                    'alt_name'         => $cat['name'],
                    'sort_order'       => $cat['sort_order'],
                    'status'           => '1',
                    'createdBy'        => $adminId,
                    'updatedBy'        => $adminId,
                ]
            );
        }
    }
}
