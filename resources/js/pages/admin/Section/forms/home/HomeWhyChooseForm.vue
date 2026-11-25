<template>
    <div class="home-why-choose-form">
        <div class="card card-primary card-outline shadow-sm mb-4">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-sliders-h mr-1 text-primary"></i> Section Settings
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Section Title <span class="text-danger">*</span></label>
                            <input v-model="form.title" type="text" class="form-control"
                                placeholder="e.g. Why Choose AIRE?" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Subtitle / Tagline</label>
                            <input v-model="form.subtitle" type="text" class="form-control"
                                placeholder="e.g. THE AIRE STANDARD" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cards Deck Manager -->
        <div class="card card-purple card-outline shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-layer-group mr-1 text-purple"></i> Stacked Solution Cards ({{ form.cards?.length || 0 }})
                </h3>
                <div class="card-tools ml-auto">
                    <button type="button" class="btn btn-sm btn-success" @click="addCard">
                        <i class="fas fa-plus mr-1"></i> Add Another Card
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3" v-for="(card, index) in form.cards" :key="index">
                        <div class="card border h-100" :class="card.theme === 'dark' ? 'bg-dark text-white' : 'bg-light'">
                            <div class="card-header py-2 d-flex justify-content-between align-items-center"
                                :class="card.theme === 'dark' ? 'bg-secondary text-white' : 'bg-white'">
                                <h3 class="card-title font-weight-bold" style="font-size: 0.95rem;">
                                    <span>Layer #{{ index + 1 }}</span>
                                    <span class="ml-2 font-weight-normal">&mdash; {{ card.title || 'Untitled Card' }}</span>
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" :disabled="index === 0"
                                        @click="moveCard(index, -1)" title="Move Up">
                                        <i class="fas fa-arrow-up"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool"
                                        :disabled="index === form.cards.length - 1"
                                        @click="moveCard(index, 1)" title="Move Down">
                                        <i class="fas fa-arrow-down"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool text-danger"
                                        :disabled="form.cards.length <= 1" @click="removeCard(index)"
                                        title="Remove Card">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body py-3">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group mb-2">
                                            <label class="small font-weight-bold">Card Title <span class="text-danger">*</span></label>
                                            <input v-model="card.title" type="text"
                                                class="form-control form-control-sm" placeholder="e.g. Pure Air Commitment"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group mb-2">
                                            <label class="small font-weight-bold">Theme Style</label>
                                            <select v-model="card.theme" class="custom-select custom-select-sm">
                                                <option value="light">Light Card</option>
                                                <option value="dark">Dark Card</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <label class="small font-weight-bold">Description <span class="text-danger">*</span></label>
                                    <textarea v-model="card.description" rows="3"
                                        class="form-control form-control-sm"
                                        placeholder="Write card description here..." required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-success" @click="addCard">
                    <i class="fas fa-plus mr-1"></i> Add Another Card
                </button>
                <div>
                    <router-link :to="{ name: 'Section' }" class="btn btn-secondary mr-2">
                        Cancel
                    </router-link>
                    <button type="button" @click="$emit('save')" class="btn btn-primary" :disabled="saving">
                        <i class="fas fa-save mr-1"></i> {{ saving ? 'Saving...' : 'Save & Update Section' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
    saving: {
        type: Boolean,
        default: false,
    },
});

defineEmits(['save']);

const addCard = () => {
    if (!props.form.cards) props.form.cards = [];
    const nextLayer = props.form.cards.length + 1;
    props.form.cards.push({
        dots: "•••",
        title: "New Feature",
        description: "Describe this key solution benefit here.",
        theme: "light",
        card_class: `card-layer-${nextLayer}`
    });
};

const removeCard = (index) => {
    if (props.form.cards && props.form.cards.length > 1) {
        props.form.cards.splice(index, 1);
        props.form.cards.forEach((c, idx) => {
            if (c.card_class) {
                c.card_class = `card-layer-${idx + 1}`;
            }
        });
    }
};

const moveCard = (index, delta) => {
    if (!props.form.cards) return;
    const newIndex = index + delta;
    if (newIndex < 0 || newIndex >= props.form.cards.length) return;
    const item = props.form.cards.splice(index, 1)[0];
    props.form.cards.splice(newIndex, 0, item);
    props.form.cards.forEach((c, idx) => {
        if (c.card_class) {
            c.card_class = `card-layer-${idx + 1}`;
        }
    });
};
</script>
