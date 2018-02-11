/**
 * My Mixins
 *  = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
 */
//mixins: [mixinHub,mixinPermission,mixinResponse]
const eventHubConst = new Vue() // Single event hub

mixinResponse = {
  mounted: function() {
    // console.log('mixinResponse loaded de boas'+this._uid);
  },
  methods: {
    showResponseError: function(e) {
      var errorText = "";

      if (e.status == 401 || e.status == 403 || e.status == 500) {
        $.each(e.data, (i, val) => {
          errorText += " * " + val + "<br>";
        });

        if (!isDevMode) {
          console.log(errorText);
        }
      }

      switch (e.status) {
        case 401:
          swal({
            title: 'Autenticação requerida.',
            type: 'info',
            html: 'Sua sessão expirou, faça login novamente',
            allowOutsideClick: false,
            allowEscapeKey:false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Fazer login'
          }).then((result) => {
            window.location.reload(); 
          })
          break;
        case 403:
          swal({
            title: 'Acesso negado',
            type: 'info',
            html: 'Parece que você não tem permissão para algum recurso, informe a TI',
            allowOutsideClick: false,
            confirmButtonText: 'Fechar',
          })
          break;

        case 500:
          swal({
            title: 'Erro no sistema',
            type: 'error',
            html: isDevMode ? errorText : 'Se possivel não feche a tela para identificarmos e corrigir o erro.',
            allowOutsideClick: false,
            confirmButtonText: 'Fechar',
          })
          break;

        default:
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
          $.each(e.data, (i, val) => {
            toastr.warning(val, 'Atenção')
          })
          toastr.options = {}; //clear toast options
          break;
      }
    },
  }
}

mixinHub = {
  mounted: function() {
    // console.log('mixinHub loaded de boas'+this._uid);
  },
  data: function() {
    return {
      eventHub: eventHubConst
    }
  },
}

mixinPermission = {
  mounted: function() {
    // console.log('mixinPermission loaded de boas'+this._uid);
  },
  data: function() {
    return {
      canInsert: false,
      canUpdate: false,
      canDelete: false
    }
  },
}
