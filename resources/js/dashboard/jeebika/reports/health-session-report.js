require("../../../bootstrap");
Vue.component("health-session-report", require("./HealthSessionReportC").default);
const app = new Vue({
    el: "#health-session-report"
});
