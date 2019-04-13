
import Vue from 'vue';
import Main from './Main.vue';
import router from './router';
import store from './store';

import { PLUGINS } from './shared/plugins';

// Mutation
import { TOGGLE_ONLINE, TOGGLE_LOADING } from './shared/store/general/mutations.types';

// Configuration settings
Vue.config.productionTip = false;

// Plugins
Vue.use(PLUGINS.NavigatorOnline, store, TOGGLE_ONLINE);
Vue.use(PLUGINS.Ago);

router.beforeEach((to, from, next) => {
  if (to.path == '/login') {
    next();
    return;
  }
  store.commit(TOGGLE_LOADING, true);
  next();
});

router.afterEach((to, from) => {
  setTimeout(() => store.commit(TOGGLE_LOADING, false), 1500); // timeout for demo purposes
});

new Vue({
  router,
  store,
  render: h => h(Main),
}).$mount('#app');
