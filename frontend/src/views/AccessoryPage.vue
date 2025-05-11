<script setup>
import { ref, computed, onMounted, watchEffect } from 'vue'
import ButtonLink from '@/components/ButtonLink.vue'
import { useAccStore } from '@/stores/accessory'
import { storeToRefs } from 'pinia'
import FormInput from '@/components/FormInput.vue'
import Button from '@/components/Button.vue'
import { useCartStore } from '@/stores/cart'
import { push } from 'notivue'
import axios from 'axios'

const {addToCart} = useCartStore()
const { acc, isLoadingAccPage } = storeToRefs(useAccStore())
const { getAccBySlug } = useAccStore()

const api = import.meta.env.VITE_SERVER

const props = defineProps({
    slug: {
        type: String,
        required: true,
    },
})

onMounted(() => {
    getAccBySlug(props.slug)
})

const purchase = ref({
    name: '',
    email: '',
    phone: '',
    address: '',
    note: '',
})

const isLoadingPurchase = ref(false);

const submitPurchase = async () => {
    try {
        isLoadingPurchase.value = true
        const response = await axios.post('/appointment/create', {
            name: purchase.value.name,
            email: purchase.value.email,
            phone: purchase.value.phone,
            address: purchase.value.address,
            type: 'purchase',
            note: purchase.value.note,
        })

        push.success(response.data.message)
        purchase.value = {
            name: '',
            email: '',
            phone: '',
            address: '',
            note: '',
        }
        isOpenBook.value = false

    } catch (err) {


        if (err.response?.data?.message) {
            if (err.response?.data?.message?.phone) {
                push.error(err.response?.data?.message?.phone)
            }
            else if (err.response?.data?.message?.address) {
                push.error(err.response?.data?.message?.address)
            }
            else if (push.error(err.response?.data?.message?.name)) {
                push.error(err.response?.data?.message?.name)
            }
            else if (push.error(err.response?.data?.message?.email)) {
                push.error(err.response?.data?.message?.email)
            }
        } else {
            console.log(err)
            push.error("Cannot submit form")
        }

    } finally {
        isLoadingPurchase.value = false
    }
}

const isOpenBook = ref(false)
const isOpenReview = ref(false)

const specs = ref({
    mileage: '45 kmpl',
    torque: '80 Nm',
    engine: '349 cc',
    weight: '180 kg',
    topSpeed: '130 km/h',
    brakes: 'Disc (Front & Rear)',
})

const reviews = ref([
    { name: 'Alice', rating: 5, comment: 'Amazing acc! Very smooth ride.' },
    { name: 'Bob', rating: 4, comment: 'Great value and lightweight frame.' },
    { name: 'Charlie', rating: 3, comment: 'Good, but gear shifting could be better.' },
])

const averageRating = computed(() => {
    const total = reviews.value.reduce((acc, review) => acc + review.rating, 0)
    return total / reviews.value.length
})

const selectedVariantIndex = ref(0)
const selectedColorId = ref(null)
const selectedVariantColorIndex = ref(0)

const selectedVariant = computed(() => acc.value?.accessory_variant?.[selectedVariantIndex.value] || null)
const selectedColors = computed(() => selectedVariant.value?.accessory_variant_color || [])
const selectedVariantColor = computed(() => acc.value?.accessory_variant?.[selectedVariantIndex.value].accessory_variant_color?.[selectedVariantColorIndex.value] || null)

const currentImage = computed(() => {
    const selectedColor = selectedColors.value.find(c => c.id === selectedColorId.value)
    return selectedColor ? `${api}/${selectedColor.image}` : `${api}/${acc.value?.image}`
})

const currentPrice = computed(() => {
    const selectedColor = selectedColors.value.find(c => c.id === selectedColorId.value)
    return selectedColor ? `${selectedColor.price}` : `${acc.value?.base_price}`
})

const selectVariant = (index) => {
    selectedVariantIndex.value = index
    selectedColorId.value = selectedColors.value[0]?.id || null
}
const selectVariantColor = (index) => {
    selectedVariantColorIndex.value = index

}
const selectColor = (colorId) => {
    selectedColorId.value = colorId
    const index = selectedColors.value.findIndex(c => c.id === colorId)
    if (index !== -1) {
        selectedVariantColorIndex.value = index
    }
}


watchEffect(() => {
    if (!selectedColorId.value && selectedColors.value.length > 0) {
        selectedColorId.value = selectedColors.value[0].id
    }
})

</script>

<template>
    <section class="py-8 px-[4%] lg:px-[8%] flex flex-col items-center">

        <!-- Loading Skeleton -->
        <div v-if="isLoadingAccPage" class="w-full flex flex-col gap-8">
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

        <!-- Acc Page -->
        <div v-else class="flex gap-4 w-full md:flex-row flex-col">
            <!-- Acc Image -->
            <div class="flex justify-center w-full md:w-1/2 h-[360px] bg-gray-100">
                <img :src="currentImage" alt="Acc" class="w-full object-contain" />
            </div>

            <!-- Acc Details -->
            <div class="flex flex-col gap-2 w-full md:w-1/2">
                <h2 class="text-2xl font-semibold">{{ acc?.model }}</h2>
                <p class="text-gray-600">{{ acc?.brand?.name }}</p>
                <p class="text-gray-600">{{ acc?.description }}</p>

                <!-- Variant Selector -->
                <div class="">
                    <span class="text-lg font-medium text-gray-700">Select Variant:</span>
                    <div class="flex gap-2 mt-2">
                        <button v-for="(variant, index) in acc?.accessory_variant" :key="variant.id"
                            @click="selectVariant(index)" class="px-3 py-1 rounded-lg border"
                            :class="index === selectedVariantIndex ? 'bg-gray-200 text-black ' : 'bg-white text-black'">
                            {{ variant.name }}
                        </button>
                    </div>
                </div>

                <!-- Color Selector -->
                <div class="">
                    <span class="text-lg font-medium text-gray-700">Select Color:</span>
                    <div class="flex gap-3 mt-2">
                        <button v-for="colorItem in selectedColors" :key="colorItem.id"
                            :style="{ backgroundColor: colorItem.color.code }" class="w-6 h-6 rounded-full border-2"
                            :class="selectedColorId === colorItem.id ? 'ring-1 ring-offset-1 ring-gray-500' : ''"
                            @click="selectColor(colorItem.id)"></button>
                    </div>
                </div>
                <div>
                    Stocks: {{ selectedVariantColor?.stock }}
                </div>
                

                <!-- Price and Stock -->
                <span class="text-sm text-gray-500 ">
                    <span></span>
                </span>
                <div class="text-xl  text-gray-900 ">₹{{ currentPrice }}</div>

                <!-- Booking -->
                <div class=" mt-1">
                    <Button content="Add to Cart" :fun="() => { addToCart(selectedVariantColor?.id, 1, currentPrice) }" />
                </div>
            </div>
        </div>

        <!-- Acc Specifications -->

        <div class="w-full mt-12">

            <h3 class="text-xl font-semibold mb-4">Accessory Specifications</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2 text-gray-700">
                <div class="border p-4 rounded-lg bg-gray-50">
                    <span class="block font-medium capitalize">Weight</span>
                    <span class="text-sm text-gray-600">{{ selectedVariant?.weight }} cc</span>
                </div>
                <div class="border p-4 rounded-lg bg-gray-50">
                    <span class="block font-medium capitalize">Material</span>
                    <span class="text-sm text-gray-600">{{ selectedVariant?.material }} kmpl</span>
                </div>


            </div>
        </div>

        <!-- Review Section -->
        <div class="w-full py-16 flex flex-col gap-4">
            <h3 class="text-xl font-semibold">Customer Reviews</h3>

            <div class="font-semibold hover:underline cursor-pointer" @click="isOpenReview = true">Add Review</div>

            <!-- Average Rating -->
            <div class="flex items-center">
                <div class="flex gap-1 text-yellow-400 text-xl">
                    <span v-for="i in 5" :key="i">
                        <i :class="i <= Math.floor(averageRating) ? 'fas fa-star' : 'far fa-star'"></i>
                    </span>
                </div>
                <span class="ml-2 text-gray-700">{{ averageRating.toFixed(1) }} out of 5</span>
            </div>

            <!-- Review List -->
            <div class="flex flex-col gap-6">
                <div v-for="(review, index) in reviews" :key="index" class="border-b pb-4">
                    <p class="font-semibold">{{ review.name }}</p>
                    <div class="flex gap-1 text-yellow-400">
                        <span v-for="i in 5" :key="i">
                            <i :class="i <= review.rating ? 'fas fa-star' : 'far fa-star'"></i>
                        </span>
                    </div>
                    <p class="text-gray-600">{{ review.comment }}</p>
                </div>
            </div>
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
                    <div class="flex  justify-end"><i class="bx bx-x cursor-pointer " @click="isOpenReview = false"></i>
                    </div>
                    <h2 class="text-lg font-semibold">Make Purchase Appointment for this acc</h2>

                    <FormInput label="Full Name" placeholder="Enter Full Name" />
                    <FormInput label="Email" placeholder="Enter Email" />
                    <FormInput label="Phone" placeholder="Enter Phone Number" />
                    <FormInput label="Address" placeholder="Enter Address" />
                    <Button :loading="isLoadingLogin" content="Submit" :isLink="false" type="submit" />
                    <RouterLink to="/user/signup" class="text-sm hover:underline ">We'll reach you back after you submit
                        this form.
                    </RouterLink>


                </form>
            </Transition>
        </div>

        <div class="fixed  w-full  px- top-0 left-0 z-30 pointer-events-none">
            <Transition>
                <div class="w-full bg-black/60 backdrop-blur-sm h-[100vh] pointer-events-auto" @click="isOpenBook = false"
                    v-if="isOpenBook">

                </div>


            </Transition>
            <Transition>
                <form v-if="isOpenBook" @submit.prevent="submitPurchase"
                    class="absolute   top-1/2 p-8 left-1/2 rounded-lg -translate-x-1/2 -translate-y-1/2 bg-white   flex flex-col gap-2 pointer-events-auto transition-all duration-[0.5s] ease-out">
                    <h2 class="text-lg font-semibold">Make Purchase Appointment</h2>

                    <FormInput v-model="purchase.name" label="Full Name" placeholder="Enter Full Name" id="name" />
                    <FormInput v-model="purchase.email" label="Email" placeholder="Enter Email" id="email" />
                    <FormInput v-model="purchase.phone" label="Phone" placeholder="Enter Phone Number" id="phone" />
                    <FormInput v-model="purchase.address" label="Address" placeholder="Enter Address" id="address" />
                    <FormInput v-model="purchase.note" :required="false" label="Note" placeholder="Enter Note" id="note" />
                    <Button :loading="isLoadingPurchase" content="Submit" :isLink="false" type="submit" />
                    <RouterLink to="/user/signup" class="text-sm hover:underline ">We'll reach you back after you submit the
                        form.</RouterLink>



                </form>
            </Transition>
        </div>


    </section>
</template>

<style scoped>
/* Make sure FontAwesome icons are available in your main HTML or layout */
</style>
