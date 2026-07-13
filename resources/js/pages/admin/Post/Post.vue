<template>
  <DashboardHeader title="Manage Post">
    <div class="d-flex justify-content-end">
      <SearchBox @search="onSearch" />
    </div>
  </DashboardHeader>

  <section class="">
    <div class="row">
      <div class="col-md-12">
        <div v-if="posts?.data?.length === 0" class="alert alert-info">
          No posts found.
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
                  <th v-if="authStore.hasPermission('publish-posts')">Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(post, index) in posts?.data" :key="post.id">
                  <td class="align-middle">{{ index + 1 }}</td>
                  <td class="align-middle">{{ truncateText(post.post_title, 20) }}</td>
                  <td class="align-middle">{{ truncateText(post.short_des, 50) }}</td>
                  <td class="align-middle">
                    <img
                      v-if="post.f_image"
                      draggable="false"
                      :src="getImageCacheUrl(post.f_image)"
                      alt="Post Image"
                      height="50"
                      class="rounded"
                    />
                  </td>
                  <td
                    v-if="authStore.hasPermission('publish-posts')"
                    class="align-middle"
                  >
                    <select
                      v-model="post.status"
                      @change="updateStatus(post)"
                      class="custom-select"
                      :class="
                        post.status == 1
                          ? 'bg-success text-white'
                          : 'bg-transparent text-dark'
                      "
                    >
                      <option :value="1">Active</option>
                      <option :value="0">Inactive</option>
                    </select>
                  </td>
                  <td class="align-middle">
                    <div class="d-flex">
                      <router-link
                        v-if="authStore.hasPermission('view-posts')"
                        :to="{ name: 'ShowPost', params: { id: post.id } }"
                        class="btn btn-sm btn-outline-dark"
                      >
                        <i class="fas fa-eye"></i>
                      </router-link>
                      <router-link
                        v-if="authStore.hasPermission('edit-posts')"
                        :to="{ name: 'UpdatePost', params: { id: post.id } }"
                        class="ml-2 btn btn-sm btn-outline-info"
                      >
                        <i class="fas fa-pencil-alt"></i>
                      </router-link>
                      <button
                        v-if="authStore.hasPermission('delete-posts')"
                        class="ml-2 btn btn-sm btn-outline-danger"
                        @click="confirmDelete(post)"
                      >
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <Pagination :pData="posts" @page-change="fetchPage" />
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import axios from "axios";
import DashboardHeader from "@/components/DashboardHeader.vue";
import { inject, onMounted, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import Pagination from "@/components/Paginations/Pagination.vue";
import { useToast } from "@/composables/useToast";
import { getImageUrl, truncateText, getImageCacheUrl } from "@/layouts/helpers/helpers";
import { useAuthStore } from "@/store/auth";
import SearchBox from "@/components/SearchBox.vue";
const router = useRouter();

const route = useRoute();
const posts = ref([]);
const currentSearchTerm = ref("");
const authStore = useAuthStore();
const toast = useToast();
const $swal = inject("$swal");

const fetchPage = async (page = 1) => {
  try {
    const res = await axios.get(`/api/posts?page=${page}&search=${currentSearchTerm.value}`);
    posts.value = res.data.data;
  } catch (error) {
    console.error(error);
  }
};
const onSearch = async (term) => {
  currentSearchTerm.value = term; // save current search
  fetchPage();
};
onMounted(async () => {
  try {
    fetchPage();
  } catch (error) {
    console.error("Error fetching posts:", error);
  }
  if (route.query.toast) {
    toast.success(route.query.toast);
    setTimeout(() => {
      const q = { ...route.query };
      delete q.toast;

      router.replace({ query: q });
    }, 2000);
  }
});

const updateStatus = async (post) => {
  try {
    const response = await axios.patch(`/api/posts/${post.id}/status`, {
      status: post.status,
    });

    if (response.data.status == 1) {
      post.status = 1;
      toast.success("Post published");
    } else {
      post.status = 0;
      toast.info("Post set to draft");
    }
  } catch (error) {
    toast.error("Failed to update status");
    console.error(error);
  }
};

const confirmDelete = async (post) => {
  const result = await $swal({
    title: `Delete "${post.post_title}"?`,
    text: "This action cannot be undone.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete",
    cancelButtonText: "Cancel",
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    try {
      await axios.delete(`/api/posts/${post.id}`);
      toast.success("Post deleted successfully!");

      posts.value.data = posts.value.data.filter((p) => p.id !== post.id);
    } catch (error) {
      toast.validationError(error);
    }
  } else {
    toast.info("Deletion cancelled.");
  }
};
</script>
