<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = 1;

        $settings = [
            // General
            ['label' => 'address', 'title' => 'Address', 'value' => "Innovation Drive, Suite 100\r\nSilicon Valley, CA 94025", 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'email', 'title' => 'Email', 'value' => 'info@aireindustries.com', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'phone', 'title' => 'Phone', 'value' => '+880 8000000000', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'state', 'title' => 'State', 'value' => '322', 'createdBy' => $userId, 'updatedBy' => $userId],

            // Branding
            ['label' => 'store_logo', 'title' => 'Store Logo', 'value' => 'settings/store_logo/store_logo_1787123535_6a85574fc70b6.png', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'store_icon', 'title' => 'Store Icon', 'value' => 'settings/store_icon/store_icon_1787127492_6a8566c4e2f8c.png', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'footer_logo', 'title' => 'Footer Logo', 'value' => 'settings/footer_logo/footer_logo_1787123535_6a85574fd1a10.png', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'footer_description', 'title' => 'Footer Description', 'value' => 'Technological mastery in every breath. Leading the future of high-purity air environments for a healthier planet.', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'breadcrumb', 'title' => 'Footer Logo', 'value' => 'https://placehold.co/1351x300', 'createdBy' => $userId, 'updatedBy' => $userId],

            // Mail settings
            ['label' => 'mail_protocol', 'title' => 'Mail Protocol', 'value' => 'smtp', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'mail_address', 'title' => 'Mail Address', 'value' => 'imranertaza12@gmail.com', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'send_from', 'title' => 'Send From Mail Address', 'value' => 'support@staging.test.npcbangladesh.org', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'smtp_host', 'title' => 'SMTP Host', 'value' => 'staging.test.npcbangladesh.org', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'smtp_username', 'title' => 'SMTP Username', 'value' => 'support@staging.test.npcbangladesh.org', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'smtp_password', 'title' => 'SMTP Password', 'value' => '[zfLhqfsDcI+', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'smtp_port', 'title' => 'SMTP Port', 'value' => '465', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'smtp_timeout', 'title' => 'SMTP Timeout', 'value' => '300', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'smtp_crypto', 'title' => 'SMTP Crypto', 'value' => 'ssl', 'createdBy' => $userId, 'updatedBy' => $userId],

            // Social links
            ['label' => 'fb_url', 'title' => 'Facebook', 'value' => 'https://www.facebook.com/aire', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'twitter_url', 'title' => 'Twitter', 'value' => 'https://twitter.com/aire', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'linkedin_url', 'title' => 'Linkedin', 'value' => 'https://www.linkedin.com/aire', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'instagram_url', 'title' => 'Instagram', 'value' => 'https://www.instagram.com/aire', 'createdBy' => $userId, 'updatedBy' => $userId],

            // SEO basics
            ['label' => 'meta_title', 'title' => 'Meta Title', 'value' => 'Aire', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'meta_keyword', 'title' => 'Meta Keyword', 'value' => 'Aire', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'meta_description', 'title' => 'Meta Description', 'value' => 'Aire Meta Description', 'createdBy' => $userId, 'updatedBy' => $userId],

            // Extended SEO
            ['label' => 'meta_author', 'title' => 'Meta Author', 'value' => 'Aire Admin', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'meta_news_keywords', 'title' => 'News Keywords', 'value' => 'Aire', 'createdBy' => $userId, 'updatedBy' => $userId],

            // Open Graph
            ['label' => 'og_type', 'title' => 'OG Type', 'value' => 'article', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'og_title', 'title' => 'OG Title', 'value' => 'Aire Article', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'og_description', 'title' => 'OG Description', 'value' => 'Discover the latest updates from the Aire', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'og_image', 'title' => 'OG Image', 'value' => 'https://placehold.co/1200x630?text=NPCB+OG+Image', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'og_image_width', 'title' => 'OG Image Width', 'value' => '1200', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'og_image_height', 'title' => 'OG Image Height', 'value' => '630', 'createdBy' => $userId, 'updatedBy' => $userId],

            // Twitter Card
            ['label' => 'twitter_card', 'title' => 'Twitter Card', 'value' => 'summary_large_image', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'twitter_title', 'title' => 'Twitter Title', 'value' => 'Aire', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'twitter_description', 'title' => 'Twitter Description', 'value' => 'Follow updates from the Aire', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'twitter_image', 'title' => 'Twitter Image', 'value' => 'https://placehold.co/1200x630?text=NPCB+Twitter+Image', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'twitter_domain', 'title' => 'Twitter Domain', 'value' => 'https://aire.com', 'createdBy' => $userId, 'updatedBy' => $userId],

            // Brand
            ['label' => 'brand_name', 'title' => 'Brand Name', 'value' => 'Aire', 'createdBy' => $userId, 'updatedBy' => $userId],

            // Mobile Apps
            ['label' => 'google_play_url', 'title' => 'Google Play URL', 'value' => '#', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'app_store_url', 'title' => 'App Store URL', 'value' => '#', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'google_play_image', 'title' => 'Google Play Badge Image', 'value' => '', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'app_store_image', 'title' => 'App Store Badge Image', 'value' => '', 'createdBy' => $userId, 'updatedBy' => $userId],
            ['label' => 'show_app_download_links', 'title' => 'Show App Download Links', 'value' => '1', 'createdBy' => $userId, 'updatedBy' => $userId],

            // Search & Discovery
            ['label' => 'popular_searches', 'title' => 'Popular Searches', 'value' => '', 'createdBy' => $userId, 'updatedBy' => $userId],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['label' => $setting['label']],
                $setting
            );
        }
    }
}
