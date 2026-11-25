<template>
    <div class="update-section-page">
        <DashboardHeader :title="'Update Section: ' + (form.key || 'Section')">
            <div class="d-flex justify-content-end align-items-center">
                <button type="button" @click="updateSections" class="btn btn-primary" :disabled="saving">
                    <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving...' : 'Save Section' }}
                </button>
                <router-link :to="{ name: 'Section' }" class="btn btn-secondary ml-2">
                    <i class="fas fa-times mr-1"></i> Cancel
                </router-link>
            </div>
        </DashboardHeader>

        <section class="content">
            <div class="container-fluid">
                <!-- ==================================================== -->
                <!-- HOMEPAGE SECTION FORMS (Modular Components)          -->
                <!-- ==================================================== -->
                <HomeCategoryGridForm
                    v-if="form.key === 'home_category_grid'"
                    :form="form"
                    :gridFiles="gridFiles"
                    :saving="saving"
                    @save="updateSections"
                />

                <HomeWhyChooseForm
                    v-else-if="form.key === 'why_choose_aire'"
                    :form="form"
                    :saving="saving"
                    @save="updateSections"
                />

                <HomeLifestyleForm
                    v-else-if="['home_lifestyle', 'lifestyle'].includes(form.key)"
                    :form="form"
                    :saving="saving"
                    @save="updateSections"
                />

                <HomeBenefitsForm
                    v-else-if="['home_benefits', 'benefits'].includes(form.key)"
                    :form="form"
                    :saving="saving"
                    v-model:fileUpload="fileUpload"
                    v-model:previews="previews"
                    @save="updateSections"
                />

                <HomeFaqForm
                    v-else-if="['home_faq', 'faq'].includes(form.key)"
                    :form="form"
                    :saving="saving"
                    @save="updateSections"
                />

                <HomeTrustBadgesForm
                    v-else-if="form.key === 'trust_badges'"
                    :form="form"
                    :saving="saving"
                    @save="updateSections"
                />

                <HomeVideoBannerForm
                    v-else-if="['home_video', 'video'].includes(form.key)"
                    :form="form"
                    :saving="saving"
                    v-model:videoFile="selectedVideoFile"
                    v-model:removeVideo="removeVideoFlag"
                    v-model:posterFile="fileUpload"
                    v-model:posterPreviews="previews"
                    @save="updateSections"
                />

                <HomeProductShowcaseForm
                    v-else-if="['home_best_selling', 'best_selling', 'home_new_arrival', 'new_arrival', 'home_customer_favorites', 'customer_favorites'].includes(form.key)"
                    :form="form"
                    :saving="saving"
                    @save="updateSections"
                />

                <HomeLivingHeroForm
                    v-else-if="['home_living_hero', 'living_hero'].includes(form.key)"
                    :form="form"
                    :saving="saving"
                    v-model:fileUpload="fileUpload"
                    v-model:previews="previews"
                    @save="updateSections"
                />

                <!-- ==================================================== -->
                <!-- ABOUT PAGE SECTIONS (Modular Components)             -->
                <!-- ==================================================== -->
                <AboutHeroForm
                    v-else-if="form.key === 'about_hero'"
                    :form="form"
                />

                <AboutStoryForm
                    v-else-if="form.key === 'about_story'"
                    :form="form"
                    @file-change="handleAboutFileChange"
                />

                <AboutMissionVisionForm
                    v-else-if="form.key === 'about_mission_vision'"
                    :form="form"
                    @file-change="handleAboutFileChange"
                />

                <AboutLeadershipForm
                    v-else-if="form.key === 'about_leadership'"
                    :form="form"
                    @file-change="handleAboutFileChange"
                />

                <AboutFeaturesForm
                    v-else-if="['about_innovation', 'about_quality', 'about_global'].includes(form.key)"
                    :form="form"
                />

                <AboutCareersForm
                    v-else-if="form.key === 'about_careers'"
                    :form="form"
                />

                <AboutNewsForm
                    v-else-if="form.key === 'about_news'"
                    :form="form"
                />

                <!-- Action Footer Bar for About Page Sections -->
                <div v-if="form.key && form.key.startsWith('about_')" class="card bg-white border shadow-sm p-3 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <router-link :to="{ name: 'AboutSections' }" class="btn btn-outline-secondary px-3">
                            <i class="fas fa-arrow-left mr-1"></i> Back to About Sections
                        </router-link>
                        <div class="d-flex align-items-center">
                            <button type="button" @click="updateSections" class="btn btn-primary px-4 shadow-sm font-weight-bold" :disabled="saving">
                                <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving Changes...' : 'Save & Publish Section' }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ==================================================== -->
                <!-- STANDARD MODE: Other General Sections                -->
                <!-- ==================================================== -->
                <GeneralSectionForm
                    v-else
                    :form="form"
                    :saving="saving"
                    v-model:fileUpload="fileUpload"
                    v-model:previews="previews"
                    @save="updateSections"
                />
            </div>
        </section>
    </div>
</template>

<script setup>
import axios from "axios";
import { onMounted, reactive, ref } from "vue";
import { useRoute, useRouter } from "vue-router";

import DashboardHeader from "@/components/DashboardHeader.vue";
import { useToast } from "@/composables/useToast";
import { getImageUrl } from "@/layouts/helpers/helpers";

// Modular Home Section Forms
import HomeCategoryGridForm from "@/pages/admin/Section/forms/home/HomeCategoryGridForm.vue";
import HomeWhyChooseForm from "@/pages/admin/Section/forms/home/HomeWhyChooseForm.vue";
import HomeLifestyleForm from "@/pages/admin/Section/forms/home/HomeLifestyleForm.vue";
import HomeBenefitsForm from "@/pages/admin/Section/forms/home/HomeBenefitsForm.vue";
import HomeFaqForm from "@/pages/admin/Section/forms/home/HomeFaqForm.vue";
import HomeTrustBadgesForm from "@/pages/admin/Section/forms/home/HomeTrustBadgesForm.vue";
import HomeVideoBannerForm from "@/pages/admin/Section/forms/home/HomeVideoBannerForm.vue";
import HomeProductShowcaseForm from "@/pages/admin/Section/forms/home/HomeProductShowcaseForm.vue";
import HomeLivingHeroForm from "@/pages/admin/Section/forms/home/HomeLivingHeroForm.vue";
import GeneralSectionForm from "@/pages/admin/Section/forms/GeneralSectionForm.vue";

// Modular About Section Forms
import AboutHeroForm from "@/pages/admin/Section/forms/about/AboutHeroForm.vue";
import AboutStoryForm from "@/pages/admin/Section/forms/about/AboutStoryForm.vue";
import AboutMissionVisionForm from "@/pages/admin/Section/forms/about/AboutMissionVisionForm.vue";
import AboutLeadershipForm from "@/pages/admin/Section/forms/about/AboutLeadershipForm.vue";
import AboutFeaturesForm from "@/pages/admin/Section/forms/about/AboutFeaturesForm.vue";
import AboutCareersForm from "@/pages/admin/Section/forms/about/AboutCareersForm.vue";
import AboutNewsForm from "@/pages/admin/Section/forms/about/AboutNewsForm.vue";

const props = defineProps({
    id: {
        type: [String, Number],
        default: null,
    },
});

const toast = useToast();
const route = useRoute();
const router = useRouter();
const saving = ref(false);

// About section uploaded image files map
const aboutImageFiles = reactive({
    hero_image: null,
    impact_image: null,
    purpose_image: null,
    banner_image: null,
});

const handleAboutFileChange = (field, file) => {
    aboutImageFiles[field] = file;
};

// File upload handling for general, benefits & living hero sections
const fileUpload = ref([]);
const previews = ref([]);

// Video banner section file handling
const selectedVideoFile = ref(null);
const removeVideoFlag = ref(false);

// Category Showcase Grid image files map
const gridFiles = reactive({
    fresh_air_image_file: null,
    mask_image_file: null,
    accessories_image_file: null,
    purifier_image_file: null,
    home_solutions_image_file: null,
    biz_solutions_image_file: null,
});

// Reactive form state
const form = reactive({
    id: null,
    title: "",
    badge: "BENEFITS",
    subtitle: "",
    key: "",
    content: "",
    home_content: "",
    number: null,
    hero_title: "",
    hero_desc: "",
    hero_image: "",
    hero_badge: "",
    milestones: [],
    impact_title: "",
    impact_desc: "",
    impact_image: "",
    impact_badge: "",
    stats: [],
    purpose_title: "",
    purpose_desc: "",
    purpose_image: "",
    purpose_badge: "",
    mission_title: "",
    mission_desc: "",
    vision_title: "",
    vision_desc: "",
    values: [],
    banner_badge: "",
    banner_title: "",
    banner_desc: "",
    banner_image: "",
    banner_badge_text: "",
    team_heading: "",
    team_subheading: "",
    members: [],
    card_title: "",
    card_desc: "",
    quote: "",
    quote_brand: "",
    items: [],
    cards: [],
    badges: [],
    product_ids: [],
    product_id: null,
    button_text: "Buy Now",
    button_link: "",
    enabled: 1,
    description: "",
    file: "",
    image: "",
    video_url: "",
    video_file: "",
    // Category Showcase Grid
    action_text: "Find Your Solutions",
    action_url: "/category/products",

    fresh_air_category_id: null,
    fresh_air_title: "Fresh Air Unit",
    fresh_air_url: "/category/fresh-air-systems",
    fresh_air_image: "",

    mask_category_id: null,
    mask_title: "Air Pro Mask",
    mask_url: "/category/smart-wearable-masks",
    mask_image: "",

    accessories_category_id: null,
    accessories_title: "Accessories",
    accessories_url: "/category/accessories-parts",
    accessories_image: "",

    purifier_category_id: null,
    purifier_title: "Air Purifiers",
    purifier_url: "/category/air-purifiers",
    purifier_image: "",

    home_solutions_category_id: null,
    home_solutions_title: "Solutions for Home",
    home_solutions_sub: "Ventilation and Filtration Solution",
    home_solutions_url: "/category/home-fresh-air-systems",
    home_solutions_image: "",

    biz_solutions_category_id: null,
    biz_solutions_title: "Solutions for Business",
    biz_solutions_sub: "Air Disinfection & Air Monitoring",
    biz_solutions_url: "/category/commercial-fresh-air-systems",
    biz_solutions_image: "",

    status: "1",
    createdBy: 1,
    updatedBy: null,
});

// Fetch existing section data
const fetchSections = async () => {
    try {
        const sectionId = props.id || route.params.id;
        const res = await axios.get(`/api/sections/${sectionId}`);
        const sectionData = res.data.data;

        if (sectionData.name === 'client_testimonials') {
            router.replace({ name: 'TestimonialsSection' });
            return;
        }

        let d = sectionData.data;
        if (typeof d === 'string') {
            try { d = JSON.parse(d); } catch (e) { }
        }

        form.id = sectionData.id;
        form.key = sectionData.name;
        form.title = d.title || "";
        form.badge = d.badge || (sectionData.name === 'home_lifestyle' || sectionData.name === 'lifestyle' ? 'LIFESTYLE' : 'BENEFITS');
        form.subtitle = d.subtitle || "";
        form.content = d.content || "";
        form.home_content = d.home_content || "";
        form.number = d.number !== undefined ? d.number : null;

        if (['home_video', 'video'].includes(form.key)) {
            form.title = d.title || "AIRE Pro S1 — Engineering Architecture & Air Purification";
            form.video_url = d.video_url || "storage/home/home-video.mp4";
            form.video_file = d.video_file || "";
            form.image = d.image || "home/video_thumb.png";
            if (form.image) {
                previews.value = [getImageUrl(form.image)];
            }
        }

        if (['home_best_selling', 'best_selling', 'home_new_arrival', 'new_arrival', 'home_customer_favorites', 'customer_favorites'].includes(form.key)) {
            const isFav = ['home_customer_favorites', 'customer_favorites'].includes(form.key);
            const isNew = ['home_new_arrival', 'new_arrival'].includes(form.key);

            form.badge = d.badge || (isFav ? 'Customers Favorites' : (isNew ? 'New arrival' : 'Product'));
            form.title = d.title || (isFav ? 'Loved by Our Community' : (isNew ? 'Freshly Launched Models' : 'Best Selling Product'));
            form.subtitle = d.subtitle || (isFav ? 'Discover the purifiers most chosen by families who value clean, healthy air.' : (isNew ? 'Explore the latest purifiers designed with advanced technology for modern living.' : 'Discover the top‑selling models trusted by thousands of families for cleaner, healthier air.'));

            let pIds = d.product_ids;
            if (typeof pIds === 'string') {
                try { pIds = JSON.parse(pIds); } catch (e) { pIds = []; }
            }
            form.product_ids = Array.isArray(pIds) ? pIds.map(Number).filter(n => !isNaN(n) && n > 0) : [];
        }

        if (['home_living_hero', 'living_hero'].includes(form.key)) {
            form.badge = d.badge || "INNOVATION";
            form.title = d.title || "The Future of Pure Living";
            form.subtitle = d.subtitle || d.description || "";
            form.description = d.description || d.subtitle || "";
            form.button_text = d.button_text || "Buy Now";
            form.product_id = d.product_id ? Number(d.product_id) : null;
            form.image = d.image || "themes/default/assets/img/background-without-product.png";
            form.enabled = d.enabled !== undefined ? Number(d.enabled) : 1;
            if (form.image) {
                previews.value = [getImageUrl(form.image)];
            }
        }

        if (['home_faq', 'faq'].includes(form.key)) {
            form.badge = d.badge || "SUPPORT";
            form.title = d.title || "Frequently Asked Questions";
            form.subtitle = d.subtitle || "";
            form.items = Array.isArray(d.items) ? d.items.map(it => ({
                question: it.question || "",
                answer: it.answer || "",
            })) : [];
        }

        if (form.key === 'home_category_grid') {
            form.action_text = d.action_text || "Find Your Solutions";
            form.action_url = d.action_url || "/category/products";

            form.fresh_air_category_id = d.fresh_air_category_id ? Number(d.fresh_air_category_id) : null;
            form.fresh_air_title = d.fresh_air_title || "Fresh Air Unit";
            form.fresh_air_url = d.fresh_air_url || "/category/fresh-air-systems";
            form.fresh_air_image = d.fresh_air_image || "themes/default/assets/img/home/fresh-air-unit.webp";

            form.mask_category_id = d.mask_category_id ? Number(d.mask_category_id) : null;
            form.mask_title = d.mask_title || "Air Pro Mask";
            form.mask_url = d.mask_url || "/category/smart-wearable-masks";
            form.mask_image = d.mask_image || "themes/default/assets/img/home/air-pro-mask.webp";

            form.accessories_category_id = d.accessories_category_id ? Number(d.accessories_category_id) : null;
            form.accessories_title = d.accessories_title || "Accessories";
            form.accessories_url = d.accessories_url || "/category/accessories-parts";
            form.accessories_image = d.accessories_image || "themes/default/assets/img/home/accessories.webp";

            form.purifier_category_id = d.purifier_category_id ? Number(d.purifier_category_id) : null;
            form.purifier_title = d.purifier_title || "Air Purifiers";
            form.purifier_url = d.purifier_url || "/category/air-purifiers";
            form.purifier_image = d.purifier_image || "themes/default/assets/img/home/air-purifiers.webp";

            form.home_solutions_category_id = d.home_solutions_category_id ? Number(d.home_solutions_category_id) : null;
            form.home_solutions_title = d.home_solutions_title || "Solutions for Home";
            form.home_solutions_sub = d.home_solutions_sub || "Ventilation and Filtration Solution";
            form.home_solutions_url = d.home_solutions_url || "/category/home-fresh-air-systems";
            form.home_solutions_image = d.home_solutions_image || "themes/default/assets/img/home/solutions-home.webp";

            form.biz_solutions_category_id = d.biz_solutions_category_id ? Number(d.biz_solutions_category_id) : null;
            form.biz_solutions_title = d.biz_solutions_title || "Solutions for Business";
            form.biz_solutions_sub = d.biz_solutions_sub || "Air Disinfection & Air Monitoring";
            form.biz_solutions_url = d.biz_solutions_url || "/category/commercial-fresh-air-systems";
            form.biz_solutions_image = d.biz_solutions_image || "themes/default/assets/img/home/solutions-business.webp";
        }

        // About Sections Specific Parsing
        if (form.key === 'about_hero') {
            form.badge = d.badge || "OUR STORY";
            form.title = d.title || "A Cleaner Tomorrow Starts Here";
            form.subtitle = d.subtitle || "";
        }

        if (form.key === 'about_story') {
            form.hero_title = d.hero_title || "";
            form.hero_desc = d.hero_desc || "";
            form.hero_image = d.hero_image || "";
            form.hero_badge = d.hero_badge || "";
            form.button_text = d.button_text || "";
            form.button_link = d.button_link || "";
            form.milestones = Array.isArray(d.milestones) ? d.milestones.map(m => ({
                year: m.year || "",
                title: m.title || "",
                desc: m.desc || ""
            })) : [];
            form.impact_title = d.impact_title || "";
            form.impact_desc = d.impact_desc || "";
            form.impact_image = d.impact_image || "";
            form.impact_badge = d.impact_badge || "";
            form.stats = Array.isArray(d.stats) ? d.stats.map(s => ({
                icon: s.icon || "bi bi-globe",
                title: s.title || "",
                desc: s.desc || ""
            })) : [];
            form.quote = d.quote || "";
            form.quote_brand = d.quote_brand || "";
        }

        if (form.key === 'about_mission_vision') {
            form.purpose_title = d.purpose_title || "";
            form.purpose_desc = d.purpose_desc || "";
            form.purpose_image = d.purpose_image || "";
            form.purpose_badge = d.purpose_badge || "";
            form.mission_title = d.mission_title || "";
            form.mission_desc = d.mission_desc || "";
            form.vision_title = d.vision_title || "";
            form.vision_desc = d.vision_desc || "";
            form.values = Array.isArray(d.values) ? d.values.map(v => ({
                icon: v.icon || "bi bi-heart",
                title: v.title || "",
                desc: v.desc || ""
            })) : [];
            form.quote = d.quote || "";
            form.quote_brand = d.quote_brand || "";
        }

        if (form.key === 'about_leadership') {
            form.banner_badge = d.banner_badge || "";
            form.banner_title = d.banner_title || "";
            form.banner_desc = d.banner_desc || "";
            form.banner_image = d.banner_image || "";
            form.banner_badge_text = d.banner_badge_text || "";
            form.team_heading = d.team_heading || "";
            form.team_subheading = d.team_subheading || "";
            form.members = Array.isArray(d.members) ? d.members.map(m => ({
                name: m.name || "",
                role: m.role || "",
                bio: m.bio || "",
                image: m.image || ""
            })) : [];
            form.quote = d.quote || "";
            form.quote_brand = d.quote_brand || "";
        }

        if (['about_innovation', 'about_quality', 'about_global'].includes(form.key)) {
            form.items = Array.isArray(d.items) ? d.items.map(it => ({
                icon: it.icon || "bi bi-star",
                title: it.title || "",
                desc: it.desc || ""
            })) : [];
        }

        if (form.key === 'about_careers') {
            form.card_title = d.card_title || "";
            form.card_desc = d.card_desc || "";
            form.button_text = d.button_text || "";
            form.button_link = d.button_link || "";
        }

        if (form.key === 'about_news') {
            form.banner_title = d.banner_title || "";
            form.banner_desc = d.banner_desc || "";
            form.button_text = d.button_text || "";
            form.button_link = d.button_link || "";
        }

        if (!['home_faq', 'faq', 'about_innovation', 'about_quality', 'about_global'].includes(form.key)) {
            form.items = Array.isArray(d.items) ? d.items.map(it => ({
                title: it.title || "",
                description: it.description || "",
                question: it.question || "",
                answer: it.answer || "",
                image: it.image || "",
                dropzoneFile: null,
                previews: it.image ? [getImageUrl(it.image)] : []
            })) : form.items || [];
        }

        form.cards = Array.isArray(d.cards) ? d.cards.map((c, idx) => ({
            theme: c.theme || "light",
            dots: c.dots || "•••",
            title: c.title || "",
            description: c.description || c.content || "",
            content: c.description || c.content || "",
            card_class: c.card_class || `card-layer-${idx + 1}`
        })) : [];
        form.badges = Array.isArray(d.badges) ? d.badges.map(b => ({
            icon: b.icon || "bi-shield-check",
            title: b.title || "",
            description: b.description || ""
        })) : [];
        form.image = d.image || "";
        form.status = sectionData.status !== undefined ? String(sectionData.status) : (d.status !== undefined ? String(d.status) : "1");

        if (form.image && !form.key.startsWith('about_')) {
            previews.value = [getImageUrl(form.image)];
        }
    } catch (err) {
        console.error("Failed to load section data", err);
        toast.error("Failed to load section data");
    }
};

// Submit updated section
const updateSections = async () => {
    // Client-side required field validations
    if (form.key === "home_category_grid") {
        if (!form.fresh_air_title?.trim() || !form.mask_title?.trim() || !form.accessories_title?.trim() || !form.purifier_title?.trim()) {
            toast.error("Please provide titles for all 4 Category cards.");
            return;
        }
        if (!form.home_solutions_title?.trim() || !form.biz_solutions_title?.trim()) {
            toast.error("Please provide headlines for both Solutions banners.");
            return;
        }
    } else if (form.key === "why_choose_aire") {
        if (!form.title?.trim()) {
            toast.error("Section Title is required.");
            return;
        }
        for (let i = 0; i < form.cards.length; i++) {
            if (!form.cards[i].title?.trim()) {
                toast.error(`Card #${i + 1} Title is required.`);
                return;
            }
            if (!form.cards[i].description?.trim()) {
                toast.error(`Card #${i + 1} Description is required.`);
                return;
            }
        }
    } else if (["home_lifestyle", "lifestyle"].includes(form.key)) {
        if (!form.title?.trim()) {
            toast.error("Section Title is required.");
            return;
        }
        if (!form.badge?.trim()) {
            toast.error("Section Badge is required.");
            return;
        }
        if (!form.subtitle?.trim()) {
            toast.error("Section Subtitle is required.");
            return;
        }
        for (let i = 0; i < form.items.length; i++) {
            if (!form.items[i].title?.trim()) {
                toast.error(`Item #${i + 1} Title is required.`);
                return;
            }
            if (!form.items[i].description?.trim()) {
                toast.error(`Item #${i + 1} Description is required.`);
                return;
            }
        }
    } else if (["home_benefits", "benefits"].includes(form.key)) {
        if (!form.title?.trim()) {
            toast.error("Section Title is required.");
            return;
        }
        if (!form.badge?.trim()) {
            toast.error("Section Badge is required.");
            return;
        }
        if (!form.subtitle?.trim()) {
            toast.error("Section Subtitle is required.");
            return;
        }
        for (let i = 0; i < form.cards.length; i++) {
            if (!form.cards[i].title?.trim()) {
                toast.error(`Benefit Card #${i + 1} Title is required.`);
                return;
            }
            if (!form.cards[i].description?.trim()) {
                toast.error(`Benefit Card #${i + 1} Description is required.`);
                return;
            }
        }
    } else if (form.key === "trust_badges") {
        for (let i = 0; i < form.badges.length; i++) {
            if (!form.badges[i].title?.trim() || !form.badges[i].icon?.trim() || !form.badges[i].description?.trim()) {
                toast.error(`Badge #${i + 1} Title, Icon Class, and Description are required.`);
                return;
            }
        }
    } else if (form.key === "home_video" || form.key === "video") {
        if (!form.title?.trim()) {
            toast.error("Headline & Section Title is required.");
            return;
        }
    } else if (['home_best_selling', 'best_selling', 'home_new_arrival', 'new_arrival', 'home_customer_favorites', 'customer_favorites'].includes(form.key)) {
        if (!form.title?.trim()) {
            toast.error("Section Title is required.");
            return;
        }
    } else if (!['home_living_hero', 'living_hero'].includes(form.key)) {
        if (!form.title?.trim()) {
            toast.error("Section Title is required.");
            return;
        }
    }

    saving.value = true;
    let data = {};

    if (form.key === "home_category_grid") {
        data = {
            action_text: form.action_text || "Find Your Solutions",
            action_url: form.action_url || "/category/products",

            fresh_air_category_id: form.fresh_air_category_id || null,
            fresh_air_title: form.fresh_air_title || "Fresh Air Unit",
            fresh_air_url: form.fresh_air_url || "/category/fresh-air-systems",
            fresh_air_image: form.fresh_air_image || "themes/default/assets/img/home/fresh-air-unit.webp",

            mask_category_id: form.mask_category_id || null,
            mask_title: form.mask_title || "Air Pro Mask",
            mask_url: form.mask_url || "/category/smart-wearable-masks",
            mask_image: form.mask_image || "themes/default/assets/img/home/air-pro-mask.webp",

            accessories_category_id: form.accessories_category_id || null,
            accessories_title: form.accessories_title || "Accessories",
            accessories_url: form.accessories_url || "/category/accessories-parts",
            accessories_image: form.accessories_image || "themes/default/assets/img/home/accessories.webp",

            purifier_category_id: form.purifier_category_id || null,
            purifier_title: form.purifier_title || "Air Purifiers",
            purifier_url: form.purifier_url || "/category/air-purifiers",
            purifier_image: form.purifier_image || "themes/default/assets/img/home/air-purifiers.webp",

            home_solutions_category_id: form.home_solutions_category_id || null,
            home_solutions_title: form.home_solutions_title || "Solutions for Home",
            home_solutions_sub: form.home_solutions_sub || "Ventilation and Filtration Solution",
            home_solutions_url: form.home_solutions_url || "/category/home-fresh-air-systems",
            home_solutions_image: form.home_solutions_image || "themes/default/assets/img/home/solutions-home.webp",

            biz_solutions_category_id: form.biz_solutions_category_id || null,
            biz_solutions_title: form.biz_solutions_title || "Solutions for Business",
            biz_solutions_sub: form.biz_solutions_sub || "Air Disinfection & Air Monitoring",
            biz_solutions_url: form.biz_solutions_url || "/category/commercial-fresh-air-systems",
            biz_solutions_image: form.biz_solutions_image || "themes/default/assets/img/home/solutions-business.webp",
        };
    } else if (form.key === "why_choose_aire") {
        data = {
            title: form.title,
            subtitle: form.subtitle,
            cards: form.cards.map(c => ({
                theme: c.theme || "light",
                dots: c.dots || "•••",
                title: c.title || "",
                description: c.description || "",
                content: c.description || "",
                card_class: c.card_class || ""
            }))
        };
    } else if (form.key === "trust_badges") {
        data = {
            badges: form.badges.map(b => ({
                icon: b.icon || "bi-shield-check",
                title: b.title || "",
                description: b.description || ""
            }))
        };
    } else if (form.key === "home_video" || form.key === "video") {
        data = {
            title: form.title || "AIRE Pro S1 — Engineering Architecture & Air Purification",
            image: form.image || "home/video_thumb.png",
            video_url: form.video_url || "storage/home/home-video.mp4",
            video_file: form.video_file || ""
        };
    } else if (form.key === "home_faq" || form.key === "faq") {
        data = {
            badge: form.badge || "SUPPORT",
            title: form.title || "Frequently Asked Questions",
            subtitle: form.subtitle || "",
            items: form.items.map(it => ({
                question: it.question || "",
                answer: it.answer || ""
            }))
        };
    } else if (form.key === "home_lifestyle" || form.key === "lifestyle") {
        data = {
            badge: form.badge || "LIFESTYLE",
            title: form.title,
            subtitle: form.subtitle,
            items: form.items.map(it => ({
                title: it.title || "",
                description: it.description || "",
                image: it.image || ""
            }))
        };
    } else if (form.key === "home_benefits" || form.key === "benefits") {
        data = {
            badge: form.badge || "BENEFITS",
            title: form.title,
            subtitle: form.subtitle,
            image: form.image || "themes/default/assets/img/benifits-bg.png",
            cards: form.cards.map(c => ({
                title: c.title || "",
                description: c.description || ""
            }))
        };
    } else if (['home_best_selling', 'best_selling', 'home_new_arrival', 'new_arrival', 'home_customer_favorites', 'customer_favorites'].includes(form.key)) {
        const isFav = ['home_customer_favorites', 'customer_favorites'].includes(form.key);
        const isNew = ['home_new_arrival', 'new_arrival'].includes(form.key);

        data = {
            badge: form.badge || (isFav ? 'Customers Favorites' : (isNew ? 'New arrival' : 'Product')),
            title: form.title || (isFav ? 'Loved by Our Community' : (isNew ? 'Freshly Launched Models' : 'Best Selling Product')),
            subtitle: form.subtitle || "",
            product_ids: Array.isArray(form.product_ids) ? form.product_ids.map(Number).filter(n => !isNaN(n) && n > 0) : [],
        };
    } else if (['home_living_hero', 'living_hero'].includes(form.key)) {
        data = {
            enabled: form.enabled !== undefined ? Number(form.enabled) : 1,
            badge: form.badge || "INNOVATION",
            title: form.title || "",
            subtitle: form.description || form.subtitle || "",
            description: form.description || form.subtitle || "",
            button_text: form.button_text || "Buy Now",
            product_id: form.product_id ? Number(form.product_id) : null,
            image: form.image || "themes/default/assets/img/background-without-product.png",
        };
    } else if (form.key === "about_hero") {
        data = {
            badge: form.badge,
            title: form.title,
            subtitle: form.subtitle
        };
    } else if (form.key === "about_story") {
        data = {
            number: form.number,
            title: form.title,
            subtitle: form.subtitle,
            hero_title: form.hero_title,
            hero_desc: form.hero_desc,
            hero_image: form.hero_image,
            hero_badge: form.hero_badge,
            button_text: form.button_text,
            button_link: form.button_link,
            milestones: form.milestones.map(m => ({
                year: m.year || "",
                title: m.title || "",
                desc: m.desc || ""
            })),
            impact_title: form.impact_title,
            impact_desc: form.impact_desc,
            impact_image: form.impact_image,
            impact_badge: form.impact_badge,
            stats: form.stats.map(s => ({
                icon: s.icon || "",
                title: s.title || "",
                desc: s.desc || ""
            })),
            quote: form.quote,
            quote_brand: form.quote_brand
        };
    } else if (form.key === "about_mission_vision") {
        data = {
            number: form.number,
            title: form.title,
            subtitle: form.subtitle,
            purpose_title: form.purpose_title,
            purpose_desc: form.purpose_desc,
            purpose_image: form.purpose_image,
            purpose_badge: form.purpose_badge,
            mission_title: form.mission_title,
            mission_desc: form.mission_desc,
            vision_title: form.vision_title,
            vision_desc: form.vision_desc,
            values: form.values.map(v => ({
                icon: v.icon || "",
                title: v.title || "",
                desc: v.desc || ""
            })),
            quote: form.quote,
            quote_brand: form.quote_brand
        };
    } else if (form.key === "about_leadership") {
        data = {
            number: form.number,
            title: form.title,
            subtitle: form.subtitle,
            banner_badge: form.banner_badge,
            banner_title: form.banner_title,
            banner_desc: form.banner_desc,
            banner_image: form.banner_image,
            banner_badge_text: form.banner_badge_text,
            team_heading: form.team_heading,
            team_subheading: form.team_subheading,
            members: form.members.map(m => ({
                name: m.name || "",
                role: m.role || "",
                bio: m.bio || "",
                image: m.image || ""
            })),
            quote: form.quote,
            quote_brand: form.quote_brand
        };
    } else if (['about_innovation', 'about_quality', 'about_global'].includes(form.key)) {
        data = {
            number: form.number,
            title: form.title,
            subtitle: form.subtitle,
            items: form.items.map(it => ({
                icon: it.icon || "",
                title: it.title || "",
                desc: it.desc || ""
            }))
        };
    } else if (form.key === "about_careers") {
        data = {
            number: form.number,
            title: form.title,
            subtitle: form.subtitle,
            card_title: form.card_title,
            card_desc: form.card_desc,
            button_text: form.button_text,
            button_link: form.button_link
        };
    } else if (form.key === "about_news") {
        data = {
            number: form.number,
            title: form.title,
            subtitle: form.subtitle,
            banner_title: form.banner_title,
            banner_desc: form.banner_desc,
            button_text: form.button_text,
            button_link: form.button_link
        };
    } else {
        data = {
            title: form.title,
            content: form.content,
            home_content: form.home_content || null,
            image: form.image || null,
            status: form.status,
        };
    }

    const payload = new FormData();
    const specialKeys = [
        "home_category_grid", "why_choose_aire", "trust_badges", "home_benefits", "benefits",
        "home_lifestyle", "lifestyle", "home_faq", "faq", "home_video", "video",
        "home_best_selling", "best_selling", "home_new_arrival", "new_arrival",
        "home_customer_favorites", "customer_favorites", "home_living_hero", "living_hero",
        "about_hero", "about_story", "about_mission_vision", "about_leadership",
        "about_innovation", "about_quality", "about_careers", "about_news", "about_global"
    ];
    if (!previews.value[0] && !specialKeys.includes(form.key)) {
        payload.append('remove_image', 1);
    }
    payload.append("data", JSON.stringify(data));

    if (form.key === "home_category_grid") {
        Object.keys(gridFiles).forEach(k => {
            if (gridFiles[k]) {
                payload.append(k, gridFiles[k]);
            }
        });
    }

    if (["home_lifestyle", "lifestyle"].includes(form.key) && form.items) {
        form.items.forEach((it, idx) => {
            const itemFile = it.dropzoneFile?.[0]?.file || (it.dropzoneFile?.[0] instanceof File ? it.dropzoneFile[0] : null);
            if (itemFile) {
                payload.append(`item_image_${idx}`, itemFile);
            }
        });
    }

    const mainFile = fileUpload.value?.[0]?.file || (fileUpload.value?.[0] instanceof File ? fileUpload.value[0] : null);
    if (mainFile) {
        payload.append("image", mainFile);
    }
    // Append any uploaded about section banner images
    Object.keys(aboutImageFiles).forEach((field) => {
        if (aboutImageFiles[field]) {
            payload.append(field, aboutImageFiles[field]);
        }
    });
    if (selectedVideoFile.value) {
        payload.append("video_file", selectedVideoFile.value);
    }
    if (removeVideoFlag.value) {
        payload.append("remove_video", 1);
    }

    try {
        await axios.post(`/api/sections/${form.id}?_method=PUT`, payload, {
            headers: { "Content-Type": "multipart/form-data" },
        });
        toast.success("Section updated successfully");
        if (form.key.startsWith('about_')) {
            router.push({ name: "AboutSections" });
        } else if (window.history.state?.back || window.history.length > 1) {
            router.back();
        } else {
            router.push({
                name: "Section",
            });
        }
    } catch (err) {
        toast.validationError(err);
    } finally {
        saving.value = false;
    }
};

onMounted(async () => {
    await fetchSections();
});
</script>

<style scoped>
.update-section-page {
    /* Page wrapper styling */
}
</style>
