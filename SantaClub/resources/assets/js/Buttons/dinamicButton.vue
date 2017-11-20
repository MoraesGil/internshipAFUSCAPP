<template lang="html">
  <a :class="'btn '+styleClass+''" @click.prevent="click()" >
    <i :class="icon"></i> {{computedLabel}}
  </a>
</template>

<script>
const AVAILABLE_BUTTONS = {
  add : {
    label : 'Novo',
    icon : 'fa fa-plus',
  },
  print : {
    label : 'Relatório',
    icon : 'fa fa-print',
  },
  delete : {
    label : 'Excluir',
    icon : 'fa fa-trash',
  },
  detail : {
    label : 'Detalhes',
    icon : 'fa fa-eye',
  },
  download : {
    label : 'Baixar',
    icon : 'fa fa-download',
  },
  edit : {
    label : 'Alterar',
    icon : 'fa fa-edit',
  },
};

export default {
  components: {

  },
  props: {
    mini: {
      type: Boolean,
      default: false
    },
    type: {
      type: String,
      default: ''
    },
    styleClass: {
      type: String,
      default: 'btn-default'
    },
    parameter: {
      type: Object,
      default: null
    }
  },
  mounted() {
    var valid = Object.keys(AVAILABLE_BUTTONS).indexOf(this.type) !==-1;

    if (valid) {
       this.label = AVAILABLE_BUTTONS[this.type].label;
       this.icon  = AVAILABLE_BUTTONS[this.type].icon;
    }
  },
  data() {
    return {
      label : 'undefined',
      icon : 'fa fa-question',
    }
  },
  computed: {
    computedLabel: function() {
      return this.mini ? '' : this.label;
    },
  },
  watch: {

  },
  methods: {
    click(){
      this.eventHub.$emit(this.type,this.parameter);
    }
  }
}
</script>

<style lang="css">
</style>
