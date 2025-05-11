<script setup>
import FormInput from '@/components/FormInput.vue'
import ButtonLink from '@/components/ButtonLink.vue'
import Button from '@/components/Button.vue'
import { RouterLink } from 'vue-router'

import { storeToRefs } from 'pinia'
import { ref } from 'vue'
import axios from 'axios';
import { push } from 'notivue'


const servicing = ref({
    name: '',
    email: '',
    phone: '',
    address: '',
    note: '',
})

const isLoading = ref(false)

const submitServicing = async () => {
    try {
        isLoading.value = true
        const response = await axios.post('/appointment/create', {
            name: servicing.value.name,
            email: servicing.value.email,
            phone: servicing.value.phone,
            address: servicing.value.address,
            type: 'servicing',
            note: servicing.value.note,
        })

        push.success(response.data.message)
        servicing.value = {
            name: '',
            email: '',
            phone: '',
            address: '',
            note: '',
        }

    } catch (err) {
        

        if(err.response?.data?.message){
            if(err.response?.data?.message?.phone){
                push.error(err.response?.data?.message?.phone)
            }
            else if(err.response?.data?.message?.address){
                push.error(err.response?.data?.message?.address)
            }
            else if(push.error(err.response?.data?.message?.name)){
                push.error(err.response?.data?.message?.name)
            }
            else if(push.error(err.response?.data?.message?.email)){
                push.error(err.response?.data?.message?.email)
            }
        }else{
            push.error("Cannot submit form")
        }

    }finally{
        isLoading.value = false
    }
}



</script>
<template>
    <section class="w-full flex items-center justify-center  h-[90vh]">

        <form @submit.prevent="submitServicing" class="flex flex-col border  bg-white p-6 gap-2 w-[300px] rounded-md">
            <h2 class="text-lg font-semibold">Make Servicing Appointment</h2>

            <FormInput label="Full Name" v-model="servicing.name" placeholder="Enter Full Name" id="name" />
            <FormInput label="Email" v-model="servicing.email" placeholder="Enter Email" id="email" />
            <FormInput label="Phone" v-model="servicing.phone" placeholder="Enter Phone Number" id="phone" />
            <FormInput label="Address" v-model="servicing.address" placeholder="Enter Address" id="address" />
            <FormInput label="Note" :required="false" v-model="servicing.note"  placeholder="Enter Note" id="note" />
            <Button :loading="isLoading" content="Submit" :isLink="false" type="submit" />
            <RouterLink to="/user/signup" class="text-sm hover:underline ">We'll reach you back after you submit the form.</RouterLink>
        </form>
    </section>
</template>