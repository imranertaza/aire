// Global Real-Time Header Badges Update Function
window.updateHeaderBadges = function(type, count) {
    count = parseInt(count) || 0;
    let $badge;
    if (type === 'cart') {
        $badge = $('.cart-count-badge');
    } else if (type === 'favorite' || type === 'favorites' || type === 'wishlist') {
        $badge = $('.favorite-count-badge');
    } else if (type === 'compare') {
        $badge = $('.compare-count-badge');
    }
    if ($badge && $badge.length) {
        $badge.text(count);
        if (count > 0) {
            $badge.removeClass('d-none').css('cssText', 'display: inline-flex !important;');
        } else {
            $badge.addClass('d-none').css('cssText', 'display: none !important;');
        }
    }
};

// Global Toast Helpers
window.showCompareToast = function(message, isInfo = false) {
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

window.showCartToast = function(message, isRemove = false) {
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

window.showFavoriteToast = function(message) {
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
    document.querySelectorAll('.color-swatch.active').forEach(function(el) {
        const optionId   = el.getAttribute('data-option-id');
        const optionName = el.getAttribute('data-option-name') || 'Color';
        const valueId    = el.getAttribute('data-value-id');
        const valueName  = el.getAttribute('title') || el.getAttribute('data-color') || '';
        if (optionId && valueId) {
            options[valueId] = {
                option_id:  optionId,
                value_id:   valueId,
                name:       optionName,
                value:      valueName
            };
        }
    });
    // Collect active size / generic buttons
    document.querySelectorAll('.size-btn.active').forEach(function(el) {
        const optionId   = el.getAttribute('data-option-id');
        const optionName = el.getAttribute('data-option-name') || 'Option';
        const valueId    = el.getAttribute('data-value-id');
        const valueName  = el.textContent.replace(/\(.*?\)/g, '').trim();
        if (optionId && valueId) {
            options[valueId] = {
                option_id:  optionId,
                value_id:   valueId,
                name:       optionName,
                value:      valueName
            };
        }
    });
    return options;
}

// Global Compare Add Function (works for guests & logged in customers)
window.addToCompare = function(productId, btn) {
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
                    } else {
                        btn.removeClass('active btn-danger text-white').addClass('btn-outline-secondary');
                        if (icon.length) icon.removeClass('bi-heart-fill').addClass('bi-heart');
                    }

                    const favCount = response.favorites_count !== undefined ? response.favorites_count : response.count;
                    window.updateHeaderBadges('favorite', favCount);
                    window.showFavoriteToast(response.message);
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
                
                $(`#sidebar-item-${productId}`).slideUp(200, function() { $(this).remove(); });
                btn.closest('.compare-top-card').fadeOut(200, function() {
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
                setTimeout(function() {
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

        function raf(time) {
            window.lenisInstance.raf(time);
            requestAnimationFrame(raf);
        }

        requestAnimationFrame(raf);

        if (typeof $ !== 'undefined') {
            $('.sticky-sidebar, .sidebar-menu, .filter-sidebar, .featured-card, .overflow-y-auto, .overflow-auto').attr('data-lenis-prevent', 'true');

            $(document).on('wheel mousewheel DOMMouseScroll', '.sticky-sidebar, .sidebar-menu, .filter-sidebar, .featured-card', function (e) {
                e.stopPropagation();
            });

            $(document).on('click', 'a[href^="#"]', function (e) {
                var target = $(this).attr('href');
                if (target && target.length > 1 && $(target).length) {
                    e.preventDefault();
                    window.lenisInstance.scrollTo(target, { offset: -80, duration: 1.2 });
                }
            });
        }
    }

    if (typeof Lenis === 'undefined') {
        loadScript('https://cdn.jsdelivr.net/npm/lenis@1.1.18/dist/lenis.min.js', initLenisScroll);
    } else {
        initLenisScroll();
    }
})();