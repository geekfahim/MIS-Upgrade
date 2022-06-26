require("../../../bootstrap");
Vue.component("gro-admin-view-app", require("./GroAdminViewC").default);
const app = new Vue({
    el: "#gro-admin-view-app"
});
