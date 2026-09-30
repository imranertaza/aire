<template>
    <DashboardHeader title="Send Email" />

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Compose Email</h3>
                        </div>
                        <form @submit.prevent="sendEmail">
                            <div class="card-body">
                                <div class="form-group">
                                <label for="user">Audience</label>
                                <Multiselect
                                    v-model="form.user"
                                    :options="[
                                        { value: 'subscribe', label: 'All Active Subscribers' },
                                        { value: 'customer', label: 'All Customers' }
                                    ]"
                                    mode="tags"
                                    :searchable="false"
                                    :close-on-select="false"
                                    placeholder="Select Audience..."
                                    :classes="{
                                        container: 'multiselect ' + (errors.user ? 'is-invalid' : ''),
                                    }"
                                />
                                <div class="text-danger small mt-1" v-if="errors.user">{{ errors.user[0] }}</div>
                            </div>
                                 <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <input type="text" v-model="form.subject" id="subject" class="form-control"
                                        placeholder="Email Subject" required :class="{ 'is-invalid': errors.subject }">
                                    <div class="invalid-feedback" v-if="errors.subject">{{ errors.subject[0] }}</div>
                                </div>

                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea v-model="form.message" id="message" class="form-control" rows="8"
                                        placeholder="Enter your message here..." required
                                        :class="{ 'is-invalid': errors.message }"></textarea>
                                    <div class="invalid-feedback" v-if="errors.message">{{ errors.message[0] }}</div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" :disabled="loading">
                                    <span v-if="loading" class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    <i v-else class="fas fa-paper-plane"></i> Send
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useToast } from '@/composables/useToast';
import DashboardHeader from '@/components/DashboardHeader.vue';
import Multiselect from '@vueform/multiselect';
import '@vueform/multiselect/themes/default.css';

const toast = useToast();
const loading = ref(false);
const errors = ref({});



const form = ref({
    user: [],
    subject: '',
    message: ''
});

const sendEmail = async () => {
    loading.value = true;
    errors.value = {};

    try {
        const response = await axios.post('/api/email-send', form.value);
        toast.success(response.data.message || 'Email sent successfully!');

        // Reset form
        form.value = {
            user: [],
            subject: '',
            message: ''
        };
    } catch (error) {
        if (error.response && error.response.status === 422) {
            errors.value = error.response.data.errors || {};
            toast.error('Please fix the errors below.');
        } else if (error.response && error.response.data.message) {
            toast.error(error.response.data.message);
        } else {
            toast.error('Failed to send email.');
        }
    } finally {
        loading.value = false;
    }
};
</script>
