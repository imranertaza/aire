/**
 * AIRE Precision Selection Protocol — jQuery Dynamic Engine
 */

$(document).ready(function () {

    // 1. All 9 Protocol Steps Data Schema
    const STEPS_DATA = window.DYNAMIC_STEPS_DATA || [
        {
            stepNum: 1,
            stepId: "industry",
            stepName: "INDUSTRY",
            stepTitle: "Industries",
            stepTag: "PROTOCOL INIT",
            stepCount: "STEP 1 / 9",
            progressPct: 11,
            options: [
                { label: "Residential", icon: "bi-house", val: "Residential" },
                { label: "Commercial", icon: "bi-building", val: "Commercial" },
                { label: "Healthcare", icon: "bi-hospital", val: "Healthcare" },
                { label: "Education", icon: "bi-mortarboard", val: "Education" },
                { label: "Any", icon: "bi-grid", val: "Any" },
                { label: "All", icon: "bi-globe", val: "All" }
            ]
        },
        {
            stepNum: 2,
            stepId: "building",
            stepName: "BUILDING",
            stepTitle: "Building Type",
            stepTag: "BUILDING SELECTION",
            stepCount: "STEP 2 / 9",
            progressPct: 22,
            options: [
                { label: "Apartment", icon: "bi-building-fill", val: "Apartment" },
                { label: "Single Family", icon: "bi-house-heart", val: "Single Family" },
                { label: "Office Space", icon: "bi-briefcase", val: "Office Space" },
                { label: "Medical Clinic", icon: "bi-hospital", val: "Medical Clinic" },
                { label: "School", icon: "bi-mortarboard", val: "School" },
                { label: "Custom Facility", icon: "bi-gear", val: "Custom Facility" }
            ]
        },
        {
            stepNum: 3,
            stepId: "area",
            stepName: "AREA TYPE",
            stepTitle: "Area Category",
            stepTag: "SPACE CATEGORY",
            stepCount: "STEP 3 / 9",
            progressPct: 33,
            options: [
                { label: "Living Room", icon: "bi-tv", val: "Living Room" },
                { label: "Bedroom", icon: "bi-moon-stars", val: "Bedroom" },
                { label: "Whole House", icon: "bi-house-door", val: "Whole House" },
                { label: "Open Office", icon: "bi-laptop", val: "Open Office" },
                { label: "Clean Room", icon: "bi-shield-check", val: "Clean Room" },
                { label: "ICU / Surgery", icon: "bi-heart-pulse", val: "ICU / Surgery" }
            ]
        },
        {
            stepNum: 4,
            stepId: "coverage",
            stepName: "COVERAGE",
            stepTitle: "Coverage Scope",
            stepTag: "CAPACITY SCOPE",
            stepCount: "STEP 4 / 9",
            progressPct: 44,
            options: [
                { label: "< 300 sq ft", icon: "bi-box", val: "< 300 sq ft" },
                { label: "300 - 600 sq ft", icon: "bi-aspect-ratio", val: "300 - 600 sq ft" },
                { label: "600 - 1,000 sq ft", icon: "bi-fullscreen", val: "600 - 1,000 sq ft" },
                { label: "1,000+ sq ft", icon: "bi-bounding-box-circles", val: "1,000+ sq ft" },
                { label: "2,000+ sq ft", icon: "bi-arrows-fullscreen", val: "2,000+ sq ft" },
                { label: "Custom Facility", icon: "bi-sliders", val: "Custom Facility" }
            ]
        },
        {
            stepNum: 5,
            stepId: "occupancy",
            stepName: "OCCUPANCY",
            stepTitle: "Occupancy Density",
            stepTag: "DENSITY ESTIMATE",
            stepCount: "STEP 5 / 9",
            progressPct: 55,
            options: [
                { label: "1 - 2 People", icon: "bi-person", val: "1 - 2 People" },
                { label: "3 - 5 People", icon: "bi-people", val: "3 - 5 People" },
                { label: "6 - 10 People", icon: "bi-people-fill", val: "6 - 10 People" },
                { label: "11 - 25 People", icon: "bi-person-workspace", val: "11 - 25 People" },
                { label: "25+ People", icon: "bi-buildings", val: "25+ People" },
                { label: "High Traffic", icon: "bi-activity", val: "High Traffic" }
            ]
        },
        {
            stepNum: 6,
            stepId: "health",
            stepName: "HEALTH CONCERN",
            stepTitle: "Primary Health Concern",
            stepTag: "HEALTH TARGETING",
            stepCount: "STEP 6 / 9",
            progressPct: 66,
            options: [
                { label: "Allergies", icon: "bi-flower1", val: "Allergies" },
                { label: "Wildfire Smoke", icon: "bi-fire", val: "Wildfire Smoke" },
                { label: "Chemicals", icon: "bi-virus", val: "Chemicals" },
                { label: "Viruses", icon: "bi-bug", val: "Viruses" },
                { label: "Odor Control", icon: "bi-wind", val: "Odor Control" },
                { label: "General Purity", icon: "bi-sparkles", val: "General Purity" }
            ]
        },
        {
            stepNum: 7,
            stepId: "problem",
            stepName: "PROBLEM",
            stepTitle: "Air Quality Contaminant",
            stepTag: "CONTAMINANT FILTER",
            stepCount: "STEP 7 / 9",
            progressPct: 77,
            options: [
                { label: "Dust & Pollen", icon: "bi-sun", val: "Dust & Pollen" },
                { label: "Pet Dander", icon: "bi-github", val: "Pet Dander" },
                { label: "Mold Spores", icon: "bi-droplet", val: "Mold Spores" },
                { label: "Smog / Exhaust", icon: "bi-cloud-haze2", val: "Smog / Exhaust" },
                { label: "Stale Air", icon: "bi-soundwave", val: "Stale Air" },
                { label: "Full Spectrum", icon: "bi-shield-lock", val: "Full Spectrum" }
            ]
        },
        {
            stepNum: 8,
            stepId: "solution",
            stepName: "SOLUTION NEEDED",
            stepTitle: "System Architecture",
            stepTag: "SYSTEM SPEC",
            stepCount: "STEP 8 / 9",
            progressPct: 88,
            options: [
                { label: "Purifier", icon: "bi-box-seam", val: "Purifier" },
                { label: "HVAC", icon: "bi-fan", val: "HVAC" },
                { label: "Wearable", icon: "bi-smartwatch", val: "Wearable" },
                { label: "Wall Mounted", icon: "bi-border-style", val: "Wall Mounted" },
                { label: "Ceiling Mounted", icon: "bi-distribute-vertical", val: "Ceiling Mounted" },
                { label: "Multi-Room", icon: "bi-diagram-3", val: "Multi-Room" }
            ]
        },
        {
            stepNum: 9,
            stepId: "budget",
            stepName: "BUDGET RANGE",
            stepTitle: "Budget Investment",
            stepTag: "PROTOCOL FINALIZATION",
            stepCount: "STEP 9 / 9",
            progressPct: 100,
            options: [
                { label: "Under $500", icon: "bi-cash", val: "Under $500" },
                { label: "$500 - $1,000", icon: "bi-cash-stack", val: "$500 - $1,000" },
                { label: "$1,000 - $2,500", icon: "bi-credit-card", val: "$1,000 - $2,500" },
                { label: "$2,500 - $5,000", icon: "bi-wallet2", val: "$2,500 - $5,000" },
                { label: "$5,000+", icon: "bi-bank", val: "$5,000+" },
                { label: "Quote", icon: "bi-file-earmark-text", val: "Quote" }
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
        return selections.some(item => String(item.val) === String(val));
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
    function buildFilterPayload(stepLimit = 9) {
        const selectedSlugs = [];
        for (let k = 1; k <= stepLimit; k++) {
            const vals = getStepSelectedValues(k);
            vals.forEach(v => selectedSlugs.push(v));
        }

        const getSingleVal = (stepNum) => {
            if (stepLimit < stepNum) return '';
            const vals = getStepSelectedValues(stepNum);
            return vals.length > 0 ? vals[0] : '';
        };

        const getArrayVals = (stepNum) => {
            if (stepLimit < stepNum) return [];
            return getStepSelectedValues(stepNum);
        };

        return {
            _token: window.CSRF_TOKEN || '',
            category: getSingleVal(1),
            industry: getSingleVal(1),
            building_type: getSingleVal(2),
            room_type: getSingleVal(3),
            area_range: getSingleVal(4),
            occupancy: getSingleVal(5),
            health_concern: getArrayVals(6),
            problem: getArrayVals(7),
            solution_needed: getArrayVals(8),
            budget: getSingleVal(9),
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
                        $('.protocol-analysis-pct').text(res.count + ' MATCHES');
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

    // Initialize Selections with default first choices
    STEPS_DATA.forEach(step => {
        userSelections[step.stepNum] = [{
            label: step.options[0].label,
            icon: step.options[0].icon,
            val: step.options[0].val
        }];
    });

    // Render Full Wizard UI
    function renderWizard() {
        renderSidebarTracker();
        renderCenterWizard();
        updateProgressIndicators();
    }

    // 2. Render Left Sidebar Step Tracker
    function renderSidebarTracker() {
        const $tracker = $('.step-tracker');
        $tracker.empty();

        STEPS_DATA.forEach(step => {
            const isActive = step.stepNum === currentStep;
            const isCompleted = step.stepNum < currentStep;
            const formattedNum = String(step.stepNum).padStart(2, '0');
            const selections = userSelections[step.stepNum] || [];

            let stateClass = '';
            if (isActive) stateClass = 'active';
            else if (isCompleted) stateClass = 'completed';

            let contentHtml = '';
            if (isCompleted || isActive) {
                if (selections.length === 0 || (selections.length === 1 && selections[0].val === 'any')) {
                    const defaultIcon = (selections[0] && selections[0].icon) || 'bi-grid';
                    contentHtml = `
                        <span class="step-summary-pill">
                            <i class="bi ${defaultIcon}"></i> Any
                        </span>
                    `;
                } else if (selections.length === 1) {
                    contentHtml = `
                        <span class="step-summary-pill">
                            <i class="bi ${selections[0].icon}"></i> ${selections[0].label}
                        </span>
                    `;
                } else {
                    const labelStr = selections.map(s => s.label).join(', ');
                    contentHtml = `
                        <span class="step-summary-pill" title="${labelStr}">
                            <i class="bi ${selections[0].icon}"></i> ${labelStr}
                        </span>
                    `;
                }
            } else {
                contentHtml = `<div class="step-name">—</div>`;
            }

            const stepItemHtml = `
                <div class="step-item ${stateClass}" data-step="${step.stepNum}">
                    <div class="step-dot">${formattedNum}</div>
                    <div class="step-content">
                        <span class="step-num-label">${step.stepName}</span>
                        <div>${contentHtml}</div>
                    </div>
                </div>
            `;
            $tracker.append(stepItemHtml);
        });
    }

    // 3. Render Center Panel Active & Inactive Step Sections with Progressive Narrowing
    function renderCenterWizard() {
        const $centerContainer = $('#wizardStepsContainer');
        $centerContainer.empty();

        // Check if all steps completed
        if (currentStep > STEPS_DATA.length) {
            renderProtocolCompleteSummary($centerContainer);
            return;
        }

        const activeData = STEPS_DATA.find(s => s.stepNum === currentStep);
        const formattedActiveNum = String(activeData.stepNum).padStart(2, '0');
        const isCheckbox = isStepCheckbox(currentStep);

        // Verify currently selected options are available; if not, fallback to 'any'
        if (userSelections[currentStep] && Array.isArray(userSelections[currentStep])) {
            userSelections[currentStep] = userSelections[currentStep].filter(item => {
                if (item.val === 'any' || item.val === 'all') return true;
                return isOptionAvailable(activeData.stepId, item.val);
            });

            if (userSelections[currentStep].length === 0) {
                const anyOpt = activeData.options.find(o => o.val === 'any') || activeData.options[0];
                userSelections[currentStep] = [{ label: anyOpt.label, icon: anyOpt.icon, val: anyOpt.val }];
                renderSidebarTracker();
            }
        }

        // Active Step Section
        let activeSectionHtml = `
            <div class="step-section step-animate-slide-up">
                <div class="step-title-row d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="step-title-num">${formattedActiveNum}</span>
                        <h2 class="step-title-text mb-0">${activeData.stepTitle}</h2>
                    </div>
                    ${isCheckbox ? '<span class="badge bg-light text-primary border rounded-pill px-3 py-1.5 fs-11 fw-semibold"><i class="bi bi-check2-all me-1"></i> Multi-select enabled</span>' : ''}
                </div>
                <div class="option-grid-3col">
        `;

        activeData.options.forEach((opt) => {
            const isAvail = isOptionAvailable(activeData.stepId, opt.val);
            const isSelected = isStepOptionSelected(currentStep, opt.val);
            const selectedClass = isSelected ? 'selected' : '';
            const disabledClass = isAvail ? '' : 'disabled';
            const disabledAttr = isAvail ? '' : 'disabled';
            const checkedAttr = (isSelected && isAvail) ? 'checked' : '';
            const inputType = isCheckbox ? 'checkbox' : 'radio';
            const inputName = isCheckbox ? `step_${currentStep}[]` : `step_${currentStep}`;

            activeSectionHtml += `
                <div class="option-card-step ${selectedClass} ${disabledClass}" data-step="${currentStep}" data-val="${opt.val}" data-label="${opt.label}" data-icon="${opt.icon}" data-type="${inputType}" role="button" tabindex="0" ${!isAvail ? 'title="No matching products for current selection"' : ''}>
                    <input type="${inputType}" name="${inputName}" value="${opt.val}" ${checkedAttr} ${disabledAttr} tabindex="-1">
                    <i class="bi ${opt.icon} option-card-step-icon"></i>
                    <span class="option-card-step-label">${opt.label}</span>
                </div>
            `;
        });

        activeSectionHtml += `
                </div>
                <div class="protocol-action-buttons d-flex align-items-center gap-2 gap-sm-3 mt-4 mb-4 mb-lg-5">
                    ${currentStep > 1 ? `
                    <button type="button" class="btn-protocol-prev-step flex-fill" id="btnPrevStep">
                        <i class="bi bi-arrow-left"></i> PREVIOUS
                    </button>
                    ` : ''}
                    <button type="button" class="btn-protocol-next-step ${currentStep === 1 ? 'w-100' : 'flex-fill'}" id="btnNextStep">
                        ${currentStep === 9 ? 'FINALIZE' : 'NEXT'} <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>
        `;

        // Render Inactive Step Section below if there is a next step
        let inactiveSectionHtml = '';
        if (currentStep < STEPS_DATA.length) {
            const nextData = STEPS_DATA.find(s => s.stepNum === currentStep + 1);
            if (nextData) {
                const formattedNextNum = String(nextData.stepNum).padStart(2, '0');

                inactiveSectionHtml = `
                <div class="step-section opacity-60">
                    <div class="step-title-row">
                        <span class="step-title-num text-muted" style="color: #cbd5e1 !important;">${formattedNextNum}</span>
                        <h2 class="step-title-text text-muted mb-0" style="color: #94a3b8 !important;">${nextData.stepTitle}</h2>
                    </div>
                    <div class="option-grid-3col">
                `;

                nextData.options.forEach(opt => {
                    const isNextAvail = isOptionAvailable(nextData.stepId, opt.val);
                    const optDisabledClass = isNextAvail ? '' : 'opacity-25';
                    inactiveSectionHtml += `
                    <div class="option-card-step disabled ${optDisabledClass}">
                        <i class="bi ${opt.icon} option-card-step-icon"></i>
                        <span class="option-card-step-label">${opt.label}</span>
                    </div>
                `;
                });

                inactiveSectionHtml += `
                    </div>
                </div>
            `;
            }
        }
        $centerContainer.append(activeSectionHtml + inactiveSectionHtml);
    }

    // 4. Handle Protocol Complete (Directly fetch and display matched products)
    function renderProtocolCompleteSummary($container) {
        $container.html(`
            <div class="protocol-complete-header mb-4 p-4 rounded-4 bg-light border border-light-subtle text-center">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle mb-2" style="width: 44px; height: 44px;">
                    <i class="bi bi-shield-check fs-4"></i>
                </div>
                <h2 class="title-2 fs-22 fw-bold text-dark mb-1">Precision Protocol Synthesis Complete</h2>
                <p class="fs-13 text-muted mb-0">System has analyzed your requirements and synthesized the highest-rated matching configuration below.</p>
            </div>
            <div id="protocolLoadingSpinner" class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Analyzing & loading specifications...</span>
                </div>
                <p class="fs-13 text-muted mt-2 fw-semibold">Synthesizing matched solutions...</p>
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
        if (currentStep > 9) {
            $('.step-progress-track-fill, .protocol-progress-fill').css('width', '100%');
            $('.protocol-analysis-pct').text('100%');
            $('.step-header-tag').text('PROTOCOL COMPLETE');
            $('.step-header-count').text('STEP 9 / 9');
            if ($('#mobileStepBadge').length) $('#mobileStepBadge').text('STEP 9 / 9');
            if ($('#mobileStepName').length) $('#mobileStepName').text('PROTOCOL COMPLETE');
            return;
        }

        const activeData = STEPS_DATA.find(s => s.stepNum === currentStep);
        const pctStr = activeData.progressPct + '%';

        $('.step-progress-track-fill, .protocol-progress-fill').css('width', pctStr);
        $('.step-header-tag').text(activeData.stepTag);
        $('.step-header-count').text(activeData.stepCount);
        if ($('#mobileStepBadge').length) $('#mobileStepBadge').text(activeData.stepCount);
        if ($('#mobileStepName').length) $('#mobileStepName').text(activeData.stepTitle);
    }

    // 6. jQuery Event Listeners (Delegated)
    $(document).on('click', '.option-card-step:not(.disabled)', function (e) {
        e.preventDefault();
        const $card = $(this);
        const stepNum = parseInt($card.data('step'), 10);
        const val = String($card.data('val'));
        const label = $card.data('label');
        const icon = $card.data('icon');
        const activeData = STEPS_DATA.find(s => s.stepNum === stepNum);
        const isCheckbox = isStepCheckbox(stepNum);

        if (!Array.isArray(userSelections[stepNum])) {
            userSelections[stepNum] = userSelections[stepNum] ? [userSelections[stepNum]] : [];
        }

        if (isCheckbox) {
            if (val === 'any' || val === 'all') {
                // Clicking "Any": clear other selections and only select "Any"
                userSelections[stepNum] = [{ label, icon, val }];
                $card.addClass('selected').siblings().removeClass('selected');
                $card.find('input').prop('checked', true);
                $card.siblings().find('input').prop('checked', false);
            } else {
                // Remove "Any" if it was selected
                userSelections[stepNum] = userSelections[stepNum].filter(item => item.val !== 'any' && item.val !== 'all');
                $card.parent().find('[data-val="any"], [data-val="all"]').removeClass('selected').find('input').prop('checked', false);

                const existingIndex = userSelections[stepNum].findIndex(item => String(item.val).toLowerCase() === val.toLowerCase());
                if (existingIndex > -1) {
                    // Already selected -> Deselect
                    userSelections[stepNum].splice(existingIndex, 1);
                    $card.removeClass('selected');
                    $card.find('input').prop('checked', false);
                } else {
                    // Not selected -> Select
                    userSelections[stepNum].push({ label, icon, val });
                    $card.addClass('selected');
                    $card.find('input').prop('checked', true);
                }

                // If nothing left selected, auto-select "Any"
                if (userSelections[stepNum].length === 0) {
                    const anyOpt = activeData.options.find(o => o.val === 'any') || activeData.options[0];
                    userSelections[stepNum] = [{ label: anyOpt.label, icon: anyOpt.icon, val: anyOpt.val }];
                    $card.parent().find('[data-val="' + anyOpt.val + '"]').addClass('selected').find('input').prop('checked', true);
                }
            }
        } else {
            // Radio: single selection
            userSelections[stepNum] = [{ label, icon, val }];
            $card.addClass('selected').siblings().removeClass('selected');
            $card.find('input').prop('checked', true);
            $card.siblings().find('input').prop('checked', false);
        }

        // Update Sidebar Tracker
        renderSidebarTracker();

        // Background query to update match counts & pre-calculate available next options
        fetchStepProgress(stepNum);
    });

    function smoothScrollToWizard() {
        const $panel = $('.protocol-center-panel');
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

        if (currentStep < STEPS_DATA.length) {
            fetchStepProgress(currentStep, function () {
                currentStep++;
                renderWizard();
                smoothScrollToWizard();
            });
        } else {
            fetchStepProgress(STEPS_DATA.length, function () {
                currentStep++;
                renderWizard();
                smoothScrollToWizard();
            });
        }
    });

    // Previous Step Button Click
    $(document).on('click', '#btnPrevStep', function () {
        if (currentStep > 1) {
            currentStep--;
            fetchStepProgress(currentStep - 1, function () {
                renderWizard();
                smoothScrollToWizard();
            });
        }
    });

    // Restart Protocol Button Click (Reload site)
    $(document).on('click', '#btnRestartProtocol', function (e) {
        e.preventDefault();
        window.location.reload();
    });

    // Sidebar Step Item Click (Allow Jumping Back to Completed Steps)
    $(document).on('click', '.step-item.completed', function () {
        const stepNum = parseInt($(this).data('step'), 10);
        if (stepNum && stepNum < currentStep) {
            currentStep = stepNum;
            // On mobile (< 992px), auto-collapse the stepper after selecting a step
            if ($(window).width() < 992) {
                $('#protocolStepperContent').removeClass('is-open');
                $('.mobile-stepper-chevron').css('transform', 'rotate(0deg)');
                $('#mobileStepperToggle').attr('aria-expanded', 'false');
            }
            fetchStepProgress(currentStep - 1, function () {
                renderWizard();
                smoothScrollToWizard();
            });
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

    // Refresh ScrollTrigger when window finishes loading all assets/images & fonts
    function safeRefreshScrollTriggers() {
        if (typeof ScrollTrigger !== 'undefined') {
            ScrollTrigger.sort();
            ScrollTrigger.refresh(true);
        }
    }

    if (document.readyState === 'complete') {
        setTimeout(safeRefreshScrollTriggers, 100);
    } else {
        window.addEventListener('load', function () {
            setTimeout(safeRefreshScrollTriggers, 100);
        });
    }

    if (document.fonts && document.fonts.ready) {
        document.fonts.ready.then(function () {
            setTimeout(safeRefreshScrollTriggers, 50);
        });
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

        gsap.registerPlugin(ScrollTrigger);

        // 1. Clean up previous triggers on living hero section to avoid duplicates
        ScrollTrigger.getAll().forEach(st => {
            if (st.vars && st.vars.trigger === livingHeroSection || st.trigger === livingHeroSection) {
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

        gsap.fromTo(animatedProductImg,
            {
                y: 0
            },
            {
                y: () => {
                    const startCenter = livingHeroImgBox.offsetTop + (livingHeroImgBox.offsetHeight / 2);
                    const targetCenter = productTargetBox.offsetTop + (productTargetBox.offsetHeight / 2);
                    return targetCenter - startCenter;
                },
                ease: "none",
                scrollTrigger: {
                    trigger: livingHeroSection,
                    start: "top top",
                    end: "bottom 85%",
                    scrub: 0.6,
                    invalidateOnRefresh: true
                }
            }
        );
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

    function generateProductCardHtml(p, colClass = 'col-md-6 col-sm-6') {
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

        return `
            <div class="${colClass} mb-3 product-card-col">
                <div class="product-card position-relative h-100">
                    ${badgeHtml}
                    <div class="product-card__labels position-absolute d-flex flex-column gap-2">
                        <a href="javascript:void(0);" class="btn-add-to-cart ${inCart ? 'active' : ''}"
                            data-product-id="${p.id}" data-bs-toggle="tooltip" data-bs-placement="left"
                            title="${inCart ? 'In Cart' : 'Add to Cart'}">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M17 18C17.5304 18 18.0391 18.2107 18.4142 18.5858C18.7893 18.9609 19 19.4696 19 20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22C16.4696 22 15.9609 21.7893 15.5858 21.4142C15.2107 21.0391 15 20.5304 15 20C15 18.89 15.89 18 17 18ZM1 2H4.27L5.21 4H20C20.2652 4 20.5196 4.10536 20.7071 4.29289C20.8946 4.48043 21 4.73478 21 5C21 5.17 20.95 5.34 20.88 5.5L17.3 11.97C16.96 12.58 16.3 13 15.55 13H8.1L7.2 14.63L7.17 14.75C7.17 14.8163 7.19634 14.8799 7.24322 14.9268C7.29011 14.9737 7.3537 15 7.42 15H19V17H7C6.46957 17 5.96086 16.7893 5.58579 16.4142C5.21071 16.0391 5 15.5304 5 15C5 14.65 5.09 14.32 5.24 14.04L6.6 11.59L3 4H1V2ZM7 18C7.53043 18 8.03914 18.2107 8.41421 18.5858C8.78929 18.9609 9 19.4696 9 20C9 20.5304 8.78929 21.0391 8.41421 21.4142C8.03914 21.7893 7.53043 22 7 22C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20C5 18.89 5.89 18 7 18ZM16 11L18.78 6H6.14L8.5 11H16Z"
                                    fill="#0066CC" />
                            </svg>
                        </a>
                        <a href="javascript:void(0);" class="btn-add-to-compare ${inCompare ? 'active' : ''}"
                            data-product-id="${p.id}" data-bs-toggle="tooltip" data-bs-placement="left"
                            title="${inCompare ? 'In Compare' : 'Compare this solution'}">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M2 5C2 6.3 2.84 7.4 4 7.82V17.5C4 18.163 4.26339 18.7989 4.73223 19.2678C5.20107 19.7366 5.83696 20 6.5 20H10V22L14 19L10 16V18H6.5C6.22 18 6 17.78 6 17.5V7.82C7.16 7.41 8 6.31 8 5C8 3.35 6.65 2 5 2C3.35 2 2 3.35 2 5ZM5 4C5.55 4 6 4.45 6 5C6 5.55 5.55 6 5 6C4.45 6 4 5.55 4 5C4 4.45 4.45 4 5 4ZM20 16.18V6.5C20 5.83696 19.7366 5.20107 19.2678 4.73223C18.7989 4.26339 18.163 4 17.5 4H14V2L10 5L14 8V6H17.5C17.78 6 18 6.22 18 6.5V16.18C16.84 16.59 16 17.69 16 19C16 20.65 17.35 22 19 22C20.65 22 22 20.65 22 19C22 17.7 21.16 16.6 20 16.18ZM19 20C18.45 20 18 19.55 18 19C18 18.45 18.45 18 19 18C19.55 18 20 18.45 20 19C20 19.55 19.55 20 19 20Z"
                                    fill="#0066CC" />
                            </svg>
                        </a>
                        <a href="javascript:void(0);" class="btn-toggle-favorite ${isFav ? 'active' : ''}"
                            data-product-id="${p.id}" data-bs-toggle="tooltip" data-bs-placement="left"
                            title="${isFav ? 'Remove from favorites' : 'Add to favorite'}">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="${isFav ? '#dc3545' : 'none'}"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 20.9999L10.55 19.6999C8.86667 18.1832 7.475 16.8749 6.375 15.7749C5.275 14.6749 4.4 13.6872 3.75 12.8119C3.1 11.9366 2.646 11.1326 2.388 10.3999C2.13 9.66724 2.00067 8.91724 2 8.1499C2 6.58324 2.525 5.2749 3.575 4.2249C4.625 3.1749 5.93333 2.6499 7.5 2.6499C8.36667 2.6499 9.19167 2.83324 9.975 3.1999C10.7583 3.56657 11.4333 4.08324 12 4.7499C12.5667 4.08324 13.2417 3.56657 14.025 3.1999C14.8083 2.83324 15.6333 2.6499 16.5 2.6499C18.0667 2.6499 19.375 3.1749 20.425 4.2249C21.475 5.2749 22 6.58324 22 8.1499C22 8.91657 21.871 9.66657 21.613 10.3999C21.355 11.1332 20.9007 11.9372 20.25 12.8119C19.5993 13.6866 18.7243 14.6742 17.625 15.7749C16.5257 16.8756 15.134 18.1839 13.45 19.6999L12 20.9999ZM12 18.2999C13.6 16.8666 14.9167 15.6376 15.95 14.6129C16.9833 13.5882 17.8 12.6966 18.4 11.9379C19 11.1792 19.4167 10.5039 19.65 9.9119C19.8833 9.3199 20 8.73257 20 8.1499C20 7.1499 19.6667 6.31657 19 5.6499C18.3333 4.98324 17.5 4.6499 16.5 4.6499C15.7167 4.6499 14.9917 4.87057 14.325 5.3119C13.6583 5.75324 13.2 6.3159 12.95 6.9999H11.05C10.8 6.31657 10.3417 5.75424 9.675 5.3129C9.00833 4.87157 8.28333 4.65057 7.5 4.6499C6.5 4.6499 5.66667 4.98324 5 5.6499C4.33333 6.31657 4 7.1499 4 8.1499C4 8.73324 4.11667 9.3209 4.35 9.9129C4.58333 10.5049 5 11.1799 5.6 11.9379C6.2 12.6959 7.01667 13.5876 8.05 14.6129C9.08333 15.6382 10.4 16.8672 12 18.2999Z"
                                    fill="${isFav ? '#dc3545' : '#0066CC'}" />
                            </svg>
                        </a>
                    </div>
                    <div class="product-card__image-wrapper">
                        <a href="${p.url}">
                            <img src="${p.main_image}" alt="${p.name}" class="product-card__image" loading="lazy">
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
                        <a href="javascript:void(0);" class="product-card__btn-buy btn-buy-now" data-product-id="${p.id}">Buy</a>
                        <a href="${p.url}" class="product-card__btn-learn">Learn more</a>
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
            <div class="best-matched-product-card mb-4 p-4 bg-white border rounded-4 shadow-sm position-relative">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 pb-2 border-bottom">
                    <span class="badge bg-primary text-white text-uppercase px-3 py-2 fw-bold" style="font-size: 11px; letter-spacing: 0.08em;">
                        <i class="bi bi-patch-check-fill me-1"></i> #1 Best Matched Solution
                    </span>
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fs-12 fw-semibold" id="btnRestartProtocol">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reconfigure Protocol
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
                            <div class="d-flex gap-2">
                                <a href="${p.url}" class="btn btn-outline-dark btn-sm rounded-pill px-3 py-2 fw-semibold">
                                    Full Specs <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                                <a href="javascript:void(0);" class="btn btn-primary btn-sm rounded-pill px-4 py-2 fw-bold btn-buy-now" data-product-id="${p.id}">
                                    Buy Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
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

        let bestMatchHtml = generateBestMatchHeroHtml(bestMatch);
        let otherCardsHtml = '';
        otherProducts.forEach(p => {
            otherCardsHtml += generateProductCardHtml(p, 'col-md-6 col-sm-6');
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