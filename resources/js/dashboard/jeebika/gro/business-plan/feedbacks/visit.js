require("../../../../../bootstrap");
Vue.component("visit-feedback", require("./VisitC").default);
const app = new Vue({
    el: "#visit-feedback"
});
