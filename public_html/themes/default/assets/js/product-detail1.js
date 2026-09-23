$(document).ready(function () {
    //
    // Product Gallery
    //
    const galleryThumbs = new Swiper(".gallery-thumbs", {
        spaceBetween: 16,
        slidesPerView: 5,
        freeMode: true,
        watchSlidesProgress: true,
    });

    const galleryMain = new Swiper(".gallery-main", {
        spaceBetween: 10,
        thumbs: {
            swiper: galleryThumbs,
        },
    });

    //
    // Quantity Selector
    //
    $('.quantity-selector').each(function () {
        const $selector = $(this);
        const $input = $selector.find('.qty-input');
        const $plusBtn = $selector.find('.qty-btn:contains("+")');
        const $minusBtn = $selector.find('.qty-btn:contains("-")');

        $plusBtn.on('click', function () {
            let currentValue = parseInt($input.val());
            $input.val(currentValue + 1);
        });

        $minusBtn.on('click', function () {
            let currentValue = parseInt($input.val());
            if (currentValue > 1) {
                $input.val(currentValue - 1);
            }
        });
    });

    //
    // Sticky Nav Bar ScrollSpy
    //
    const sections = document.querySelectorAll('.pdp-section');
    const navItems = document.querySelectorAll('.sticky-nav-bar .nav-item');

    window.addEventListener('scroll', () => {
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            if (pageYOffset >= (sectionTop - sectionHeight / 3)) {
                current = section.getAttribute('id');
            }
        });

        navItems.forEach(item => {
            item.classList.remove('active');
            if (item.getAttribute('href').includes(current)) {
                item.classList.add('active');
            }
        });
    });

    //
    // Color/Size/Voltage Selectors
    //
    $('.color-swatches .swatch').on('click', function() {
        $(this).siblings().removeClass('active');
        $(this).addClass('active');
    });

    $('.size-selector .size-btn').on('click', function() {
        $(this).siblings().removeClass('active');
        $(this).addClass('active');
    });

});
