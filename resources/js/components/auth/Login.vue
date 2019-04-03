<template>
    <div class="login flex justify-center">
        <div class="w-full max-w-xs">
            <form @submit.prevent="login" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                <h3 class="text-teal-dark text-center">Login</h3>
                </div>
                <div class="mb-4">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="email">
                    Email
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker mb-3 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="Email" v-model="form.email">
                <p class="text-red text-xs italic" v-if="errors.email">{{ errors.email[0] }}</p>
                </div>
                 <div class="mb-6">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                    Password
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************" v-model="form.password">
                <p class="text-red text-xs italic" v-if="errors.password">{{ errors.password[0] }}</p>
                </div>
                <div class="bg-red-lightest border border-red-light text-red-dark px-4 py-3 rounded mb-3 relative" role="alert" v-if="errors.message">
                
                <span class="block sm:inline">{{ errors.message }}</span>               
                </div>
                <div class="flex items-center justify-between">
                <button class="bg-teal hover:bg-teal-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Sign In
                </button>
                <router-link class="inline-block align-baseline font-bold text-sm text-teal" to="/register">
                    Register
                </router-link>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import swal from 'sweetalert';
    import Auth  from './../../store/auth';

    export default {
        created() {
        },
        mounted() {     
        },
        data() {
            return {
                form: {
                    email: '',
                    password: '',
                },
                errors: {
                    message: ""
                }
            }
        },
        methods: {
            login() {
                this.errors = {
                    message: ""
                };
                axios.post(`http://localhost:8000/api/login`, this.form)
                    .then((res) => {
                        // save the tokens
                        const { access_token, user_id } = res.data;
                        Auth.set(access_token, user_id);
                        window.location.href = "http://localhost:8000/"
                    })
                    .catch((e) => {
                        if(e.response &&e.response.status === 401) {
                            this.errors.message = "We have no records matching the email and password you entered!."
                        } else {
                            if(e.response) {
                                this.errors = e.response.data.errors
                            } else {
                                this.errors.message = "It's not you, it's us. We're working to fix that soon :)"
                            }
                        }
                    });
            }
        }
    }
</script>
