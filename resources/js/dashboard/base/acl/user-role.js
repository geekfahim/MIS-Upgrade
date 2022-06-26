require('../../../bootstrap');
Vue.component('user-role', require('./UserRoleC').default);
const app = new Vue({
    el: '#user-role-app'
});
