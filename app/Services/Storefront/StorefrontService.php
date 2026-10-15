<?php

namespace App\Services\Storefront;

use App\Models\Customer;
use App\Models\Newsletter;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class StorefrontService
{
    /**
     * Batch resolve and cache all homepage product sections.
     */
    public function getHomeProductSections(): array
    {
        return Cache::remember(Product::HOME_SECTIONS_CACHE_KEY, 3600, function () {
            $bestSellingSection = getSection('home_best_selling') ?? (getSection('best_selling') ?? []);
            $newArrivalSection  = getSection('home_new_arrival') ?? (getSection('new_arrival') ?? []);
            $customerFavSection = getSection('home_customer_favorites') ?? (getSection('customer_favorites') ?? (getSection('home_customer_fav') ?? []));
            $livingHeroSection  = getSection('home_living_hero') ?? (getSection('living_hero') ?? []);

            $bestSellingIds = is_array($bestSellingSection['product_ids'] ?? null) ? $bestSellingSection['product_ids'] : [];
            $newArrivalIds  = is_array($newArrivalSection['product_ids'] ?? null) ? $newArrivalSection['product_ids'] : [];
            $favIds         = is_array($customerFavSection['product_ids'] ?? null) ? $customerFavSection['product_ids'] : [];
            $livingId       = $livingHeroSection['product_id'] ?? null;

            // Collect all unique configured product IDs
            $allConfiguredIds = array_values(array_filter(array_unique(array_merge(
                $bestSellingIds,
                $newArrivalIds,
                $favIds,
                $livingId ? [$livingId] : []
            ))));

            // 1. Single batch query for all configured products using reusable scopes
            $loadedProducts = !empty($allConfiguredIds)
                ? Product::withCatalogRelations()
                    ->active()
                    ->whereIn('id', $allConfiguredIds)
                    ->get()
                    ->keyBy('id')
                : collect();

            // 2. Map Best Selling products (or fallback via scope)
            $bestSellingProducts = collect($bestSellingIds)->map(fn($id) => $loadedProducts->get($id))->filter()->values();
            if ($bestSellingProducts->isEmpty()) {
                $bestSellingProducts = Product::bestSellingFallback(4)->get();
            }

            // 3. Map New Arrival products (or fallback via scope)
            $newArrivalProducts = collect($newArrivalIds)->map(fn($id) => $loadedProducts->get($id))->filter()->values();
            if ($newArrivalProducts->isEmpty()) {
                $newArrivalProducts = Product::newArrivalsFallback(3)->get();
            }

            // 4. Map Customer Favorites products (or fallback via scope)
            $customerFavoritesProducts = collect($favIds)->map(fn($id) => $loadedProducts->get($id))->filter()->values();
            if ($customerFavoritesProducts->isEmpty()) {
                $customerFavoritesProducts = Product::customerFavoritesFallback(3, 3)->get();
            }

            // 5. Map Living Hero product (or fallback via scope)
            $livingProduct = $livingId ? $loadedProducts->get($livingId) : null;
            if (!$livingProduct) {
                $livingProduct = Product::bestSellingFallback(1)->first();
            }

            return [
                'bestSellingProducts'       => $bestSellingProducts,
                'newArrivalProducts'        => $newArrivalProducts,
                'customerFavoritesProducts' => $customerFavoritesProducts,
                'livingProduct'             => $livingProduct,
                'bottomFeaturedProduct'     => $livingProduct,
            ];
        });
    }

    /**
     * Get banner slides for homepage hero.
     */
    public function getHeroSlides()
    {
        return Slider::getByPlacement('banner_section');
    }

    /**
     * Get promotional sliders for About page.
     */
    public function getAboutAds(): Collection
    {
        return Cache::remember('storefront_about_ads_v1', 3600, function () {
            return Slider::getByPlacement('about_us');
        });
    }

    /**
     * Retrieve all dynamic content sections for the About Us page.
     */
    public function getAboutSections(): array
    {
        return Cache::remember('storefront_about_sections_v1', 86400, function () {
            return [
                'hero' => getSection('about_hero', [
                    'badge'    => 'OUR STORY',
                    'title'    => 'A Cleaner Tomorrow Starts Here',
                    'subtitle' => 'From a simple idea to a global mission, our journey has always been about one thing — cleaner air for healthier, happier lives.',
                ]),
                'story' => getSection('about_story', [
                    'number'       => 1,
                    'title'        => 'Our Journey',
                    'subtitle'     => 'From humble beginnings to global clean air leadership.',
                    'hero_title'   => 'The Story Behind AIRE',
                    'hero_desc'    => 'AIRE was founded with a single, powerful conviction: clean, pure air should not be a luxury — it is a fundamental human right.',
                    'hero_image'   => 'themes/default/assets/img/about/mountains.jpg',
                    'hero_badge'   => "CLEANER AIR\nBRIGHTER SPACES\nA HEALTHIER TOMORROW",
                    'button_text'  => 'Explore Our History',
                    'button_link'  => '#milestones',
                    'milestones'   => [
                        [
                            'year'  => '1988',
                            'title' => 'The Beginning',
                            'desc'  => 'AIRE was founded with a small, passionate team and a big mission — to create advanced air filtration systems that improve daily life.',
                        ],
                    ],
                    'impact_title' => 'A Healthier World Through Cleaner Air',
                    'impact_desc'  => 'Our solutions are creating measurable change across the globe.',
                    'impact_image' => 'themes/default/assets/img/apartments.jpg',
                    'impact_badge' => "CLEANER AIR\nBRIGHTER SPACES\nA HEALTHIER TOMORROW",
                    'stats'        => [
                        [
                            'icon'  => 'bi bi-globe',
                            'title' => '100+ Countries',
                            'desc'  => 'Trusted by households, medical facilities, and enterprises globally.',
                        ],
                    ],
                    'quote'        => 'Real change happens when cleaner air becomes a right for everyone, everywhere.',
                    'quote_brand'  => "CLEANER AIR\nBRIGHTER SPACES\nA HEALTHIER TOMORROW",
                ]),
                'mission_vision' => getSection('about_mission_vision', [
                    'number'         => 2,
                    'title'          => 'Mission & Vision',
                    'subtitle'       => 'Our purpose, values and commitment to a better future.',
                    'purpose_title'  => 'Our Purpose',
                    'purpose_desc'   => 'We believe clean air is a fundamental right for everyone.',
                    'purpose_image'  => 'themes/default/assets/img/about/earth_purpose.jpg',
                    'purpose_badge'  => "CLEANER AIR\nBRIGHTER SPACES\nA HEALTHIER TOMORROW",
                    'mission_title'  => 'Our Mission',
                    'mission_desc'   => 'To develop and deliver innovative, reliable and energy-efficient air solutions.',
                    'vision_title'   => 'Our Vision',
                    'vision_desc'    => 'A world where everyone, everywhere can breathe clean, safe and healthy air.',
                    'values'         => [
                        [
                            'icon'  => 'bi bi-heart',
                            'title' => 'People First',
                            'desc'  => 'We put the health and wellbeing of people at the heart of our work.',
                        ],
                    ],
                    'quote'          => 'Clean air empowers people, strengthens communities and builds a brighter tomorrow.',
                    'quote_brand'    => "CLEANER AIR\nBRIGHTER SPACES\nA HEALTHIER TOMORROW",
                ]),
                'leadership' => getSection('about_leadership', [
                    'number'            => 3,
                    'title'             => 'Leadership',
                    'subtitle'          => 'Meet the people driving innovation and impact.',
                    'banner_badge'      => 'OUR LEADERSHIP',
                    'banner_title'      => 'People with Purpose',
                    'banner_desc'       => 'Our leadership team brings together decades of experience and a passion for cleaner air.',
                    'banner_image'      => 'themes/default/assets/img/about/leadership.jpg',
                    'banner_badge_text' => "CLEANER AIR\nBRIGHTER SPACES\nA HEALTHIER TOMORROW",
                    'team_heading'      => 'Meet Our Leadership Team',
                    'team_subheading'   => 'A diverse group of visionaries working together.',
                    'members'           => [
                        [
                            'name'  => 'Dr. James Liu',
                            'role'  => 'Chief Executive Officer',
                            'bio'   => "Leading AIRE's global vision for cleaner air and healthier lives.",
                            'image' => '',
                        ],
                    ],
                    'quote'             => 'Great things happen when passionate people work together for a cleaner, healthier world.',
                    'quote_brand'       => "CLEANER AIR\nBRIGHTER SPACES\nA HEALTHIER TOMORROW",
                ]),
                'innovation' => getSection('about_innovation', [
                    'number'   => 4,
                    'title'    => 'Innovation & Patents',
                    'subtitle' => 'Pioneering technologies protected worldwide.',
                    'items'    => [
                        [
                            'icon'  => 'bi bi-patch-check',
                            'title' => '200+ Global Patents',
                            'desc'  => 'Proprietary innovations in ionization and acoustic airflow design.',
                        ],
                    ],
                ]),
                'quality' => getSection('about_quality', [
                    'number'   => 5,
                    'title'    => 'Quality & Certifications',
                    'subtitle' => 'Globally certified for safety, quality and performance.',
                    'items'    => [
                        [
                            'icon'  => 'bi bi-award',
                            'title' => 'ISO 9001 & 14001',
                            'desc'  => 'Rigorous international standards for manufacturing and environmental stewardship.',
                        ],
                    ],
                ]),
                'careers' => getSection('about_careers', [
                    'number'      => 6,
                    'title'       => 'Careers',
                    'subtitle'    => 'Join our team and help shape a healthier world.',
                    'card_title'  => 'Build the Future of Clean Air',
                    'card_desc'   => 'We are always looking for passionate engineers, designers and scientists.',
                    'button_text' => 'View Open Positions',
                    'button_link' => '/contact-us',
                ]),
                'news' => getSection('about_news', [
                    'number'       => 7,
                    'title'        => 'News & Media',
                    'subtitle'     => 'Latest news, press releases and media coverage.',
                    'banner_title' => 'Official Press & Media Center',
                    'banner_desc'  => 'Stay informed with our latest announcements and product innovations.',
                    'button_text'  => 'Media Inquiries',
                    'button_link'  => '/contact-us',
                ]),
                'global' => getSection('about_global', [
                    'number'   => 8,
                    'title'    => 'Global Presence',
                    'subtitle' => 'Serving customers in over 100 countries.',
                    'items'    => [
                        [
                            'icon'  => 'bi bi-geo-alt',
                            'title' => 'Global Offices',
                            'desc'  => 'Regional hubs in North America, Europe, Asia Pacific, and the Middle East.',
                        ],
                    ],
                ]),
            ];
        });
    }

    /**
     * Process newsletter subscription.
     */
    public function subscribe(string $email, ?int $customerId = null): array
    {
        $existing = Newsletter::where('email', $email)->first();

        if ($existing) {
            $updates = ['status' => 1, 'unsubscribed_at' => null];
            if (empty($existing->unsubscribe_token)) {
                $updates['unsubscribe_token'] = Str::random(64);
            }
            if ($customerId) {
                $updates['customer_id'] = $customerId;
            }

            $existing->update($updates);

            return [
                'success' => true,
                'message' => 'Thank you! Your newsletter subscription has been confirmed.',
            ];
        }

        Newsletter::create([
            'email'             => $email,
            'status'            => 1,
            'customer_id'       => $customerId,
            'unsubscribe_token' => Str::random(64),
            'unsubscribed_at'   => null,
        ]);

        return [
            'success' => true,
            'message' => 'Thank you for subscribing to our newsletter!',
        ];
    }

    /**
     * Process 1-Click Unsubscribe via secure token.
     */
    public function unsubscribeByToken(string $token): array
    {
        if (empty($token) || strlen($token) < 16) {
            return [
                'success' => false,
                'message' => 'Invalid or expired unsubscribe link.',
                'email'   => null,
            ];
        }

        // 1. Check in Newsletter table
        $subscriber = Newsletter::where('unsubscribe_token', $token)->first();
        if ($subscriber) {
            $subscriber->update([
                'status'          => 0,
                'unsubscribed_at' => now(),
            ]);

            return [
                'success' => true,
                'message' => 'You have been successfully unsubscribed from our newsletter.',
                'email'   => $subscriber->email,
                'token'   => $token,
            ];
        }

        // 2. Check in Customer table
        $customer = Customer::where('unsubscribe_token', $token)->first();
        if ($customer) {
            $customer->update([
                'newsletter'      => 0,
                'is_subscribed'   => 0,
                'unsubscribed_at' => now(),
            ]);

            return [
                'success' => true,
                'message' => 'You have been successfully unsubscribed from our promotional emails.',
                'email'   => $customer->email,
                'token'   => $token,
            ];
        }

        return [
            'success' => false,
            'message' => 'We could not find an active subscription associated with this link.',
            'email'   => null,
        ];
    }

    /**
     * Process 1-Click Re-subscribe (undo accidental unsubscribe).
     */
    public function resubscribeByToken(string $token): array
    {
        if (empty($token)) {
            return [
                'success' => false,
                'message' => 'Invalid or expired token.',
            ];
        }

        $subscriber = Newsletter::where('unsubscribe_token', $token)->first();
        if ($subscriber) {
            $subscriber->update([
                'status'          => 1,
                'unsubscribed_at' => null,
            ]);

            return [
                'success' => true,
                'message' => 'Your newsletter subscription has been successfully reactivated!',
                'email'   => $subscriber->email,
            ];
        }

        $customer = Customer::where('unsubscribe_token', $token)->first();
        if ($customer) {
            $customer->update([
                'newsletter'      => 1,
                'is_subscribed'   => 1,
                'unsubscribed_at' => null,
            ]);

            return [
                'success' => true,
                'message' => 'Your email subscription has been successfully reactivated!',
                'email'   => $customer->email,
            ];
        }

        return [
            'success' => false,
            'message' => 'Unable to find subscription to reactivate.',
        ];
    }
}
