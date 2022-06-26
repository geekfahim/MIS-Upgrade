require("../../../../bootstrap");
Vue.component("withdrawal-app", require("./WithdrawalC").default);
const app = new Vue({
    el: "#withdrawal-app"
});
