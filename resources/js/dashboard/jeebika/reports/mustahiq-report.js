require("../../../bootstrap");
Vue.component("mustahiq-report", require("./MustahiqReportC").default);
const app = new Vue({
    el: "#mustahiq-report"
});
