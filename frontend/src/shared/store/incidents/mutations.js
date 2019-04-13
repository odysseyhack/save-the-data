import * as orderBy from 'lodash/orderBy';
import { SORT_INCIDENTS, SET_INCIDENTS } from './mutations.types';

export default {
  [SORT_INCIDENTS](state, key, sort = 'desc') {
    state.all = orderBy(state.all, [key], [sort]);
  },
  [SET_INCIDENTS](state,incidents) {
    state.all = incidents
  }
};
