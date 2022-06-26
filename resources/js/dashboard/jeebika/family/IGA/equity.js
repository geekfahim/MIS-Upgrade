require("../../../../bootstrap");
Vue.component("equity", require("./EquityC").default);
const app = new Vue({
    el: "#equity"
});
