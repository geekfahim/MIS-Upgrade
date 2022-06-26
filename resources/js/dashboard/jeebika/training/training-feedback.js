require('../../../bootstrap');
Vue.component('training-feedback', require('./TrainingFeedbackC').default);
const app = new Vue({
    el: '#training-feedback'
});
