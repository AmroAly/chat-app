<template>
    <div class="register flex justify-center">
        <div class="w-full max-w-xs">
            <form @submit.prevent="register" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                <h3 class="text-teal-dark text-center">Register</h3>
                </div>
                <div class="mb-4">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="name">
                    Name
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none  mb-3 focus:shadow-outline" id="name" type="text" placeholder="John Doe" v-model="form.name">
                <p class="text-red text-xs italic" v-if="errors.name">{{ errors.name[0] }}</p>
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
                <div class="mb-6">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="password-confirmation">
                    Password Confirmation
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password-confirmation" type="password" placeholder="******************" v-model="form.password_confirmation">
                <p class="text-red text-xs italic" v-if="errors.password_confirmation">{{ errors.password_confirmation[0] }}</p>
                <!--<p class="text-red text-xs italic">Please choose a password.</p>-->
                </div>
                <div class="flex items-center justify-between">
                <button class="bg-teal hover:bg-teal-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Register
                </button>
                <router-link class="inline-block align-baseline font-bold text-sm text-teal" to="/login">
                    Have an account?
                </router-link>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import swal from 'sweetalert';

    export default {
        mounted() {            
        },
        data() {
            return {
                form: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },
                errors: {}
            }
        },
        methods: {
            register() {
                this.errors = {};
                axios.post(`http://localhost:8000/api/register`, this.form)
                    .then((res) => {
                        if(res.status === 201) {
                            // user created
                            swal("Your account has been created successfully!, You'll be redirected to login page.", {
                                buttons: false,
                                timer: 4000,
                                icon: "success"
                            }).then(() => this.$router.push("/login"));
                        }
                    })
                    .catch((e) => {
                        this.errors = e.response.data.errors
                    });
            }
        }
    }
</script>
