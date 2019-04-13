import { ADD_ERROR, REMOVE_ERROR, TOGGLE_ERROR } from './mutations.types';

export default {
  addIncidents({ commit, state }, error_message) {
    commit(ADD_INCIDENT, error_message);
  },
  removeIncidents({ commit, state }, index) {
    commit(REMOVE_INCIDENT, index);
  },
};
