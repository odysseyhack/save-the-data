import {
  LOGIN, LOGOUT, AUTHENTICATE, REDIRECT_SIGNIN,
} from './actions.types';
import { SET_AUTHENTICATED, SET_TOKEN } from './mutations.types';
import router from '@/router';

export default {
  [LOGIN]({ commit }, token) {
    commit(SET_AUTHENTICATED, true);
    commit(SET_TOKEN, token);
  },
  [LOGOUT]({ commit, dispatch }) {
    commit(SET_AUTHENTICATED, true);
    commit(SET_TOKEN, null);
    dispatch(REDIRECT_SIGNIN);
  },
  [REDIRECT_SIGNIN]() {
    router.push({ path: 'signin' });
  },
  async [AUTHENTICATE]({ dispatch }, token) {
    if (token) {
      dispatch(LOGIN, token);
    } else {
      dispatch(LOGOUT);
    }
  },
};
