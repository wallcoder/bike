<script setup>
  import MainFooter from '@/components/MainFooter.vue';
  import MainNavbar from '@/components/MainNavbar.vue'
  import {RouterView} from 'vue-router'
  import TopLoader from '@/components/TopLoader.vue'
</script>

<template>
  <div>
    <TopLoader />
    <MainNavbar />
    <div>
      <RouterView />
    </div>
    <MainFooter />


  </div>
</template>
