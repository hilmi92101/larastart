import VueRouter from 'vue-router';
import { Form, HasError, AlertError } from 'vform';
import moment from 'moment';
import VueProgressBar from 'vue-progressbar';

require('./bootstrap');

window.Vue = require('vue');
window.Form = Form;

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

Vue.use(VueProgressBar, {
	color: 'rgb(143, 255, 199)',
	failedColor: 'red',
	height: '300px'
});

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

// GLOBAL VUE FILTER
Vue.filter('upText', function(text){
	return text.charAt(0).toUpperCase() + text.slice(1);
});
Vue.filter('myDate', function(createdDate){
	return moment(createdDate).format('MMMM Do YYYY');
});

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
    router
});
