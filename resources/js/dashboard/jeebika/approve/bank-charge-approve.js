require("../../../bootstrap");
Vue.component("bank-charge-approve-app", require("./BankChargeApprove").default);
const app = new Vue({
    el: "#bank-charge-approve-app"
});
