require("../../../../bootstrap");
Vue.component("business-plan-joint", require("./BusinessPlanJointC").default);
const app = new Vue({
    el: "#business-plan-joint-app"
});
