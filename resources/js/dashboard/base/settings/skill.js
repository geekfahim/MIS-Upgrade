require('../../../bootstrap');
Vue.component('skill', require('./SkillC').default);
const app = new Vue({
    el: '#skill-app'
});
