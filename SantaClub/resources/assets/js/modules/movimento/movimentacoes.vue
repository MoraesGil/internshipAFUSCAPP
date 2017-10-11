<template lang="html">
  <div >
    <div class="row">
      <!-- advanced tools -->
      <div class="col-md-11 col-md-offset-1 pl0">
        <div class="x_panel row text-center">
          <a href="#" class="custom-btn pull-left" @click.prevent>
            Lançamento
            <span class="fa-stack fa-lg">
              <i class="fa fa-circle fa-stack-2x"></i>
              <i class="fa fa-plus fa-stack-1x fa-inverse"></i>
            </span>
          </a>
          <a href="#" class="custom-btn pull-left" @click.prevent>
            Relatório
            <span class="fa-stack fa-lg">
              <i class="fa fa-circle fa-stack-2x"></i>
              <i class="fa fa-print fa-stack-1x fa-inverse"></i>
            </span>
          </a>

          <div class="datepick pt8 custom-btn">
            <i class="fa fa-chevron-left  fa-fw "></i>
            <span>Este Mês</span>
            <i class="fa fa-chevron-right fa-fw "></i>
          </div>

          <a href="#" class="custom-btn pt8 pull-right" @click.prevent>
            Conta Itaú
          </a>

        </div>
      </div>

      <!-- searchTools -->
      <div class="col-md-11 col-md-offset-1 pl0">
        <div class="x_panel" style="margin-bottom:0; padding-bottom: 18px;">
          <div class="container">
            <form class="form-inline" style="padding-top: 10px;">
              <div class="form-group pull-left" style="padding-top: 10px;">
                <popover title="Filtro avançado" placement="bottom" trigger="click" v-model="popoverFilters" @show="bindThird" >
                  <a href="#" class="custom-btn" @click.prevent data-role="trigger">
                    <i class="fa fa-filter" aria-hidden="true"></i>
                    Criar um filtro
                  </a>
                  <div slot="popover">
                    <select class="selectpicker" v-model="filterType">
                      <option value="1">Todos os Lançamentos</option>
                      <option value="2">Receitas</option>
                      <option value="3">Receitas recebidas</option>
                      <option value="4">Receitas não recebidas</option>
                      <option value="5">Despesas</option>
                      <option value="6">Despesas recebidas</option>
                      <option value="7">Despesas não recebidas</option>
                      <option value="8">Transferências</option>
                      <option value="9">Lançamentos fixos</option>
                      <option value="10">Lançamentos parcelados</option>
                    </select>
                    <br><br>
                    <select class="selectpicker" multiple title="Filte por categorias" v-model="filterCategory">
                      <option v-for="category in categories">{{category}}</option>
                    </select>
                    <br><br>
                    <button type="button" class="btn btn-default btn-block" @click="applyFilters" trigger="click">
                      Aplicar filtro
                    </button>
                  </div>
                </popover>
              </div>

              <button type="button" class="btn btn-default pull-right" v-on:click="clickSearchButton($event)">
                <input type="checkbox" checked data-toggle="tooltip" title="Filtrar automaticamente" v-model="autoSearch" class="pull-left"  style="margin:4px 10px 0"/>
                <i class="fa fa-search"></i> Buscar
              </button>
              <div class="form-group pull-right col-md-5">
                <input type="text" class="form-control" v-model="searchTerm" placeholder="Buscar por ..." style="width:100%">
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <div id="scrollable" >
          <div class="row line" v-for="(mov,index) in pagination.data">
            <div class="col-md-1 float_data text-center">
              <strong  v-if="index == 0 || (mov.dt_vencimento != (pagination.data[index-1] !=null ? pagination.data[index-1].dt_vencimento : ''))">
                {{tinyDate(mov.dt_vencimento)}}
              </strong>
            </div>
            <div class="col-md-11 mytable-wrap" >
              <div class="row mytable">
                <div class="col-md-6 start">
                  <i :class="['pull-left fa fa-circle fa-fw status',(mov.tipo_entrada == 0 ? 'red' : 'green' )]"></i>
                  <div class="elipse_over_flow">
                    {{mov.descricao}}
                    <small v-if="miniMode">
                      {{mov.dt_vencimento}}
                    </small>
                  </div>
                </div>
                <div class="col-md-3">
                  <i class="fa fa-bookmark" :style="{color:mov.categoria_cor}"></i> {{mov.categoria_label}}
                </div>
                <div class="col-md-2">
                  {{mov.valor}}
                </div>
                <div class="col-md-1 end">
                  <i class="fa fa-thumbs-o-up fa-fw  "></i>
                  <i class="fa fa-chevron-down fa-fw "></i>
                </div>
              </div>
            </div>
          </div>
          <infinite-loading @infinite="infiniteHandler($event,'#scrollable')">
            <span slot="no-more">
              There is no more Hacker News :(
            </span>
          </infinite-loading>

        </div>
      </div>

      <!-- resume board -->
      <div class="col-md-11 col-md-offset-1 pl0">
        <div class="x_panel row" style="margin-top: 15px; padding: 0; border: none">
          <div class="col-md-2 resumed-td">
            <small>saldo</small>
            <span>R$200</span>
          </div>
          <div class="col-md-2 resumed-td">
            <small>saldo</small>
            <span>R$200</span>
          </div>
          <div class="col-md-2 resumed-td">
            <small>saldo</small>
            <span>R$200</span>
          </div>
          <div class="col-md-2 resumed-td">
            <small>saldo</small>
            <span>R$200</span>
          </div>
          <div class="col-md-2 resumed-td">
            <small>saldo</small>
            <span>R$200</span>
          </div>
          <div class="col-md-2 resumed-td">
            <small>saldo</small>
            <span>R$200</span>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
import DataViewer      from '../DataViewer/gridView.vue'
import InfiniteLoading from 'vue-infinite-loading';
import moment          from 'moment'
import { Popover }     from 'uiv'

export default {
  extends: DataViewer,
  components: {
    InfiniteLoading, Popover
  },
  props: {
    subtitle: {
      type: String,
      default: 'subtitle'
    },
    filterable: {
      type: Boolean,
      default: true
    },
    categorySource: {
      type: String,
      default: ''
    },
    miniMode: {
      type: Boolean,
      default: false
    },
  },
  mounted() {
    var self = this
    $('#scrollable').slimScroll();

    $(function() {
      self.resizeList();
      $( window ).resize(function() {
        self.resizeList();
      });
    });
  },
  data() {
    return {
      init : {
        popoverFilters : false
      },
      categories : [],
      popoverFilters:false,
      filterType:''
    }
  },
  computed: {

  },
  watch: {

  },
  methods: {
    fetchCategories(){
      axios.get(this.categoriesSource).then((res_s)=>{
        let dados = res_s.data.data;


      },(res_e)=>{
        self.showAlertError(res_e);
      });
    },
    applyFilters(){
      console.log('clicou fechar');
      this.popoverFilters = false
    },
    bindThird(){
      // init selectpicker
      if (!this.init.popoverFilters) {
        this.popoverFilters = true
        $('.selectpicker').selectpicker({
          size: 10
        });
      }
    },
    tinyDate(value){
      return value.substring(0, 5)
    },
    resizeList(){
      var newHeight =  $(window).height() * 0.6
      if (newHeight >= 400) {
        $('#scrollable').parent().height(newHeight)
        $('#scrollable').height(newHeight)
      }
    }
  }
}
</script>

<style lang="css">

.pl0{
  padding-left: 0px;
}

#scrollable{
  height: 400px;
  overflow-y: scroll;
  padding-right: 10px;
}
.elipse_over_flow {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.mytable-wrap{
  border-bottom: 1px solid #E6E9ED;
  padding-left: 11px;
}
.mytable > div{
  padding: 8px;
  border-bottom: 1px solid #E6E9ED;
}

.mytable > div.start{
  border-left: 1px solid #E6E9ED;
  padding-left: 1px
}
.mytable > div.end{
  border-right: 1px solid #E6E9ED;
}

.float_data{
  font-size: 17px;
}

.line div.mytable {
  background: #fff;
}

.line:hover div.mytable {
  background-color: #f5f5f5;
}
i.status{
  margin-top: 3px;
  margin-left: 5px;
  margin-right: 5px;
}

.x_panel{
  margin-left: 0px !important;
}

.datepick{
  position: absolute;
  left: 45%;
}
.pt8{
  padding-top: 8px;
}

.custom-btn{
  font-size: 14px;
  display: inline-block;
  margin: 0 4px 0px 4px;
}
.resumed-td{
  border: 1px solid #E6E9ED;
  height: 50px;
}

.resumed-td div.x_panel{
  padding: 0;
  border: none;
}

</style>
