import { defineStore } from "pinia";
import { ref } from "vue";

export const usePayStore = defineStore('pay', () => {

    const isLoading = ref(false);

    const payWithRazorpay = async () => {
        isLoading.value = true;

        try {
            const amount = 500; // amount in rupees
            const { data: order } = await axios.post('http://localhost:5000/create-order', {
                amount,
            });

            const options = {
                key: 'YOUR_KEY_ID', // from Razorpay dashboard
                amount: order.amount,
                currency: order.currency,
                name: 'Your Company Name',
                description: 'Test Transaction',
                order_id: order.id,
                handler: function (response) {
                    alert('Payment successful! Payment ID: ' + response.razorpay_payment_id);
                   
                },
                prefill: {
                    name: 'Test User',
                    email: 'test@example.com',
                    contact: '9999999999',
                },
                theme: {
                    color: '#3399cc',
                },
            };

            const razorpay = new window.Razorpay(options);
            razorpay.open();
        } catch (err) {
            console.error(err);
            alert('Payment Failed');
        } finally {
            isLoading.value = false;
        }
    };

})