require('../../../bootstrap');
Vue.component('profile', require('./ProfileC').default);
const app = new Vue({
    el: '#profile-app'
});
