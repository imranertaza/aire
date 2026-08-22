<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $featuresMap = [
            'health' => [
                ['icon' => 'bi-shield-check', 'title' => 'PM2.5 Capture', 'desc' => 'Captures 99.97% of harmful airborne micro-particles.'],
                ['icon' => 'bi-flower1', 'title' => 'Allergen Reduction', 'desc' => 'Eliminates pollen, dust mites, and pet dander.'],
                ['icon' => 'bi-cloud', 'title' => 'CO2 & O2 Balance', 'desc' => 'Maintains optimal oxygen levels for peak wellness.'],
                ['icon' => 'bi-wind', 'title' => 'Continuous Fresh Air', 'desc' => 'Guarantees continuous 100% fresh air circulation.'],
            ],
            'energy' => [
                ['icon' => 'bi-cash-stack', 'title' => 'Cost Savings', 'desc' => 'Lower utility bills and operational costs.'],
                ['icon' => 'bi-tree', 'title' => 'Sustainable Solutions', 'desc' => 'Reduce carbon footprint and environmental impact.'],
                ['icon' => 'bi-cpu', 'title' => 'Intelligent Sensors', 'desc' => 'Real-time optimization based on occupancy.'],
                ['icon' => 'bi-thermometer-half', 'title' => 'Heat Recovery Tech', 'desc' => 'Retain indoor temperatures while ventilating.'],
            ],
            'sick-building' => [
                ['icon' => 'bi-shield-x', 'title' => 'VOC Elimination', 'desc' => 'Neutralize harmful off-gassing and chemicals.'],
                ['icon' => 'bi-moisture', 'title' => 'Mold Prevention', 'desc' => 'Control humidity to stop mold and mildew growth.'],
                ['icon' => 'bi-speedometer2', 'title' => 'CO2 Monitoring', 'desc' => 'Ensure optimal oxygen levels for alertness.'],
                ['icon' => 'bi-wind', 'title' => 'Odor Control', 'desc' => 'Eliminate unpleasant smells at their source.'],
            ],
            'infection' => [
                ['icon' => 'bi-virus', 'title' => 'Pathogen Defense', 'desc' => 'UV-C and electrostatic sterilization of airborne viruses.'],
                ['icon' => 'bi-shield-plus', 'title' => 'Medical Grade H14', 'desc' => '99.995% containment grade filtration.'],
                ['icon' => 'bi-hospital', 'title' => 'Clinical Isolation', 'desc' => 'Pressure gradient control for patient safety.'],
                ['icon' => 'bi-activity', 'title' => '24/7 Sterilization', 'desc' => 'Round-the-clock continuous pathogen neutralization.'],
            ],
            'compliance' => [
                ['icon' => 'bi-clipboard-check', 'title' => 'IAQ Standards', 'desc' => 'Meet ASHRAE, WELL, and LEED air standards.'],
                ['icon' => 'bi-file-earmark-bar-graph', 'title' => 'Audit Reports', 'desc' => 'Exportable audit-ready air quality compliance logs.'],
                ['icon' => 'bi-patch-check', 'title' => 'Certified Quality', 'desc' => 'Independently tested laboratory verification.'],
                ['icon' => 'bi-shield-lock', 'title' => 'Liability Protection', 'desc' => 'Safeguard building occupants and limit liability.'],
            ],
            'smart' => [
                ['icon' => 'bi-phone', 'title' => 'Mobile Cloud App', 'desc' => 'Monitor and control air purity from anywhere.'],
                ['icon' => 'bi-diagram-3', 'title' => 'BMS / BACnet Sync', 'desc' => 'Integrates seamlessly with existing building automation.'],
                ['icon' => 'bi-cpu', 'title' => 'AI Auto-Tuning', 'desc' => 'Self-learning algorithms adapt to pollution spikes.'],
                ['icon' => 'bi-wifi', 'title' => 'IoT Sensor Mesh', 'desc' => 'Multi-point distributed environmental data mesh.'],
            ],
            'residential' => [
                ['icon' => 'bi-house-heart', 'title' => 'Home Sanctuary', 'desc' => 'Clean, whisper-quiet air for living rooms and bedrooms.'],
                ['icon' => 'bi-moon-stars', 'title' => 'Ultra-Quiet Mode', 'desc' => 'Sub-20dB silent operation for uninterrupted sleep.'],
                ['icon' => 'bi-shield-check', 'title' => 'Family Protection', 'desc' => 'Guards against seasonal allergies, dust, and smoke.'],
                ['icon' => 'bi-phone', 'title' => 'Smart Home Sync', 'desc' => 'Works with AIRE App, Alexa, and Google Home.'],
            ],
            'commercial' => [
                ['icon' => 'bi-building', 'title' => 'Productivity Boost', 'desc' => 'Higher oxygen levels increase focus and reduce fatigue.'],
                ['icon' => 'bi-people', 'title' => 'Occupant Wellness', 'desc' => 'Fewer sick days and higher workplace satisfaction.'],
                ['icon' => 'bi-lightning-charge', 'title' => 'Energy Efficient', 'desc' => 'Demand-controlled ventilation lowers HVAC load.'],
                ['icon' => 'bi-diagram-3', 'title' => 'Central BMS Sync', 'desc' => 'Enterprise management across multi-story facilities.'],
            ],
            'healthcare' => [
                ['icon' => 'bi-hospital', 'title' => 'Infection Defense', 'desc' => 'Prevents cross-contamination in surgical & triage areas.'],
                ['icon' => 'bi-shield-plus', 'title' => 'HEPA H14 Standard', 'desc' => 'Sterile air exceeding international hospital standards.'],
                ['icon' => 'bi-heart-pulse', 'title' => 'Patient Recovery', 'desc' => 'Pure particulate-free air accelerates recovery.'],
                ['icon' => 'bi-check2-all', 'title' => 'Clinical Compliance', 'desc' => 'Meets strict CDC and WHO ventilation guidelines.'],
            ],
            'education' => [
                ['icon' => 'bi-mortarboard', 'title' => 'Cognitive Focus', 'desc' => 'Low CO2 levels enhance student concentration.'],
                ['icon' => 'bi-virus', 'title' => 'Healthier Classes', 'desc' => 'Reduces airborne virus spread in dense classrooms.'],
                ['icon' => 'bi-volume-mute', 'title' => 'Silent Learning', 'desc' => 'Designed for library and lecture acoustics.'],
                ['icon' => 'bi-sliders', 'title' => 'Smart Schedules', 'desc' => 'Custom operating hours matching school calendars.'],
            ],
            'transportation' => [
                ['icon' => 'bi-train-front', 'title' => 'Transit Filtration', 'desc' => 'Removes brake dust, exhaust, and heavy particulates.'],
                ['icon' => 'bi-people', 'title' => 'High Footfall IAQ', 'desc' => 'Handles massive passenger volumes smoothly.'],
                ['icon' => 'bi-shield-check', 'title' => 'Air Quality Alerts', 'desc' => 'Live monitoring across concourses and platforms.'],
                ['icon' => 'bi-wind', 'title' => 'Rapid Air Exchange', 'desc' => 'High CADR ventilation for cavernous terminals.'],
            ],
            'industrial' => [
                ['icon' => 'bi-cone-striped', 'title' => 'Heavy Fume Capture', 'desc' => 'Captures welding fumes, solvents, and chemical vapors.'],
                ['icon' => 'bi-shield-exclamation', 'title' => 'OSHA Compliance', 'desc' => 'Guarantees permissible exposure limit adherence.'],
                ['icon' => 'bi-gear-wide-connected', 'title' => 'Continuous 24/7 Duty', 'desc' => 'Robust metal chassis built for harsh environments.'],
                ['icon' => 'bi-funnel-fill', 'title' => 'High Airflow CADR', 'desc' => 'Massive CFM airflow for expansive factory floors.'],
            ],
            'infrastructure' => [
                ['icon' => 'bi-bank', 'title' => 'Public Safety', 'desc' => 'Certified air protection for government and public spaces.'],
                ['icon' => 'bi-shield-lock', 'title' => 'High Reliability', 'desc' => 'Fault-tolerant multi-stage air safety installations.'],
                ['icon' => 'bi-people', 'title' => 'Civic Protection', 'desc' => 'Cleaner indoor breathing environments for public visitors.'],
                ['icon' => 'bi-activity', 'title' => 'Continuous Monitoring', 'desc' => 'Auditable environmental logs and compliance reporting.'],
            ],
            'products' => [
                ['icon' => 'bi-box-seam', 'title' => 'Modular Design', 'desc' => 'Engineered for seamless installation and filter maintenance.'],
                ['icon' => 'bi-shield-check', 'title' => 'Medical H13/H14 HEPA', 'desc' => 'Hospital-grade certified particulate containment.'],
                ['icon' => 'bi-cpu', 'title' => 'IoT Smart Sensors', 'desc' => 'Real-time air analytics and auto-speed regulation.'],
                ['icon' => 'bi-award', 'title' => 'Industry Certified', 'desc' => 'Tested and certified by international IAQ standards.'],
            ],
            'technologies' => [
                ['icon' => 'bi-cpu', 'title' => 'Core Innovation', 'desc' => 'Proprietary aerodynamic and electronic air cleaning architectures.'],
                ['icon' => 'bi-shield-check', 'title' => 'Multi-Stage Filtration', 'desc' => 'Comprehensive mechanical, electrostatic, and chemical capture.'],
                ['icon' => 'bi-arrow-repeat', 'title' => 'High Thermal Efficiency', 'desc' => 'Up to 93% heat and energy recovery core performance.'],
                ['icon' => 'bi-diagram-3', 'title' => 'Smart IoT Synchronization', 'desc' => 'Direct protocol bridge connecting hardware to central BMS.'],
            ],
            'monitoring' => [
                ['icon' => 'bi-display', 'title' => 'Live Telemetry', 'desc' => 'Continuous high-frequency tracking of 9 critical IAQ parameters.'],
                ['icon' => 'bi-bell', 'title' => 'Instant Alerts', 'desc' => 'Instant escalation notifications when pollutant levels spike.'],
                ['icon' => 'bi-file-earmark-pdf', 'title' => 'Audit-Ready Reports', 'desc' => 'One-click automated ESG and regulatory compliance reporting.'],
                ['icon' => 'bi-buildings', 'title' => 'Enterprise Multi-Site', 'desc' => 'Unified global facility air intelligence from one console.'],
            ],
        ];

        $categories = ProductCategory::all();

        foreach ($categories as $category) {
            $catSlug = strtolower($category->slug ?? Str::slug($category->category_name));
            $matchedFeatures = null;

            foreach ($featuresMap as $key => $features) {
                if (Str::contains($catSlug, $key) || Str::contains(strtolower($category->category_name), $key)) {
                    $matchedFeatures = $features;
                    break;
                }
            }

            if (!$matchedFeatures) {
                $matchedFeatures = [
                    ['icon' => 'bi-shield-check', 'title' => 'Advanced Filtration', 'desc' => 'Captures 99.97% of airborne pollutants.'],
                    ['icon' => 'bi-lightning-charge', 'title' => 'Energy Efficient', 'desc' => 'Engineered for minimum power consumption.'],
                    ['icon' => 'bi-cpu', 'title' => 'Smart Automation', 'desc' => 'Adaptive air purification and IoT monitoring.'],
                    ['icon' => 'bi-award', 'title' => 'Certified Quality', 'desc' => 'Engineered to highest international standards.'],
                ];
            }

            $category->update(['features' => $matchedFeatures]);
        }
    }
}
