import axios from 'axios';

export default {
    state: {
        'access_token': null,
        'user_id': null,
        'authenticated': false
    },
    initialize() {
        this.state.access_token = localStorage.getItem('access_token')
        this.state.user_id = localStorage.getItem('user_id')
        this.state.authenticated = localStorage.getItem('authenticated')
    },
    set(access_token, user_id) {
        localStorage.setItem('access_token', `Bearer ${access_token}`)
        localStorage.setItem('user_id', user_id)
        localStorage.setItem('authenticated', true)
        this.initialize()
    },
    remove() {
        localStorage.removeItem('access_token')
        localStorage.removeItem('user_id')
        localStorage.removeItem('authenticated')
        this.initialize()
    },
    check() {
        this.initialize()
        const headers = {Authorization: this.state.access_token}
        axios.get(`/api/user`, { headers })
            .then((res) => {
                // console.log('response check', res)
                if (res.data.user) {
                    return true
                }
            })
            .catch((err) =>{
                if(performance.navigation.type !== 1) {
                    if (err.response.status === 401) {
                        if(this.state.authenticated == "true") {
                            window.location.reload()
                        }
                    }
                }
                this.remove()
            })
    }
}
