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
        Section::updateOrCreate(
            ['name' => 'about_vision'],
            [
                'data' => [
                    'title' => 'Vision',
                    'image' => 'themes/default/assets/img/Air-Purify.png',
                    'content' => '<p class="content-text text-dark-emphasis">
            Through its programs and events, the NPCB’s vision is to foster a truly inclusive Bangladesh,
            where Para athletes have equal opportunities to participate in sports at all levels and are
            recognized for their successes.
        </p>'
                ],
            ]
        );
        Section::updateOrCreate(
            ['name' => 'about_mission_vision'],
            [
                'data' => [
                    'title' => 'Our mission and vision',
                    'image' => 'themes/default/assets/img/Air-Purify.png',
                    'content' => '<p class="content-text text-white opacity-75">
                        The mission & vision of the National Paralympic Committee of Bangladesh (NPCB) is aligned with
                        International Paralympic Committee\'s mission & vision. NPCB promotes the Paralympic movement
                        within the country, enabling Para athletes to achieve sporting excellence.
                    </p>',
                    'home_content' => '<p class="content-text text-dark-emphasis">
                        The mission & vision of the National Paralympic Committee of Bangladesh (NPCB) is aligned with
                        International Paralympic Committee\'s mission & vision. NPCB promotes the Paralympic movement
                        within the country, enabling Para athletes to achieve sporting excellence.
                    </p>',
                ],
            ]
        );
        Section::updateOrCreate(
            ['name' => 'about_mission'],
            [
                'data' => [
                    'title' => 'Mission',
                    'image' => 'themes/default/assets/img/Air-Purify.png',
                    'content' => '<ul class=" ps-3 ">
                        <li class="text-dark-emphasis content-text mb-4">Supporting members and providing platforms
                            for Para athletes to achieve their best in
                            sports, from national competitions to the Paralympic Games.</li>
                        <li class="text-dark-emphasis content-text mb-4">Using sports as a tool for social and
                            cultural development, fostering hope, independence,
                            and showing that "disability is not inability</li>
                        <li class="text-dark-emphasis content-text mb-4">Leading the development of various Para
                            sports and helping to train coaches and
                            administrators</li>
                        <li class="text-dark-emphasis content-text mb-4">Ensuring the observance of the International
                            Paralympic Committee\'s rules and regulations
                            within Bangladesh</li>
                    </ul>',
                ],
            ]
        );
        Section::updateOrCreate(
            ['name' => 'history_history'],
            [
                'data' => [
                    'title' => 'History',
                    'image' => 'themes/default/assets/img/Air-Purify.png',
                    'content' => ' <p class="content-text text-white opacity-75">The history of the National Paralympic Committee of Bangladesh (NPCB) was formed in 1981. Bangladesh\'s debut at the Summer Paralympics was in 2004, where it sent one athlete to compete in athletics. The NPCB was formally established in 2004 and became the official national organization for para-sports, affiliated with the International Paralympic Committee (IPC). The country has since participated in every Summer Paralympics, though it has yet to win a medal.</p>
                    <ul class=" ps-3 text-white opacity-75 content-tex">
                        <li class=" t mb-4"><strong>2004: </strong>Bangladesh makes its first appearance at the 2004 Athens Summer Paralympics, sending a single athlete to compete in the men\'s 400m T46 event.</li>

                        <li class="mb-4"><strong>2004: </strong>The National Paralympic Committee of Bangladesh is officially established.</li>

                        <li class="mb-4"><strong>2008: </strong>Abdul Quader Suman represents Bangladesh at the Beijing Paralympics, competing in the men\'s 100m T12.</li>

                        <li class="mb-4"><strong>2012-2024: </strong>Bangladesh continues its participation in the Summer Paralympics.</li>

                        <li class="mb-4"><strong>2022: </strong> NPCB is granted provisional membership status by the International Paralympic Committee (IPC)..</li>
                        <li class="mb-4"><strong>Present: </strong> The organization continues its work as a para-athlete-centered, non-profit national organization based in Dhaka.</li>
                </ul>',
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
