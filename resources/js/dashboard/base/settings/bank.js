require('../../../bootstrap');
Vue.component('bank-app',require('./BankC').default);
const app = new Vue({
    el: '#bank-app'
});