<script setup>

const props = defineProps({
    content: {
        type: String,
        default: ""

    },
    fun: {
        type: Function,
        default: ()=>{}
    },
    loading: {
        type: Boolean,
         default: false
    }

})

</script>
<template>
    <button @click="fun" :disabled="loading" class=" px-4 py-2 bg-purple-600 rounded-lg text-white hover:brightness-[1.2] active:brightness-[1.1] ">
        
        <span v-if="loading">Loading..</span>
        <span v-else>  {{ content }}</span>
        
       
    </button>
</template>