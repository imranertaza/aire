$(document).ready(function () {
    // 1. Sticky Header Effect
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('.top-header').addClass('scrolled');
        } else {
            $('.top-header').removeClass('scrolled');
        }
    });

    // 2. Subtle scale effect for search inputs on focus
    $('.hero-search input, .error-search-box input').on('focus', function () {
        $(this).closest('form').css('transform', 'scale(1.02)');
    }).on('blur', function () {
        $(this).closest('form').css('transform', 'scale(1)');
    });

    // 3. AIRE Smart Search & Discovery Modal
    let searchDebounceTimer = null;
    let examplePromptIndex = 0;
    const examplePrompts = [
        "clean air for classroom",
        "reduce virus in hospital OT",
        "PM2.5 removal for living room",
        "quiet ERV for bedroom",
        "cleanroom HVAC system",
        "high efficiency air purifier for clinic"
    ];

    function openSearch(initialQuery = '') {
        const $backdrop = $('#aireSearchBackdrop');
        const $modal = $('#aireSearchModal');
        const $input = $('#aireSearchInput');
        const $guidance = $('#aireSearchGuidance');
        const $results = $('#aireSearchResults');
        const $clear = $('#aireSearchClear');

        $backdrop.addClass('show');
        $modal.addClass('show');
        $('body').addClass('search-modal-open');

        if (initialQuery) {
            $input.val(initialQuery);
            $clear.removeClass('d-none');
            $guidance.hide();
            $results.show().html('<div class="aire-results-loading"><i class="spinner-border spinner-border-sm text-primary me-2"></i>Searching clean air systems...</div>');
            fetchLiveSearchResults(initialQuery);
        } else {
            $guidance.show();
            $results.empty().hide();
            if ($input.val().trim().length === 0) {
                $clear.addClass('d-none');
            }
        }

        // Staggered focus so browser never loses focus
        const focusInput = function () {
            if ($input.length && $modal.hasClass('show')) {
                $input[0].focus({ preventScroll: true });
                if (initialQuery) {
                    $input.select();
                }
            }
        };

        focusInput();
        requestAnimationFrame(focusInput);
        setTimeout(focusInput, 30);
        setTimeout(focusInput, 100);
        setTimeout(focusInput, 200);
    }

    function closeSearch() {
        $('#aireSearchModal').removeClass('show');
        $('#aireSearchBackdrop').removeClass('show');
        $('body').removeClass('search-modal-open');
        $('#aireSearchInput').blur();
    }

    // Toggle button click (Desktop + Mobile dock)
    $(document).on('click', '[data-search-toggle]', function (e) {
        e.preventDefault();
        e.stopPropagation();
        if ($('#aireSearchModal').hasClass('show')) {
            closeSearch();
        } else {
            openSearch();
        }
    });

    // Close button click
    $(document).on('click', '#aireSearchCloseBtn', function (e) {
        e.preventDefault();
        closeSearch();
    });

    // Backdrop click
    $(document).on('click', '#aireSearchBackdrop', function (e) {
        e.preventDefault();
        closeSearch();
    });

    // Global keyboard handling
    $(document).on('keydown', function (e) {
        const isSearchOpen = $('#aireSearchModal').hasClass('show');
        const activeTagName = document.activeElement ? document.activeElement.tagName.toLowerCase() : '';
        const isTypingInOtherInput = ['input', 'textarea', 'select'].includes(activeTagName) && !$(document.activeElement).hasClass('aire-search-input');

        // Escape closes search
        if (e.key === 'Escape' && isSearchOpen) {
            closeSearch();
            return;
        }

        // Shortcut: '/' or Ctrl/Cmd + K opens search when not in another input
        if (!isSearchOpen && !isTypingInOtherInput) {
            if (e.key === '/' || ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k')) {
                e.preventDefault();
                openSearch();
                return;
            }
        }

        // If search is open but input lost focus, redirect alphanumeric key to search input
        if (isSearchOpen && !$(document.activeElement).hasClass('aire-search-input') && !e.ctrlKey && !e.metaKey && !e.altKey) {
            if (e.key.length === 1 || e.key === 'Backspace') {
                const $input = $('#aireSearchInput');
                $input.focus();
            }
        }
    });

    // Search Input Clear Button
    $(document).on('click', '#aireSearchClear', function () {
        const $input = $('#aireSearchInput');
        $input.val('').focus();
        $(this).addClass('d-none');
        $('#aireSearchResults').empty().hide();
        $('#aireSearchGuidance').show();
    });

    // Live Dynamic Search Input Handler
    $(document).on('input', '#aireSearchInput', function () {
        const query = $(this).val().trim();
        const $clear = $('#aireSearchClear');
        const $guidance = $('#aireSearchGuidance');
        const $results = $('#aireSearchResults');

        clearTimeout(searchDebounceTimer);

        if (query.length > 0) {
            $clear.removeClass('d-none');
        } else {
            $clear.addClass('d-none');
        }

        if (query.length < 2) {
            $results.empty().hide();
            $guidance.show();
            return;
        }

        $guidance.hide();
        $results.show().html('<div class="aire-results-loading"><i class="spinner-border spinner-border-sm text-primary me-2"></i>Searching clean air systems...</div>');

        searchDebounceTimer = setTimeout(function () {
            fetchLiveSearchResults(query);
        }, 180);
    });

    // Popular Search Chips Click
    $(document).on('click', '.aire-search-chip', function (e) {
        e.preventDefault();
        const keyword = $(this).data('keyword');
        if (keyword) {
            $('#aireSearchInput').val(keyword).trigger('input');
        }
    });


    // "Try an example" button click
    $(document).on('click', '#aireBtnTryExample', function (e) {
        e.preventDefault();
        const prompt = examplePrompts[examplePromptIndex % examplePrompts.length];
        examplePromptIndex++;
        $('#aireSearchInput').val(prompt).trigger('input');
    });

    function fetchLiveSearchResults(query) {
        const $results = $('#aireSearchResults');

        $.ajax({
            url: '/products-dropdown',
            method: 'GET',
            data: { search: query, limit: 6 },
            dataType: 'json',
            success: function (res) {
                const products = res.products || res.data || [];
                const categories = res.categories || [];
                const matchingTags = res.matching_tags || [];

                if (products.length === 0 && categories.length === 0 && matchingTags.length === 0) {
                    $results.html(`
                        <div class="aire-results-empty">
                            <i class="bi bi-wind fs-2 d-block text-muted mb-2"></i>
                            No products or solutions found matching "<strong>${escapeHtml(query)}</strong>".
                            <div class="mt-2 text-muted fs-12">Try searching by model (e.g. BAP-500), application (e.g. Hospital), or requirement (e.g. PM2.5).</div>
                        </div>
                    `);
                    return;
                }

                let html = '';

                // Matching Categories Section
                if (categories.length > 0) {
                    html += `<div class="aire-results-section-title">Matching Categories & Solutions</div>`;
                    html += `<div class="aire-results-pills-row">`;
                    categories.forEach(function (cat) {
                        html += `<a href="${cat.url}" class="aire-results-pill"><i class="bi bi-folder2-open"></i> ${escapeHtml(cat.name)}</a>`;
                    });
                    html += `</div>`;
                }

                // Matching Requirement / Application Filter Tags
                if (matchingTags.length > 0) {
                    html += `<div class="aire-results-section-title">Matching Requirements & Applications</div>`;
                    html += `<div class="aire-results-pills-row">`;
                    matchingTags.forEach(function (tag) {
                        html += `<a href="${tag.url}" class="aire-results-pill"><i class="bi bi-tag-fill"></i> ${escapeHtml(tag.name)} <span class="text-muted fs-10">(${escapeHtml(tag.group)})</span></a>`;
                    });
                    html += `</div>`;
                }

                // Matching Products Section
                if (products.length > 0) {
                    html += `<div class="aire-results-section-title">Products</div>`;
                    html += `<div class="aire-results-products-grid">`;
                    products.forEach(function (p) {
                        html += `
                            <a href="${p.url}" class="aire-result-product-card">
                                <img src="${p.image}" alt="${escapeHtml(p.name)}" class="aire-result-product-img" onerror="this.onerror=null;this.src='/themes/default/assets/img/Air-Purify.png';">
                                <div class="aire-result-product-info">
                                    <div class="aire-result-product-title">${escapeHtml(p.name)}</div>
                                    <div class="aire-result-product-meta">
                                        <span class="aire-result-product-badge" style="background-color: ${p.category_bg || '#0066cc'};">${escapeHtml(p.category)}</span>
                                        ${p.model ? `<span>• Model: <strong>${escapeHtml(p.model)}</strong></span>` : ''}
                                    </div>
                                </div>
                                <div class="aire-result-product-price">$${p.price}</div>
                            </a>
                        `;
                    });
                    html += `</div>`;
                }

                // Footer link to full filtered catalog
                html += `
                    <a href="/products-filter?search=${encodeURIComponent(query)}" class="aire-results-footer">
                        See all results for "${escapeHtml(query)}" &rarr;
                    </a>
                `;

                $results.html(html);
            },
            error: function () {
                $results.html('<div class="aire-results-empty text-danger">Search service temporarily unavailable. Please try again.</div>');
            }
        });
    }

    function escapeHtml(text) {
        if (!text) return '';
        return String(text)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }
});
