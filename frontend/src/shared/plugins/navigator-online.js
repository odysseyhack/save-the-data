/**
 * Plugin check rather the person is still online
 * Can be checked throughout v-if="isOnline" or check by the state variable : state.general.online
 */
const NavigatorOnline = {
  install(Vue, store, mutation) {
    if (!store) {
      throw new Error("Please provide Vuex store.");
    }

    const vm = new Vue({
      data: {
        online: window.navigator.onLine
      },
      watch: {
        online(newVal) {
          store.commit(mutation, newVal);
        }
      }
    });

    window.addEventListener("online", function handleOnline() {
      vm.$data.online = true;
    });

    window.addEventListener("offline", function handleOffline() {
      vm.$data.online = false;
    });

    Vue.mixin({
      computed: {
        isOnline() {
          return vm.$data.online;
        }
      }
    });
  }
};

if (typeof window !== "undefined" && window.Vue) {
  window.Vue.use(NavigatorOnline);
}

export default NavigatorOnline;
