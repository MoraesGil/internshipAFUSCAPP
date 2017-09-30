import Vue from 'vue'
Vue.mixin({
  mounted: function () {

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
          if (response.status == 500) {
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
        console.log(err);
      }
    }
    ,showTeste(){
      alert('sou um mixin')
    }
  }
})
