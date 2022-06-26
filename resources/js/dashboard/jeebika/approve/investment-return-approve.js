require("../../../bootstrap");
Vue.component("investment-return-approve-app", require("./InvestmentReturnApproveC").default);
const app = new Vue({
    el: "#investment-return-approve-app"
});
