<template lang="html">
  <div >
    <!-- <div class="" v-if="dataSource != ''"> -->
    <table  class="table-hover main-table">
      <thead>
        <tr>
          <th class="fit"></th>
          <th class=""> Descrição </th>
          <th class="" v-if="!miniMode"> Categoria </th>
          <th class=""> Valor </th>
          <th class="fit text-center"> Opções </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(mov,index) in pagination.data">
          <td class="fit">
            <i :class="['fa fa-circle fa-fw',(mov.tipo_entrada == 0 ? 'red' : 'green' )]"></i>
          </td>
          <td class="descricao text-left">
            <table class="fixed-table">
              <tr>
                <td>
                  <a href="#">
                    Folha de pagamento da santa casa Mar/2017
                    <template v-if="!miniMode">
                      <strong class="float_data" v-if="index == 0 || (mov.dt_vencimento != (pagination.data[index-1] !=null ? pagination.data[index-1].dt_vencimento : ''))">
                        {{mov.dt_vencimento}}
                      </strong>
                    </template>
                    <small v-else>
                      {{mov.dt_vencimento}}
                    </small>
                  </a>
                </td>
              </tr>
            </table>
          </td>
          <td class="categoria text-left" v-if="!miniMode">
            <table class="fixed-table">
              <tr>
                <td>
                  <i class="fa fa-bookmark" :style="{color:mov.categoria_cor}"></i> {{mov.categoria_label}}
                </td>
              </tr>
            </table>
          </td>
          <td class="valor">
            {{mov.valor}}
          </td>
          <td class="fit text-center mov_options">
            <i class="fa fa-thumbs-o-up fa-fw  "></i>
            <i class="fa fa-chevron-down fa-fw "></i>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- </div> -->
  </div>
</template>

<script>
import DataViewer      from '../DataViewer/gridView.vue'

export default {
  extends: DataViewer,

  props: {
    subtitle: {
      type: String,
      default: 'subtitle'
    },
    filterable: {
      type: Boolean,
      default: true
    },
    searchable: {
      type: Boolean,
      default: true
    },
    miniMode: {
      type: Boolean,
      default: false
    },
  },
  mounted() {
  },
  data() {
    return {

    }
  },
  computed: {
    titleComputed(){
      return this.source == '' ? "DataSource não informado" : this.title;
    },

  },
  watch: {

  },
  methods: {

  }

}
</script>

<style lang="css">
.fixed-table {
  /* magic */
  width: 100%;
  table-layout: fixed;

  /*not really necessary, removes extra white space */
  border-collapse: collapse;
  border-spacing: 0;
  border: 0;
}
.fixed-table td {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.nowrap {
  /* used to keep buttons' text in a single line,
  * remove this class to allow natural line-breaking.
  */
  white-space: nowrap;
}

table.main-table > tbody > tr  {
  border-bottom: 1px solid #F1F2F5;
}

/**
*  ######### Configuração das colunas
*/
table > tbody > tr > td.descricao {
  padding: 11px 2px 9px;
  font-weight: 600;
  /*background: purple;*/
  width: 55%;
}
table > tbody > tr > td.categoria {
  /*background: pink;*/
  width: 20%;
}
table > tbody > tr > td.valor {
  white-space: nowrap;
  width: 15%;
  padding:0  2px;
  /*background: yellow;*/
}
table > tbody > tr > td.fit {
  width: 1%;
  /*background: blue;*/
}

/**
*  ######### ajuste overflow descricao
*/
table > tbody > tr > td.descricao small {
  display: block;
  font-size: 11px;
  color: #999999;
}
table > tbody > tr > td.descricao > div{
  overflow: hidden;
  text-overflow: ellipsis;
}
.mov_options{
  width: 9% !important;
}
.float_data{
  /*background: green;*/
  position: absolute;
  left: -75px;
}
</style>
