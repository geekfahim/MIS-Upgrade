require('../../../bootstrap');
Vue.component('sponsor-app', require('./SponsorC').default);
const app = new Vue({
    el: '#sponsor-app'
});
