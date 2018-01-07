<template lang="html"> 
    <div> 
        <div class="row">
        <div class="col-md-9 col-xs-9 col-sm-9">
          <label for="form_logradouro">Logradouro/Nº </label>
          <input type="text" id="form_logradouro" class="form-control" placeholder="" v-model="dataForm.logradouro" />
        </div>
        <div class="col-md-3 col-xs-3 col-sm-3">
          <label for="form_cep">CEP</label>
          <input type="text" id="form_cep" class="form-control" placeholder="" v-model="dataForm.cep" />
        </div> 
      </div>
      <div class="row">
        <div class="col-md-6 col-xs-6 col-sm-6">
          <label for="form_bairro">Bairro</label>
          <input type="text" id="form_bairro" class="form-control" placeholder="" v-model="dataForm.bairro" />
        </div>
        <div class="col-md-6 col-xs-6 col-sm-6">
          <label for="form_complemento">Complemento</label>
          <input type="text" id="form_complemento" class="form-control" placeholder="" v-model="dataForm.complemento" />
        </div> 
      </div>
    </div>
   
</template>

<script>
import MainForm from "./form_main.vue";

export default {
  extends: MainForm,
  components: {},
  data() {
    return {
      dataForm: {
        logradouro: "",
        cep: "",
        bairro: "",
        complemento: ""
      }
    };
  },
  mounted() {},
  methods: {}
};
</script>

<style lang="css">

</style>
