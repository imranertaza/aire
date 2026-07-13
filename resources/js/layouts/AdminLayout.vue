<template>
    <div class="wrapper">
        <Navbar />
        <SidebarVue />
        <div class="content-wrapper">
            <div class="container-fluid py-4">
                <router-view />
            </div>
        </div>
        <Footer />
    </div>
</template>

<script setup>
import Footer from '@/layouts/includes/Footer.vue'
import Navbar from '@/layouts/includes/Navbar.vue'
import "@/assets/dist/css/adminlte.min.css";
import SidebarVue from './includes/SidebarVue.vue';
import 'icheck-bootstrap/icheck-bootstrap.css'
</script>
