$(document).ready(function () {
    // 2. Product Category Filtering
    $('.filter-tabs .nav-link').on('click', function (e) {
        e.preventDefault();

        // Update active class
        $('.filter-tabs .nav-link').removeClass('active');
        $(this).addClass('active');

        let filterValue = $(this).attr('data-filter');

        if (filterValue === 'all') {
            $('.product-item').stop(true, true).fadeIn(400);
        } else {
            $('.product-item').stop(true, true).hide();
            $('.product-item[data-category="' + filterValue + '"]').stop(true, true).fadeIn(400);
        }
    });

    // 3. Like/Favorite Button Animation
    $('.btn-favorite').on('click', function (e) {
        e.preventDefault();
        let icon = $(this).find('i');

        if (icon.hasClass('bi-heart')) {
            // Add like animation
            icon.removeClass('bi-heart').addClass('bi-heart-fill text-danger animate__animated animate__heartBeat');
        } else {
            // Remove like animation
            icon.removeClass('bi-heart-fill text-danger animate__animated animate__heartBeat').addClass('bi-heart');
        }
    });

    // 4. Initialize Swiper Featured Slider
    if (typeof Swiper !== 'undefined' && $('.featured-swiper').length && !$('.featured-swiper')[0].swiper) {
        new Swiper('.featured-swiper', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            }
        });
    }

    // 5. Sidebar & Mobile Category Scrollspy and Click Navigation
    const sections = document.querySelectorAll('.content-section, .category-showcase-section');
    const menuItems = document.querySelectorAll('.sidebar-menu .menu-item, .mobile-cat-pill');
    let isClickScrolling = false;
    let scrollTimeout = null;

    function setActiveCategory(targetId) {
        if (!targetId) return;
        const hashId = targetId.startsWith('#') ? targetId : '#' + targetId;

        // Remove active from all hash-based sidebar items and mobile pills
        document.querySelectorAll('.sidebar-menu .menu-item[href^="#"], .mobile-cat-pill[href^="#"]').forEach(item => {
            item.classList.remove('active');
        });

        // Add active to matching links
        const activeLinks = document.querySelectorAll(`.sidebar-menu .menu-item[href="${hashId}"], .mobile-cat-pill[href="${hashId}"]`);
        activeLinks.forEach(link => {
            link.classList.add('active');
            if (link.classList.contains('mobile-cat-pill')) {
                link.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
            }
        });
    }

    // Handle Click Navigation with smooth scroll and header offset
    $(document).on('click', '.sidebar-menu .menu-item[href^="#"], .mobile-cat-pill[href^="#"]', function (e) {
        const targetId = $(this).attr('href');
        if (targetId && targetId !== '#' && targetId.length > 1) {
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                e.preventDefault();

                isClickScrolling = true;
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(() => {
                    isClickScrolling = false;
                }, 800);

                setActiveCategory(targetId);

                const headerOffset = 90;
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });

                if (history.pushState) {
                    history.pushState(null, null, targetId);
                }
            }
        }
    });

    // Intersection Observer for Scrollspy
    if (sections.length && menuItems.length) {
        const observerOptions = {
            root: null,
            rootMargin: '-15% 0px -65% 0px',
            threshold: 0
        };

        const observer = new IntersectionObserver((entries) => {
            if (isClickScrolling) return;

            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const id = entry.target.getAttribute('id');
                    if (id) {
                        setActiveCategory('#' + id);
                    }
                }
            });
        }, observerOptions);

        sections.forEach(section => observer.observe(section));
    }
});
