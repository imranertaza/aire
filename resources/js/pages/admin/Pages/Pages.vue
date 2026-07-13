<template>
    <DashboardHeader title="Manage Pages">
        <div class="d-flex justify-content-end">
            <SearchBox @search="onSearch" />
        </div>
    </DashboardHeader>

    <section class="">
        <div class="row">
            <div class="col-md-12">
                <div v-if="pages?.data?.length === 0" class="alert alert-info">
                    No pages found.
                </div>
                <div v-else>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr class="align-middle">
                                    <th style="width: 10px">#</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th v-if="authStore.hasPermission('publish-pages')">Status</th>
                                    <th>Template</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(page, index) in pages?.data" :key="page.id">
                                    <td class="align-middle">{{ index + 1 }}</td>
                                    <td class="align-middle">{{ truncateText(page.page_title, 20) }}</td>
                                    <td class="align-middle">{{ truncateText(page.short_des, 50) }}</td>
                                    <td class="align-middle">
                                        <img v-if="page.f_image" :src="getImageCacheUrl(page.f_image, 100, 100)"
                                            alt="Page Image" height="50" class="rounded" />
                                    </td>
                                    <td v-if="authStore.hasPermission('publish-pages')" class="align-middle">
                                        <select v-model="page.status" @change="updateStatus(page)" class="custom-select"
                                            :class="page.status === 'Active'
                                                    ? 'bg-success text-white'
                                                    : 'bg-transparent text-dark'
                                                ">
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </td>
                                    <td class="align-middle">{{ page.temp }}</td>
                                    <td class="align-middle">
                                        <div class="d-flex">
                                            <router-link v-if="authStore.hasPermission('view-pages')"
                                                :to="{ name: 'ShowPage', params: { id: page.id } }"
                                                class="btn btn-sm btn-outline-dark">
                                                <i class="fas fa-eye"></i>
                                            </router-link>
                                            <router-link v-if="authStore.hasPermission('edit-pages')"
                                                :to="{ name: 'UpdatePages', params: { id: page.id } }"
                                                class="ml-2 btn btn-sm btn-outline-info">
                                                <i class="fas fa-pencil-alt"></i>
                                            </router-link>

                                            <button v-if="authStore.hasPermission('delete-pages')"
                                                class="ml-2 btn btn-sm btn-outline-danger" @click="confirmDelete(page)">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :pData="pages" @page-change="fetchPages" />
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import DashboardHeader from "@/components/DashboardHeader.vue";
import Pagination from "@/components/Paginations/Pagination.vue";
import { useToast } from "@/composables/useToast";
import { getImageUrl, truncateText, getImageCacheUrl } from "@/layouts/helpers/helpers";
import { useAuthStore } from "@/store/auth";
import axios from "axios";
import { inject, onMounted, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import SearchBox from "@/components/SearchBox.vue";

const toast = useToast();
const authStore = useAuthStore();
const route = useRoute();
const pages = ref([]);
const $swal = inject("$swal");
const router = useRouter();
const currentSearchTerm = ref("");
const fetchPages = async (page = 1) => {
    try {
        const res = await axios.get(`/api/pages?page=${page}&search=${currentSearchTerm.value}`);
        pages.value = res.data.data;
    } catch (error) {
        console.error(error);
    }
};

const onSearch = (term) => {
    currentSearchTerm.value = term;
    fetchPages();
};

onMounted(async () => {
    fetchPages();

    if (route.query.toast) {
        toast.success(route.query.toast);
        setTimeout(() => {
            const q = { ...route.query };
            delete q.toast;

            router.replace({ query: q });
        }, 2000);
    }
});

const updateStatus = async (page) => {
    try {
        const response = await axios.patch(`/api/pages/${page.id}/status`, {
            status: page.status,
        });

        if (response.data.status === "Active") {
            toast.success("Page activated");
        } else {
            toast.info("Page deactivated");
        }
    } catch (error) {
        toast.validationError(error);
    }
};

const confirmDelete = async (page) => {
    const result = await $swal({
        title: `Delete "${page.page_title}"?`,
        text: "This action cannot be undone.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete",
        cancelButtonText: "Cancel",
        reverseButtons: true,
    });

    if (result.isConfirmed) {
        try {
            await axios.delete(`/api/pages/${page.id}`);
            toast.success("Page deleted successfully!");
            pages.value.data = pages.value.data.filter((p) => p.id !== page.id);
        } catch (error) {
            toast.validationError(error);
        }
    } else {
        toast.info("Deletion cancelled.");
    }
};
</script>
