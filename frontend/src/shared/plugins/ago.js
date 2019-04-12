import moment from "moment";

const Ago = {
  install(Vue) {
    Vue.filter("ago", function(value) {
      if (!value) return "";

      let date = moment(value);
      return date.fromNow();
    });
  }
};

export default Ago;
