require("../../../bootstrap");
Vue.component("savings-approve-app", require("./SavingsApproveC").default);
const app = new Vue({
    el: "#savings-approve-app"
});
