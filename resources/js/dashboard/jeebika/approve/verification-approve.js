require("../../../bootstrap");
Vue.component("verification-approve-app", require("./VerificationApproveC").default);
const app = new Vue({
    el: "#verification-approve-app"
});
