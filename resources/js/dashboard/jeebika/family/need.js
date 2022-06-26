require("../../../bootstrap");
Vue.component("need-app", require("./NeedC").default);
const app = new Vue({
    el: "#need-app"
});
