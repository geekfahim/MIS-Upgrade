require('../../../bootstrap');
Vue.component('training-component', require('./TrainingC').default);
const app = new Vue({
    el: '#training-app'
});
