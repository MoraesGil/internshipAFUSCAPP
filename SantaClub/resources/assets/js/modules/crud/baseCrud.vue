<!-- * @author Gilberto Prudêncio Vaz de Moraes <moraesdev@gmail.com> -->
<script>
import DataViewer    from '../dataviewer/gridViewer.vue'

export default {
  mixins: [mixinHub,mixinResponse],
  data() {
    return {
      modalSize:'md',
      form_modal : false,
      entity : {},
    }
  },
  components:{
    DataViewer,
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
    this.eventHub.$on('savedChanges',this.savedChanges)

    // this.eventHub.$on('refreshgridViewer', this.fetchItems);
  },
  destroyed: function() {

  },
  computed: {
    formName(){
      return this.resourceName!= '' ? this.resourceName.split('.').join("") : '' ;
    }
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
    sendForm(){
      this.eventHub.$emit('triggerForm');
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
  }
}
</script>
