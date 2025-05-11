<script setup>
import { ref, computed, onMounted } from 'vue'
import { useCartStore } from '@/stores/cart'
import { storeToRefs } from 'pinia'

const { cart, isLoadingCart } = storeToRefs(useCartStore())
const { addToCart, getCart, removeFromCart } = useCartStore()
const api = import.meta.env.VITE_SERVER
onMounted(() => {
    getCart()
})
// Sample cart items (replace with actual API data)
const cartItems = ref([
    {
        id: 1,
        accessory: { model: 'Fire Speaker' },
        variant: { name: 'Pro' },
        color: { name: 'Red' },
        quantity: 2,
        price: 1499
    },
    {
        id: 2,
        accessory: { model: 'Fire Earbuds' },
        variant: { name: 'Lite' },
        color: { name: 'Black' },
        quantity: 1,
        price: 899
    }
])

const subtotal = computed(() =>
    cartItems.value.reduce((acc, item) => acc + item.price * item.quantity, 0)
)

const taxRate = 0.18
const tax = computed(() => subtotal.value * taxRate)
const total = computed(() => subtotal.value + tax.value)

const handlePayment = () => {
    alert('Proceeding to payment...')
}
</script>

<template>
    <section>
        <div v-if="isLoadingCart" class="flex flex-col lg:flex-row gap-6 py-6 animate-pulse">
            <!-- Cart Items Skeleton -->
            <div class="flex-1 space-y-4">
                <div class="h-7 bg-gray-300 rounded w-32"></div>

                <div v-for="n in 3" :key="n" class="p-4 rounded-xl shadow bg-white flex justify-between items-center">
                    <div class="flex gap-2 items-center">
                        <div class="size-20 bg-gray-300 rounded-lg"></div>
                        <div class="space-y-2">
                            <div class="h-4 bg-gray-300 rounded w-40"></div>
                            <div class="h-3 bg-gray-200 rounded w-32"></div>
                            <div class="h-3 bg-gray-200 rounded w-28"></div>
                            <div class="h-3 bg-gray-200 rounded w-20"></div>
                        </div>
                    </div>
                    <div class="h-6 bg-gray-300 rounded w-16"></div>
                </div>
            </div>

            <!-- Summary Skeleton -->
            <div class="lg:w-80 w-full sticky top-6">
                <div class="p-6 bg-white rounded-xl shadow space-y-4">
                    <div class="h-6 bg-gray-300 rounded w-24"></div>
                    <div class="flex justify-between">
                        <div class="h-4 bg-gray-200 rounded w-16"></div>
                        <div class="h-4 bg-gray-200 rounded w-10"></div>
                    </div>
                    <div class="flex justify-between">
                        <div class="h-4 bg-gray-200 rounded w-20"></div>
                        <div class="h-4 bg-gray-200 rounded w-12"></div>
                    </div>
                    <hr />
                    <div class="flex justify-between items-center">
                        <div class="h-5 bg-gray-300 rounded w-16"></div>
                        <div class="h-5 bg-gray-300 rounded w-14"></div>
                    </div>
                    <div class="h-10 bg-gray-300 rounded w-full"></div>
                </div>
            </div>
        </div>

        <div v-else class="flex flex-col lg:flex-row gap-6 py-6">
            <!-- Cart Items -->
            <div class="flex-1 space-y-4">
                <h2 class="text-2xl font-semibold">Your Cart</h2>


                <div v-for="item in cart" :key="item.id"
                    class="p-4 rounded-xl shadow bg-white flex justify-between items-center">
                    <div class="flex gap-2 items-center">
                        <div class="size-20 overflow-hidden rounded-lg">
                            <img class="w-full h-full object-cover" :src="`${api}/${item?.accessory_variant_color?.image}`"
                                alt="">
                        </div>

                        <div>
                            <h3 class="text-lg font-medium"> {{
                                item?.accessory_variant_color?.accessory_variant?.accessory?.model }}</h3>
                            <p class="text-sm text-gray-500">Variant: {{
                                item?.accessory_variant_color?.accessory_variant?.name
                            }}
                            </p>
                            <p class="text-sm text-gray-500">Color: {{ item?.accessory_variant_color?.color.name }}</p>
                            <p class="text-sm text-gray-500">Quantity: {{ item?.quantity }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xl font-semibold">₹{{ item?.quantity * item?.unit_price }}</p>
                    </div>
                </div>
            </div>

            <!-- Summary & Pay Button -->
            <div class="lg:w-80 w-full sticky top-6">
                <div class="p-6 bg-white rounded-xl shadow space-y-4">
                    <h3 class="text-xl font-semibold">Summary</h3>
                    <div class="flex justify-between text-sm">
                        <span>Subtotal</span>
                        <span>₹{{ subtotal.toFixed(2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span>Tax (18%)</span>
                        <span>₹{{ tax.toFixed(2) }}</span>
                    </div>
                    <hr />
                    <div class="flex justify-between font-semibold text-lg">
                        <span>Total</span>
                        <span>₹{{ total.toFixed(2) }}</span>
                    </div>
                    <button @click="handlePayment"
                        class="w-full bg-purple-600 hover:bg-purple-500 text-white font-semibold py-2 px-4 rounded-xl">
                        Pay Now
                    </button>
                </div>
            </div>
        </div>

    </section>
</template>
