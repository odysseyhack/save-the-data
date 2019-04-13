import Vue from "vue";
import Main from "./Main.vue";
import router from "./router";
import store from "./store";

import { PLUGINS } from "./shared/plugins";

// Mutation
import { TOGGLE_ONLINE } from "./shared/store/general/mutations.types";

// Configuration settings
Vue.config.productionTip = false;

// Plugins
Vue.use(PLUGINS.NavigatorOnline, store, TOGGLE_ONLINE);
Vue.use(PLUGINS.Ago);

new Vue({
  router,
  store,
  render: h => h(Main)
}).$mount("#app");
