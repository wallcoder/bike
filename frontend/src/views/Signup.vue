<script setup>
import FormInput from '@/components/FormInput.vue'
import ButtonLink from '@/components/ButtonLink.vue'
import Button from '@/components/Button.vue'
import { RouterLink } from 'vue-router'

import {useAuthStore} from '@/stores/auth'
import { storeToRefs } from 'pinia'
import { ref } from 'vue'


const {handleSignUp}  = useAuthStore()
const {signUp, isLoadingSignup} = storeToRefs(useAuthStore())






</script>
<template>
 
     
    <section class="w-full flex items-center justify-center  h-[90vh]">
        <form @submit.prevent="handleSignUp" class="flex flex-col border  bg-white p-6 gap-2 w-[300px] rounded-md">
            <h2 class="text-lg font-semibold">Sign up</h2>

            <FormInput id="email" label="Email" type="email" v-model="signUp.email" placeholder="Enter Email"/>
           
            <FormInput id="name" label="Name" type="text" v-model="signUp.name" placeholder="Enter name"/>
            <FormInput id="password" label="Password" type="password" v-model="signUp.password"  placeholder="Enter Password" />
            <FormInput id="conPassword" label="Confirm Password" type="password" v-model="signUp.confirm_password" placeholder="Enter Password" />
            <Button :loading="isLoadingSignup" content="Register"  type="submit" />
            <RouterLink  to="/user/login" class="text-sm hover:underline ">Already have an account? Login</RouterLink>
        </form>
    </section>
</template>