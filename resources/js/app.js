import VueRouter from 'vue-router';

require('./bootstrap');

window.Vue = require('vue');
Vue.use(VueRouter);

const routes = [
  { path: '/dashboard', component: require('./components/Dashboard.vue').default },
  { path: '/profile', component: require('./components/Profile.vue').default }
];

const router = new VueRouter({
	routes // short for `routes: routes`
});

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
    router
});
