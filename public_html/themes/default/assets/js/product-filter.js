/**
 * AIRE Guided Product Finder — jQuery Dynamic Engine
 * Exactly matches Guided Product Finder Mockups (10 Steps)
 */

$(document).ready(function () {

    // 1. All 10 Guided Product Finder Steps Data Schema
    const STEPS_DATA = window.DYNAMIC_STEPS_DATA || [
        {
            stepNum: 1,
            stepId: "application",
            stepName: "APPLICATION",
            stepTitle: "WHERE WILL YOU USE IT?",
            stepTag: "APPLICATION / ENVIRONMENT",
            guided_question: "01 WHERE WILL YOU USE IT?",
            guided_subtitle: "APPLICATION / ENVIRONMENT",
            options: [
                { label: "Car / Vehicle", val: "car_vehicle", explanation: "Selected: Car / Vehicle. Routes to compact in-car or automotive air purification." },
                { label: "Personal Protection", val: "personal_protection", explanation: "Selected: Personal Protection. Wearable and personal air filtering devices." },
                { label: "Small Enclosed Space", val: "small_enclosed_space", explanation: "Selected: Small Enclosed Space. Compact units tailored for tight cabins, closets, or small booths." },
                { label: "Single Room", val: "single_room", explanation: "Selected: Single Room. This routes the user to room-scale air solutions rather than vehicle, wearable or large-building systems." },
                { label: "Bedroom", val: "bedroom", explanation: "Selected: Bedroom. Prioritizes whisper-quiet, night-mode certified units." },
                { label: "Living Room", val: "living_room", explanation: "Selected: Living Room. Medium-to-high capacity air cleaning and ventilation." },
                { label: "Home / Apartment", val: "home_apartment", explanation: "Selected: Home / Apartment. Full residential or whole-apartment fresh air solutions." },
                { label: "Office", val: "office", explanation: "Selected: Office. Low-noise commercial air filtration for productivity." },
                { label: "Hospital / Healthcare", val: "hospital_healthcare", explanation: "Selected: Hospital / Healthcare. Medical-grade pathogen and virus neutralization." },
                { label: "School / Classroom", val: "school_classroom", explanation: "Selected: School / Classroom. High air exchange rate for crowded learning spaces." },
                { label: "Commercial Building", val: "commercial_building", explanation: "Selected: Commercial Building. Centralized high-capacity air treatment systems." },
                { label: "Industrial Facility", val: "industrial_facility", explanation: "Selected: Industrial Facility. Heavy-duty particulate and chemical exhaust filtration." }
            ]
        },
        {
            stepNum: 2,
            stepId: "product_family",
            stepName: "PRODUCT FAMILY",
            stepTitle: "WHAT DO YOU NEED?",
            stepTag: "PRODUCT FAMILY / SYSTEM TYPE",
            guided_question: "02 WHAT DO YOU NEED?",
            guided_subtitle: "PRODUCT FAMILY / SYSTEM TYPE",
            options: [
                { label: "Air Purifier", val: "air_purifier", explanation: "Selected: Air Purifier. Recirculates and purifies indoor air with multi-stage HEPA and carbon filters." },
                { label: "Fresh Air & Ventilation", val: "fresh_air_ventilation", explanation: "Selected: Fresh Air & Ventilation. FE6 is pursued as a fresh-air product, not as a standalone air-purifier-only or AC selection." },
                { label: "Air Conditioner / Climate Control", val: "air_conditioner_climate_control", explanation: "Selected: Air Conditioner / Climate Control. Temperature and climate regulation combined with air treatment." },
                { label: "Air Quality Monitor", val: "air_quality_monitor", explanation: "Selected: Air Quality Monitor. Precise real-time tracking of PM2.5, CO2, TVOC, and humidity." },
                { label: "Personal Air & Protection", val: "personal_air_protection", explanation: "Selected: Personal Air & Protection. Mobile and wearable personal clean air equipment." },
                { label: "Vehicle / Mobile Air System", val: "vehicle_mobile_air_system", explanation: "Selected: Vehicle / Mobile Air System. 12V automotive and on-the-go air purifiers." },
                { label: "Accessories / Filters", val: "accessories_filters", explanation: "Selected: Accessories / Filters. Replacement filter elements, pre-filters, and ducting parts." },
                { label: "Smart Controls", val: "smart_controls", explanation: "Selected: Smart Controls. IoT gateways, central control panels, and smart sensors." },
                { label: "Not sure — recommend", val: "not_sure_recommend", explanation: "Selected: Not sure — recommend. Let our algorithm recommend the best matching product family based on your needs." }
            ]
        },
        {
            stepNum: 3,
            stepId: "space_size",
            stepName: "SPACE SIZE",
            stepTitle: "HOW LARGE IS THE SPACE?",
            stepTag: "ROOM SIZE / COVERAGE",
            guided_question: "03 HOW LARGE IS THE SPACE?",
            guided_subtitle: "ROOM SIZE / COVERAGE",
            options: [
                { label: "Under 200 sq ft", val: "under_200_sq_ft", explanation: "Selected: Under 200 sq ft. Compact space coverage." },
                { label: "200-500 sq ft", val: "200_500_sq_ft", explanation: "Selected: 200-500 sq ft. Typical master bedroom or standard room coverage." },
                { label: "500-1,000 sq ft", val: "500_1000_sq_ft", explanation: "Selected: 500-1,000 sq ft. Large living room or combined open plan area." },
                { label: "1,000-2,000 sq ft", val: "1000_2000_sq_ft", explanation: "Selected: 1,000-2,000 sq ft. Whole apartment or floor-wide coverage." },
                { label: "2,000-5,000 sq ft", val: "2000_5000_sq_ft", explanation: "Selected: 2,000-5,000 sq ft. Multi-story residence or large open commercial floor." },
                { label: "5,000+ sq ft", val: "5000_plus_sq_ft", explanation: "Selected: 5,000+ sq ft. Massive commercial building or industrial facility scale." },
                { label: "I don't know", val: "i_dont_know", explanation: "Area not provided in this example, so we do not invent a room size. Coverage can be checked against the verified FE6 specification on the results page." }
            ]
        },
        {
            stepNum: 4,
            stepId: "airflow",
            stepName: "AIRFLOW",
            stepTitle: "AIRFLOW REQUIREMENT",
            stepTag: "AIRFLOW / PERFORMANCE",
            guided_question: "04 AIRFLOW REQUIREMENT",
            guided_subtitle: "AIRFLOW / PERFORMANCE",
            options: [
                { label: "Under 100 m³/h", val: "under_100_m3_h", explanation: "Selected: Under 100 m³/h. Ultra-quiet micro ventilation." },
                { label: "100–300 m³/h", val: "100_300_m3_h", explanation: "Selected: 100–300 m³/h. Standard residential fresh air delivery rate." },
                { label: "300–600 m³/h", val: "300_600_m3_h", explanation: "Selected: 300–600 m³/h. High-flow fresh air and rapid air renewal." },
                { label: "600–1,500 m³/h", val: "600_1500_m3_h", explanation: "Selected: 600–1,500 m³/h. Commercial air volume circulation." },
                { label: "1,500+ m³/h", val: "1500_plus_m3_h", explanation: "Selected: 1,500+ m³/h. Industrial-scale high volume air exchange." },
                { label: "I don't know", val: "i_dont_know", explanation: "Airflow is optional. Since the user does not know the required airflow, keep the path open and compare against the product's verified m³/h rating later." }
            ]
        },
        {
            stepNum: 5,
            stepId: "air_quality_needs",
            type: "checkbox",
            stepType: "checkbox",
            stepName: "AIR QUALITY NEEDS",
            stepTitle: "WHAT MATTERS MOST?",
            stepTag: "AIR QUALITY NEEDS — SIMPLIFIED",
            guided_question: "05 WHAT MATTERS MOST?",
            guided_subtitle: "AIR QUALITY NEEDS — SIMPLIFIED",
            options: [
                { label: "Bring in fresh outdoor air", val: "bring_in_fresh_outdoor_air", explanation: "Selected: Fresh outdoor air. Introduces oxygen-rich outside air to lower CO2 and eliminate stuffiness." },
                { label: "Reduce PM2.5 / fine particles", val: "reduce_pm25_fine_particles", explanation: "Selected: PM2.5 reduction. Captures microscopic airborne pollutants and smoke particles." },
                { label: "Reduce odours / VOCs", val: "reduce_odours_vocs", explanation: "Selected: Odours & VOCs. Activated carbon adsorption for cooking smells, formaldehyde and chemicals." },
                { label: "HEPA filtration required", val: "hepa_filtration_required", explanation: "Selected: HEPA filtration. Medical-grade 99.97% or higher particle capture standard." },
                { label: "Heat / energy recovery", val: "heat_energy_recovery", explanation: "Selected: Heat / energy recovery. Minimizes heating and cooling loss during continuous air exchange." },
                { label: "Monitor CO2", val: "monitor_co2", explanation: "Selected: CO2 monitoring. Integrated sensor monitoring for indoor carbon dioxide levels." },
                { label: "Humidity control", val: "humidity_control", explanation: "Selected: Humidity control. Prevents condensation or relieves excessively dry indoor air." },
                { label: "Not sure — recommend", val: "not_sure_recommend", explanation: "Selected: Not sure — recommend. Balanced general clean air and fresh ventilation profile." }
            ]
        },
        {
            stepNum: 6,
            stepId: "requirements",
            stepName: "REQUIREMENTS",
            stepTitle: "ANY INSTALLATION REQUIREMENTS?",
            stepTag: "INSTALLATION / USE",
            guided_question: "06 ANY INSTALLATION REQUIREMENTS?",
            guided_subtitle: "INSTALLATION / USE",
            options: [
                { label: "Wall-mounted", val: "wall_mounted", explanation: "Selected: Wall-mounted. Through-wall mounted fresh air unit saving precious floor space." },
                { label: "Desktop / Tabletop", val: "desktop_tabletop", explanation: "Selected: Desktop / Tabletop. Compact personal clean air on your desk or nightstand." },
                { label: "Ceiling / Ducted", val: "ceiling_ducted", explanation: "Selected: Ceiling / Ducted. Concealed in ceiling with ducted distribution to multiple zones." },
                { label: "Portable", val: "portable", explanation: "Selected: Portable. Free-standing movable air system with plug-and-play simplicity." },
                { label: "Low noise", val: "low_noise", explanation: "Selected: Low noise. Ultra-quiet sleep operation under 30 dB." },
                { label: "Low energy use", val: "low_energy_use", explanation: "Selected: Low energy use. High-efficiency brushless DC motor with minimal power draw." },
                { label: "Smart / Remote control", val: "smart_remote_control", explanation: "Selected: Smart / Remote control. WiFi app control, scheduled timers, and automation." },
                { label: "No preference", val: "no_preference", explanation: "This is optional and can be skipped. Do not block FE6 from matching just because the customer has no installation preference." }
            ]
        },
        {
            stepNum: 7,
            stepId: "budget",
            stepName: "BUDGET",
            stepTitle: "WHAT IS YOUR BUDGET?",
            stepTag: "BUDGET / PRICE RANGE",
            guided_question: "07 WHAT IS YOUR BUDGET?",
            guided_subtitle: "BUDGET / PRICE RANGE",
            options: [
                { label: "Under $500", val: "under_500", explanation: "Selected: Under $500. Budget-friendly entry solution." },
                { label: "$500–$1,000", val: "500_1000", explanation: "Selected: $500–$1,000. Core residential fresh air or high-efficiency air purifier." },
                { label: "$1,000–$2,500", val: "1000_2500", explanation: "Selected: $1,000–$2,500. Premium multi-stage ERV/HRV fresh air units like BROAD FE6." },
                { label: "Over $2,500", val: "over_2500", explanation: "Selected: Over $2,500. Commercial or whole-building ducted ventilation system." },
                { label: "Not sure", val: "not_sure", explanation: "Budget is not specified in this sample. Confirm the storefront currency and compare with live FE6 pricing rather than using an invented price." }
            ]
        },
        {
            stepNum: 8,
            stepId: "matched_solutions",
            stepName: "MATCHED SOLUTIONS",
            stepTitle: "YOUR MATCHED SOLUTIONS",
            stepTag: "MATCHED PRODUCT",
            guided_question: "08 YOUR MATCHED SOLUTIONS",
            guided_subtitle: "MATCHED PRODUCT",
            options: [
                { label: "BROAD FE6 AirPro Fresh", val: "broad_fe6_airpro_fresh", explanation: "Target Product matched to your exact room and ventilation profile." },
                { label: "Compare Products", val: "compare_products", explanation: "Side-by-side technical specification comparison." },
                { label: "View Full Specifications", val: "view_full_specifications", explanation: "CADR, power consumption, sound level, and dimensions." },
                { label: "Check Coverage & Airflow", val: "check_coverage_airflow", explanation: "Verify m³/h ratings against your space dimensions." },
                { label: "View Features / Filters", val: "view_features_filters", explanation: "HEPA H13, electrostatic cleanable filter, and heat recovery core." },
                { label: "Price & Availability", val: "price_availability", explanation: "Direct pricing, stock status, and shipping information." }
            ]
        },
        {
            stepNum: 9,
            stepId: "product_result",
            stepName: "PRODUCT RESULT",
            stepTitle: "BROAD FE6 AIRPRO FRESH",
            stepTag: "PRODUCT RESULT / REVIEW",
            guided_question: "09 BROAD FE6 AIRPRO FRESH",
            guided_subtitle: "PRODUCT RESULT / REVIEW",
            options: [
                { label: "View Product Details", val: "view_product_details", explanation: "Open complete product datasheet and overview." },
                { label: "Compare Selected Products", val: "compare_selected_products", explanation: "Review alternatives and related accessories." },
                { label: "Buy Now", val: "buy_now", explanation: "Proceed directly to checkout." },
                { label: "Request a Quote", val: "request_quote", explanation: "Get a specialized quotation for your project." },
                { label: "Talk to an Expert", val: "talk_expert", explanation: "Consult with our HVAC air quality engineers." },
                { label: "Change My Answers", val: "change_answers", explanation: "Return to earlier steps to refine criteria." }
            ]
        },
        {
            stepNum: 10,
            stepId: "match_summary",
            stepName: "MATCH SUMMARY",
            stepTitle: "WHY FE6 MATCHED",
            stepTag: "MATCH SUMMARY",
            guided_question: "10 WHY FE6 MATCHED",
            guided_subtitle: "MATCH SUMMARY",
            options: [
                { label: "Application: Single Room", val: "app_single_room", explanation: "Ideal fit for single room and apartment environments." },
                { label: "Family: Fresh Air & Ventilation", val: "fam_fresh_air", explanation: "Continuous outdoor fresh air intake with energy recovery." },
                { label: "Area: Not specified", val: "area_not_specified", explanation: "Coverage matches broad residential space applications." },
                { label: "Airflow: Not specified", val: "airflow_not_specified", explanation: "Flexible multi-speed fan control accommodates diverse loads." },
                { label: "Needs: Fresh outdoor air + PM2.5", val: "needs_fresh_air_pm25", explanation: "Dual electrostatic and HEPA filtration with high PM2.5 efficiency." },
                { label: "Next: Verify specifications", val: "next_verify_specs", explanation: "Confirm voltage, duct dimensions, and installation accessories." }
            ]
        }
    ];

    // State Tracking
    let currentStep = 1;
    const userSelections = {};
    let availableOptionsMap = null;
    let isFetchingProgress = false;

    // Helper: check if a step is multi-select checkbox
    function isStepCheckbox(stepNum) {
        const step = STEPS_DATA.find(s => s.stepNum === stepNum);
        return step && (step.type === 'checkbox' || step.stepType === 'checkbox');
    }

    // Helper: check if a specific option value is selected in a step
    function isStepOptionSelected(stepNum, val) {
        const selections = userSelections[stepNum];
        if (!selections || !Array.isArray(selections)) return false;
        return selections.some(item => String(item.val).toLowerCase() === String(val).toLowerCase());
    }

    // Helper: get array of active selected values (excluding 'any') for a step
    function getStepSelectedValues(stepNum) {
        const selections = userSelections[stepNum];
        if (!selections || !Array.isArray(selections)) return [];
        return selections
            .map(item => item.val)
            .filter(v => v && v !== 'any' && v !== 'all');
    }

    // Helper: determine if an option has matching products in current selection
    function isOptionAvailable(stepId, optVal) {
        if (!availableOptionsMap || !optVal || optVal === 'any' || optVal === 'all') return true;

        const cleanStepKey = String(stepId).toLowerCase().replace(/[\s\(\)²\-]/g, '_').replace(/_+/g, '_').trim();
        const cleanOptVal = String(optVal).toLowerCase().replace(/[\s\-]/g, '_').trim();

        let allowedList = null;
        for (let k in availableOptionsMap) {
            const cleanK = k.toLowerCase().replace(/[\s\(\)²\-]/g, '_').replace(/_+/g, '_').trim();
            if (cleanK === cleanStepKey || cleanK.includes(cleanStepKey) || cleanStepKey.includes(cleanK)) {
                allowedList = availableOptionsMap[k];
                break;
            }
        }

        if (!allowedList || !Array.isArray(allowedList) || allowedList.length === 0) return true;

        return allowedList.some(item => {
            const cleanItem = String(item).toLowerCase().replace(/[\s\-]/g, '_').trim();
            return cleanItem === cleanOptVal || cleanItem.includes(cleanOptVal) || cleanOptVal.includes(cleanItem);
        });
    }

    // Build payload using all user selections up to the specified step
    function buildFilterPayload(stepLimit = STEPS_DATA.length) {
        const selectedSlugs = [];
        for (let k = 1; k <= stepLimit; k++) {
            const vals = getStepSelectedValues(k);
            vals.forEach(v => selectedSlugs.push(v));
        }

        const getValByStepId = (idKeyword) => {
            const step = STEPS_DATA.find(s => s.stepId && s.stepId.toLowerCase().includes(idKeyword));
            if (!step || stepLimit < step.stepNum) return '';
            const vals = getStepSelectedValues(step.stepNum);
            return vals.length > 0 ? vals[0] : '';
        };

        const getArrayByStepId = (idKeyword) => {
            const step = STEPS_DATA.find(s => s.stepId && s.stepId.toLowerCase().includes(idKeyword));
            if (!step || stepLimit < step.stepNum) return [];
            return getStepSelectedValues(step.stepNum);
        };

        return {
            _token: window.CSRF_TOKEN || '',
            category: getValByStepId('category'),
            industry: getValByStepId('industry'),
            building_type: getValByStepId('application') || getValByStepId('building'),
            room_type: getValByStepId('space_size') || getValByStepId('room'),
            area_range: getValByStepId('space_size') || getValByStepId('area'),
            occupancy: getValByStepId('occupancy'),
            health_concern: getArrayByStepId('air_quality_needs') || getArrayByStepId('health'),
            problem: getArrayByStepId('problem'),
            solution_needed: getArrayByStepId('product_family') || getArrayByStepId('solution'),
            budget: getValByStepId('budget'),
            category_slugs: selectedSlugs,
            page: 1
        };
    }

    // Backend query on step progression to fetch matching count & next step candidate options
    function fetchStepProgress(stepLimit, onComplete) {
        if (!window.FILTER_QUERY_URL) {
            if (typeof onComplete === 'function') onComplete();
            return;
        }

        const payload = buildFilterPayload(stepLimit);
        isFetchingProgress = true;

        const $btnNext = $('#btnNextStep');
        if ($btnNext.length && typeof onComplete === 'function') {
            $btnNext.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> SYNTHESIZING...');
        }

        $.ajax({
            url: window.FILTER_QUERY_URL,
            type: 'POST',
            data: payload,
            success: function (res) {
                if (res && res.status) {
                    if (res.available_options) {
                        availableOptionsMap = res.available_options;
                    }
                    if (res.count !== undefined) {
                        $('#liveMatchCountTag').text(res.count + ' Products Match');
                        $('.match-progress-count').text(`STEP ${currentStep} OF 10`);
                    }
                    window.LATEST_STEP_RESULT = res;
                }
            },
            complete: function () {
                isFetchingProgress = false;
                if ($btnNext.length) {
                    $btnNext.prop('disabled', false);
                }
                if (typeof onComplete === 'function') {
                    onComplete();
                }
            }
        });
    }

    // Initialize Selections matching the mockup journey
    const DEFAULT_PRESELECTIONS = {
        1: "Single Room",
        2: "Fresh Air & Ventilation",
        3: "I don't know",
        4: "I don't know",
        5: ["Bring in fresh outdoor air", "Reduce PM2.5 / fine particles"],
        6: "No preference",
        7: "Not sure",
        8: "BROAD FE6 AirPro Fresh",
        9: "View Product Details",
        10: "Application: Single Room"
    };

    STEPS_DATA.forEach(step => {
        const pre = DEFAULT_PRESELECTIONS[step.stepNum];
        if (pre) {
            if (Array.isArray(pre)) {
                userSelections[step.stepNum] = [];
                pre.forEach(pLabel => {
                    const matchedOpt = step.options.find(o => o.label.toLowerCase() === pLabel.toLowerCase()) || step.options[0];
                    userSelections[step.stepNum].push({
                        label: matchedOpt.label,
                        val: matchedOpt.val,
                        explanation: matchedOpt.explanation || ''
                    });
                });
            } else {
                const matchedOpt = step.options.find(o => o.label.toLowerCase() === pre.toLowerCase()) || step.options[0];
                userSelections[step.stepNum] = [{
                    label: matchedOpt.label,
                    val: matchedOpt.val,
                    explanation: matchedOpt.explanation || ''
                }];
            }
        } else {
            userSelections[step.stepNum] = [{
                label: step.options[0].label,
                val: step.options[0].val,
                explanation: step.options[0].explanation || ''
            }];
        }
    });

    // Render Full Wizard UI
    function renderWizard() {
        renderSidebarTracker();
        renderCenterWizard();
        updateProgressIndicators();
    }

    // 2. Render Left Sidebar Step Tracker (10 Steps matching mockup)
    function renderSidebarTracker() {
        const $list = $('#sidebarStepList');
        if (!$list.length) return;
        $list.empty();

        const JOURNEY_STEPS = [
            "APPLICATION",
            "PRODUCT FAMILY",
            "SPACE SIZE",
            "AIRFLOW",
            "AIR QUALITY NEEDS",
            "REQUIREMENTS",
            "BUDGET",
            "MATCHED SOLUTIONS",
            "PRODUCT RESULT",
            "MATCH SUMMARY"
        ];

        for (let i = 1; i <= 10; i++) {
            const formattedNum = String(i).padStart(2, '0');
            const stepObj = STEPS_DATA.find(s => s.stepNum === i);
            const name = JOURNEY_STEPS[i - 1] || (stepObj ? (stepObj.sidebar_name || stepObj.stepName) : '');
            const isActive = i === currentStep;
            const isCompleted = i < currentStep;

            let stateClass = 'upcoming';
            let statusHtml = '';

            if (isActive) {
                stateClass = 'active';
                statusHtml = '<div class="sidebar-step-status current">CURRENT STEP</div>';
            } else if (isCompleted) {
                stateClass = 'completed';
                statusHtml = '<div class="sidebar-step-status completed">COMPLETED</div>';
            }

            const itemHtml = `
                <div class="sidebar-step-item ${stateClass}" data-step="${i}">
                    <div class="sidebar-step-circle">${formattedNum}</div>
                    <div class="sidebar-step-info">
                        <div class="sidebar-step-name">${name}</div>
                        ${statusHtml}
                    </div>
                </div>
            `;
            $list.append(itemHtml);
        }
    }

    // Dynamic "Answer So Far" card matching mockup pages 0001 to 0007
    function renderAnswerSoFarHtml() {
        const activeData = STEPS_DATA.find(s => s.stepNum === currentStep);
        if (!activeData) return '';

        const selections = userSelections[currentStep] || [];
        if (selections.length === 0) return '';

        let labels = selections.map(s => s.label).join(' + ');
        let explanation = selections.map(s => s.explanation).filter(Boolean).join(' ');

        if (!explanation) {
            if (currentStep === 1) {
                explanation = 'Selected: ' + labels + '. This routes the user to room-scale air solutions rather than vehicle, wearable or large-building systems.';
            } else if (currentStep === 2) {
                explanation = 'Selected: ' + labels + '. FE6 is pursued as a fresh-air product, not as a standalone air-purifier-only or AC selection.';
            } else if (currentStep === 3) {
                explanation = 'Area not provided in this example, so we do not invent a room size. Coverage can be checked against the verified FE6 specification on the results page.';
            } else if (currentStep === 4) {
                explanation = 'Airflow is optional. Since the user does not know the required airflow, keep the path open and compare against the product\'s verified m³/h rating later.';
            } else if (currentStep === 5) {
                explanation = 'To reduce complexity, combine the old "Features" and "Air Concerns" steps into one needs step. Users state the desired outcome; technical filters appear only as optional preferences. FE6 should be matched only where its';
            } else if (currentStep === 6) {
                explanation = 'This is optional and can be skipped. Do not block FE6 from matching just because the customer has no installation preference.';
            } else if (currentStep === 7) {
                explanation = 'Budget is not specified in this sample. Confirm the storefront currency and compare with live FE6 pricing rather than using an invented price.';
            }
        }

        return `
            <div class="answer-so-far-box">
                <div class="answer-so-far-tag">ANSWER SO FAR</div>
                <div class="answer-so-far-title">${labels}</div>
                <div class="answer-so-far-desc">${explanation}</div>
            </div>
        `;
    }

    // Dynamic "TARGET PRODUCT" box for Steps 8, 9, 10 matching mockups
    function renderTargetProductHtml() {
        return `
            <div class="target-product-box">
                <div class="target-product-tag">TARGET PRODUCT</div>
                <div class="target-product-title">BROAD FE6 AirPro Fresh</div>
                <div class="target-product-desc">
                    Fresh Air &amp; Ventilation &bull; Intended application: Single Room<br>
                    Coverage / airflow / detailed features: verify against official model specification.
                </div>
            </div>
        `;
    }

    // 3. Render Center Panel Active Step Section matching mockups exactly 1:1
    function renderCenterWizard() {
        const $container = $('#wizardStepsContainer');
        $container.empty();

        // Check if all 10 steps completed
        if (currentStep > 10) {
            renderProtocolCompleteSummary($container);
            return;
        }

        const activeData = STEPS_DATA.find(s => s.stepNum === currentStep) || STEPS_DATA[0];
        const isCheckbox = isStepCheckbox(currentStep);
        const currentStepStr = String(currentStep).padStart(2, '0');
        const metaTag = activeData.guided_subtitle || activeData.stepTag || activeData.stepName;
        const questionText = (activeData.guided_question || activeData.stepHeading || activeData.stepTitle).replace(/^\d+\s*/, '');

        // Meta row: e.g. APPLICATION / ENVIRONMENT     STEP 1 / 10
        const metaRowHtml = `
            <div class="finder-meta-row">
                <span>${metaTag}</span>
                <span>STEP ${currentStep} / 10</span>
            </div>
        `;

        // Step heading: e.g. 01 WHERE WILL YOU USE IT?
        const headingHtml = `
            <h2 class="finder-step-heading">
                <span>${currentStepStr}</span> &nbsp;<span>${questionText}</span>
            </h2>
        `;

        // 3-Column Options Grid
        let optionsGridHtml = '<div class="finder-options-grid">';
        activeData.options.forEach((opt) => {
            const isAvail = isOptionAvailable(activeData.stepId, opt.val);
            const isSelected = isStepOptionSelected(currentStep, opt.val);
            const selectedClass = isSelected ? 'selected' : '';
            const disabledClass = isAvail ? '' : 'disabled';
            const checkedAttr = (isSelected && isAvail) ? 'checked' : '';
            const inputType = isCheckbox ? 'checkbox' : 'radio';
            const inputName = isCheckbox ? `step_${currentStep}[]` : `step_${currentStep}`;

            optionsGridHtml += `
                <div class="finder-option-card ${selectedClass} ${disabledClass}" data-step="${currentStep}" data-val="${opt.val}" data-label="${opt.label}" data-explanation="${opt.explanation || ''}" data-type="${inputType}">
                    <input type="${inputType}" name="${inputName}" value="${opt.val}" ${checkedAttr} tabindex="-1">
                    <div class="finder-radio-circle">
                        <svg class="finder-radio-check-icon" width="10" height="8" viewBox="0 0 10 8" fill="none">
                            <path d="M1 4L3.5 6.5L9 1" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <span class="finder-option-label">${opt.label}</span>
                </div>
            `;
        });
        optionsGridHtml += '</div>';

        // Grid-aligned action buttons
        let btnGridHtml = '';
        if (currentStep === 1) {
            btnGridHtml = `
                <div class="finder-btn-grid">
                    <button type="button" class="btn-finder-next full-width" id="btnNextStep">NEXT &rarr;</button>
                </div>
            `;
        } else {
            let nextBtnText = 'NEXT &rarr;';
            if (currentStep === 8) nextBtnText = 'VIEW PRODUCT &rarr;';
            else if (currentStep === 10) nextBtnText = 'FINISH &rarr;';

            btnGridHtml = `
                <div class="finder-btn-grid">
                    <button type="button" class="btn-finder-prev" id="btnPrevStep">&larr; PREVIOUS</button>
                    <button type="button" class="btn-finder-next" id="btnNextStep">${nextBtnText}</button>
                </div>
            `;
        }

        // Answer So Far (Steps 1 to 7) or Target Product (Steps 8 to 10)
        const answerBoxHtml = currentStep <= 7 ? renderAnswerSoFarHtml() : renderTargetProductHtml();

        // Footnote matching mockup
        const footnoteHtml = `
            <div class="finder-footnote">FILLED EXAMPLE &mdash; FE6 JOURNEY &mdash; STEP ${currentStepStr}</div>
        `;

        $container.html(metaRowHtml + headingHtml + optionsGridHtml + btnGridHtml + answerBoxHtml + footnoteHtml);
    }

    // 4. Handle Protocol Complete (Directly fetch and display matched products)
    function renderProtocolCompleteSummary($container) {
        $container.html(`
            <div class="protocol-complete-header mb-4 p-4 rounded-4 bg-light border border-light-subtle text-center">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle mb-2" style="width: 44px; height: 44px;">
                    <i class="bi bi-shield-check fs-4"></i>
                </div>
                <h2 class="title-2 fs-22 fw-bold text-dark mb-1">Guided Product Finder Synthesis Complete</h2>
                <p class="fs-13 text-muted mb-0">System has matched the highest-rated configuration below based on your journey.</p>
            </div>
            <div id="protocolLoadingSpinner" class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Analyzing & loading specifications...</span>
                </div>
                <p class="fs-13 text-muted mt-2 fw-semibold">Loading matched solutions...</p>
            </div>
        `);

        if (window.LATEST_STEP_RESULT && window.LATEST_STEP_RESULT.products) {
            $('#protocolLoadingSpinner').remove();
            $('#liveMatchCountTag').text((window.LATEST_STEP_RESULT.count || 0) + ' Products Match');
            renderRelatedProducts(window.LATEST_STEP_RESULT, {
                total: window.LATEST_STEP_RESULT.total || window.LATEST_STEP_RESULT.count || 0
            });
        } else {
            triggerLiveProductCountQuery(1, true);
        }
    }

    // 5. Update Progress Bars & Counters
    function updateProgressIndicators() {
        const pct = Math.min(100, Math.round((currentStep / 10) * 100)) + '%';
        $('#topProgressFill, .sidebar-progress-fill').css('width', pct);
        $('#sidebarProgressCounter').text(`STEP ${currentStep} OF 10`);
    }

    // 6. jQuery Event Listeners (Delegated)
    $(document).on('click', '.finder-option-card:not(.disabled)', function (e) {
        e.preventDefault();
        const $card = $(this);
        const stepNum = parseInt($card.data('step'), 10);
        const val = String($card.data('val'));
        const label = $card.data('label');
        const explanation = $card.data('explanation') || '';
        const activeData = STEPS_DATA.find(s => s.stepNum === stepNum);
        const isCheckbox = isStepCheckbox(stepNum);

        if (!Array.isArray(userSelections[stepNum])) {
            userSelections[stepNum] = userSelections[stepNum] ? [userSelections[stepNum]] : [];
        }

        if (isCheckbox) {
            if (val === 'any' || val === 'all' || val === 'not_sure_recommend') {
                // Clicking "Any" or "Not sure": clear other selections
                userSelections[stepNum] = [{ label, val, explanation }];
                $card.addClass('selected').siblings().removeClass('selected');
                $card.find('input').prop('checked', true);
                $card.siblings().find('input').prop('checked', false);
            } else {
                // Remove "Any" or "Not sure" if it was selected
                userSelections[stepNum] = userSelections[stepNum].filter(item => item.val !== 'any' && item.val !== 'all' && item.val !== 'not_sure_recommend');
                $card.parent().find('[data-val="any"], [data-val="all"], [data-val="not_sure_recommend"]').removeClass('selected').find('input').prop('checked', false);

                const existingIndex = userSelections[stepNum].findIndex(item => String(item.val).toLowerCase() === val.toLowerCase());
                if (existingIndex > -1) {
                    // Already selected -> Deselect
                    userSelections[stepNum].splice(existingIndex, 1);
                    $card.removeClass('selected');
                    $card.find('input').prop('checked', false);
                } else {
                    // Not selected -> Select
                    userSelections[stepNum].push({ label, val, explanation });
                    $card.addClass('selected');
                    $card.find('input').prop('checked', true);
                }

                // If nothing left selected, auto-select first option
                if (userSelections[stepNum].length === 0) {
                    const anyOpt = activeData.options[0];
                    userSelections[stepNum] = [{ label: anyOpt.label, val: anyOpt.val, explanation: anyOpt.explanation || '' }];
                    $card.parent().find('[data-val="' + anyOpt.val + '"]').addClass('selected').find('input').prop('checked', true);
                }
            }
        } else {
            // Radio: single selection
            userSelections[stepNum] = [{ label, val, explanation }];
            $card.addClass('selected').siblings().removeClass('selected');
            $card.find('input').prop('checked', true);
            $card.siblings().find('input').prop('checked', false);
        }

        // Live update Answer So Far / Target Product box
        $('#answerSoFarWrapper').html(currentStep <= 7 ? renderAnswerSoFarHtml() : renderTargetProductHtml());

        // Update Sidebar Tracker
        renderSidebarTracker();

        // Background query to update match counts & pre-calculate available next options
        if (stepNum <= 7) {
            fetchStepProgress(stepNum);
        }
    });

    function smoothScrollToWizard() {
        const $panel = $('.guided-finder-main, .protocol-center-panel');
        if ($panel.length) {
            const offset = $(window).width() < 992 ? 70 : 100;
            const panelTop = $panel.offset().top - offset;
            const scrollPos = $(window).scrollTop();
            if (scrollPos > panelTop + 100 || scrollPos < panelTop - 200) {
                window.scrollTo({ top: panelTop, behavior: 'smooth' });
            }
        }
    }

    // Mobile Stepper Drawer Toggle
    $(document).on('click', '#mobileStepperToggle', function () {
        const $content = $('#protocolStepperContent');
        const $chevron = $(this).find('.mobile-stepper-chevron');
        const isOpen = $content.hasClass('is-open');
        if (isOpen) {
            $content.removeClass('is-open');
            $chevron.css('transform', 'rotate(0deg)');
            $(this).attr('aria-expanded', 'false');
        } else {
            $content.addClass('is-open');
            $chevron.css('transform', 'rotate(180deg)');
            $(this).attr('aria-expanded', 'true');
        }
    });

    // Next Step Button Click: Query backend, narrow next step options, and advance
    $(document).on('click', '#btnNextStep', function () {
        if (isFetchingProgress) return;

        if (currentStep < 10) {
            if (currentStep <= 7) {
                fetchStepProgress(currentStep, function () {
                    currentStep++;
                    renderWizard();
                    smoothScrollToWizard();
                });
            } else {
                currentStep++;
                renderWizard();
                smoothScrollToWizard();
            }
        } else {
            // Step 10 Finish Click
            currentStep = 11;
            renderWizard();
            smoothScrollToWizard();
        }
    });

    // Previous Step Button Click
    $(document).on('click', '#btnPrevStep', function () {
        if (currentStep > 1) {
            currentStep--;
            if (currentStep <= 7) {
                fetchStepProgress(currentStep - 1, function () {
                    renderWizard();
                    smoothScrollToWizard();
                });
            } else {
                renderWizard();
                smoothScrollToWizard();
            }
        }
    });

    // Restart Protocol Button Click (Reload site)
    $(document).on('click', '#btnRestartProtocol', function (e) {
        e.preventDefault();
        window.location.reload();
    });

    // Sidebar Step Item Click (Allow Jumping Back to Completed Steps)
    $(document).on('click', '.sidebar-step-item.completed, .step-item.completed', function () {
        const stepNum = parseInt($(this).data('step'), 10);
        if (stepNum && stepNum < currentStep) {
            currentStep = stepNum;
            // On mobile (< 992px), auto-collapse the stepper after selecting a step
            if ($(window).width() < 992) {
                $('#protocolStepperContent').removeClass('is-open');
                $('.mobile-stepper-chevron').css('transform', 'rotate(0deg)');
                $('#mobileStepperToggle').attr('aria-expanded', 'false');
            }
            if (currentStep <= 7) {
                fetchStepProgress(currentStep - 1, function () {
                    renderWizard();
                    smoothScrollToWizard();
                });
            } else {
                renderWizard();
                smoothScrollToWizard();
            }
        }
    });

    // Filter Group Accordion Toggle Handler
    $(document).on('click', '.filter-group__header', function () {
        const $currentGroup = $(this).closest('.filter-group');
        const isCollapsed = $currentGroup.hasClass('collapsed');

        // Collapse all filter groups
        $('.filter-group').addClass('collapsed');

        // If the clicked group was closed, open it (remove 'collapsed')
        if (isCollapsed) {
            $currentGroup.removeClass('collapsed');
        }
    });

    // GSAP ScrollTrigger Pinned Deck Animation (Bottom to Top Reveal) for #whyChooseStackedWrapper
    function initWhyChooseScrollTrigger() {
        if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;
        gsap.registerPlugin(ScrollTrigger);

        const stackedWrapper = document.getElementById('whyChooseStackedWrapper') || document.getElementById('whyChooseWrapper');
        if (!stackedWrapper) return;

        // 1. Clean up previous triggers on the same element to avoid ghost pinning or duplicate triggers
        ScrollTrigger.getAll().forEach(st => {
            if (st.vars && st.vars.trigger === stackedWrapper || st.trigger === stackedWrapper) {
                st.kill(true);
            }
        });

        // 2. Unwind any stale/cached .pin-spacer wrappers from browser history (bfcache)
        const pinSpacer = stackedWrapper.closest('.pin-spacer');
        if (pinSpacer && pinSpacer.parentElement) {
            pinSpacer.parentElement.insertBefore(stackedWrapper, pinSpacer);
            pinSpacer.remove();
        }

        // 3. Clear any leftover inline transforms
        gsap.set(stackedWrapper, { clearProps: "all" });
        gsap.set("#whyChooseStackedWrapper .stacked-card, #whyChooseWrapper .stacked-card", { clearProps: "transform" });

        if (window.innerWidth >= 992) {
            const tl = gsap.timeline({
                scrollTrigger: {
                    trigger: stackedWrapper,
                    start: "top 90px",
                    end: "+=1200",
                    scrub: 1,
                    pin: true,
                    anticipatePin: 1,
                    invalidateOnRefresh: true,
                    refreshPriority: 1
                }
            });

            tl.fromTo("#whyChooseStackedWrapper .card-layer-2, #whyChooseWrapper .card-layer-2", { y: "140%" }, { y: "0%", ease: "power1.out", duration: 1 })
                .fromTo("#whyChooseStackedWrapper .card-layer-3, #whyChooseWrapper .card-layer-3", { y: "140%" }, { y: "0%", ease: "power1.out", duration: 1 })
                .fromTo("#whyChooseStackedWrapper .card-layer-4, #whyChooseWrapper .card-layer-4", { y: "140%" }, { y: "0%", ease: "power1.out", duration: 1 });
        }
    }

    // Expose globally for AJAX / SPA navigation
    window.initWhyChooseScrollTrigger = initWhyChooseScrollTrigger;
    initWhyChooseScrollTrigger();

    // Refresh ScrollTrigger when window finishes loading all assets/images & fonts (Debounced & Desktop only)
    var filterRefreshTimer = null;
    function safeRefreshScrollTriggers() {
        if (typeof ScrollTrigger === 'undefined' || window.innerWidth < 992) return;
        clearTimeout(filterRefreshTimer);
        filterRefreshTimer = setTimeout(function () {
            if (typeof ScrollTrigger !== 'undefined') {
                ScrollTrigger.sort();
                ScrollTrigger.refresh();
            }
        }, 120);
    }

    if (document.readyState === 'complete') {
        safeRefreshScrollTriggers();
    } else {
        window.addEventListener('load', safeRefreshScrollTriggers, { once: true });
    }

    if (document.fonts && document.fonts.ready) {
        document.fonts.ready.then(safeRefreshScrollTriggers);
    }

    // Initialize Right Sidebar Featured Swiper Slider
    if (typeof Swiper !== 'undefined' && $('.featured-swiper').length && !$('.featured-swiper')[0].swiper) {
        new Swiper('.featured-swiper', {
            slidesPerView: 1,
            spaceBetween: 0,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.featured-swiper .swiper-pagination',
                clickable: true,
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            }
        });
    }

    // Living Hero Product Flight Animation on Scroll
    function initLivingHeroScrollTrigger() {
        const livingHeroSection = document.querySelector('#living-hero-section');
        const animatedProductImg = document.querySelector('#living-hero-animated-product');
        const productTargetBox = document.querySelector('#living-hero-product-target');
        const livingHeroImgBox = document.querySelector('#living-hero-img-box');

        if (!livingHeroSection || !animatedProductImg || !productTargetBox || !livingHeroImgBox) return;
        if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;

        // Ensure Lenis and GSAP share the same ticker loop
        if (typeof window.connectLenisToGsap === 'function') {
            window.connectLenisToGsap();
        }

        gsap.registerPlugin(ScrollTrigger);

        // 1. Clean up previous triggers on living hero section to avoid duplicates
        ScrollTrigger.getAll().forEach(st => {
            if (st.vars && (st.vars.trigger === livingHeroSection || st.vars.trigger === livingHeroImgBox || st.trigger === livingHeroSection || st.trigger === livingHeroImgBox)) {
                st.kill(true);
            }
        });

        // 2. Clear stale transforms & reset base centering
        gsap.set(animatedProductImg, { clearProps: "transform" });
        gsap.set(animatedProductImg, {
            xPercent: -50,
            yPercent: -50,
            x: 0,
            y: 0
        });

        // Start scroll animation smoothly when living hero image enters view
        gsap.fromTo(animatedProductImg,
            {
                y: 0
            },
            {
                y: () => {
                    const boxRect = livingHeroImgBox.getBoundingClientRect();
                    const targetRect = productTargetBox.getBoundingClientRect();
                    const startCenter = boxRect.top + (boxRect.height / 2);
                    const targetCenter = targetRect.top + (targetRect.height / 2);
                    return targetCenter - startCenter;
                },
                ease: "none",
                scrollTrigger: {
                    trigger: livingHeroImgBox,
                    start: "center center",
                    endTrigger: productTargetBox,
                    end: "center center",
                    scrub: 0.6,
                    invalidateOnRefresh: true
                }
            }
        );

        // Refresh trigger coordinates when images finish loading (handles first visit uncached state)
        const bgImg = livingHeroImgBox.querySelector('.living-hero__bg-img');
        if (bgImg && !bgImg.complete) {
            bgImg.addEventListener('load', function () {
                ScrollTrigger.refresh();
            }, { once: true });
        }
        if (!animatedProductImg.complete) {
            animatedProductImg.addEventListener('load', function () {
                ScrollTrigger.refresh();
            }, { once: true });
        }
    }

    // Expose globally for AJAX / page re-renders
    window.initLivingHeroScrollTrigger = initLivingHeroScrollTrigger;
    initLivingHeroScrollTrigger();


    // Render Other Matched Products Dynamically inside #other-matched-products
    const infiniteScroll = {
        currentPage: (window.INITIAL_PAGINATION && window.INITIAL_PAGINATION.currentPage) || 1,
        lastPage: (window.INITIAL_PAGINATION && window.INITIAL_PAGINATION.lastPage) || 1,
        isLoading: false,
        hasMore: (window.INITIAL_PAGINATION && window.INITIAL_PAGINATION.hasMore) || false
    };

    function generateProductCardHtml(p, colClass = 'col-lg-4 col-md-6 col-12') {
        // We simulate the blade template here.
        // Assume empty/false for active states initially since AJAX payload doesn't include session states.
        const inCart = false;
        const inCompare = false;
        const isFav = false;

        const categoryBgColor = p.category_bg_color || '#6c757d';
        const categoryName = p.category || '';
        const subtitle = (p.subtitle || p.category || 'ENTERPRISE FILTRATION').toUpperCase();

        let badgeHtml = '';
        if (categoryName || (p.quantity <= 5 && p.quantity > 0)) {
            badgeHtml = `<div class="product-card__badge-wrapper">`;
            if (categoryName) {
                badgeHtml += `<span class="product-card__badge-pill" style="background-color: ${categoryBgColor} !important; color: #ffffff !important;">${categoryName}</span>`;
            }
            if (p.quantity <= 5 && p.quantity > 0) {
                badgeHtml += `<span class="product-card__badge-pill product-card__badge-pill--low-stock">Low Stock</span>`;
            }
            badgeHtml += `</div>`;
        }

        const rawPrice = parseFloat(p.raw_price || p.price || 0);
        const specialPrice = p.special_price ? parseFloat(p.special_price) : null;
        const hasSpecial = specialPrice !== null && specialPrice < rawPrice;

        let priceHtml = '';
        if (hasSpecial) {
            priceHtml = `
                <span class="product-card__price pre">$${rawPrice.toFixed(2)}</span>
                <span class="product-card__price">$${specialPrice.toFixed(2)}</span>
            `;
        } else if (rawPrice > 0) {
            priceHtml = `<span class="product-card__price">$${rawPrice.toFixed(2)}</span>`;
        }

        const imageSrc = p.main_image || '/themes/default/assets/img/Air-Purify.png';

        return `
            <div class="${colClass} mb-3 product-card-col">
                <div class="product-card position-relative h-100">
                    ${badgeHtml}
                    <div class="product-card__labels position-absolute d-flex flex-column gap-2">
                        <button type="button" class="btn-add-to-cart ${inCart ? 'active' : ''}"
                            data-product-id="${p.id}" data-bs-toggle="tooltip" data-bs-placement="left"
                            title="${inCart ? 'In Cart' : 'Add to Cart'}" aria-label="${inCart ? 'In Cart' : 'Add to Cart'}">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M17 18C17.5304 18 18.0391 18.2107 18.4142 18.5858C18.7893 18.9609 19 19.4696 19 20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22C16.4696 22 15.9609 21.7893 15.5858 21.4142C15.2107 21.0391 15 20.5304 15 20C15 18.89 15.89 18 17 18ZM1 2H4.27L5.21 4H20C20.2652 4 20.5196 4.10536 20.7071 4.29289C20.8946 4.48043 21 4.73478 21 5C21 5.17 20.95 5.34 20.88 5.5L17.3 11.97C16.96 12.58 16.3 13 15.55 13H8.1L7.2 14.63L7.17 14.75C7.17 14.8163 7.19634 14.8799 7.24322 14.9268C7.29011 14.9737 7.3537 15 7.42 15H19V17H7C6.46957 17 5.96086 16.7893 5.58579 16.4142C5.21071 16.0391 5 15.5304 5 15C5 14.65 5.09 14.32 5.24 14.04L6.6 11.59L3 4H1V2ZM7 18C7.53043 18 8.03914 18.2107 8.41421 18.5858C8.78929 18.9609 9 19.4696 9 20C9 20.5304 8.78929 21.0391 8.41421 21.4142C8.03914 21.7893 7.53043 22 7 22C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20C5 18.89 5.89 18 7 18ZM16 11L18.78 6H6.14L8.5 11H16Z"
                                    fill="#0066CC" />
                            </svg>
                        </button>
                        <button type="button" class="btn-add-to-compare ${inCompare ? 'active' : ''}"
                            data-product-id="${p.id}" data-bs-toggle="tooltip" data-bs-placement="left"
                            title="${inCompare ? 'In Compare' : 'Compare this solution'}" aria-label="${inCompare ? 'In Compare' : 'Compare this solution'}">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M2 5C2 6.3 2.84 7.4 4 7.82V17.5C4 18.163 4.26339 18.7989 4.73223 19.2678C5.20107 19.7366 5.83696 20 6.5 20H10V22L14 19L10 16V18H6.5C6.22 18 6 17.78 6 17.5V7.82C7.16 7.41 8 6.31 8 5C8 3.35 6.65 2 5 2C3.35 2 2 3.35 2 5ZM5 4C5.55 4 6 4.45 6 5C6 5.55 5.55 6 5 6C4.45 6 4 5.55 4 5C4 4.45 4.45 4 5 4ZM20 16.18V6.5C20 5.83696 19.7366 5.20107 19.2678 4.73223C18.7989 4.26339 18.163 4 17.5 4H14V2L10 5L14 8V6H17.5C17.78 6 18 6.22 18 6.5V16.18C16.84 16.59 16 17.69 16 19C16 20.65 17.35 22 19 22C20.65 22 22 20.65 22 19C22 17.7 21.16 16.6 20 16.18ZM19 20C18.45 20 18 19.55 18 19C18 18.45 18.45 18 19 18C19.55 18 20 18.45 20 19C20 19.55 19.55 20 19 20Z"
                                    fill="#0066CC" />
                            </svg>
                        </button>
                        <button type="button" class="btn-toggle-favorite ${isFav ? 'active' : ''}"
                            data-product-id="${p.id}" data-bs-toggle="tooltip" data-bs-placement="left"
                            title="${isFav ? 'Remove from favorites' : 'Add to favorite'}" aria-label="${isFav ? 'Remove from favorites' : 'Add to favorite'}">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="${isFav ? '#dc3545' : 'none'}"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 20.9999L10.55 19.6999C8.86667 18.1832 7.475 16.8749 6.375 15.7749C5.275 14.6749 4.4 13.6872 3.75 12.8119C3.1 11.9366 2.646 11.1326 2.388 10.3999C2.13 9.66724 2.00067 8.91724 2 8.1499C2 6.58324 2.525 5.2749 3.575 4.2249C4.625 3.1749 5.93333 2.6499 7.5 2.6499C8.36667 2.6499 9.19167 2.83324 9.975 3.1999C10.7583 3.56657 11.4333 4.08324 12 4.7499C12.5667 4.08324 13.2417 3.56657 14.025 3.1999C14.8083 2.83324 15.6333 2.6499 16.5 2.6499C18.0667 2.6499 19.375 3.1749 20.425 4.2249C21.475 5.2749 22 6.58324 22 8.1499C22 8.91657 21.871 9.66657 21.613 10.3999C21.355 11.1332 20.9007 11.9372 20.25 12.8119C19.5993 13.6866 18.7243 14.6742 17.625 15.7749C16.5257 16.8756 15.134 18.1839 13.45 19.6999L12 20.9999ZM12 18.2999C13.6 16.8666 14.9167 15.6376 15.95 14.6129C16.9833 13.5882 17.8 12.6966 18.4 11.9379C19 11.1792 19.4167 10.5039 19.65 9.9119C19.8833 9.3199 20 8.73257 20 8.1499C20 7.1499 19.6667 6.31657 19 5.6499C18.3333 4.98324 17.5 4.6499 16.5 4.6499C15.7167 4.6499 14.9917 4.87057 14.325 5.3119C13.6583 5.75324 13.2 6.3159 12.95 6.9999H11.05C10.8 6.31657 10.3417 5.75424 9.675 5.3129C9.00833 4.87157 8.28333 4.65057 7.5 4.6499C6.5 4.6499 5.66667 4.98324 5 5.6499C4.33333 6.31657 4 7.1499 4 8.1499C4 8.73324 4.11667 9.3209 4.35 9.9129C4.58333 10.5049 5 11.1799 5.6 11.9379C6.2 12.6959 7.01667 13.5876 8.05 14.6129C9.08333 15.6382 10.4 16.8672 12 18.2999Z"
                                    fill="${isFav ? '#dc3545' : '#0066CC'}" />
                            </svg>
                        </button>
                    </div>
                    <div class="product-card__image-wrapper">
                        <a href="${p.url}" aria-label="${p.name}">
                            <img src="${imageSrc}" alt="${p.name}" class="product-card__image" loading="lazy">
                        </a>
                    </div>
                    <h3 class="product-card__title">
                        <a href="${p.url}">
                            ${p.name}
                        </a>
                    </h3>
                    <div class="product-card__category">
                        ${subtitle}
                    </div>
                    <div class="product-card__actions">
                        <div class="d-flex gap-2 align-items-center">
                            <button type="button" class="product-card__btn-buy btn-buy-now" data-product-id="${p.id}">Buy</button>
                            <div class="d-flex flex-column gap-0">
                                ${priceHtml}
                            </div>
                        </div>
                        <a href="${p.url}" class="product-card__btn-learn" aria-label="Learn more about ${p.name}">Learn more</a>
                    </div>
                </div>
            </div>
        `;
    }

    function generateBestMatchHeroHtml(p) {
        const inCart = false;
        const inCompare = false;
        const isFav = false;
        const categoryBgColor = p.category_bg_color || '#0066cc';
        const categoryName = p.category || 'Air Solution';
        const subtitle = (p.subtitle || 'OPTIMAL ARCHITECTURAL MATCH').toUpperCase();

        return `
            <div class="best-matched-product-card mb-4 p-4 bg-white border border-success-subtle rounded-4 shadow-sm position-relative">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 pb-2 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-success text-white text-uppercase px-3 py-1.5 fw-bold" style="font-size: 11px; letter-spacing: 0.08em;">
                            <i class="bi bi-patch-check-fill me-1"></i> #1 Recommended Solution
                        </span>
                        <span class="badge bg-success-subtle text-success border border-success-subtle fw-bold px-2.5 py-1 fs-12">
                            98% Match Score
                        </span>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fs-12 fw-semibold" id="btnRestartProtocol">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reconfigure
                    </button>
                </div>

                <div class="row align-items-center g-4">
                    <div class="col-md-5 text-center">
                        <div class="best-match-img-box p-3 bg-light rounded-3 d-flex align-items-center justify-content-center" style="min-height: 220px;">
                            <a href="${p.url}">
                                <img src="${p.main_image}" alt="${p.name}" class="img-fluid" style="max-height: 220px; object-fit: contain;">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <span class="badge rounded-pill mb-2 px-2.5 py-1 text-white fs-11" style="background-color: ${categoryBgColor};">
                            ${categoryName}
                        </span>
                        <h2 class="title-2 fs-22 fw-bold text-dark mb-1">
                            <a href="${p.url}" class="text-decoration-none text-dark hover-primary">${p.name}</a>
                            ${p.model ? `<span class="text-muted fw-normal fs-15 ms-1">(${p.model})</span>` : ''}
                        </h2>
                        <div class="text-uppercase text-muted fs-11 fw-bold tracking-wider mb-2">${subtitle}</div>

                        ${p.description ? `<p class="fs-13 text-muted mb-3 line-clamp-2">${p.description}</p>` : ''}

                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="badge bg-light text-dark border px-2.5 py-1.5 fs-12 fw-medium">
                                <i class="bi bi-wind text-primary me-1"></i> CADR: <strong>${p.cadr || 'High Performance'}</strong>
                            </span>
                            <span class="badge bg-light text-dark border px-2.5 py-1.5 fs-12 fw-medium">
                                <i class="bi bi-shield-check text-success me-1"></i> Filtration: <strong>${p.filter_grade || 'HEPA H13'}</strong>
                            </span>
                        </div>

                        <div class="d-flex flex-wrap align-items-center justify-content-between pt-3 border-top gap-3">
                            <div class="price-wrap">
                                <span class="fs-11 text-muted text-uppercase d-block fw-semibold">Configured Price</span>
                                <span class="fs-22 fw-bold text-dark">$${p.price}</span>
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="${p.url}" class="btn btn-outline-dark btn-sm rounded-pill px-3 py-2 fw-semibold">
                                    Full Specs <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                                <a href="/contact" class="btn btn-outline-primary btn-sm rounded-pill px-3 py-2 fw-semibold">
                                    <i class="bi bi-chat-dots me-1"></i> Request Quote
                                </a>
                                <button type="button" class="btn btn-primary btn-sm rounded-pill px-4 py-2 fw-bold btn-buy-now" data-product-id="${p.id}">
                                    Buy Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    function generateWhyMatchedMatrixHtml(p) {
        if (!p) return '';
        let rowsHtml = '';

        STEPS_DATA.forEach(step => {
            const selections = userSelections[step.stepNum];
            if (!selections || selections.length === 0) return;
            const targetSelections = selections.filter(s => s.val !== 'any' && s.val !== 'all');
            const userChoice = targetSelections.length > 0 ? targetSelections.map(s => s.label).join(', ') : 'Any / Flexible';

            // Find matching product attribute or filter option
            let matchedSpec = '';
            if (p.filter_options && Array.isArray(p.filter_options)) {
                const found = p.filter_options.find(fo => {
                    const optName = (fo.option_name || '').toLowerCase();
                    const stepTag = (step.stepTag || step.stepName || '').toLowerCase();
                    return optName.includes(stepTag) || stepTag.includes(optName);
                });
                if (found) {
                    matchedSpec = found.value_name;
                }
            }

            if (!matchedSpec) {
                if (step.stepId.includes('area') || step.stepId.includes('coverage')) matchedSpec = p.cadr ? `High CADR (${p.cadr})` : 'Optimal coverage capacity';
                else if (step.stepId.includes('health') || step.stepId.includes('problem')) matchedSpec = p.filter_grade ? `${p.filter_grade} Medical Grade Filtration` : 'Multi-stage active filtration';
                else if (step.stepId.includes('budget')) matchedSpec = p.price ? `$${p.price} / High-value tier` : 'Within budget';
                else matchedSpec = p.subtitle || 'Architectural compliance certified';
            }

            const stepNumStr = String(step.stepNum).padStart(2, '0');
            const stepNameClean = (step.guided_question || step.stepName).replace(/^\d+\.\s*/, '');

            rowsHtml += `
                <tr>
                    <td class="align-middle fw-bold fs-12 text-uppercase text-secondary">
                        <span class="badge bg-light text-dark border me-1">${stepNumStr}</span> ${stepNameClean}
                    </td>
                    <td class="align-middle fs-13 text-dark fw-semibold">
                        <i class="bi bi-person-check text-primary me-1"></i> ${userChoice}
                    </td>
                    <td class="align-middle fs-13 text-muted">
                        <i class="bi bi-cpu text-success me-1"></i> ${matchedSpec}
                    </td>
                    <td class="align-middle text-center">
                        <span class="badge bg-success text-white px-2.5 py-1 rounded-pill fs-11">
                            <i class="bi bi-check-circle-fill me-1"></i> Matched
                        </span>
                    </td>
                </tr>
            `;
        });

        if (!rowsHtml) return '';
        return '';
        // return `
        //     <div class="why-matched-matrix-card mb-4 p-4 bg-white border border-light-subtle rounded-4 shadow-sm">
        //         <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom flex-wrap gap-2">
        //             <div class="d-flex align-items-center gap-2">
        //                 <div class="bg-success-subtle text-success p-2 rounded-circle" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
        //                     <i class="bi bi-check2-circle fs-5"></i>
        //                 </div>
        //                 <div>
        //                     <h4 class="fs-16 fw-bold text-dark mb-0">10. Why This System Matched Your Requirements</h4>
        //                     <p class="fs-12 text-muted mb-0">Dynamic requirement-to-specification validation matrix</p>
        //                 </div>
        //             </div>
        //             <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1.5 rounded-pill fs-12 fw-bold">
        //                 <i class="bi bi-shield-fill-check me-1"></i> 100% Certified Solution
        //             </span>
        //         </div>
        //         <div class="table-responsive">
        //             <table class="table table-hover table-sm align-middle mb-0">
        //                 <thead class="table-light">
        //                     <tr class="fs-11 text-uppercase text-muted">
        //                         <th style="width: 25%;">Question / Criterion</th>
        //                         <th style="width: 30%;">Your Need</th>
        //                         <th style="width: 33%;">System Specification</th>
        //                         <th style="width: 12%;" class="text-center">Status</th>
        //                     </tr>
        //                 </thead>
        //                 <tbody>
        //                     ${rowsHtml}
        //                 </tbody>
        //             </table>
        //         </div>
        //     </div>
        // `;
    }

    // Render Matched Products List (products[0] as #1 Best Match + products[1..n] in grid below)
    function renderRelatedProducts(data, meta) {
        const $section = $('#other-matched-products, #Related-products');
        if (!$section.length) return;

        // Extract products array from API response
        let products = [];
        if (data && Array.isArray(data.products)) {
            products = data.products;
        } else if (Array.isArray(data)) {
            products = data;
        } else if (data && data.best_product) {
            products = [data.best_product, ...(data.other_products || data.related_products || [])];
        }

        if (!products || products.length === 0) {
            $section.html(`
                <div class="p-4 bg-light rounded-4 border text-center my-4">
                    <i class="bi bi-search fs-3 text-muted mb-2 d-block"></i>
                    <h4 class="fs-16 fw-bold text-dark mb-1">No Exact Matches Found</h4>
                    <p class="fs-13 text-muted mb-3">No specific product matches all combined criteria simultaneously.</p>
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold" id="btnRestartProtocol">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reconfigure Protocol
                        </button>
                        <a href="${window.CATALOG_URL || '/categories'}" class="btn btn-sm btn-outline-dark rounded-pill px-3 fw-semibold">
                            Browse Catalog
                        </a>
                    </div>
                </div>
            `);
            return;
        }

        // 1. First index [0] is ALWAYS the #1 Best Match product
        const bestMatch = products[0];

        // 2. All remaining indices [1..n] are rendered directly below in the grid
        const otherProducts = products.slice(1);

        let bestMatchHtml = generateBestMatchHeroHtml(bestMatch) + generateWhyMatchedMatrixHtml(bestMatch);
        let otherCardsHtml = '';
        otherProducts.forEach(p => {
            otherCardsHtml += generateProductCardHtml(p, 'col-lg-4 col-md-6 col-12');
        });

        let otherSectionHtml = '';
        if (otherProducts.length > 0) {
            otherSectionHtml = `
                <div class="other-matched-products-wrapper mt-4 pt-4 border-top">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="title-2 fs-18 fw-bold text-dark mb-0">
                            <i class="bi bi-grid-3x3-gap text-primary me-2"></i> Other Matching Products (${otherProducts.length})
                        </h3>
                        <a href="${window.CATALOG_URL || '/products-filter'}" class="btn btn-sm btn-link text-decoration-none fw-semibold fs-13 text-primary p-0">
                            View All in Catalog <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <div class="row g-3" id="matchedProductsGrid">
                        ${otherCardsHtml}
                    </div>
                </div>
            `;
        } else {
            otherSectionHtml = `
                <div class="row g-3 d-none" id="matchedProductsGrid"></div>
            `;
        }

        $section.html(bestMatchHtml + otherSectionHtml);

        // Initialize tooltips for newly rendered action buttons
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            $section.find('[data-bs-toggle="tooltip"]').each(function () {
                new bootstrap.Tooltip(this);
            });
        }
    }

    // Live AJAX Product Matching Query
    let queryTimeout = null;
    function triggerLiveProductCountQuery(page = 1, shouldScroll = false) {
        if (!window.FILTER_QUERY_URL) return;

        clearTimeout(queryTimeout);
        queryTimeout = setTimeout(function () {
            const payload = buildFilterPayload(9);
            payload.page = page;

            $.ajax({
                url: window.FILTER_QUERY_URL,
                type: 'POST',
                data: payload,
                success: function (res) {
                    $('#protocolLoadingSpinner').remove();
                    if (res && res.status) {
                        $('#liveMatchCountTag').text(res.count + ' Products Match');

                        // Render best match + other searched products
                        renderRelatedProducts(res, {
                            total: res.total || res.count || 0
                        });

                        if (shouldScroll && $('#other-matched-products').length) {
                            $('html, body').animate({
                                scrollTop: $('#other-matched-products').offset().top - 80
                            }, 500);
                        }
                    } else {
                        renderRelatedProducts([], {});
                    }
                },
                error: function (xhr, status, error) {
                    $('#protocolLoadingSpinner').remove();
                    $('#other-matched-products').html(`
                        <div class="p-4 bg-light rounded-4 border text-center my-4">
                            <i class="bi bi-exclamation-triangle text-warning fs-3 mb-2 d-block"></i>
                            <h4 class="fs-16 fw-bold text-dark mb-1">Notice</h4>
                            <p class="fs-13 text-muted mb-3">Unable to synthesize specifications at this moment.</p>
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold" id="btnRestartProtocol">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reconfigure Protocol
                                </button>
                                <a href="${window.CATALOG_URL || '/categories'}" class="btn btn-sm btn-outline-dark rounded-pill px-3 fw-semibold">
                                    Browse Catalog
                                </a>
                            </div>
                        </div>
                    `);
                }
            });
        }, 150);
    }

    $(document).on('click', '#btnViewProductsFinal, #btnViewProductsResult', function (e) {
        e.preventDefault();
        const cleanParams = new URLSearchParams();

        const singleParamMap = {
            1: 'category',
            2: 'building_type',
            3: 'room_type',
            4: 'area_range',
            5: 'occupancy',
            9: 'budget'
        };

        const arrayParamMap = {
            6: 'health_concern',
            7: 'problem',
            8: 'solution_needed'
        };

        Object.keys(singleParamMap).forEach(stepNum => {
            const vals = getStepSelectedValues(parseInt(stepNum, 10));
            if (vals.length > 0) {
                cleanParams.set(singleParamMap[stepNum], vals[0]);
            }
        });

        Object.keys(arrayParamMap).forEach(stepNum => {
            const vals = getStepSelectedValues(parseInt(stepNum, 10));
            vals.forEach(v => {
                cleanParams.append(arrayParamMap[stepNum] + '[]', v);
            });
        });

        const baseUrl = window.CATALOG_URL || '/products-filter';
        const targetUrl = cleanParams.toString() ? (baseUrl + '?' + cleanParams.toString()) : baseUrl;
        window.location.href = targetUrl;
    });

    // Initial Render
    renderWizard();
});


function initTestimonialsSwiper() {
    const sliderContainer = document.querySelector('.testimonials-slider');
    if (!sliderContainer || typeof Swiper === 'undefined') return;

    if (sliderContainer.swiper) {
        sliderContainer.swiper.update();
        return;
    }

    const slideCount = sliderContainer.querySelectorAll('.swiper-slide').length;
    if (slideCount === 0) return;

    new Swiper(sliderContainer, {
        slidesPerView: 1,
        spaceBetween: 24,
        loop: slideCount > 2,
        autoplay: slideCount > 1 ? {
            delay: 5000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        } : false,
        pagination: {
            el: sliderContainer.querySelector('.swiper-pagination') || '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            // When window width is >= 768px
            768: {
                slidesPerView: slideCount >= 2 ? 2 : 1,
                spaceBetween: 30,
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initTestimonialsSwiper();
});
window.initTestimonialsSwiper = initTestimonialsSwiper;