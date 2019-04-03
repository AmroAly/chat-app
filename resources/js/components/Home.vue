<template>
<div>
    <div class="home my-container flex items-center inline-block xl:justify-between  flex-wrap w-4/5 mx-auto" v-if="!auth">
        <h1 class="text-grey-darkest mx-auto font-thin">Welcome to Chat App, Please <router-link to="/login" class="text-teal-dark">login</router-link> to start chatting!</h1>
    </div>
    <div class="flex md:flex-row-reverse flex-wrap home" v-else>
        <div class="my-container flex justify-between flex-wrap w-4/5">
            <div class="w-full md:w-1/5  text-grey-darker sidebar">
                <ul class="list-reset block border max-h-xs border-grey rounded" id="users-list">
                <h4 class="p-4 text-center">Users List</h4>
                    <li class="border bg-white" v-for="user in users">
                        <router-link class="text-blue block no-underline hover:bg-white p-3" :to="'/conversation/'+user.id">{{ user.name }}</router-link>
                    </li>
                </ul>
            </div>
            <div class="w-full md:w-4/5  text-grey-lighter">
                <router-view></router-view>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    // import axios from 'axios'
    import { get, post } from '../helper/api'
    import Auth from '../store/auth'

    export default {
        mounted() {
            // get the users list
            get(`/api/users`)
                .then(r => {
                    this.users = r.data.users
                })
                .catch((e) => console.log(e))
        },
        data() {
            return {
                auth: Auth.state.authenticated,
                users: []
            }
        },
        methods: {
        },
    }
</script>
