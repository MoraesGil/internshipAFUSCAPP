<template lang="html">
  <tooltip :text="label" :enable="mini">
    <a :class="'btn '+styleClass+' dbutton '" @click.prevent="click()" type="primary" v-if="visible">
      <i :class="icon+' fa-fw'"></i> {{computedLabel}}
    </a>
  </tooltip>
</template>

<script>
require('../../mixins.js')
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
  clearPassword:{
    label : 'Zerar Senha',
    icon : 'fa fa-key',
  },
  lock:{
    label : 'Bloquear',
    icon : 'fa fa-unlock-alt',
  },
  unlock:{
    label : 'Desbloquear',
    icon : 'fa fa-lock',
  },

};

export default {
  mixins: [mixinHub],
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
  created(){

  },
  mounted() {
    let type = this.type.split(":")[0]
    let rules = this.type.split(":")[1]
    self = this

    var valid = Object.keys(AVAILABLE_BUTTONS).indexOf(type) !==-1;

    if (valid) {
      this.icon  = AVAILABLE_BUTTONS[type].icon;
      this.label = AVAILABLE_BUTTONS[type].label;
    }

    if(rules){
      console.log('linha: '+self.parameter['user_nome']+' bloqueado: '+!self.parameter['user_active'])
      console.log('Button: '+AVAILABLE_BUTTONS[type].label)

      rules.split("|").forEach(function (item) {
        let rule = item.split(",")
        switch (rule[1]) {
          case 'true':  rule[1] = true; break;
          case 'false': rule[1] = false; break;
          default: break;

        }

        if(self.parameter[rule[0]] == rule[1]){
          self.visible = false
        }

      })

    }
  },
  data() {
    return {
      label:   'undefined',
      icon:    'fa fa-question',
      visible: true
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
.dbutton{
  margin: 1px;
}
</style>
