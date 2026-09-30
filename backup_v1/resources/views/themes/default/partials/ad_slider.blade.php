<div class="featured-card sticky-sidebar bg-white border border-light-subtle shadow-sm rounded-4 ms-3"
    data-lenis-prevent>
    <div class="swiper featured-swiper">
        <div class="swiper-wrapper">
            @forelse ($adSliders as $index => $ad)
                <div class="swiper-slide">
                    <div class="featured-img position-relative">
                        <span
                            class="badge bg-dark position-absolute top-0 start-0 m-3 rounded-0 px-3 py-2 text-uppercase text-white border-0 featured-badge">
                            {{ $ad->subtitle ?: ($ad->badge ?: ($index === 0 ? 'Featured Solution' : ($index === 1 ? 'New Arrival' : 'Commercial'))) }}
                        </span>
                        <img src="{{ !empty($ad->image) ? getImageUrl($ad->image) : theme_asset('img/featured/' . (($index % 3) + 1) . '.png') }}"
                            class="img-fluid w-100" alt="{{ $ad->title ?? 'Featured Ad' }}">
                    </div>
                    <div class="featured-content pb-5">
                        <h3 class="mb-2">{{ $ad->title }}</h3>
                        <p class="text-muted mb-2 lh-base">{{ $ad->description }}</p>
                        <a href="{{ $ad->link ?: route('products.filter') }}"
                            class="btn btn-primary w-100 fw-bold shadow-sm featured-btn text-decoration-none d-inline-block text-center">
                            {{ $ad->button_text ?? ($index === 0 ? 'VIEW PRODUCTS' : ($index === 1 ? 'LEARN MORE' : 'GET A QUOTE')) }}
                        </a>
                    </div>
                </div>
            @empty
            @endforelse
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination position-absolute bottom-2"></div>
    </div>
</div>
