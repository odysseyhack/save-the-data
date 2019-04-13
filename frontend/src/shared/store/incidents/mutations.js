import * as orderBy from 'lodash/orderBy';
import { SORT_INCIDENTS } from './mutations.types';

export default {
  [SORT_INCIDENTS](state, key, sort = 'desc') {
    state.all = orderBy(state.all, [key], [sort]);
  },
};
