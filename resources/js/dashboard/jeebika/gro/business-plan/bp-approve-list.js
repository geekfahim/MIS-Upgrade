require("../../../../bootstrap");
Vue.component("bp-approve-list", require("./BPApproveListC").default);
const app = new Vue({
    el: "#bp-approve-list-app"
});
