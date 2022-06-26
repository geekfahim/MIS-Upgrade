require("../../../../bootstrap");
Vue.component("bank-charge", require("./BankChargeC").default);
const app = new Vue({
    el: "#bank-charge"
});
