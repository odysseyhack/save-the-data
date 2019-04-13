import moment from 'moment';

const Ago = {
  install(Vue) {
    Vue.filter('ago', (value) => {
      if (!value) { return ''; }

      const date = moment(value);
      return date.fromNow();
    });
  },
};

export default Ago;
