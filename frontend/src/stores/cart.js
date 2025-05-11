import { defineStore } from "pinia";
import { ref } from "vue";
import { push } from "notivue";
import axios from "axios";
import { useAuthStore } from "@/stores/auth";
import { storeToRefs } from "pinia";


export const useCartStore = defineStore('cart', ()=>{
    const cart = ref([])
    const {checkToken} = useAuthStore()
    const isLoadingCart = ref(false)


    const addToCart = async (accessoryVariantColorId, quantity, unitPrice)=>{
        try{

            const check = await checkToken(true);

            if(!check){
                push.warning('You have to log in first')
                return
            }

            const response = await axios.post('/cart/add', {
                accessoryVariantColorId, quantity, unitPrice
            })

            push.success(response.data.message)
            getCart()
        }catch(err){
            console.log(err)
            if(err.response.data?.message){
                push.error(err.response.data?.message)
            }

        }finally{

        }
    }

    const getCart = async ()=>{
        try{
            isLoadingCart.value = true
            const response = await axios.get('/cart' )

            cart.value = response.data.data

        }catch(err){
            console.log(err)
            if(err.response.data?.message){
                push.error(err.response.data?.message)
            }

        }finally{
            isLoadingCart.value = false
        }
    }


    const removeFromCart = async (accessoryVariantColorId, quantity=1)=>{
        try{

            const response = await axios.post('/cart/add', {
                accessoryVariantColorId, quantity
            })

            push.success(response.data.message)
            getCart()
        }catch(err){
            console.log(err)
            if(err.response.data?.message){
                push.error(err.response.data?.message)
            }

        }finally{

        }
    }


    return {cart, isLoadingCart,

        addToCart, getCart, removeFromCart
    }



})