<script setup>

import ButtonLink from '@/components/ButtonLink.vue'
</script>
<template>
    
        <div class="rounded-lg  flex flex-col overflow-hidden" v-for="n in 4">
            <img src="/bike.jpg" alt=""
                class="w-full h-[70%] brightness-[0.9] rounded-lg hover:brightness-[1] object-cover">
            <div class="px-2 py-2 flex flex-col gap-1  h-full text-sm">
                <span>Honda PR 210</span>
                <span>$7000</span>
                <div class="py-2">
                    <ButtonLink content="Check Details" link="/bike/abc" />
                </div>
            </div>

        </div>




  
</template>