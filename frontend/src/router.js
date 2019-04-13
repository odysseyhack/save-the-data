import Vue from 'vue';
import Router from 'vue-router';
import Home from './views/Home.vue';
import Dashboard from './views/Dashboard.vue';
import Login from './views/Login.vue';

Vue.use(Router);

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      component: Home,
      children : [
        {
          path: '/',
          name: 'home',
          component: Dashboard,
        }
      ]
    },
    {
      path : '/login',
      name : 'login',
      component : Login
    }
  ],
});
