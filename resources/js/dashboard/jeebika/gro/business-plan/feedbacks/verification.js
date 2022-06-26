require("../../../../../bootstrap");
Vue.component("verification-feedback", require("./VerificationC").default);
const app = new Vue({
    el: "#verification-feedback"
});
