/**
 * AIRE Precision Selection Protocol — jQuery Dynamic Engine
 */

$(document).ready(function () {

    // 1. All 9 Protocol Steps Data Schema
    const STEPS_DATA = [
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

    // Initialize Selections with default first choices
    STEPS_DATA.forEach(step => {
        userSelections[step.stepNum] = {
            label: step.options[0].label,
            icon: step.options[0].icon,
            val: step.options[0].val
        };
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
            const selection = userSelections[step.stepNum];

            let stateClass = '';
            if (isActive) stateClass = 'active';
            else if (isCompleted) stateClass = 'completed';

            let contentHtml = '';
            if (isCompleted || isActive) {
                contentHtml = `
                    <span class="step-summary-pill">
                        <i class="bi ${selection.icon}"></i> ${selection.label}
                    </span>
                `;
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

    // 3. Render Center Panel Active & Inactive Step Sections
    function renderCenterWizard() {
        const $centerContainer = $('#wizardStepsContainer');
        $centerContainer.empty();

        // Check if all steps completed
        if (currentStep > 9) {
            renderProtocolCompleteSummary($centerContainer);
            return;
        }

        const activeData = STEPS_DATA.find(s => s.stepNum === currentStep);
        const formattedActiveNum = String(activeData.stepNum).padStart(2, '0');

        // Active Step Section
        let activeSectionHtml = `
            <div class="step-section step-animate-slide-up">
                <div class="step-title-row">
                    <span class="step-title-num">${formattedActiveNum}</span>
                    <h2 class="step-title-text">${activeData.stepTitle}</h2>
                </div>
                <div class="option-grid-3col">
        `;

        activeData.options.forEach((opt, idx) => {
            const isSelected = userSelections[currentStep].val === opt.val;
            const selectedClass = isSelected ? 'selected' : '';
            const checkedAttr = isSelected ? 'checked' : '';

            activeSectionHtml += `
                <label class="option-card-step ${selectedClass}" data-step="${currentStep}" data-val="${opt.val}" data-label="${opt.label}" data-icon="${opt.icon}">
                    <input type="radio" name="step_${currentStep}" value="${opt.val}" ${checkedAttr}>
                    <i class="bi ${opt.icon} option-card-step-icon"></i>
                    <span class="option-card-step-label">${opt.label}</span>
                </label>
            `;
        });

        activeSectionHtml += `
                </div>
                <div class="option-grid-3col g-3 mt-4 mb-5">
                    ${currentStep > 1 ? `
                    <div class="col">
                        <button type="button" class="btn-protocol-prev-step w-100" id="btnPrevStep">
                            <i class="bi bi-arrow-left"></i> PREVIOUS
                        </button>
                    </div>
                    ` : ''}
                    <div class="col ${currentStep === 1 ? 'offset-col' : ''}"> <!-- Or use w-100 if single -->
                        <button type="button" class="btn-protocol-next-step w-100" id="btnNextStep">
                            ${currentStep === 9 ? 'FINALIZE' : 'NEXT'} <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;

        // Render Inactive Step Section below if step < 9
        let inactiveSectionHtml = '';
        if (currentStep < 9) {
            const nextData = STEPS_DATA.find(s => s.stepNum === currentStep + 1);
            const formattedNextNum = String(nextData.stepNum).padStart(2, '0');

            inactiveSectionHtml = `
                <div class="step-section opacity-60">
                    <div class="step-title-row">
                        <span class="step-title-num text-muted" style="color: #cbd5e1 !important;">${formattedNextNum}</span>
                        <h2 class="step-title-text text-muted" style="color: #94a3b8 !important;">${nextData.stepTitle}</h2>
                    </div>
                    <div class="option-grid-3col">
            `;

            nextData.options.forEach(opt => {
                inactiveSectionHtml += `
                    <div class="option-card-step disabled">
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

        $centerContainer.append(activeSectionHtml + inactiveSectionHtml);
    }

    // 4. Handle Protocol Complete
    function renderProtocolCompleteSummary($container) {
        $container.empty();
    }

    // 5. Update Progress Bars & Counters
    function updateProgressIndicators() {
        if (currentStep > 9) {
            $('.step-progress-track-fill, .protocol-progress-fill').css('width', '100%');
            $('.protocol-analysis-pct').text('100%');
            $('.step-header-tag').text('PROTOCOL COMPLETE');
            $('.step-header-count').text('STEP 9 / 9');
            return;
        }

        const activeData = STEPS_DATA.find(s => s.stepNum === currentStep);
        const pctStr = activeData.progressPct + '%';

        $('.step-progress-track-fill, .protocol-progress-fill').css('width', pctStr);
        $('.protocol-analysis-pct').text(pctStr);
        $('.step-header-tag').text(activeData.stepTag);
        $('.step-header-count').text(activeData.stepCount);
    }

    // 6. jQuery Event Listeners (Delegated)
    $(document).on('click', '.option-card-step:not(.disabled)', function () {
        const stepNum = $(this).data('step');
        const val = $(this).data('val');
        const label = $(this).data('label');
        const icon = $(this).data('icon');

        $(this).addClass('selected').siblings().removeClass('selected');
        $(this).find('input[type="radio"]').prop('checked', true);

        // Update Selection State
        userSelections[stepNum] = { label, icon, val };

        // Update Sidebar Immediately
        renderSidebarTracker();
    });

    function smoothScrollToWizard() {
        const $panel = $('.protocol-center-panel');
        if ($panel.length) {
            const panelTop = $panel.offset().top - 100;
            const scrollPos = $(window).scrollTop();
            if (scrollPos > panelTop + 150 || scrollPos < panelTop - 250) {
                window.scrollTo({ top: panelTop, behavior: 'smooth' });
            }
        }
    }

    // Next Step Button Click
    $(document).on('click', '#btnNextStep', function () {
        currentStep++;
        renderWizard();
        smoothScrollToWizard();
    });

    // Previous Step Button Click
    $(document).on('click', '#btnPrevStep', function () {
        if (currentStep > 1) {
            currentStep--;
            renderWizard();
            smoothScrollToWizard();
        }
    });

    // Restart Protocol Button Click
    $(document).on('click', '#btnRestartProtocol', function () {
        currentStep = 1;
        renderWizard();
    });

    // Sidebar Step Item Click (Allow Jumping Back to Completed Steps)
    $(document).on('click', '.step-item.completed', function () {
        const stepNum = parseInt($(this).data('step'), 10);
        if (stepNum && stepNum < currentStep) {
            currentStep = stepNum;
            renderWizard();
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
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);

        const stackedWrapper = document.getElementById('whyChooseStackedWrapper') || document.getElementById('whyChooseWrapper');
        if (stackedWrapper && window.innerWidth >= 992) {
            const tl = gsap.timeline({
                scrollTrigger: {
                    trigger: stackedWrapper,
                    start: "top 90px",
                    end: "+=1200",
                    scrub: 1,
                    pin: true,
                    anticipatePin: 1
                }
            });

            tl.to("#whyChooseStackedWrapper .card-layer-2", { y: "0%", ease: "power1.out", duration: 1 })
                .to("#whyChooseStackedWrapper .card-layer-3", { y: "0%", ease: "power1.out", duration: 1 })
                .to("#whyChooseStackedWrapper .card-layer-4", { y: "0%", ease: "power1.out", duration: 1 });
        }
    }

    // Initialize Right Sidebar Featured Swiper Slider
    if (typeof Swiper !== 'undefined' && $('.featured-swiper').length) {
        new Swiper('.featured-swiper', {
            slidesPerView: 1,
            spaceBetween: 0,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.featured-swiper .swiper-pagination',
                clickable: true,
            },
        });
    }

    // Living Hero Product Flight Animation on Scroll
    const livingHeroSection = document.querySelector('#living-hero-section');
    const animatedProductImg = document.querySelector('#living-hero-animated-product');
    const productTargetBox = document.querySelector('#living-hero-product-target');
    const livingHeroImgBox = document.querySelector('#living-hero-img-box');

    if (livingHeroSection && animatedProductImg && productTargetBox && livingHeroImgBox) {
        if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
            gsap.registerPlugin(ScrollTrigger);

            function setupProductFlight() {
                const startCenter = livingHeroImgBox.getBoundingClientRect().top + (livingHeroImgBox.getBoundingClientRect().height / 2);
                const targetCenter = productTargetBox.getBoundingClientRect().top + (productTargetBox.getBoundingClientRect().height / 2);
                const yDistance = targetCenter - startCenter;

                gsap.to(animatedProductImg, {
                    y: yDistance,
                    ease: "none",
                    scrollTrigger: {
                        trigger: livingHeroSection,
                        start: "top 35%",
                        end: "bottom 85%",
                        scrub: 0.5,
                        invalidateOnRefresh: true
                    }
                });
            }

            setupProductFlight();
            window.addEventListener('resize', setupProductFlight);
        }
    }

    // Initial Render
    renderWizard();
});


document.addEventListener('DOMContentLoaded', () => {
    const testimonialsSwiper = new Swiper('.testimonials-slider', {
        slidesPerView: 1,
        spaceBetween: 24,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            // When window width is >= 768px
            768: {
                slidesPerView: 2,
                spaceBetween: 30,
            }
        }
    });
});