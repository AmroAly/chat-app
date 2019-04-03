import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from '../components/Home.vue'
import Login from '../components/auth/Login.vue'
import Conversation from '../components/conversation/Conversation.vue'
import Register from '../components/auth/Register.vue'
import Auth from './../store/auth'

Vue.use(VueRouter)
Auth.check()


const routes = [
    { path: '/', component: Home, meta: {  requiredNotAuth: true}, children: [
        { path: 'conversation/:id?', component: Conversation, meta: {  requiredAuth: true}}
    ] },
    { path: '/login', component: Login, meta: {  requiredNotAuth: true} },
    { path: '/register', component: Register, meta: {  requiredNotAuth: true} }
]

const router = new VueRouter({
    mode: 'history',
    routes
})

router.beforeEach((to, from, next) => {
    if(to.meta.requiredAuth && !Auth.state.authenticated) {
        next('/login')
    }
    if(to.meta.requiredNotAuth && Auth.state.authenticated) {
        next('/conversation')
    }
    else {
        next()
    }
})

export default router;