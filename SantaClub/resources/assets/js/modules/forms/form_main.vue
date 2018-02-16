<script>
/**
* @author Gilberto Prudêncio Vaz de Moraes <moraesdev@gmail.com>
* @type {Object}
*/
export default {
  mixins: [mixinHub,mixinResponse],
  components: {

  },
  props: {
    targetUrl: {
      type: String,
      default: ''
    },
    entitySrc: {
      type: Object,
      default: null
    },
  },
  created : function() {
    this.dataForm  = this.mergeEntity(this.dataForm, this.entitySrc)
    this.eventHub.$on('triggerForm',this.sendForm);
  },
  mounted() {

  },
  destroyed: function() {
    this.eventHub.$off('triggerForm');
  },
  data() {
    return {
      dataForm:{},
    }
  },
  computed: {
    formId(){
      return 'gm_crud_form_'+this._uid
    },
    isEditing(){
      return this.entitySrc != null
    }
  },
  watch: {

  },
  methods: {
    mergeEntity(obj1, obj2) { 
      for( var p in obj2 )
      if( obj1.hasOwnProperty(p) )
      obj1[p] = typeof obj2[p] === 'object' ? merge(obj1[p], obj2[p]) : obj2[p];
      return obj1;
    },
    sendForm:_.debounce(
      function () {
        toastr.clear();
        self = this
        try {
          if (this.entitySrc == null) {
            axios.post(this.targetUrl, this.dataForm)
            .then((res) => {
              this.eventHub.$emit('savedChanges')
              toastr.success('Cadastrado com sucesso')
            })
            .catch((e) => {
              self.showResponseError(e.response)
            })
          }else {
            axios.put(this.targetUrl+'/'+this.entitySrc.primary, this.dataForm)
            .then(res => {
              this.eventHub.$emit('savedChanges')
              toastr.success('Atualizado com sucesso')
            })
            .catch((e) => {
              self.showResponseError(e.response)
            })
          }
        } catch (ex) {
          console.log(ex);
        }
      },
      200
    ),
  }
}
</script>
