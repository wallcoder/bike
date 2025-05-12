<script setup>
import {RouterLink} from 'vue-router'

const props = defineProps({
    content: {
        type: String,
        default: ""

    },
    link: {
        type: String,
        default: ""
    },
    fun: {
        type: Function,
        default: ()=>{}
    }
})

</script>
<template>
    <RouterLink :to="link" @click="fun()"  class="text-sm px-2 py-2 bg-purple-600 text-center rounded-lg text-white hover:brightness-[1.2] active:brightness-[1.1] ">
        {{ content }}
    </RouterLink>
</template>