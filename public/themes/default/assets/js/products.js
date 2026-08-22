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

    // 5. Intersection Observer for Scrollspy
    const sections = document.querySelectorAll('.content-section');
    const menuItems = document.querySelectorAll('.sidebar-menu .menu-item');

    if (sections.length && menuItems.length) {
        const observerOptions = {
            root: null,
            rootMargin: '-20% 0px -80% 0px',
            threshold: 0
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    menuItems.forEach(item => item.classList.remove('active'));
                    const id = entry.target.getAttribute('id');
                    const activeLinks = document.querySelectorAll(`.sidebar-menu .menu-item[href="#${id}"]`);
                    activeLinks.forEach(link => {
                        link.classList.add('active');
                    });
                }
            });
        }, observerOptions);

        sections.forEach(section => observer.observe(section));
    }
});
