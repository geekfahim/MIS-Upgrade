require('../../../bootstrap');
Vue.component('disaster',require('./DisasterC').default);
const app = new Vue({
    el: '#disaster-app'
});
