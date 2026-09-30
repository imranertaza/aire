<template>
    <DashboardHeader :title="'Update Section: ' + (form.key || 'client_testimonials')">
        <div class="d-flex justify-content-end align-items-center">
            <button type="button" @click="saveTestimonials" class="btn btn-primary" :disabled="saving">
                <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving...' : 'Save Section' }}
            </button>
            <router-link :to="{ name: 'Section' }" class="btn btn-secondary ml-2">
                <i class="fas fa-times mr-1"></i> Cancel
            </router-link>
        </div>
    </DashboardHeader>

    <section class="content">
        <div class="container-fluid">
            <!-- Loading Indicator -->
            <div v-if="loading" class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="text-muted mt-2">Loading testimonials section...</p>
            </div>

            <div v-else>
                <!-- 1. Section Settings Card -->
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-sliders-h mr-1"></i> Section Settings
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Section Title <span class="text-danger">*</span></label>
                                    <input v-model="form.title" type="text" class="form-control"
                                        placeholder="e.g. Purity in Practice" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Subtitle / Tagline</label>
                                    <input v-model="form.subtitle" type="text" class="form-control"
                                        placeholder="e.g. CLIENT TESTIMONIALS" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Testimonial Slides Manager Card -->
                <div class="card card-purple card-outline">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            <i class="fas fa-quote-left mr-1"></i> Testimonial Slides ({{ form.items.length }})
                        </h3>
                        <div class="card-tools ml-auto">
                            <button type="button" class="btn btn-sm btn-success" @click="addItem">
                                <i class="fas fa-plus mr-1"></i> Add New Slide
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div v-if="form.items.length === 0" class="text-center py-4 text-muted">
                            <i class="fas fa-comments fa-2x mb-2 text-secondary"></i>
                            <p>No testimonial slides found. Click "Add New Slide" to create one.</p>
                        </div>

                        <div v-else class="row">
                            <div class="col-md-6 mb-3" v-for="(item, index) in form.items" :key="index">
                                <div class="card card-outline card-purple">
                                    <div class="card-header py-2">
                                        <h3 class="card-title font-weight-bold" style="font-size: 0.95rem;">
                                            <span class="badge badge-purple">Slide {{ index + 1 }}</span>
                                            <span class="ml-2">{{ item.name || 'Untitled Client' }}</span>
                                            <small v-if="item.role" class="text-muted ml-1">({{ item.role }})</small>
                                        </h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" :disabled="index === 0"
                                                @click="moveItem(index, -1)" title="Move Up">
                                                <i class="fas fa-arrow-up"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool"
                                                :disabled="index === form.items.length - 1" @click="moveItem(index, 1)"
                                                title="Move Down">
                                                <i class="fas fa-arrow-down"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool text-danger"
                                                :disabled="form.items.length <= 1" @click="removeItem(index)"
                                                title="Remove Slide">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="card-body py-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label class="small font-weight-bold">Client Name <span class="text-danger">*</span></label>
                                                    <input v-model="item.name" type="text" class="form-control form-control-sm"
                                                        placeholder="e.g. Sarah Jenkins" required />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label class="small font-weight-bold">Role / Job Title</label>
                                                    <input v-model="item.role" type="text" class="form-control form-control-sm"
                                                        placeholder="e.g. INTERIOR ARCHITECT" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label class="small font-weight-bold">Rating (1-5)</label>
                                                    <select v-model.number="item.rating" class="custom-select custom-select-sm">
                                                        <option :value="5">⭐⭐⭐⭐⭐ (5 Stars)</option>
                                                        <option :value="4">⭐⭐⭐⭐ (4 Stars)</option>
                                                        <option :value="3">⭐⭐⭐ (3 Stars)</option>
                                                        <option :value="2">⭐⭐ (2 Stars)</option>
                                                        <option :value="1">⭐ (1 Star)</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label class="small font-weight-bold">Avatar Image URL</label>
                                                    <div class="input-group input-group-sm">
                                                        <input v-model="item.avatar" type="text" class="form-control form-control-sm"
                                                            placeholder="https://... or image url" />
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-outline-secondary"
                                                                @click="generateInitialsAvatar(index)" title="Generate initials avatar">
                                                                <i class="fas fa-magic"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label class="small font-weight-bold">Avatar Upload (Optional Dropzone)</label>
                                            <Vue3Dropzone v-model="item.dropzoneFile" v-model:previews="item.avatarPreviews"
                                                mode="edit" :allowSelectOnPreview="true" :maxFiles="1" />
                                            <small class="text-muted d-block mt-1">Recommended: 100 × 100px or 120 × 120px (1:1 Square avatar, rounded display)</small>
                                            <div v-if="item.avatarPreviews?.length" class="mt-2 d-flex align-items-center">
                                                <img :src="item.avatarPreviews[0]" class="rounded-circle border mr-2" width="38" height="38" style="object-fit: cover;" />
                                                <small class="text-muted">Selected photo</small>
                                            </div>
                                            <div v-else-if="item.avatar" class="mt-2 d-flex align-items-center">
                                                <img :src="getAvatarDisplayUrl(item)" class="rounded-circle border mr-2" width="38" height="38" style="object-fit: cover;" @error="onImgError($event, item.name)" />
                                                <small class="text-muted">Current avatar</small>
                                            </div>
                                        </div>

                                        <div class="form-group mb-0">
                                            <label class="small font-weight-bold">Testimonial Quote <span class="text-danger">*</span></label>
                                            <textarea v-model="item.quote" rows="3" class="form-control form-control-sm"
                                                placeholder="Write client testimonial quote here..." required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-success" @click="addItem">
                            <i class="fas fa-plus mr-1"></i> Add Another Slide
                        </button>
                        <div>
                            <button type="button" @click="saveTestimonials" class="btn btn-primary" :disabled="saving">
                                <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving...' : 'Save & Update Section' }}
                            </button>
                            <router-link :to="{ name: 'Section' }" class="btn btn-secondary ml-2">
                                Cancel
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import DashboardHeader from '@/components/DashboardHeader.vue';
import Vue3Dropzone from '@jaxtheprime/vue3-dropzone';
import '@jaxtheprime/vue3-dropzone/dist/style.css';
import { getImageUrl } from '@/layouts/helpers/helpers';
import { useToast } from '@/composables/useToast';

const router = useRouter();
const toast = useToast();

const loading = ref(true);
const saving = ref(false);

const form = reactive({
    id: null,
    key: 'client_testimonials',
    title: 'Purity in Practice',
    subtitle: 'CLIENT TESTIMONIALS',
    items: []
});

// Default starting slides if empty
const defaultSlides = [
    {
        name: 'Sarah Jenkins',
        role: 'INTERIOR ARCHITECT',
        avatar: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=120&q=80',
        rating: 5,
        quote: "The AIRE Pro S1 is not just an air purifier; it's a piece of architectural art that has transformed our living environment."
    },
    {
        name: 'Marcus Chen',
        role: 'SENIOR FACILITY MANAGER',
        avatar: 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=120&q=80',
        rating: 5,
        quote: "Unmatched technical precision. The IAQ data reporting is exactly what our facility management team needed for ESG compliance."
    },
    {
        name: 'Dr. Elena Rostova',
        role: 'CLINICAL ALLERGIST',
        avatar: 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=120&q=80',
        rating: 5,
        quote: "The multi-stage filtration system drastically reduced particulate matter in our high-traffic clinic rooms. Absolutely vital for our patients."
    },
    {
        name: 'David Sterling',
        role: 'SUSTAINABILITY DIRECTOR',
        avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80',
        rating: 5,
        quote: "Combining whisper-quiet acoustics with verifiable CADR performance has made AIRE our go-to partner for premium commercial builds."
    }
];

// Add New Slide
const addItem = () => {
    form.items.push({
        name: '',
        role: '',
        rating: 5,
        quote: '',
        avatar: '',
        dropzoneFile: null,
        avatarPreviews: []
    });
    toast.info('New slide added.');
};

// Remove Slide
const removeItem = (index) => {
    if (form.items.length <= 1) {
        toast.warning('You must keep at least 1 testimonial slide.');
        return;
    }
    form.items.splice(index, 1);
};

// Move Slide Up / Down
const moveItem = (index, delta) => {
    const newIndex = index + delta;
    if (newIndex < 0 || newIndex >= form.items.length) return;
    const moved = form.items.splice(index, 1)[0];
    form.items.splice(newIndex, 0, moved);
};

// Generate initials avatar URL
const generateInitialsAvatar = (index) => {
    const item = form.items[index];
    const name = item.name ? encodeURIComponent(item.name.trim()) : 'Client';
    item.avatar = `https://ui-avatars.com/api/?name=${name}&background=6f42c1&color=fff&size=128`;
    item.avatarPreviews = [item.avatar];
};

// Avatar display fallback
const getAvatarDisplayUrl = (item) => {
    if (item.avatar && item.avatar.trim() !== '') {
        return item.avatar.startsWith('http') ? item.avatar : getImageUrl(item.avatar);
    }
    const name = item.name ? encodeURIComponent(item.name.trim()) : 'Client';
    return `https://ui-avatars.com/api/?name=${name}&background=6f42c1&color=fff&size=128`;
};

const onImgError = (event, name) => {
    const safeName = name ? encodeURIComponent(name.trim()) : 'Client';
    event.target.src = `https://ui-avatars.com/api/?name=${safeName}&background=6f42c1&color=fff&size=128`;
};

// Fetch Section from API
const fetchTestimonials = async () => {
    loading.value = true;
    try {
        const res = await axios.get('/api/sections/by-name/client_testimonials');
        const sectionData = res.data.data;

        let d = sectionData?.data;
        if (typeof d === 'string') {
            try { d = JSON.parse(d); } catch (e) { }
        }

        form.id = sectionData?.id || null;
        form.key = sectionData?.name || 'client_testimonials';
        form.title = d?.title || 'Purity in Practice';
        form.subtitle = d?.subtitle || 'CLIENT TESTIMONIALS';
        const items = Array.isArray(d?.items) && d.items.length > 0
            ? d.items
            : JSON.parse(JSON.stringify(defaultSlides));

        form.items = items.map(it => ({
            name: it.name || '',
            role: it.role || '',
            rating: Number(it.rating) || 5,
            quote: it.quote || '',
            avatar: it.avatar || '',
            dropzoneFile: null,
            avatarPreviews: it.avatar ? [it.avatar.startsWith('http') ? it.avatar : getImageUrl(it.avatar)] : []
        }));
    } catch (err) {
        console.error('Error loading testimonials section:', err);
        form.items = defaultSlides.map(it => ({
            ...it,
            dropzoneFile: null,
            avatarPreviews: it.avatar ? [it.avatar] : []
        }));
    } finally {
        loading.value = false;
    }
};

// Save Testimonials to API
const saveTestimonials = async () => {
    if (!form.title || form.title.trim() === '') {
        toast.error('Please provide a section title.');
        return;
    }

    if (!form.items || form.items.length === 0) {
        toast.error('Please add at least one testimonial slide.');
        return;
    }

    saving.value = true;
    try {
        const payloadData = {
            title: form.title.trim(),
            subtitle: form.subtitle ? form.subtitle.trim() : '',
            items: form.items.map(it => ({
                name: (it.name || '').trim(),
                role: (it.role || '').trim(),
                avatar: (it.avatar || '').trim(),
                rating: Number(it.rating) || 5,
                quote: (it.quote || '').trim()
            }))
        };

        const formData = new FormData();
        formData.append('data', JSON.stringify(payloadData));

        // Append any new dropzone files for individual items
        form.items.forEach((it, idx) => {
            if (it.dropzoneFile && it.dropzoneFile[0]?.file) {
                formData.append(`item_avatar_${idx}`, it.dropzoneFile[0].file);
            }
        });

        await axios.post('/api/sections/by-name/client_testimonials', formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });

        toast.success('Section updated successfully');
        router.push({
            name: 'Section',
            query: { toast: 'Section updated successfully' }
        });
    } catch (err) {
        console.error('Save error:', err);
        if (toast.validationError) {
            toast.validationError(err);
        } else {
            toast.error(err.response?.data?.message || 'Failed to save testimonials section.');
        }
    } finally {
        saving.value = false;
    }
};

onMounted(() => {
    fetchTestimonials();
});
</script>

<style scoped>
.card-purple.card-outline {
    border-top: 3px solid #6f42c1;
}

.badge-purple {
    background-color: #6f42c1;
    color: #fff;
}
</style>
