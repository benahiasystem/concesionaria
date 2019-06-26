

//require('./bootstrap');

window.Vue = require('vue');
import Vue from 'vue'
import Vuetify from 'vuetify'
import Snotify from 'vue-snotify';

Vue.use(Snotify);

Vue.use(Vuetify, {
    iconfont: 'fa',
    icons: {
        'register'  : 'fas fa-id-card-alt   fa-lg ',
        'user'      : 'fas fa-user-cog      fa-lg',
        'search'    : 'fas fa-search        fa-lg', 
        'logout'    : 'fas fa-sign-in-alt   fa-lg',
        'edit'      : 'fas fa-pen-alt       fa-lg     text-xs-center mt-3',
        'trash'     : 'fas fa-trash-alt     fa-lg     text-xs-center mt-3',
        'car'       : 'fas fa-car-alt       fa-lg     text-xs-center mt-3',
        'usersPlus' : 'fas fa-user-plus     fa-2x',
        'usersEdit' : 'fas fa-user-edit     fa-2x',
        'tools'     : 'fas fa-tools         fa-1.02x   text-xs-center mt-3',
        'userAlt'   : 'fas fa-user-alt      fa-1.02x   text-xs-center mt-3',
        'filePdf'   : 'fas fa-file-pdf      fa-1.02x   text-xs-center mt-3',
        'save'      : 'fas fa-save          fa-lg',
        'cancel'    : 'fas fa-times         fa-lg',
        'pdf'       : 'fas fa-file-pdf      fa-lg',

        'radiation' : 'fas fa-exclamation-triangle fa-lg',
        
               
        
      },
      theme:{
        primary:        '#1d2640',
        toolbarsText:   '#c5d7da', // cambiar por primaryText
        secondary:      '#be305e',
        cancel:         '#ec8359',
        accent:         '#82B1FF',
        error:          '#FF5252',
        info:           '#2196F3',
        success:        '#4CAF50',
        warning:        '#FFC107',
        footer:         '#6e929a',
        naranja:           '#e87524',
        blue:           '#c9e1eb' 
      }
})
  

Vue.component('cliente-component', require('./components/clientes/clienteComponent.vue').default);
Vue.component('concesionario-component', require('./components/concesionarios/concesionarioComponent.vue').default);
Vue.component('toolbar1-component', require('./components/toolbars/toolbar1Component.vue').default);
Vue.component('toolbar2-component', require('./components/toolbars/toolbar2Component.vue').default);
Vue.component('navigation1-component', require('./components/drawer/navigation1Component.vue').default);
Vue.component('navigation2-component', require('./components/drawer/navigation2Component.vue').default);
Vue.component('footer-component', require('./components/footerComponent.vue').default);
Vue.component('reporte-cliente-component', require('./components/reportes/reporteClienteComponent.vue').default);


const app = new Vue({
    el: '#app'
});
     