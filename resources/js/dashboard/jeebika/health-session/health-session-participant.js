require('../../../bootstrap');
Vue.component('health-session-participant', require('./HealthSessionParticipantC').default);
const app = new Vue({
    el: '#health-session-participant'
});
