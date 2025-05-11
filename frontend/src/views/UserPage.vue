<script setup>
    import {RouterView, RouterLink} from 'vue-router'
    import {useAuthStore} from '@/stores/auth'
    import {storeToRefs} from 'pinia'

    const {user} = storeToRefs(useAuthStore());

</script>
<template>
    <section class="px-[4%] py-6 md:px-[8%] flex flex-col gap-4">
        
            <div class="flex gap-2  items-center">
                <div class=" p-2 bg-gray-100 w-16 h-16 justify-center flex items-center rounded-full">
                    <i class="bx bxs-user text-3xl "></i>
                </div>
                <div class="flex flex-col  ">
                    <div>{{ user?.name }}</div>
                    <div class="text-gray-500 text-sm"> {{ user?.email }}</div>

                </div>
                
                
 
            </div>
            <div class="flex gap-4 ">
                <RouterLink to="/user/cart" exact-active-class="text-purple-600 underline">Cart</RouterLink>
                <RouterLink to="/user/cart" exact-active-class="text-purple-600 underline">Order History</RouterLink>
                <RouterLink to="/user/cart" exact-active-class="text-purple-600 underline">Payment History</RouterLink>
            </div>
            <div>
                <RouterView />
                
            </div>
            


    </section>

</template>