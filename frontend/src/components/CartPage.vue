<script setup>
import { ref, computed, onMounted } from 'vue'
import { useCartStore } from '@/stores/cart'
import { storeToRefs } from 'pinia'
import { RouterLink } from 'vue-router'
import {push} from 'notivue'
import axios from 'axios'
const { cart, isLoadingCart } = storeToRefs(useCartStore())
const { addToCart, getCart, removeFromCart } = useCartStore()
const api = import.meta.env.VITE_SERVER
const ship = ref({
    name: '',
    phone: '',
    street: '',
    postalCode: '',
    city: '',
    state: '',
    country: '',
})
const showAddressSection = ref(false)

onMounted(() => {
    getCart()
})

const subtotal = computed(() =>
    cart.value.reduce((acc, item) => acc + item.unit_price * item.quantity, 0)
)

const taxRate = 0.18
const tax = computed(() => subtotal.value * taxRate)
const total = computed(() => subtotal.value + tax.value)

const handlePayment = async () => {
    try {

        if(!ship.value.name || !ship.value.phone || !ship.value.street || !ship.value.postalCode || !ship.value.city || !ship.value.state || !ship.value.country ){
            push.warning('All shipping info field required')
            return
        }

        
        console.log("total: ", total.value )

        const orderRes = await axios.post(`/create-order`, {
            amount: total.value * 100, // Razorpay expects amount in paise
        })

       

        const orderData = orderRes.data
        
        const options = {
            key: import.meta.env.VITE_RAZORPAY_KEY_ID, 
            amount: orderData.amount,
            currency: "INR",
            name: "RevNation",
            description: "Accessory Purchase",
           
            order_id: orderData.id,
            handler: async function (response) {
                try {
                    const verifyRes = await axios.post(`/verify-payment`, {
                        razorpay_order_id: response.razorpay_order_id,
                        razorpay_payment_id: response.razorpay_payment_id,
                        razorpay_signature: response.razorpay_signature,
                        
                    })

                    if (verifyRes.data.success) {
                        push.success("Payment successful!")
                        const storeResponse = await axios.post('/store-info', {
                            razorpay_order_id: response.razorpay_order_id,
                            razorpay_payment_id: response.razorpay_payment_id,
                            name: ship.value.name,
                            phone: ship.value.phone,
                            street: ship.value.street,
                            postalCode: ship.value.postalCode,
                            city: ship.value.city,
                            state: ship.value.state,
                            country: ship.value.country,
                            total: total.value
                        })
                        getCart()
                        goBackToCart()
                    } else {
                        push.error("Payment verification failed.")
                    }
                } catch (error) {
                    push.error("An error occurred during verification.")
                    console.error(error)
                }
            },
            prefill: {
                
                
                
            },
            theme: {
                color: "#8b5cf6"
            }
        }

        const rzp = new Razorpay(options)
        rzp.open()
    } catch (error) {
        alert("Unable to initiate payment.")
        console.error(error)
    }
}

const goToCheckout = () => {
    showAddressSection.value = true
}

const goBackToCart = () => {
    showAddressSection.value = false
}



</script>

<template>
    <section>
        <!-- <div v-if="isLoadingCart" class="flex flex-col lg:flex-row gap-6 py-6 animate-pulse">
            
        </div> -->

        <div class="flex flex-col lg:flex-row gap-6 py-6 min-h-[40vh]">
            <!-- Cart Section -->
            <div class="flex-1 space-y-4" v-if="!showAddressSection">
                <h2 class="text-2xl font-semibold">Your Cart</h2>
                <div v-if="cart.length === 0">Cart is empty</div>
               <div v-else>
                <div v-for="item in cart" :key="item.id"
                    class="p-4 rounded-xl shadow bg-white flex justify-between items-center">
                    <div class="flex gap-2 items-center">
                        <div class="size-20 overflow-hidden rounded-lg">
                            <img class="w-full h-full object-cover" :src="`${api}/${item?.accessory_variant_color?.image}`"
                                alt="">
                        </div>
                        <div>
                            <RouterLink
                                :to="`/accessory/${item?.accessory_variant_color?.accessory_variant?.accessory?.slug}`"
                                class="hover:underline text-lg font-medium">
                                {{ item?.accessory_variant_color?.accessory_variant?.accessory?.model }}
                            </RouterLink>
                            <p class="text-sm text-gray-500">
                                Variant: {{ item?.accessory_variant_color?.accessory_variant?.name }}
                            </p>
                            <p class="text-sm text-gray-500">
                                Color: {{ item?.accessory_variant_color?.color.name }}
                            </p>
                            <p class="text-sm text-gray-500">
                                Quantity: {{ item?.quantity }}
                            </p>
                            <!-- Remove from cart -->
                           
                            <span class="text-sm hover:underline cursor-pointer" @click="removeFromCart(item?.accessory_variant_color_id, item?.quantity)">Remove</span>
                        </div>
                        
                    </div>
                    <div class="text-right">
                        <p class="text-xl font-semibold">₹{{ item?.quantity * item?.unit_price }}</p>
                    </div>
                </div>
                </div>
            </div>

            <!-- Address Section -->
            <div class="flex-1 space-y-4" v-if="showAddressSection">
                <h3 class="text-2xl font-semibold">Shipping Address</h3>
                <div class="w-full bg-white p-6 rounded-xl shadow space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <input v-model="ship.name" type="text"  placeholder="Full Name" class="border rounded-lg px-4 py-2 w-full" />
                        <input v-model="ship.phone" type="tel" placeholder="Phone Number" class="border rounded-lg px-4 py-2 w-full" />
                        <input v-model="ship.street" type="street" placeholder="Street" class="border rounded-lg px-4 py-2 w-full" />
                        
                        <input v-model="ship.postalCode" type="text" placeholder="ZIP Code" class="border rounded-lg px-4 py-2 w-full" />
                    </div>
                   
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <input v-model="ship.city" type="text" placeholder="City" class="border rounded-lg px-4 py-2 w-full" />
                        <input v-model="ship.state" type="text" placeholder="State" class="border rounded-lg px-4 py-2 w-full" />
                        <input v-model="ship.country" type="text" placeholder="Country" class="border rounded-lg px-4 py-2 w-full" />
                    </div>
                </div>
            </div>

            <!-- Summary -->
            <div class="lg:w-80 w-full sticky top-6" v-if="cart.length > 0">
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

                    <template v-if="!showAddressSection">
                        <button @click="goToCheckout"
                            class="w-full bg-purple-600 hover:bg-purple-500 text-white font-semibold py-2 px-4 rounded-xl">
                            Checkout
                        </button>
                    </template>

                    <div v-else class=" flex flex-col gap-2" >
                        <button @click="handlePayment"
                            class="w-full bg-purple-600 hover:bg-green-500 text-white font-semibold py-2 px-4 rounded-xl">
                            Pay Now
                        </button>
                        <button @click="goBackToCart"
                            class="w-full bg-gray-300 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-xl">
                            Back to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
