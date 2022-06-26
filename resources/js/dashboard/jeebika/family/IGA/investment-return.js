require("../../../../bootstrap");
Vue.component("investment-return", require("./InvestmentReturnC").default);
const app = new Vue({
    el: "#investment-return"
});
