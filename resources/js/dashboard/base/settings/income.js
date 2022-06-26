require('../../../bootstrap');
Vue.component('income',require('./IncomeC').default);
const app = new Vue({
    el: '#income-app'
});
