/* Product Detail GSAP ScrollTrigger Animations */
document.addEventListener('DOMContentLoaded', () => {
    // Check GSAP availability
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;

    gsap.registerPlugin(ScrollTrigger);

    // 1. Section 1 (Hero) -> Section 2 (Science) Smooth Single-Image Scrubbed Transition
    const heroImgBox = document.querySelector('.hero-img-box');
    const scienceImgBox = document.querySelector('.science-card-img-box');
    const heroSection = document.querySelector('.product-hero-section');
    const scienceSection = document.querySelector('.science-section');

    if (heroImgBox && scienceImgBox && heroSection && scienceSection) {
        const scienceImg = scienceImgBox.querySelector('img');
        if (scienceImg) {
            // Hide static duplicate image inside Science card to eliminate double image ghosting
            gsap.set(scienceImg, { opacity: 0 });

            gsap.to(heroImgBox, {
                y: () => {
                    const heroRect = heroImgBox.getBoundingClientRect();
                    const sciRect = scienceImgBox.getBoundingClientRect();
                    return (sciRect.top + sciRect.height / 2) - (heroRect.top + heroRect.height / 2);
                },
                ease: "none",
                scrollTrigger: {
                    trigger: heroSection,
                    start: "top top+=60",
                    endTrigger: scienceSection,
                    end: "center center",
                    scrub: 0.5,
                    invalidateOnRefresh: true
                }
            });
        }
    }

    // 3. Lifestyle Background Parallax Effect
    const bgLifestyleImg = document.querySelector('.bg-lifestyle-img');
    const lifestyleSection = document.getElementById('lifestyle-section');
    if (bgLifestyleImg && lifestyleSection) {
        gsap.fromTo(bgLifestyleImg,
            { yPercent: -15 },
            {
                yPercent: 15,
                ease: "none",
                scrollTrigger: {
                    trigger: lifestyleSection,
                    start: "top bottom",
                    end: "bottom top",
                    scrub: true
                }
            }
        );
    }

    // 4. Medical-Grade Precision Filter Tech Parallax Effect
    const filterTechBox = document.querySelector('.filter-tech-img-box');
    const filterTechImg = document.querySelector('.filter-tech-img-box img');

    if (filterTechBox && filterTechImg) {
        gsap.fromTo(filterTechImg,
            { yPercent: -15 },
            {
                yPercent: 15,
                ease: "none",
                scrollTrigger: {
                    trigger: filterTechBox,
                    start: "top bottom",
                    end: "bottom top",
                    scrub: true
                }
            }
        );
    }

    // 4. Dynamic Specs Image Swap on Scroll
    const specBlocks = document.querySelectorAll('.spec-group-block');
    const specsImage = document.getElementById('specs-dynamic-image');

    if (specBlocks.length > 0 && specsImage) {
        let currentSrc = specsImage.getAttribute('src');

        function updateSpecsImage(newSrc) {
            if (newSrc && currentSrc !== newSrc) {
                currentSrc = newSrc;
                gsap.to(specsImage, {
                    opacity: 0,
                    duration: 0.3,
                    onComplete: () => {
                        specsImage.src = newSrc;
                        const fadeIn = () => gsap.to(specsImage, { opacity: 1, duration: 0.3 });
                        if (specsImage.complete) {
                            fadeIn();
                        } else {
                            specsImage.onload = fadeIn;
                        }
                    }
                });
            }
        }

        specBlocks.forEach((block) => {
            const newImgSrc = block.getAttribute('data-image');
            if (!newImgSrc) return;

            ScrollTrigger.create({
                trigger: block,
                start: 'top 50%',
                end: 'bottom 50%',
                onEnter: () => updateSpecsImage(newImgSrc),
                onEnterBack: () => updateSpecsImage(newImgSrc)
            });
        });
    }

    // 6. Initialize Swiper for Related Products Section
    if (typeof Swiper !== 'undefined' && document.querySelector('.related-products-swiper')) {
        new Swiper('.related-products-swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.related-swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                    spaceBetween: 24,
                },
                1200: {
                    slidesPerView: 2,
                    spaceBetween: 32,
                }
            }
        });
    }

    // 5. Quantity Box Interactivity
    const qtyBoxes = document.querySelectorAll('.sub-header-qty-box');
    qtyBoxes.forEach(box => {
        const minusBtn = box.querySelector('.qty-btn-minus');
        const plusBtn = box.querySelector('.qty-btn-plus');
        const qtyVal = box.querySelector('.qty-val');

        if (minusBtn && plusBtn && qtyVal) {
            minusBtn.addEventListener('click', (e) => {
                e.preventDefault();
                let current = parseInt(qtyVal.textContent, 10) || 1;
                if (current > 1) {
                    qtyVal.textContent = current - 1;
                }
            });

            plusBtn.addEventListener('click', (e) => {
                e.preventDefault();
                let current = parseInt(qtyVal.textContent, 10) || 1;
                qtyVal.textContent = current + 1;
            });
        }
    });
});
