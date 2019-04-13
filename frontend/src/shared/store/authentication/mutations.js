import { SET_AUTHENTICATED, SET_AUTH_USER, SET_TOKEN } from "./mutations.types";

export default {
  [SET_AUTHENTICATED](state, bool) {
    state.authenticated = bool;
  },
  [SET_TOKEN](state, token) {
    state.token = token;
  },
  [SET_AUTH_USER](state, user) {
    state.user = user;
  }
};
