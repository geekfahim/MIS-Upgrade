require("../../../bootstrap");
Vue.component(
    "project-manager-view-app",
    require("./ProjectManagerViewC").default
);
const app = new Vue({
    el: "#project-manager-view-app"
});
