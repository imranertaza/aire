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
            const isSelected = userSelections[currentStep] ? (userSelections[currentStep].val === opt.val) : false;
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

    // 4. Handle Protocol Complete (Directly fetch and display matched products)
    function renderProtocolCompleteSummary($container) {
        $container.empty();

        // Trigger filter API query only once all steps are completed
        triggerLiveProductCountQuery(1, true);
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

        // Update Sidebar Immediately (No API call on each step click)
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


    // Render Other Matched Products Dynamically inside #other-matched-products
    const infiniteScroll = {
        currentPage: (window.INITIAL_PAGINATION && window.INITIAL_PAGINATION.currentPage) || 1,
        lastPage: (window.INITIAL_PAGINATION && window.INITIAL_PAGINATION.lastPage) || 1,
        isLoading: false,
        hasMore: (window.INITIAL_PAGINATION && window.INITIAL_PAGINATION.hasMore) || false
    };

    function generateProductCardHtml(p) {
        return `
            <div class="col-md-6 mb-3 product-card-col">
                <div class="product-card position-relative shadow-sm h-100 d-flex flex-column justify-content-between">
                    <div class="product-card__labels position-absolute d-flex flex-column gap-2">
                        <a href="javascript:void(0);" class="btn-add-to-cart"
                            data-product-id="${p.id}" title="Add to cart">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M17 18C17.5304 18 18.0391 18.2107 18.4142 18.5858C18.7893 18.9609 19 19.4696 19 20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22C16.4696 22 15.9609 21.7893 15.5858 21.4142C15.2107 21.0391 15 20.5304 15 20C15 18.89 15.89 18 17 18ZM1 2H4.27L5.21 4H20C20.2652 4 20.5196 4.10536 20.7071 4.29289C20.8946 4.48043 21 4.73478 21 5C21 5.17 20.95 5.34 20.88 5.5L17.3 11.97C16.96 12.58 16.3 13 15.55 13H8.1L7.2 14.63L7.17 14.75C7.17 14.8163 7.19634 14.8799 7.24322 14.9268C7.29011 14.9737 7.3537 15 7.42 15H19V17H7C6.46957 17 5.96086 16.7893 5.58579 16.4142C5.21071 16.0391 5 15.5304 5 15C5 14.65 5.09 14.32 5.24 14.04L6.6 11.59L3 4H1V2ZM7 18C7.53043 18 8.03914 18.2107 8.41421 18.5858C8.78929 18.9609 9 19.4696 9 20C9 20.5304 8.78929 21.0391 8.41421 21.4142C8.03914 21.7893 7.53043 22 7 22C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20C5 18.89 5.89 18 7 18ZM16 11L18.78 6H6.14L8.5 11H16Z"
                                    fill="#0066CC" />
                            </svg>
                        </a>
                        <a href="javascript:void(0);" class="btn-add-to-favorite"
                            data-product-id="${p.id}" title="Add to wishlist">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 21.35L10.55 20.03C5.4 15.36 2 12.28 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.91 3.81 12 5.09C13.09 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.28 18.6 15.36 13.45 20.04L12 21.35Z"
                                    fill="#0066CC" />
                            </svg>
                        </a>
                    </div>
                    <div class="product-card__image-wrapper">
                        <a href="${p.url}">
                            <img src="${p.main_image}" alt="${p.name}" class="product-card__image">
                        </a>
                    </div>
                    <h3 class="product-card__title">
                        <a href="${p.url}" class="text-decoration-none text-dark">
                            ${p.name}
                        </a>
                    </h3>
                    <div class="product-card__category">
                        ${p.category}
                    </div>
                    <div class="product-card__actions">
                        <a href="javascript:void(0);" class="product-card__btn-buy btn-buy-now"
                            data-product-id="${p.id}">Buy</a>
                        <a href="${p.url}" class="product-card__btn-learn">Learn more</a>
                        <a href="javascript:void(0);" class="product-card__btn-compare btn-add-to-compare"
                            data-product-id="${p.id}" title="Add to Compare"
                            style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:6px;border:1px solid #cbd5e1;background:#fff;color:#475569;transition:all .2s;"
                            onmouseover="this.style.background='#0066cc';this.style.color='#fff';this.style.borderColor='#0066cc'"
                            onmouseout="this.style.background='#fff';this.style.color='#475569';this.style.borderColor='#cbd5e1'">
                            <i class="bi bi-bar-chart-steps" style="font-size:0.85rem;"></i>
                        </a>
                    </div>
                </div>
            </div>
        `;
    }

    // Render Matched Products List
    function renderRelatedProducts(products, meta, isAppend = false) {
        const $section = $('#other-matched-products, #Related-products');
        if (!$section.length) return;

        // Update infinite scroll pagination meta
        if (meta) {
            infiniteScroll.currentPage = meta.current_page || 1;
            infiniteScroll.lastPage = meta.last_page || 1;
            infiniteScroll.hasMore = infiniteScroll.currentPage < infiniteScroll.lastPage;
        }

        if (!isAppend) {
            if (!products || products.length === 0) {
                $section.html(`
                    <div class="p-4 bg-light rounded-4 border text-center my-4">
                        <i class="bi bi-search fs-3 text-muted mb-2 d-block"></i>
                        <h4 class="fs-16 fw-bold text-dark mb-1">No Other Matches</h4>
                        <p class="fs-13 text-muted mb-0">Adjust your protocol options or explore our complete catalog.</p>
                    </div>
                `);
                return;
            }

            let cardsHtml = '';
            products.forEach(p => {
                cardsHtml += generateProductCardHtml(p);
            });

            let productsHtml = `
                <div class="other-matched-products-wrapper my-5 pt-3 border-top">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h3 class="title-2 fs-20 fw-bold text-dark mb-0">Recommended Configurations</h3>
                        </div>
                    </div>

                    <div class="row g-4" id="matchedProductsGrid">
                        ${cardsHtml}
                    </div>

                    <div id="infiniteScrollLoader" class="text-center py-4 w-100 ${infiniteScroll.hasMore ? '' : 'd-none'}">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span class="ms-2 fs-13 text-muted fw-semibold">Loading more configurations...</span>
                    </div>
                </div>
            `;

            $section.html(productsHtml);
        } else {
            // Append mode
            let newCardsHtml = '';
            products.forEach(p => {
                newCardsHtml += generateProductCardHtml(p);
            });
            $('#matchedProductsGrid').append(newCardsHtml);

            if (infiniteScroll.hasMore) {
                $('#infiniteScrollLoader').removeClass('d-none');
            } else {
                $('#infiniteScrollLoader').addClass('d-none');
            }
        }
    }

    // Infinite Scroll On-Scroll Event Listener
    let scrollThrottle = null;
    $(window).on('scroll resize', function () {
        if (scrollThrottle) return;
        scrollThrottle = setTimeout(function () {
            scrollThrottle = null;

            if (!infiniteScroll.hasMore || infiniteScroll.isLoading) return;

            const $loader = $('#infiniteScrollLoader');
            if (!$loader.length || $loader.hasClass('d-none')) return;

            const loaderOffset = $loader.offset().top;
            const scrollBottom = $(window).scrollTop() + $(window).height();

            if (scrollBottom >= loaderOffset - 400) {
                loadNextInfinitePage();
            }
        }, 100);
    });

    function loadNextInfinitePage() {
        if (!infiniteScroll.hasMore || infiniteScroll.isLoading) return;
        if (!window.FILTER_QUERY_URL) return;

        infiniteScroll.isLoading = true;
        $('#infiniteScrollLoader').removeClass('d-none');

        const nextPage = infiniteScroll.currentPage + 1;
        const selectedSlugs = [];
        Object.keys(userSelections).forEach(function (stepKey) {
            if (userSelections[stepKey] && userSelections[stepKey].val) {
                selectedSlugs.push(userSelections[stepKey].val);
            }
        });

        $.ajax({
            url: window.FILTER_QUERY_URL,
            type: 'POST',
            data: {
                _token: window.CSRF_TOKEN || '',
                category_slugs: selectedSlugs,
                page: nextPage
            },
            success: function (res) {
                infiniteScroll.isLoading = false;
                if (res && res.status && res.products && res.products.length > 0) {
                    renderRelatedProducts(res.products, {
                        current_page: res.current_page,
                        last_page: res.last_page,
                        total: res.total,
                        per_page: res.per_page
                    }, true);
                } else {
                    infiniteScroll.hasMore = false;
                    $('#infiniteScrollLoader').addClass('d-none');
                }
            },
            error: function () {
                infiniteScroll.isLoading = false;
                $('#infiniteScrollLoader').addClass('d-none');
            }
        });
    }

    // Live AJAX Product Matching Query
    let queryTimeout = null;
    function triggerLiveProductCountQuery(page = 1, shouldScroll = false) {
        if (!window.FILTER_QUERY_URL) return;

        clearTimeout(queryTimeout);
        queryTimeout = setTimeout(function () {
            const selectedSlugs = [];
            Object.keys(userSelections).forEach(function (stepKey) {
                if (userSelections[stepKey] && userSelections[stepKey].val) {
                    selectedSlugs.push(userSelections[stepKey].val);
                }
            });

            $.ajax({
                url: window.FILTER_QUERY_URL,
                type: 'POST',
                data: {
                    _token: window.CSRF_TOKEN || '',
                    category_slugs: selectedSlugs,
                    page: page
                },
                success: function (res) {
                    if (res && res.status) {
                        $('#liveMatchCountTag').text(res.count + ' Products Match');

                        // Reset & Render matched products with infinite scroll pagination meta
                        renderRelatedProducts(res.products || [], {
                            current_page: res.current_page || 1,
                            last_page: res.last_page || 1,
                            total: res.total || res.count || 0,
                            per_page: res.per_page || 2
                        }, false);

                        if (shouldScroll && $('#other-matched-products').length) {
                            $('html, body').animate({
                                scrollTop: $('#other-matched-products').offset().top - 80
                            }, 500);
                        }
                    }
                }
            });
        }, 150);
    }

    $(document).on('click', '#btnViewProductsFinal, #btnViewProductsResult', function (e) {
        e.preventDefault();
        const selectedSlugs = [];
        Object.keys(userSelections).forEach(function (stepKey) {
            if (userSelections[stepKey] && userSelections[stepKey].val) {
                selectedSlugs.push(userSelections[stepKey].val);
            }
        });

        let targetUrl = window.CATALOG_URL || '/categories';
        if (selectedSlugs.length > 0) {
            targetUrl = '/category/' + encodeURIComponent(selectedSlugs[0]);
        }
        window.location.href = targetUrl;
    });

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