import Vue from 'vue';
import Vuex from 'vuex';

import general from './shared/store/general';
import authentication from './shared/store/authentication';
import incidents from './shared/store/incidents';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    general,
    authentication,
    incidents,
  },
});
