require("../../../bootstrap");
Vue.component("equity-approve-app", require("./EquityApproveC").default);
const app = new Vue({
    el: "#equity-approve-app"
});
