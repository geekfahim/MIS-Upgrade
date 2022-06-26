require('../../../bootstrap');
Vue.component('occupation',require('./OccupationC').default);
const app = new Vue({
    el: '#occupation-app'
});
