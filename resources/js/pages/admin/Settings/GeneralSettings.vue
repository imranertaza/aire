<template>
    <DashboardHeader title="General Settings" />

    <section class="container py-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <!-- Tabs Navigation -->
                <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="branding-tab" data-toggle="tab" href="#branding"
                            role="tab">Branding</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="general-tab" data-toggle="tab" href="#general" role="tab">General</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="mail-tab" data-toggle="tab" href="#mail" role="tab">Mail</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="security-tab" data-toggle="tab" href="#security" role="tab">Security</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="social-tab" data-toggle="tab" href="#social" role="tab">Social</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="seo-tab" data-toggle="tab" href="#seo" role="tab">SEO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="opengraph-tab" data-toggle="tab" href="#opengraph" role="tab">Open
                            Graph</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="twittercard-tab" data-toggle="tab" href="#twittercard"
                            role="tab">Twitter Card</a>
                    </li>
                </ul>

                <!-- Tabs Content -->
                <form @submit.prevent="submitSettings" class="tab-content mt-4">

                    <!-- Branding Tab -->
                    <div class="tab-pane fade show active" id="branding" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Store Logo</label>
                                <Vue3Dropzone v-model="logoFile" v-model:previews="logoPreview" mode="edit"
                                    :allowSelectOnPreview="true" :maxFiles="1" />
                                <small class="text-muted">Recommended:300 × 40px</small>

                                <div v-if="logoPreview.length" class="mt-2">
                                    <img :src="logoPreview[0]" alt="Logo Preview" class="bg-dark img-thumbnail"
                                        style="width:120px;height:auto;" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Footer Logo</label>
                                <Vue3Dropzone v-model="footerLogoFile" v-model:previews="footerLogoPreview" mode="edit"
                                    :allowSelectOnPreview="true" :maxFiles="1" />
                                <small class="text-muted">Recommended:300 × 40px</small>

                                <div v-if="footerLogoPreview.length" class="mt-2">
                                    <img :src="footerLogoPreview[0]" alt="Footer Logo Preview" class="img-thumbnail"
                                        style="width:120px;height:auto;" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Store Icon (Favicon)</label>
                                <Vue3Dropzone v-model="faviconFile" v-model:previews="faviconPreview" mode="edit"
                                    :allowSelectOnPreview="true" :maxFiles="1" />
                                <small class="text-muted">Recommended:64 × 64px</small>

                                <div v-if="faviconPreview.length" class="mt-2">
                                    <img :src="faviconPreview[0]" alt="Favicon Preview" class="img-thumbnail"
                                        style="width:40px;height:40px;" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Brand Name</label>
                                <input v-model="form.brand_name" type="text" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <!-- General Tab -->
                    <div class="tab-pane fade" id="general" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Address</label>
                                <textarea v-model="form.address" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input v-model="form.email" type="email" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input v-model="form.phone" type="text" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">State</label>
                                <input v-model="form.state" type="text" class="form-control" />
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <label class="form-label">Breadcrumb Image</label>
                                <Vue3Dropzone v-model="BreadcrumbFile" v-model:previews="BreadcrumbFilePreview"
                                    mode="edit" :allowSelectOnPreview="true" :maxFiles="1" />
                                <small class="text-muted">Recommended:1351 × 300px</small>

                                <div v-if="BreadcrumbFilePreview.length" class="mt-2">
                                    <img :src="BreadcrumbFilePreview[0]" alt="Favicon Preview" height="300"
                                        class="img-thumbnail" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mail Tab -->
                    <div class="tab-pane fade" id="mail" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mail Protocol</label>
                                <select v-model="form.mail_protocol" class="form-control">
                                    <option value="smtp">SMTP</option>
                                    <option value="mail">Mail</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Receive Mail Address</label>
                                <input v-model="form.mail_address" type="email" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Send From Mail Address</label>
                                <input v-model="form.send_from" type="email" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">SMTP Host</label>
                                <input v-model="form.smtp_host" type="text" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">SMTP Username</label>
                                <input v-model="form.smtp_username" type="text" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">SMTP Password</label>
                                <input v-model="form.smtp_password" type="password" class="form-control"
                                    autocomplete="new-password" />
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">SMTP Port</label>
                                <input v-model="form.smtp_port" type="text" class="form-control" />
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">SMTP Timeout</label>
                                <input v-model="form.smtp_timeout" type="text" class="form-control" />
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">SMTP Crypto</label>
                                <select v-model="form.smtp_crypto" class="form-control">
                                    <option value="ssl">SSL</option>
                                    <option value="tls">TLS</option>
                                    <option value="">None</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Security Tab -->
                    <div class="tab-pane fade" id="security" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input v-model="form.use_recaptcha" :checked="form.use_recaptcha == 1"
                                        type="checkbox" class="form-check-input" id="useRecaptcha">
                                    <label class="form-check-label" for="useRecaptcha">
                                        Enable Google reCAPTCHA
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">reCAPTCHA Site Key</label>
                                <input v-model="form.nocaptcha_sitekey" type="text" class="form-control"
                                    placeholder="Enter Site Key" />
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">reCAPTCHA Secret Key</label>
                                <input v-model="form.nocaptcha_secret" type="text" class="form-control"
                                    placeholder="Enter Secret Key" />
                            </div>
                        </div>
                    </div>

                    <!-- Social Tab -->
                    <div class="tab-pane fade" id="social" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Facebook URL</label>
                                <input v-model="form.fb_url" type="url" class="form-control"
                                    placeholder="https://facebook.com/..." />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Twitter URL</label>
                                <input v-model="form.twitter_url" type="url" class="form-control"
                                    placeholder="https://twitter.com/..." />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Linkedin URL</label>
                                <input v-model="form.linkedin_url" type="url" class="form-control"
                                    placeholder="https://linkedin.com/..." />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Instagram URL</label>
                                <input v-model="form.instagram_url" type="url" class="form-control"
                                    placeholder="https://instagram.com/..." />
                            </div>
                        </div>
                    </div>

                    <!-- SEO Tab -->
                    <div class="tab-pane fade" id="seo" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Meta Title</label>
                                <input v-model="form.meta_title" type="text" class="form-control" />
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Meta Keyword</label>
                                <input v-model="form.meta_keyword" type="text" class="form-control" />
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Meta Description</label>
                                <input v-model="form.meta_description" type="text" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Meta Author</label>
                                <input v-model="form.meta_author" type="text" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Meta News Keywords</label>
                                <input v-model="form.meta_news_keywords" type="text" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <!-- Open Graph Tab -->
                    <div class="tab-pane fade" id="opengraph" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">OG Type</label>
                                <input v-model="form.og_type" type="text" class="form-control"
                                    placeholder="e.g. website" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">OG Title</label>
                                <input v-model="form.og_title" type="text" class="form-control" />
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">OG Description</label>
                                <textarea v-model="form.og_description" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">OG Image</label>
                                <Vue3Dropzone v-model="ogImageFile" v-model:previews="ogImagePreview" mode="edit"
                                    :allowSelectOnPreview="true" :maxFiles="1" />
                                <small class="text-muted">Recommended: 1200×630px</small>

                                <div v-if="ogImagePreview.length" class="mt-2">
                                    <img :src="ogImagePreview[0]" alt="OG Image Preview" class="img-thumbnail"
                                        style="max-width:250px;height:auto;" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">OG Image Width</label>
                                <input v-model="form.og_image_width" type="number" class="form-control" />
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">OG Image Height</label>
                                <input v-model="form.og_image_height" type="number" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <!-- Twitter Card Tab -->
                    <div class="tab-pane fade" id="twittercard" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Twitter Card Type</label>
                                <input v-model="form.twitter_card" type="text" class="form-control"
                                    placeholder="e.g. summary_large_image" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Twitter Title</label>
                                <input v-model="form.twitter_title" type="text" class="form-control" />
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Twitter Description</label>
                                <textarea v-model="form.twitter_description" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Twitter Image</label>
                                <Vue3Dropzone v-model="twitterImageFile" v-model:previews="twitterImagePreview"
                                    mode="edit" :allowSelectOnPreview="true" :maxFiles="1" />
                                <small class="text-muted">Recommended: 1200×628px</small>
                                <div v-if="twitterImagePreview.length" class="mt-2">
                                    <img :src="twitterImagePreview[0]" alt="Twitter Image Preview" class="img-thumbnail"
                                        style="max-width:250px;height:auto;" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Twitter Domain</label>
                                <input v-model="form.twitter_domain" type="url" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-5 text-end">
                        <button type="submit" class="btn btn-primary px-5">Save Settings</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>
<script setup>
import DashboardHeader from '@/components/DashboardHeader.vue';
import { useToast } from '@/composables/useToast';
import { getImageUrl } from '@/layouts/helpers/helpers';
import Vue3Dropzone from '@jaxtheprime/vue3-dropzone';
import '@jaxtheprime/vue3-dropzone/dist/style.css';
import axios from 'axios';
import { onMounted, ref } from 'vue';

/**
 * Global Settings Management Page
 *
 * Allows administrators to update site-wide settings including:
 * - Store information (address, contact details)
 * - Branding assets (logos, favicon, breadcrumb, OG/Twitter images)
 * - Mail server configuration
 * - Social media links
 * - SEO & Open Graph metadata
 * - reCAPTCHA security settings
 *
 * Settings are fetched from the backend on mount and submitted as multipart/form-data.
 */

const toast = useToast();

// Main form state - contains all text, email, URL, and boolean settings
const form = ref({
    address: '',
    email: '',
    phone: '',
    state: '',
    brand_name: '',
    mail_protocol: '',
    mail_address: '',
    send_from: '',
    smtp_host: '',
    smtp_username: '',
    smtp_password: '',
    smtp_port: '',
    smtp_timeout: '',
    smtp_crypto: '',
    fb_url: '',
    twitter_url: '',
    linkedin_url: '',
    instagram_url: '',
    meta_title: '',
    meta_keyword: '',
    meta_description: '',
    meta_author: '',
    meta_news_keywords: '',
    og_type: '',
    og_title: '',
    og_description: '',
    og_image_width: '',
    og_image_height: '',
    twitter_card: '',
    twitter_title: '',
    twitter_description: '',
    twitter_domain: '',
    // Security / reCAPTCHA
    use_recaptcha: false,
    nocaptcha_sitekey: '',
    nocaptcha_secret: '',
});

// Dropzone file references (new uploads)
const logoFile = ref([]);
const footerLogoFile = ref([]);
const faviconFile = ref([]);
const BreadcrumbFile = ref([]);
const ogImageFile = ref([]);
const twitterImageFile = ref([]);

// Preview URLs for currently saved images
const logoPreview = ref([]);
const footerLogoPreview = ref([]);
const faviconPreview = ref([]);
const BreadcrumbFilePreview = ref([]);
const ogImagePreview = ref([]);
const twitterImagePreview = ref([]);

// Fetch all settings from database and populate form + previews
const fetchSettings = async () => {
    try {
        const { data } = await axios.get('/api/settings');
        const settings = data.data || [];

        settings.forEach(s => {
            const key = s.label;
            const value = s.value;

            // Populate text/numeric fields
            if (form.value.hasOwnProperty(key)) {
                if (key === 'use_recaptcha') {
                    form.value[key] = value === '1' || value === true;
                } else {
                    form.value[key] = value ?? '';
                }
            }

            // Generate preview URLs for existing images
            if (key === 'store_logo' && value) logoPreview.value = [getImageUrl(value)];
            if (key === 'footer_logo' && value) footerLogoPreview.value = [getImageUrl(value)];
            if (key === 'store_icon' && value) faviconPreview.value = [getImageUrl(value)];
            if (key === 'breadcrumb' && value) BreadcrumbFilePreview.value = [getImageUrl(value)];
            if (key === 'og_image' && value) ogImagePreview.value = [getImageUrl(value)];
            if (key === 'twitter_image' && value) twitterImagePreview.value = [getImageUrl(value)];
        });
    } catch (e) {
        toast.validationError(e);
    }
};

// Fetch reCAPTCHA-specific settings (from config, not DB)
const fetchSecuritySettings = async () => {
    try {
        const { data } = await axios.get('/api/settings/security');
        form.value.use_recaptcha = data.use_recaptcha;
        form.value.nocaptcha_sitekey = data.nocaptcha_sitekey;
        form.value.nocaptcha_secret = data.nocaptcha_secret;
    } catch (e) {
        toast.validationError(e);
    }
};

// Submit all settings (text + new file uploads)
const submitSettings = async () => {
    const payload = new FormData();

    // Append all form fields (convert boolean to '1'/'0' for backend)
    Object.entries(form.value).forEach(([key, value]) => {
        if (typeof value === 'boolean') {
            payload.append(key, value ? '1' : '0');
        } else {
            payload.append(key, value ?? '');
        }
    });

    // Append new uploaded files only if selected
    if (logoFile.value[0]?.file) payload.append('store_logo', logoFile.value[0].file);
    if (footerLogoFile.value[0]?.file) payload.append('footer_logo', footerLogoFile.value[0].file);
    if (faviconFile.value[0]?.file) payload.append('store_icon', faviconFile.value[0].file);
    if (BreadcrumbFile.value[0]?.file) payload.append('breadcrumb', BreadcrumbFile.value[0].file);
    if (ogImageFile.value[0]?.file) payload.append('og_image', ogImageFile.value[0].file);
    if (twitterImageFile.value[0]?.file) payload.append('twitter_image', twitterImageFile.value[0].file);

    // if remove any one
    if (!logoPreview.value[0]) payload.append('remove_store_logo', 1);
    if (!footerLogoPreview.value[0]) payload.append('remove_footer_logo', 1);
    if (!faviconPreview.value[0]) payload.append('remove_store_icon', 1);
    if (!BreadcrumbFilePreview.value[0]) payload.append('remove_breadcrumb', 1);
    if (!ogImagePreview.value[0]) payload.append('remove_og_image', 1);
    if (!twitterImagePreview.value[0]) payload.append('remove_twitter_image', 1);
    try {
        await axios.post('/api/settings/update', payload, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
        toast.success('Settings saved successfully');
    } catch (error) {
        toast.validationError(error);
    }
};

// Load data when component mounts
onMounted(() => {
    fetchSettings();
    fetchSecuritySettings();
});
</script>

<style scoped>
.form-check-input {
    transform: scale(1.2);
}
</style>
