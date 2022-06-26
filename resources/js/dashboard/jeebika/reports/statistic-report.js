require("../../../bootstrap");
Vue.component("statistic-report", require("./StatisticReportC").default);
const app = new Vue({
    el: "#statistic-report"
});
