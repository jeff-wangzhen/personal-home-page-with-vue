import Vue from "vue";
import router from "./router";
import store from "./store";
import {
    BButton,
    BCard,
    CardPlugin,
    LayoutPlugin,
    BFormInput,
    BFormSelect,
    BInputGroup,
    BTable
} from "bootstrap-vue";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import Meta from "vue-meta";
import { Indicator, Toast } from "mint-ui";
import "mint-ui/lib/style.css";
import axios from "axios";
import qs from "qs";
import App from "./App.vue";
Vue.use(Meta);
Vue.use(CardPlugin);
Vue.use(LayoutPlugin);
Vue.component("b-table", BTable);
Vue.component("b-card", BCard);
Vue.component("b-input-group", BInputGroup);
Vue.component("b-form-select", BFormSelect);
Vue.component("b-form-input", BFormInput);
Vue.component("b-button", BButton);
Vue.prototype.$Indicator = Indicator;
Vue.prototype.$Toast = Toast;
Vue.prototype.$axios = axios;
Vue.prototype.qs = qs;

if (window.location.host.indexOf(":") > -1) {
    //有端口，本地项目调试
    axios.defaults.baseURL = "http://127.7.7.7/grwz-vue/";
} else {
    //线上
    axios.defaults.baseURL = location.origin + "/grwz-vue/";
}

Vue.config.productionTip = false;
new Vue({
    router,
    store,
    render: (h) => h(App)
}).$mount("#app");
