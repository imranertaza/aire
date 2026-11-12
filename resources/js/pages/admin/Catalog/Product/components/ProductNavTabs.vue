<template>
    <div class="card-header p-0 border-bottom-0">
        <ul class="nav nav-tabs" id="product-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tab-general" data-toggle="pill"
                    href="#custom-tabs-general" role="tab" aria-controls="custom-tabs-general"
                    aria-selected="true">General</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-data" data-toggle="pill" href="#custom-tabs-data" role="tab"
                    aria-controls="custom-tabs-data" aria-selected="false">Data</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-images" data-toggle="pill" href="#custom-tabs-images"
                    role="tab" aria-controls="custom-tabs-images" aria-selected="false">Images</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-links" data-toggle="pill" href="#custom-tabs-links"
                    role="tab" aria-controls="custom-tabs-links" aria-selected="false">Links</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-overview" data-toggle="pill"
                    href="#custom-tabs-overview" role="tab" aria-controls="custom-tabs-overview"
                    aria-selected="false">Overview</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-specifications" data-toggle="pill"
                    href="#custom-tabs-specifications" role="tab" aria-controls="custom-tabs-specifications"
                    aria-selected="false">Specifications</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-features" data-toggle="pill"
                    href="#custom-tabs-features" role="tab" aria-controls="custom-tabs-features"
                    aria-selected="false">Features</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-technology" data-toggle="pill"
                    href="#custom-tabs-technology" role="tab" aria-controls="custom-tabs-technology"
                    aria-selected="false">Technology</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-in-the-box" data-toggle="pill"
                    href="#custom-tabs-in-the-box" role="tab" aria-controls="custom-tabs-in-the-box"
                    aria-selected="false">In The Box</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-applications" data-toggle="pill"
                    href="#custom-tabs-applications" role="tab" aria-controls="custom-tabs-applications"
                    aria-selected="false">Applications</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-filter-options" data-toggle="pill" href="#custom-tabs-filter-options"
                    role="tab" aria-controls="custom-tabs-filter-options" aria-selected="false">Filter Options</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-options" data-toggle="pill" href="#custom-tabs-options"
                    role="tab" aria-controls="custom-tabs-options" aria-selected="false">Options</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-attributes" data-toggle="pill"
                    href="#custom-tabs-attributes" role="tab" aria-controls="custom-tabs-attributes"
                    aria-selected="false">Attributes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-specials" data-toggle="pill" href="#custom-tabs-specials"
                    role="tab" aria-controls="custom-tabs-specials" aria-selected="false">Specials</a>
            </li>
            <li v-if="showOthersTab" class="nav-item">
                <a class="nav-link" id="tab-others" data-toggle="pill" href="#custom-tabs-others"
                    role="tab" aria-controls="custom-tabs-others" aria-selected="false">Others</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-faqs" data-toggle="pill" href="#custom-tabs-faqs" role="tab"
                    aria-controls="custom-tabs-faqs" aria-selected="false">FAQs</a>
            </li>
            <li v-if="mode === 'edit' || showLandingTab" class="nav-item">
                <a class="nav-link" id="tab-landing" data-toggle="pill" href="#custom-tabs-landing"
                    role="tab" aria-controls="custom-tabs-landing" aria-selected="false">
                    <i class="fas fa-rocket text-primary mr-1"></i> Landing Page
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-showcase" data-toggle="pill" href="#custom-tabs-showcase"
                    role="tab" aria-controls="custom-tabs-showcase" aria-selected="false">
                    <i class="fas fa-layer-group text-success mr-1"></i> Showcase Card
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-block-sections" data-toggle="pill" href="#custom-tabs-block-sections"
                    role="tab" aria-controls="custom-tabs-block-sections" aria-selected="false">
                    <i class="fas fa-cubes text-info mr-1"></i> Block Sections
                </a>
            </li>
        </ul>
    </div>
</template>

<script setup>
defineProps({
    mode: {
        type: String,
        default: 'create'
    },
    showLandingTab: {
        type: Boolean,
        default: false
    },
    showOthersTab: {
        type: Boolean,
        default: false
    }
});
</script>
