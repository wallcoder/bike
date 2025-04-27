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
        <form @submit.prevent="handleSignup" class="flex flex-col border  bg-white p-6 gap-2 w-[300px] rounded-md">
            <h2 class="text-lg font-semibold">Make Servicing Appointment</h2>

            <FormInput label="Full Name" placeholder="Enter Full Name" />
            <FormInput label="Email" placeholder="Enter Email" />
            <FormInput label="Phone" placeholder="Enter Phone Number" />
            <FormInput label="Address" placeholder="Enter Address" />
            <Button :loading="isLoadingLogin" content="Submit" :isLink="false" type="submit" />
            <RouterLink to="/user/signup" class="text-sm hover:underline ">Don't have and account? Sign up</RouterLink>
        </form>
    </section>
</template>