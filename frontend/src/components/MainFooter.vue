<script setup>
    import Logo from '@/components/Logo.vue'
</script>

<template>
  <footer class="min-h-[30vh] py-8 px-[4%] lg:px-[8%] flex   bg-gray-100" >
      <div class="flex gap-2 flex-col">
         <Logo />

         <span class="text-sm text-gray-600 ">&copy;2025</span>
         <div class="flex gap-4 items-center text-gray-600">
            <RouterLink to="/" class="text-sm hover:underline">Terms of Service</RouterLink>
            
            <RouterLink to="/" class="text-sm hover:underline">Privacy Policy</RouterLink>
            <span></span>

         </div>

      </div>


   </footer>
</template>
