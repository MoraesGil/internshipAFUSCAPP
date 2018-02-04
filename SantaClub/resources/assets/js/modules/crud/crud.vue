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
      <form v-if="form_modal" :is="formName"  :target-url="resourceUrl" :entity-src="entity"></form>
      <div slot="footer">
        <button type="button" class="btn btn-default" @click="form_modal = false">Cancel</button>
        <button type="button" class="btn btn-success" @click="sendForm">Gravar</button>
      </div>
    </modal>

  </div>
</template>

<script>
import baseCrud from './baseCrud.vue'

//Avaliable forms
import FormCategoria from '../../forms/form_categoria.vue'
import FormConta     from '../../forms/form_conta.vue'
 

export default {
  extends: baseCrud,
  data() {
    return {

    }
  },
  components:{
    // ## note the form name must be resource route name less dots ex: catcategorias to form Categoria
    'catcategorias':    FormCategoria,
    'concontas':        FormConta,
    'usuariosapiusers': FormUsuarios,
    'usuariosapiroles': FormGrupos
  },
  props: {

  },
  mounted() {

  },
  destroyed: function() {

  },
  computed: {

  },
  watch: {

  },
  methods: {

  }
}

</script>
