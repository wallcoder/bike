<script setup>

const props = defineProps({
    content: {
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
    <button @click="fun" class=" px-4 py-2 bg-purple-600 rounded-lg text-white hover:brightness-[1.2] active:brightness-[1.1] ">
        {{ content }}
    </button>
</template>