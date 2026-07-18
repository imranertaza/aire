<template>
    <DashboardHeader title="Create Customer" />
    <section class="content">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create Customer</h3>
                    </div>

                    <form @submit.prevent="submitCustomer">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input v-model="form.firstname" type="text" class="form-control" placeholder="First Name" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input v-model="form.lastname" type="text" class="form-control" placeholder="Last Name" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input v-model="form.email" type="email" class="form-control" placeholder="Email Address" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input v-model="form.phone" type="text" class="form-control" placeholder="Phone Number" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input v-model="form.password" type="password" class="form-control" placeholder="Password" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input v-model="form.con_password" type="password" class="form-control" placeholder="Confirm Password" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" :disabled="loading">
                                <span v-if="loading" class="spinner-border spinner-border-sm mr-1"></span>
                                Create
                            </button>
                            <RouterLink :to="{ name: 'Customers' }" class="btn btn-danger ml-2">
                                Back
                            </RouterLink>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import DashboardHeader from '@/components/DashboardHeader.vue';
import axios from 'axios';
import { reactive, ref } from 'vue';
import { useToast } from '@/composables/useToast';
import { useRouter } from 'vue-router';

const toast = useToast();
const router = useRouter();
const loading = ref(false);

const form = reactive({
    firstname: '',
    lastname: '',
    email: '',
    phone: '',
    password: '',
    con_password: ''
});

const submitCustomer = async () => {
    loading.value = true;
    try {
        await axios.post('/api/customers', form);
        toast.success('Customer created successfully!');
        router.push({ name: 'Customers' });
    } catch (error) {
        toast.validationError(error);
    } finally {
        loading.value = false;
    }
};
</script>
