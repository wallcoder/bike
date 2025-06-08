<script setup>

import ButtonLink from '@/components/ButtonLink.vue'
const api = import.meta.env.VITE_SERVER
const props = defineProps({
    items: {
        type: Array,
        default: []
    }
})
</script>
<template>
    <div class="rounded-lg   flex flex-col overflow-hidden" v-for="i in items">
        <div>
            <img :src="`${api}/${i.image}`" alt=""
                class="w-full h-[260px] brightness-[0.9]  rounded-lg hover:brightness-[1] object-contain">
        </div>
        <div class="px-2 py-2 flex flex-col gap-1  h-full text-sm">
            <span class="">{{ i.model }}</span>
            <span class="text-gray-600">{{ i.brand.name }}</span>
            <span class="font-semibold">₹{{ i.base_price }} onwards</span>
            <div class="py-2">
                <ButtonLink content="Check Details" :link="`/accessory/${i.slug}`" />
            </div>
        </div>

    </div>
</template>