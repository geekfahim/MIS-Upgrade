require("../../../../bootstrap");
Vue.component("business-plan-app", require("./BusinessPlanC").default);
const app = new Vue({
    el: "#business-plan-app"
});
