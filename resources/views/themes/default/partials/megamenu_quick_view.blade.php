@pushOnce('styles')
    <link rel="stylesheet"
        href="{{ theme_asset('css/megamenu.css') }}?v={{ @filemtime(public_path('themes/default/assets/css/megamenu.css')) ?: time() }}">
@endpushOnce

<!-- Quick View Modal Blurred Backdrop -->
<div id="quickviewBackdrop" class="quickview-backdrop" aria-hidden="true"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const overlays = document.querySelectorAll('.megamenu-quickview-overlay');
        if (!overlays.length) return;

        // Ensure backdrop is a direct child of <body> to avoid stacking context traps
        const backdrop = document.getElementById('quickviewBackdrop');
        if (backdrop && backdrop.parentElement !== document.body) {
            document.body.appendChild(backdrop);
        }

        // Move modal showcase overlays to document.body so they are not trapped inside containers or affected by ancestor styling
        document.querySelectorAll('.category-showcase-quickview-overlay').forEach(ov => {
            if (ov.parentElement !== document.body) {
                document.body.appendChild(ov);
            }
        });

        let activeOverlay = null;
        let hideTimer = null;
        let isManuallyClosed = false;
        let isPinnedByClick = false;

        function openOverlay(overlay, trigger) {
            if (isManuallyClosed && activeOverlay === overlay) return;
            clearTimeout(hideTimer);

            // If another overlay is open, close it instantly
            if (activeOverlay && activeOverlay !== overlay) {
                closeOverlay(activeOverlay, true);
            }

            activeOverlay = overlay;
            isManuallyClosed = false;
            overlay.classList.add('is-active');
            overlay.setAttribute('aria-hidden', 'false');
            overlay.closest('.category-section-header')?.classList.add('quickview-open');
            if (overlay.closest('.site-header')) {
                document.body.classList.add('quickview-header-open');
            }
            if (trigger) {
                trigger.setAttribute('aria-expanded', 'true');
            }
            if (backdrop) {
                backdrop.classList.add('is-active');
            }
            document.body.classList.add('quickview-modal-open');
        }

        function scheduleClose(delay = 180) {
            if (isPinnedByClick) return;
            clearTimeout(hideTimer);
            hideTimer = setTimeout(function() {
                if (activeOverlay) {
                    closeOverlay(activeOverlay);
                }
            }, delay);
        }

        function closeOverlay(overlay, instant = false) {
            if (!overlay) return;
            clearTimeout(hideTimer);
            isPinnedByClick = false;
            overlay.classList.remove('is-active');
            overlay.setAttribute('aria-hidden', 'true');
            overlay.closest('.category-section-header')?.classList.remove('quickview-open');
            document.body.classList.remove('quickview-header-open');
            const targetId = overlay.id;
            const triggers = document.querySelectorAll('[data-megamenu-target="' + targetId + '"]');
            triggers.forEach(t => t.setAttribute('aria-expanded', 'false'));
            if (activeOverlay === overlay) {
                activeOverlay = null;
            }
            if (backdrop) {
                backdrop.classList.remove('is-active');
            }
            document.body.classList.remove('quickview-modal-open');
        }

        // Backdrop click closes the active modal
        if (backdrop) {
            backdrop.addEventListener('click', function(e) {
                if (activeOverlay) {
                    isManuallyClosed = true;
                    isPinnedByClick = false;
                    closeOverlay(activeOverlay, true);
                }
            });
        }

        // Attach listeners to all triggers
        const allTriggers = document.querySelectorAll('[data-megamenu-target]');
        allTriggers.forEach(trigger => {
            const targetId = trigger.getAttribute('data-megamenu-target');
            const targetOverlay = document.getElementById(targetId) ||
                document.querySelector('[data-megamenu-alias="' + targetId + '"]') ||
                document.querySelector('[data-megamenu-id="' + targetId + '"]');
            if (!targetOverlay) return;

            const isClickOnly = trigger.classList.contains('category-quickview-trigger') ||
                                trigger.classList.contains('sidebar-quickview-btn') ||
                                trigger.getAttribute('data-megamenu-click') === 'true' ||
                                (targetId && targetId.startsWith('quickViewSectionCat-'));

            // Only attach hover events if this trigger is NOT click-only
            if (!isClickOnly) {
                trigger.addEventListener('mouseenter', function() {
                    isManuallyClosed = false;
                    openOverlay(targetOverlay, trigger);
                });
                trigger.addEventListener('mouseleave', function() {
                    scheduleClose(220);
                });
                trigger.addEventListener('focus', function() {
                    isManuallyClosed = false;
                    openOverlay(targetOverlay, trigger);
                });
                trigger.addEventListener('blur', function() {
                    scheduleClose(220);
                });
            }

            trigger.addEventListener('click', function(e) {
                const isAnchor = trigger.tagName.toLowerCase() === 'a';
                const href = trigger.getAttribute('href');
                if (!isAnchor || !href || href === '#' || href.startsWith('javascript:')) {
                    e.preventDefault();
                }
                if (activeOverlay === targetOverlay) {
                    isManuallyClosed = true;
                    isPinnedByClick = false;
                    closeOverlay(targetOverlay, true);
                } else {
                    isManuallyClosed = false;
                    isPinnedByClick = true;
                    openOverlay(targetOverlay, trigger);
                    if (trigger.classList.contains('sidebar-quickview-btn') || trigger.closest('.sidebar-quickview-wrapper')) {
                        setTimeout(() => {
                            targetOverlay.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        }, 50);
                    }
                }
            });
        });

        // Hover & click handling for each overlay
        overlays.forEach(overlay => {
            // Clicking directly on the backdrop area outside the card closes the modal
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) {
                    isManuallyClosed = true;
                    isPinnedByClick = false;
                    closeOverlay(overlay, true);
                }
            });

            overlay.addEventListener('mouseenter', function() {
                clearTimeout(hideTimer);
                activeOverlay = overlay;
            });
            overlay.addEventListener('mouseleave', function() {
                isManuallyClosed = false;
                scheduleClose(180);
            });

            // Close button inside overlay
            const closeBtn = overlay.querySelector('.quickview-close-btn');
            if (closeBtn) {
                closeBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    isManuallyClosed = true;
                    closeOverlay(overlay, true);
                });
            }

            // Carousel scroll buttons
            const carouselWrapper = overlay.querySelector('.quickview-carousel-wrapper');
            if (carouselWrapper) {
                const track = carouselWrapper.querySelector('.quickview-groups-track');
                const prevBtn = carouselWrapper.querySelector('.quickview-scroll-btn.prev');
                const nextBtn = carouselWrapper.querySelector('.quickview-scroll-btn.next');

                if (track && prevBtn) {
                    prevBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        track.scrollBy({
                            left: -380,
                            behavior: 'smooth'
                        });
                    });
                }
                if (track && nextBtn) {
                    nextBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        track.scrollBy({
                            left: 380,
                            behavior: 'smooth'
                        });
                    });
                }
            }
        });

        // Escape key closes open overlay
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && activeOverlay) {
                isManuallyClosed = true;
                closeOverlay(activeOverlay, true);
            }
        });

        // Outside click closes open overlay
        document.addEventListener('click', function(e) {
            if (activeOverlay && !activeOverlay.contains(e.target)) {
                let isTriggerClick = false;
                allTriggers.forEach(t => {
                    if (t.contains(e.target)) isTriggerClick = true;
                });
                if (!isTriggerClick) {
                    closeOverlay(activeOverlay, true);
                }
            }
        });
    });
</script>