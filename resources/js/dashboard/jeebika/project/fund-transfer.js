require('../../../bootstrap');
Vue.component('fund-transfer-app', require('./FundTransferC').default);
const app = new Vue({
    el: '#fund-transfer-app'
});
