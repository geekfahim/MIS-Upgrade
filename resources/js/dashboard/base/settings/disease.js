require('../../../bootstrap');
Vue.component('disease',require('./DiseaseC').default);
const app = new Vue({
    el: '#disease-app'
});
