require("../../../bootstrap");
Vue.component(
    "implementation-plan-feedback-app",
    require("./ImplementationPlanFeedbackC").default
);
const app = new Vue({
    el: "#implementation-plan-feedback-app"
});
