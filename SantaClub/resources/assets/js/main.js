window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * GM - My mixin loads commun data to all my components
 * @type {[VueMixin]}
 */
const eventHub = new Vue() // Single event hub
Vue.mixin({
  mounted: function () {
    // console.log('mixin loaded de boas'+this._uid);
  },
  data: function () {
    return {
      eventHub: eventHub
    }
  },
  methods: {
    showAlertError: function (err) {
      var error = err.response.data;
      var errors = '';
      if (error.errors) {
        if (Array.isArray(error.errors) || typeof error.errors  !== 'string')
        $.each(error.errors,(i,val)=>{
          errors += Object.keys(error.errors)[0] != i ?  " - "+val : val;
        })
        if (err.status == 500) {
          console.log('erro cod: '+errors);
          errors = 'Se possivel não feche a tela para identificarmos e corrigir o erro.'
        }
      }
      if (error.message) {
        swal({
          title: error.message,
          type: 'error',
          text: errors,
          allowOutsideClick: false,
          confirmButtonText: 'Fechar',
        })
      } else {
        swal({
          title: 'Erro',
          type: 'error',
          text: err,
          allowOutsideClick: false,
          confirmButtonText: 'Fechar',
        })
        console.log(err);
      }
    },
    showTeste(){
      console.log('teste mixin')
    }
  }
})
