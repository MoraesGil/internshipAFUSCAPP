/**
* GM - Global Configs
*  = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
*/
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
/**
* GM - Directives injection
*  = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
*/
import VueTheMask from 'vue-the-mask'
Vue.use(VueTheMask)

import * as uiv from 'uiv'
Vue.use(uiv, {prefix: 'uiv'})

/**
* GM - Global Components
*  = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
*/

import dbutton from './Buttons/dinamicButton.vue'
Vue.component('dbutton', dbutton);

/**
* GM - Global Mixin
*  = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
*/
const eventHub = new Vue() // Single event hub
Vue.mixin({
  mounted: function () {
    // console.log('mixin loaded de boas'+this._uid);
  },
  data: function () {
    return {
      eventHub: eventHub,
    }
  },
  methods: {
    showResponseError: function (err) {
      if (err.response.status == 500) {
        var errorText = isDevMode ? '' : 'Se possivel não feche a tela para identificarmos e corrigir o erro.';
        errors = err.response.data;
        $.each(errors,(i,val)=>{
          errorText += " * "+val+"<br>";
        })

        swal({
          title: 'Erro no sistema',
          type: 'error',
          html: errorText,
          allowOutsideClick: false,
          confirmButtonText: 'Fechar',
        })
      }else {
        toastr.options = {
          "closeButton": true,
          "debug": false,
          "newestOnTop": true,
          "progressBar": true,
          "positionClass": "toast-top-right",
          "preventDuplicates": true,
          "onclick": null,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": "5000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        }
        $.each(err.response.data,(i,val)=>{
          toastr.warning(val,'Atenção')
        })
        toastr.options = {}; //clear toast options
      }
    },
    showTeste(){
      console.log('teste mixin')
    }
  }
})
