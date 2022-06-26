require('../../../bootstrap');
Vue.component('health-session-implementation', require('./HealthSessionImplementationC').default);
const app = new Vue({
    el: '#health-session-implementation'
});
