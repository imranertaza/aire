<template>
    <div class="tab-pane fade" id="custom-tabs-showcase" role="tabpanel"
        aria-labelledby="tab-showcase">
        
        <div class="alert alert-info py-2 px-3 mb-3 d-flex flex-wrap align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle mr-2 fa-lg"></i>
                <span>Configure custom header text, badges, imagery, specs, and detailed modal features with <strong>Real-Time Live Preview</strong>.</span>
            </div>
            <div class="d-flex align-items-center mt-2 mt-md-0">
                <button type="button" class="btn btn-sm font-weight-bold"
                    :class="showLivePreview ? 'btn-outline-secondary bg-white' : 'btn-success text-white shadow-sm'"
                    @click="showLivePreview = !showLivePreview">
                    <i class="fas" :class="showLivePreview ? 'fa-eye-slash mr-1' : 'fa-eye mr-1'"></i>
                    {{ showLivePreview ? 'Hide Live Preview' : 'Show Live Preview' }}
                </button>
            </div>
        </div>

        <!-- 12-Column Real-Time Live Preview at Top (Collapsible) -->
        <div v-show="showLivePreview" class="row mb-4">
            <div class="col-12">
                <div class="card card-outline card-primary shadow-sm mb-0">
                    <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center py-2 px-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-desktop text-primary mr-2"></i>
                            <span class="font-weight-bold text-dark">Real-Time Live Preview (12-Col Full Width)</span>
                        </div>
                        <div class="d-flex align-items-center mt-2 mt-md-0">
                            <div class="btn-group btn-group-sm mr-2" role="group">
                                <button type="button" class="btn"
                                    :class="previewDevice === 'desktop' ? 'btn-dark' : 'btn-outline-secondary'"
                                    @click="previewDevice = 'desktop'" title="Preview Desktop (2-Column Showcase Card)">
                                    <i class="fas fa-desktop mr-1"></i> Desktop
                                </button>
                                <button type="button" class="btn"
                                    :class="previewDevice === 'mobile' ? 'btn-dark' : 'btn-outline-secondary'"
                                    @click="previewDevice = 'mobile'" title="Preview Mobile (Stacked Card)">
                                    <i class="fas fa-mobile-alt mr-1"></i> Mobile
                                </button>
                            </div>
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn"
                                    :class="previewMode === 'card' ? 'btn-primary' : 'btn-outline-secondary'"
                                    @click="previewMode = 'card'">
                                    <i class="fas fa-id-card mr-1"></i> Card Only
                                </button>
                                <button type="button" class="btn"
                                    :class="previewMode === 'modal' ? 'btn-primary' : 'btn-outline-secondary'"
                                    @click="previewMode = 'modal'">
                                    <i class="fas fa-window-maximize mr-1"></i> Modal Only
                                </button>
                                <button type="button" class="btn"
                                    :class="previewMode === 'both' ? 'btn-primary' : 'btn-outline-secondary'"
                                    @click="previewMode = 'both'">
                                    <i class="fas fa-columns mr-1"></i> Side-by-Side (Both)
                                </button>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary ml-2"
                                @click="showLivePreview = false" title="Hide Preview">
                                <i class="fas fa-chevron-up"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body bg-light p-3 p-md-4">
                        <!-- 1. Card Only View -->
                        <div v-if="previewMode === 'card'" class="d-flex justify-content-center py-2">
                            <div :style="{ width: '100%', maxWidth: previewDevice === 'mobile' ? '440px' : '920px' }">
                                <div class="ductless-showcase-card" :class="{ 'ductless-preview--mobile': previewDevice === 'mobile' }">
                                    <!-- Top Hero Section -->
                                    <div class="ductless-showcase-card__hero"
                                        :style="{ backgroundImage: `url('${previewHeroBgImage}')` }">
                                        <!-- Badges -->
                                        <div class="ductless-showcase-card__badges">
                                            <span class="ductless-badge ductless-badge--residential">
                                                <i class="bi bi-house"></i>
                                                <span>{{ formData.showcase_badge_residential || 'Residential' }}</span>
                                            </span>
                                            <span class="ductless-badge ductless-badge--fresh-air">
                                                <i class="bi bi-wind"></i>
                                                <span>{{ formData.showcase_badge_fresh_air || 'Small Fresh Air' }}</span>
                                            </span>
                                        </div>

                                        <!-- Actions -->
                                        <div class="ductless-showcase-card__actions">
                                            <button type="button" class="ductless-action-btn" title="Add to Cart">
                                                <i class="bi bi-cart3"></i>
                                            </button>
                                            <button type="button" class="ductless-action-btn" title="Compare">
                                                <i class="bi bi-arrow-left-right"></i>
                                            </button>
                                            <button type="button" class="ductless-action-btn" title="Add to Wishlist">
                                                <i class="bi bi-heart"></i>
                                            </button>
                                        </div>

                                        <!-- Title & Subtitle -->
                                        <div class="ductless-showcase-card__header">
                                            <h2 class="ductless-showcase-card__title">
                                                {{ formData.showcase_title || formData.name || 'Single Room Ductless' }}
                                            </h2>
                                            <p class="ductless-showcase-card__subtitle" :title="formData.showcase_subtitle">
                                                {{ formData.showcase_subtitle || 'Compact & powerful fresh air solution' }}
                                            </p>
                                        </div>

                                        <!-- Feature Pills -->
                                        <div class="ductless-showcase-card__pills">
                                            <template v-if="formData.showcase_feature_pills && formData.showcase_feature_pills.length > 0">
                                                <div v-for="(pill, pIdx) in formData.showcase_feature_pills" :key="pIdx"
                                                    class="ductless-pill" :class="{ 'ductless-pill--dual': pill.subtext }">
                                                    <i class="ductless-pill__icon" :class="pill.icon || 'bi bi-check-circle'"></i>
                                                    <div v-if="pill.subtext" class="ductless-pill__dual-text">
                                                        <span class="ductless-pill__dual-main">{{ pill.text }}</span>
                                                        <span class="ductless-pill__dual-sub">{{ pill.subtext }}</span>
                                                    </div>
                                                    <span v-else class="ductless-pill__text">{{ pill.text }}</span>
                                                </div>
                                            </template>
                                            <template v-else>
                                                <div class="ductless-pill"><i class="bi bi-arrows-fullscreen ductless-pill__icon"></i><span class="ductless-pill__text">200–500 sq ft</span></div>
                                                <div class="ductless-pill"><i class="bi bi-arrow-repeat ductless-pill__icon"></i><span class="ductless-pill__text">Heat Recovery 70%</span></div>
                                                <div class="ductless-pill"><i class="bi bi-shield-check ductless-pill__icon"></i><span class="ductless-pill__text">PM 2.5 99%</span></div>
                                                <div class="ductless-pill ductless-pill--dual"><i class="bi bi-wind ductless-pill__icon"></i><div class="ductless-pill__dual-text"><span class="ductless-pill__dual-main">100% Fresh Air</span><span class="ductless-pill__dual-sub">No Recycled Air</span></div></div>
                                            </template>
                                        </div>

                                        <!-- Quick View Button -->
                                        <button type="button" class="ductless-quickview-btn border-0" @click="previewMode = 'modal'" title="Click to preview Modal">
                                            <i class="bi bi-eye"></i>
                                            <span>Quick View</span>
                                            <i class="bi bi-chevron-right"></i>
                                        </button>
                                    </div>

                                    <!-- Bottom Body -->
                                    <div class="ductless-showcase-card__body">
                                        <div class="ductless-diagram-box">
                                            <div class="ductless-diagram-box__meta">
                                                <span class="ductless-diagram-box__brand">{{ formData.showcase_diagram_brand || 'BROAD' }}</span>
                                                <h3 class="ductless-diagram-box__model">{{ formData.name || formData.showcase_diagram_model || 'Product Name' }}</h3>
                                                <p class="ductless-diagram-box__system" :title="formData.description || formData.showcase_diagram_system">
                                                    {{ formData.description || formData.showcase_diagram_system || 'Compact Fresh Air System' }}
                                                </p>
                                            </div>
                                            <div class="ductless-diagram-box__illustration">
                                                <img :src="previewDiagramImage" alt="Diagram" class="ductless-diagram-img" />
                                            </div>
                                        </div>

                                        <!-- Specs Bar -->
                                        <div class="ductless-specs-bar">
                                            <div class="ductless-spec-item">
                                                <div class="ductless-spec-item__value">
                                                    <i class="bi bi-box"></i>
                                                    <span>{{ formData.showcase_airflow || '100 m³/h' }}</span>
                                                </div>
                                                <span class="ductless-spec-item__label">Airflow</span>
                                            </div>
                                            <div class="ductless-specs-bar__divider"></div>
                                            <div class="ductless-spec-item">
                                                <div class="ductless-spec-item__value">
                                                    <i class="bi bi-lightning-charge"></i>
                                                    <span>{{ formData.showcase_power || '25 W' }}</span>
                                                </div>
                                                <span class="ductless-spec-item__label">Power</span>
                                            </div>
                                            <div class="ductless-specs-bar__divider"></div>
                                            <div class="ductless-spec-item">
                                                <div class="ductless-spec-item__value">
                                                    <i class="bi bi-house-door"></i>
                                                    <span>{{ formData.showcase_coverage_area || '30–50 m²' }}</span>
                                                </div>
                                                <span class="ductless-spec-item__label">Apartment</span>
                                            </div>
                                        </div>

                                        <!-- Footer -->
                                        <div class="ductless-card-footer">
                                            <button type="button" class="ductless-buy-btn">
                                                <span>Buy</span>
                                                <i class="bi bi-arrow-right"></i>
                                            </button>
                                            <div class="ductless-price-wrap">
                                                <div class="ductless-price">${{ formData.price || '0.00' }}</div>
                                                <span class="ductless-learn-more">
                                                    <span>Learn more</span>
                                                    <i class="bi bi-chevron-right"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Modal Only View -->
                        <div v-if="previewMode === 'modal'" class="py-2">
                            <div class="ductless-modal__content rounded shadow-sm border p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                                    <span class="badge badge-primary"><i class="fas fa-window-maximize mr-1"></i> Quick View Modal Preview</span>
                                    <button type="button" class="btn btn-xs btn-outline-secondary" @click="previewMode = 'card'">
                                        <i class="fas fa-times mr-1"></i> Back to Card View
                                    </button>
                                </div>
                                <div class="row g-4 align-items-center">
                                    <div class="col-lg-5">
                                        <div class="ductless-modal__image-wrapper rounded"
                                            :style="{ backgroundImage: `url('${previewHeroBgImage}')` }"></div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="ductless-modal__info">
                                            <div class="d-flex align-items-center justify-content-between mb-1 mt-1">
                                                <span class="ductless-modal__brand">{{ formData.showcase_diagram_brand || 'AIRE' }}</span>
                                                <span class="ductless-modal__series-badge">{{ formData.showcase_series_badge || 'PRO S1 SERIES' }}</span>
                                            </div>
                                            <h2 class="ductless-modal__title">{{ formData.name || 'Product Name' }}</h2>
                                            <h3 class="ductless-modal__subtitle">{{ formData.showcase_modal_subtitle || formData.showcase_subtitle || 'Single Room Ductless Fresh Air Ventilator' }}</h3>
                                            <p class="ductless-modal__desc">{{ formData.description || 'Brings in 100% outdoor air, filters with HEPA, and recovers heat to provide clean indoor air.' }}</p>

                                            <!-- 4-Column Specs Grid -->
                                            <div class="ductless-modal__specs-grid">
                                                <template v-if="formData.showcase_spec_highlights && formData.showcase_spec_highlights.length > 0">
                                                    <div v-for="(spec, sIdx) in formData.showcase_spec_highlights" :key="sIdx" class="ductless-modal__spec-col">
                                                        <i :class="spec.icon || 'bi bi-gear'" style="font-size: 16px; color: #334155;"></i>
                                                        <span class="ductless-modal__spec-label">{{ spec.label }}</span>
                                                        <span class="ductless-modal__spec-value">{{ spec.value }}</span>
                                                    </div>
                                                </template>
                                                <template v-else>
                                                    <div class="ductless-modal__spec-col"><i class="bi bi-wind" style="font-size: 16px; color: #334155;"></i><span class="ductless-modal__spec-label">Airflow</span><span class="ductless-modal__spec-value">100 m³/h</span></div>
                                                    <div class="ductless-modal__spec-col"><i class="bi bi-lightning-charge" style="font-size: 16px; color: #334155;"></i><span class="ductless-modal__spec-label">Power</span><span class="ductless-modal__spec-value">25 W</span></div>
                                                    <div class="ductless-modal__spec-col"><i class="bi bi-soundwave" style="font-size: 16px; color: #334155;"></i><span class="ductless-modal__spec-label">Noise</span><span class="ductless-modal__spec-value">&lt; 28 dB</span></div>
                                                    <div class="ductless-modal__spec-col"><i class="bi bi-arrows-fullscreen" style="font-size: 16px; color: #334155;"></i><span class="ductless-modal__spec-label">Area</span><span class="ductless-modal__spec-value">30–50 m²</span></div>
                                                </template>
                                            </div>

                                            <!-- Matched Checklist -->
                                            <div class="ductless-modal__matched-section">
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <span class="ductless-modal__matched-title">Matched to your needs</span>
                                                    <span class="ductless-modal__matched-sub">Based on filters</span>
                                                </div>
                                                <div class="ductless-modal__pill-wrap" style="grid-template-columns: repeat(3, 1fr);">
                                                    <template v-if="formData.showcase_matched_features && formData.showcase_matched_features.length > 0">
                                                        <div v-for="(feat, fIdx) in formData.showcase_matched_features" :key="fIdx" class="ductless-modal__pill text-truncate">
                                                            <i :class="feat.icon || 'bi bi-check2'"></i>
                                                            <span class="text-truncate">{{ feat.text }}</span>
                                                            <span class="ductless-modal__check ml-auto"><i class="bi bi-check-lg"></i></span>
                                                        </div>
                                                    </template>
                                                    <template v-else>
                                                        <div class="ductless-modal__pill"><i class="bi bi-house"></i><span>Residential</span><span class="ductless-modal__check ml-auto"><i class="bi bi-check-lg"></i></span></div>
                                                        <div class="ductless-modal__pill"><i class="bi bi-wind"></i><span>Fresh Air</span><span class="ductless-modal__check ml-auto"><i class="bi bi-check-lg"></i></span></div>
                                                        <div class="ductless-modal__pill"><i class="bi bi-shield-check"></i><span>HEPA PM2.5</span><span class="ductless-modal__check ml-auto"><i class="bi bi-check-lg"></i></span></div>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Footer Row -->
                                <div class="ductless-modal__footer mt-3 pt-3">
                                    <div class="ductless-modal__health-tags">
                                        <template v-if="formData.showcase_health_tags && formData.showcase_health_tags.length > 0">
                                            <span v-for="(htag, hIdx) in formData.showcase_health_tags" :key="hIdx" class="ductless-modal__health-tag">
                                                <i :class="htag.icon || 'bi bi-check-circle'"></i> {{ htag.text }}
                                            </span>
                                        </template>
                                        <template v-else>
                                            <span class="ductless-modal__health-tag"><i class="bi bi-shield-check"></i> PM2.5: 99.9%</span>
                                            <span class="ductless-modal__health-tag"><i class="bi bi-heart-pulse"></i> HCHO: 65 m³/h</span>
                                        </template>
                                    </div>
                                    <div class="ductless-modal__cta-wrap">
                                        <button type="button" class="ductless-modal__btn-view">View Product</button>
                                        <button type="button" class="ductless-modal__btn-compare">Compare</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Side-by-Side (Both Card & Modal) View -->
                        <div v-if="previewMode === 'both'" class="py-2">
                            <div class="row g-4 align-items-start">
                                <!-- Card (Left) -->
                                <div class="col-lg-5 mb-4 mb-lg-0">
                                    <div class="text-muted small font-weight-bold mb-2">
                                        <i class="fas fa-id-card mr-1"></i> Showcase Card
                                    </div>
                                    <div class="ductless-showcase-card" :class="{ 'ductless-preview--mobile': previewDevice === 'mobile' }">
                                        <!-- Top Hero Section -->
                                        <div class="ductless-showcase-card__hero"
                                            :style="{ backgroundImage: `url('${previewHeroBgImage}')` }">
                                            <!-- Badges -->
                                            <div class="ductless-showcase-card__badges">
                                                <span class="ductless-badge ductless-badge--residential">
                                                    <i class="bi bi-house"></i>
                                                    <span>{{ formData.showcase_badge_residential || 'Residential' }}</span>
                                                </span>
                                                <span class="ductless-badge ductless-badge--fresh-air">
                                                    <i class="bi bi-wind"></i>
                                                    <span>{{ formData.showcase_badge_fresh_air || 'Small Fresh Air' }}</span>
                                                </span>
                                            </div>

                                            <!-- Actions -->
                                            <div class="ductless-showcase-card__actions">
                                                <button type="button" class="ductless-action-btn" title="Add to Cart">
                                                    <i class="bi bi-cart3"></i>
                                                </button>
                                                <button type="button" class="ductless-action-btn" title="Compare">
                                                    <i class="bi bi-arrow-left-right"></i>
                                                </button>
                                                <button type="button" class="ductless-action-btn" title="Add to Wishlist">
                                                    <i class="bi bi-heart"></i>
                                                </button>
                                            </div>

                                            <!-- Title & Subtitle -->
                                            <div class="ductless-showcase-card__header">
                                                <h2 class="ductless-showcase-card__title">
                                                    {{ formData.showcase_title || formData.name || 'Single Room Ductless' }}
                                                </h2>
                                                <p class="ductless-showcase-card__subtitle" :title="formData.showcase_subtitle">
                                                    {{ formData.showcase_subtitle || 'Compact & powerful fresh air solution' }}
                                                </p>
                                            </div>

                                            <!-- Feature Pills -->
                                            <div class="ductless-showcase-card__pills">
                                                <template v-if="formData.showcase_feature_pills && formData.showcase_feature_pills.length > 0">
                                                    <div v-for="(pill, pIdx) in formData.showcase_feature_pills" :key="pIdx"
                                                        class="ductless-pill" :class="{ 'ductless-pill--dual': pill.subtext }">
                                                        <i class="ductless-pill__icon" :class="pill.icon || 'bi bi-check-circle'"></i>
                                                        <div v-if="pill.subtext" class="ductless-pill__dual-text">
                                                            <span class="ductless-pill__dual-main">{{ pill.text }}</span>
                                                            <span class="ductless-pill__dual-sub">{{ pill.subtext }}</span>
                                                        </div>
                                                        <span v-else class="ductless-pill__text">{{ pill.text }}</span>
                                                    </div>
                                                </template>
                                                <template v-else>
                                                    <div class="ductless-pill"><i class="bi bi-arrows-fullscreen ductless-pill__icon"></i><span class="ductless-pill__text">200–500 sq ft</span></div>
                                                    <div class="ductless-pill"><i class="bi bi-arrow-repeat ductless-pill__icon"></i><span class="ductless-pill__text">Heat Recovery 70%</span></div>
                                                    <div class="ductless-pill"><i class="bi bi-shield-check ductless-pill__icon"></i><span class="ductless-pill__text">PM 2.5 99%</span></div>
                                                    <div class="ductless-pill ductless-pill--dual"><i class="bi bi-wind ductless-pill__icon"></i><div class="ductless-pill__dual-text"><span class="ductless-pill__dual-main">100% Fresh Air</span><span class="ductless-pill__dual-sub">No Recycled Air</span></div></div>
                                                </template>
                                            </div>

                                            <!-- Quick View Button -->
                                            <button type="button" class="ductless-quickview-btn border-0" @click="previewMode = 'modal'" title="Click to preview Modal">
                                                <i class="bi bi-eye"></i>
                                                <span>Quick View</span>
                                                <i class="bi bi-chevron-right"></i>
                                            </button>
                                        </div>

                                        <!-- Bottom Body -->
                                        <div class="ductless-showcase-card__body">
                                            <div class="ductless-diagram-box">
                                                <div class="ductless-diagram-box__meta">
                                                    <span class="ductless-diagram-box__brand">{{ formData.showcase_diagram_brand || 'BROAD' }}</span>
                                                    <h3 class="ductless-diagram-box__model">{{ formData.name || formData.showcase_diagram_model || 'Product Name' }}</h3>
                                                    <p class="ductless-diagram-box__system" :title="formData.description || formData.showcase_diagram_system">
                                                        {{ formData.description || formData.showcase_diagram_system || 'Compact Fresh Air System' }}
                                                    </p>
                                                </div>
                                                <div class="ductless-diagram-box__illustration">
                                                    <img :src="previewDiagramImage" alt="Diagram" class="ductless-diagram-img" />
                                                </div>
                                            </div>

                                            <!-- Specs Bar -->
                                            <div class="ductless-specs-bar">
                                                <div class="ductless-spec-item">
                                                    <div class="ductless-spec-item__value">
                                                        <i class="bi bi-box"></i>
                                                        <span>{{ formData.showcase_airflow || '100 m³/h' }}</span>
                                                    </div>
                                                    <span class="ductless-spec-item__label">Airflow</span>
                                                </div>
                                                <div class="ductless-specs-bar__divider"></div>
                                                <div class="ductless-spec-item">
                                                    <div class="ductless-spec-item__value">
                                                        <i class="bi bi-lightning-charge"></i>
                                                        <span>{{ formData.showcase_power || '25 W' }}</span>
                                                    </div>
                                                    <span class="ductless-spec-item__label">Power</span>
                                                </div>
                                                <div class="ductless-specs-bar__divider"></div>
                                                <div class="ductless-spec-item">
                                                    <div class="ductless-spec-item__value">
                                                        <i class="bi bi-house-door"></i>
                                                        <span>{{ formData.showcase_coverage_area || '30–50 m²' }}</span>
                                                    </div>
                                                    <span class="ductless-spec-item__label">Apartment</span>
                                                </div>
                                            </div>

                                            <!-- Footer -->
                                            <div class="ductless-card-footer">
                                                <button type="button" class="ductless-buy-btn">
                                                    <span>Buy</span>
                                                    <i class="bi bi-arrow-right"></i>
                                                </button>
                                                <div class="ductless-price-wrap">
                                                    <div class="ductless-price">${{ formData.price || '0.00' }}</div>
                                                    <span class="ductless-learn-more">
                                                        <span>Learn more</span>
                                                        <i class="bi bi-chevron-right"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal (Right) -->
                                <div class="col-lg-7">
                                    <div class="text-muted small font-weight-bold mb-2">
                                        <i class="fas fa-window-maximize mr-1"></i> Quick View Modal
                                    </div>
                                    <div class="ductless-modal__content rounded shadow-sm border p-3">
                                        <div class="row g-3">
                                            <div class="col-md-5">
                                                <div class="ductless-modal__image-wrapper rounded"
                                                    :style="{ backgroundImage: `url('${previewHeroBgImage}')` }"></div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="ductless-modal__info">
                                                    <div class="d-flex align-items-center justify-content-between mb-1 mt-1">
                                                        <span class="ductless-modal__brand">{{ formData.showcase_diagram_brand || 'AIRE' }}</span>
                                                        <span class="ductless-modal__series-badge">{{ formData.showcase_series_badge || 'PRO S1 SERIES' }}</span>
                                                    </div>
                                                    <h2 class="ductless-modal__title">{{ formData.name || 'Product Name' }}</h2>
                                                    <h3 class="ductless-modal__subtitle">{{ formData.showcase_modal_subtitle || formData.showcase_subtitle || 'Single Room Ductless Fresh Air Ventilator' }}</h3>
                                                    <p class="ductless-modal__desc">{{ formData.description || 'Brings in 100% outdoor air, filters with HEPA, and recovers heat to provide clean indoor air.' }}</p>

                                                    <!-- 4-Column Specs Grid -->
                                                    <div class="ductless-modal__specs-grid">
                                                        <template v-if="formData.showcase_spec_highlights && formData.showcase_spec_highlights.length > 0">
                                                            <div v-for="(spec, sIdx) in formData.showcase_spec_highlights" :key="sIdx" class="ductless-modal__spec-col">
                                                                <i :class="spec.icon || 'bi bi-gear'" style="font-size: 16px; color: #334155;"></i>
                                                                <span class="ductless-modal__spec-label">{{ spec.label }}</span>
                                                                <span class="ductless-modal__spec-value">{{ spec.value }}</span>
                                                            </div>
                                                        </template>
                                                        <template v-else>
                                                            <div class="ductless-modal__spec-col"><i class="bi bi-wind" style="font-size: 16px; color: #334155;"></i><span class="ductless-modal__spec-label">Airflow</span><span class="ductless-modal__spec-value">100 m³/h</span></div>
                                                            <div class="ductless-modal__spec-col"><i class="bi bi-lightning-charge" style="font-size: 16px; color: #334155;"></i><span class="ductless-modal__spec-label">Power</span><span class="ductless-modal__spec-value">25 W</span></div>
                                                            <div class="ductless-modal__spec-col"><i class="bi bi-soundwave" style="font-size: 16px; color: #334155;"></i><span class="ductless-modal__spec-label">Noise</span><span class="ductless-modal__spec-value">&lt; 28 dB</span></div>
                                                            <div class="ductless-modal__spec-col"><i class="bi bi-arrows-fullscreen" style="font-size: 16px; color: #334155;"></i><span class="ductless-modal__spec-label">Area</span><span class="ductless-modal__spec-value">30–50 m²</span></div>
                                                        </template>
                                                    </div>

                                                    <!-- Matched Checklist -->
                                                    <div class="ductless-modal__matched-section">
                                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                                            <span class="ductless-modal__matched-title">Matched to your needs</span>
                                                            <span class="ductless-modal__matched-sub">Based on filters</span>
                                                        </div>
                                                        <div class="ductless-modal__pill-wrap" style="grid-template-columns: repeat(2, 1fr);">
                                                            <template v-if="formData.showcase_matched_features && formData.showcase_matched_features.length > 0">
                                                                <div v-for="(feat, fIdx) in formData.showcase_matched_features" :key="fIdx" class="ductless-modal__pill text-truncate">
                                                                    <i :class="feat.icon || 'bi bi-check2'"></i>
                                                                    <span class="text-truncate">{{ feat.text }}</span>
                                                                    <span class="ductless-modal__check ml-auto"><i class="bi bi-check-lg"></i></span>
                                                                </div>
                                                            </template>
                                                            <template v-else>
                                                                <div class="ductless-modal__pill"><i class="bi bi-house"></i><span>Residential</span><span class="ductless-modal__check ml-auto"><i class="bi bi-check-lg"></i></span></div>
                                                                <div class="ductless-modal__pill"><i class="bi bi-wind"></i><span>Fresh Air</span><span class="ductless-modal__check ml-auto"><i class="bi bi-check-lg"></i></span></div>
                                                            </template>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Footer Row -->
                                        <div class="ductless-modal__footer mt-3 pt-3">
                                            <div class="ductless-modal__health-tags">
                                                <template v-if="formData.showcase_health_tags && formData.showcase_health_tags.length > 0">
                                                    <span v-for="(htag, hIdx) in formData.showcase_health_tags" :key="hIdx" class="ductless-modal__health-tag">
                                                        <i :class="htag.icon || 'bi bi-check-circle'"></i> {{ htag.text }}
                                                    </span>
                                                </template>
                                                <template v-else>
                                                    <span class="ductless-modal__health-tag"><i class="bi bi-shield-check"></i> PM2.5: 99.9%</span>
                                                    <span class="ductless-modal__health-tag"><i class="bi bi-heart-pulse"></i> HCHO: 65 m³/h</span>
                                                </template>
                                            </div>
                                            <div class="ductless-modal__cta-wrap">
                                                <button type="button" class="ductless-modal__btn-view">View Product</button>
                                                <button type="button" class="ductless-modal__btn-compare">Compare</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- 12-Column Form Sections Below Preview -->
        <div class="row">
            <div class="col-12">

                <!-- 1. Header & Badges -->
                <div class="card card-outline card-secondary mb-4 shadow-sm">
                    <div class="card-header bg-light">
                        <h3 class="card-title font-weight-bold text-dark mb-0">
                            <i class="fas fa-heading mr-1 text-primary"></i> 1. Card Header & Badges
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Card Title</label>
                                <input type="text" class="form-control" v-model="formData.showcase_title"
                                    placeholder="e.g. Single Room Ductless" />
                                <small class="text-muted">Appears as the main title on the showcase card header.</small>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Card Subtitle (Max 36-60 chars)</label>
                                <input type="text" class="form-control" v-model="formData.showcase_subtitle"
                                    placeholder="e.g. Compact and powerful room purifiers" />
                                <small class="text-muted">Short one-line description displayed right below the card title.</small>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="font-weight-bold text-primary"><i class="fas fa-window-maximize mr-1"></i> Quick View Modal Subtitle</label>
                                <input type="text" class="form-control" v-model="formData.showcase_modal_subtitle"
                                    placeholder="e.g. Single Room Ductless Fresh Air Ventilator" />
                                <small class="text-muted">Displayed directly under the product name inside the Quick View Modal popup.</small>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Series Badge</label>
                                <input type="text" class="form-control" v-model="formData.showcase_series_badge"
                                    placeholder="e.g. PRO S1 SERIES" />
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Badge 1 (Primary Category/Tag)</label>
                                <input type="text" class="form-control" v-model="formData.showcase_badge_residential"
                                    placeholder="e.g. Residential" />
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Badge 2 (Secondary Category/Tag)</label>
                                <input type="text" class="form-control" v-model="formData.showcase_badge_fresh_air"
                                    placeholder="e.g. Small Fresh Air" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Hero Background & Diagram Cutout Images -->
                <div class="card card-outline card-secondary mb-4 shadow-sm">
                    <div class="card-header bg-light">
                        <h3 class="card-title font-weight-bold text-dark mb-0">
                            <i class="fas fa-images mr-1 text-success"></i> 2. Showcase Images & Cutouts
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Hero Background Image</label>
                                <Vue3Dropzone v-model="heroImage" v-model:previews="heroPreviews"
                                    :mode="mode" :allowSelectOnPreview="true"
                                    @previewRemoved="() => onPreviewRemoved('showcase_hero_bg_image')" />
                                <small class="text-muted d-block mt-1">Recommended: 1200 × 800px landscape image for the showcase background banner.</small>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Diagram / Cutaway Product Image</label>
                                <Vue3Dropzone v-model="diagramImage" v-model:previews="diagramPreviews"
                                    :mode="mode" :allowSelectOnPreview="true"
                                    @previewRemoved="() => onPreviewRemoved('showcase_diagram_image')" />
                                <small class="text-muted d-block mt-1">Recommended: Transparent PNG or cutout (approx 600 × 500px) showing internal/front view.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Diagram Box Info & Quick Specs -->
                <div class="card card-outline card-secondary mb-4 shadow-sm">
                    <div class="card-header bg-light">
                        <h3 class="card-title font-weight-bold text-dark mb-0">
                            <i class="fas fa-sliders-h mr-1 text-info"></i> 3. Diagram Box Info & Quick Specs
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Diagram Brand</label>
                                <input type="text" class="form-control" v-model="formData.showcase_diagram_brand"
                                    placeholder="e.g. AIRE" />
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Diagram Model</label>
                                <input type="text" class="form-control" v-model="formData.showcase_diagram_model"
                                    placeholder="e.g. AP-S100" />
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Diagram System (1-line description)</label>
                                <input type="text" class="form-control" v-model="formData.showcase_diagram_system"
                                    placeholder="e.g. Wall-Mounted Fresh Air System" />
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Airflow Volume</label>
                                <input type="text" class="form-control" v-model="formData.showcase_airflow"
                                    placeholder="e.g. 100 m³/h" />
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Power Consumption</label>
                                <input type="text" class="form-control" v-model="formData.showcase_power"
                                    placeholder="e.g. 25 W" />
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Coverage Area</label>
                                <input type="text" class="form-control" v-model="formData.showcase_coverage_area"
                                    placeholder="e.g. 30–50 m²" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. Floating Feature Pills -->
                <div class="card card-outline card-secondary mb-4 shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h3 class="card-title font-weight-bold text-dark mb-0">
                            <i class="fas fa-tags mr-1 text-warning"></i> 4. Floating Feature Pills (Over Image)
                        </h3>
                        <button type="button" class="btn btn-sm btn-primary" @click="addShowcasePill">
                            <i class="fas fa-plus mr-1"></i> Add Pill
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 25%;">Icon (Bootstrap Icons)</th>
                                    <th style="width: 35%;">Title / Label</th>
                                    <th style="width: 35%;">Subtext</th>
                                    <th style="width: 5%; text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(pill, pIdx) in formData.showcase_feature_pills" :key="pIdx">
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i :class="pill.icon || 'bi bi-check-circle'"></i></span>
                                            </div>
                                            <input type="text" class="form-control" v-model="pill.icon" placeholder="e.g. bi bi-wind" />
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" v-model="pill.text" placeholder="e.g. 100 m³/h Airflow" />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" v-model="pill.subtext" placeholder="e.g. Continuous fresh air" />
                                    </td>
                                    <td class="text-center align-middle">
                                        <button type="button" class="btn btn-sm btn-outline-danger" @click="removeShowcasePill(pIdx)">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="!formData.showcase_feature_pills || formData.showcase_feature_pills.length === 0">
                                    <td colspan="4" class="text-center text-muted py-3">No feature pills added. Click "+ Add Pill" to create one.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 5. Detail Modal Spec Highlights (4 items) -->
                <div class="card card-outline card-secondary mb-4 shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h3 class="card-title font-weight-bold text-dark mb-0">
                            <i class="fas fa-th-large mr-1 text-primary"></i> 5. Detail Modal - Spec Highlight Cards
                        </h3>
                        <button type="button" class="btn btn-sm btn-primary" @click="addShowcaseSpecHighlight">
                            <i class="fas fa-plus mr-1"></i> Add Highlight Card
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 25%;">Icon (Bootstrap Icons)</th>
                                    <th style="width: 35%;">Label</th>
                                    <th style="width: 35%;">Value</th>
                                    <th style="width: 5%; text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(spec, sIdx) in formData.showcase_spec_highlights" :key="sIdx">
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i :class="spec.icon || 'bi bi-lightning-charge'"></i></span>
                                            </div>
                                            <input type="text" class="form-control" v-model="spec.icon" placeholder="e.g. bi bi-wind" />
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" v-model="spec.label" placeholder="e.g. Airflow Volume" />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" v-model="spec.value" placeholder="e.g. 100 m³/h" />
                                    </td>
                                    <td class="text-center align-middle">
                                        <button type="button" class="btn btn-sm btn-outline-danger" @click="removeShowcaseSpecHighlight(sIdx)">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="!formData.showcase_spec_highlights || formData.showcase_spec_highlights.length === 0">
                                    <td colspan="4" class="text-center text-muted py-3">No spec highlights added. Click "+ Add Highlight Card" to create one.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 6. Detail Modal Key Features & Technology Checklist -->
                <div class="card card-outline card-secondary mb-4 shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h3 class="card-title font-weight-bold text-dark mb-0">
                            <i class="fas fa-check-double mr-1 text-success"></i> 6. Detail Modal - Key Features Checklist
                        </h3>
                        <button type="button" class="btn btn-sm btn-primary" @click="addShowcaseMatchedFeature">
                            <i class="fas fa-plus mr-1"></i> Add Feature
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 25%;">Icon</th>
                                    <th style="width: 70%;">Feature Description</th>
                                    <th style="width: 5%; text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(feat, fIdx) in formData.showcase_matched_features" :key="fIdx">
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i :class="feat.icon || 'bi bi-check2-circle'"></i></span>
                                            </div>
                                            <input type="text" class="form-control" v-model="feat.icon" placeholder="e.g. bi bi-check2-circle" />
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" v-model="feat.text" placeholder="e.g. Medical-Grade H13 HEPA + Active Carbon Multi-Stage Filtration" />
                                    </td>
                                    <td class="text-center align-middle">
                                        <button type="button" class="btn btn-sm btn-outline-danger" @click="removeShowcaseMatchedFeature(fIdx)">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="!formData.showcase_matched_features || formData.showcase_matched_features.length === 0">
                                    <td colspan="3" class="text-center text-muted py-3">No features added. Click "+ Add Feature" to create one.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 7. Detail Modal Health & Certification Badges -->
                <div class="card card-outline card-secondary mb-4 shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h3 class="card-title font-weight-bold text-dark mb-0">
                            <i class="fas fa-shield-alt mr-1 text-danger"></i> 7. Detail Modal - Health & Safety Certifications
                        </h3>
                        <button type="button" class="btn btn-sm btn-primary" @click="addShowcaseHealthTag">
                            <i class="fas fa-plus mr-1"></i> Add Health / Cert Tag
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 25%;">Icon</th>
                                    <th style="width: 70%;">Tag / Certification Text</th>
                                    <th style="width: 5%; text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(tag, tIdx) in formData.showcase_health_tags" :key="tIdx">
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i :class="tag.icon || 'bi bi-shield-fill-check'"></i></span>
                                            </div>
                                            <input type="text" class="form-control" v-model="tag.icon" placeholder="e.g. bi bi-shield-fill-check" />
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" v-model="tag.text" placeholder="e.g. PM2.5 Removal: 99.9%" />
                                    </td>
                                    <td class="text-center align-middle">
                                        <button type="button" class="btn btn-sm btn-outline-danger" @click="removeShowcaseHealthTag(tIdx)">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="!formData.showcase_health_tags || formData.showcase_health_tags.length === 0">
                                    <td colspan="3" class="text-center text-muted py-3">No certification tags added. Click "+ Add Health / Cert Tag" to create one.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import Vue3Dropzone from '@jaxtheprime/vue3-dropzone';
import { getImagePath, getImageCacheUrl } from '@/layouts/helpers/helpers';

const heroImage = defineModel('heroImage', { default: null });
const heroPreviews = defineModel('heroPreviews', { default: () => [] });
const diagramImage = defineModel('diagramImage', { default: null });
const diagramPreviews = defineModel('diagramPreviews', { default: () => [] });

const props = defineProps({
    modelValue: {
        type: Object,
        default: null
    },
    form: {
        type: Object,
        default: null
    },
    mode: {
        type: String,
        default: undefined
    }
});

const emit = defineEmits([
    'previewRemoved',
    'showcasePillAdded',
    'showcasePillRemoved',
    'showcaseSpecHighlightAdded',
    'showcaseSpecHighlightRemoved',
    'showcaseMatchedFeatureAdded',
    'showcaseMatchedFeatureRemoved',
    'showcaseHealthTagAdded',
    'showcaseHealthTagRemoved'
]);

const formData = computed(() => props.form || props.modelValue || {});

const showLivePreview = ref(true);
const previewMode = ref('card');
const previewDevice = ref('desktop');

const previewHeroBgImage = computed(() => {
    if (heroImage.value && heroImage.value[0]?.file) {
        try { return URL.createObjectURL(heroImage.value[0].file); } catch (e) { /* fallback */ }
    }
    if (formData.value.showcase_hero_bg_image) {
        return getImagePath(formData.value.showcase_hero_bg_image);
    }
    if (heroPreviews.value && heroPreviews.value.length > 0) {
        const prev = heroPreviews.value[0];
        return prev ? prev.replace(/^\/image\/\d+\/\d+\/[^/]+\//, '/storage/') : prev;
    }
    return '/themes/default/assets/img/cart-bg.png';
});

const previewDiagramImage = computed(() => {
    if (diagramImage.value && diagramImage.value[0]?.file) {
        try { return URL.createObjectURL(diagramImage.value[0].file); } catch (e) { /* fallback */ }
    }
    if (diagramPreviews.value && diagramPreviews.value.length > 0) {
        const prev = diagramPreviews.value[0];
        return prev ? prev.replace('/image/120/120/', '/image/280/280/') : prev;
    }
    if (formData.value.showcase_diagram_image) {
        const img = formData.value.showcase_diagram_image;
        return img.startsWith('http') || img.startsWith('themes/') || img.startsWith('assets/')
            ? (img.startsWith('http') ? img : `/${img}`)
            : getImageCacheUrl(img, 280, 280, 'webp');
    }
    return '/themes/default/assets/img/diagram.png';
});

const onPreviewRemoved = (field) => {
    if (formData.value && formData.value[field]) {
        formData.value[field] = '';
    }
    emit('previewRemoved', field);
};

const addShowcasePill = () => {
    if (!formData.value.showcase_feature_pills) formData.value.showcase_feature_pills = [];
    const item = { icon: 'bi bi-wind', text: '', subtext: '' };
    formData.value.showcase_feature_pills.push(item);
    emit('showcasePillAdded', item);
};

const removeShowcasePill = (index) => {
    if (formData.value.showcase_feature_pills) {
        formData.value.showcase_feature_pills.splice(index, 1);
        emit('showcasePillRemoved', index);
    }
};

const addShowcaseSpecHighlight = () => {
    if (!formData.value.showcase_spec_highlights) formData.value.showcase_spec_highlights = [];
    const item = { icon: 'bi bi-lightning-charge', label: '', value: '' };
    formData.value.showcase_spec_highlights.push(item);
    emit('showcaseSpecHighlightAdded', item);
};

const removeShowcaseSpecHighlight = (index) => {
    if (formData.value.showcase_spec_highlights) {
        formData.value.showcase_spec_highlights.splice(index, 1);
        emit('showcaseSpecHighlightRemoved', index);
    }
};

const addShowcaseMatchedFeature = () => {
    if (!formData.value.showcase_matched_features) formData.value.showcase_matched_features = [];
    const item = { icon: 'bi bi-check2-circle', text: '' };
    formData.value.showcase_matched_features.push(item);
    emit('showcaseMatchedFeatureAdded', item);
};

const removeShowcaseMatchedFeature = (index) => {
    if (formData.value.showcase_matched_features) {
        formData.value.showcase_matched_features.splice(index, 1);
        emit('showcaseMatchedFeatureRemoved', index);
    }
};

const addShowcaseHealthTag = () => {
    if (!formData.value.showcase_health_tags) formData.value.showcase_health_tags = [];
    const item = { icon: 'bi bi-shield-fill-check', text: '' };
    formData.value.showcase_health_tags.push(item);
    emit('showcaseHealthTagAdded', item);
};

const removeShowcaseHealthTag = (index) => {
    if (formData.value.showcase_health_tags) {
        formData.value.showcase_health_tags.splice(index, 1);
        emit('showcaseHealthTagRemoved', index);
    }
};
</script>

<style>
.showcase-preview-card-wrap {
    max-width: 920px;
    width: 100%;
    margin: 0 auto;
}

.showcase-preview-modal-wrap {
    width: 100%;
}

/* Ductless Card Styling */
.ductless-showcase-card {
    background: #ffffff;
    border-radius: 28px;
    padding: 14px;
    border: 1px solid #eef2f6;
    box-shadow: 0 16px 36px -12px rgba(15, 23, 42, 0.08), 0 1px 3px rgba(15, 23, 42, 0.03);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    width: 100%;
    max-width: 100%;
    margin: 0 auto;
    font-family: inherit;
    overflow: hidden;
    display: flex;
    flex-direction: row;
    align-items: stretch;
    gap: 16px;
    box-sizing: border-box;
}

.ductless-showcase-card:hover {
    box-shadow: 0 24px 48px -12px rgba(15, 23, 42, 0.12), 0 4px 12px rgba(15, 23, 42, 0.05);
}

.ductless-showcase-card__hero {
    position: relative;
    flex: 1 1 50%;
    max-width: 50%;
    min-width: 0;
    background-color: #f1f4f8;
    background-size: cover;
    background-position: center right;
    background-repeat: no-repeat;
    border-radius: 22px;
    padding: 16px 18px 20px 18px;
    min-height: 430px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    overflow: hidden;
    margin: 0;
    box-sizing: border-box;
}

.ductless-showcase-card__badges {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 12px;
    z-index: 2;
    max-width: calc(100% - 50px);
}

.ductless-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    border-radius: 9999px;
    font-size: 11px;
    font-weight: 600;
    line-height: 1;
    text-decoration: none;
}

.ductless-badge i {
    font-size: 12px;
    line-height: 1;
}

.ductless-badge--residential {
    background: #fff7ed;
    border: 1px solid #fed7aa;
    color: #c2410c;
}

.ductless-badge--fresh-air {
    background: #dcfce7;
    border: 1px solid #bbf7d0;
    color: #15803d;
}

.ductless-showcase-card__actions {
    position: absolute;
    top: 16px;
    right: 16px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    z-index: 10;
}

.ductless-action-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #ffffff;
    border: 1px solid rgba(226, 232, 240, 0.85);
    box-shadow: 0 4px 10px rgba(15, 23, 42, 0.06);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    padding: 0;
    color: #475569;
    font-size: 13px;
    text-decoration: none !important;
}

.ductless-action-btn:hover {
    transform: scale(1.08);
    background-color: #0095da !important;
    border-color: #0095da !important;
    color: #ffffff !important;
    box-shadow: 0 6px 16px rgba(0, 149, 218, 0.25);
}

.ductless-action-btn.active,
.ductless-action-btn.btn-primary {
    background: #0095da !important;
    color: #ffffff !important;
    border-color: #0095da !important;
    box-shadow: 0 4px 14px rgba(0, 149, 218, 0.35) !important;
}

.ductless-action-btn.active i,
.ductless-action-btn.btn-primary i {
    color: #ffffff !important;
}

.ductless-showcase-card__header {
    margin-bottom: 12px;
    z-index: 2;
}

.ductless-showcase-card__title {
    font-size: 24px;
    font-weight: 800;
    line-height: 1.15;
    letter-spacing: -0.035em;
    color: #090d16;
    margin: 0;
    max-width: 190px;
    word-break: break-word;
}

.ductless-showcase-card__subtitle {
    font-size: 12px;
    font-weight: 400;
    line-height: 1.35;
    color: #64748B;
    margin: 4px 0 0 0;
    max-width: 180px;
    word-break: break-word;
}

.ductless-showcase-card__pills {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 4px;
    z-index: 2;
    width: max-content;
    max-width: 58%;
}

.ductless-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.96);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border-radius: 8px;
    padding: 5px 9px;
    box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.9);
    font-size: 11px;
    font-weight: 700;
    color: #1e293b;
    white-space: nowrap;
    box-sizing: border-box;
    transition: background 0.15s ease, transform 0.15s ease;
}

.ductless-pill:hover {
    background: #ffffff;
    transform: translateX(2px);
}

.ductless-pill__icon {
    color: #475569;
    flex-shrink: 0;
    font-size: 12px;
}

.ductless-pill__dual-text {
    display: flex;
    flex-direction: column;
    line-height: 1.15;
    text-align: left;
}

.ductless-pill__dual-main {
    font-size: 11px;
    font-weight: 700;
    color: #1e293b;
}

.ductless-pill__dual-sub {
    font-size: 9.5px;
    font-weight: 500;
    color: #64748b;
}

.ductless-quickview-btn {
    position: absolute;
    bottom: 16px;
    right: 28px;
    background: #202938;
    color: #ffffff !important;
    border: 0 !important;
    outline: none !important;
    cursor: pointer;
    border-radius: 9999px;
    padding: 7px 18px;
    font-size: 11.5px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    text-decoration: none !important;
    box-shadow: 0 4px 14px rgba(15, 23, 42, 0.25);
    z-index: 10;
    transition: all 0.2s ease;
}

.ductless-quickview-btn:hover {
    background: #0f172a;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(15, 23, 42, 0.35);
}

.ductless-showcase-card__body {
    background: #ffffff;
    flex: 1 1 50%;
    max-width: 50%;
    min-width: 0;
    padding: 2px 4px 4px 4px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-sizing: border-box;
}

.ductless-diagram-box {
    background: #f4f9fd;
    border: 1.5px solid #dbeafe;
    border-radius: 18px;
    padding: 16px 18px 14px 18px;
    margin-top: 0;
    margin-bottom: 6px;
    display: flex;
    flex-direction: column;
}

.ductless-diagram-box__meta {
    width: 100%;
}

.ductless-diagram-box__brand {
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: 0.06em;
    color: #647489;
    text-transform: uppercase;
    display: block;
}

.ductless-diagram-box__model {
    font-size: 16px;
    font-weight: 800;
    color: #0f172a;
    margin: 3px 0 2px 0;
    line-height: 1.25;
    word-break: break-word;
}

.ductless-diagram-box__system {
    font-size: 12px;
    font-weight: 500;
    color: #64748b;
    margin: 0;
    line-height: 1.3;
}

.ductless-diagram-box__illustration {
    margin-top: 10px;
    display: block;
    width: 100%;
}

.ductless-diagram-img {
    width: 100% !important;
    max-width: 100% !important;
    height: auto !important;
    display: block;
    border-radius: 12px;
}

.ductless-specs-bar {
    display: flex;
    align-items: center;
    justify-content: space-around;
    padding: 10px 4px;
    margin: 4px 0 8px 0;
    text-align: center;
    border: none;
}

.ductless-spec-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 3px;
    flex: 1;
}

.ductless-spec-item__value {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13.5px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1;
}

.ductless-spec-item__value i {
    color: #334155;
    font-size: 13px;
}

.ductless-spec-item__label {
    font-size: 11px;
    color: #64748b;
    font-weight: 500;
}

.ductless-specs-bar__divider {
    display: none;
}

.ductless-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 4px 6px 4px 6px;
}

.ductless-buy-btn {
    background: linear-gradient(135deg, #0070f3 0%, #0056c6 100%);
    color: #ffffff !important;
    font-size: 15px;
    font-weight: 700;
    border-radius: 9999px;
    padding: 11px 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none !important;
    box-shadow: 0 6px 18px rgba(0, 112, 243, 0.35);
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    cursor: pointer;
    min-width: 140px;
}

.ductless-buy-btn:hover {
    background: linear-gradient(135deg, #0056c6 0%, #0044a0 100%);
    box-shadow: 0 8px 24px rgba(0, 112, 243, 0.45);
    transform: translateY(-2px);
    color: #ffffff !important;
}

.ductless-price-wrap {
    text-align: right;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
}

.ductless-price {
    font-size: 20px;
    font-weight: 800;
    color: #0F172A;
    letter-spacing: -0.02em;
    line-height: 1;
}

.ductless-learn-more {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11.5px;
    font-weight: 700;
    color: #0070f3 !important;
    text-decoration: none !important;
    margin-top: 4px;
}

/* Mobile & Responsive Showcase Card */
.ductless-preview--mobile.ductless-showcase-card,
.ductless-preview--mobile .ductless-showcase-card {
    flex-direction: column !important;
    border-radius: 24px !important;
    padding: 0 !important;
    gap: 0 !important;
}

.ductless-preview--mobile .ductless-showcase-card__hero {
    flex: none !important;
    max-width: 100% !important;
    width: 100% !important;
    min-height: 380px !important;
    border-radius: 24px !important;
    padding: 14px 16px !important;
    background-position: right 6% center !important;
    margin: 0 !important;
    justify-content: flex-start !important;
}

.ductless-preview--mobile .ductless-showcase-card__body {
    flex: none !important;
    max-width: 100% !important;
    width: 100% !important;
    padding: 14px 16px 20px 16px !important;
    display: block !important;
}

.ductless-preview--mobile .ductless-showcase-card__title {
    font-size: 21px !important;
    line-height: 26px !important;
    max-width: 260px !important;
}

.ductless-preview--mobile .ductless-showcase-card__subtitle {
    font-size: 11.5px !important;
    line-height: 16px !important;
    max-width: 240px !important;
}

.ductless-preview--mobile .ductless-showcase-card__pills {
    max-width: 100% !important;
}

.ductless-preview--mobile .ductless-diagram-box {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    justify-content: space-between !important;
    gap: 12px !important;
    padding: 10px 12px !important;
    border-radius: 16px !important;
    margin-top: 0 !important;
    margin-bottom: 12px !important;
}

.ductless-preview--mobile .ductless-diagram-box__meta {
    flex: 1 1 auto !important;
    min-width: 0 !important;
    width: auto !important;
}

.ductless-preview--mobile .ductless-diagram-box__brand {
    font-size: 10px !important;
    font-weight: 700 !important;
    color: #94a3b8 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.06em !important;
    display: block !important;
}

.ductless-preview--mobile .ductless-diagram-box__model {
    font-size: clamp(11.5px, 0.7rem + 0.5vw, 14px) !important;
    font-weight: 700 !important;
    color: #0f172a !important;
    margin: 2px 0 2px 0 !important;
    line-height: 1.25 !important;
    word-break: break-word !important;
}

.ductless-preview--mobile .ductless-diagram-box__system {
    font-size: 10px !important;
    font-weight: 500 !important;
    color: #64748b !important;
    margin: 0 !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    display: block !important;
}

.ductless-preview--mobile .ductless-diagram-box__illustration {
    flex-shrink: 0 !important;
    width: auto !important;
    max-width: 130px !important;
    margin-top: 0 !important;
    text-align: right !important;
    display: flex !important;
    align-items: center !important;
    justify-content: flex-end !important;
}

.ductless-preview--mobile .ductless-diagram-img {
    width: auto !important;
    height: auto !important;
    max-width: 125px !important;
    max-height: 68px !important;
    object-fit: contain !important;
    border-radius: 8px !important;
    display: block !important;
}

.ductless-preview--mobile .ductless-specs-bar {
    display: flex !important;
    align-items: center !important;
    justify-content: space-around !important;
    padding: 9px 4px !important;
    border-top: 1px solid #f1f5f9 !important;
    border-bottom: 1px solid #f1f5f9 !important;
    margin-top: 0 !important;
    margin-bottom: 16px !important;
    text-align: center !important;
}

.ductless-preview--mobile .ductless-specs-bar__divider {
    display: block !important;
    width: 1px !important;
    height: 24px !important;
    background: #e2e8f0 !important;
    flex-shrink: 0 !important;
}

.ductless-preview--mobile .ductless-spec-item {
    flex: 1 !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    gap: 3px !important;
}

.ductless-preview--mobile .ductless-spec-item__value {
    font-size: 12px !important;
    font-weight: 800 !important;
    color: #0f172a !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 4px !important;
    line-height: 1 !important;
}

.ductless-preview--mobile .ductless-spec-item__value i {
    font-size: 10px !important;
}

.ductless-preview--mobile .ductless-spec-item__label {
    font-size: 10px !important;
    color: #94a3b8 !important;
    font-weight: 500 !important;
}

.ductless-preview--mobile .ductless-card-footer {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    gap: 12px !important;
    padding: 0 !important;
}

.ductless-preview--mobile .ductless-buy-btn {
    flex: 1 1 auto !important;
    max-width: none !important;
    width: auto !important;
    padding: 9px 20px !important;
    font-size: 13.5px !important;
    min-height: 40px !important;
    border-radius: 9999px !important;
    min-width: auto !important;
}

.ductless-preview--mobile .ductless-price-wrap {
    text-align: right !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: flex-end !important;
    min-width: max-content !important;
}

.ductless-preview--mobile .ductless-price {
    font-size: 17px !important;
    font-weight: 800 !important;
    color: #0f172a !important;
    letter-spacing: -0.02em !important;
    line-height: 1 !important;
}

.ductless-preview--mobile .ductless-learn-more {
    font-size: 11px !important;
    font-weight: 700 !important;
    color: #0070f3 !important;
    margin-top: 3px !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 3px !important;
}

@media (max-width: 860px) {
    .ductless-showcase-card {
        flex-direction: column !important;
        border-radius: 24px !important;
        padding: 0 !important;
        gap: 0 !important;
    }

    .ductless-showcase-card__hero {
        flex: none !important;
        max-width: 100% !important;
        width: 100% !important;
        min-height: 380px !important;
        border-radius: 24px !important;
        padding: 14px 16px !important;
        background-position: right 6% center !important;
        margin: 0 !important;
        justify-content: flex-start !important;
    }

    .ductless-showcase-card__body {
        flex: none !important;
        max-width: 100% !important;
        width: 100% !important;
        padding: 14px 16px 20px 16px !important;
        display: block !important;
    }

    .ductless-showcase-card__title {
        font-size: 21px !important;
        line-height: 26px !important;
        max-width: 260px !important;
    }

    .ductless-showcase-card__subtitle {
        font-size: 11.5px !important;
        line-height: 16px !important;
        max-width: 240px !important;
    }

    .ductless-showcase-card__pills {
        max-width: 100% !important;
    }

    .ductless-diagram-box {
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 12px !important;
        padding: 10px 12px !important;
        border-radius: 16px !important;
        margin-top: 0 !important;
        margin-bottom: 12px !important;
    }

    .ductless-diagram-box__meta {
        flex: 1 1 auto !important;
        min-width: 0 !important;
        width: auto !important;
    }

    .ductless-diagram-box__brand {
        font-size: 10px !important;
        font-weight: 700 !important;
        color: #94a3b8 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.06em !important;
        display: block !important;
    }

    .ductless-diagram-box__model {
        font-size: clamp(11.5px, 0.7rem + 0.5vw, 14px) !important;
        font-weight: 700 !important;
        color: #0f172a !important;
        margin: 2px 0 2px 0 !important;
        line-height: 1.25 !important;
        word-break: break-word !important;
    }

    .ductless-diagram-box__system {
        font-size: 10px !important;
        font-weight: 500 !important;
        color: #64748b !important;
        margin: 0 !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        display: block !important;
    }

    .ductless-diagram-box__illustration {
        flex-shrink: 0 !important;
        width: auto !important;
        max-width: 130px !important;
        margin-top: 0 !important;
        text-align: right !important;
        display: flex !important;
        align-items: center !important;
        justify-content: flex-end !important;
    }

    .ductless-diagram-img {
        width: auto !important;
        height: auto !important;
        object-fit: contain !important;
        border-radius: 8px !important;
        display: block !important;
    }

    .ductless-specs-bar {
        display: flex !important;
        align-items: center !important;
        justify-content: space-around !important;
        padding: 9px 4px !important;
        border-top: 1px solid #f1f5f9 !important;
        border-bottom: 1px solid #f1f5f9 !important;
        margin-top: 0 !important;
        margin-bottom: 16px !important;
        text-align: center !important;
    }

    .ductless-specs-bar__divider {
        display: block !important;
        width: 1px !important;
        height: 24px !important;
        background: #e2e8f0 !important;
        flex-shrink: 0 !important;
    }

    .ductless-spec-item {
        flex: 1 !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        gap: 3px !important;
    }

    .ductless-spec-item__value {
        font-size: 12px !important;
        font-weight: 800 !important;
        color: #0f172a !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 4px !important;
        line-height: 1 !important;
    }

    .ductless-spec-item__value i {
        font-size: 10px !important;
    }

    .ductless-spec-item__label {
        font-size: 10px !important;
        color: #94a3b8 !important;
        font-weight: 500 !important;
    }

    .ductless-card-footer {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 12px !important;
        padding: 0 !important;
    }

    .ductless-buy-btn {
        flex: 1 1 auto !important;
        max-width: none !important;
        width: auto !important;
        padding: 9px 20px !important;
        font-size: 13.5px !important;
        min-height: 40px !important;
        border-radius: 9999px !important;
        min-width: auto !important;
    }

    .ductless-price-wrap {
        text-align: right !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-end !important;
        min-width: max-content !important;
    }

    .ductless-price {
        font-size: 17px !important;
        font-weight: 800 !important;
        color: #0f172a !important;
        letter-spacing: -0.02em !important;
        line-height: 1 !important;
    }

    .ductless-learn-more {
        font-size: 11px !important;
        font-weight: 700 !important;
        color: #0070f3 !important;
        margin-top: 3px !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 3px !important;
    }
}

/* Ductless Quick View Modal Styling inside Admin */
.ductless-modal__content {
    background: #ffffff;
    box-shadow: 0 15px 35px -10px rgba(15, 23, 42, 0.12);
    position: relative;
}

.ductless-modal__image-wrapper {
    background-color: #f1f4f8;
    background-size: cover;
    background-position: 75% center;
    background-repeat: no-repeat;
    min-height: 280px;
    height: 100%;
    width: 100%;
}

.ductless-modal__info {
    padding-left: 4px;
}

.ductless-modal__brand {
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: 0.06em;
    color: #94a3b8;
    text-transform: uppercase;
}

.ductless-modal__series-badge {
    background: #ebf5ff;
    color: #0284c7;
    border: 1px solid #bfdbfe;
    font-size: 10px;
    font-weight: 700;
    border-radius: 9999px;
    padding: 3px 10px;
    line-height: 1;
}

.ductless-modal__title {
    font-size: 18px;
    font-weight: 800;
    color: #090d16;
    line-height: 1.2;
    margin: 6px 0 2px 0;
}

.ductless-modal__subtitle {
    font-size: 12px;
    font-weight: 600;
    color: #334155;
    line-height: 1.35;
    margin-bottom: 8px;
}

.ductless-modal__desc {
    font-size: 11px;
    font-weight: 400;
    color: #64748b;
    line-height: 1.45;
    margin-bottom: 12px;
}

.ductless-modal__specs-grid {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-top: 1px solid #e5e7eb;
    border-bottom: 1px solid #e5e7eb;
    margin-bottom: 12px;
    padding: 6px 0;
    text-align: center;
}

.ductless-modal__spec-col {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    flex: 1;
    gap: 2px;
    border-right: 1px solid #e2e8f0;
}

.ductless-modal__spec-col:last-child {
    border-right: none;
}

.ductless-modal__spec-label {
    font-size: 9.5px;
    color: #64748b;
    font-weight: 500;
}

.ductless-modal__spec-value {
    font-size: 12px;
    font-weight: 800;
    color: #0F172A;
}

.ductless-modal__matched-section {
    margin-top: 6px;
}

.ductless-modal__matched-title {
    font-size: 11px;
    font-weight: 700;
    color: #090d16;
}

.ductless-modal__matched-sub {
    font-size: 9.5px;
    color: #94A3B8;
}

.ductless-modal__pill-wrap {
    display: grid;
    gap: 6px;
    margin-top: 6px;
}

.ductless-modal__pill {
    background: #fbfcfe;
    border: 1px solid #e2e8f0;
    border-radius: 9999px;
    padding: 4px 8px 4px 10px;
    font-size: 10.5px;
    font-weight: 600;
    color: #1e293b;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.ductless-modal__check {
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: #1d3f66;
    color: #ffffff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 9px;
}

.ductless-modal__footer {
    border-top: 1px solid #f1f5f9;
    padding-top: 12px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
}

.ductless-modal__health-tags {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
}

.ductless-modal__health-tag {
    font-size: 10px;
    font-weight: 600;
    color: #475569;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.ductless-modal__cta-wrap {
    display: flex;
    align-items: center;
    gap: 6px;
}

.ductless-modal__btn-view {
    background: #20426b;
    color: #ffffff !important;
    border-radius: 9999px;
    padding: 6px 14px;
    font-size: 11px;
    font-weight: 700;
    border: none;
}

.ductless-modal__btn-compare {
    background: #ffffff;
    border: 1.5px solid #cbd5e1;
    color: #334155 !important;
    border-radius: 9999px;
    padding: 5px 14px;
    font-size: 11px;
    font-weight: 600;
}
</style>
