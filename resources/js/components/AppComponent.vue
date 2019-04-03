<template>
    <div>
        <Header :auth="check" :admin="is_admin"></Header>
        <div class="main bg-grey-lighter">
            <router-view></router-view>
        </div>
        <Footer></Footer>
    </div>
</template>

<script>
    import Header from './sub/Header.vue';
    import Footer from './sub/Footer.vue';
    import Auth from './../store/auth';

    export default {
        created() {
            // console.log('App compo', this.check)
        },
        data() {
            return {
                auth: Auth.state.authenticated,
                is_admin: (/true/i).test(Auth.state.is_admin)
            }
        },
        components: {
            Header,
            Footer
        },
        computed: {
            check: function() {
                // console.log('App 2 compo', Auth.state.authenticated)
                if(this.auth) {
                    return true
                } else {
                    return false
                }
            } 
        },
        mounted() {
            Auth.initialize()
        }
    }
</script>
