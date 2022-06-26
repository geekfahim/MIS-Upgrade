require("../../../bootstrap");
Vue.component("project-report", require("./ProjectReportC").default);
const app = new Vue({
    el: "#project-report"
});
