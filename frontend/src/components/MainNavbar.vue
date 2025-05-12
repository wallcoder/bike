<script setup>
import { ref, watch } from 'vue'
import { RouterLink } from 'vue-router'
import Logo from '@/components/Logo.vue'
import { storeToRefs } from 'pinia'
import { useAuthStore } from '@/stores/auth'

const { isLoggedin } = storeToRefs(useAuthStore())
const {logout} = useAuthStore()
const isOpenSidebar = ref(false)
const links = ref([
    { label: 'Bikes', link: '/bikes' },
    { label: 'Servicing', link: '/servicing' },
    { label: 'Accessories', link: '/accessories' },
    { label: 'Login', link: '/user/login' },

])

watch(isOpenSidebar, (newVal) => {
    if (newVal) {
        document.body.classList.add('overflow-hidden')
    } else {
        document.body.classList.remove('overflow-hidden')
    }
})

</script>

<template>
    <section>
        <header class="py-3 px-[2%] flex justify-between items-center">

            <Logo />
            <div class="md:hidden cursor-pointer hover:text-gray-600" @click="isOpenSidebar = true">
                <i class='bx bx-menu text-3xl'></i>
            </div>
            <nav class=" items-center gap-4 hidden md:flex">
                <RouterLink to="/bikes" class="text-sm cursor-pointer py-2 px-4 rounded-lg hover:bg-gray-100"
                    exact-active-class="bg-gray-100">Bikes</RouterLink>
                <RouterLink to="/servicing" class="text-sm cursor-pointer py-2 px-4 rounded-lg hover:bg-gray-100"
                    exact-active-class="bg-gray-100">Servicing</RouterLink>
                <RouterLink to="/accessories" class="text-sm cursor-pointer py-2 px-4 rounded-lg hover:bg-gray-100"
                    exact-active-class="bg-gray-100">Accessories</RouterLink>
                <RouterLink v-if="!isLoggedin" to="/user/login"
                    class="text-sm cursor-pointer py-2 px-4 rounded-lg hover:bg-gray-100" exact-active-class="bg-gray-100">
                    Login</RouterLink>

                <div v-else class="flex gap-2 items-center">
                    <button @click="logout()" class="text-sm cursor-pointer py-2 px-4 rounded-lg hover:bg-gray-100">Logout</button>
                    <RouterLink to="/user" class="p-1 flex items-center justify-center size-8 cursor-pointer rounded-full hover:bg-gray-100">
                         <i class="bx bxs-cart text-lg "></i>
                    </RouterLink>
                    <RouterLink to="/user" class="p-1 flex items-center justify-center size-8 cursor-pointer rounded-full hover:bg-gray-100">
                         <i class="bx bxs-user text-lg "></i>
                    </RouterLink>
                    
                    
                </div>

            </nav>

        </header>

        <div class="fixed  w-full  top-0 left-0 z-30 pointer-events-none">
            <Transition>
                <div class="w-full bg-black/60 backdrop-blur-sm h-[100vh] pointer-events-auto"
                    @click="isOpenSidebar = false" v-if="isOpenSidebar">

                </div>
            </Transition>
            <div class="absolute top-0 right-0 bg-white  w-[300px] h-[100vh] flex flex-col pointer-events-auto transition-all duration-[0.5s] ease-out"
                :class="isOpenSidebar ? 'translate-x-0' : 'translate-x-[100%]'">
                <div class="flex justify-between items-center p-4">
                    <Logo />
                    <i class="bx bx-x text-3xl cursor-pointer hover:text-accent" @click="isOpenSidebar = false"
                        :class="isOpenSidebar ? 'rotate-[720deg]' : ''"></i>
                </div>
                <RouterLink @click="isOpenSidebar = false" :to="l.link" class="px-4 py-2 font-semibold "
                    exactActiveClass="text-purple-600" v-for="l in links" :key="l">{{ l.label }}</RouterLink>



            </div>

        </div>
    </section>
</template>
