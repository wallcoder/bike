import { createRouter, createWebHistory } from 'vue-router'
import MainLayout from '../views/MainLayout.vue'
import HomePage from '@/views/HomePage.vue'
import Login from '@/views/Login.vue'
import Signup from '@/views/Signup.vue'
import Bikes from '@/views/Bikes.vue'
import BikePage from '@/views/BikePage.vue'
import AccessoryPage from '@/views/AccessoryPage.vue'
import Accessories from '@/views/Accessories.vue'
import Servicing from '@/views/Servicing.vue'

import { useAuthStore } from '@/stores/auth'
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
          component: Login,
          meta: { requiresLogout: true }
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
        },
        {
          path: '/bike/:slug',
          props: true,
          component: BikePage
        },
        {
          path: '/accessory/:slug',
          props: true,
          component: AccessoryPage
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


router.beforeEach(async (to, from) => {
  const { checkToken } = useAuthStore();

  if (to.meta.requiresAuth) {
    const check = await checkToken(true);
    if (!check) {
      return '/user/login'; // redirect
    }
    return true; // allow
  }

  if (to.meta.requiresLogout) {
    const check = await checkToken(true);
    if (check) {
      return '/'; // redirect to home
    }
    return true; // allow
  }

  return true; // allow by default
});

export default router
