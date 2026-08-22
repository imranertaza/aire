<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\CategoryFeaturedProduct;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubcategoryProductSeeder extends Seeder
{
    /**
     * Run the subcategory products seeder.
     */
    public function run(): void
    {
        $defaultStore = Store::first();
        $defaultBrand = Brand::first();
        $storeId = $defaultStore?->id ?? 1;
        $brandId = $defaultBrand?->id ?? 1;

        // Subcategory definitions and their target products
        $catalog = [
            'Residential Air Quality' => [
                'description' => 'Architectural air purification designed for modern homes and luxury living spaces.',
                'subcategories' => [
                    'Compact Purifiers' => [
                        [
                            'name' => 'AIRE Pure Studio Mini',
                            'model' => 'AP-STU-100',
                            'price' => 499.00,
                            'description' => 'Ultra-compact HEPA-13 air purifier designed for bedside tables and home offices. Whispers at 19dB silent mode.',
                            'main_image' => 'https://images.unsplash.com/photo-1585771724684-38269d6639fd?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => '240 m³/h', 'Filter Grade' => 'H13 Medical HEPA', 'Coverage' => 'Up to 350 sq ft'],
                        ],
                        [
                            'name' => 'AIRE QuietFlow Desktop',
                            'model' => 'AP-QFL-200',
                            'price' => 349.00,
                            'description' => 'Personal air purifier with dynamic directional airflow and activated carbon VOC filtration for workspace productivity.',
                            'main_image' => 'https://images.unsplash.com/photo-1545259741-2ea3ebf61fa3?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => '180 m³/h', 'Filter Grade' => 'H13 Medical HEPA', 'Coverage' => 'Up to 250 sq ft'],
                        ],
                        [
                            'name' => 'AIRE Cube Air Personal',
                            'model' => 'AP-CUB-150',
                            'price' => 299.00,
                            'description' => 'Sleek anodized aluminum desktop air scrubbing unit with real-time PM2.5 LED air quality indicator.',
                            'main_image' => 'https://images.unsplash.com/photo-1583863788434-e58a36330cf0?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => '210 m³/h', 'Filter Grade' => 'HEPA-13 Dual', 'Coverage' => 'Up to 300 sq ft'],
                        ],
                    ],
                    'Whole House Systems' => [
                        [
                            'name' => 'AIRE Max Matrix 900',
                            'model' => 'AP-MMX-900',
                            'price' => 2899.00,
                            'description' => 'Commercial-strength home HVAC in-duct air purification system with dual UV-C ionization and HEPA-14 scrubbers.',
                            'main_image' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => '1,450 m³/h', 'Filter Grade' => 'H14 Ultra HEPA', 'Coverage' => 'Up to 3,500 sq ft'],
                        ],
                        [
                            'name' => 'AIRE Villa Pure Pro',
                            'model' => 'AP-VLA-750',
                            'price' => 2199.00,
                            'description' => 'Multi-zone residential air purifier with Smart Mesh app sync and real-time indoor air health reporting.',
                            'main_image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => '1,100 m³/h', 'Filter Grade' => 'H14 Ultra HEPA', 'Coverage' => 'Up to 2,800 sq ft'],
                        ],
                        [
                            'name' => 'AIRE Architect Dual-Tower',
                            'model' => 'AP-ARC-800',
                            'price' => 2499.00,
                            'description' => 'Floor-standing dual-intake architectural air tower crafted from brushed aluminum with titanium catalyst core.',
                            'main_image' => 'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => '1,250 m³/h', 'Filter Grade' => 'HEPA-14 Surgical', 'Coverage' => 'Up to 3,000 sq ft'],
                        ],
                    ],
                    'Bedroom Air Units' => [
                        [
                            'name' => 'AIRE Somnus Sleep Purifier',
                            'model' => 'AP-SOM-300',
                            'price' => 649.00,
                            'description' => 'Acoustically dampening sleep sanctuary air purifier featuring sleep-cycle ambient night lighting and allergy defense mode.',
                            'main_image' => 'https://images.unsplash.com/photo-1540518614846-7ede433c5173?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => '380 m³/h', 'Filter Grade' => 'H13 Medical HEPA', 'Coverage' => 'Up to 550 sq ft'],
                        ],
                        [
                            'name' => 'AIRE Nocturne Whisper Unit',
                            'model' => 'AP-NOC-350',
                            'price' => 599.00,
                            'description' => 'Ultra-silent air cleaner engineered specifically for master suites and nurseries with zero ozone carbon filtration.',
                            'main_image' => 'https://images.unsplash.com/photo-1595526114035-0d45ed16cfbf?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => '350 m³/h', 'Filter Grade' => 'H13 Medical HEPA', 'Coverage' => 'Up to 500 sq ft'],
                        ],
                    ],
                ],
            ],

            'Commercial & Industrial' => [
                'description' => 'Industrial-grade air filtration and cleanroom systems for corporate offices, hospitals, and facilities.',
                'subcategories' => [
                    'High-Capacity Purifiers' => [
                        [
                            'name' => 'AIRE Commercial Prime 1200',
                            'model' => 'AP-CP12-IND',
                            'price' => 3899.00,
                            'description' => 'Heavy-duty industrial air scrubber built for high-traffic corporate lobbies, airports, and convention centers.',
                            'main_image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => '2,200 m³/h', 'Filter Grade' => 'H14 Industrial HEPA', 'Coverage' => 'Up to 6,000 sq ft'],
                        ],
                        [
                            'name' => 'AIRE Titan Scrub X',
                            'model' => 'AP-TTN-1500',
                            'price' => 4499.00,
                            'description' => 'Quad-engine high capacity air scrubbing system with automated multi-stage particulate clearance.',
                            'main_image' => 'https://images.unsplash.com/photo-1497215728101-856f4ea42174?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => '2,800 m³/h', 'Filter Grade' => 'H14 Industrial HEPA', 'Coverage' => 'Up to 8,500 sq ft'],
                        ],
                    ],
                    'HVAC In-Duct Systems' => [
                        [
                            'name' => 'AIRE DuctMaster Pro-V',
                            'model' => 'AP-DMC-5000',
                            'price' => 3299.00,
                            'description' => 'In-duct commercial HVAC air sterilizer utilizing bi-polar ionization and high-flow HEPA filter cartridges.',
                            'main_image' => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => '3,500 m³/h', 'Filter Grade' => 'H13 Duct HEPA', 'Coverage' => 'Up to 10,000 sq ft'],
                        ],
                        [
                            'name' => 'AIRE Central AirGuard',
                            'model' => 'AP-CAG-4000',
                            'price' => 2999.00,
                            'description' => 'Zero-drop pressure HVAC inline purification engine with centralized BMS monitoring system.',
                            'main_image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => '3,000 m³/h', 'Filter Grade' => 'H13 Duct HEPA', 'Coverage' => 'Up to 8,000 sq ft'],
                        ],
                    ],
                ],
            ],

            'Smart Sensors & Accessories' => [
                'description' => 'Precision IAQ air quality monitors, smart sensors, and genuine replacement filter cartridges.',
                'subcategories' => [
                    'IAQ Air Monitors' => [
                        [
                            'name' => 'AIRE Sense Pro IAQ Monitor',
                            'model' => 'AS-SEN-100',
                            'price' => 249.00,
                            'description' => 'Desktop air quality sensor monitoring PM1.0, PM2.5, PM10, CO2, TVOC, humidity, and room temperature.',
                            'main_image' => 'https://images.unsplash.com/photo-1558002038-1055907df827?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => 'N/A (Sensor)', 'Filter Grade' => 'Laser NDIR Sensor', 'Coverage' => 'Real-time IAQ'],
                        ],
                        [
                            'name' => 'AIRE Clarity Wall Sensor',
                            'model' => 'AS-CLA-200',
                            'price' => 199.00,
                            'description' => 'Flush-mount architectural IAQ sensor node with OLED display and wireless smart home integration.',
                            'main_image' => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => 'N/A (Sensor)', 'Filter Grade' => 'Optical PM2.5', 'Coverage' => 'Multi-Room Sync'],
                        ],
                    ],
                    'Replacement Filters' => [
                        [
                            'name' => 'AIRE UltraCart HEPA-14 Replacement',
                            'model' => 'AF-H14-MAX',
                            'price' => 129.00,
                            'description' => 'Genuine high-efficiency replacement HEPA-14 and activated carbon dual filter assembly.',
                            'main_image' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => 'Filter Refill', 'Filter Grade' => 'H14 Medical HEPA', 'Coverage' => '12 Months Life'],
                        ],
                        [
                            'name' => 'AIRE CarbonShield VOC Refill',
                            'model' => 'AF-CAR-500',
                            'price' => 89.00,
                            'description' => 'High-density coconut shell activated carbon cartridge for absorbing odor, smoke, and chemical gases.',
                            'main_image' => 'https://images.unsplash.com/photo-1585771724684-38269d6639fd?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => 'VOC Refill', 'Filter Grade' => 'Activated Carbon', 'Coverage' => '6 Months Life'],
                        ],
                    ],
                ],
            ],

            'Technologies' => [
                'description' => 'Advanced technologies for cleaner, smarter, healthier spaces — engineered for maximum efficiency and precision air purification.',
                'subcategories' => [
                    'Fresh Air & Ventilation' => [
                        [
                            'name' => 'AIRE PureFlow ERV 500',
                            'model' => 'ERV-PF500',
                            'price' => 1899.00,
                            'description' => 'Continuous fresh air exchange system with high-efficiency enthalpy core and dual EC motor fans.',
                            'main_image' => 'https://images.unsplash.com/photo-1585771724684-38269d6639fd?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => '850 m³/h', 'Filter Grade' => 'H13 HEPA & Enthalpy', 'Coverage' => 'Up to 2,500 sq ft'],
                        ],
                        [
                            'name' => 'AIRE In-Duct Matrix Vent 1000',
                            'model' => 'IDM-V1000',
                            'price' => 2499.00,
                            'description' => 'Direct HVAC in-line fresh air system providing balanced outdoor intake and indoor exhaust recovery.',
                            'main_image' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => '1,400 m³/h', 'Filter Grade' => 'Dual HEPA H14', 'Coverage' => 'Up to 3,800 sq ft'],
                        ],
                        [
                            'name' => 'AIRE AeroStream High-Flo',
                            'model' => 'AST-HF2000',
                            'price' => 3299.00,
                            'description' => 'Heavy-duty commercial ventilation unit engineered for high-occupancy spaces and silent continuous airflow.',
                            'main_image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => '2,200 m³/h', 'Filter Grade' => 'Industrial ERV Core', 'Coverage' => 'Up to 5,500 sq ft'],
                        ],
                    ],
                    'Air Purification' => [
                        [
                            'name' => 'AIRE Pro S1 (Snow)',
                            'model' => 'AP-S1-SNOW',
                            'price' => 1499.00,
                            'description' => 'Hospital-grade air purifier featuring medical True HEPA H14 filtration and whisper-quiet aerodynamics.',
                            'main_image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => '1,200 m³/h', 'Filter Grade' => 'HEPA-14Medical', 'Coverage' => 'Up to 3,200 sq ft'],
                        ],
                        [
                            'name' => 'AIRE SteriShield UV-C 800',
                            'model' => 'UV-SS800',
                            'price' => 1299.00,
                            'description' => 'Clinical air sterilizer combining 254nm ultraviolet germicidal irradiation with high-capacity HEPA containment.',
                            'main_image' => 'https://images.unsplash.com/photo-1583863788434-e58a36330cf0?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => '950 m³/h', 'Filter Grade' => 'UV-C + H14 HEPA', 'Coverage' => 'Up to 2,400 sq ft'],
                        ],
                        [
                            'name' => 'AIRE PlasmaIonic Scrubber 1500',
                            'model' => 'PL-ION1500',
                            'price' => 2199.00,
                            'description' => 'Bipolar ionization and electrostatic precipitation unit capturing ultra-fine smoke and airborne pathogens.',
                            'main_image' => 'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => '1,650 m³/h', 'Filter Grade' => 'Electrostatic H14', 'Coverage' => 'Up to 4,500 sq ft'],
                        ],
                    ],
                    'Heat Recovery' => [
                        [
                            'name' => 'AIRE ThermalCore HRX 95',
                            'model' => 'HRX-95-CORE',
                            'price' => 2150.00,
                            'description' => 'Cross-counterflow heat recovery module with up to 93% sensible thermal energy retention.',
                            'main_image' => 'https://images.unsplash.com/photo-1545259741-2ea3ebf61fa3?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => '1,100 m³/h', 'Filter Grade' => '93% Counterflow Core', 'Coverage' => 'Up to 3,000 sq ft'],
                        ],
                        [
                            'name' => 'AIRE RotaryEnthalpy Wheel 1200',
                            'model' => 'REW-1200-ENT',
                            'price' => 3450.00,
                            'description' => 'Desiccant-coated rotary thermal recovery wheel transferring both sensible heat and latent humidity.',
                            'main_image' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => '1,800 m³/h', 'Filter Grade' => 'Desiccant Thermal Core', 'Coverage' => 'Up to 4,800 sq ft'],
                        ],
                        [
                            'name' => 'AIRE ArcticDefrost ERV Matrix',
                            'model' => 'ADF-ERV-800',
                            'price' => 2299.00,
                            'description' => 'Cold-climate energy recovery ventilator with smart pre-heating and frost prevention bypass loops.',
                            'main_image' => 'https://images.unsplash.com/photo-1540518614846-7ede433c5173?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => '1,050 m³/h', 'Filter Grade' => 'H13 + Auto Defrost', 'Coverage' => 'Up to 2,800 sq ft'],
                        ],
                    ],
                    'Monitoring & Sensing' => [
                        [
                            'name' => 'AIRE SenseMatrix Multi-Probe',
                            'model' => 'SMX-PRB-900',
                            'price' => 499.00,
                            'description' => 'Precision environmental sensor tracking 9 key metrics including PM2.5, VOCs, CO2, and humidity in real time.',
                            'main_image' => 'https://images.unsplash.com/photo-1583863788434-e58a36330cf0?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => 'IoT Sensor Probe', 'Filter Grade' => 'Laser Optical Array', 'Coverage' => 'Multi-Zone Mesh'],
                        ],
                        [
                            'name' => 'AIRE NDIR Sentinel Air Monitor',
                            'model' => 'NDR-SNT-400',
                            'price' => 349.00,
                            'description' => 'Dual-beam NDIR carbon dioxide monitor with high-visibility color ambient display and cloud reporting.',
                            'main_image' => 'https://images.unsplash.com/photo-1585771724684-38269d6639fd?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => 'CO2 & Temp Monitor', 'Filter Grade' => 'Dual NDIR Optical', 'Coverage' => 'Up to 1,500 sq ft'],
                        ],
                        [
                            'name' => 'AIRE Telemetry Beacon VOC',
                            'model' => 'TLM-VOC-250',
                            'price' => 399.00,
                            'description' => 'Photoionization detection (PID) sensor engineered for ultra-fast response to industrial solvents and off-gassing.',
                            'main_image' => 'https://images.unsplash.com/photo-1595526114035-0d45ed16cfbf?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => 'VOC Sensing Unit', 'Filter Grade' => 'Photoionization PID', 'Coverage' => 'Up to 1,200 sq ft'],
                        ],
                    ],
                    'Smart Control' => [
                        [
                            'name' => 'AIRE SmartHub BACnet Gateway',
                            'model' => 'SHB-BAC-100',
                            'price' => 699.00,
                            'description' => 'Protocol converter linking AIRE air hardware to enterprise BMS via BACnet/IP, Modbus TCP, and MQTT.',
                            'main_image' => 'https://images.unsplash.com/photo-1545259741-2ea3ebf61fa3?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => 'BMS Controller', 'Filter Grade' => 'Modbus/BACnet Bridge', 'Coverage' => 'Enterprise System'],
                        ],
                        [
                            'name' => 'AIRE ZoneSync Damper Actuator',
                            'model' => 'ZSN-DMP-40',
                            'price' => 289.00,
                            'description' => 'Precision motorized modulating damper delivering demand-controlled fresh air to occupied zones.',
                            'main_image' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => 'Air Balancing', 'Filter Grade' => 'Stepper Damper 24V', 'Coverage' => 'Single Duct Line'],
                        ],
                        [
                            'name' => 'AIRE AI Touch Controller 7',
                            'model' => 'AIF-CTL-500',
                            'price' => 549.00,
                            'description' => '7-inch flush-mount glass capacitive touchscreen with live IAQ dashboard and automated speed regulation.',
                            'main_image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => 'Smart Touch Kiosk', 'Filter Grade' => '7-inch IPS Glass Panel', 'Coverage' => 'Facility Hub'],
                        ],
                    ],
                    'Healthy Building' => [
                        [
                            'name' => 'AIRE PositivePressure Core 750',
                            'model' => 'PPC-750-BAR',
                            'price' => 2899.00,
                            'description' => 'Maintains micro-positive indoor pressure preventing infiltration of dust, smoke, and outside allergens.',
                            'main_image' => 'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => '1,350 m³/h', 'Filter Grade' => 'WELL/LEED Certified H14', 'Coverage' => 'Up to 3,500 sq ft'],
                        ],
                        [
                            'name' => 'AIRE BioBarrier Laminar Scrubber',
                            'model' => 'BBR-LAM-1200',
                            'price' => 3699.00,
                            'description' => 'Sterile laminar airflow air barrier designed for cleanrooms, isolation wards, and biological research spaces.',
                            'main_image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => '1,600 m³/h', 'Filter Grade' => 'Surgical BioBarrier H14', 'Coverage' => 'Up to 4,200 sq ft'],
                        ],
                        [
                            'name' => 'AIRE EcoEnvelop LEED Fresh Unit',
                            'model' => 'EEL-LEED-900',
                            'price' => 2450.00,
                            'description' => 'ASHRAE 62.1 and LEED IAQ-optimized fresh air system with energy submetering and automated audit logs.',
                            'main_image' => 'https://images.unsplash.com/photo-1540518614846-7ede433c5173?auto=format&fit=crop&w=800&q=80',
                            'attributes' => ['CADR Rating' => '1,150 m³/h', 'Filter Grade' => 'ASHRAE 62.1 LEED H13', 'Coverage' => 'Up to 3,000 sq ft'],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($catalog as $parentName => $categoryData) {
            // Find or create parent category
            $parent = ProductCategory::where('category_name', $parentName)
                ->orWhere('slug', Str::slug($parentName))
                ->orWhere('alt_name', Str::slug($parentName))
                ->first();

            if (!$parent) {
                $parent = ProductCategory::create([
                    'category_name'   => $parentName,
                    'slug'            => Str::slug($parentName),
                    'alt_name'        => Str::slug($parentName),
                    'description'     => $categoryData['description'],
                    'meta_title'      => $parentName,
                    'meta_description' => $categoryData['description'],
                    'meta_keyword'    => Str::slug($parentName, ', '),
                    'image'           => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80',
                    'header_menu'     => 1,
                    'side_menu'       => 1,
                    'sort_order'      => 1,
                    'status'          => 1,
                    'createdBy'       => 1,
                    'updatedBy'       => 1,
                ]);
            }

            foreach ($categoryData['subcategories'] as $subName => $products) {
                // Find or create subcategory
                $sub = ProductCategory::where(function ($q) use ($subName, $parent) {
                    $q->where('category_name', $subName)
                        ->orWhere('slug', Str::slug($subName))
                        ->orWhere('slug', 'tech-' . Str::slug($subName));
                })->first();

                if (!$sub) {
                    $sub = ProductCategory::create([
                        'parent_id'       => $parent->id,
                        'category_name'   => $subName,
                        'slug'            => Str::slug($subName),
                        'alt_name'        => Str::slug($subName),
                        'description'     => "Premium {$subName} engineered by AIRE.",
                        'meta_title'      => $subName,
                        'meta_description' => "Shop {$subName}",
                        'meta_keyword'    => Str::slug($subName, ', '),
                        'image'           => $products[0]['main_image'] ?? null,
                        'header_menu'     => 0,
                        'side_menu'       => 1,
                        'sort_order'      => 1,
                        'status'          => 1,
                        'createdBy'       => 1,
                        'updatedBy'       => 1,
                    ]);
                }

                $createdProductIds = [];

                foreach ($products as $pData) {
                    $product = Product::updateOrCreate(
                        ['model' => $pData['model']],
                        [
                            'store_id'         => $storeId,
                            'brand_id'         => $brandId,
                            'name'             => $pData['name'],
                            'product_code'     => strtoupper(Str::random(8)),
                            'main_image'       => $pData['main_image'],
                            'image'            => $pData['main_image'],
                            'alt_name'         => Str::slug($pData['name']),
                            'price'            => $pData['price'],
                            'quantity'         => rand(20, 100),
                            'featured'         => 1,
                            'average_feedback' => 5,
                            'date_available'   => now(),
                            'weight'           => 4.5,
                            'length'           => 30.0,
                            'width'            => 30.0,
                            'height'           => 65.0,
                            'sort_order'       => 1,
                            'status'           => 1,
                            'createdBy'        => 1,
                            'updatedBy'        => 1,
                        ]
                    );

                    // Sync product to subcategory and parent category
                    $product->categories()->syncWithoutDetaching([$sub->id, $parent->id]);

                    // Add product description
                    $product->description()->updateOrCreate(
                        ['product_id' => $product->id],
                        [
                            'description'      => $pData['description'],
                            'meta_title'       => $product->name,
                            'meta_description' => $pData['description'],
                            'meta_keyword'     => 'air purifier, hepa, indoor air quality',
                        ]
                    );

                    // Add product attributes
                    $attrGroup = \App\Models\ProductAttributeGroup::firstOrCreate(
                        ['name' => 'General Specifications'],
                        ['sort_order' => 1, 'status' => 1]
                    );

                    foreach ($pData['attributes'] as $attrName => $attrVal) {
                        ProductAttribute::updateOrCreate(
                            [
                                'product_id' => $product->id,
                                'name'       => $attrName,
                            ],
                            [
                                'attribute_group_id' => $attrGroup->id,
                                'details'            => $attrVal,
                                'sort_order'         => 1,
                            ]
                        );
                    }

                    $createdProductIds[] = $product->id;
                }

                // Automatically set top, middle, and bottom featured products for the subcategory if available
                if (count($createdProductIds) >= 1) {
                    CategoryFeaturedProduct::updateOrCreate(
                        ['category_id' => $sub->id, 'position' => 'top'],
                        ['product_id' => $createdProductIds[0], 'sort_order' => 0]
                    );
                }
                if (count($createdProductIds) >= 2) {
                    CategoryFeaturedProduct::updateOrCreate(
                        ['category_id' => $sub->id, 'position' => 'middle'],
                        ['product_id' => $createdProductIds[1], 'sort_order' => 0]
                    );
                }
                if (count($createdProductIds) >= 3) {
                    CategoryFeaturedProduct::updateOrCreate(
                        ['category_id' => $sub->id, 'position' => 'bottom'],
                        ['product_id' => $createdProductIds[2], 'sort_order' => 0]
                    );
                }
            }
        }
    }
}
