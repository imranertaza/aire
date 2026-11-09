<template>
    <div class="wrapper">
        <Navbar />
        <SidebarVue />
        <div class="content-wrapper" :class="{ 'builder-content-wrapper': isBuilderRoute }">
            <div :class="isBuilderRoute ? 'container-fluid p-2' : 'container-fluid py-4'">
                <router-view />
            </div>
        </div>
        <Footer v-if="!isBuilderRoute" />
    </div>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import Footer from '@/layouts/includes/Footer.vue'
import Navbar from '@/layouts/includes/Navbar.vue'
import "@/assets/dist/css/adminlte.min.css";
import SidebarVue from './includes/SidebarVue.vue';
import 'icheck-bootstrap/icheck-bootstrap.css'

const route = useRoute()
const isBuilderRoute = computed(() => {
    return ['CreateSectionBuilder', 'EditSectionBuilder'].includes(route.name)
})
</script>

<style scoped>
.builder-content-wrapper {
    min-height: calc(100vh - 56px) !important;
}
</style>
