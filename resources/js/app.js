require('./bootstrap');

window.Vue = require('vue');
import Vuex from 'vuex';

Vue.use(Vuex)

import VueChatScroll from 'vue-chat-scroll'
Vue.use(VueChatScroll)

import storeVuex from './store/index';
import timeFilter from './filter';

const store = new Vuex.Store(storeVuex)

Vue.component('main-app', require('./components/MainApp').default);

const app = new Vue({
    el: '#app',
    store
});
