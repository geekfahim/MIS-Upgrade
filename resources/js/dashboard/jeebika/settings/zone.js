require('../../../bootstrap');
Vue.component('zone-component', require('./ZoneC').default);
const app = new Vue({
    el: '#zone-app'
});
