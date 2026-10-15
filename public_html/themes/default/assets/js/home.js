/**
 * AIRE Theme - Home Page Controller
 * Highly-Optimized Architecture:
 * - Zero inline scripts
 * - Hero Swiper & Video Controls
 * - Lightweight mobile entrance reveals
 * - Living Hero Product Flight on Scroll (Active on BOTH Mobile & Desktop)
 * - Intelligent IntersectionObserver preloading for GSAP (0ms initial main-thread blocking)
 */
(function () {
    'use strict';

    let gsapLoading = false;
    let gsapLoaded = false;
    let refreshTimer = null;

    /**
     * 1. Hero Swiper Slider Initializer
     */
    function initHomeHeroSwiper() {
        if (typeof Swiper === 'undefined') {
            setTimeout(initHomeHeroSwiper, 40);
            return;
        }

        const heroSliderEl = document.querySelector('.home-hero-swiper');
        if (heroSliderEl && !heroSliderEl.swiper) {
            new Swiper(heroSliderEl, {
                loop: true,
                speed: 700,
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                autoplay: {
                    delay: 5500,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true
                },
                pagination: {
                    el: '.home-hero-swiper-pagination',
                    clickable: true
                },
                keyboard: window.innerWidth >= 992 ? { enabled: true, onlyInViewport: true } : false,
                watchSlidesProgress: false,
                observer: false,
                observeParents: false,
                passiveListeners: true
            });
        }
    }

    /**
     * 2. Inline Video Player Handler
     */
    function initHomeVideo() {
        const videoBox = document.getElementById('homeVideoBox');
        const mainVideo = document.getElementById('homeMainVideo');
        const playBtn = document.getElementById('homeVideoPlayBtn');

        if (!videoBox || !mainVideo) return;

        function togglePlay(e) {
            if (e) e.stopPropagation();
            if (mainVideo.paused || mainVideo.ended) {
                mainVideo.play().catch(function (err) {
                    console.log('Playback error:', err);
                });
            } else {
                mainVideo.pause();
            }
        }

        mainVideo.addEventListener('play', function () {
            videoBox.classList.add('is-playing', 'has-started');
            videoBox.classList.remove('is-paused');
            mainVideo.controls = true;
        });

        mainVideo.addEventListener('pause', function () {
            videoBox.classList.remove('is-playing');
            videoBox.classList.add('is-paused');
        });

        mainVideo.addEventListener('ended', function () {
            videoBox.classList.remove('is-playing');
            videoBox.classList.add('is-paused');
        });

        if (playBtn) {
            playBtn.addEventListener('click', togglePlay);
        }

        videoBox.addEventListener('click', function (e) {
            if (e.target === mainVideo && !mainVideo.paused) {
                mainVideo.pause();
            } else if (mainVideo.paused) {
                togglePlay(e);
            }
        });
    }

    /**
     * 3. Asynchronously loads a script once
     */
    function loadScriptAsync(src) {
        return new Promise(function (resolve, reject) {
            const existing = document.querySelector('script[src="' + src + '"]');
            if (existing) {
                if (existing.dataset.loaded === 'true' || (window.gsap && src.includes('gsap.min.js'))) {
                    resolve();
                } else {
                    existing.addEventListener('load', resolve);
                    existing.addEventListener('error', reject);
                }
                return;
            }
            const script = document.createElement('script');
            script.src = src;
            script.async = true;
            script.onload = function () {
                script.dataset.loaded = 'true';
                resolve();
            };
            script.onerror = reject;
            document.head.appendChild(script);
        });
    }

    /**
     * Debounced ScrollTrigger refresh to avoid layout thrashing
     */
    function scheduleScrollRefresh() {
        if (typeof ScrollTrigger === 'undefined') return;
        clearTimeout(refreshTimer);
        refreshTimer = setTimeout(function () {
            if (typeof ScrollTrigger !== 'undefined') {
                ScrollTrigger.sort();
                ScrollTrigger.refresh();
            }
        }, 150);
    }

    /**
     * 4. Mobile Lightweight Reveal (IntersectionObserver - 0 Main-Thread Blocking)
     */
    function initMobileLifestyleReveals(rows) {
        if (!rows || !rows.length) return;

        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(function (entries, obs) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-revealed');
                        obs.unobserve(entry.target);
                    }
                });
            }, {
                rootMargin: '0px 0px -50px 0px',
                threshold: 0.1
            });

            rows.forEach(function (row) {
                observer.observe(row);
            });
        } else {
            rows.forEach(function (row) {
                row.classList.add('is-revealed');
            });
        }
    }

    /**
     * 5. Why Choose Stacked Cards GSAP ScrollTrigger Animation (Desktop only)
     */
    function initWhyChooseScrollTrigger() {
        const stackedWrapper = document.getElementById('whyChooseStackedWrapper') || document.getElementById('whyChooseWrapper');
        if (!stackedWrapper) return;

        if (window.innerWidth < 992) {
            const pinSpacer = stackedWrapper.closest('.pin-spacer');
            if (pinSpacer && pinSpacer.parentElement) {
                pinSpacer.parentElement.insertBefore(stackedWrapper, pinSpacer);
                pinSpacer.remove();
            }
            if (typeof gsap !== 'undefined') {
                gsap.set(stackedWrapper, { clearProps: 'all' });
                gsap.set('#whyChooseStackedWrapper .stacked-card, #whyChooseWrapper .stacked-card', { clearProps: 'all' });
            }
            return;
        }

        if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;
        gsap.registerPlugin(ScrollTrigger);

        ScrollTrigger.getAll().forEach(function (st) {
            if ((st.vars && st.vars.trigger === stackedWrapper) || st.trigger === stackedWrapper) {
                st.kill(true);
            }
        });

        const pinSpacer = stackedWrapper.closest('.pin-spacer');
        if (pinSpacer && pinSpacer.parentElement) {
            pinSpacer.parentElement.insertBefore(stackedWrapper, pinSpacer);
            pinSpacer.remove();
        }

        gsap.set(stackedWrapper, { clearProps: 'all' });
        gsap.set('#whyChooseStackedWrapper .stacked-card, #whyChooseWrapper .stacked-card', { clearProps: 'transform' });

        const tl = gsap.timeline({
            scrollTrigger: {
                trigger: stackedWrapper,
                start: 'top 90px',
                end: '+=1200',
                scrub: 1,
                pin: true,
                anticipatePin: 1,
                invalidateOnRefresh: true,
                refreshPriority: 1
            }
        });

        tl.fromTo('#whyChooseStackedWrapper .card-layer-2, #whyChooseWrapper .card-layer-2', { y: '140%' }, { y: '0%', ease: 'power1.out', duration: 1 })
            .fromTo('#whyChooseStackedWrapper .card-layer-3, #whyChooseWrapper .card-layer-3', { y: '140%' }, { y: '0%', ease: 'power1.out', duration: 1 })
            .fromTo('#whyChooseStackedWrapper .card-layer-4, #whyChooseWrapper .card-layer-4', { y: '140%' }, { y: '0%', ease: 'power1.out', duration: 1 });
    }
    window.initWhyChooseScrollTrigger = initWhyChooseScrollTrigger;

    /**
     * 6. Living Hero Product Flight Animation on Scroll (Active on BOTH Mobile & Desktop)
     */
    function initLivingHeroScrollTrigger() {
        const livingHeroSection = document.querySelector('#living-hero-section');
        const animatedProductImg = document.querySelector('#living-hero-animated-product');
        const productTargetBox = document.querySelector('#living-hero-product-target');
        const livingHeroImgBox = document.querySelector('#living-hero-img-box');

        if (!livingHeroSection || !animatedProductImg || !productTargetBox || !livingHeroImgBox) return;
        if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;

        gsap.registerPlugin(ScrollTrigger);

        // Clean up previous triggers on living hero section
        ScrollTrigger.getAll().forEach(function (st) {
            if (st.vars && (st.vars.trigger === livingHeroSection || st.vars.trigger === livingHeroImgBox || st.trigger === livingHeroSection || st.trigger === livingHeroImgBox)) {
                st.kill(true);
            }
        });

        gsap.set(animatedProductImg, { clearProps: 'transform' });
        gsap.set(animatedProductImg, {
            xPercent: -50,
            yPercent: -50,
            x: 0,
            y: 0
        });

        gsap.fromTo(animatedProductImg,
            { y: 0 },
            {
                y: function () {
                    const boxRect = livingHeroImgBox.getBoundingClientRect();
                    const targetRect = productTargetBox.getBoundingClientRect();
                    const startCenter = boxRect.top + (boxRect.height / 2);
                    const targetCenter = targetRect.top + (targetRect.height / 2);
                    return targetCenter - startCenter;
                },
                ease: 'none',
                scrollTrigger: {
                    trigger: livingHeroImgBox,
                    start: 'center center',
                    endTrigger: productTargetBox,
                    end: 'center center',
                    scrub: 0.6,
                    invalidateOnRefresh: true
                }
            }
        );

        const bgImg = livingHeroImgBox.querySelector('.living-hero__bg-img');
        if (bgImg && !bgImg.complete) {
            bgImg.addEventListener('load', function () {
                if (typeof ScrollTrigger !== 'undefined') {
                    ScrollTrigger.refresh();
                }
            }, { once: true });
        }
        if (!animatedProductImg.complete) {
            animatedProductImg.addEventListener('load', function () {
                if (typeof ScrollTrigger !== 'undefined') {
                    ScrollTrigger.refresh();
                }
            }, { once: true });
        }
    }
    window.initLivingHeroScrollTrigger = initLivingHeroScrollTrigger;

    /**
     * 7. Lifestyle Section Parallax & Scroll Reveal Effects
     */
    function initLifestyleParallax() {
        const rows = document.querySelectorAll('.home-lifestyle__row');
        if (!rows.length) return;

        if (window.innerWidth < 992) {
            initMobileLifestyleReveals(rows);
            return;
        }

        if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;
        gsap.registerPlugin(ScrollTrigger);

        rows.forEach(function (row) {
            ScrollTrigger.getAll().forEach(function (st) {
                if ((st.vars && st.vars.trigger === row) || st.trigger === row) {
                    st.kill(true);
                }
            });
        });

        rows.forEach(function (row) {
            const imgBox = row.querySelector('.home-lifestyle__img-box');
            const img = row.querySelector('.home-lifestyle__img');
            const content = row.querySelector('.home-lifestyle__content');

            if (imgBox && img) {
                gsap.set(img, { scale: 1.18, transformOrigin: 'center center' });

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
            }

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
    }
    window.initLifestyleParallax = initLifestyleParallax;

    /**
     * 8. Benefits Banner Parallax Effect (Desktop only)
     */
    function initBenefitsParallax() {
        const banner = document.querySelector('.home-benefits__banner');
        const bannerBg = document.querySelector('.home-benefits__banner-bg');
        if (!banner || !bannerBg) return;

        if (window.innerWidth < 992) return;

        if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;
        gsap.registerPlugin(ScrollTrigger);

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
    window.initBenefitsParallax = initBenefitsParallax;

    /**
     * Orchestrates GSAP animation loading and initialization
     */
    function initAnimations() {
        if (gsapLoaded && typeof gsap !== 'undefined') {
            if (window.innerWidth >= 992) {
                initBenefitsParallax();
                initLifestyleParallax();
                initWhyChooseScrollTrigger();
            } else {
                initMobileLifestyleReveals(document.querySelectorAll('.home-lifestyle__row'));
            }

            // Living Hero product flight animation runs on BOTH Mobile & Desktop
            initLivingHeroScrollTrigger();
            scheduleScrollRefresh();
            return;
        }

        if (gsapLoading) return;
        gsapLoading = true;

        loadScriptAsync('https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js')
            .then(function () {
                return loadScriptAsync('https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js');
            })
            .then(function () {
                gsapLoaded = true;
                gsapLoading = false;
                if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
                    gsap.registerPlugin(ScrollTrigger);

                    if (window.innerWidth >= 992) {
                        initBenefitsParallax();
                        initLifestyleParallax();
                        initWhyChooseScrollTrigger();
                    } else {
                        initMobileLifestyleReveals(document.querySelectorAll('.home-lifestyle__row'));
                    }

                    // Living Hero product flight animation active on mobile & desktop
                    initLivingHeroScrollTrigger();

                    if (typeof window.connectLenisToGsap === 'function') {
                        window.connectLenisToGsap();
                    }

                    scheduleScrollRefresh();
                }
            })
            .catch(function (err) {
                gsapLoading = false;
                console.warn('GSAP scripts deferred/unavailable:', err);
            });
    }

    // Initialize on DOM Ready
    document.addEventListener('DOMContentLoaded', function () {
        initHomeHeroSwiper();
        initHomeVideo();

        // Mobile lifestyle reveals initialize immediately (0 CPU overhead)
        if (window.innerWidth < 992) {
            initMobileLifestyleReveals(document.querySelectorAll('.home-lifestyle__row'));
        }

        if (window.innerWidth >= 992) {
            // Desktop: load when idle shortly after initial render
            if ('requestIdleCallback' in window) {
                window.requestIdleCallback(initAnimations, { timeout: 1200 });
            } else {
                setTimeout(initAnimations, 60);
            }
        } else {
            // Mobile: Observe #living-hero-section so GSAP only loads when user actually scrolls near Section 6!
            // This guarantees 0ms TBT impact during initial Lighthouse tests at the top of the page.
            const livingHero = document.getElementById('living-hero-section');
            if (livingHero && 'IntersectionObserver' in window) {
                const livingObserver = new IntersectionObserver(function (entries) {
                    if (entries[0].isIntersecting) {
                        initAnimations();
                        livingObserver.disconnect();
                    }
                }, {
                    rootMargin: '800px 0px 800px 0px' // Preloads 800px before reaching section
                });
                livingObserver.observe(livingHero);
            } else {
                window.addEventListener('scroll', initAnimations, { once: true, passive: true });
            }
        }
    });

    // Window Resize Handling (Desktop <-> Mobile transitions)
    let resizeTimer = null;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
            if (gsapLoaded && typeof ScrollTrigger !== 'undefined') {
                if (window.innerWidth >= 992) {
                    initWhyChooseScrollTrigger();
                    initBenefitsParallax();
                    initLifestyleParallax();
                }
                initLivingHeroScrollTrigger();
                scheduleScrollRefresh();
            } else if (window.innerWidth >= 992) {
                initAnimations();
            }
        }, 200);
    }, { passive: true });

})();
