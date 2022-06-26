require('../../../bootstrap');
Vue.component('indicator-app', require('./IndicatorC').default);
const app = new Vue({
    el: '#indicator-app'
});
