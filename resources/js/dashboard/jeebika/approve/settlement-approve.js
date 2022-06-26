require("../../../bootstrap");
Vue.component("settlement-approve-app", require("./SettlementApprove").default);
const app = new Vue({
    el: "#settlement-approve-app"
});
