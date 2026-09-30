$(document).ready(function () {
    // CSRF Setup for AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Quantity update via buttons
    $(document).on('click', '.btn-update-qty', function () {
        const productId = $(this).data('product-id');
        const action = $(this).data('action');
        const input = $(this).siblings('.qty-input-val');
        let currentQty = parseInt(input.val()) || 1;

        if (action === 'increase') {
            currentQty++;
        } else if (action === 'decrease' && currentQty > 1) {
            currentQty--;
        } else {
            return;
        }

        updateCartQuantity(productId, currentQty, input);
    });

    // Remove item from cart
    $(document).on('click', '.btn-remove-cart', function (e) {
        e.preventDefault();
        const productId = $(this).data('product-id');
        const row = $(this).closest('.cart-item-block');

        $.ajax({
            url: '/cart/remove',
            method: 'POST',
            data: { product_id: productId },
            success: function (response) {
                if (response.success) {
                    row.fadeOut(300, function () {
                        $(this).remove();
                        if ($('.cart-item-block').length === 0) {
                            location.reload(); // Reload to show empty cart template
                        }
                    });
                    // Update header badge
                    if (response.cart_count > 0) {
                        $('.cart-count-badge').text(response.cart_count).show();
                    } else {
                        $('.cart-count-badge').hide();
                    }
                    // Update order summaries
                    updateTotals(response.subtotal);
                }
            }
        });
    });

    // Save for Later
    $(document).on('click', '.btn-save-later', function (e) {
        e.preventDefault();
        const productId = $(this).data('product-id');

        $.ajax({
            url: '/cart/save-later',
            method: 'POST',
            data: { product_id: productId },
            success: function (response) {
                if (response.success) {
                    location.reload();
                }
            }
        });
    });

    // Move to Basket (Cart)
    $(document).on('click', '.btn-move-to-cart', function (e) {
        e.preventDefault();
        const productId = $(this).data('product-id');

        $.ajax({
            url: '/cart/move-to-cart',
            method: 'POST',
            data: { product_id: productId },
            success: function (response) {
                if (response.success) {
                    location.reload();
                }
            }
        });
    });

    // Remove from Saved list
    $(document).on('click', '.btn-remove-saved', function (e) {
        e.preventDefault();
        const productId = $(this).data('product-id');
        const element = $(this).closest('.saved-item-wrapper');

        $.ajax({
            url: '/cart/remove-saved',
            method: 'POST',
            data: { product_id: productId },
            success: function (response) {
                if (response.success) {
                    element.fadeOut(300, function () {
                        $(this).remove();
                        const currentCount = $('.saved-item-wrapper').length;
                        $('#saved-item-count').text(currentCount);
                        if (currentCount === 0) {
                            $('#saved-items-container').html('<div class="col-12 py-3 text-center"><p class="text-muted fs-14">No saved items.</p></div>');
                        }
                    });
                }
            }
        });
    });

    // Promo Code / Coupon Apply
    $(document).on('click', '#btnApplyPromo', function (e) {
        e.preventDefault();
        const code = $('#promoCodeInput').val().trim();
        const feedback = $('#promoFeedback');

        if (!code) {
            feedback.removeClass('text-success').addClass('text-danger').text('Please enter a coupon code.');
            return;
        }

        const btn = $(this);
        btn.prop('disabled', true).text('Applying...');

        $.ajax({
            url: '/coupon/apply',
            method: 'POST',
            data: { coupon_code: code, code: code },
            success: function (response) {
                btn.prop('disabled', false).text('Apply');
                if (response.success) {
                    location.reload();
                } else {
                    feedback.removeClass('text-success').addClass('text-danger').text(response.message || 'Invalid coupon code.');
                }
            },
            error: function (xhr) {
                btn.prop('disabled', false).text('Apply');
                const msg = xhr.responseJSON ? xhr.responseJSON.message : 'Failed to apply coupon.';
                feedback.removeClass('text-success').addClass('text-danger').text(msg);
            }
        });
    });

    // Promo Code / Coupon Remove
    $(document).on('click', '#btnRemoveCoupon', function (e) {
        e.preventDefault();

        $.ajax({
            url: '/coupon/remove',
            method: 'POST',
            success: function (response) {
                if (response.success) {
                    location.reload();
                }
            }
        });
    });

    function updateCartQuantity(productId, qty, inputEl) {
        $.ajax({
            url: '/cart/update',
            method: 'POST',
            data: {
                product_id: productId,
                quantity: qty
            },
            success: function (response) {
                if (response.success) {
                    inputEl.val(qty);
                    // Update header badge
                    if (response.cart_count > 0) {
                        $('.cart-count-badge').text(response.cart_count).show();
                    } else {
                        $('.cart-count-badge').hide();
                    }
                    // Update items total
                    $(`#subtotal-${productId}`).text('$' + response.item_subtotal);
                    updateTotals(response.subtotal);
                }
            }
        });
    }

    function updateTotals(subtotalFormatted) {
        $('.subtotal-summary').text('$' + subtotalFormatted);

        let subtotalVal = parseFloat(subtotalFormatted.replace(/,/g, '')) || 0;
        let discountVal = 0;

        if ($('.cart-discount-row').is(':visible')) {
            let discountText = $('.cart-discount-val').text().replace(/[^0-9.]/g, '');
            discountVal = parseFloat(discountText) || 0;
        }

        let finalTotal = Math.max(0, subtotalVal - discountVal);
        $('.total-summary').text('$' + finalTotal.toFixed(2));
    }
});
