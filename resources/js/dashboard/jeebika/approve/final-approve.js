require("../../../bootstrap");
Vue.component("final-approve-app", require("./FinalApproveC").default);
const app = new Vue({
    el: "#final-approve-app"
});
