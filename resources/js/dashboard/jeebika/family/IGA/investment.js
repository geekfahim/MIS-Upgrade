require("../../../../bootstrap");
Vue.component("investment-app", require("./InvestmentC").default);
const app = new Vue({
    el: "#investment-app"
});
