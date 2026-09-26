// Global Real-Time Header Badges Update Function
window.updateHeaderBadges = function (type, count) {
    count = parseInt(count) || 0;
    let selector = '';
    if (type === 'cart') {
        selector = '.cart-count-badge';
    } else if (type === 'favorite' || type === 'favorites' || type === 'wishlist') {
        selector = '.favorite-count-badge';
    } else if (type === 'compare') {
        selector = '.compare-count-badge';
    }
    if (!selector) return;

    if (window.jQuery) {
        const $badge = window.jQuery(selector);
        if ($badge && $badge.length) {
            $badge.text(count);
            if (count > 0) {
                $badge.removeClass('d-none').css('cssText', 'display: inline-flex !important;');
            } else {
                $badge.addClass('d-none').css('cssText', 'display: none !important;');
            }
        }
    } else {
        document.querySelectorAll(selector).forEach(function (badge) {
            badge.textContent = count;
            if (count > 0) {
                badge.classList.remove('d-none');
                badge.style.setProperty('display', 'inline-flex', 'important');
            } else {
                badge.classList.add('d-none');
                badge.style.setProperty('display', 'none', 'important');
            }
        });
    }
};

// Global Toast Helpers
window.showCompareToast = function (message, isInfo = false) {
    $('.compare-toast, .cart-toast, .favorite-toast, .toast-notification').remove();
    const title = isInfo ? 'Comparison Notice' : 'Comparison Updated!';
    const iconClass = isInfo ? 'bi-info-circle text-info' : 'bi-check-circle-fill text-success';

    const toastHtml = `
        <div class="compare-toast position-fixed bottom-0 end-0 m-4 bg-white border border-light-subtle shadow-lg rounded-4 p-3 animate__animated animate__slideInRight" style="z-index: 10000; width: 320px; box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;">
            <div class="d-flex align-items-center mb-2">
                <i class="bi ${iconClass} fs-5 me-2"></i>
                <span class="fw-bold text-dark fs-14">${title}</span>
                <button type="button" class="btn-close ms-auto" onclick="$(this).closest('.compare-toast').fadeOut(300, function(){ $(this).remove(); })" aria-label="Close"></button>
            </div>
            <p class="fs-13 text-muted mb-3">${message}</p>
            <div class="d-flex gap-2">
                <a href="/compare" class="btn btn-primary btn-sm w-100 fw-semibold rounded-2 fs-12 text-white">View Compare</a>
            </div>
        </div>
    `;
    $('body').append(toastHtml);

    setTimeout(function () {
        $('.compare-toast').fadeOut(300, function () { $(this).remove(); });
    }, 4500);
};

window.showCartToast = function (message, isRemove = false) {
    $('.compare-toast, .cart-toast, .favorite-toast, .toast-notification').remove();
    const title = isRemove ? 'Removed from Cart' : 'Added to Cart!';
    const iconBg = isRemove ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary';
    const iconSvg = isRemove
        ? `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M19 6.41L17.5304 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z" fill="#dc3545" />
           </svg>`
        : `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM10 17L5 12L6.41 10.59L10 14.17L17.59 6.58L19 8L10 17Z" fill="#0066cc" />
           </svg>`;

    const toastHtml = `
        <div class="cart-toast position-fixed bottom-0 end-0 m-4 bg-white border border-light-subtle shadow-lg rounded-4 p-3 animate__animated animate__slideInRight" style="z-index: 10000; width: 320px; box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;">
            <div class="d-flex align-items-center gap-3">
                <div class="${iconBg} rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    ${iconSvg}
                </div>
                <div class="flex-grow-1">
                    <h6 class="mb-1 fw-bold text-dark fs-14">${title}</h6>
                    <p class="mb-0 text-muted fs-12">${message}</p>
                </div>
                <button type="button" class="btn-close ms-auto" onclick="$(this).closest('.cart-toast').fadeOut(300, function(){ $(this).remove(); })" aria-label="Close"></button>
            </div>
            <div class="d-flex gap-2 mt-3 pt-2 border-top border-light-subtle">
                <a href="/cart" class="btn btn-outline-primary btn-sm w-50 fw-semibold rounded-2 fs-12">View Cart</a>
                <a href="/checkout" class="btn btn-primary btn-sm w-50 fw-semibold rounded-2 fs-12 text-white">Checkout</a>
            </div>
        </div>
    `;
    $('body').append(toastHtml);
    setTimeout(() => {
        $('.cart-toast').fadeOut(300, function () { $(this).remove(); });
    }, 5000);
};


window.showNewsletterToast = function (message, isSuccess = true) {
    $('.compare-toast, .cart-toast, .favorite-toast, .newsletter-toast, .toast-notification').remove();
    const title = isSuccess ? 'Newsletter Subscribed' : 'Newsletter';
    const iconBg = isSuccess ? 'bg-success-subtle text-success' : 'bg-primary-subtle text-primary';
    const iconSvg = isSuccess
        ? `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM10 17L5 12L6.41 10.59L10 14.17L17.59 6.58L19 8L10 17Z" fill="#198754" />
           </svg>`
        : `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" fill="#0066cc"/>
           </svg>`;

    const toastHtml = `
        <div class="newsletter-toast position-fixed bottom-0 end-0 m-4 bg-white border border-light-subtle shadow-lg rounded-4 p-3 animate__animated animate__slideInRight" style="z-index: 10000; width: 320px; box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;">
            <div class="d-flex align-items-center gap-3">
                <div class="${iconBg} rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    ${iconSvg}
                </div>
                <div class="flex-grow-1">
                    <h6 class="mb-1 fw-bold text-dark fs-14">${title}</h6>
                    <p class="mb-0 text-muted fs-12">${message}</p>
                </div>
                <button type="button" class="btn-close ms-auto" onclick="$(this).closest('.newsletter-toast').fadeOut(300, function(){ $(this).remove(); })" aria-label="Close"></button>
            </div>
        </div>
    `;
    $('body').append(toastHtml);
    setTimeout(() => {
        $('.newsletter-toast').fadeOut(300, function () { $(this).remove(); });
    }, 5000);
};
window.showFavoriteToast = function (message) {
    $('.compare-toast, .cart-toast, .favorite-toast, .toast-notification').remove();
    const toastHtml = `
        <div class="favorite-toast position-fixed bottom-0 end-0 m-4 bg-white border border-light-subtle shadow-lg rounded-4 p-3 animate__animated animate__slideInRight" style="z-index: 10000; width: 320px; box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-danger-subtle text-danger rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </div>
                <div class="flex-grow-1">
                    <h6 class="mb-1 fw-bold text-dark fs-14">Wishlist Updated</h6>
                    <p class="mb-0 text-muted fs-12">${message}</p>
                </div>
                <button type="button" class="btn-close ms-auto" onclick="$(this).closest('.favorite-toast').fadeOut(300, function(){ $(this).remove(); })" aria-label="Close"></button>
            </div>
            <div class="d-flex justify-content-end mt-2 pt-2 border-top border-light-subtle">
                <a href="/favorite" class="btn btn-primary btn-sm w-100 fw-semibold rounded-2 fs-12 text-white">Go to Wishlist</a>
            </div>
        </div>
    `;
    $('body').append(toastHtml);
    setTimeout(() => {
        $('.favorite-toast').fadeOut(300, function () { $(this).remove(); });
    }, 5000);
};

// Helper: collect selected options from product detail page
function getSelectedOptions() {
    const options = {};
    // Collect active color swatches
    document.querySelectorAll('.color-swatch.active').forEach(function (el) {
        const optionId = el.getAttribute('data-option-id');
        const optionName = el.getAttribute('data-option-name') || 'Color';
        const valueId = el.getAttribute('data-value-id');
        const valueName = el.getAttribute('data-color') || (el.getAttribute('title') || '').split('(')[0].trim();
        const price = parseFloat(el.getAttribute('data-price')) || 0;
        const pricePrefix = el.getAttribute('data-price-prefix') || '+';
        if (optionId && valueId) {
            options[valueId] = {
                option_id: optionId,
                value_id: valueId,
                name: optionName,
                value: valueName,
                price: price,
                price_prefix: pricePrefix
            };
        }
    });
    // Collect active size / generic buttons
    document.querySelectorAll('.size-btn.active').forEach(function (el) {
        const optionId = el.getAttribute('data-option-id');
        const optionName = el.getAttribute('data-option-name') || 'Option';
        const valueId = el.getAttribute('data-value-id');
        const valueName = el.textContent.replace(/\(.*?\)/g, '').trim();
        const price = parseFloat(el.getAttribute('data-price')) || 0;
        const pricePrefix = el.getAttribute('data-price-prefix') || '+';
        if (optionId && valueId) {
            options[valueId] = {
                option_id: optionId,
                value_id: valueId,
                name: optionName,
                value: valueName,
                price: price,
                price_prefix: pricePrefix
            };
        }
    });
    return options;
}

// Global Compare Add Function (works for guests & logged in customers)
window.addToCompare = function (productId, btn) {
    if (!productId) return;

    const $btn = btn ? $(btn) : $(`[data-product-id="${productId}"].btn-add-to-compare`);
    const csrfToken = $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val();

    if ($btn.length) {
        $btn.prop('disabled', true);
    }

    $.ajax({
        url: '/compare/add',
        method: 'POST',
        data: {
            _token: csrfToken,
            product_id: productId
        },
        success: function (response) {
            if ($btn.length) {
                $btn.prop('disabled', false);
            }
            const cnt = response.compare_count !== undefined ? response.compare_count : response.count;
            if (cnt !== undefined) {
                window.updateHeaderBadges('compare', cnt);
            }

            if (response.success) {
                if ($btn.length) {
                    $btn.addClass('active btn-primary text-white').removeClass('btn-outline-secondary');
                    $btn.attr('title', 'In Comparison List');
                }
                window.showCompareToast(response.message, false);
            } else {
                window.showCompareToast(response.message, true);
            }
        },
        error: function (xhr) {
            if ($btn.length) {
                $btn.prop('disabled', false);
            }
            const msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Could not add item to comparison. Please try again.';
            window.showCompareToast(msg, true);
        }
    });
};

$(document).ready(function () {
    // Setup CSRF token for all jQuery AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        }
    });

    // 1. Sticky Header Effect
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('.top-header').addClass('scrolled');
        } else {
            $('.top-header').removeClass('scrolled');
        }
    });

    // 2. Product Category Filtering
    $('.filter-tabs .nav-link').on('click', function (e) {
        e.preventDefault();
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
            icon.removeClass('bi-heart').addClass('bi-heart-fill text-danger animate__animated animate__heartBeat');
        } else {
            icon.removeClass('bi-heart-fill text-danger animate__animated animate__heartBeat').addClass('bi-heart');
        }
    });

    // 4. Subtle scale effect for hero search bar
    $('.hero-search input').on('focus', function () {
        $(this).parent().css('transform', 'scale(1.03)');
    }).on('blur', function () {
        $(this).parent().css('transform', 'scale(1)');
    });

    // 5. Header Height calculation
    function updateHeaderHeight() {
        var header = $('.site-header');
        if (header.length) {
            document.documentElement.style.setProperty('--header-height', header.outerHeight() + 'px');
        }
    }
    updateHeaderHeight();
    $(window).on('resize', updateHeaderHeight);

    // -------------------------------------------------------------
    // E-COMMERCE CORE AJAX HANDLERS
    // -------------------------------------------------------------

    // Grid / List Add to Cart
    $(document).on('click', '.btn-add-to-cart', function (e) {
        e.preventDefault();
        const productId = $(this).data('product-id') || $(this).attr('data-product-id');
        const btn = $(this);
        const originalContent = btn.html();
        const isRemove = btn.hasClass('active');
        const url = isRemove ? '/cart/remove' : '/cart/add';

        btn.prop('disabled', true).addClass('pe-none');

        $.ajax({
            url: url,
            method: 'POST',
            data: {
                product_id: productId,
                quantity: 1,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    if (response.cart_count > 0) {
                        window.updateHeaderBadges('cart', response.cart_count);
                    } else {
                        window.updateHeaderBadges('cart', 0);
                    }
                    if (isRemove) {
                        btn.removeClass('active');
                        btn.attr('title', 'Add to cart').attr('data-bs-original-title', 'Add to cart');
                        window.showCartToast('Product removed from cart.', true);
                    } else {
                        btn.addClass('active');
                        btn.attr('title', 'In cart').attr('data-bs-original-title', 'In cart');
                        window.showCartToast('Product added to cart.', false);
                    }
                    btn.prop('disabled', false).removeClass('pe-none');
                } else if (response.has_options && response.redirect) {
                    // Redirect to detail page if product has mandatory options
                    window.location.href = response.redirect;
                    return;
                } else {
                    btn.prop('disabled', false).removeClass('pe-none').html(originalContent);
                    alert(response.message || 'Could not update cart.');
                }
            },
            error: function () {
                btn.prop('disabled', false).removeClass('pe-none').html(originalContent);
                alert('Could not update cart. Please try again.');
            }
        });
    });

    // Product Detail Add to Cart
    $(document).on('click', '.btn-add-to-cart-detail', function (e) {
        e.preventDefault();
        const productId = $(this).data('product-id') || $(this).attr('data-product-id');
        const quantity = $('#qtyInput').val() || 1;
        const btn = $(this);
        const originalText = btn.text();
        const selectedOptions = getSelectedOptions();

        btn.prop('disabled', true).text('ADDING...');

        $.ajax({
            url: '/cart/add',
            method: 'POST',
            data: {
                product_id: productId,
                quantity: quantity,
                options: selectedOptions,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    window.updateHeaderBadges('cart', response.cart_count);
                    window.showCartToast(response.message);
                    btn.text('ADDED!');
                    setTimeout(() => {
                        btn.prop('disabled', false).text(originalText);
                    }, 2000);
                } else {
                    btn.prop('disabled', false).text(originalText);
                    alert(response.message || 'Could not add to cart.');
                }
            },
            error: function () {
                btn.prop('disabled', false).text(originalText);
                alert('Could not add item to cart. Please try again.');
            }
        });
    });

    // Buy Now Button
    $(document).on('click', '.btn-buy-now', function (e) {
        e.preventDefault();
        const productId = $(this).data('product-id') || $(this).attr('data-product-id');
        let quantity = 1;
        if ($('#qtyInput').length) {
            quantity = $('#qtyInput').val();
        } else if ($('.sticky-qty-input').length) {
            quantity = $('.sticky-qty-input').val();
        }
        const btn = $(this);
        const originalText = btn.text();
        const selectedOptions = getSelectedOptions();

        btn.prop('disabled', true).text('PROCESSING...');

        $.ajax({
            url: '/cart/add',
            method: 'POST',
            data: {
                product_id: productId,
                quantity: quantity,
                options: selectedOptions,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    window.location.href = '/checkout';
                } else {
                    btn.prop('disabled', false).text(originalText);
                    alert(response.message || 'Could not proceed to checkout.');
                }
            },
            error: function () {
                btn.prop('disabled', false).text(originalText);
                alert('Could not process checkout. Please try again.');
            }
        });
    });

    // Toggle Favorite / Wishlist
    $(document).on('click', '.btn-toggle-favorite', function (e) {
        e.preventDefault();
        const productId = $(this).data('product-id') || $(this).attr('data-product-id');
        const btn = $(this);
        const icon = btn.find('i');

        $.ajax({
            url: '/favorite/toggle',
            method: 'POST',
            data: {
                product_id: productId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    if (response.is_favorite) {
                        btn.addClass('active btn-danger text-white').removeClass('btn-outline-secondary');
                        if (icon.length) icon.removeClass('bi-heart').addClass('bi-heart-fill');
                        btn.find('svg').attr('fill', '#dc3545');
                        btn.find('svg path').attr('fill', '#dc3545');
                    } else {
                        btn.removeClass('active btn-danger text-white').addClass('btn-outline-secondary');
                        if (icon.length) icon.removeClass('bi-heart-fill').addClass('bi-heart');
                        btn.find('svg').attr('fill', 'none');
                        btn.find('svg path').attr('fill', '#0066CC');
                    }

                    const favCount = response.favorites_count !== undefined ? response.favorites_count : response.count;
                    window.updateHeaderBadges('favorite', favCount);
                    window.showFavoriteToast(response.message);
                } else {
                    alert(response.message || 'Could not update favorites.');
                }
            },
            error: function () {
                alert('Could not update favorites. Please try again.');
            }
        });
    });

    // -------------------------------------------------------------
    // COMPARE PRODUCT HANDLERS (GUEST & AUTHENTICATED)
    // -------------------------------------------------------------

    // Add to Compare Click Handler
    $(document).on('click', '.btn-add-to-compare, .btn-add-compare, .product-card__btn-compare', function (e) {
        e.preventDefault();
        const btn = $(this);
        const productId = btn.data('product-id') || btn.attr('data-product-id');
        if (!productId) return;

        window.addToCompare(productId, btn);
    });

    // Remove from Compare Click Handler
    $(document).on('click', '.btn-remove-compare, .sidebar-compare-remove, .prod-close-btn', function (e) {
        e.preventDefault();
        const btn = $(this);
        const productId = btn.data('product-id') || btn.attr('data-product-id');
        if (!productId) return;

        const csrfToken = $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val();

        $.ajax({
            url: '/compare/remove',
            method: 'POST',
            data: {
                _token: csrfToken,
                product_id: productId
            },
            success: function (response) {
                const cnt = response.compare_count !== undefined ? response.compare_count : response.count;
                if (cnt !== undefined) {
                    window.updateHeaderBadges('compare', cnt);
                }
                window.showCompareToast(response.message, true);

                $(`#sidebar-item-${productId}`).slideUp(200, function () { $(this).remove(); });
                btn.closest('.compare-top-card').fadeOut(200, function () {
                    $(this).remove();
                    if ($('.compare-top-card').length === 0 || window.location.pathname.includes('/compare')) {
                        window.location.reload();
                    }
                });
            }
        });
    });

    // Clear All Compare Click Handler
    $(document).on('click', '#btn-clear-all-compare', function (e) {
        e.preventDefault();
        const csrfToken = $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val();

        $.ajax({
            url: '/compare/clear',
            method: 'POST',
            data: {
                _token: csrfToken
            },
            success: function (response) {
                window.updateHeaderBadges('compare', 0);
                window.showCompareToast(response.message, true);
                setTimeout(function () {
                    window.location.reload();
                }, 300);
            }
        });
    });

    // Buy Now from Compare Matrix
    $(document).on('click', '.btn-compare-buy', function (e) {
        e.preventDefault();
        const productId = $(this).data('product-id') || $(this).attr('data-product-id');
        if (!productId) return;

        const csrfToken = $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val();

        $.ajax({
            url: '/cart/add',
            method: 'POST',
            data: {
                _token: csrfToken,
                product_id: productId,
                quantity: 1
            },
            success: function (res) {
                if (res.success) {
                    window.location.href = '/checkout';
                } else {
                    window.location.href = `/products/${productId}`;
                }
            },
            error: function () {
                window.location.href = `/products/${productId}`;
            }
        });
    });

});

// Global Lenis Smooth Momentum Scroll Engine (isolated layer)
(function () {
    function loadScript(src, callback) {
        if (document.querySelector('script[src="' + src + '"]')) {
            if (callback) callback();
            return;
        }
        var script = document.createElement('script');
        script.src = src;
        script.onload = callback;
        document.head.appendChild(script);
    }

    function initLenisScroll() {
        if (typeof Lenis === 'undefined') return;

        window.lenisInstance = new Lenis({
            duration: 1.2,
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
            orientation: 'vertical',
            gestureOrientation: 'vertical',
            smoothWheel: true,
            wheelMultiplier: 1,
            touchMultiplier: 2,
            infinite: false,
        });

        // Synchronize Lenis with GSAP Ticker & ScrollTrigger
        if (typeof gsap !== 'undefined') {
            window.lenisInstance.on('scroll', () => {
                if (typeof ScrollTrigger !== 'undefined') {
                    ScrollTrigger.update();
                }
            });
            gsap.ticker.add((time) => {
                window.lenisInstance.raf(time * 1000);
            });
            gsap.ticker.lagSmoothing(0);
        } else {
            function raf(time) {
                window.lenisInstance.raf(time);
                requestAnimationFrame(raf);
            }
            requestAnimationFrame(raf);

            document.addEventListener('DOMContentLoaded', function () {
                if (typeof ScrollTrigger !== 'undefined' && window.lenisInstance) {
                    window.lenisInstance.on('scroll', () => ScrollTrigger.update());
                }
            });
        }

        if (typeof $ !== 'undefined') {
            $('.sticky-sidebar, .sidebar-menu, .filter-sidebar, .featured-card, .overflow-y-auto, .overflow-auto, .modal, .modal-body, .auth-modal, .offcanvas, .bottom-tabs-bar, .sticky-product-header, .mobile-category-scroll-wrapper, .mobile-category-scroll-track, .mobile-cat-pill').attr('data-lenis-prevent', 'true');

            // Pause Lenis momentum scrolling when any modal or offcanvas is opened
            $(document).on('show.bs.modal shown.bs.modal show.bs.offcanvas shown.bs.offcanvas', function () {
                if (window.lenisInstance) {
                    window.lenisInstance.stop();
                }
            });

            // Resume Lenis momentum scrolling ONLY after modal/offcanvas is completely hidden
            $(document).on('hidden.bs.modal hidden.bs.offcanvas', function () {
                if ($('.modal.show, .offcanvas.show').length === 0 && window.lenisInstance) {
                    window.lenisInstance.resize();
                    window.lenisInstance.start();
                }
            });

            $(document).on('wheel mousewheel DOMMouseScroll', '[data-lenis-prevent], .sticky-sidebar, .sidebar-menu, .filter-sidebar, .featured-card, .modal, .modal-dialog, .modal-body, .auth-modal, .offcanvas, .bottom-tabs-bar, .sticky-product-header, .mobile-category-scroll-wrapper, .mobile-category-scroll-track, .mobile-cat-pill', function (e) {
                e.stopPropagation();
            });

            // Unified Pointer / Touch / Mouse Drag-to-Scroll for horizontal pill tracks
            $(document).on('pointerdown', '.mobile-category-scroll-track, .bottom-tabs-bar .overflow-auto', function (e) {
                if (e.pointerType === 'mouse' && e.button !== 0) return;

                var slider = this;
                var isDown = true;
                var startX = e.pageX || (e.originalEvent && e.originalEvent.pageX) || 0;
                var startY = e.pageY || (e.originalEvent && e.originalEvent.pageY) || 0;
                var startLeft = slider.scrollLeft;
                var hasDragged = false;
                var lastX = startX;
                var lastTime = performance.now();
                var velX = 0;

                function onPointerMove(ev) {
                    if (!isDown) return;
                    var currentX = ev.pageX || (ev.originalEvent && ev.originalEvent.pageX) || 0;
                    var currentY = ev.pageY || (ev.originalEvent && ev.originalEvent.pageY) || 0;
                    var walkX = (currentX - startX);
                    var walkY = (currentY - startY);

                    // If user is intentionally scrolling page vertically before dragging horizontally
                    if (!hasDragged && Math.abs(walkY) > 8 && Math.abs(walkY) > Math.abs(walkX)) {
                        isDown = false;
                        try {
                            slider.releasePointerCapture(e.pointerId);
                        } catch (err) { }
                        return;
                    }

                    // Defer pointer capture until deliberate drag movement > 7px so child clicks dispatch cleanly
                    if (!hasDragged && Math.abs(walkX) > 7) {
                        hasDragged = true;
                        $(slider).addClass('is-dragging');
                        try {
                            slider.setPointerCapture(e.pointerId);
                        } catch (err) { }
                    }
                    var now = performance.now();
                    var dt = now - lastTime;
                    if (dt > 0) {
                        velX = (currentX - lastX) / dt;
                    }
                    lastX = currentX;
                    lastTime = now;
                    slider.scrollLeft = startLeft - walkX;
                }

                function onPointerUp(ev) {
                    if (!isDown) return;
                    isDown = false;
                    $(slider).removeClass('is-dragging');

                    if (ev && ev.pointerId) {
                        try {
                            slider.releasePointerCapture(ev.pointerId);
                        } catch (err) { }
                    }

                    window.removeEventListener('pointermove', onPointerMove);
                    window.removeEventListener('pointerup', onPointerUp);
                    window.removeEventListener('pointercancel', onPointerUp);

                    if (hasDragged) {
                        // Capture phase click suppression
                        var captureClick = function (clickEv) {
                            clickEv.preventDefault();
                            clickEv.stopPropagation();
                            clickEv.stopImmediatePropagation();
                            window.removeEventListener('click', captureClick, true);
                        };
                        window.addEventListener('click', captureClick, true);
                        setTimeout(function () {
                            window.removeEventListener('click', captureClick, true);
                        }, 150);

                        // Smooth momentum decay
                        var momentumX = velX * 16;
                        var friction = 0.92;
                        function stepMomentum() {
                            if (Math.abs(momentumX) > 0.4) {
                                slider.scrollLeft -= momentumX;
                                momentumX *= friction;
                                requestAnimationFrame(stepMomentum);
                            }
                        }
                        requestAnimationFrame(stepMomentum);
                    }
                }

                window.addEventListener('pointermove', onPointerMove, { passive: true });
                window.addEventListener('pointerup', onPointerUp, { passive: true });
                window.addEventListener('pointercancel', onPointerUp, { passive: true });
            });

            // Convert vertical wheel to horizontal scroll inside horizontal scroll tracks
            $(document).on('wheel', '.mobile-category-scroll-track, .bottom-tabs-bar .overflow-auto', function (e) {
                var delta = e.originalEvent.deltaY || e.originalEvent.deltaX;
                if (delta !== 0 && this.scrollWidth > this.clientWidth) {
                    this.scrollLeft += delta * 0.9;
                    e.preventDefault();
                    e.stopPropagation();
                }
            });

            $(document).on('click', 'a[href^="#"]', function (e) {
                // Ignore Bootstrap toggles (collapse, tab, modal, dropdown)
                if ($(this).is('[data-bs-toggle], [data-toggle], [role="tab"], .dropdown-toggle, .btn-close')) {
                    return;
                }

                var target = $(this).attr('href');
                if (target && target.length > 1 && $(target).length) {
                    e.preventDefault();
                    if (window.lenisInstance && typeof window.lenisInstance.scrollTo === 'function') {
                        window.lenisInstance.scrollTo(target, { offset: -80, duration: 1.2 });
                    } else {
                        var $target = $(target);
                        if ($target.length) {
                            $('html, body').stop().animate({ scrollTop: $target.offset().top - 80 }, 600);
                        }
                    }
                }
            });
        }
    }

    if (typeof Lenis === 'undefined') {
        loadScript('https://cdn.jsdelivr.net/npm/lenis@1.1.18/dist/lenis.min.js', initLenisScroll);
    } else {
        initLenisScroll();
    }

    // Global GSAP ScrollTrigger Lifecycle & Back/Forward Cache (bfcache) Recovery
    (function () {
        if (typeof window === 'undefined') return;

        // Prevent browser's premature scroll jump before Lenis & GSAP coordinates are ready
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }

        // Persist scroll position per URL path to accurately restore on Back navigation
        window.addEventListener('beforeunload', function () {
            try {
                sessionStorage.setItem('aire_scroll_pos_' + window.location.pathname, window.scrollY);
            } catch (err) { }
        });

        function recoverScrollAndTriggers(isBackForward) {
            // 1. Synchronize Lenis smooth scroll engine with DOM height
            if (window.lenisInstance) {
                window.lenisInstance.resize();
            }

            // 2. Restore exact scroll coordinate if returning via back/forward cache or history
            if (isBackForward) {
                try {
                    var savedPos = sessionStorage.getItem('aire_scroll_pos_' + window.location.pathname);
                    if (savedPos !== null) {
                        var targetY = parseFloat(savedPos) || 0;
                        if (window.lenisInstance) {
                            window.lenisInstance.scrollTo(targetY, { immediate: true });
                        } else {
                            window.scrollTo(0, targetY);
                        }
                    }
                } catch (err) { }
            }

            // 3. Re-initialize dynamic components & recalculate all ScrollTrigger boundaries
            if (typeof ScrollTrigger !== 'undefined') {
                if (typeof window.initWhyChooseScrollTrigger === 'function') {
                    window.initWhyChooseScrollTrigger();
                }
                if (typeof window.initLivingHeroScrollTrigger === 'function') {
                    window.initLivingHeroScrollTrigger();
                }
                if (typeof window.initLifestyleParallax === 'function') {
                    window.initLifestyleParallax();
                }
                if (typeof window.initBenefitsParallax === 'function') {
                    window.initBenefitsParallax();
                }

                ScrollTrigger.clearScrollMemory();
                ScrollTrigger.sort();
                ScrollTrigger.refresh(true);
            }
        }

        // Modern bfcache & page restore listener
        window.addEventListener('pageshow', function (e) {
            var isBackNav = e.persisted || (window.performance && window.performance.navigation && window.performance.navigation.type === 2);

            // Immediate recovery pass
            recoverScrollAndTriggers(isBackNav);

            // Deferred second pass after custom fonts & dynamic images paint
            requestAnimationFrame(function () {
                setTimeout(function () {
                    recoverScrollAndTriggers(false);
                }, 120);
            });
        });

        // History popstate listener
        window.addEventListener('popstate', function () {
            requestAnimationFrame(function () {
                recoverScrollAndTriggers(true);
            });
        });
    })();

    // ── Mobile Offcanvas Active Menu Indicator Auto-sync ──────────
    function syncMobileMenuActiveItem() {
        var currentPath = window.location.pathname.replace(/\/$/, '') || '/';
        $('.offcanvas .mobile-nav').each(function () {
            var $nav = $(this);
            // Clean up any stray indicator spans from DOM so CSS ::after exclusively renders the dot
            $nav.find('.mobile-nav-link__indicator').remove();

            var $activeLinks = $nav.find('.mobile-nav-link.active');
            // If exactly one link is already active from Blade SSR, keep it
            if ($activeLinks.length === 1) {
                return;
            }

            // If 0 or multiple are marked active, clear all and find the single exact match
            $nav.find('.mobile-nav-link').removeClass('active');
            $nav.find('.mobile-nav-link').each(function () {
                var href = $(this).attr('href');
                if (!href || href === '#' || href.startsWith('javascript:')) return;
                try {
                    var linkPath = new URL(href, window.location.origin).pathname.replace(/\/$/, '') || '/';
                    if (linkPath === currentPath) {
                        $(this).addClass('active');
                        return false; // Break after single exact match
                    }
                } catch (e) { }
            });
        });
    }

    $(document).on('show.bs.offcanvas', function () {
        syncMobileMenuActiveItem();
    });
})();