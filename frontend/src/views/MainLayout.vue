<script setup>
  import MainFooter from '@/components/MainFooter.vue';
  import MainNavbar from '@/components/MainNavbar.vue'
  import {RouterView} from 'vue-router'
</script>

<template>
  <div>
    <MainNavbar />
    <div>
      <RouterView />
    </div>
    <MainFooter />


  </div>
</template>
