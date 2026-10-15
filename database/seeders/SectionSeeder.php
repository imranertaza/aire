<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ==========================================
        // ABOUT US PAGE DYNAMIC SECTIONS
        // ==========================================
        Section::updateOrCreate(
            ['name' => 'about_hero'],
            [
                'data' => [
                    'badge' => 'OUR STORY',
                    'title' => 'A Cleaner Tomorrow Starts Here',
                    'subtitle' => 'From a simple idea to a global mission, our journey has always been about one thing — cleaner air for healthier, happier lives.',
                ],
            ]
        );

        Section::updateOrCreate(
            ['name' => 'about_story'],
            [
                'data' => [
                    'number' => 1,
                    'title' => 'Our Journey',
                    'subtitle' => 'Discover the key milestones that have shaped AIRE into a global leader in clean air solutions.',
                    'hero_title' => 'Our Journey',
                    'hero_desc' => 'Since our founding, AIRE has been at the forefront of clean air innovation. What began as a vision to improve indoor air quality has grown into a global movement, trusted in homes, businesses and public spaces worldwide.',
                    'hero_image' => 'themes/default/assets/img/about/mountains.jpg',
                    'hero_badge' => "CLEANER AIR\nBRIGHTER SPACES\nA HEALTHIER TOMORROW",
                    'button_text' => 'Explore Our History',
                    'button_link' => '#milestones',
                    'milestones' => [
                        [
                            'year' => '1988',
                            'title' => 'The Beginning',
                            'desc' => 'AIRE was founded with a vision to develop advanced air purification technologies for healthier indoor environments.',
                        ],
                        [
                            'year' => '1995',
                            'title' => 'Research & Development',
                            'desc' => 'We established our first R&D centre, focusing on innovative air treatment technologies and energy-efficient solutions.',
                        ],
                        [
                            'year' => '2005',
                            'title' => 'Expanding Globally',
                            'desc' => 'We expanded our product portfolio and entered international markets across Europe and Asia.',
                        ],
                        [
                            'year' => '2015',
                            'title' => 'A Broader Impact',
                            'desc' => 'We introduced commercial and industrial solutions, addressing air quality challenges across multiple industries, from residential to large-scale commercial projects.',
                        ],
                        [
                            'year' => '2020',
                            'title' => 'Building Healthier Communities',
                            'desc' => 'Our technologies are trusted in over 100 countries, improving the lives of millions through cleaner, safer air.',
                        ],
                        [
                            'year' => 'Today',
                            'title' => 'A Cleaner, Brighter Tomorrow',
                            'desc' => 'We continue to innovate for a healthier planet, with a commitment to sustainability and a future where everyone can breathe better, everywhere.',
                        ],
                    ],
                    'impact_title' => 'A Healthier World Through Cleaner Air',
                    'impact_desc' => 'Our solutions are creating measurable change — improving health, enhancing productivity and building more sustainable communities across the globe.',
                    'impact_image' => 'themes/default/assets/img/apartments.jpg',
                    'impact_badge' => "CLEANER AIR\nBRIGHTER SPACES\nA HEALTHIER TOMORROW",
                    'stats' => [
                        [
                            'icon' => 'bi bi-globe',
                            'title' => '100+ Countries',
                            'desc' => 'Our solutions are trusted in over 100 countries worldwide.',
                        ],
                        [
                            'icon' => 'bi bi-house-door',
                            'title' => 'Millions Healthier Homes',
                            'desc' => 'Cleaner, safer indoor air for families around the world.',
                        ],
                        [
                            'icon' => 'bi bi-buildings',
                            'title' => 'Thousands Businesses',
                            'desc' => 'From offices to factories, we help organisations create healthier workplaces.',
                        ],
                        [
                            'icon' => 'bi bi-tree',
                            'title' => 'A Cleaner Tomorrow',
                            'desc' => 'Reducing emissions and supporting a more sustainable planet.',
                        ],
                    ],
                    'quote' => 'Real change happens when cleaner air becomes a right for everyone, not a privilege for a few.',
                    'quote_brand' => "CLEANER AIR\nBRIGHTER SPACES\nA HEALTHIER TOMORROW",
                ],
            ]
        );

        Section::updateOrCreate(
            ['name' => 'about_mission_vision'],
            [
                'data' => [
                    'number' => 2,
                    'title' => 'Mission & Vision',
                    'subtitle' => 'Our purpose, values and commitment to a better future.',
                    'purpose_title' => 'Our Purpose',
                    'purpose_desc' => 'We believe clean air is a fundamental right for everyone. Our mission and vision guide everything we do — from the technologies we develop to the communities we serve.',
                    'purpose_image' => 'themes/default/assets/img/about/earth_purpose.jpg',
                    'purpose_badge' => "CLEANER AIR\nBRIGHTER SPACES\nA HEALTHIER TOMORROW",
                    'mission_title' => 'Our Mission',
                    'mission_desc' => 'To develop and deliver innovative, reliable and energy-efficient air solutions that create healthier indoor environments for people everywhere.',
                    'vision_title' => 'Our Vision',
                    'vision_desc' => 'A world where everyone, everywhere can breathe clean, safe and healthy air — today and for future generations.',
                    'values' => [
                        [
                            'icon' => 'bi bi-heart',
                            'title' => 'People First',
                            'desc' => 'We put the health and wellbeing of people at the heart of our work.',
                        ],
                        [
                            'icon' => 'bi bi-lightbulb',
                            'title' => 'Innovation Always',
                            'desc' => 'We continuously push the boundaries of clean air technology.',
                        ],
                        [
                            'icon' => 'bi bi-globe-americas',
                            'title' => 'A Healthier Planet',
                            'desc' => 'We are committed to a more sustainable and resilient future.',
                        ],
                        [
                            'icon' => 'bi bi-people-fill',
                            'title' => 'Stronger Together',
                            'desc' => 'We collaborate with partners and communities to create lasting impact.',
                        ],
                    ],
                    'quote' => 'Clean air empowers people, strengthens communities and builds a brighter tomorrow.',
                    'quote_brand' => "CLEANER AIR\nBRIGHTER SPACES\nA HEALTHIER TOMORROW",
                ],
            ]
        );

        Section::updateOrCreate(
            ['name' => 'about_leadership'],
            [
                'data' => [
                    'number' => 3,
                    'title' => 'Leadership',
                    'subtitle' => 'Meet the people driving innovation and impact.',
                    'banner_badge' => 'OUR LEADERSHIP',
                    'banner_title' => 'People with Purpose',
                    'banner_desc' => 'Our leadership team brings together decades of experience, a passion for cleaner air and a shared commitment to creating healthier spaces for everyone, everywhere.',
                    'banner_image' => 'themes/default/assets/img/about/leadership.jpg',
                    'banner_badge_text' => "CLEANER AIR\nBRIGHTER SPACES\nA HEALTHIER TOMORROW",
                    'team_heading' => 'Meet Our Leadership Team',
                    'team_subheading' => 'A diverse group of visionaries, innovators and changemakers working together to build a cleaner, healthier future.',
                    'members' => [
                        [
                            'name' => 'Dr. James Liu',
                            'role' => 'Chief Executive Officer',
                            'bio' => "Leading AIRE's global vision for cleaner air and healthier lives.",
                            'image' => '',
                        ],
                        [
                            'name' => 'Sarah Mitchell',
                            'role' => 'Chief Technology Officer',
                            'bio' => 'Driving innovation in air purification and sustainable technologies.',
                            'image' => '',
                        ],
                        [
                            'name' => 'Kenji Tanaka',
                            'role' => 'Chief Operations Officer',
                            'bio' => 'Scaling solutions globally with operational excellence and partnerships.',
                            'image' => '',
                        ],
                        [
                            'name' => 'Elena Rodriguez',
                            'role' => 'Chief Sustainability Officer',
                            'bio' => 'Championing a healthier planet through people, partnerships and purpose.',
                            'image' => '',
                        ],
                    ],
                    'quote' => 'Great things happen when passionate people work together for a cleaner, healthier world.',
                    'quote_brand' => "CLEANER AIR\nBRIGHTER SPACES\nA HEALTHIER TOMORROW",
                ],
            ]
        );

        Section::updateOrCreate(
            ['name' => 'about_innovation'],
            [
                'data' => [
                    'number' => 4,
                    'title' => 'Innovation & Patents',
                    'subtitle' => 'Pioneering technologies protected worldwide.',
                    'items' => [
                        [
                            'icon' => 'bi bi-patch-check',
                            'title' => '200+ Global Patents',
                            'desc' => 'Proprietary innovations in ionization, filtration, and acoustic airflow design.',
                        ],
                        [
                            'icon' => 'bi bi-sliders',
                            'title' => 'Smart Air Calibration',
                            'desc' => 'AI-powered sensors that dynamically adjust filtration based on environmental metrics.',
                        ],
                    ],
                ],
            ]
        );

        Section::updateOrCreate(
            ['name' => 'about_quality'],
            [
                'data' => [
                    'number' => 5,
                    'title' => 'Quality & Certifications',
                    'subtitle' => 'Globally certified for safety, quality and performance.',
                    'items' => [
                        [
                            'icon' => 'bi bi-award',
                            'title' => 'ISO 9001 & 14001',
                            'desc' => 'Rigorous international standards for manufacturing and environmental stewardship.',
                        ],
                        [
                            'icon' => 'bi bi-shield-lock',
                            'title' => 'AHAM CADR Certified',
                            'desc' => 'Independently lab tested and verified Clean Air Delivery Rates.',
                        ],
                    ],
                ],
            ]
        );

        Section::updateOrCreate(
            ['name' => 'about_careers'],
            [
                'data' => [
                    'number' => 6,
                    'title' => 'Careers',
                    'subtitle' => 'Join our team and help shape a healthier world.',
                    'card_title' => 'Build the Future of Clean Air',
                    'card_desc' => 'We are always looking for passionate engineers, designers, scientists, and problem-solvers to join our global family.',
                    'button_text' => 'View Open Positions',
                    'button_link' => '/contact-us',
                ],
            ]
        );

        Section::updateOrCreate(
            ['name' => 'about_news'],
            [
                'data' => [
                    'number' => 7,
                    'title' => 'News & Media',
                    'subtitle' => 'Latest news, press releases and media coverage.',
                    'banner_title' => 'Official Press & Media Center',
                    'banner_desc' => 'Stay informed with our latest announcements, product innovations, and global milestones.',
                    'button_text' => 'Media Inquiries',
                    'button_link' => '/contact-us',
                ],
            ]
        );

        Section::updateOrCreate(
            ['name' => 'about_global'],
            [
                'data' => [
                    'number' => 8,
                    'title' => 'Global Presence',
                    'subtitle' => 'Serving customers in over 100 countries.',
                    'items' => [
                        [
                            'icon' => 'bi bi-geo-alt',
                            'title' => 'Global Offices',
                            'desc' => 'Regional hubs in North America, Europe, Asia Pacific, and the Middle East.',
                        ],
                        [
                            'icon' => 'bi bi-truck',
                            'title' => 'Worldwide Distribution',
                            'desc' => 'Direct fulfillment and certified maintenance partners across 100+ nations.',
                        ],
                    ],
                ],
            ]
        );
        Section::updateOrCreate(
            ['name' => 'home_benefits'],
            [
                'data' => [
                    'badge' => 'BENEFITS',
                    'title' => 'Pure Air, Healthy Living',
                    'subtitle' => 'Get authentic products, fast delivery, and trusted local service — only from us.',
                    'image' => 'themes/default/assets/img/benifits-bg.png',
                    'cards' => [
                        [
                            'title' => 'Authentic Products',
                            'description' => '100% genuine guaranteed with official manufacturer warranty',
                        ],
                        [
                            'title' => 'Warranty Coverage',
                            'description' => 'Comprehensive protection and technical maintenance plan',
                        ],
                        [
                            'title' => 'Fast Delivery',
                            'description' => 'Swift nationwide door-to-door shipping service available',
                        ],
                        [
                            'title' => 'Trusted Service',
                            'description' => 'Dedicated local experts for support, setup, and advice',
                        ],
                        [
                            'title' => 'Easy Replacement',
                            'description' => 'Hassle-free filter and parts replacement availability',
                        ],
                        [
                            'title' => 'Multiple Choices',
                            'description' => 'Wide range of models and features to suit lifestyles',
                        ],
                    ],
                ],
            ]
        );

        Section::updateOrCreate(
            ['name' => 'home_video'],
            [
                'data' => [
                    'title' => 'AIRE Pro S1 — Engineering Architecture & Air Purification',
                    'image' => 'home/video_thumb.png',
                    'video_url' => 'storage/home/home-video.mp4',
                    'video_file' => '',
                ],
            ]
        );

        Section::updateOrCreate(
            ['name' => 'home_faq'],
            [
                'data' => [
                    'badge' => 'SUPPORT',
                    'title' => 'Frequently Asked Questions',
                    'subtitle' => 'Have questions? Here are answers to common questions about our purifiers, filters, and technology.',
                    'items' => [
                        [
                            'question' => 'How long do the HEPA H13 filters last?',
                            'answer' => 'Under normal conditions, filters should be replaced every 120-150 hours of active use. The integrated sensor will notify you via the LED ring and app when replacement is required.',
                        ],
                        [
                            'question' => 'Is the Airpro Mask FB2 suitable for high-intensity exercise?',
                            'answer' => 'Yes. The active pressure balance system dynamically adjusts airflow to match your breathing rate, preventing CO2 buildup and keeping the interior cool during physical exertion.',
                        ],
                        [
                            'question' => 'How do I sanitize the mask?',
                            'answer' => 'The medical-grade silicone seal is detachable and can be cleaned with warm soapy water or alcohol-based wipes. Ensure the electronic chassis is removed before cleaning.',
                        ],
                        [
                            'question' => 'Does the mask support Bluetooth connectivity?',
                            'answer' => 'Yes, it connects to the AIRE app via Bluetooth 5.2 for real-time air quality monitoring, filter healthtracking, and firmware updates.',
                        ],
                        [
                            'question' => 'What is the battery life of the active sensors?',
                            'answer' => 'The internal battery provides up to 12 hours of continuous operation on a single charge. It supports fast charging via USB-C, reaching 80% in just 45 minutes.',
                        ],
                    ],
                ],
            ]
        );

        Section::updateOrCreate(
            ['name' => 'home_lifestyle'],
            [
                'data' => [
                    'badge' => 'LIFESTYLE',
                    'title' => 'Seamless Living, Cleaner Air',
                    'subtitle' => 'From bedrooms to offices, our purifiers blend effortlessly into every space while keeping your air fresh and healthy.',
                    'items' => [
                        [
                            'title' => 'Bedroom Serenity',
                            'description' => 'Sleep peacefully with cleaner air by your side. Wake up refreshed every morning with purified air.',
                            'image' => 'home/lifestyle/s1.png',
                        ],
                        [
                            'title' => 'Living Room Comfort',
                            'description' => 'Enjoy family moments in a healthier environment. Keep your living space fresh and welcoming.',
                            'image' => 'home/lifestyle/s2.png',
                        ],
                        [
                            'title' => 'Office Focus',
                            'description' => 'Boost productivity with fresh, purified air at work. Stay sharp and energized throughout the day.',
                            'image' => 'home/lifestyle/s3.png',
                        ],
                        [
                            'title' => "Kids' Room Safety",
                            'description' => 'Protect your children from dust, pollen, and allergens. Ensure safe, clean air to breathe.',
                            'image' => 'home/lifestyle/s4.png',
                        ],
                    ],
                ],
            ]
        );

        Section::updateOrCreate(
            ['name' => 'trust_badges'],
            [
                'data' => [
                    'badges' => [
                        ['icon' => 'bi-shield-check', 'title' => 'SECURE PAYMENTS', 'description' => '100% secure and encrypted payments.'],
                        ['icon' => 'bi-box-seam', 'title' => 'FREE SHIPPING', 'description' => 'On all orders over $150.'],
                        ['icon' => 'bi-arrow-repeat', 'title' => '30-DAY RETURNS', 'description' => 'Return or exchange within 30 days.'],
                        ['icon' => 'bi-award', 'title' => '1 YEAR WARRANTY', 'description' => 'Full protection and quality assurance.'],
                        ['icon' => 'bi-headset', 'title' => 'DEDICATED SUPPORT', 'description' => 'Expert assistance whenever you need it.'],
                    ]
                ],
            ]
        );

        Section::updateOrCreate(
            ['name' => 'why_choose_aire'],
            [
                'data' => [
                    'title' => 'Why Choose AIRE?',
                    'subtitle' => 'The ultimate protocol for atmospheric purity and environmental control.',
                    'cards' => [
                        [
                            'theme' => 'dark',
                            'dots' => '•••',
                            'title' => 'Unmatched <br> Filtration Precision',
                            'content' => 'We utilize medical-grade HEPA-14 filters combined with advanced activated carbon matrices to capture particles as small as 0.1 microns, ensuring absolute purity.'
                        ],
                        [
                            'theme' => 'light',
                            'dots' => '••••',
                            'title' => 'Smart IoT <br> Ecosystem Integration',
                            'content' => 'Monitor indoor air quality in real-time, adjust fan speeds automatically based on atmospheric sensors, and track filter degradation through the AIRE mobile app.'
                        ],
                        [
                            'theme' => 'light',
                            'dots' => '•••••',
                            'title' => 'Whisper-Quiet <br> Acoustic Engineering',
                            'content' => 'Architected using aerodynamic fluid dynamics to operate at ultra-low decibel levels, guaranteeing your professional or living space remains undisturbed.'
                        ],
                        [
                            'theme' => 'light',
                            'dots' => '••••••',
                            'title' => 'Sustainable & <br> Energy Efficient',
                            'content' => 'Constructed with eco-conscious materials and engineered to consume minimal energy while delivering maximum Clean Air Delivery Rate (CADR).'
                        ],
                    ]
                ],
            ]
        );

        Section::updateOrCreate(
            ['name' => 'client_testimonials'],
            [
                'data' => [
                    'title' => 'Purity in Practice',
                    'subtitle' => 'CLIENT TESTIMONIALS',
                    'items' => [
                        [
                            'name' => 'Sarah Jenkins',
                            'role' => 'INTERIOR ARCHITECT',
                            'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=120&q=80',
                            'rating' => 5,
                            'quote' => "The AIRE Pro S1 is not just an air purifier; it's a piece of architectural art that has transformed our living environment.",
                        ],
                        [
                            'name' => 'Marcus Chen',
                            'role' => 'SENIOR FACILITY MANAGER',
                            'avatar' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=120&q=80',
                            'rating' => 5,
                            'quote' => 'Unmatched technical precision. The IAQ data reporting is exactly what our facility management team needed for ESG compliance.',
                        ],
                        [
                            'name' => 'Dr. Elena Rostova',
                            'role' => 'CLINICAL ALLERGIST',
                            'avatar' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=120&q=80',
                            'rating' => 5,
                            'quote' => 'The multi-stage filtration system drastically reduced particulate matter in our high-traffic clinic rooms. Absolutely vital for our patients.',
                        ],
                        [
                            'name' => 'David Sterling',
                            'role' => 'SUSTAINABILITY DIRECTOR',
                            'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80',
                            'rating' => 5,
                            'quote' => 'Combining whisper-quiet acoustics with verifiable CADR performance has made AIRE our go-to partner for premium commercial builds.',
                        ],
                    ]
                ],
            ]
        );

        $defaultProductIds = \App\Models\Product::where('status', 1)->take(4)->pluck('id')->toArray();
        Section::updateOrCreate(
            ['name' => 'home_best_selling'],
            [
                'data' => [
                    'badge' => 'Product',
                    'title' => 'Best Selling Product',
                    'subtitle' => 'Discover the top‑selling models trusted by thousands of families for cleaner, healthier air.',
                    'product_ids' => $defaultProductIds,
                ],
            ]
        );
        $defaultNewArrivalIds = \App\Models\Product::where('status', 1)->latest('id')->take(3)->pluck('id')->toArray();
        Section::updateOrCreate(
            ['name' => 'home_new_arrival'],
            [
                'data' => [
                    'badge' => 'New arrival',
                    'title' => 'New arrival Home',
                    'subtitle' => 'Explore the latest purifiers designed with advanced technology for modern living.',
                    'product_ids' => $defaultNewArrivalIds,
                ],
            ]
        );
        $defaultFavoriteIds = \App\Models\Product::where('status', 1)->skip(3)->take(3)->pluck('id')->toArray();
        if (empty($defaultFavoriteIds)) {
            $defaultFavoriteIds = \App\Models\Product::where('status', 1)->take(2)->pluck('id')->toArray();
        }
        Section::updateOrCreate(
            ['name' => 'home_customer_favorites'],
            [
                'data' => [
                    'badge' => 'Customers Favorites',
                    'title' => 'Loved by Our Community',
                    'subtitle' => 'Discover the purifiers most chosen by families who value clean, healthy air.',
                    'product_ids' => $defaultFavoriteIds,
                ],
            ]
        );

        $defaultLivingHeroProduct = \App\Models\Product::where('status', 1)->latest('id')->first();
        Section::updateOrCreate(
            ['name' => 'home_living_hero'],
            [
                'data' => [
                    'enabled' => 1,
                    'badge' => 'INNOVATION',
                    'title' => 'Home Living Hero',
                    'subtitle' => 'Engineered for complete atmospheric transformation. Seamlessly integrates into modern living spaces with intelligent active air purification.',
                    'description' => 'Engineered for complete atmospheric transformation. Seamlessly integrates into modern living spaces with intelligent active air purification.',
                    'image' => 'themes/default/assets/img/background-without-product.png',
                    'product_id' => $defaultLivingHeroProduct ? $defaultLivingHeroProduct->id : null,
                    'button_text' => 'Buy Now',
                ],
            ]
        );
    }
}
