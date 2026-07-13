<template>
  <div v-if="loadingStore.isLoading" class="overlay">
    <svg class="loader" viewBox="0 0 50 50">
      <circle class="ring" cx="25" cy="25" r="20" />
      <circle class="ball" cx="25" cy="5" r="3" />
    </svg>
    <span class="ml-2">{{ loadingStore.message }} {{ loadingStore.progress }}%</span>
  </div>
</template>

<script setup>
import { useLoadingStore } from '../store/useLoadingStore'
const loadingStore = useLoadingStore()
</script>

<style scoped>
.overlay {
  position: fixed;
  top:0; left:0; right:0; bottom:0;
  background: rgba(0,0,0,0.4);
  display:flex;
  align-items:center;
  justify-content:center;
  z-index:9999;
  flex-direction: column;
  color: #fff;
  font-weight: 500;
}

.loader {
  width: 60px;
  height: 60px;
  animation: rotate 2s linear infinite;
}

.ring {
  fill: none;
  stroke: #fff;
  stroke-width: 4;
  opacity: 0.3;
}

.ball {
  fill: #fff;
  stroke: none;
  animation: move 2s ease-in-out infinite;
}

@keyframes rotate {
  100% { transform: rotate(360deg); }
}

@keyframes move {
  0%, 100% { cy: 5; }
  50% { cy: 45; }
}
</style>
