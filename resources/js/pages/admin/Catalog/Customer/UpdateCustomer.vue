<template>
    <DashboardHeader title="Update Customer" />
    <section class="content" v-if="!loading">
        <div class="container-fluid">
            <div class="row row-cols-1">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Update Customer</h3>
                    </div>

                    <form @submit.prevent="submitBasic">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input v-model="basicForm.firstname" type="text" class="form-control" placeholder="First Name" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input v-model="basicForm.lastname" type="text" class="form-control" placeholder="Last Name" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input v-model="basicForm.email" type="email" class="form-control" placeholder="Email Address" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input v-model="basicForm.phone" type="text" class="form-control" placeholder="Phone Number" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Password <small class="text-muted">(leave blank to keep current)</small></label>
                                        <input v-model="basicForm.password" type="password" class="form-control" placeholder="Password" />
                                    </div>
                                    <div class="form-group" v-if="basicForm.password">
                                        <label>Confirm Password</label>
                                        <input v-model="basicForm.con_password" type="password" class="form-control" placeholder="Confirm Password" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info" :disabled="saving">
                                <span v-if="saving" class="spinner-border spinner-border-sm mr-1"></span>
                                Update
                            </button>
                            <RouterLink :to="{ name: 'Customers' }" class="btn btn-danger ml-2">Back</RouterLink>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <div v-else class="text-center my-5">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</template>

<script setup>
import DashboardHeader from '@/components/DashboardHeader.vue';
import axios from 'axios';
import { onMounted, reactive, ref } from 'vue';
import { useToast } from '@/composables/useToast';
import { useRoute, useRouter } from 'vue-router';

const toast = useToast();
const route = useRoute();
const router = useRouter();

const loading = ref(true);
const saving = ref(false);

const basicForm = reactive({
    firstname: '',
    lastname: '',
    email: '',
    phone: '',
    password: '',
    con_password: ''
});

const fetchCustomer = async () => {
    try {
        const res = await axios.get(`/api/customers/${route.params.id}`);
        const c = res.data.data;
        
        basicForm.firstname = c.firstname;
        basicForm.lastname = c.lastname;
        basicForm.email = c.email;
        basicForm.phone = c.phone;
    } catch (error) {
        toast.error('Failed to load customer details.');
        router.push({ name: 'Customers' });
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    fetchCustomer();
});

const submitBasic = async () => {
    saving.value = true;
    try {
        await axios.put(`/api/customers/${route.params.id}`, basicForm);
        toast.success('Customer updated successfully!');
        router.push({ name: 'Customers' });
    } catch (error) {
        toast.validationError(error);
    } finally {
        saving.value = false;
    }
};
</script>
