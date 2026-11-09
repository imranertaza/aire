@php
    $s = $block['settings'] ?? $block;
    $items = $s['items'] ?? ($block['items'] ?? []);
    $style = $s['style'] ?? ($block['style'] ?? 'separated'); // 'separated', 'bordered', 'flush'
    $firstOpen = array_key_exists('first_open', $s) ? (bool) $s['first_open'] : (array_key_exists('first_open', $block) ? (bool) $block['first_open'] : true);
    $allowMultiple = !empty($s['allow_multiple']) || !empty($block['allow_multiple']);
    $iconType = $s['icon_type'] ?? ($block['icon_type'] ?? 'chevron'); // 'chevron', 'plus_minus'

    $rawId = $block['id'] ?? uniqid();
    $cleanId = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $rawId);
    $accordionId = 'accordion_' . $cleanId;

    // Visibility
    $vis = $s['visibility'] ?? ($block['visibility'] ?? []);
    $hideClasses = [];
    if (!empty($vis['hideOnMobile']) || !empty($s['hideMobile'])) $hideClasses[] = 'd-none d-md-block';
    if (!empty($vis['hideOnTablet']) || !empty($s['hideTablet'])) $hideClasses[] = 'd-md-none d-lg-block';
    if (!empty($vis['hideOnDesktop']) || !empty($s['hideDesktop'])) $hideClasses[] = 'd-lg-none';
    $hideClassStr = implode(' ', $hideClasses);

    // Margins
    $styles = [];
    $mt = $s['marginTop'] ?? ($block['marginTop'] ?? '');
    $mb = $s['marginBottom'] ?? ($block['marginBottom'] ?? '');
    if ($mt) $styles[] = "margin-top: {$mt};";
    if ($mb) $styles[] = "margin-bottom: {$mb};";
    $styleAttr = !empty($styles) ? 'style="' . implode(' ', $styles) . '"' : '';

    $customClass = $s['custom_class'] ?? ($block['customClass'] ?? '');
    $customId = $s['custom_id'] ?? ($block['customId'] ?? '');
    $customIdAttr = !empty($customId) ? 'id="' . e($customId) . '"' : '';

    // Style-specific classes
    $accordionClass = 'accordion';
    if ($style === 'flush') {
        $accordionClass .= ' accordion-flush';
    } elseif ($style === 'bordered') {
        $accordionClass .= ' border rounded-4 overflow-hidden bg-white shadow-2xs';
    }
@endphp

@once
<style>
    .builder-accordion-separated .accordion-item {
        border: 1px solid #e2e8f0;
        border-radius: 12px !important;
        margin-bottom: 12px;
        background-color: #ffffff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        transition: box-shadow 0.2s ease, border-color 0.2s ease;
    }
    .builder-accordion-separated .accordion-item:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }
    .builder-accordion .accordion-button {
        font-weight: 600;
        color: #1e293b;
        background-color: #ffffff;
        padding: 1rem 1.25rem;
        box-shadow: none !important;
    }
    .builder-accordion .accordion-button:not(.collapsed) {
        color: #0095DA;
        background-color: #f8fafc;
    }
    .builder-accordion .accordion-body {
        padding: 1rem 1.25rem 1.25rem 1.25rem;
        color: #64748b;
        line-height: 1.6;
        font-size: 0.95rem;
    }
    .builder-accordion-plus-minus .accordion-button::after {
        background-image: none !important;
        content: '+';
        font-size: 1.4rem;
        font-weight: 300;
        line-height: 1;
        transform: none !important;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 1.25rem;
        height: 1.25rem;
        color: #64748b;
    }
    .builder-accordion-plus-minus .accordion-button:not(.collapsed)::after {
        content: '−';
        color: #0095DA;
    }
</style>
@endonce

<div {!! $customIdAttr !!} class="builder-block-accordion builder-accordion {{ $style === 'separated' ? 'builder-accordion-separated' : '' }} {{ $iconType === 'plus_minus' ? 'builder-accordion-plus-minus' : '' }} {{ $hideClassStr }} {{ $customClass }}" {!! $styleAttr !!}>
    @if (!empty($items))
        <div class="{{ $accordionClass }}" id="{{ $accordionId }}">
            @foreach ($items as $idx => $item)
                @php
                    $itemId = $cleanId . '_item_' . $idx;
                    $isOpen = ($idx === 0 && $firstOpen);
                    $title = $item['title'] ?? ('Question #' . ($idx + 1));
                    $content = $item['content'] ?? '';
                @endphp
                <div class="accordion-item {{ $style === 'bordered' && $idx === 0 ? 'border-top-0' : '' }}">
                    <h3 class="accordion-header" id="heading_{{ $itemId }}">
                        <button
                            class="accordion-button {{ !$isOpen ? 'collapsed' : '' }}"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapse_{{ $itemId }}"
                            aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
                            aria-controls="collapse_{{ $itemId }}"
                        >
                            {{ $title }}
                        </button>
                    </h3>
                    <div
                        id="collapse_{{ $itemId }}"
                        class="accordion-collapse collapse {{ $isOpen ? 'show' : '' }}"
                        aria-labelledby="heading_{{ $itemId }}"
                        @if (!$allowMultiple) data-bs-parent="#{{ $accordionId }}" @endif
                    >
                        <div class="accordion-body">
                            {!! nl2br(e($content)) !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-4 text-muted bg-light rounded-4 border">
            <i class="far fa-question-circle fa-2x mb-2 text-secondary opacity-50"></i>
            <p class="small mb-0">No accordion items added yet. Click to configure questions in the inspector.</p>
        </div>
    @endif
</div>
