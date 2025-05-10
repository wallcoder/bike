<script setup>
import { ref, computed } from 'vue'
import ButtonLink from '@/components/ButtonLink.vue'
import Button from '@/components/Button.vue'
import FormInput from '@/components/FormInput.vue'
const selectedColor = ref('red')
const isOpenBook = ref(false)
const loading = ref(true)
const isOpenReview = ref(false)
setTimeout(() => {
    loading.value = false
}, 1500)
const colorMap = {
    red: { hex: '#ef4444', img: 'https://via.placeholder.com/400x300?text=Red+Bike' },
    blue: { hex: '#3b82f6', img: 'https://via.placeholder.com/400x300?text=Blue+Bike' },
    green: { hex: '#22c55e', img: 'https://via.placeholder.com/400x300?text=Green+Bike' },
    black: { hex: '#000000', img: 'https://via.placeholder.com/400x300?text=Black+Bike' }
}

const specs = ref({
    mileage: '45 kmpl',
    torque: '80 Nm',
    engine: '349 cc',
    weight: '180 kg',
    topSpeed: '130 km/h',
    brakes: 'Disc (Front & Rear)',
})


const selectColor = (color) => {
    selectedColor.value = color
}

const currentImage = computed(() => colorMap[selectedColor.value].img)

const reviews = ref([
    { name: 'Alice', rating: 5, comment: 'Amazing bike! Very smooth ride.' },
    { name: 'Bob', rating: 4, comment: 'Great value and lightweight frame.' },
    { name: 'Charlie', rating: 3, comment: 'Good, but gear shifting could be better.' }
])

const averageRating = computed(() => {
    const total = reviews.value.reduce((acc, review) => acc + review.rating, 0)
    return total / reviews.value.length
})
</script>

<template>
    <section class="py-8 px-[4%] lg:px-[8%] flex flex-col items-center">
        <div v-if="loading" class="w-full flex flex-col gap-8">
            <!-- Skeleton Layout -->
            <div class="flex gap-4 w-full md:flex-row flex-col animate-pulse">
                <div class="w-full md:w-1/2 h-[360px] bg-gray-200 rounded-lg"></div>
                <div class="flex flex-col gap-4 w-full md:w-1/2">
                    <div class="h-6 bg-gray-200 rounded w-1/2"></div>
                    <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                    <div class="h-4 bg-gray-200 rounded w-1/2"></div>

                    <div class="flex gap-3 mt-2">
                        <div class="w-8 h-8 rounded-full bg-gray-300" v-for="n in 4" :key="n"></div>
                    </div>

                    <div class="h-4 bg-gray-200 rounded w-1/3 mt-4"></div>
                    <div class="h-6 bg-gray-300 rounded w-24"></div>
                    <div class="h-10 bg-gray-300 rounded w-40"></div>
                </div>
            </div>

            <div class="w-full">
                <div class="h-6 bg-gray-200 rounded w-1/3 mb-4"></div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                    <div v-for="i in 6" :key="i" class="p-4 bg-gray-100 rounded animate-pulse">
                        <div class="h-4 bg-gray-200 w-1/2 mb-2 rounded"></div>
                        <div class="h-4 bg-gray-200 w-3/4 rounded"></div>
                    </div>
                </div>
            </div>

            <div class="w-full py-12 flex flex-col gap-4">
                <div class="h-6 bg-gray-200 w-1/3 rounded"></div>
                <div class="h-4 bg-gray-200 w-24 rounded"></div>
                <div class="h-6 bg-gray-200 w-1/4 rounded"></div>

                <div class="flex flex-col gap-4">
                    <div v-for="i in 3" :key="i" class="border-b pb-4 animate-pulse">
                        <div class="h-4 bg-gray-200 w-32 mb-2 rounded"></div>
                        <div class="h-4 bg-gray-200 w-full rounded"></div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="flex gap-4 w-full md:flex-row flex-col">
            <!-- Bike Image -->
            <div class="flex justify-center w-full md:w-1/2 h-[360px] bg-gray-100">
                <img :src="currentImage" alt="Bike" class="w-full object-contain" />
            </div>

            <!-- Bike Details -->
            <div class="flex flex-col gap-3">
                <h2 class="text-2xl ">Speedster Road Bike</h2>
                <p class="text-gray-600">
                    High-performance road bike designed for speed, comfort, and durability.
                </p>

                <div class="flex flex-col gap-3">
                    <span class="text-lg font-medium text-gray-700">Select Color:</span>
                    <div class="flex gap-3">
                        <button v-for="color in Object.keys(colorMap)" :key="color"
                            :style="{ backgroundColor: colorMap[color].hex }" @click="selectColor(color)"
                            class="w-8 h-8 rounded-full border-2 border-white hover:ring-2"
                            :class="selectedColor === color ? 'ring-2 ring-offset-2 ring-' + color : ''"></button>
                    </div>
                </div>

                <!-- Quantity & Stock -->
                <div class="flex flex-col gap-2 mt-2">
                    <!-- <div class="flex items-center gap-2">
                        <span class="text-gray-700 font-medium">Quantity:</span>
                        <input type="number" v-model="quantity" min="1" :max="stock"
                            class="w-20 border px-2 py-1 rounded-md" />
                    </div> -->
                    <span class="text-sm text-gray-500">Available Stock: 2</span>
                </div>

                <!-- Price -->
                <div class="text-xl font-semibold text-gray-900">$799.00</div>
                <div>
                    <ButtonLink content="Book for Purchase" :fun="() => { isOpenBook = true }" />
                </div>
            </div>
        </div>


        <!-- More Attributes -->

        <!-- Bike Specifications -->
        <div class="w-full mt-12">
            <h3 class="text-xl font-semibold mb-4">Bike Specifications</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2 text-gray-700">
                <div v-for="(value, key) in specs" :key="key" class="border p-4 rounded-lg bg-gray-50">
                    <span class="block font-medium capitalize">{{ key.replace(/([A-Z])/g, ' $1') }}</span>
                    <span class="text-sm text-gray-600">{{ value }}</span>
                </div>
            </div>
        </div>


        <!-- Review Section -->
        <div class=" w-full  py-16 flex flex-col gap-4">
            <h3 class="text-xl  font-semibold">Customer Reviews</h3>

            <div class="font-semibold hover hover:underline cursor-pointer" @click="isOpenReview=true">Add Review</div>
            <!-- Average Rating -->
            <div class="flex items-center ">
                <div class="flex gap-1 text-yellow-400 text-xl">
                    <span v-for="i in 5" :key="i">
                        <i :class="i <= averageRating ? 'fas fa-star' : 'far fa-star'"></i>
                    </span>
                </div>
                <span class="ml-2 text-gray-700">{{ averageRating.toFixed(1) }} out of 5</span>
            </div>

            <!-- Review List -->
            <div class="flex flex-col gap-6">
                <div v-for="(review, index) in reviews" :key="index" class="border-b">
                    <div class="flex items-center gap-2 mb-1">
                        <div>{{ review.name }}</div>
                        <div class="flex text-yellow-400 text-sm">
                            <span v-for="i in 5" :key="i">
                                <i :class="i <= review.rating ? 'fas fa-star' : 'far fa-star'"></i>
                            </span>
                        </div>
                    </div>
                    <p class="text-gray-600">{{ review.comment }}</p>
                </div>
            </div>
        </div>


        <!-- POST REVIEW -->
        <div class="fixed  w-full  px- top-0 left-0 z-30 pointer-events-none">
            <Transition>
                <div class="w-full bg-black/60 backdrop-blur-sm h-[100vh] pointer-events-auto" @click="isOpenBook = false"
                    v-if="isOpenBook">

                </div>


            </Transition>
            <Transition>
                <form v-if="isOpenBook" @submit.prevent="handleSignup"
                    class="absolute   top-1/2 p-8 left-1/2 rounded-lg -translate-x-1/2 -translate-y-1/2 bg-white   flex flex-col gap-2 pointer-events-auto transition-all duration-[0.5s] ease-out">
                    <div class="flex  justify-end"><i class="bx bx-x cursor-pointer " @click="isOpenBook = false"></i></div>
                    <h2 class="text-lg font-semibold">Make Purchase Appointment for this bike</h2>

                    <FormInput label="Full Name" placeholder="Enter Full Name" />
                    <FormInput label="Email" placeholder="Enter Email" />
                    <FormInput label="Phone" placeholder="Enter Phone Number" />
                    <FormInput label="Address" placeholder="Enter Address" />
                    <Button :loading="isLoadingLogin" content="Submit" :isLink="false" type="submit" />
                    <RouterLink to="/user/signup" class="text-sm hover:underline ">We'll reach you back after you submit this form.
                    </RouterLink>


                </form>
            </Transition>
        </div>


        <div class="fixed  w-full  px- top-0 left-0 z-30 pointer-events-none">
            <Transition>
                <div class="w-full bg-black/60 backdrop-blur-sm h-[100vh] pointer-events-auto" @click="isOpenReview = false"
                    v-if="isOpenReview">

                </div>


            </Transition>
            <Transition>
                <form v-if="isOpenReview" @submit.prevent="handleSignup"
                    class="absolute   top-1/2 p-8 left-1/2 rounded-lg -translate-x-1/2 -translate-y-1/2 bg-white   flex flex-col gap-2 pointer-events-auto transition-all duration-[0.5s] ease-out">
                    <div class="flex  justify-end"><i class="bx bx-x cursor-pointer " @click="isOpenReview = false"></i></div>
                    <h2 class="text-lg font-semibold">Make Purchase Appointment for this bike</h2>

                    <FormInput label="Full Name" placeholder="Enter Full Name" />
                    <FormInput label="Email" placeholder="Enter Email" />
                    <FormInput label="Phone" placeholder="Enter Phone Number" />
                    <FormInput label="Address" placeholder="Enter Address" />
                    <Button :loading="isLoadingLogin" content="Submit" :isLink="false" type="submit" />
                    <RouterLink to="/user/signup" class="text-sm hover:underline ">We'll reach you back after you submit this form.
                    </RouterLink>


                </form>
            </Transition>
        </div>




    </section>
</template>

<!-- Add Font Awesome for stars -->
<style>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
</style>
