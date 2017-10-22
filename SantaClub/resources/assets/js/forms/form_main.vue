
<script>
export default {
  components: {

  },
  props: {

  },
  mounted() {

  },
  data() {
    return {
      dataForm:{},
      errors: []
    }
  },
  computed: {
    hasErrors () {
      return this.errors.errors.length > 0
    },
    formId(){
      return 'gm_crud_form_'+this._uid
    },
  },
  watch: {

  },
  methods: {
    sendForm(){
      if (condition) {
        axios.post(this.resourceURL, dataForm)
        .then(response => {

        })
        .catch(e => {
          this.errors.push(e)
        })
      }else {
        axios.put(this.resourceURL, dataForm)
        .then(response => {

        })
        .catch(e => {
          this.errors.push(e)
        })
      }
    }
  }
}
</script>
