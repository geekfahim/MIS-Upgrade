require('../../../bootstrap');
Vue.component('project-app', require('./ProjectC').default);
const app = new Vue({
    el: '#project-app'
});
