
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Push = require('push.js');

import VeeValidate from 'vee-validate';

var VueValidationEs = require('vee-validate/dist/locale/es');

Vue.use(VeeValidate, {
  locale: 'sv',
  dictionary: {
    sv: VueValidationEs
  }
});
var VueEventBus = require('vue-event-bus');
Vue.use(VueEventBus);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('alumno', require('./components/Alumno.vue'));
Vue.component('maestro', require('./components/Maestro.vue'));
Vue.component('extraclase', require('./components/Extraclase.vue'));
Vue.component('carrera', require('./components/Carrera.vue'));
Vue.component('grupo', require('./components/Grupo.vue'));
Vue.component('publicacion', require('./components/Publicacion.vue'));
Vue.component('publicaciones', require('./components/Publicaciones.vue'));
Vue.component('comentario', require('./components/Comentario.vue'));
Vue.component('notificacion', require('./components/Notificacion.vue'));

const app = new Vue({
    el: '#app',
    data:{
    	menu:0
    }
});
