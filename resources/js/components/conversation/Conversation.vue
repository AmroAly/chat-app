<template>
    <div>
    <div v-if="!id">
        <h3 class="text-grey-darkest font-thin text-center"><== Please select a user to start chatting with!</h3>
    </div>
    <div v-else>
        <div class="flex flex-col max-w-sm m-auto bg-white border border-grey rounded p-4" id="conversation">
            <div class="message text-grey-dark border p-3 mb-3 rounded w-1/2" :class="message.user_id == user_id ? 'owner': 'not-owner'" v-for="message in messages">{{ message.text }}</div>
        </div>
        <form class="w-full max-w-sm m-auto" id="message-form" @submit.prevent="sendMessage">
            <div class="flex items-center border-b border-b-2 border-teal py-2">
                <input class="appearance-none bg-transparent border-none w-full text-grey-darker mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" placeholder="Your Message" aria-label="message">
                <button class="flex-no-shrink bg-teal hover:bg-teal-dark border-teal hover:border-teal-dark text-sm border-4 text-white py-1 px-5 rounded" type="submit">
                send
                </button>
            </div>
        </form>
    </div>
    </div>
</template>

<script>
    import { get, post } from '../../helper/api'
    import Auth from '../../store/auth'

    export default {
        mounted() {
            const v = this
            var socket = io.connect('http://localhost:8890');
            if(this.$route.params.id) {
                get(`/api/conversations/${this.id}`)
                .then((res) => {
                    this.messages = res.data.messages
                    this.conv_id = res.data.conv_id
                    
                    socket.emit('add user', {'client': v.user_id, 'conversation': v.conv_id});
                    console.log(v.user_id, v.conv_id)
                    v.scrollToBottom()
                })
                .catch(err => console.log(err))
            }
            
            socket.on('message', function(e) {
                console.log(e)
                v.createMessageElem(e.msg, false);
                v.scrollToBottom()
            })
        },
        data() {
            return {
                messages: [],
                conv_id: null,
                error: '',
                user_id: Auth.state.user_id
            }
        },
        methods: {
            sendMessage(e) {
                const msg = e.target.elements[0].value.trim();
                const v = this;
                if(msg) {
                    if(this.validateInput(msg)) {
                        // send data to the server
                        post(`/api/messages`, {
                            conversation_id: this.conv_id,
                            text: msg
                        })
                        .then(res => {
                            v.messages.push({
                                'text': res.data.message.text,
                                'conversation_id': v.conv_id,
                                'user_id': v.user_id
                            })
                            document.getElementById('message-form').reset()
                            v.scrollToBottom()
                        })
                        .catch(err => console.log(err))
                    }
                }
            },
            scrollToBottom() {
                setTimeout(() => {
                    const objDiv = document.getElementById("conversation");
                    objDiv.scrollTop = objDiv.scrollHeight;
                }, 10)
            },
            createMessageElem(text, isOwner) {
                var node = document.createElement("DIV");
                var textnode = document.createTextNode(text);
                node.className = `message text-grey-dark border p-3 mb-3 rounded w-1/2 ${isOwner ? 'owner': 'not-owner'}`
                node.appendChild(textnode);
                document.getElementById('conversation').appendChild(node)
            },
            validateInput(msg) {
                const badWords = ['fuck', 'shit', 'bitch', 'damn']
                let flag = false;
                msg.split(' ').forEach(word => {
                    if(badWords.includes(word.toLowerCase())) {
                        flag = true
                    }
                });
                if(flag) {
                    swal("Please stop using bad words", {
                        buttons: false,
                        timer: 2000,
                        icon: "error"
                    })
                    return false
                }
                return true
            }
        },
        computed: {
            id() {
                return Number(this.$route.params.id)
            },
            conversation() {
                return []
            }
        },
        updated() {
        },
        beforeRouteUpdate(to, from, next) {
            // window.location.reload()
            var socket = io.connect('http://localhost:8890');
            const that = this
            if(to.params.id) {
                
                get(`/api/conversations/${to.params.id}`)
                .then((res) => {
                    this.messages = res.data.messages
                    this.conv_id = res.data.conv_id
                    
                    socket.emit('add user', {'client': that.user_id, 'conversation': this.conv_id});
                    that.scrollToBottom()
                })
                .catch(err => console.log(err))
            }
            socket.on('message', function(e) {
                that.messages.push({ "text": e.msg, "user_id": e.user_id})
                that.scrollToBottom()
            })
            next() 
        },
        created() {
        }
    }
</script>