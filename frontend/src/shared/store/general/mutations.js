import { TOGGLE_ONLINE, ADD_ERROR, REMOVE_ERROR } from "./mutations.types";

export default {
  [TOGGLE_ONLINE](state, bool) {
    state.online = bool;
  },
  [ADD_ERROR](state, error) {
    state.errors.push(error);
  },
  [REMOVE_ERROR](state, index) {
    state.errors.splice(index, 1);
  }
};
