import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
export const useBikeStore = defineStore('bike', ()=>{

    const bikes = ref([])
    const isLoadingBikes = ref(false)
    const isLoadingBikePage = ref(false)
    const bike = ref([])
    const getBikes = async (limit=4)=>{
        try{
            if(bikes.value?.data?.length > 0){
                return
            }
            isLoadingBikes.value = true
            const response = await axios.get('/bikes', {
                limit: limit
            })

            bikes.value = response.data.data

        }catch(err){
            console.log(err)
        }finally{
            isLoadingBikes.value = false
        }
    }

    const getBikeBySlug = async (slug)=>{

        try {
            if(bike.value?.slug === slug){
                return
            }
            isLoadingBikePage.value = true
            const response = await axios.get(`/bike/${slug}`)
            bike.value = response.data.data
            
        } catch (err) {
            console.log(err)
            
        }finally{
            isLoadingBikePage.value = false
        }

    }


    return {
        bikes, isLoadingBikes, getBikes, getBikeBySlug, bike, isLoadingBikePage
        
    }



})
