<script setup>
import { ref } from 'vue'

import ButtonLink from '@/components/ButtonLink.vue'
</script>
<template>
    <section class="px-[4%] md:px-[8%] py-10 flex flex-col gap-2">
        <div class="flex gap-2 items-center">
            <h1 class="text-2xl font-semibold">Accessories</h1>
            <!-- <div>
                <select name="brand" id="brand" class="px-2 cursor-pointer bg-gray-100">
                    <option value="" v-for="n in 5">Honda</option>
                </select>
            </div> -->
        </div>

        <div class="flex flex-col">



        </div>
        <div class="grid sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-2">
            <div class="rounded-lg  flex flex-col overflow-hidden" v-for="n in 4">
                <img src="/bike.jpg" alt="" class="w-full h-[70%] brightness-[0.9] hover:brightness-[1] object-cover">
                <div class="px-2 py-2 flex flex-col gap-1  h-full text-sm">
                    <span>Honda PR 210</span>
                    <span>$7000</span>
                    <div class="py-2">
                        <ButtonLink content="Check Details" />
                    </div>
                </div>

            </div>




        </div>
    </section>
</template>