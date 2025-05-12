<script setup>
import { ref, onMounted } from 'vue'
import { storeToRefs } from 'pinia'
import { useOrderStore } from '@/stores/order'
import { jsPDF } from 'jspdf'

const { orders, isLoadingOrders } = storeToRefs(useOrderStore())
const { getOrders } = useOrderStore()

// Track toggle state for each order's payment section
const openPayments = ref({})

const togglePayment = (orderId) => {
    openPayments.value[orderId] = !openPayments.value[orderId]
}

onMounted(() => {
    getOrders()
})

// Method to generate PDF invoice
const generatePDF = (order) => {
    const doc = new jsPDF()

    // Add title
    doc.setFontSize(18)
    doc.text('Invoice', 14, 20)

    // Order Information
    doc.setFontSize(12)
    doc.text(`Order #${order.id}`, 14, 30)
    doc.text(`Status: ${order.status}`, 14, 40)
    doc.text(`Total: ₹${order.total}`, 14, 50)

    // Items List
    doc.text('Items:', 14, 60)
    let yOffset = 70
    order.order_item.forEach(item => {
        doc.text(`${item.name} - Qty: ${item.quantity} - ₹${item.price * item.quantity}`, 14, yOffset)
        yOffset += 10
    })

    // Payment Details
    if (order.payment.length > 0) {
        doc.text('Payments:', 14, yOffset + 10)
        yOffset += 20
        order.payment.forEach(pay => {
            doc.text(`Method: ${pay.method}`, 14, yOffset)
            doc.text(`Ref ID: ${pay.ref_id}`, 14, yOffset + 10)
            doc.text(`Status: ${pay.status}`, 14, yOffset + 20)
            doc.text(`Amount: ₹${pay.amount}`, 14, yOffset + 30)
            yOffset += 40
        })
    }

 
    doc.save(`invoice_${order.id}.pdf`)
}
</script>

<template>
    <section class="max-w-3xl">
       
        <div v-if="isLoadingOrders" class="space-y-6 py-6 animate-pulse">
            <div class="h-8 bg-gray-300 rounded w-1/3"></div>
            <div v-for="n in 2" :key="n" class="bg-white p-6 rounded-lg shadow-sm space-y-4">
                <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                <div class="h-4 bg-gray-200 rounded w-1/3"></div>
                <div class="h-4 bg-gray-200 rounded w-full"></div>
            </div>
        </div>

        <!-- Orders List -->
        <div v-else class="flex flex-col gap-2">
            <h2 class="text-2xl font-bold  text-gray-800">Your Orders</h2>

            <div v-for="order in orders" :key="order.id"
                class="bg-white border border-gray-200 rounded-xl p-4  shadow-sm transition hover:shadow-md">
                <!-- Order Header -->
                <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Order #{{ order.id }}</h3>
                        <p class="text-sm text-gray-500">
                            Status: <span class="capitalize">{{ order.status }}</span>
                        </p>
                    </div>
                    <div class="mt-2 md:mt-0 text-sm text-gray-600">
                        <span class="font-medium">Total:</span> ₹{{ order.total }}
                    </div>
                </div>

                <!-- Items -->
                <div class="">
                    <h4 class="text-lg font-semibold text-gray-700">Items</h4>
                    <ul class="divide-y divide-gray-200">
                        <li v-for="item in order.order_item" :key="item.id" class="flex justify-between items-center ">
                            <div class="text-gray-700">
                                <div class="font-medium">{{ item.name }}</div>
                            </div>
                            <div class="text-sm text-gray-600 text-right">
                                Qty: {{ item.quantity }}<br />
                                ₹{{ item.price * item.quantity }}
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Payment Toggle -->
                <div v-if="order.payment.length" class="mt-4">
                    <button @click="togglePayment(order.id)"
                        class="text-sm font-medium text-indigo-600 hover:underline focus:outline-none">
                        {{ openPayments[order.id] ? 'Hide Payment Details' : 'Show Payment Details' }}
                    </button>

                    <transition name="fade">
                        <div v-if="openPayments[order.id]" class="mt-3 space-y-3 transition-all duration-300">
                            <div v-for="pay in order.payment" :key="pay.id"
                                class="bg-gray-50 border border-gray-200 rounded p-4 text-sm text-gray-700">
                                <p><span class="font-medium">Method:</span> {{ pay.method }}</p>
                                <p><span class="font-medium">Ref ID:</span> {{ pay.ref_id }}</p>
                                <p>
                                    <span class="font-medium">Status:</span>
                                    <span class="capitalize"
                                        :class="pay.status === 'success' ? 'text-green-600' : 'text-red-600'">
                                        {{ pay.status }}
                                    </span>
                                </p>
                                <p><span class="font-medium">Tax:</span> 18%</p>
                                <p><span class="font-medium">Amount:</span> ₹{{ pay.amount }}</p>
                            </div>
                        </div>
                    </transition>
                </div>

                <!-- Actions -->
                <div class="mt-6 text-right">
                    <button @click="generatePDF(order)"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-lg transition">
                        Download Invoice
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: all 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: scale(0.98);
}
</style>
