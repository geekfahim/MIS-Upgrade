require("../../../../bootstrap");
Vue.component("miscellaneous-app", require("./MiscellaneousC").default);
const app = new Vue({
    el: "#miscellaneous-app"
});
