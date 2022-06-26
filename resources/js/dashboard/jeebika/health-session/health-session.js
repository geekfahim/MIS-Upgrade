require('../../../bootstrap');
Vue.component('health-session', require('./HealthSessionC').default);
const app = new Vue({
    el: '#health-session-app'
});
