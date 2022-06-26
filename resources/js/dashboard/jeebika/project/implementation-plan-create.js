require("../../../bootstrap");
Vue.component(
    "implementation-plan-create-app",
    require("./ImplementationPlanCreateC").default
);
const app = new Vue({
    el: "#implementation-plan-create-app"
});
