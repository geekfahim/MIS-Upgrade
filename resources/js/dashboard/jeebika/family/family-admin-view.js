require("../../../bootstrap");
Vue.component("family-admin-view-app", require("./FamilyAdminViewC").default);
const app = new Vue({
    el: "#family-admin-view-app"
});
