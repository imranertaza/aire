<template>
    <!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
  <img class="animation__wobble" :src="adminLogo" alt="AdminLTELogo" height="60" width="60">
</div>
</template>

<script setup>
import adminLogo from '@/assets/dist/img/AdminLTELogo.png';
</script>