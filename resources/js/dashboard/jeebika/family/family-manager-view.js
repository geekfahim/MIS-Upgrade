require("../../../bootstrap");
Vue.component(
    "family-manager-view-app",
    require("./FamilyManagerViewC").default
);
const app = new Vue({
    el: "#family-manager-view-app"
});
