<template>
    <div class="container clearfix">
        <div class="people-list" id="people-list">
            <div class="search">
                <label>
                    <input type="text" placeholder="search"/>
                </label>
            </div>
            <ul class="list">
                <li @click.prevent="selectUser(user.id)" class="clearfix" v-for="user in userList" :key="user.id">
                    <div class="about">
                        <div class="name">{{ user.name }}</div>
                        <div class="status">
                            <i class="fa fa-circle online"></i> online
                        </div>
                    </div>
                </li>

            </ul>
        </div>

        <div class="chat">
            <div class="chat-header clearfix">
                <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_01.jpg" alt="avatar"/>
                <div class="chat-about">
                    <div class="chat-with" v-if="userMessage.user">{{ userMessage.user.name }}</div>
                    <div class="dropdown">
                        <a class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            ...
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a @click.prevent="deleteAllMessage" class="dropdown-item" href="#">Delete</a>
                        </div>
                    </div>
                </div>
            </div> <!-- end chat-header -->

            <div class="chat-history" v-chat-scroll>
                <ul>
                    <li class="clearfix" v-for="message in userMessage.messages" :key="message.id">
                        <div class="message-data align-right">
                            <span class="message-data-time">{{ message.created_at | timeFormat }}</span> &nbsp; &nbsp;
                            <span class="message-data-name">{{ message.user.name }}</span> <i
                            class="fa fa-circle me"></i>
                            <div class="dropdown">
                                <a class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    ...
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a @click.prevent="deleteMessage(message.id)" class="dropdown-item"
                                       href="#">Delete</a>
                                </div>
                            </div>
                        </div>
                        <div
                            :class="`message float-right ${ message.user.id === userMessage.user.id ? 'other-message' : 'my-message' }`">
                            {{ message.message }}
                        </div>
                    </li>

                </ul>

            </div> <!-- end chat-history -->

            <div class="chat-message clearfix">
                <textarea @keydown.enter="sendMessage" v-model="message" name="message-to-send" id="message-to-send"
                          placeholder="Type your message"
                          rows="3"></textarea>

            </div> <!-- end chat-message -->

        </div> <!-- end chat -->

    </div>
</template>

<script>
export default {
    mounted() {
        Echo.private(`chat.$authUser.id`)
            .listen('MessageSend', (e) => {
                console.log(e);
            });

        this.$store.dispatch('userList');
    },
    data() {
        return {
            message: ''
        }
    },
    computed: {
        userList() {
            return this.$store.getters.userList
        },

        userMessage() {
            return this.$store.getters.userMessage
        }
    },
    created() {
    },
    methods: {
        selectUser(userId) {
            this.$store.dispatch('userMessage', userId);
        },

        sendMessage(e) {
            e.preventDefault();
            if (this.message !== '') {
                axios.post('/sendMessage', {message: this.message, user_id: this.userMessage.user.id})
                    .then(response => {
                        this.selectUser(this.userMessage.user.id)
                    })
                this.message = '';
            }
        },

        deleteMessage(messageId) {
            axios.get(`/deleteMessage/${messageId}`)
                .then(response => {
                    this.selectUser(this.userMessage.user.id)
                })
        },

        deleteAllMessage() {
            axios.get(`/deleteAllMessage/${this.userMessage.user.id}`)
                .then(response => {
                    this.selectUser(this.userMessage.user.id)
                })
        }
    }
}
</script>

<style scoped>

</style>
