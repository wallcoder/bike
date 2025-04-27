import { createRouter, createWebHistory } from 'vue-router'
import MainLayout from '../views/MainLayout.vue'
import HomePage from '@/views/HomePage.vue'
import Login from '@/views/Login.vue'
import Signup from '@/views/Signup.vue'
import Bikes from '@/views/Bikes.vue'
import Accessories from '@/views/Accessories.vue'
import Servicing from '@/views/Servicing.vue'
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'main-layout',
      component: MainLayout,
      children: [
        {
          path: '',
          name: 'home',
          component: HomePage
        },
        {
          path: '/user/login',
          name: 'login',
          component: Login
        },
        {
          path: '/user/signup',
          name: 'signup',
          component: Signup
        },
        {
          path: '/bikes',
          name: 'bikes',
          component: Bikes
        },
        {
          path: '/accessories',
          name: 'accessories',
          component: Accessories
        },
        {
          path: '/servicing',
          name: 'serviving',
          component: Servicing
        }
      ]
    },
    
  ],
  scrollBehavior(to, from, savedPosition) {
    if (to.hash) {
      return {
        el: to.hash,
        behavior: 'smooth', // Smooth scroll
      };
    }
    return savedPosition || { top: 0 };
  },


  
})

export default router
