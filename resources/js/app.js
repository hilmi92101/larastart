import VueRouter from 'vue-router';
import { Form, HasError, AlertError } from 'vform';

require('./bootstrap');

window.Vue = require('vue');
window.Form = Form;

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.use(VueRouter);

const routes = [
  { path: '/dashboard', component: require('./components/Dashboard.vue').default },
  { path: '/users', component: require('./components/Users.vue').default },
  { path: '/profile', component: require('./components/Profile.vue').default },
];

const router = new VueRouter({
	mode: 'history',
	routes // short for `routes: routes`
});

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
    router
});
