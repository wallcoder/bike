<script setup>
import FormInput from '@/components/FormInput.vue'
import ButtonLink from '@/components/ButtonLink.vue'
import Button from '@/components/Button.vue'
import { RouterLink } from 'vue-router'

import { storeToRefs } from 'pinia'
import { ref } from 'vue'
import axios from 'axios';


import {useAuthStore} from '@/stores/auth'



const {handleLogin, }  = useAuthStore()
const {login, isLoadingLogin, user} = storeToRefs(useAuthStore())






</script>
<template>
   
    <section class="w-full flex items-center justify-center  h-[90vh]">
        <form @submit.prevent="handleLogin" class="flex flex-col border  bg-white p-6 gap-2 w-[300px] rounded-md">
            <h2 class="text-lg font-semibold">Login</h2>

            <FormInput label="Email" type="email" v-model="login.email" placeholder="Enter Email"/>
            <FormInput label="Password" v-model="login.password" type="password" placeholder="Enter Password" />
            <Button :loading="isLoadingLogin" content="Login"  type="submit" />
            <RouterLink to="/user/signup" class="text-sm hover:underline ">Don't have and account? Sign up</RouterLink>
        </form>
    </section>
</template>