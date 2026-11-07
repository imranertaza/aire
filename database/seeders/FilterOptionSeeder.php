<?php

namespace Database\Seeders;

use App\Models\FilterOption;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FilterOptionSeeder extends Seeder
{
    /**
     * Run the database seeds matching:
     * 1. The 10-step Guided Product Finder mockups (guided product finder filter/)
     * 2. Storefront Catalog Sidebar filters (filter.blade.php sidebar).
     */
    public function run(): void
    {
        // Disable foreign key checks for clean truncation
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        FilterOption::truncate();
        DB::table('filter_option_values')->truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $options = [
            // =========================================================================
            // PART 1: 10-STEP GUIDED PRODUCT FINDER (show_in_catalog: 0, show_in_guided_finder: 1)
            // =========================================================================

            // STEP 1: Application / Environment (Mockup Page 1)
            [
                'name'                  => 'Application / Environment',
                'type'                  => 'radio',
                'icon'                  => 'bi-building',
                'show_in_catalog'       => 0,
                'show_in_filter'        => 0,
                'show_in_guided_finder' => 1,
                'guided_step_number'    => 1,
                'guided_question'       => '01 WHERE WILL YOU USE IT?',
                'guided_subtitle'       => 'APPLICATION / ENVIRONMENT',
                'has_unknown_option'    => 0,
                'unknown_option_label'  => "I don't know",
                'values' => [
                    ['name' => 'Car / Vehicle', 'icon' => 'bi-car-front', 'explanation' => 'Selected: Car / Vehicle. Routes to compact in-car or automotive air purification.'],
                    ['name' => 'Personal Protection', 'icon' => 'bi-person', 'explanation' => 'Selected: Personal Protection. Wearable and personal air filtering devices.'],
                    ['name' => 'Small Enclosed Space', 'icon' => 'bi-box', 'explanation' => 'Selected: Small Enclosed Space. Compact units tailored for tight cabins, closets, or small booths.'],
                    ['name' => 'Single Room', 'icon' => 'bi-door-closed', 'explanation' => 'Selected: Single Room. This routes the user to room-scale air solutions rather than vehicle, wearable or large-building systems.'],
                    ['name' => 'Bedroom', 'icon' => 'bi-moon-stars', 'explanation' => 'Selected: Bedroom. Prioritizes whisper-quiet, night-mode certified units.'],
                    ['name' => 'Living Room', 'icon' => 'bi-tv', 'explanation' => 'Selected: Living Room. Medium-to-high capacity air cleaning and ventilation.'],
                    ['name' => 'Home / Apartment', 'icon' => 'bi-house-door', 'explanation' => 'Selected: Home / Apartment. Full residential or whole-apartment fresh air solutions.'],
                    ['name' => 'Office', 'icon' => 'bi-briefcase', 'explanation' => 'Selected: Office. Low-noise commercial air filtration for productivity.'],
                    ['name' => 'Hospital / Healthcare', 'icon' => 'bi-hospital', 'explanation' => 'Selected: Hospital / Healthcare. Medical-grade pathogen and virus neutralization.'],
                    ['name' => 'School / Classroom', 'icon' => 'bi-mortarboard', 'explanation' => 'Selected: School / Classroom. High air exchange rate for crowded learning spaces.'],
                    ['name' => 'Commercial Building', 'icon' => 'bi-buildings', 'explanation' => 'Selected: Commercial Building. Centralized high-capacity air treatment systems.'],
                    ['name' => 'Industrial Facility', 'icon' => 'bi-boxes', 'explanation' => 'Selected: Industrial Facility. Heavy-duty particulate and chemical exhaust filtration.'],
                ]
            ],

            // STEP 2: Product Family / System Type (Mockup Page 2)
            [
                'name'                  => 'Product Family',
                'type'                  => 'radio',
                'icon'                  => 'bi-box-seam',
                'show_in_catalog'       => 0,
                'show_in_filter'        => 0,
                'show_in_guided_finder' => 1,
                'guided_step_number'    => 2,
                'guided_question'       => '02 WHAT DO YOU NEED?',
                'guided_subtitle'       => 'PRODUCT FAMILY / SYSTEM TYPE',
                'has_unknown_option'    => 0,
                'unknown_option_label'  => 'Not sure — recommend',
                'values' => [
                    ['name' => 'Air Purifier', 'icon' => 'bi-wind', 'explanation' => 'Selected: Air Purifier. Recirculates and purifies indoor air with multi-stage HEPA and carbon filters.'],
                    ['name' => 'Fresh Air & Ventilation', 'icon' => 'bi-arrow-left-right', 'explanation' => 'Selected: Fresh Air & Ventilation. FE6 is pursued as a fresh-air product, not as a standalone air-purifier-only or AC selection.'],
                    ['name' => 'Air Conditioner / Climate Control', 'icon' => 'bi-snow', 'explanation' => 'Selected: Air Conditioner / Climate Control. Temperature and climate regulation combined with air treatment.'],
                    ['name' => 'Air Quality Monitor', 'icon' => 'bi-speedometer2', 'explanation' => 'Selected: Air Quality Monitor. Precise real-time tracking of PM2.5, CO2, TVOC, and humidity.'],
                    ['name' => 'Personal Air & Protection', 'icon' => 'bi-shield-check', 'explanation' => 'Selected: Personal Air & Protection. Mobile and wearable personal clean air equipment.'],
                    ['name' => 'Vehicle / Mobile Air System', 'icon' => 'bi-car-front', 'explanation' => 'Selected: Vehicle / Mobile Air System. 12V automotive and on-the-go air purifiers.'],
                    ['name' => 'Accessories / Filters', 'icon' => 'bi-tools', 'explanation' => 'Selected: Accessories / Filters. Replacement filter elements, pre-filters, and ducting parts.'],
                    ['name' => 'Smart Controls', 'icon' => 'bi-cpu', 'explanation' => 'Selected: Smart Controls. IoT gateways, central control panels, and smart sensors.'],
                    ['name' => 'Not sure — recommend', 'icon' => 'bi-question-circle', 'explanation' => 'Selected: Not sure — recommend. Let our algorithm recommend the best matching product family based on your needs.'],
                ]
            ],

            // STEP 3: Space Size / Coverage (Mockup Page 3)
            [
                'name'                  => 'Space Size',
                'type'                  => 'radio',
                'icon'                  => 'bi-aspect-ratio',
                'show_in_catalog'       => 0,
                'show_in_filter'        => 0,
                'show_in_guided_finder' => 1,
                'guided_step_number'    => 3,
                'guided_question'       => '03 HOW LARGE IS THE SPACE?',
                'guided_subtitle'       => 'ROOM SIZE / COVERAGE',
                'has_unknown_option'    => 0,
                'unknown_option_label'  => "I don't know",
                'values' => [
                    ['name' => 'Under 200 sq ft', 'icon' => 'bi-box', 'explanation' => 'Selected: Under 200 sq ft. Compact space coverage.'],
                    ['name' => '200-500 sq ft', 'icon' => 'bi-aspect-ratio', 'explanation' => 'Selected: 200-500 sq ft. Typical master bedroom or standard room coverage.'],
                    ['name' => '500-1,000 sq ft', 'icon' => 'bi-fullscreen', 'explanation' => 'Selected: 500-1,000 sq ft. Large living room or combined open plan area.'],
                    ['name' => '1,000-2,000 sq ft', 'icon' => 'bi-bounding-box-circles', 'explanation' => 'Selected: 1,000-2,000 sq ft. Whole apartment or floor-wide coverage.'],
                    ['name' => '2,000-5,000 sq ft', 'icon' => 'bi-arrows-fullscreen', 'explanation' => 'Selected: 2,000-5,000 sq ft. Multi-story residence or large open commercial floor.'],
                    ['name' => '5,000+ sq ft', 'icon' => 'bi-buildings', 'explanation' => 'Selected: 5,000+ sq ft. Massive commercial building or industrial facility scale.'],
                    ['name' => "I don't know", 'icon' => 'bi-question-circle', 'explanation' => 'Area not provided in this example, so we do not invent a room size. Coverage can be checked against the verified FE6 specification on the results page.'],
                ]
            ],

            // STEP 4: Airflow Requirement (Mockup Page 4)
            [
                'name'                  => 'Airflow',
                'type'                  => 'radio',
                'icon'                  => 'bi-fan',
                'show_in_catalog'       => 0,
                'show_in_filter'        => 0,
                'show_in_guided_finder' => 1,
                'guided_step_number'    => 4,
                'guided_question'       => '04 AIRFLOW REQUIREMENT',
                'guided_subtitle'       => 'AIRFLOW / PERFORMANCE',
                'has_unknown_option'    => 0,
                'unknown_option_label'  => "I don't know",
                'values' => [
                    ['name' => 'Under 100 m³/h', 'icon' => 'bi-speedometer', 'explanation' => 'Selected: Under 100 m³/h. Ultra-quiet micro ventilation.'],
                    ['name' => '100–300 m³/h', 'icon' => 'bi-speedometer2', 'explanation' => 'Selected: 100–300 m³/h. Standard residential fresh air delivery rate.'],
                    ['name' => '300–600 m³/h', 'icon' => 'bi-activity', 'explanation' => 'Selected: 300–600 m³/h. High-flow fresh air and rapid air renewal.'],
                    ['name' => '600–1,500 m³/h', 'icon' => 'bi-tornado', 'explanation' => 'Selected: 600–1,500 m³/h. Commercial air volume circulation.'],
                    ['name' => '1,500+ m³/h', 'icon' => 'bi-wind', 'explanation' => 'Selected: 1,500+ m³/h. Industrial-scale high volume air exchange.'],
                    ['name' => "I don't know", 'icon' => 'bi-question-circle', 'explanation' => 'Airflow is optional. Since the user does not know the required airflow, keep the path open and compare against the product\'s verified m³/h rating later.'],
                ]
            ],

            // STEP 5: Air Quality Needs (Mockup Page 5 - Multi-select)
            [
                'name'                  => 'Air Quality Needs',
                'type'                  => 'checkbox',
                'icon'                  => 'bi-shield-check',
                'show_in_catalog'       => 0,
                'show_in_filter'        => 0,
                'show_in_guided_finder' => 1,
                'guided_step_number'    => 5,
                'guided_question'       => '05 WHAT MATTERS MOST?',
                'guided_subtitle'       => 'AIR QUALITY NEEDS — SIMPLIFIED',
                'has_unknown_option'    => 0,
                'unknown_option_label'  => 'Not sure — recommend',
                'values' => [
                    ['name' => 'Bring in fresh outdoor air', 'icon' => 'bi-clouds', 'explanation' => 'Selected: Fresh outdoor air. Introduces oxygen-rich outside air to lower CO2 and eliminate stuffiness.'],
                    ['name' => 'Reduce PM2.5 / fine particles', 'icon' => 'bi-cloud-fog', 'explanation' => 'Selected: PM2.5 reduction. Captures microscopic airborne pollutants and smoke particles.'],
                    ['name' => 'Reduce odours / VOCs', 'icon' => 'bi-droplet-half', 'explanation' => 'Selected: Odours & VOCs. Activated carbon adsorption for cooking smells, formaldehyde and chemicals.'],
                    ['name' => 'HEPA filtration required', 'icon' => 'bi-shield-check', 'explanation' => 'Selected: HEPA filtration. Medical-grade 99.97% or higher particle capture standard.'],
                    ['name' => 'Heat / energy recovery', 'icon' => 'bi-arrow-repeat', 'explanation' => 'Selected: Heat / energy recovery. Minimizes heating and cooling loss during continuous air exchange.'],
                    ['name' => 'Monitor CO2', 'icon' => 'bi-speedometer2', 'explanation' => 'Selected: CO2 monitoring. Integrated sensor monitoring for indoor carbon dioxide levels.'],
                    ['name' => 'Humidity control', 'icon' => 'bi-moisture', 'explanation' => 'Selected: Humidity control. Prevents condensation or relieves excessively dry indoor air.'],
                    ['name' => 'Not sure — recommend', 'icon' => 'bi-question-circle', 'explanation' => 'Selected: Not sure — recommend. Balanced general clean air and fresh ventilation profile.'],
                ]
            ],

            // STEP 6: Requirements / Installation (Mockup Page 6)
            [
                'name'                  => 'Requirements',
                'type'                  => 'radio',
                'icon'                  => 'bi-tools',
                'show_in_catalog'       => 0,
                'show_in_filter'        => 0,
                'show_in_guided_finder' => 1,
                'guided_step_number'    => 6,
                'guided_question'       => '06 ANY INSTALLATION REQUIREMENTS?',
                'guided_subtitle'       => 'INSTALLATION / USE',
                'has_unknown_option'    => 0,
                'unknown_option_label'  => 'No preference',
                'values' => [
                    ['name' => 'Wall-mounted', 'icon' => 'bi-layout-sidebar-inset', 'explanation' => 'Selected: Wall-mounted. Through-wall mounted fresh air unit saving precious floor space.'],
                    ['name' => 'Desktop / Tabletop', 'icon' => 'bi-laptop', 'explanation' => 'Selected: Desktop / Tabletop. Compact personal clean air on your desk or nightstand.'],
                    ['name' => 'Ceiling / Ducted', 'icon' => 'bi-grid-3x3', 'explanation' => 'Selected: Ceiling / Ducted. Concealed in ceiling with ducted distribution to multiple zones.'],
                    ['name' => 'Portable', 'icon' => 'bi-box-seam', 'explanation' => 'Selected: Portable. Free-standing movable air system with plug-and-play simplicity.'],
                    ['name' => 'Low noise', 'icon' => 'bi-volume-mute', 'explanation' => 'Selected: Low noise. Ultra-quiet sleep operation under 30 dB.'],
                    ['name' => 'Low energy use', 'icon' => 'bi-lightning-charge', 'explanation' => 'Selected: Low energy use. High-efficiency brushless DC motor with minimal power draw.'],
                    ['name' => 'Smart / Remote control', 'icon' => 'bi-phone', 'explanation' => 'Selected: Smart / Remote control. WiFi app control, scheduled timers, and automation.'],
                    ['name' => 'No preference', 'icon' => 'bi-check-all', 'explanation' => 'This is optional and can be skipped. Do not block FE6 from matching just because the customer has no installation preference.'],
                ]
            ],

            // STEP 7: Budget / Price Range (Mockup Page 7)
            [
                'name'                  => 'Budget',
                'type'                  => 'radio',
                'icon'                  => 'bi-cash-stack',
                'show_in_catalog'       => 0,
                'show_in_filter'        => 0,
                'show_in_guided_finder' => 1,
                'guided_step_number'    => 7,
                'guided_question'       => '07 WHAT IS YOUR BUDGET?',
                'guided_subtitle'       => 'BUDGET / PRICE RANGE',
                'has_unknown_option'    => 0,
                'unknown_option_label'  => 'Not sure',
                'values' => [
                    ['name' => 'Under $500', 'icon' => 'bi-cash', 'explanation' => 'Selected: Under $500. Budget-friendly entry solution.'],
                    ['name' => '$500–$1,000', 'icon' => 'bi-cash-stack', 'explanation' => 'Selected: $500–$1,000. Core residential fresh air or high-efficiency air purifier.'],
                    ['name' => '$1,000–$2,500', 'icon' => 'bi-gem', 'explanation' => 'Selected: $1,000–$2,500. Premium multi-stage ERV/HRV fresh air units like BROAD FE6.'],
                    ['name' => 'Over $2,500', 'icon' => 'bi-bank', 'explanation' => 'Selected: Over $2,500. Commercial or whole-building ducted ventilation system.'],
                    ['name' => 'Not sure', 'icon' => 'bi-question-circle', 'explanation' => 'Budget is not specified in this sample. Confirm the storefront currency and compare with live FE6 pricing rather than using an invented price.'],
                ]
            ],

            // STEP 8: Matched Solutions (Mockup Page 8)
            [
                'name'                  => 'Matched Solutions',
                'type'                  => 'radio',
                'icon'                  => 'bi-box-seam',
                'show_in_catalog'       => 0,
                'show_in_filter'        => 0,
                'show_in_guided_finder' => 1,
                'guided_step_number'    => 8,
                'guided_question'       => '08 YOUR MATCHED SOLUTIONS',
                'guided_subtitle'       => 'MATCHED PRODUCT',
                'has_unknown_option'    => 0,
                'unknown_option_label'  => "I don't know",
                'values' => [
                    ['name' => 'BROAD FE6 AirPro Fresh', 'icon' => 'bi-box-seam', 'explanation' => 'Target Product matched to your exact room and ventilation profile.'],
                    ['name' => 'Compare Products', 'icon' => 'bi-arrow-left-right', 'explanation' => 'Side-by-side technical specification comparison.'],
                    ['name' => 'View Full Specifications', 'icon' => 'bi-file-earmark-text', 'explanation' => 'CADR, power consumption, sound level, and dimensions.'],
                    ['name' => 'Check Coverage & Airflow', 'icon' => 'bi-aspect-ratio', 'explanation' => 'Verify m³/h ratings against your space dimensions.'],
                    ['name' => 'View Features / Filters', 'icon' => 'bi-shield-check', 'explanation' => 'HEPA H13, electrostatic cleanable filter, and heat recovery core.'],
                    ['name' => 'Price & Availability', 'icon' => 'bi-tag', 'explanation' => 'Direct pricing, stock status, and shipping information.'],
                ]
            ],

            // STEP 9: Product Result (Mockup Page 9)
            [
                'name'                  => 'Product Result',
                'type'                  => 'radio',
                'icon'                  => 'bi-card-checklist',
                'show_in_catalog'       => 0,
                'show_in_filter'        => 0,
                'show_in_guided_finder' => 1,
                'guided_step_number'    => 9,
                'guided_question'       => '09 BROAD FE6 AIRPRO FRESH',
                'guided_subtitle'       => 'PRODUCT RESULT / REVIEW',
                'has_unknown_option'    => 0,
                'unknown_option_label'  => "I don't know",
                'values' => [
                    ['name' => 'View Product Details', 'icon' => 'bi-eye', 'explanation' => 'Open complete product datasheet and overview.'],
                    ['name' => 'Compare Selected Products', 'icon' => 'bi-columns', 'explanation' => 'Review alternatives and related accessories.'],
                    ['name' => 'Buy Now', 'icon' => 'bi-bag-check', 'explanation' => 'Proceed directly to checkout.'],
                    ['name' => 'Request a Quote', 'icon' => 'bi-chat-left-dots', 'explanation' => 'Get a specialized quotation for your project.'],
                    ['name' => 'Talk to an Expert', 'icon' => 'bi-headset', 'explanation' => 'Consult with our HVAC air quality engineers.'],
                    ['name' => 'Change My Answers', 'icon' => 'bi-arrow-counterclockwise', 'explanation' => 'Return to earlier steps to refine criteria.'],
                ]
            ],

            // STEP 10: Match Summary (Mockup Page 10)
            [
                'name'                  => 'Match Summary',
                'type'                  => 'radio',
                'icon'                  => 'bi-check2-circle',
                'show_in_catalog'       => 0,
                'show_in_filter'        => 0,
                'show_in_guided_finder' => 1,
                'guided_step_number'    => 10,
                'guided_question'       => '10 WHY FE6 MATCHED',
                'guided_subtitle'       => 'MATCH SUMMARY',
                'has_unknown_option'    => 0,
                'unknown_option_label'  => "I don't know",
                'values' => [
                    ['name' => 'Application: Single Room', 'icon' => 'bi-door-closed', 'explanation' => 'Ideal fit for single room and apartment environments.'],
                    ['name' => 'Family: Fresh Air & Ventilation', 'icon' => 'bi-arrow-left-right', 'explanation' => 'Continuous outdoor fresh air intake with energy recovery.'],
                    ['name' => 'Area: Not specified', 'icon' => 'bi-aspect-ratio', 'explanation' => 'Coverage matches broad residential space applications.'],
                    ['name' => 'Airflow: Not specified', 'icon' => 'bi-fan', 'explanation' => 'Flexible multi-speed fan control accommodates diverse loads.'],
                    ['name' => 'Needs: Fresh outdoor air + PM2.5', 'icon' => 'bi-shield-check', 'explanation' => 'Dual electrostatic and HEPA filtration with high PM2.5 efficiency.'],
                    ['name' => 'Next: Verify specifications', 'icon' => 'bi-check2-circle', 'explanation' => 'Confirm voltage, duct dimensions, and installation accessories.'],
                ]
            ],

            // =========================================================================
            // PART 2: STOREFRONT CATALOG SIDEBAR FILTERS (show_in_catalog: 1, show_in_guided_finder: 0)
            // Exactly matching Mockup Image 2:
            // 1. Categories (handled from product_categories)
            // 2. BUILDING TYPE
            // 3. ROOM / AREA TYPE
            // 4. AREA RANGE (M²)
            // 5. OCCUPANCY
            // 6. HEALTH CONCERN
            // 7. PROBLEM
            // 8. SOLUTION NEEDED
            // 9. BUDGET RANGE
            // =========================================================================

            [
                'name'                  => 'Building Type',
                'type'                  => 'radio',
                'icon'                  => 'bi-building',
                'show_in_catalog'       => 1,
                'show_in_filter'        => 1,
                'show_in_guided_finder' => 0,
                'guided_step_number'    => null,
                'guided_question'       => null,
                'guided_subtitle'       => null,
                'has_unknown_option'    => 0,
                'unknown_option_label'  => "I don't know",
                'values' => [
                    ['name' => 'Apartment', 'icon' => 'bi-building-fill', 'explanation' => 'Apartment & multi-family home.'],
                    ['name' => 'House', 'icon' => 'bi-house-door', 'explanation' => 'Standalone single family residential.'],
                    ['name' => 'Office', 'icon' => 'bi-briefcase', 'explanation' => 'Corporate office interior.'],
                    ['name' => 'Clinic', 'icon' => 'bi-hospital', 'explanation' => 'Healthcare facility & clinics.'],
                    ['name' => 'School', 'icon' => 'bi-mortarboard', 'explanation' => 'Classroom & education space.'],
                    ['name' => 'Warehouse', 'icon' => 'bi-boxes', 'explanation' => 'Storage & industrial warehouse.'],
                ]
            ],
            [
                'name'                  => 'Room / Area Type',
                'type'                  => 'radio',
                'icon'                  => 'bi-door-closed',
                'show_in_catalog'       => 1,
                'show_in_filter'        => 1,
                'show_in_guided_finder' => 0,
                'guided_step_number'    => null,
                'guided_question'       => null,
                'guided_subtitle'       => null,
                'has_unknown_option'    => 0,
                'unknown_option_label'  => "I don't know",
                'values' => [
                    ['name' => 'Living Room', 'icon' => 'bi-tv', 'explanation' => 'Living Room environment.'],
                    ['name' => 'Bedroom', 'icon' => 'bi-moon-stars', 'explanation' => 'Quiet bedroom environment.'],
                    ['name' => 'Kitchen', 'icon' => 'bi-fire', 'explanation' => 'Kitchen smoke and grease removal.'],
                    ['name' => 'Office Space', 'icon' => 'bi-laptop', 'explanation' => 'Commercial office productivity.'],
                    ['name' => 'Patient Room', 'icon' => 'bi-heart-pulse', 'explanation' => 'Medical-grade clean environment.'],
                    ['name' => 'Waiting Area', 'icon' => 'bi-people', 'explanation' => 'High-traffic waiting lounge.'],
                ]
            ],
            [
                'name'                  => 'Area Range (m²)',
                'type'                  => 'radio',
                'icon'                  => 'bi-aspect-ratio',
                'show_in_catalog'       => 1,
                'show_in_filter'        => 1,
                'show_in_guided_finder' => 0,
                'guided_step_number'    => null,
                'guided_question'       => null,
                'guided_subtitle'       => null,
                'has_unknown_option'    => 0,
                'unknown_option_label'  => "I don't know",
                'values' => [
                    ['name' => '0-20 m²', 'icon' => 'bi-box', 'explanation' => 'Small rooms up to 20 m².'],
                    ['name' => '21-50 m²', 'icon' => 'bi-aspect-ratio', 'explanation' => 'Medium rooms 21 to 50 m².'],
                    ['name' => '51-100 m²', 'icon' => 'bi-fullscreen', 'explanation' => 'Large areas 51 to 100 m².'],
                    ['name' => '100+ m²', 'icon' => 'bi-arrows-fullscreen', 'explanation' => 'Open floors over 100 m².'],
                ]
            ],
            [
                'name'                  => 'Occupancy',
                'type'                  => 'radio',
                'icon'                  => 'bi-people',
                'show_in_catalog'       => 1,
                'show_in_filter'        => 1,
                'show_in_guided_finder' => 0,
                'guided_step_number'    => null,
                'guided_question'       => null,
                'guided_subtitle'       => null,
                'has_unknown_option'    => 0,
                'unknown_option_label'  => "I don't know",
                'values' => [
                    ['name' => '1-2 Persons', 'icon' => 'bi-person', 'explanation' => 'Individual or couple density.'],
                    ['name' => '3-5 Persons', 'icon' => 'bi-people', 'explanation' => 'Small family or team room.'],
                    ['name' => '5-10 Persons', 'icon' => 'bi-people-fill', 'explanation' => 'Medium occupancy suite.'],
                    ['name' => '10+ Persons', 'icon' => 'bi-buildings', 'explanation' => 'High-density commercial room.'],
                ]
            ],
            [
                'name'                  => 'Health Concern',
                'type'                  => 'checkbox',
                'icon'                  => 'bi-shield-check',
                'show_in_catalog'       => 1,
                'show_in_filter'        => 1,
                'show_in_guided_finder' => 0,
                'guided_step_number'    => null,
                'guided_question'       => null,
                'guided_subtitle'       => null,
                'has_unknown_option'    => 0,
                'unknown_option_label'  => "I don't know",
                'values' => [
                    ['name' => 'Asthma', 'icon' => 'bi-lungs', 'explanation' => 'Asthma relief and prevention.'],
                    ['name' => 'Allergies', 'icon' => 'bi-flower1', 'explanation' => 'Pollen and allergen filtering.'],
                    ['name' => 'Viruses / Bacteria', 'icon' => 'bi-virus2', 'explanation' => 'Pathogen neutralization.'],
                    ['name' => 'Mold', 'icon' => 'bi-water', 'explanation' => 'Mold spore capture and moisture control.'],
                    ['name' => 'Chemicals (VOCs)', 'icon' => 'bi-droplet-half', 'explanation' => 'Formaldehyde and chemical removal.'],
                ]
            ],
            [
                'name'                  => 'Problem',
                'type'                  => 'checkbox',
                'icon'                  => 'bi-exclamation-triangle',
                'show_in_catalog'       => 1,
                'show_in_filter'        => 1,
                'show_in_guided_finder' => 0,
                'guided_step_number'    => null,
                'guided_question'       => null,
                'guided_subtitle'       => null,
                'has_unknown_option'    => 0,
                'unknown_option_label'  => "I don't know",
                'values' => [
                    ['name' => 'Dust', 'icon' => 'bi-cloud-fog', 'explanation' => 'Coarse and fine dust extraction.'],
                    ['name' => 'Odors', 'icon' => 'bi-droplet-half', 'explanation' => 'Gas-phase odor adsorption.'],
                    ['name' => 'Smoke', 'icon' => 'bi-fire', 'explanation' => 'Wildfire and tobacco smoke clearance.'],
                    ['name' => 'Pet Dander', 'icon' => 'bi-flower1', 'explanation' => 'Pet hair and dander filtration.'],
                    ['name' => 'High Humidity', 'icon' => 'bi-water', 'explanation' => 'Moisture balancing.'],
                ]
            ],
            [
                'name'                  => 'Solution Needed',
                'type'                  => 'checkbox',
                'icon'                  => 'bi-box-seam',
                'show_in_catalog'       => 1,
                'show_in_filter'        => 1,
                'show_in_guided_finder' => 0,
                'guided_step_number'    => null,
                'guided_question'       => null,
                'guided_subtitle'       => null,
                'has_unknown_option'    => 0,
                'unknown_option_label'  => "I don't know",
                'values' => [
                    ['name' => 'Air Purification', 'icon' => 'bi-box-seam', 'explanation' => 'Standalone HEPA / carbon clean air.'],
                    ['name' => 'Dehumidification', 'icon' => 'bi-droplet', 'explanation' => 'Moisture reduction.'],
                    ['name' => 'Humidification', 'icon' => 'bi-moisture', 'explanation' => 'Moisture addition.'],
                    ['name' => 'Ventilation', 'icon' => 'bi-arrow-left-right', 'explanation' => 'Fresh air exchange.'],
                    ['name' => 'Ozone Generation', 'icon' => 'bi-lightning', 'explanation' => 'Shock odor treatment.'],
                ]
            ],
            [
                'name'                  => 'Budget Range',
                'type'                  => 'radio',
                'icon'                  => 'bi-cash-stack',
                'show_in_catalog'       => 1,
                'show_in_filter'        => 1,
                'show_in_guided_finder' => 0,
                'guided_step_number'    => null,
                'guided_question'       => null,
                'guided_subtitle'       => null,
                'has_unknown_option'    => 0,
                'unknown_option_label'  => "I don't know",
                'values' => [
                    ['name' => 'Under $500', 'icon' => 'bi-cash', 'explanation' => 'Entry level air solutions.'],
                    ['name' => '$500 - $1,000', 'icon' => 'bi-cash-stack', 'explanation' => 'Mid-tier residential units.'],
                    ['name' => '$1,000 - $2,500', 'icon' => 'bi-gem', 'explanation' => 'Premium fresh air systems.'],
                    ['name' => 'Over $2,500', 'icon' => 'bi-bank', 'explanation' => 'Commercial and whole-building systems.'],
                ]
            ],
        ];

        foreach ($options as $index => $optionData) {
            $filterOption = FilterOption::create([
                'name'                  => $optionData['name'],
                'icon'                  => $optionData['icon'] ?? 'bi-list',
                'type'                  => $optionData['type'],
                'sort_order'            => $index,
                'status'                => 1,
                'show_in_filter'        => $optionData['show_in_filter'] ?? 1,
                'show_in_catalog'       => $optionData['show_in_catalog'] ?? 1,
                'show_in_guided_finder' => $optionData['show_in_guided_finder'] ?? 0,
                'guided_step_number'    => $optionData['guided_step_number'] ?? null,
                'guided_question'       => $optionData['guided_question'] ?? null,
                'guided_subtitle'       => $optionData['guided_subtitle'] ?? null,
                'has_unknown_option'    => $optionData['has_unknown_option'] ?? 0,
                'unknown_option_label'  => $optionData['unknown_option_label'] ?? "I don't know",
            ]);

            foreach ($optionData['values'] as $valueIndex => $valData) {
                $filterOption->optionValues()->create([
                    'name'        => $valData['name'],
                    'icon'        => $valData['icon'] ?? 'bi-check-circle',
                    'explanation' => $valData['explanation'] ?? null,
                    'sort_order'  => $valueIndex,
                    'status'      => 1,
                ]);
            }
        }
    }
}
