// @author Gilberto Prudêncio Vaz de Moraes <moraesdev@gmail.com>
require('../main.js')
import DataViewer    from '../modules/dataviewer/gridViewer.vue'
import { Modal }     from 'uiv'


import FormCategoria from '../forms/form_categoria.vue'
import FormConta     from '../forms/form_conta.vue'

new Vue({
  el:'#app',
  components:{
    Modal,
    DataViewer,
    // ## note the form name must be resource route name ex: cat.categorias to form Categoria
    'cat.categorias': FormCategoria,
    'con.contas':     FormConta
  },
  data(){
    return {
      modalSize:'md',
      resourceUrl: '',
      form_modal : false,
      entity : {},
    }
  },
  mounted(){
    this.resourceUrl = $("#resourceUrl").val();
    this.eventHub.$on('savedChanges',this.savedChanges);
  },
  destroyed: function() {
    this.eventHub.$off('savedChanges');
  },
  methods:{
    create(){
      this.entity = null;
      this.form_modal = true;
    },
    edit(par){
      if (par.primary != null) {
        this.entity = par;
        this.form_modal = true;
      }else {
        console.log('Unknow PrimaryKey Field');
      }
    },

    saveChanges(){
      this.eventHub.$emit('saveChanges');
    },

    savedChanges(){
      this.form_modal = false;
      this.eventHub.$emit('refreshgridViewer');
    },

    destroy(par) {

      var delete_url = this.resourceUrl+'/'+par.primary;

      let self = this;

      swal({
        cancelButtonColor:   '#d33',
        cancelButtonText:    'Cancelar',
        confirmButtonText:   'Sim',
        showCancelButton:    true,
        showLoaderOnConfirm: true,
        html:                "Confirma exclusão do item: <strong>"+par.title+"</strong> ?",
        title:               'Atenção',
        type:                'warning',
      }).then(function () {
        axios.delete(delete_url).then((res) => {
          self.eventHub.$emit('refreshgridViewer');
          toastr.success(par.title+' foi excluído com sucesso.');
        },(res) => {
          console.log(res);
          self.showResponseError(res)
        });
      }) //end swal
    },

    show(){
    },


    report(){

    },

    download(){

    }
  }
})
