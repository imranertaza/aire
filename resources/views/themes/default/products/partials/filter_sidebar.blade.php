<form action="{{ route('products.filter') }}" method="GET" id="desktopFilterForm">
    @if (request('search'))
        <input type="hidden" name="search" value="{{ request('search') }}">
    @endif
    <div class="filter-sidebar__header">
        <h2 class="filter-sidebar__title">FILTERS</h2>
        <a href="{{ route('products.filter') }}"
            class="filter-sidebar__reset-btn text-decoration-none">RESET ALL</a>
    </div>

    <a href="{{ route('products.filter') }}" class="filter-sidebar__subtitle filter-sidebar__subtitle--link">All
        Products</a>

    @php
        $filterIndex = 1;
        $activeCategory = request('category', $currentCategory->slug ?? ($currentCategory->id ?? 'any'));
        $selectedCats = (array) request('category', []);
        if (empty($selectedCats) && isset($currentCategory) && $currentCategory) {
            $selectedCats = [$currentCategory->slug ?? $currentCategory->id];
        }
        $catType = $filterOptionTypes['Categories'] ?? ($filterOptionTypes['Category'] ?? 'radio');
        $isCatCheckbox = $catType === 'checkbox';
        $hasCatChecked = $isCatCheckbox
            ? !empty($selectedCats)
            : $activeCategory !== 'any' && $activeCategory !== 'all';
    @endphp

    <!-- 1. CATEGORIES -->
    @if (!empty($filterCategories))
        <div class="filter-group {{ $hasCatChecked ? '' : 'collapsed' }}">
            <div class="filter-group__header">
                <h3 class="filter-group__title">CATEGORIES</h3>
                <i class="bi bi-chevron-down filter-group__icon"></i>
            </div>
            <div class="filter-group__content">
                @foreach ($filterCategories as $val => $label)
                    @php
                        $isCatChecked = $isCatCheckbox
                            ? in_array($val, $selectedCats)
                            : $activeCategory == $val ||
                                (isset($currentCategory) &&
                                    ($currentCategory->slug == $val || $currentCategory->id == $val));
                    @endphp
                    <label class="filter-option">
                        <input type="{{ $isCatCheckbox ? 'checkbox' : 'radio' }}"
                            name="{{ $isCatCheckbox ? 'category[]' : 'category' }}" value="{{ $val }}"
                            class="filter-option__input auto-filter-input" {{ $isCatChecked ? 'checked' : '' }}>
                        <span class="filter-option__text">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
        </div>
    @endif

    <!-- DYNAMIC FILTER OPTIONS (Ordered by sort_order with show_in_filter = 1) -->
    @if (!empty($dynamicFilterSections))
        @foreach ($dynamicFilterSections as $section)
            @if (!empty($section['options']))
                <div class="filter-group {{ $section['has_checked'] ? '' : 'collapsed' }}">
                    <div class="filter-group__header">
                        <h3 class="filter-group__title">{{ strtoupper($section['name']) }}</h3>
                        <i class="bi bi-chevron-down filter-group__icon"></i>
                    </div>
                    <div class="filter-group__content">
                        @foreach ($section['options'] as $val => $optData)
                            <label class="filter-option">
                                <input type="{{ $section['is_checkbox'] ? 'checkbox' : 'radio' }}"
                                    name="{{ $section['input_name'] }}" value="{{ $val }}"
                                    class="filter-option__input auto-filter-input"
                                    {{ $optData['is_checked'] ? 'checked' : '' }}>
                                <span class="filter-option__text">{{ $optData['label'] }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    @endif
</form>
