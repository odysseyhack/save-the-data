import * as orderBy from "lodash/orderBy";
import {
  SET_DEMO_FIRE,
  SET_DEMO_SMOKE,
  SET_DEMO_QUADRANT,
  SET_DEMO_URL
} from "./mutations.types";

export default {
  [SET_DEMO_URL](state, url) {
    state.url = url;
  },
  [SET_DEMO_QUADRANT](state, quadrant) {
    state.quadrant = quadrant;
  },
  [SET_DEMO_SMOKE](state, smoke) {
    state.smoke = smoke;
  },
  [SET_DEMO_FIRE](state, fire) {
    state.fire = fire;
  }
};
