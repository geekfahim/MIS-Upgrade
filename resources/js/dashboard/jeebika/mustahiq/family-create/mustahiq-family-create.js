require('../../../../bootstrap');
const eventBus = new Vue();
Vue.use(eventBus)
Vue.component('mustahiq-family-create', require('./MustahiqFamilyCreateC').default);
const app = new Vue({
    el: '#mustahiq-family-create-app'
});
