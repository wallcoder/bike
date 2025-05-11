import { defineStore } from "pinia";
import { ref } from 'vue';
import axios from 'axios'; 

export const useAccStore = defineStore('acc', () => {
    const accs = ref([]);
    const isLoadingAccs = ref(false);
    const isLoadingAccPage = ref(false);
    const acc = ref([]);

    const getAccs = async (limit = 4) => {
        try {
            if (accs.value.length > 0) {
                return;
            }
            isLoadingAccs.value = true;
            const response = await axios.get('/accessories', {
                params: { limit } 
            });

            accs.value = response.data.data;
        } catch (err) {
            console.log(err);
        } finally {
            isLoadingAccs.value = false;
        }
    };

    const getAccBySlug = async (slug) => {
        try {
            if (acc.value?.slug === slug) {
                return;
            }
            isLoadingAccPage.value = true;
            const response = await axios.get(`/accessory/${slug}`);
            acc.value = response.data.data;
        } catch (err) {
            console.log(err);
        } finally {
            isLoadingAccPage.value = false;
        }
    };

   
    return {
        accs,
        acc,
        isLoadingAccs,
        isLoadingAccPage,
        getAccs,
        getAccBySlug
    };
});
