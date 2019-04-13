import { ADD_ERROR, REMOVE_ERROR, TOGGLE_ERROR } from "./mutations.types";

export default {
  addError({ commit, state }, error_message) {
    commit(ADD_ERROR, error_message);
    commit(TOGGLE_ERROR, state.errors.length > 0);
  },
  removeError({ commit, state }, index) {
    commit(REMOVE_ERROR, index);
    commit(TOGGLE_ERROR, state.errors.length > 0);
  }
};
