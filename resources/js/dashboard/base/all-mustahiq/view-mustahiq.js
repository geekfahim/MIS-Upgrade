require('../../../bootstrap');
Vue.component('view-mustahiq-app', require('./ViewMustahiqC').default);
const app = new Vue({
    el: '#view-mustahiq-app'
});
