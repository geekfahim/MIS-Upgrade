require('../../../bootstrap');
Vue.component('training-participant', require('./TrainingParticipant').default);
const app = new Vue({
    el: '#training-participant'
});
