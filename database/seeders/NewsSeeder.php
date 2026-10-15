<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::first();
        if (!$adminUser) {
            $adminUser = User::create([
                'name'     => 'Super Admin',
                'email'    => 'super@gmail.com',
                'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
            ]);
        }
        $adminId = $adminUser->id;

        // Clean up legacy gaming news articles
        $legacyKeywords = ['PUBG', 'Free Fire', 'Esports', 'Cyber Games', 'Gaming Industry', 'Online Gaming', 'gaming'];
        News::where(function ($q) use ($legacyKeywords) {
            foreach ($legacyKeywords as $kw) {
                $q->orWhere('news_title', 'like', "%{$kw}%")
                  ->orWhere('meta_keyword', 'like', "%{$kw}%");
            }
        })->delete();

        // === AIRE INDUSTRY & INDOOR AIR QUALITY NEWS ===
        $newsList = [
            [
                'news_title'       => 'AIRE Introduces Next-Generation Ductless Heat Recovery Ventilators with 99.97% PM2.5 Interception',
                'short_des'        => 'Engineered for modern high-performance residential spaces, AIRE\'s latest ductless ERV models deliver continuous fresh air exchange without thermal loss.',
                'description'      => '<h2>Revolutionizing Residential Clean Air with Decentralized ERV</h2>
<p>AIRE Industries has officially announced the launch of its next-generation line of ductless heat recovery ventilation (HRV/ERV) units. Designed specifically for apartments, modern homes, and precision cleanrooms, the new series combines medical-grade air filtration with over 70% thermal energy recovery efficiency.</p>
<p>Traditional ducted HVAC systems often recirculate stale, carbon-dioxide-heavy air or suffer from hidden duct contaminant buildup. AIRE\'s decentralized, through-the-wall architecture provides a constant stream of 100% fresh, oxygen-rich outside air while simultaneously exhausting stale indoor air, airborne allergens, and volatile organic compounds (VOCs).</p>
<h3>Key Technological Innovations</h3>
<ul>
    <li><strong>Dual Medical-Grade HEPA & PM2.5 Filtration:</strong> Captures 99.97% of particulate matter down to 0.3 microns, including pollen, pet dander, micro-dust, and smoke aerosols.</li>
    <li><strong>High-Efficiency Ceramic Enthalpy Core:</strong> Transfers sensible and latent heat between incoming and outgoing air streams, keeping winter warmth and summer cooling indoors.</li>
    <li><strong>Whisper-Quiet Brushless DC Motors:</strong> Operates at an ultra-low sound level of only 22 dB(A), ensuring peaceful sleep in bedrooms and undisturbed focus in study spaces.</li>
    <li><strong>Smart Automated Telemetry:</strong> Integrated laser PM2.5, temperature, and humidity sensors automatically regulate airflow speeds according to real-time environmental metrics.</li>
</ul>
<blockquote>"Our mission is to make whole-building fresh air accessible without the prohibitive cost and structural disruption of extensive ductwork renovation," said the Chief Technology Officer at AIRE.</blockquote>
<p>The new ductless showcase systems are now available globally through authorized HVAC distributors and our official web storefront.</p>',
                'meta_title'       => 'Next-Gen Ductless ERV Heat Recovery Ventilators | AIRE News',
                'meta_keyword'     => 'ductless ERV, heat recovery ventilation, PM2.5 filtration, fresh air, residential air purifier, AIRE HVAC',
                'meta_description' => 'AIRE launches cutting-edge ductless ERVs with 70%+ heat recovery and 99.97% PM2.5 filtration for healthy living.',
                'image'            => 'themes/default/assets/img/Air-Purify.png',
                'f_image'          => 'themes/default/assets/img/og-share-banner.jpg',
                'alt_name'         => 'AIRE Ductless Heat Recovery Ventilator System',
                'publish_date'     => now()->subDays(2),
                'featured'         => 1,
                'categories'       => ['technology-innovation', 'air-quality-health'],
            ],
            [
                'news_title'       => 'How Smart IAQ Sensors and Automated Fresh Air Combat Sick Building Syndrome in Commercial Towers',
                'short_des'        => 'New workplace telemetry confirms that real-time CO2 and VOC monitoring combined with targeted ventilation boosts workforce cognitive performance by up to 24%.',
                'description'      => '<h2>The Invisible Threat in High-Rise Office Environments</h2>
<p>A multi-center environmental study conducted across 45 corporate office towers in major metropolitan centers has highlighted the significant cognitive and health toll of poor indoor air quality (IAQ). When conference rooms and open-plan workspaces experience elevated carbon dioxide levels (>1,000 ppm) alongside accumulated off-gassing from furniture and carpets, employee fatigue increases by 38% while decision-making clarity drops sharply.</p>
<p>AIRE\'s commercial smart air management system addresses this challenge by combining high-precision NDIR (non-dispersive infrared) CO2 sensors with dynamic modulating fresh air intake units.</p>
<h3>Documented Workplace Benefits</h3>
<ul>
    <li><strong>24% Higher Cognitive Function:</strong> Independent psychometric testing revealed sharper problem-solving and rapid data retention among teams working in fresh air environments.</li>
    <li><strong>Substantial Absenteeism Reduction:</strong> Continuous viral-rated air displacement lowered annual sick leave instances by 31% over a 12-month observation window.</li>
    <li><strong>Demand-Controlled Ventilation (DCV):</strong> Energy consumption dropped by 18% because fresh air fans ramp up only when occupancy thresholds require it.</li>
</ul>
<p>Corporate facility managers can now deploy AIRE commercial air monitoring arrays with centralized cloud analytics, providing transparent environmental compliance reports in real time.</p>',
                'meta_title'       => 'Combating Sick Building Syndrome with Smart IAQ | AIRE Research',
                'meta_keyword'     => 'sick building syndrome, CO2 monitoring, commercial ventilation, workplace IAQ, cognitive performance',
                'meta_description' => 'Learn how automated IAQ monitoring and clean fresh air systems increase productivity and reduce illness in commercial buildings.',
                'image'            => 'themes/default/assets/img/Air-Purify.png',
                'f_image'          => 'themes/default/assets/img/og-share-banner.jpg',
                'alt_name'         => 'Commercial IAQ Sensor Monitoring Dashboard',
                'publish_date'     => now()->subDays(4),
                'featured'         => 1,
                'categories'       => ['green-buildings-energy', 'technology-innovation'],
            ],
            [
                'news_title'       => 'Hospital-Grade Cleanroom Filtration: The Role of Dual HEPA and Photocatalytic Neutralization in Healthcare Facilities',
                'short_des'        => 'Healthcare isolation wards and outpatient clinics are deploying AIRE precision air filtration systems for infection control and pathogen suppression.',
                'description'      => '<h2>Meeting Stringent Healthcare Infection Control Protocols</h2>
<p>Hospital-acquired infections (HAIs) and airborne pathogen transmission present severe operational hazards in clinical settings, dental operatories, and intensive care units. To establish robust biocontainment barriers, healthcare architects are increasingly specifying multi-barrier filtration systems capable of continuous air sterilization.</p>
<p>AIRE\'s Medical-Series filtration platforms utilize a synergistic four-stage decontamination architecture designed to neutralize viral aerosols, antibiotic-resistant bacteria, and volatile anesthetic gases.</p>
<h3>Multi-Barrier Sterilization Architecture</h3>
<ul>
    <li><strong>Stage 1: Antimicrobial Pre-Filter:</strong> Traps macroscopic dust, lint, and hairs, protecting downstream ultra-fine media.</li>
    <li><strong>Stage 2: Medical-Grade H13/H14 HEPA:</strong> Certified 99.995% efficiency for particulate containment down to 0.1 microns.</li>
    <li><strong>Stage 3: High-Capacity Activated Carbon Honeycomb:</strong> Adsorbs chemical fumes, formaldehyde, ethylene oxide, and medicinal odors.</li>
    <li><strong>Stage 4: Photocatalytic Titanium Dioxide (TiO2) & UV-C:</strong> Breaks down viral protein capsids and microbial DNA without generating harmful ozone byproducts.</li>
</ul>
<p>Compliant with international ISO 14644 cleanroom and CDC airborne contaminant isolation standards, AIRE healthcare units are actively serving regional hospitals and specialized respiratory clinics globally.</p>',
                'meta_title'       => 'Hospital-Grade Air Filtration & Pathogen Control | AIRE Healthcare',
                'meta_keyword'     => 'hospital air filtration, HEPA H14, infection control, cleanroom IAQ, pathogen suppression, medical air purifier',
                'meta_description' => 'Explore AIRE medical-grade HEPA and photocatalytic air filtration systems designed for healthcare infection control.',
                'image'            => 'themes/default/assets/img/Air-Purify.png',
                'f_image'          => 'themes/default/assets/img/og-share-banner.jpg',
                'alt_name'         => 'Hospital Isolation Ward Clean Air Purifier',
                'publish_date'     => now()->subDays(6),
                'featured'         => 1,
                'categories'       => ['air-quality-health', 'regulations-standards'],
            ],
            [
                'news_title'       => 'Decarbonizing Modern Architecture: Why Heat Recovery Ventilation is Crucial for Net-Zero Building Standards',
                'short_des'        => 'With 70%+ thermal efficiency, AIRE energy recovery cores drastically cut HVAC power consumption while maintaining pristine fresh airflow.',
                'description'      => '<h2>Balancing Air Tightness with Healthy Ventilation</h2>
<p>As international energy codes drive residential and commercial structures toward airtight building envelopes (Passivhaus, LEED Platinum, and BREEAM Outstanding), a fundamental dilemma emerges: airtightness conserves thermal energy but traps indoor toxins, humidity, and CO2.</p>
<p>Opening windows wastes valuable heating and cooling energy. The engineering answer is Enthalpy Recovery Ventilation (ERV), which recovers energy from exhaust air before discharging it outdoors.</p>
<h3>Energy & Carbon Savings Breakdown</h3>
<ul>
    <li><strong>Up to 72% Heat Energy Recaptured:</strong> In sub-zero winter conditions, incoming freezing air is pre-warmed by outgoing exhaust air without physical air mixing.</li>
    <li><strong>Latent Moisture Balancing:</strong> Specialized membrane cores transfer excess indoor moisture in humid climates, relieving load on air conditioners.</li>
    <li><strong>Reduced Chiller & Boiler Sizing:</strong> Architects can downsize primary HVAC mechanical plants by up to 25%, resulting in immediate capital and operational cost savings.</li>
</ul>
<p>AIRE remains dedicated to engineering ventilation solutions that empower green building developers to achieve carbon neutrality without compromising occupant respiratory wellness.</p>',
                'meta_title'       => 'Heat Recovery Ventilation in Net-Zero Architecture | AIRE Green Building',
                'meta_keyword'     => 'net-zero HVAC, green building ventilation, LEED certification, energy recovery ventilator, Passivhaus ERV',
                'meta_description' => 'Discover how AIRE heat recovery ventilation cores enable net-zero building standards and reduce HVAC energy consumption.',
                'image'            => 'themes/default/assets/img/Air-Purify.png',
                'f_image'          => 'themes/default/assets/img/og-share-banner.jpg',
                'alt_name'         => 'Net Zero Architecture Energy Recovery Core',
                'publish_date'     => now()->subDays(8),
                'featured'         => 1,
                'categories'       => ['green-buildings-energy'],
            ],
            [
                'news_title'       => 'Global Air Quality Report 2026: The Critical Importance of Micro-Fine PM2.5 and Ozone Management Indoors',
                'short_des'        => 'Urban smog and seasonal particulate spikes make sealed indoor fresh air systems indispensable for allergy and asthma protection.',
                'description'      => '<h2>Understanding Micro-Fine Particulate Exposure</h2>
<p>The World Health Organization (WHO) updated global environmental benchmarks reveal that over 90% of the world\'s population breathes ambient air that exceeds particulate safety thresholds. While exterior smog is widely discussed, indoor concentrations of PM2.5 and volatile chemicals can be 2 to 5 times higher due to inadequate air exchange.</p>
<p>Unlike larger dust grains, PM2.5 particles are capable of penetrating deep into alveolar pulmonary capillaries, triggering chronic inflammation, exacerbating childhood asthma, and impacting cardiovascular health.</p>
<h3>Proactive Indoor Defense Strategies</h3>
<ul>
    <li><strong>Continuous Positive-Pressure Ventilation:</strong> By introducing filtered air at slight positive pressure, outdoor unfiltered drafts are prevented from leaking in through window gaskets.</li>
    <li><strong>Zero-Ozone Catalytic Filtration:</strong> AIRE systems avoid ionizers that emit secondary ozone, ensuring air is cleaned purely through mechanical and physical sorption media.</li>
    <li><strong>Real-Time App Notifications:</strong> Mobile companion applications alert homeowners during outdoor wildfire smoke or pollen surges, automatically engaging high-flow boost mode.</li>
</ul>
<p>Investing in continuous indoor air purification represents an essential preventive health measure for every modern household.</p>',
                'meta_title'       => 'Global Air Quality Report 2026 & Indoor Protection | AIRE',
                'meta_keyword'     => 'PM2.5 protection, asthma indoor air, wildfire smoke filtration, WHO air standards, positive pressure IAQ',
                'meta_description' => 'Insights into the 2026 Global Air Quality Report and how AIRE positive-pressure fresh air filtration protects family health.',
                'image'            => 'themes/default/assets/img/Air-Purify.png',
                'f_image'          => 'themes/default/assets/img/og-share-banner.jpg',
                'alt_name'         => 'Global Air Quality PM2.5 Sensor Analysis',
                'publish_date'     => now()->subDays(11),
                'featured'         => 1,
                'categories'       => ['air-quality-health', 'regulations-standards'],
            ],
            [
                'news_title'       => 'AIRE Global Partners with Sustainable Housing Consortium to Deploy 15,000 Clean Air Smart Units',
                'short_des'        => 'A landmark initiative to integrate high-efficiency ductless ERVs across eco-neighborhoods in North America and Asia-Pacific.',
                'description'      => '<h2>Scaling Clean Air Infrastructure Globally</h2>
<p>AIRE Industries is proud to announce a multi-year collaborative partnership with the International Sustainable Housing Consortium (ISHC). Under this framework agreement, AIRE will supply 15,000 smart ductless energy recovery ventilators for newly developed low-emission residential communities across 12 countries.</p>
<p>The project represents one of the largest single-contract deployments of decentralized ventilation technology in modern residential development history.</p>
<h3>Partnership Milestones & Objectives</h3>
<ul>
    <li><strong>Standardized IAQ Integration:</strong> Every residential unit will feature built-in AIRE Fresh-Pro ventilation modules as standard base specification.</li>
    <li><strong>Community Energy Grid Integration:</strong> Smart IoT modules communicate with regional microgrids to optimize air exchange timing during off-peak renewable energy generation hours.</li>
    <li><strong>Long-Term IAQ Health Telemetry Study:</strong> Anonymized particulate reduction metrics will be analyzed in collaboration with environmental health research universities.</li>
</ul>
<blockquote>"Clean indoor air is not a luxury—it is a fundamental public health requirement. This partnership demonstrates that sustainable, healthy living can be achieved at scale," stated the AIRE CEO during the signing ceremony.</blockquote>',
                'meta_title'       => 'AIRE Global Partners with Sustainable Housing Consortium | Corporate News',
                'meta_keyword'     => 'AIRE partnership, sustainable housing, ISHC agreement, green community HVAC, corporate announcement',
                'meta_description' => 'AIRE partners with Sustainable Housing Consortium to install 15,000 smart ductless ERV units across eco-neighborhoods.',
                'image'            => 'themes/default/assets/img/Air-Purify.png',
                'f_image'          => 'themes/default/assets/img/og-share-banner.jpg',
                'alt_name'         => 'Sustainable Housing Community Partnership Signing',
                'publish_date'     => now()->subDays(14),
                'featured'         => 1,
                'categories'       => ['corporate-case-studies', 'green-buildings-energy'],
            ],
            [
                'news_title'       => 'Understanding ASHRAE 241 & Indoor Infection Risk Mitigation in Public and Educational Facilities',
                'short_des'        => 'A deep dive into new aerosol management regulations and clean air delivery rates (CADR) required for schools and conference hubs.',
                'description'      => '<h2>The Evolution of Standardized Clean Air Delivery</h2>
<p>Following the ratification of ASHRAE Standard 241 (Control of Infectious Aerosols), commercial facilities, educational institutions, and civic venues must now meet strict "equivalent clean airflow" requirements per occupant during declared infection risk periods.</p>
<p>Traditional HVAC systems designed solely for temperature control often fall short of these clean airflow benchmarks. AIRE provides modular supplementary filtration units that enable facilities to achieve full compliance without costly central air-handling overhauls.</p>
<h3>Compliance Checklist for Facility Operators</h3>
<ul>
    <li>Calculate target Equivalent Clean Airflow per person (ECAi) based on room volume and occupancy density.</li>
    <li>Upgrade primary filtration stages to certified MERV 13 or H13 HEPA equivalents.</li>
    <li>Incorporate continuous optical particulate sensing for real-time verification and automated compliance logging.</li>
</ul>
<p>AIRE\'s engineering advisory team offers complimentary building IAQ assessments to help educational administrators ensure their classrooms exceed national safety standards.</p>',
                'meta_title'       => 'ASHRAE 241 Compliance Guide for Schools & Offices | AIRE Standards',
                'meta_keyword'     => 'ASHRAE 241, infectious aerosol control, school ventilation, ECAi calculation, clean air delivery rate',
                'meta_description' => 'A comprehensive guide to meeting ASHRAE Standard 241 requirements for educational and commercial facilities with AIRE.',
                'image'            => 'themes/default/assets/img/Air-Purify.png',
                'f_image'          => 'themes/default/assets/img/og-share-banner.jpg',
                'alt_name'         => 'Educational Classroom Clean Air Ventilation',
                'publish_date'     => now()->subDays(18),
                'featured'         => 0,
                'categories'       => ['regulations-standards'],
            ],
            [
                'news_title'       => 'Acoustic Engineering in Ultra-Quiet Air Purifiers: Achieving 22dB Whispering Operation for Better Sleep',
                'short_des'        => 'How aerodynamically profiled fan blades and brushless DC motors allow AIRE residential units to purify air without disrupting sleep.',
                'description'      => '<h2>Silent Engineering for Restful Nights</h2>
<p>A frequent complaint regarding traditional air purifiers is mechanical motor hum and turbulent air whistling at night. Research has proven that even moderate ambient fan noise above 35 dB can disrupt deep REM sleep cycles and elevate cortisol levels.</p>
<p>AIRE\'s acoustic engineering laboratory has developed a bio-inspired aerodynamic impeller design paired with precision sine-wave brushless DC motors, achieving near-silent 22 dB(A) operation on night mode.</p>
<h3>Acoustic Breakthrough Highlights</h3>
<ul>
    <li><strong>Serrated Trailing-Edge Blades:</strong> Inspired by owl wing aerodynamics, serrated fan trailing edges break large turbulent vortices into microscopic, inaudible eddies.</li>
    <li><strong>Vibration-Isolated Motor Mounts:</strong> Multi-axis silicone dampening blocks eliminate structural motor vibration before it transfers to the outer casing.</li>
    <li><strong>Laminar Flow Exhaust Chambers:</strong> Specially curved internal air channels ensure smooth air ejection with zero whistling resonance.</li>
</ul>
<p>Experience uninterrupted sleep and wake up breathing pure, revitalizing air with AIRE residential smart purifiers.</p>',
                'meta_title'       => 'Acoustic Engineering & Ultra-Quiet 22dB Air Purification | AIRE',
                'meta_keyword'     => 'quiet air purifier, 22dB sleep mode, acoustic fan engineering, brushless DC motor, bedroom clean air',
                'meta_description' => 'Learn how AIRE acoustic engineering and bio-inspired fan blades deliver whispering 22dB air purification for peaceful sleep.',
                'image'            => 'themes/default/assets/img/Air-Purify.png',
                'f_image'          => 'themes/default/assets/img/og-share-banner.jpg',
                'alt_name'         => 'Acoustic Sound Laboratory Fan Testing',
                'publish_date'     => now()->subDays(22),
                'featured'         => 0,
                'categories'       => ['technology-innovation'],
            ],
        ];

        foreach ($newsList as $item) {
            $categorySlugs = $item['categories'] ?? [];
            unset($item['categories']);

            $slug = Str::slug($item['news_title']);
            $item['slug'] = $slug;
            $item['status'] = 1;
            $item['createdBy'] = $adminId;
            $item['updatedBy'] = $adminId;

            $newsRecord = News::updateOrCreate(
                ['slug' => $slug],
                $item
            );

            // Attach mapped categories
            if (!empty($categorySlugs)) {
                $categoryIds = NewsCategory::whereIn('slug', $categorySlugs)->pluck('id')->toArray();
                if (!empty($categoryIds)) {
                    $newsRecord->categories()->sync($categoryIds);
                }
            }
        }
    }
}
