require('../../../bootstrap');
Vue.component('training-implementation', require('./TrainingImplementationC').default);
const app = new Vue({
    el: '#training-implementation'
});
