require("../../../bootstrap");
Vue.component("asset", require("./AssetC").default);
const app = new Vue({
    el: "#asset-app"
});
