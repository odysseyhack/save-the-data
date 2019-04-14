
import {
  SET_DEMO_FIRE,
  SET_DEMO_URL_SMOKE,
  SET_DEMO_URL_FIRE,
  SET_DEMO_SMOKE,
  SET_DEMO_QUADRANT,
  SET_DEMO_URL
} from "./mutations.types";

export default {
  // smoke_predictions
  [SET_DEMO_URL](state, url) {
    state.url = url;
  },
  [SET_DEMO_URL_FIRE](state, url) {
    state.url_fire = url;
  },
  [SET_DEMO_URL_SMOKE](state, url) {
    state.url_smoke = url;
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
