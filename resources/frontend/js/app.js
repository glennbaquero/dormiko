
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

require('./settings');

/* Event Bus */
window.Event = new Vue;

/* require flatpickr */
window.flatpickr = require('flatpickr');

import 'slick-carousel';

Vue.component('reservation', require('./views/reservation/Reservation.vue'));
Vue.component('subscription', require('./views/subscription/Subscription.vue'));

const app = {
	init() {
		this.setupVue();
	},

	setupVue() {
		new Vue({
		    el: '#main',
		});
	}
};

app.init();

