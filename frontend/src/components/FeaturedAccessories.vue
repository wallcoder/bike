<script setup>
import { ref, onMounted } from 'vue'
import AccessoryCard from '@/components/AccessoryCard.vue';
import ButtonLink from '@/components/ButtonLink.vue'
import { storeToRefs } from 'pinia'
import { useAccStore } from '@/stores/accessory'

const { accs, isLoadingAccs } = storeToRefs(useAccStore())
const { getAccs } = useAccStore()

onMounted(() => {
    getAccs()
})

</script>
<template>
    <div>
        <section v-if="isLoadingAccs" class="px-[4%] md:px-[8%] py-10 flex flex-col gap-4 animate-pulse">
            <!-- Header -->
            <div class="flex gap-2 items-center">
                <div class="h-8 w-40 bg-gray-100 rounded"></div>
                <div class="h-8 w-24 bg-gray-100 rounded"></div>
            </div>

            <!-- Empty filler for filters or content -->
            <div class="flex flex-col gap-2">
                <div class="h-4 w-1/2 bg-gray-100 rounded"></div>
                <div class="h-4 w-1/3 bg-gray-100 rounded"></div>
            </div>

            <!-- Grid skeleton cards -->
            <div class="grid sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4">
                <div v-for="n in 4" :key="n" class="p-4 rounded-lg shadow bg-gray-100 flex flex-col gap-4">
                    <div class="h-40  rounded"></div>
                    <div class="h-4 w-3/4  rounded"></div>
                    <div class="h-4 w-1/2  rounded"></div>
                    <div class="h-6 w-1/3  rounded mt-auto"></div>
                </div>
            </div>

            <!-- Bottom link -->
            <div class="h-6 w-48 bg-gray-100 rounded"></div>
        </section>
        <section v-else class="px-[4%] md:px-[8%] py-10 flex flex-col gap-2">
            <!-- {{ bikes }} -->
            <div class="flex gap-2 items-center">
                <h1 class="text-2xl font-semibold">Featured Accessories</h1>
                <!-- <div>
                    <select name="brand" id="brand" class="px-2 cursor-pointer bg-gray-100">
                        <option value="" v-for="n in 5">Honda</option>
                    </select>
                </div> -->
            </div>

             <div v-if="accs?.data?.length == 0" class="flex flex-col">


                 No Bike Available
            </div>
            <div class="grid sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-2">
                <AccessoryCard :items="accs.data" />




            </div>
            <span class="">

                <RouterLink to="/bikes" class="capitalize hover:text-purple-600  font-semibold    "><span>See
                        all available accessories</span> </RouterLink>

            </span>
        </section>
    </div>
</template>