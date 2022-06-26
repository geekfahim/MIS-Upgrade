require('../../../bootstrap');
Vue.component('district-app', require('./DistrictC').default);
const app = new Vue({
    el: '#district-app'
});
