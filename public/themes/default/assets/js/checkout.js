$(document).ready(function () {
    const csrfToken = $('input[name="_token"]').val();

    // ─── Dynamic Country -> District / Zone Loading ─────────────────────────
    function loadZones(countryId, targetSelectId, selectedZoneId = null) {
        if (!countryId) {
            $(`#${targetSelectId}`).html('<option value="">Please select district</option>');
            updateLiveShipSummary();
            return;
        }

        $.ajax({
            url: '/checkout/zones',
            method: 'POST',
            data: {
                _token: csrfToken,
                country_id: countryId
            },
            success(res) {
                if (res.success && res.zones) {
                    let html = '<option value="">Please select district</option>';
                    res.zones.forEach(zone => {
                        const isSel = selectedZoneId && (selectedZoneId == zone.id || selectedZoneId == zone.name) ? 'selected' : '';
                        html += `<option value="${zone.name}" data-id="${zone.id}" ${isSel}>${zone.name}</option>`;
                    });
                    $(`#${targetSelectId}`).html(html);
                    updateLiveShipSummary();
                }
            }
        });
    }

    $('#countryName1').on('change', function () {
        loadZones($(this).val(), 'stateView');
    });

    $('#sh_countryName').on('change', function () {
        loadZones($(this).val(), 'sh_stateView');
    });

    // Initial load for default selected country
    if ($('#countryName1').val()) {
        loadZones($('#countryName1').val(), 'stateView');
    }
    if ($('#sh_countryName').val()) {
        loadZones($('#sh_countryName').val(), 'sh_stateView');
    }

    // ─── Payment Option Button Click Handler ─────────────────────────────────
    $('.payment-opt-btn').on('click', function () {
        $('.payment-opt-btn').removeClass('active');
        $(this).addClass('active');

        const val          = $(this).data('value');
        const requiresCard = $(this).data('requires-card') == 1;
        $('#selectedPaymentMethod').val(val);

        // Toggle Credit Card form fields
        if (requiresCard) {
            $('#ccFormFields').slideDown(200);
            $('#ccNum, #ccExp, #ccCvv').attr('required', true);
        } else {
            $('#ccFormFields').slideUp(200);
            $('#ccNum, #ccExp, #ccCvv').removeAttr('required');
        }

        // Toggle payment instruction panels
        $('.payment-info-panel').hide();
        const slug = val.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
        $('#info-' + slug).fadeIn(200);
    });

    // ─── Dynamic Zone Rate Shipping Calculation (cCart Reference Feature) ───
    function updateZoneShippingRate() {
        const isDifferentShipping = $('#shippingElseCheckbox').is(':checked');
        const selectedCity = isDifferentShipping ? $('#sh_stateView').val() : $('#stateView').val();
        const selectedCityId = isDifferentShipping
            ? $('#sh_stateView option:selected').data('id')
            : $('#stateView option:selected').data('id');
        const countryId = isDifferentShipping ? $('#sh_countryName').val() : $('#countryName1').val();

        // Calculate rate for each shipping method option dynamically
        $('input[name="shippingMethod"]').each(function() {
            const methodCode = $(this).val();
            const $radio = $(this);

            $.ajax({
                url: '/checkout/shipping-rate',
                method: 'POST',
                data: {
                    _token: csrfToken,
                    city_id: selectedCityId || selectedCity,
                    country_id: countryId,
                    paymethod: methodCode
                },
                success(res) {
                    if (res.success) {
                        $radio.attr('data-cost', res.charge);
                        const costText = res.charge > 0 ? res.formatted_charge : 'Free';
                        $radio.closest('.shipping-method-option').find('.shipping-cost-label').text(costText);

                        if ($radio.is(':checked')) {
                            $('.checkout-shipping-val').text(costText);
                            if (res.discount > 0) {
                                $('.checkout-discount-row').show();
                                $('.checkout-discount-val').text(res.formatted_discount);
                            }
                            $('.checkout-subtotal-val').text(res.formatted_subtotal.replace('$', ''));
                            $('.checkout-total-val, .checkout-total-btn-val').text(res.formatted_total.replace('$', ''));
                        }
                    }
                }
            });
        });
    }

    $(document).on('change', '#stateView, #sh_stateView, #countryName1, #sh_countryName, #shippingElseCheckbox, input[name="shippingMethod"]', updateZoneShippingRate);
    updateZoneShippingRate(); // run on page load

    // ─── Live "Ship To" Summary Card Update (cCart Reference Feature) ───────
    function updateLiveShipSummary() {
        const isDifferentShipping = $('#shippingElseCheckbox').is(':checked');

        let fName, lName, country, district, addr1, addr2, phone;

        if (isDifferentShipping) {
            fName    = $('#shipFname').val() || '';
            lName    = $('#shipLname').val() || '';
            phone    = $('#shipPhone').val() || '';
            country  = $('#sh_countryName option:selected').text() || '—';
            district = $('#sh_stateView option:selected').text() || '—';
            addr1    = $('#shipAddr1').val() || '';
            addr2    = $('#shipAddr2').val() || '';
        } else {
            fName    = $('#fname1').val() || '';
            lName    = $('#lname1').val() || '';
            phone    = $('#phone').val() || '';
            country  = $('#countryName1 option:selected').text() || '—';
            district = $('#stateView option:selected').text() || '—';
            addr1    = $('#addr1').val() || '';
            addr2    = $('#addr2').val() || '';
        }

        if (country.includes('Please select')) country = '—';
        if (district.includes('Please select')) district = '—';

        const fullName = (fName + ' ' + lName).trim();
        $('#liveShipName').text(fullName || 'First & Last Name');
        $('#liveShipCountry').text(country);
        $('#liveShipDistrict').text(district);
        $('#liveShipAddr1').text(addr1 || '—');
        $('#liveShipAddr2').text(addr2 || '—');
        $('#liveShipPhone').text(phone || '—');
    }

    $(document).on('input change', '.ship-live-trigger, #shippingElseCheckbox', updateLiveShipSummary);
    updateLiveShipSummary();

    // ─── Guest Account Creation Toggle (cCart Reference Feature) ───────────
    $('#createNewAccount').on('change', function () {
        if ($(this).is(':checked')) {
            $('#accountPasswordFields').slideDown(200);
            $('#accPassword').attr('required', true);
        } else {
            $('#accountPasswordFields').slideUp(200);
            $('#accPassword').removeAttr('required');
        }
    });

    // ─── Separate Shipping Address Toggle (cCart Reference Feature) ─────────
    $('#shippingElseCheckbox').on('change', function () {
        if ($(this).is(':checked')) {
            $('#differentShippingAddressBlock').slideDown(200);
            $('#shipFname, #shipLname, #shipPhone, #sh_countryName, #sh_stateView, #shipAddr1, #shipZip').attr('required', true);
        } else {
            $('#differentShippingAddressBlock').slideUp(200);
            $('#shipFname, #shipLname, #shipPhone, #sh_countryName, #sh_stateView, #shipAddr1, #shipZip').removeAttr('required');
        }
        updateLiveShipSummary();
    });

    // ─── Apply Promo Code ─────────────────────────────────────────────────────
    $(document).on('click', '#btnApplyPromo', function () {
        const code = $('#promoCodeInput').val().trim();
        if (!code) return;

        const $btn = $(this).prop('disabled', true).text('Applying…');
        $('#promoFeedback').text('').removeClass('text-success text-danger');

        $.ajax({
            url: '/coupon/apply',
            method: 'POST',
            data: {
                _token: csrfToken,
                coupon_code: code
            },
            success(res) {
                if (res.success) {
                    couponDiscount = parseFloat(res.discount) || 0;

                    // Swap the promo input form for the applied banner
                    const saving = couponDiscount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    const banner = `
                        <div class="d-flex align-items-center justify-content-between gap-2 rounded-3 px-3 py-2" id="appliedCouponBanner"
                            style="background: var(--color-primary-bg); border: 1.5px solid var(--color-primary-light);">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-tag-fill fs-15" style="color: var(--color-primary);"></i>
                                <div>
                                    <span class="fw-bold fs-14" style="color: var(--color-primary);">${code.toUpperCase()}</span>
                                    <p class="mb-0 fs-12 text-muted">Coupon applied &mdash; saving $${saving}</p>
                                </div>
                            </div>
                            <button type="button" id="btnRemoveCoupon"
                                class="btn btn-link p-0 fs-13 fw-semibold text-decoration-none"
                                style="color: var(--color-primary-hover);">
                                <i class="bi bi-x-circle me-1"></i>Remove
                            </button>
                        </div>`;
                    $('#promoInputWrapper').replaceWith(banner);

                    // Show discount row and update totals
                    $('.checkout-discount-val').text(saving);
                    $('.checkout-discount-row').css('display', 'flex');
                    updateCheckoutTotals();
                } else {
                    $('#promoFeedback').text(res.message).addClass('text-danger');
                    $btn.prop('disabled', false).text('Apply');
                }
            },
            error() {
                $('#promoFeedback').text('Something went wrong. Please try again.').addClass('text-danger');
                $btn.prop('disabled', false).text('Apply');
            }
        });
    });

    // ─── Remove Coupon ────────────────────────────────────────────────────────
    $(document).on('click', '#btnRemoveCoupon', function () {
        const $btn = $(this).prop('disabled', true);

        $.ajax({
            url: '/coupon/remove',
            method: 'POST',
            data: { _token: csrfToken },
            success(res) {
                if (res.success) {
                    couponDiscount = 0;

                    // Replace the banner back with the promo input form
                    const inputForm = `
                        <div id="promoInputWrapper">
                            <a class="text-decoration-none fw-semibold fs-14 text-dark d-flex justify-content-between align-items-center"
                                data-bs-toggle="collapse" href="#promoCodeCollapse" role="button" aria-expanded="false"
                                aria-controls="promoCodeCollapse">
                                Do you have a promo code?
                                <i class="bi bi-chevron-down text-muted"></i>
                            </a>
                            <div class="collapse mt-3" id="promoCodeCollapse">
                                <div class="input-group">
                                    <input type="text" class="form-control fs-14 shadow-none" id="promoCodeInput" placeholder="Enter code">
                                    <button class="btn btn-dark fw-semibold fs-14 px-3" type="button" id="btnApplyPromo">Apply</button>
                                </div>
                                <div id="promoFeedback" class="mt-2 fs-13 fw-semibold"></div>
                            </div>
                        </div>`;
                    $('#appliedCouponBanner').replaceWith(inputForm);

                    // Hide discount row and recalculate
                    $('.checkout-discount-row').css('display', 'none');
                    $('.checkout-discount-val').text('0.00');
                    updateCheckoutTotals();
                }
            }
        });
    });
});
