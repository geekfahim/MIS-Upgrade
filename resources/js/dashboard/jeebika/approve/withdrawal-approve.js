require("../../../bootstrap");
Vue.component("withdrawal-approve-app", require("./WithdrawalApproveC").default);
const app = new Vue({
    el: "#withdrawal-approve-app"
});
