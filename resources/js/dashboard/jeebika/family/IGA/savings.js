require("../../../../bootstrap");
Vue.component("savings-app", require("./SavingsC").default);
const app = new Vue({
    el: "#savings-app"
});
