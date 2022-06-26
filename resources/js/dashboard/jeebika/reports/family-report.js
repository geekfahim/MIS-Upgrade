require("../../../bootstrap");
Vue.component("family-report", require("./FamilyReportC").default);
const app = new Vue({
    el: "#family-report"
});
