require("../../../bootstrap");
Vue.component(
    "gro-project-manager-view-app",
    require("./GroProjectManagerViewC").default
);
const app = new Vue({
    el: "#gro-project-manager-view-app"
});
