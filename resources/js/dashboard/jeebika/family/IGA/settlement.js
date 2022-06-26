require("../../../../bootstrap");
Vue.component("settlement-app", require("./SettlementC").default);
const app = new Vue({
    el: "#settlement-app"
});
