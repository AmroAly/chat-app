<template>
    <div>
        <nav class="shadow-lg flex items-center justify-between flex-wrap bg-teal">
        <div class="my-container flex items-center justify-between flex-wrap w-4/5">
            <div class="flex items-center flex-no-shrink text-white mr-10">
            <router-link class="font-semibold text-xl text-white" to="/">
                Chat App
            </router-link>
            </div>
            
            <div class="w-full block lg:flex lg:items-center lg:w-auto">
                <div>
                <router-link to="/login" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal hover:bg-white mt-4 lg:mt-0 mr-4" v-if="!auth">Login</router-link>
                </div>
                 <div>
                <router-link to="/register" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal hover:bg-white mt-4 lg:mt-0" v-if="!auth">Register</router-link>
                </div>
                 <div>
                <router-link to="/dashboard/auctions" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal hover:bg-white mt-4 lg:mt-0" v-if="admin">Dashboard</router-link>
                <form @submit.prevent="logout" class="inline-block" v-if="auth">
                    <button class="bg-teal hover:bg-teal-light text-white font-bold py-2 px-4 border-b-4 border-teal-dark hover:border-teal rounded">
                        Logout
                    </button>
                </form>
                </div>
            </div>
            </div>
        </nav> 
    </div>
</template>

<script>
    import Auth from '../../store/auth'
    import { post } from '../../helper/api'

    export default {
        props: [
            'auth',
            'admin'
        ],
        mounted() {
        },
        data() {
            return {
                // auth: Auth.state.authenticated
            }
        },
        methods: {
            logout() {
                post(`/api/logout`, {})
                    .then(res => {
                        if(res.statusText === "OK") {
                            Auth.remove()
                            window.location.reload()
                        }
                    })
                    .catch(e => {
                        console.log(e)
                    });
            }
        },
    }
</script>
