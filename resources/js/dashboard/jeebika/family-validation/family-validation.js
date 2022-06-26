require("../../../bootstrap");
Vue.component("family-validation", require("./FamilyValidationC").default);
const app = new Vue({
    el: "#family-validation-app"
});
