require('../../../bootstrap');
Vue.component('health-session-feedback', require('./HealthSessionFeedbackC').default);
const app = new Vue({
    el: '#health-session-feedback'
});
