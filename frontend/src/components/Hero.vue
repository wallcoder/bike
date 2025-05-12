<script setup>
import Button from '@/components/Button.vue'
import ButtonLink from '@/components/ButtonLink.vue'
</script>
<template>
    <div class="h-[50vh] relative  bg-center w-full">
        <img src="/bike.jpg" alt="" class=" h-full w-full object-cover brightness-[0.5]">

        <div class="absolute inset-0 w-full py-20 flex items-center  gap-2 px-[4%] md:px-[8%] text-white">
            <div class="flex flex-col gap-2">
                <h1 class="text-2xl  ">
                    Ride, Repair, Repeat
                </h1>
                <p class="text-md md:text-lg  ">
                    Book your next service, buy your dream bike, or gear up with premium accessories — all in one
                    place.
                </p>
                <div class="flex gap-2 flex-wrap pt-2">

                    <ButtonLink link="/servicing" content="Book Servicing" />
                    <ButtonLink link="/bikes" content="Browse Bikes" />
                    <ButtonLink link="/accessories" content="Shop Accessories" />


                </div>
            </div>
        </div>
    </div>
</template>
