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

    // 3. Floating Live Dynamic Search
    let searchDebounceTimer = null;

    function ensureSearchElements() {
        if ($('.search-backdrop').length === 0) {
            $('body').append('<div class="search-backdrop"></div>');
        }

        if ($('.search-floating-card').length === 0) {
            var cardHtml = `
                <div class="search-floating-card" data-lenis-prevent>
                    <form class="search-floating-bar" action="/product-filter" method="GET">
                        <input type="search" name="search" class="search-floating-input" placeholder="Search products, models, categories..." autocomplete="off" autofocus>
                        <button type="submit" class="search-floating-btn" aria-label="Search">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path d="M18.031 16.617L22.314 20.899L20.899 22.314L16.617 18.031C15.0237 19.3082 13.042 20.0029 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20.0029 13.042 19.3082 15.0237 18.031 16.617ZM16.025 15.875C17.2938 14.5697 18.0025 12.8204 18 11C18 7.133 14.867 4 11 4C7.133 4 4 7.133 4 11C4 14.867 7.133 18 11 18C12.8204 18.0025 14.5697 17.2938 15.875 16.025L16.025 15.875Z" fill="currentColor"/>
                            </svg>
                        </button>
                    </form>
                    <div class="search-floating-results" data-lenis-prevent></div>
                </div>`;
            $('body').append(cardHtml);
        }
    }

    function openSearch() {
        ensureSearchElements();

        const $backdrop = $('.search-backdrop');
        const $card = $('.search-floating-card');
        const $input = $('.search-floating-input');

        $backdrop.addClass('show');
        $card.addClass('show');

        // Immediate + staggered autofocus so browser never drops focus
        const focusInput = function () {
            if ($input.length && $card.hasClass('show')) {
                $input[0].focus({ preventScroll: true });
                $input.select();
            }
        };

        focusInput();
        requestAnimationFrame(focusInput);
        setTimeout(focusInput, 30);
        setTimeout(focusInput, 100);
        setTimeout(focusInput, 200);
    }

    function closeSearch() {
        $('.search-floating-card').removeClass('show has-results');
        $('.search-backdrop').removeClass('show');
        $('.search-floating-results').empty().hide();
        $('.search-floating-input').val('').blur();
    }

    // Toggle button click
    $(document).on('click', '[data-search-toggle]', function (e) {
        e.preventDefault();
        e.stopPropagation();
        if ($('.search-floating-card').hasClass('show')) {
            closeSearch();
        } else {
            openSearch();
        }
    });

    // Close on backdrop click
    $(document).on('click', '.search-backdrop', function (e) {
        e.preventDefault();
        closeSearch();
    });

    // Global keyboard handling
    $(document).on('keydown', function (e) {
        const isSearchOpen = $('.search-floating-card').hasClass('show');
        const activeTagName = document.activeElement ? document.activeElement.tagName.toLowerCase() : '';
        const isTypingInOtherInput = ['input', 'textarea', 'select'].includes(activeTagName) && !$(document.activeElement).hasClass('search-floating-input');

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

        // If search is open but input somehow lost focus, redirect alphanumeric key to search input
        if (isSearchOpen && !$(document.activeElement).hasClass('search-floating-input') && !e.ctrlKey && !e.metaKey && !e.altKey) {
            if (e.key.length === 1 || e.key === 'Backspace') {
                const $input = $('.search-floating-input');
                $input.focus();
            }
        }
    });

    // Live Dynamic Search Input Handler
    $(document).on('input', '.search-floating-input', function () {
        const query = $(this).val().trim();
        const $card = $('.search-floating-card');
        const $results = $('.search-floating-results');

        clearTimeout(searchDebounceTimer);

        if (query.length < 2) {
            $card.removeClass('has-results');
            $results.empty().hide();
            return;
        }

        $card.addClass('has-results');
        $results.show().html('<div class="search-floating-loading"><i class="spinner-border spinner-border-sm text-primary me-2"></i>Searching clean air systems...</div>');

        searchDebounceTimer = setTimeout(function () {
            fetchLiveSearchResults(query, $card, $results);
        }, 180);
    });

    function fetchLiveSearchResults(query, $card, $results) {
        $.ajax({
            url: '/products-dropdown',
            method: 'GET',
            data: { search: query, limit: 6 },
            dataType: 'json',
            success: function (res) {
                const products = res.products || res.data || [];
                const categories = res.categories || [];

                if (products.length === 0 && categories.length === 0) {
                    $results.html(`
                        <div class="search-floating-empty">
                            <i class="bi bi-wind fs-3 d-block text-muted mb-2"></i>
                            No products found matching "<strong>${escapeHtml(query)}</strong>"
                        </div>
                    `);
                    return;
                }

                let html = '';

                // Matching Categories Section
                if (categories.length > 0) {
                    html += `<div class="search-floating-section-title">Matching Categories</div>`;
                    html += `<div class="search-floating-categories">`;
                    categories.forEach(function (cat) {
                        html += `<a href="${cat.url}" class="search-floating-cat-pill">${escapeHtml(cat.name)}</a>`;
                    });
                    html += `</div>`;
                }

                // Matching Products Section
                if (products.length > 0) {
                    html += `<div class="search-floating-section-title">Products</div>`;
                    products.forEach(function (p) {
                        html += `
                            <a href="${p.url}" class="search-floating-item">
                                <img src="${p.image}" alt="${escapeHtml(p.name)}" class="search-floating-item-img">
                                <div class="search-floating-item-info">
                                    <div class="search-floating-item-title">${escapeHtml(p.name)}</div>
                                    <div class="search-floating-item-meta">
                                        <span class="search-floating-item-cat" style="background-color: ${p.category_bg || '#0066cc'};">${escapeHtml(p.category)}</span>
                                        ${p.model ? `<span>• ${escapeHtml(p.model)}</span>` : ''}
                                    </div>
                                </div>
                                <div class="search-floating-item-price">$${p.price}</div>
                            </a>
                        `;
                    });
                }

                // Footer link to full filtered catalog
                html += `
                    <a href="/product-filter?search=${encodeURIComponent(query)}" class="search-floating-footer">
                        See all results for "${escapeHtml(query)}" &rarr;
                    </a>
                `;

                $results.html(html);
            },
            error: function () {
                $results.html('<div class="search-floating-empty text-danger">Search service unavailable. Please try again.</div>');
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
