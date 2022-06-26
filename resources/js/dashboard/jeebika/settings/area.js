require('../../../bootstrap');
Vue.component('area-component', require('./AreaC').default);
const app = new Vue({
    el: '#area-app'
});
