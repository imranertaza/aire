/**
 * AIRE Theme - Home Page Scripts
 */
document.addEventListener('DOMContentLoaded', function () {
    initBenefitsParallax();
    initLifestyleParallax();
});

/**
 * Lifestyle Section Parallax & Scroll Reveal Effects
 */
function initLifestyleParallax() {
    const rows = document.querySelectorAll('.home-lifestyle__row');
    if (!rows.length) return;

    function setupGsapParallax() {
        if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
            return false;
        }

        gsap.registerPlugin(ScrollTrigger);

        // Clean up previous triggers on rows to prevent duplicates on back navigation
        rows.forEach(function (row) {
            ScrollTrigger.getAll().forEach(function (st) {
                if ((st.vars && st.vars.trigger === row) || st.trigger === row) {
                    st.kill(true);
                }
            });
        });

        rows.forEach(function (row, idx) {
            const imgBox = row.querySelector('.home-lifestyle__img-box');
            const img = row.querySelector('.home-lifestyle__img');
            const content = row.querySelector('.home-lifestyle__content');

            if (imgBox && img) {
                // Initial scale so vertical movement never exposes empty edges
                gsap.set(img, { scale: 1.18, transformOrigin: 'center center' });

                // Smooth vertical scroll parallax scrub
                gsap.fromTo(img,
                    { yPercent: -6 },
                    {
                        yPercent: 6,
                        ease: 'none',
                        scrollTrigger: {
                            trigger: row,
                            start: 'top bottom',
                            end: 'bottom top',
                            scrub: 1.2
                        }
                    }
                );

                // Row Entry Reveal
                gsap.from(imgBox, {
                    scale: 0.96,
                    opacity: 0.9,
                    duration: 0.8,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: row,
                        start: 'top 85%',
                        toggleActions: 'play none none none'
                    }
                });

                // Desktop 3D Mouse Parallax & Tilt (only on fine pointer devices)
                if (window.matchMedia('(pointer: fine)').matches) {
                    let isHovered = false;

                    imgBox.addEventListener('mouseenter', function () {
                        isHovered = true;
                    });


                }
            }

            // Smooth Content Reveal
            if (content) {
                gsap.from(content, {
                    y: 30,
                    opacity: 0,
                    duration: 0.8,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: row,
                        start: 'top 82%',
                        toggleActions: 'play none none none'
                    }
                });
            }
        });

        // Ensure triggers are evaluated in correct DOM order
        ScrollTrigger.sort();

        // Refresh all ScrollTriggers after images load
        function triggerFullRefresh() {
            if (typeof ScrollTrigger !== 'undefined') {
                ScrollTrigger.sort();
                ScrollTrigger.refresh(true);
            }
            if (typeof window.initWhyChooseScrollTrigger === 'function') {
                window.initWhyChooseScrollTrigger();
            }
        }

        if (document.readyState === 'complete') {
            setTimeout(triggerFullRefresh, 150);
        } else {
            window.addEventListener('load', function () {
                setTimeout(triggerFullRefresh, 150);
            });
        }

        // Attach load listeners on lifestyle & card images to trigger refresh immediately upon download
        const allImages = document.querySelectorAll('.home-benefits__bg-img, .home-lifestyle__img, .home-product-card__img, .home-hero-swiper img');
        let refreshTimeout;
        allImages.forEach(function (image) {
            if (!image.complete) {
                image.addEventListener('load', function () {
                    clearTimeout(refreshTimeout);
                    refreshTimeout = setTimeout(triggerFullRefresh, 80);
                });
            }
        });

        return true;
    }

    let attempts = 0;
    const maxAttempts = 30;
    function checkAndInit() {
        if (setupGsapParallax()) {
            return;
        }
        attempts++;
        if (attempts < maxAttempts) {
            setTimeout(checkAndInit, 50);
        }
    }

    checkAndInit();
}
window.initLifestyleParallax = initLifestyleParallax;

/**
 * Benefits Banner Parallax Effect
 */
function initBenefitsParallax() {
    const banner = document.querySelector('.home-benefits__banner');
    const bannerBg = document.querySelector('.home-benefits__banner-bg');
    if (!banner || !bannerBg) return;

    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);

        // Clean up previous trigger on banner if any
        ScrollTrigger.getAll().forEach(function (st) {
            if ((st.vars && st.vars.trigger === banner) || st.trigger === banner) {
                st.kill(true);
            }
        });

        gsap.fromTo(bannerBg,
            { yPercent: -12 },
            {
                yPercent: 12,
                ease: 'none',
                scrollTrigger: {
                    trigger: banner,
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: 1.2
                }
            }
        );
    }
}
window.initBenefitsParallax = initBenefitsParallax;
