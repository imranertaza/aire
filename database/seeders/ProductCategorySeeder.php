<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('product_to_categories')->truncate();
        DB::table('product_categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $categories = [
            // 1. PRODUCTS (Parent Category - 6 Subcategories)
            [
                'category_name' => 'Products',
                'slug'          => 'products',
                'description'   => 'Explore high-performance air purification systems, smart sensors, protective masks, accessories, and replacement parts.',
                'icon_class'    => 'bi bi-box-seam',
                'image'         => 'categories/products.jpg',
                'sort_order'    => 1,
                'subcategories' => [
                    [
                        'category_name' => 'Fresh Air Systems',
                        'slug'          => 'fresh-air-systems',
                        'description'   => 'Industrial and residential fresh air exchange systems for continuous ventilation.',
                        'icon_class'    => 'bi bi-wind',
                        'subcategories' => [
                            ['category_name' => 'Home Fresh Air Systems', 'slug' => 'home-fresh-air-systems', 'description' => 'Advanced home ventilation systems providing continuous fresh, clean air.', 'icon_class' => 'bi bi-house-door'],
                            ['category_name' => 'Commercial Fresh Air Systems', 'slug' => 'commercial-fresh-air-systems', 'description' => 'High-capacity air exchange systems built for offices and retail spaces.', 'icon_class' => 'bi bi-building'],
                            ['category_name' => 'Industrial Fresh Air Systems', 'slug' => 'industrial-fresh-air-systems', 'description' => 'Heavy-duty ventilation units engineered for factories and manufacturing facilities.', 'icon_class' => 'bi bi-gear-wide-connected'],
                        ]
                    ],
                    [
                        'category_name' => 'Air Purifiers',
                        'slug'          => 'air-purifiers',
                        'description'   => 'State-of-the-art air purifiers featuring True HEPA H13 filtration.',
                        'icon_class'    => 'bi bi-funnel',
                        'subcategories' => [
                            ['category_name' => 'Air Purifiers for Home', 'slug' => 'air-purifiers-for-home', 'description' => 'Compact and powerful room purifiers designed for quiet residential use.', 'icon_class' => 'bi bi-house-heart'],
                            ['category_name' => 'Air Purifiers for Commercial', 'slug' => 'air-purifiers-for-commercial', 'description' => 'High CADR air purification units for lobbies, conference rooms, and open offices.', 'icon_class' => 'bi bi-briefcase'],
                            ['category_name' => 'Air Purifiers for Healthcare', 'slug' => 'air-purifiers-for-healthcare', 'description' => 'Medical-grade air purifiers engineered for clinics, ICUs, and patient rooms.', 'icon_class' => 'bi bi-hospital'],
                        ]
                    ],
                    [
                        'category_name' => 'Monitoring & Sensors',
                        'slug'          => 'monitoring-sensors',
                        'description'   => 'Real-time air quality monitors and environmental sensors.',
                        'icon_class'    => 'bi bi-broadcast',
                        'subcategories' => [
                            ['category_name' => 'Indoor Air Quality Sensors', 'slug' => 'indoor-air-quality-sensors', 'description' => 'Precision PM2.5, VOC, CO2, and humidity sensors for continuous monitoring.', 'icon_class' => 'bi bi-activity'],
                            ['category_name' => 'AIRE Dashboard Platform', 'slug' => 'aire-dashboard-platform', 'description' => 'Centralized IoT cloud dashboard for real-time facility air metrics and analytics.', 'icon_class' => 'bi bi-display'],
                        ]
                    ],
                    [
                        'category_name' => 'Protective Masks',
                        'slug'          => 'protective-masks',
                        'description'   => 'Active wearable masks and certified particulate respirators.',
                        'icon_class'    => 'bi bi-mask',
                        'subcategories' => [
                            ['category_name' => 'Smart Wearable Masks', 'slug' => 'smart-wearable-masks', 'description' => 'Battery-powered active fan masks delivering effortless breathing.', 'icon_class' => 'bi bi-mask'],
                            ['category_name' => 'N95 & Respirator Masks', 'slug' => 'n95-respirator-masks', 'description' => 'NIOSH-certified N95 respirators for high-risk environments.', 'icon_class' => 'bi bi-shield-check'],
                            ['category_name' => 'Reusable Cloth Masks', 'slug' => 'reusable-cloth-masks', 'description' => 'Washable ergonomic cloth masks with replaceable filter inserts.', 'icon_class' => 'bi bi-person-badge'],
                        ]
                    ],
                    [
                        'category_name' => 'Accessories & Parts',
                        'slug'          => 'accessories-parts',
                        'description'   => 'Genuine replacement filters, pre-filters, and hardware modules.',
                        'icon_class'    => 'bi bi-sliders',
                        'subcategories' => [
                            ['category_name' => 'Replacement Filters', 'slug' => 'replacement-filters', 'description' => 'Authentic H13 HEPA and activated carbon filter replacements.', 'icon_class' => 'bi bi-funnel'],
                            ['category_name' => 'Spare Parts & Modules', 'slug' => 'spare-parts-modules', 'description' => 'OEM replacement fan motors, power supplies, and sensor modules.', 'icon_class' => 'bi bi-tools'],
                        ]
                    ],
                    [
                        'category_name' => 'Smart Controls',
                        'slug'          => 'smart-controls',
                        'description'   => 'Intelligent automation and mobile control solutions.',
                        'icon_class'    => 'bi bi-gear',
                        'subcategories' => [
                            ['category_name' => 'AIRE Smart App', 'slug' => 'aire-smart-app', 'description' => 'Mobile app for remote monitoring, custom schedules, and automated alerts.', 'icon_class' => 'bi bi-phone-vibrate'],
                            ['category_name' => 'Building Automation Integration', 'slug' => 'building-automation-integration', 'description' => 'BACnet and Modbus protocol adapters for smart building management.', 'icon_class' => 'bi bi-diagram-3'],
                        ]
                    ],
                ],
            ],

            // 2. SOLUTIONS (Parent Category - 6 Subcategories)
            [
                'category_name' => 'Solutions',
                'slug'          => 'solutions',
                'description'   => 'Custom engineered air solutions tailored for health, energy efficiency, infection control, compliance, and smart building environments.',
                'icon_class'    => 'bi bi-lightbulb',
                'image'         => 'categories/solutions.jpg',
                'sort_order'    => 2,
                'subcategories' => [
                    [
                        'category_name' => 'Health & Wellbeing Solutions',
                        'slug'          => 'health-wellbeing-solutions',
                        'description'   => 'Our solutions improve indoor air quality by removing pollutants, reducing allergens and ensuring a continuous supply of fresh air.',
                        'icon_class'    => 'bi bi-shield-check',
                        'subcategories' => [
                            ['category_name' => 'Remove PM2.5 & Pollutants', 'slug' => 'remove-pm25-pollutants', 'description' => 'Advanced filtration that captures 99.9% of PM2.5 and airborne pollutants.', 'icon_class' => 'bi bi-snow'],
                            ['category_name' => 'Virus & Bacteria Protection', 'slug' => 'virus-bacteria-protection', 'description' => 'Electrostatic technology kills viruses and bacteria for a safer environment.', 'icon_class' => 'bi bi-shield-check'],
                            ['category_name' => 'Reduce Allergens', 'slug' => 'reduce-allergens', 'description' => 'Eliminate pollen, dust mites and other common allergens from indoor air.', 'icon_class' => 'bi bi-flower1'],
                            ['category_name' => 'Oxygen & CO2 Balance', 'slug' => 'oxygen-co2-balance', 'description' => 'Maintain optimal oxygen levels and reduce CO2 for better comfort and focus.', 'icon_class' => 'bi bi-cloud'],
                            ['category_name' => 'Ventilation & Fresh Air', 'slug' => 'ventilation-fresh-air', 'description' => 'Bring in 100% fresh air and improve overall air circulation.', 'icon_class' => 'bi bi-wind'],
                            ['category_name' => 'Comfort & Wellbeing', 'slug' => 'comfort-wellbeing', 'description' => 'Consistent, clean air for better sleep, health and productivity.', 'icon_class' => 'bi bi-house'],
                        ]
                    ],
                    [
                        'category_name' => 'Energy Efficiency Solutions',
                        'slug'          => 'energy-efficiency-solutions',
                        'description'   => 'Optimize indoor air quality while minimizing energy consumption with smart, demand-driven systems.',
                        'icon_class'    => 'bi bi-lightning-charge',
                        'subcategories' => [
                            ['category_name' => 'High Efficiency Ventilation', 'slug' => 'high-efficiency-ventilation', 'description' => 'Low-energy EC fans and optimized aerodynamics for minimal power usage.', 'icon_class' => 'bi bi-wind'],
                            ['category_name' => 'Smart Controls & Auto', 'slug' => 'smart-controls-auto', 'description' => 'AI-driven systems that adjust automatically to occupancy and air quality.', 'icon_class' => 'bi bi-cpu'],
                            ['category_name' => 'Demand Controlled Vent', 'slug' => 'demand-controlled-vent', 'description' => 'Supply exactly the right amount of fresh air, exactly when and where needed.', 'icon_class' => 'bi bi-graph-up-arrow'],
                            ['category_name' => 'Energy Recovery', 'slug' => 'energy-recovery', 'description' => 'Recover heat and cooling from exhaust air to dramatically reduce energy costs.', 'icon_class' => 'bi bi-arrow-repeat'],
                        ]
                    ],
                    [
                        'category_name' => 'Sick Building Prevention',
                        'slug'          => 'sick-building-prevention',
                        'description'   => 'Combat Sick Building Syndrome with comprehensive solutions that eliminate VOCs, mold, and stagnant air to create healthy indoor environments.',
                        'icon_class'    => 'bi bi-building-exclamation',
                        'subcategories' => [
                            ['category_name' => 'Advanced VOC Filtration', 'slug' => 'advanced-voc-filtration', 'description' => 'Specialized carbon filters that remove harmful chemical off-gassing from furniture and materials.', 'icon_class' => 'bi bi-funnel'],
                            ['category_name' => 'Humidity & Mold Control', 'slug' => 'humidity-mold-control', 'description' => 'Maintain ideal 40-60% humidity levels to completely prevent mold and mildew growth.', 'icon_class' => 'bi bi-droplet-half'],
                            ['category_name' => 'IAQ Monitoring', 'slug' => 'iaq-monitoring', 'description' => 'Real-time dashboards that track pollutants, temperature and CO2 to ensure a healthy environment.', 'icon_class' => 'bi bi-display'],
                            ['category_name' => 'Active Odor Neutralization', 'slug' => 'active-odor-neutralization', 'description' => 'Eliminate persistent odors rather than masking them, creating a fresh, pleasant indoor atmosphere.', 'icon_class' => 'bi bi-wind'],
                        ]
                    ],
                    [
                        'category_name' => 'Infection Control',
                        'slug'          => 'infection-control',
                        'description'   => "Reduce airborne pathogen transmission with AIRE's proven clinical-grade air purification and UV sterilization systems, designed for healthcare, schools and high-traffic public environments.",
                        'icon_class'    => 'bi bi-virus',
                        'subcategories' => [
                            ['category_name' => 'Hospital-Grade Air Sterilizers', 'slug' => 'hospital-grade-air-sterilizers', 'description' => 'Medical-grade portable air sterilizers using HEPA H14 and UV-C for surgical rooms and intensive care units.', 'icon_class' => 'bi bi-virus2'],
                            ['category_name' => 'School & Public Space Solutions', 'slug' => 'school-public-space-solutions', 'description' => 'Ceiling-integrated HEPA systems that reduce viral load in classrooms, gyms, and public transport hubs.', 'icon_class' => 'bi bi-people'],
                        ]
                    ],
                    [
                        'category_name' => 'Air Quality Compliance',
                        'slug'          => 'air-quality-compliance',
                        'description'   => "Stay ahead of indoor air quality regulations with AIRE's comprehensive compliance monitoring and reporting solutions — meeting ASHRAE, WHO, EN 16798, and local environmental standards.",
                        'icon_class'    => 'bi bi-clipboard-check',
                        'subcategories' => [
                            ['category_name' => 'IAQ Compliance Platform', 'slug' => 'iaq-compliance-platform', 'description' => 'Cloud-based platform that tracks, logs, and exports air quality data in formats accepted by regulatory bodies worldwide.', 'icon_class' => 'bi bi-file-earmark-text'],
                            ['category_name' => 'On-Site IAQ Audit Service', 'slug' => 'on-site-iaq-audit-service', 'description' => "Expert AIRE engineers assess your building's air quality and provide a comprehensive remediation roadmap.", 'icon_class' => 'bi bi-search'],
                        ]
                    ],
                    [
                        'category_name' => 'Smart Building Solutions',
                        'slug'          => 'smart-building-solutions',
                        'description'   => "Integrate AIRE's air quality systems with your building management ecosystem for intelligent, automated air quality control that responds in real time to occupancy and environmental conditions.",
                        'icon_class'    => 'bi bi-cpu',
                        'subcategories' => [
                            ['category_name' => 'AIRE Building OS', 'slug' => 'aire-building-os', 'description' => 'A complete operating system for building air quality — integrating sensors, purifiers, and ventilation into one intelligent platform.', 'icon_class' => 'bi bi-building-gear'],
                            ['category_name' => 'IoT Sensor Network', 'slug' => 'iot-sensor-network', 'description' => 'Deploy a mesh network of wireless AIRE sensors throughout your building for granular, zone-level air quality intelligence.', 'icon_class' => 'bi bi-diagram-3'],
                        ]
                    ],
                ],
            ],

            // 3. INDUSTRIES (Parent Category - 7 Subcategories)
            [
                'category_name' => 'Industries',
                'slug'          => 'industries',
                'description'   => 'Specialized air quality engineering for residential, commercial, healthcare, and industrial sectors.',
                'icon_class'    => 'bi bi-buildings',
                'image'         => 'categories/industries.jpg',
                'sort_order'    => 3,
                'subcategories' => [
                    [
                        'category_name' => 'Residential Solutions',
                        'slug'          => 'residential-solutions',
                        'description'   => 'Tailored air purification for modern living spaces.',
                        'icon_class'    => 'bi bi-house',
                        'subcategories' => [
                            ['category_name' => 'Apartments', 'slug' => 'apartments', 'description' => 'Compact IAQ systems engineered for high-rise apartment living.', 'icon_class' => 'bi bi-building'],
                            ['category_name' => 'Villas', 'slug' => 'villas', 'description' => 'Multi-zone whole-house fresh air and filtration systems for luxury residences.', 'icon_class' => 'bi bi-house-heart'],
                        ]
                    ],
                    [
                        'category_name' => 'Commercial Solutions',
                        'slug'          => 'commercial-solutions',
                        'description'   => 'Clean air solutions for commercial real estate and retail environments.',
                        'icon_class'    => 'bi bi-building',
                        'subcategories' => [
                            ['category_name' => 'Offices', 'slug' => 'offices', 'description' => 'Quiet, high-volume air purifiers promoting employee wellness and productivity.', 'icon_class' => 'bi bi-laptop'],
                            ['category_name' => 'Retail Centers', 'slug' => 'retail-centers', 'description' => 'High-traffic IAQ systems ensuring clean air for shoppers and staff.', 'icon_class' => 'bi bi-shop'],
                        ]
                    ],
                    [
                        'category_name' => 'Healthcare Solutions',
                        'slug'          => 'healthcare-solutions',
                        'description'   => 'Infection control and ultra-clean air systems for medical facilities.',
                        'icon_class'    => 'bi bi-heart-pulse',
                        'subcategories' => [
                            ['category_name' => 'Hospitals', 'slug' => 'hospitals', 'description' => 'Negative pressure isolation and HEPA filtration for hospital wards.', 'icon_class' => 'bi bi-heart-pulse'],
                            ['category_name' => 'Clinics', 'slug' => 'clinics', 'description' => 'Compact medical-grade air purifiers for waiting rooms and examination rooms.', 'icon_class' => 'bi bi-capsule'],
                        ]
                    ],
                    [
                        'category_name' => 'Education Solutions',
                        'slug'          => 'education-solutions',
                        'description'   => 'Clean air systems protecting students and educators.',
                        'icon_class'    => 'bi bi-mortarboard',
                        'subcategories' => [
                            ['category_name' => 'Schools', 'slug' => 'schools', 'description' => 'Low-noise classroom air purifiers reducing sick days and airborne illness.', 'icon_class' => 'bi bi-book'],
                            ['category_name' => 'Universities', 'slug' => 'universities', 'description' => 'Campus-wide indoor air quality monitoring and purification networks.', 'icon_class' => 'bi bi-bank'],
                        ]
                    ],
                    [
                        'category_name' => 'Transportation Solutions',
                        'slug'          => 'transportation-solutions',
                        'description'   => 'Heavy-duty filtration for transit hubs and passenger terminals.',
                        'icon_class'    => 'bi bi-train-front',
                        'subcategories' => [
                            ['category_name' => 'Airports', 'slug' => 'airports', 'description' => 'High-volume air scrubbers for airport concourses and baggage halls.', 'icon_class' => 'bi bi-airplane'],
                            ['category_name' => 'Metro Stations', 'slug' => 'metro-stations', 'description' => 'Subway platform air filtration removing brake dust and particulate.', 'icon_class' => 'bi bi-train-front'],
                        ]
                    ],
                    [
                        'category_name' => 'Industrial Solutions',
                        'slug'          => 'industrial-solutions',
                        'description'   => 'Industrial air filtration protecting workers and heavy machinery.',
                        'icon_class'    => 'bi bi-cone-striped',
                        'subcategories' => [
                            ['category_name' => 'Factories', 'slug' => 'factories', 'description' => 'Heavy fume, dust, and oil mist extraction systems for manufacturing.', 'icon_class' => 'bi bi-factory'],
                            ['category_name' => 'Warehouses', 'slug' => 'warehouses', 'description' => 'High-bay dust collection and air circulation systems for logistics hubs.', 'icon_class' => 'bi bi-box-seam'],
                        ]
                    ],
                    [
                        'category_name' => 'Infrastructure Solutions',
                        'slug'          => 'infrastructure-solutions',
                        'description'   => 'Public sector and municipal building air safety installations.',
                        'icon_class'    => 'bi bi-bank',
                        'subcategories' => [
                            ['category_name' => 'Govt. Buildings', 'slug' => 'govt-buildings', 'description' => 'Secure, high-reliability IAQ systems for government offices.', 'icon_class' => 'bi bi-shield-lock'],
                            ['category_name' => 'Public Spaces', 'slug' => 'public-spaces', 'description' => 'Architectural air purification towers for public auditoriums and museum halls.', 'icon_class' => 'bi bi-people'],
                        ]
                    ],
                ],
            ],

            // 4. TECHNOLOGIES (Parent Category - 6 Subcategories)
            [
                'category_name' => 'Technologies',
                'slug'          => 'technologies',
                'description'   => 'Advanced technologies for cleaner, smarter, healthier spaces — engineered for maximum efficiency, precision filtration, and continuous air quality intelligence.',
                'icon_class'    => 'bi bi-cpu',
                'image'         => 'categories/technologies.jpg',
                'sort_order'    => 4,
                'subcategories' => [
                    [
                        'category_name' => 'Fresh Air & Ventilation',
                        'slug'          => 'tech-fresh-air-ventilation',
                        'description'   => 'Continuous outdoor air intake with multi-stage filtration and energy recovery.',
                        'icon_class'    => 'bi bi-wind',
                        'subcategories' => [
                            ['category_name' => 'Home Fresh Air Tech', 'slug' => 'home-fresh-air-tech', 'description' => 'Acoustically insulated fresh air induction for residential spaces.', 'icon_class' => 'bi bi-house-door'],
                            ['category_name' => 'Commercial Fresh Air Tech', 'slug' => 'commercial-fresh-air-tech', 'description' => 'High-capacity continuous fresh air supply for commercial complexes.', 'icon_class' => 'bi bi-building'],
                            ['category_name' => 'Industrial Fresh Air Tech', 'slug' => 'industrial-fresh-air-tech', 'description' => 'Extreme duty ventilation for demanding manufacturing environments.', 'icon_class' => 'bi bi-gear-wide-connected'],
                            ['category_name' => 'ERV & HRV Technology', 'slug' => 'erv-hrv-technology', 'description' => 'Enthalpy and heat recovery cores recycling thermal energy.', 'icon_class' => 'bi bi-arrow-repeat'],
                        ]
                    ],
                    [
                        'category_name' => 'Air Purification',
                        'slug'          => 'tech-air-purification',
                        'description'   => 'Multi-stage medical grade particulate and molecular gas-phase filtration systems.',
                        'icon_class'    => 'bi bi-funnel',
                        'subcategories' => [
                            ['category_name' => 'True HEPA H13/H14 Tech', 'slug' => 'true-hepa-h13-h14-tech', 'description' => 'Medical grade 99.995% micro-particulate containment filters.', 'icon_class' => 'bi bi-shield-check'],
                            ['category_name' => 'Electrostatic Precipitation', 'slug' => 'electrostatic-precipitation', 'description' => 'High-voltage electronic ionization capturing ultra-fine smoke and pathogens.', 'icon_class' => 'bi bi-lightning-charge'],
                            ['category_name' => 'Activated Carbon Adsorption', 'slug' => 'activated-carbon-adsorption', 'description' => 'Micro-porous carbon matrix eliminating volatile organic compounds (VOCs).', 'icon_class' => 'bi bi-flower1'],
                            ['category_name' => 'UV-C Germicidal Sterilization', 'slug' => 'uv-c-germicidal-sterilization', 'description' => '254nm ultraviolet germicidal irradiation destroying virus and bacterial DNA.', 'icon_class' => 'bi bi-sun'],
                        ]
                    ],
                    [
                        'category_name' => 'Heat Recovery',
                        'slug'          => 'tech-heat-recovery',
                        'description'   => 'Advanced thermal energy recovery cores maximizing heating and cooling efficiency.',
                        'icon_class'    => 'bi bi-thermometer-half',
                        'subcategories' => [
                            ['category_name' => 'Counterflow Heat Exchangers', 'slug' => 'counterflow-heat-exchangers', 'description' => 'Cross-counterflow polymer cores with up to 93% thermal efficiency.', 'icon_class' => 'bi bi-arrow-left-right'],
                            ['category_name' => 'Rotary Energy Recovery Wheels', 'slug' => 'rotary-energy-recovery-wheels', 'description' => 'Desiccant-coated thermal wheels transferring latent and sensible energy.', 'icon_class' => 'bi bi-pie-chart'],
                            ['category_name' => 'Enthalpy Core Technology', 'slug' => 'enthalpy-core-technology', 'description' => 'Moisture-permeable membranes balancing indoor humidity year-round.', 'icon_class' => 'bi bi-droplet'],
                            ['category_name' => 'Intelligent Defrost Systems', 'slug' => 'intelligent-defrost-systems', 'description' => 'Adaptive pre-heating and bypass loops preventing core frost buildup.', 'icon_class' => 'bi bi-snow'],
                        ]
                    ],
                    [
                        'category_name' => 'Monitoring & Sensing',
                        'slug'          => 'tech-monitoring-sensing',
                        'description'   => 'High-precision optical, laser, and electrochemical sensors with continuous cloud calibration.',
                        'icon_class'    => 'bi bi-broadcast',
                        'subcategories' => [
                            ['category_name' => 'Laser PM2.5/PM10 Sensors', 'slug' => 'laser-pm25-pm10-sensors', 'description' => 'Mie scattering laser sensors measuring particle mass concentrations in real time.', 'icon_class' => 'bi bi-activity'],
                            ['category_name' => 'NDIR CO2 Sensors', 'slug' => 'ndir-co2-sensors', 'description' => 'Dual-beam Non-Dispersive Infrared sensors detecting carbon dioxide buildup.', 'icon_class' => 'bi bi-cloud'],
                            ['category_name' => 'Multi-Gas VOC Sensors', 'slug' => 'multi-gas-voc-sensors', 'description' => 'Metal-oxide semiconductor sensors detecting formaldehyde, benzene, and odors.', 'icon_class' => 'bi bi-funnel'],
                            ['category_name' => 'Environmental IAQ Metrics', 'slug' => 'environmental-iaq-metrics', 'description' => 'Comprehensive multi-parameter sensor arrays with real-time AQI indexing.', 'icon_class' => 'bi bi-speedometer2'],
                        ]
                    ],
                    [
                        'category_name' => 'Smart Control',
                        'slug'          => 'tech-smart-control',
                        'description'   => 'AI-driven automated airflow modulation, schedule automation, and BMS integration.',
                        'icon_class'    => 'bi bi-cpu',
                        'subcategories' => [
                            ['category_name' => 'AI Predictive Airflow', 'slug' => 'ai-predictive-airflow', 'description' => 'Machine learning algorithms adjusting fan velocity before pollution spikes occur.', 'icon_class' => 'bi bi-cpu'],
                            ['category_name' => 'BACnet & Modbus BMS Sync', 'slug' => 'bacnet-modbus-bms-sync', 'description' => 'Direct protocol bridge connecting AIRE hardware to central building systems.', 'icon_class' => 'bi bi-diagram-3'],
                            ['category_name' => 'AIRE Cloud App & API', 'slug' => 'aire-cloud-app-api', 'description' => 'Secure REST and WebSocket APIs for enterprise facility management.', 'icon_class' => 'bi bi-phone'],
                            ['category_name' => 'Automated Zone Balancing', 'slug' => 'automated-zone-balancing', 'description' => 'Motorized damper control delivering targeted ventilation to active rooms.', 'icon_class' => 'bi bi-sliders'],
                        ]
                    ],
                    [
                        'category_name' => 'Healthy Building',
                        'slug'          => 'tech-healthy-building',
                        'description'   => 'Building envelope engineering aligned with WELL, LEED, and RESET standards.',
                        'icon_class'    => 'bi bi-heart-pulse',
                        'subcategories' => [
                            ['category_name' => 'WELL Standard Alignment', 'slug' => 'well-standard-alignment', 'description' => 'Meets and exceeds strict WELL Air feature performance verification metrics.', 'icon_class' => 'bi bi-patch-check'],
                            ['category_name' => 'LEED Air Quality Systems', 'slug' => 'leed-air-quality-systems', 'description' => 'High-efficiency ventilation earning maximum LEED IAQ innovation points.', 'icon_class' => 'bi bi-award'],
                            ['category_name' => 'Positive Pressure Envelopes', 'slug' => 'positive-pressure-envelopes', 'description' => 'Maintains micro-positive pressure preventing untreated outdoor air infiltration.', 'icon_class' => 'bi bi-shield-lock'],
                            ['category_name' => 'Pathogen Barrier Architecture', 'slug' => 'pathogen-barrier-architecture', 'description' => 'Directional laminar airflow preventing aerosol cross-contamination.', 'icon_class' => 'bi bi-virus'],
                        ]
                    ],
                ],
            ],

            // 5. MONITORING (Parent Category - 5 Subcategories)
            [
                'category_name' => 'Monitoring',
                'slug'          => 'monitoring',
                'description'   => 'Enterprise air quality intelligence platform — IoT sensing devices, live dashboards, predictive analytics, and automated compliance reporting.',
                'icon_class'    => 'bi bi-display',
                'image'         => 'categories/monitoring.jpg',
                'sort_order'    => 5,
                'subcategories' => [
                    [
                        'category_name' => 'Devices & Sensors',
                        'slug'          => 'monitoring-devices-sensors',
                        'description'   => 'Precision IoT environmental sensors for granular room-level and facility tracking.',
                        'icon_class'    => 'bi bi-broadcast',
                        'subcategories' => [
                            ['category_name' => 'Ambient IAQ Monitors', 'slug' => 'ambient-iaq-monitors', 'description' => 'Wall-mounted multi-sensor units tracking 9 core IAQ parameters.', 'icon_class' => 'bi bi-display'],
                            ['category_name' => 'Duct & In-Line Probes', 'slug' => 'duct-in-line-probes', 'description' => 'High-velocity airflow and particulate probes for HVAC duct systems.', 'icon_class' => 'bi bi-tools'],
                            ['category_name' => 'Outdoor Ambient Stations', 'slug' => 'outdoor-ambient-stations', 'description' => 'Weatherproof reference monitors comparing outdoor baseline air quality.', 'icon_class' => 'bi bi-cloud-sun'],
                        ]
                    ],
                    [
                        'category_name' => 'Software & Platform',
                        'slug'          => 'monitoring-software-platform',
                        'description'   => 'Centralized cloud management console for multi-building facilities.',
                        'icon_class'    => 'bi bi-laptop',
                        'subcategories' => [
                            ['category_name' => 'AIRE Cloud Dashboard', 'slug' => 'aire-cloud-dashboard', 'description' => 'Real-time telemetry, heatmaps, and customizable widget views.', 'icon_class' => 'bi bi-speedometer2'],
                            ['category_name' => 'Enterprise Multi-Site Hub', 'slug' => 'enterprise-multi-site-hub', 'description' => 'Unified global portfolio monitoring with role-based access control.', 'icon_class' => 'bi bi-buildings'],
                        ]
                    ],
                    [
                        'category_name' => 'Alerts & Notifications',
                        'slug'          => 'monitoring-alerts-notifications',
                        'description'   => 'Real-time alert dispatching via SMS, Email, Webhooks, and Mobile Push.',
                        'icon_class'    => 'bi bi-bell',
                        'subcategories' => [
                            ['category_name' => 'Threshold Spike Alarms', 'slug' => 'threshold-spike-alarms', 'description' => 'Instant escalation alerts when PM2.5, VOCs, or CO2 breach safety thresholds.', 'icon_class' => 'bi bi-exclamation-triangle'],
                            ['category_name' => 'Preventative Filter Warnings', 'slug' => 'preventative-filter-warnings', 'description' => 'Predictive maintenance notifications based on differential pressure load.', 'icon_class' => 'bi bi-clock-history'],
                        ]
                    ],
                    [
                        'category_name' => 'Applications',
                        'slug'          => 'monitoring-applications',
                        'description'   => 'Dedicated mobile and kiosk software for occupants and facility teams.',
                        'icon_class'    => 'bi bi-phone',
                        'subcategories' => [
                            ['category_name' => 'Public Display Kiosk App', 'slug' => 'public-display-kiosk-app', 'description' => 'Lobby and reception air quality transparency dashboard displays.', 'icon_class' => 'bi bi-tv'],
                            ['category_name' => 'AIRE Mobile App (iOS/Android)', 'slug' => 'aire-mobile-app', 'description' => 'Personal air quality tracking, notifications, and remote unit control.', 'icon_class' => 'bi bi-phone'],
                        ]
                    ],
                    [
                        'category_name' => 'Reports & Analytics',
                        'slug'          => 'monitoring-reports-analytics',
                        'description'   => 'Automated ESG, compliance, and energy optimization reports.',
                        'icon_class'    => 'bi bi-file-earmark-bar-graph',
                        'subcategories' => [
                            ['category_name' => 'WELL / LEED Compliance Export', 'slug' => 'well-leed-compliance-export', 'description' => 'One-click auditor-ready air quality compliance certificates.', 'icon_class' => 'bi bi-file-earmark-pdf'],
                            ['category_name' => 'Energy & IAQ Correlation Reports', 'slug' => 'energy-iaq-correlation-reports', 'description' => 'Deep analytics highlighting ventilation savings and occupancy trends.', 'icon_class' => 'bi bi-graph-up-arrow'],
                        ]
                    ],
                ],
            ],
        ];

        $getCatColor = function ($name, $slug) {
            $str = strtolower($name . ' ' . $slug);
            if (str_contains($str, 'hospital') || str_contains($str, 'healthcare') || str_contains($str, 'medical') || str_contains($str, 'purification') || str_contains($str, 'hepa') || str_contains($str, 'uv-c')) return '#00c853';
            if (str_contains($str, 'residential') || str_contains($str, 'home') || str_contains($str, 'fresh-air') || str_contains($str, 'ventilation')) return '#0066cc';
            if (str_contains($str, 'commercial') || str_contains($str, 'office') || str_contains($str, 'business') || str_contains($str, 'smart') || str_contains($str, 'software')) return '#7c3aed';
            if (str_contains($str, 'industrial') || str_contains($str, 'factory') || str_contains($str, 'manufacturing') || str_contains($str, 'heat-recovery') || str_contains($str, 'thermal')) return '#f59e0b';
            if (str_contains($str, 'education') || str_contains($str, 'school') || str_contains($str, 'healthy') || str_contains($str, 'well')) return '#0d9488';
            if (str_contains($str, 'cleanroom') || str_contains($str, 'lab') || str_contains($str, 'monitoring') || str_contains($str, 'sensor') || str_contains($str, 'probe')) return '#06b6d4';
            if (str_contains($str, 'hospitality') || str_contains($str, 'hotel') || str_contains($str, 'alert')) return '#ec4899';
            if (str_contains($str, 'technology') || str_contains($str, 'technologies')) return '#2563eb';
            return '#00c853';
        };

        $createdCategoryIds = [];

        foreach ($categories as $catData) {
            $parent = ProductCategory::create([
                'category_name' => $catData['category_name'],
                'slug'          => $catData['slug'],
                'bg_color'      => $catData['bg_color'] ?? $getCatColor($catData['category_name'], $catData['slug']),
                'description'   => $catData['description'] ?? null,
                'icon_class'    => $catData['icon_class'] ?? 'bi bi-box',
                'parent_id'     => null,
                'image'         => $catData['image'] ?? null,
                'sort_order'    => $catData['sort_order'] ?? 1,
                'status'        => 1,
                'header_menu'   => 1,
                'side_menu'     => 1,
            ]);

            $createdCategoryIds[] = $parent->id;

            if (!empty($catData['subcategories'])) {
                foreach ($catData['subcategories'] as $index => $subData) {
                    $child = ProductCategory::create([
                        'category_name' => $subData['category_name'],
                        'slug'          => $subData['slug'],
                        'bg_color'      => $subData['bg_color'] ?? $getCatColor($subData['category_name'], $subData['slug']),
                        'description'   => $subData['description'] ?? null,
                        'icon_class'    => $subData['icon_class'] ?? 'bi bi-box',
                        'parent_id'     => $parent->id,
                        'image'         => null,
                        'sort_order'    => $index + 1,
                        'status'        => 1,
                        'header_menu'   => 1,
                        'side_menu'     => 1,
                    ]);

                    $createdCategoryIds[] = $child->id;

                    if (!empty($subData['subcategories'])) {
                        foreach ($subData['subcategories'] as $subIndex => $subSubData) {
                            $subChild = ProductCategory::create([
                                'category_name' => $subSubData['category_name'],
                                'slug'          => $subSubData['slug'],
                                'bg_color'      => $subSubData['bg_color'] ?? $getCatColor($subSubData['category_name'], $subSubData['slug']),
                                'description'   => $subSubData['description'] ?? null,
                                'icon_class'    => $subSubData['icon_class'] ?? 'bi bi-box',
                                'parent_id'     => $child->id,
                                'image'         => null,
                                'sort_order'    => $subIndex + 1,
                                'status'        => 1,
                                'header_menu'   => 1,
                                'side_menu'     => 1,
                            ]);
                            $createdCategoryIds[] = $subChild->id;
                        }
                    }
                }
            }
        }

        // Attach existing products to categories evenly
        $products = Product::all();
        if ($products->count() > 0 && !empty($createdCategoryIds)) {
            foreach ($products as $i => $product) {
                $catId = $createdCategoryIds[$i % count($createdCategoryIds)];
                DB::table('product_to_categories')->insert([
                    'product_id'  => $product->id,
                    'category_id' => $catId,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }

        // Seed dynamic category features
        (new CategoryFeatureSeeder())->run();
    }
}
