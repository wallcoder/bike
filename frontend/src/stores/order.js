import { defineStore } from "pinia";
import { ref } from "vue";
import { push } from "notivue";
import axios from "axios";
export const useOrderStore = defineStore('order', ()=>{
    const orders = ref([])
    const isLoadingOrders = ref(false)

    const getOrders = async ()=>{
        try{
            isLoadingOrders.value = true
            const response = await axios.get('/orders')

            orders.value = response.data.data

        }catch(err){
            console.log(err)
        }finally{
            isLoadingOrders.value = false
        }
    }

    return {orders, isLoadingOrders, getOrders}
})