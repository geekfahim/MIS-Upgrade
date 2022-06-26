require("../../../bootstrap");
Vue.component("visit-approve-app", require("./VisitApproveC").default);
const app = new Vue({
    el: "#visit-approve-app"
});
