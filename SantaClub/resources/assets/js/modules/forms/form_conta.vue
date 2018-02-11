<template lang="html">
  <form :id="formId">
    <label for="con_name">Titulo</label>
    <input type="text" id="con_name" class="form-control"  placeholder="ex: caixa, itáu  ..." data-action="auto-focus" v-model="dataForm.label"/>
    <br>
    <label for="descricao">Descricão</label>
    <textarea id="descricao" placeholder="..." class="form-control" v-model="dataForm.descricao" style="resize: none;"></textarea>
  </form>
</template>

<script>
import MainForm from './form_main.vue'

export default {
  extends: MainForm,
  components:{

  },
  data(){
    return {
      dataForm:{
        label:'',
        descricao:''
      },
    }
  },
  mounted(){

  },
  methods:{
  }
}
</script>

<style lang="css">
</style>
