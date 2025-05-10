<script setup>
import { ref } from 'vue'
import BikeCard from './BikeCard.vue';
import ButtonLink from '@/components/ButtonLink.vue'
</script>
<template>
    <section class="px-[4%] md:px-[8%] py-10 flex flex-col gap-2">
        <div class="flex gap-2 items-center">
            <h1 class="text-2xl font-semibold">Featured Bikes</h1>
            <div>
                <select name="brand" id="brand" class="px-2 cursor-pointer bg-gray-100">
                    <option value="" v-for="n in 5">Honda</option>
                </select>
            </div>
        </div>

        <div class="flex flex-col">



        </div>
        <div class="grid sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-2">
            <BikeCard />




        </div>
        <RouterLink to="/bikes" class="capitalize hover:text-purple-600 e font-semibold flex items-center"><span>See
                all available bikes</span> <i class='bx bx-chevron-right text-xl'></i></RouterLink>
    </section>
</template>