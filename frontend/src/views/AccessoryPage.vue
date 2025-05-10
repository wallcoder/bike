<script setup>
import { ref, computed } from 'vue'
import ButtonLink from '@/components/ButtonLink.vue'
import Button from '@/components/Button.vue'

const selectedColor = ref('black')
const loading = ref(true)
setTimeout(() => {
    loading.value = false
}, 1500)

const colorMap = {
    black: { hex: '#000000', img: 'https://via.placeholder.com/400x300?text=Black+Helmet' },
    white: { hex: '#f3f4f6', img: 'https://via.placeholder.com/400x300?text=White+Helmet' },
    red: { hex: '#ef4444', img: 'https://via.placeholder.com/400x300?text=Red+Helmet' },
    blue: { hex: '#3b82f6', img: 'https://via.placeholder.com/400x300?text=Blue+Helmet' }
}

const specs = ref({
    weight: '280 g',
    material: 'Polycarbonate Shell',
    ventilation: '20 Air Vents',
    fit: 'Adjustable Dial System',
    padding: 'Removable & Washable',
    certification: 'CPSC, EN1078'
})

const selectColor = (color) => {
    selectedColor.value = color
}

const currentImage = computed(() => colorMap[selectedColor.value].img)

const reviews = ref([
    { name: 'Derek', rating: 5, comment: 'Super lightweight and stylish.' },
    { name: 'Nina', rating: 4, comment: 'Fits well, good protection.' },
    { name: 'Leo', rating: 4, comment: 'Great value for the quality offered.' }
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
            <!-- Accessory Image -->
            <div class="flex justify-center w-full md:w-1/2 h-[360px] bg-gray-100">
                <img :src="currentImage" alt="Helmet" class="w-full object-contain" />
            </div>

            <!-- Accessory Details -->
            <div class="flex flex-col gap-3">
                <h2 class="text-2xl">Premium Bike Helmet</h2>
                <p class="text-gray-600">
                    Lightweight and durable helmet designed for ultimate comfort and safety on every ride.
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

                <span class="text-sm text-gray-500">In Stock: 10+</span>
                <div class="text-xl font-semibold text-gray-900">$89.99</div>

                <div>
                    
                    <ButtonLink content="Add to Cart" />
                </div>
            </div>
        </div>

        <!-- Accessory Specifications -->
        <div class="w-full mt-12">
            <h3 class="text-xl font-semibold mb-4">Helmet Specifications</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2 text-gray-700">
                <div v-for="(value, key) in specs" :key="key" class="border p-4 rounded-lg bg-gray-50">
                    <span class="block font-medium capitalize">{{ key.replace(/([A-Z])/g, ' $1') }}</span>
                    <span class="text-sm text-gray-600">{{ value }}</span>
                </div>
            </div>
        </div>

        <!-- Review Section -->
        <div class="w-full py-16 flex flex-col gap-4">
            <h3 class="text-xl font-semibold">Customer Reviews</h3>

            <div class="font-semibold hover:underline cursor-pointer">Add Review</div>

            <!-- Average Rating -->
            <div class="flex items-center">
                <div class="flex gap-1 text-yellow-400 text-xl">
                    <span v-for="i in 5" :key="i">
                        <i :class="i <= averageRating ? 'fas fa-star' : 'far fa-star'"></i>
                    </span>
                </div>
                <span class="ml-2 text-gray-700">{{ averageRating.toFixed(1) }} out of 5</span>
            </div>

            <!-- Review List -->
            <div class="flex flex-col gap-6">
                <div v-for="(review, index) in reviews" :key="index" class="border-b pb-4">
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
    </section>
</template>

<style>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
</style>
