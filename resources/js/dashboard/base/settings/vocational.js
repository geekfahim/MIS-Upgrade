require('../../../bootstrap');
Vue.component('vocational', require('./VocationalC').default);
const app = new Vue({
    el: '#vocational-app'
});
