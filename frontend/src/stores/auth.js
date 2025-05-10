import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios';
import {push} from 'notivue'
import { useRouter } from 'vue-router'
export const useAuthStore = defineStore('auth', () => {


    const user = ref(null)
    const isLoggedin = ref()
    const isLoadingLogin = ref(false)
    const isLoadingEditName = ref(false)
    const isLoadingSignup = ref(false)
    const isLoadingChangePassword = ref(false)
    const router = useRouter()
    const login = ref({
        email: '',
        password: '',

    })

    const signUp = ref({
        name: '',
        email: '',
        password: '',
        confirm_password: '',

    })


    const handleLogin = async () => {
        try {
            // startLoading()
            isLoadingLogin.value = true
            const response = await axios.post('/login', {
                email: login.value.email,
                password: login.value.password,
            })


            // localStorage.setItem('user', JSON.stringify(response.data.data))
            user.value = response.data.data
            console.log(user.value)
            localStorage.setItem('message', response.data.message)
            window.location.replace('/')
            isLoggedin.value = true;

            login.value = {
                email: '',
                password: '',

            }

        } catch (err) {
            console.log(err)
            if (err.response.data) {


                push.error(err.response.data.message)
            }
        } finally {
            // finishLoading()
            isLoadingLogin.value = false
        }


    }

    // SIGN UP

    const handleSignUp = async () => {
        try {
            console.log("hehehe")
            // startLoading()
            isLoadingSignup.value = true
            const response = await axios.post('/register', {
                email: signUp.value.email,
                name: signUp.value.name,
                password: signUp.value.password,
                confirm_password: signUp.value.confirm_password,
            })

            isLoggedin.value = true;

            // localStorage.setItem('user', JSON.stringify(response.data.data))
            user.value = response.data.data
            localStorage.setItem('message', response.data.message)
            window.location.replace('/')

            signUp.value = {
                name: '',
                email: '',
                password: '',
                conPassword: '',

            }

            push.success(response.data.message)



        } catch (err) {
            console.log(err)
            if (err.response.data) {
                const message = err.response.data.message
                if (message.email) {
                    push.error(err.response.data.message['email'][0])
                    console.log("Error: ", err.response.data.message['email'])
                } else if (message.password) {
                    push.error(err.response.data.message['password'][0])
                    console.log("Error: ", err.response.data.message['password'])
                } else if (message.confirm_password) {
                    push.error(err.response.data.message['confirm_password'][0])
                    console.log("Error: ", err.response.data.message['confirm_password'])
                }

            }
            // push.error(err.response.data.message) 
        } finally {
            // finishLoading()
            isLoadingSignup.value = false
        }
    }


    const checkToken = async (init = false) => {
        try {
            // startLoading()
            const response = await axios.get('/me')
            // localStorage.setItem('user', JSON.stringify(response.data.data))
            isLoggedin.value = true
            user.value = response.data.data
            // console.log("user: ", user.value)
            return true
        } catch (err) {
            // console.log(err)
            if (err.response.status == 401) {
                if (init) {
                    user.value = null
                    isLoggedin.value = false
                    return false
                }
                // push.error(`${err.response.data.message}. You are logged out`)
                logout()
                return false
            }

        } finally {
            // finishLoading()
        }
    }


    const logout = async () => {
        try {
            // startLoading()
            const response = await axios.post('/logout')

            user.value = null
            localStorage.setItem('message', response.data.message)

            isLoggedin.value = false

            window.location.replace('/')
        } catch (err) {
            console.log(err)
        } finally {
            // finishLoading()
        }
    }


    return {
        user,
        isLoggedin,
        isLoadingLogin,
        isLoadingEditName,
        isLoadingSignup,
        isLoadingChangePassword,

        login,
        signUp,
        handleLogin,
        handleSignUp,
        checkToken,
        logout
    }



})