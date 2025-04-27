<script setup>
import FormInput from '@/components/FormInput.vue'
import ButtonLink from '@/components/ButtonLink.vue'
import Button from '@/components/Button.vue'
import { RouterLink } from 'vue-router'

import { storeToRefs } from 'pinia'
import { ref } from 'vue'
import axios from 'axios';







</script>
<template>
    <section class="w-full flex items-center justify-center  h-[90vh]">
        <form @submit.prevent="handleLogin" class="flex flex-col border  bg-white p-6 gap-2 w-[300px] rounded-md">
            <h2 class="text-lg font-semibold">Login</h2>

            <FormInput label="Email" type="email" placeholder="Enter Email"/>
            <FormInput label="Password" type="password" placeholder="Enter Password" />
            <Button :loading="isLoadingLogin" content="Login" :isLink="false" type="submit" />
            <RouterLink to="/user/signup" class="text-sm hover:underline ">Don't have and account? Sign up</RouterLink>
        </form>
    </section>
</template>