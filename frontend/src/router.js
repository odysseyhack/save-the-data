import Vue from 'vue';
import Router from 'vue-router';
import Home from './views/Home.vue';
import Dashboard from './views/Dashboard.vue';
import Login from './views/Login.vue';
import Demo from './views/Demo.vue';
import DemoResult from './views/DemoResult.vue';
import DemoUpload from './views/DemoUpload.vue';
import IncidentsOverview from './views/IncidentsOverview.vue';

Vue.use(Router);

export default new Router({
  mode: "history",
  linkExactActiveClass: "active",
  linkActiveClass: "active",
  routes: [
    {
      path: "/",
      component: Home,
      children: [
        {
          path: "/demo",
          name: "demo",
          component: Demo,
          children: [
            {
              path: "/",
              name: "demo-upload",
              component: DemoUpload
            },
            {
              path: "/demo/results",
              name: "demo-results",
              component: DemoResult
            }
          ]
        },
      ]
    },
    {
      path: "/login",
      name: "login",
      component: Login
    }
  ]
});
