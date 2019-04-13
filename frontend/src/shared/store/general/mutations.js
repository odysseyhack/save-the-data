import {
  TOGGLE_ONLINE, TOGGLE_LOADING, ADD_ERROR, REMOVE_ERROR,
} from './mutations.types';

export default {
  [TOGGLE_ONLINE](state, bool) {
    state.online = bool;
  },
  [ADD_ERROR](state, error) {
    state.errors.push(error);
  },
  [REMOVE_ERROR](state, index) {
    state.errors.splice(index, 1);
  },
  [TOGGLE_LOADING](state, bool) {
    state.loading = bool;
  },
};
