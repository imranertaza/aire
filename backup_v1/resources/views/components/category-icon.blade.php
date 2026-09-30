@props(['category', 'fallback' => 'bi bi-box'])

@if (is_object($category) && method_exists($category, 'renderIcon'))
    {!! $category->renderIcon($fallback) !!}
@elseif (is_object($category))
    @if (!empty($category->icon_class) && str_contains($category->icon_class, '<svg'))
        {!! $category->icon_class !!}
    @elseif(!empty($category->icon_class))
        <i class="{{ $category->icon_class }}"></i>
    @elseif(!empty($category->icon?->code))
        {!! $category->icon->code !!}
    @else
        <i class="{{ $fallback }}"></i>
    @endif
@endif
