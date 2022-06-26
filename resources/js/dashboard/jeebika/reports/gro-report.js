require("../../../bootstrap");
Vue.component("gro-report", require("./GroReportC").default);
const app = new Vue({
    el: "#gro-report"
});
