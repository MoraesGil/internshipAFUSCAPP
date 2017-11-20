<!-- * @author Gilberto Prudêncio Vaz de Moraes <moraesdev@gmail.com> -->
<template>
  <div class="x_panel">
    <div class="x_title">
      <h2> {{title}}</h2>
      <div class="pull-right">
       <template v-for="btn in topButtons">
        <button is="dbutton" :type="btn" ></button>
      </template>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <data-viewer  :source="resourceUrl" :buttons="rowButtons"/>
    </div>

    <!-- hidden modal -->
    <modal v-model="form_modal" title="Cadastro" @hide="form_modal = false" :size="modalSize" :auto-focus="true">
      <form v-if="form_modal" :is="resourceName"  :target-url="resourceUrl" :entity-src="entity"></form>
      <div slot="footer">
        <button type="button" class="btn btn-default" @click="form_modal = false">Cancel</button>
        <button type="button" class="btn btn-success" @click="saveChanges">Gravar</button>
      </div>
    </modal>

  </div>
</template>

<script>
import DataViewer    from '../dataviewer/gridViewer.vue'
import FormCategoria from '../../forms/form_categoria.vue'
import FormConta     from '../../forms/form_conta.vue'

export default {
  data() {
    return {
      modalSize:'md',
      form_modal : false,
      entity : {},
    }
  },
  components:{
    DataViewer,
    // ## note the form name must be resource route name ex: cat.categorias to form Categoria
    'cat.categorias': FormCategoria,
    'con.contas':     FormConta
  },
  props: {
    resourceName: {
      type: String,
      default: ''
    },
    title: {
      type: String,
      default: 'Title'
    },
    topButtons: {
      type: Array,
      default: function() {
        return []
      }
    },
    rowButtons: {
      type: Array,
      default: function() {
        return []
      }
    }, 
    resourceUrl:{
      type: String,
      default: ''
    },
  },
  mounted() {
    this.eventHub.$on('add',this.create)
    this.eventHub.$on('edit',this.edit)
    this.eventHub.$on('delete',this.destroy)
    // this.loadButtons();
    // this.eventHub.$on('refreshgridViewer', this.fetchItems);
  },
  destroyed: function() {

  },
  computed: {

  },
  watch: {

  },
  methods: {
    create(){
      this.entity     = null;
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
      this.form_modal = false;
      this.eventHub.$emit('refreshgridViewer');
      this.eventHub.$emit('saveChanges');
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
}

</script>
<style media="screen">

</style>
