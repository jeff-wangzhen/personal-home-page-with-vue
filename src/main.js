import Vue from "vue";
import router from "./router";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import {
    BButton,
    BCard,
    BFormInput,
    BFormSelect,
    BInputGroup,
    BSpinner,
    BTable,
    CardPlugin,
    LayoutPlugin,
    NavPlugin
} from "bootstrap-vue";
// import { Loading } from "element-ui";
// import { Message } from "element-ui";
// Vue.prototype.$message = Message;
// Vue.use(Loading);
// import ElementUI from "element-ui";
// Vue.use(ElementUI);
// import Mint from "mint-ui";
// Vue.use(Mint);
import Meta from "vue-meta";

Vue.use(Meta);
import { Indicator, InfiniteScroll, Loadmore, Toast } from "mint-ui";
// Vue.component(TabContainer.name, TabContainer);
// Vue.component(TabContainerItem.name, TabContainerItem);
// Vue.use(TabContainer);
// Vue.use(TabContainerItem);
import "mint-ui/lib/style.css";
import axios from "axios";
import qs from "qs";
import App from "./App.vue";
// import store from "./store";
Vue.use(NavPlugin);
Vue.component("b-table", BTable);
Vue.component("b-card", BCard);
Vue.use(LayoutPlugin);
Vue.use(CardPlugin);
Vue.component("b-input-group", BInputGroup);
Vue.component("b-form-select", BFormSelect);
Vue.component("b-form-input", BFormInput);
Vue.component("b-button", BButton);
Vue.component("b-spinner", BSpinner);
// import "element-ui/lib/theme-chalk/index.css";
Vue.use(InfiniteScroll);
Vue.component(Loadmore.name, Loadmore);
Vue.prototype.$Indicator = Indicator;
Vue.prototype.$Toast = Toast;
// import { TabContainer, TabContainerItem } from "mint-ui";
// import { Tabs, TabPane } from "element-ui";
// // import App from "./App.vue";

// Vue.component(Tabs.name, Tabs);
// Vue.component(TabPane.name, TabPane);
// import "element-ui/lib/theme-chalk/index.css";

// Vue.directive("title", {
//     inserted: function(el, binding) {
//         document.title = el.dataset.title;
//     }
// });
Vue.prototype.$axios = axios; //全局注册，使用方法为:this.$axios
Vue.prototype.qs = qs;
axios.defaults.baseURL = "/grwz-vue/";
console.log(5465465464);
Vue.config.productionTip = false;
new Vue({
    router,
    // store,
    render: (h) => h(App)
}).$mount("#app");
