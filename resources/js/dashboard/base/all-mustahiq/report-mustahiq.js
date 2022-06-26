require('../../../bootstrap');
Vue.component('report-mustahiq-app', require('./ReportMustahiqC').default);
const app = new Vue({
    el: '#report-mustahiq-app'
});
