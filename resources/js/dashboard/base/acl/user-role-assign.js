require('../../../bootstrap');
Vue.component('user-role-assign', require('./UserRoleAssignC').default);
const app = new Vue({
    el: '#user-role-assign-app'
});
