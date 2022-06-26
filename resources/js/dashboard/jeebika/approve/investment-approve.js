require("../../../bootstrap");
Vue.component("investment-approve-app", require("./InvestmentApproveC").default);
const app = new Vue({
    el: "#investment-approve-app"
});
