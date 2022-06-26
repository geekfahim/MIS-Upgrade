require("../../../bootstrap");
Vue.component("training-report", require("./TrainingReportC").default);
const app = new Vue({
    el: "#training-report"
});
