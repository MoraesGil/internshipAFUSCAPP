<template lang="html">
  <div class="movContainer">
    <div class="row">
      <!-- advanced tools -->
      <div class="col-xs-12 col-sm-12 col-md-11 col-md-offset-1 pl0" v-if="!miniMode">
        <div class="x_panel row text-center" style="line-height: 30px;">
          <div class="col-xs-3 col-sm-4 col-md-4 nopadding">
            <a href="#" class="custom-btn pull-left" @click.prevent>
              <span class="hidden-xs">Lançamento</span>
              <span class="fa-stack fa-lg">
                <i class="fa fa-circle fa-stack-2x"></i>
                <i class="fa fa-plus fa-stack-1x fa-inverse"></i>
              </span>
            </a>
            <a href="#" class="custom-btn pull-left hidden-xs" @click.prevent>
              <span>Relatório</span>
              <span class="fa-stack fa-lg">
                <i class="fa fa-circle fa-stack-2x"></i>
                <i class="fa fa-print fa-stack-1x fa-inverse"></i>
              </span>
            </a>
          </div>
          <div class="col-xs-offset-1 col-xs-5 col-sm-offset-0 col-sm-4 col-md-offset-0 col-md-4 nopadding">
            <div class="range-picker  custom-btn">
              <div class="range-picker-prev pull-left">
                <i class="fa fa-chevron-left fa-fw"></i>
              </div>
              <div class="daterange">
                <div id="daterange-single" class="hidden" >
                  Dezembro
                </div>

                <div id="daterange-range">
                  <span>30 Set</span>
                  <span>2017</span>
                  a
                  <span>30 Set</span>
                  <span>2017</span>
                </div>

              </div>
              <div class="range-picker-next pull-right">
                <i class="fa fa-chevron-right fa-fw"></i>
              </div>
            </div>
          </div>
          <div class="col-xs-3 col-sm-4 col-md-4 nopadding">
            <a href="#" class="custom-btn pull-right" @click.prevent>
              Conta Itaú
            </a>
          </div>
        </div>
      </div>

      <!-- searchTools -->
      <div class="col-xs-12 col-sm-12 col-md-11 col-md-offset-1 pl0" v-if="!miniMode">
        <div class="x_panel" style="margin-bottom:0; padding-bottom: 18px;">
          <div class="container">
            <form class="form-inline" style="padding-top: 10px;">
              <div class="form-group pull-left" style="padding-top: 10px;" >
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
                    <select class="selectpicker" multiple title="Filte por categorias">
                      <option v-for="category in categories">{{category}}</option>
                    </select>
                    <br><br>
                    <button type="button" class="btn btn-xs btn-default btn-block" @click="applyFilters" trigger="click">
                      Aplicar filtro
                    </button>
                  </div>
                </popover>
              </div>

              <button type="button" class="btn btn-default pull-right hidden-xs" v-on:click="clickSearchButton($event)">
                <input type="checkbox" checked data-toggle="tooltip" title="Filtrar automaticamente" v-model="autoSearch" class="pull-left"  style="margin:4px 10px 0"/>
                <i class="fa fa-search"></i> Buscar
              </button>
              <div class="form-group pull-right col-xs-5 col-md-5">
                <input type="text" class="form-control" v-model="searchTerm" placeholder="Buscar por ..." style="width:100%">
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- table -->
      <div class="col-xs-12 col-sm-12 col-md-12">
        <div :id="scrollableId" :class="(!miniMode ? 'scrollable-box': '')">
          <div class="row line" v-for="(mov,index) in pagination.data">
            <div class="col-md-1 float_data text-center hidden-xs hidden-sm" v-if="!miniMode">
              <strong  v-if="index == 0 || (mov.dt_vencimento != (pagination.data[index-1] !=null ? pagination.data[index-1].dt_vencimento : ''))">
                {{tinyDate(mov.dt_vencimento)}}
              </strong>
            </div>
            <div :class="['mytable-wrap',tableSize]" >
              <div class="row mytable" :style="(miniMode ? 'line-height: 12px;' : '')">
                <div :class="['col-xs-5 col-sm-6 col-md-5',(!miniMode ? 'start': '')]">
                  <i :class="['pull-left fa fa-circle fa-fw status',(mov.tipo_entrada == 0 ? 'red' : 'green' )]"></i>
                  <div class="elipse_over_flow">
                    {{mov.descricao}}
                    <small :class="(!miniMode ? 'visible-xs visible-sm' : '')">
                      {{mov.dt_vencimento}}
                    </small>
                  </div>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-4" v-if="!miniMode">
                  <span v-html="mov.categoria_label">
                </span>
                </div>
                <div :class="valueColumnSize">
                  {{mov.valor}}
                </div>
                <div :class="[optionsColumnSize,(!miniMode ? 'end': '')]">
                  <a href="#"><i class="fa fa-thumbs-o-up fa-fw  "></i></a>
                  <a href="#"><i class="fa fa-chevron-down fa-fw "></i></a>
                </div>
              </div>
            </div>
          </div>
          <infinite-loading @infinite="infiniteHandler($event,scrollableId)" v-if="!miniMode">
            <span slot="no-more">
              Não tem mais movimentações :(
            </span>
          </infinite-loading>
        </div>
      </div>

      <!-- resume board -->
      <div class="col-xs-12 col-sm-12 col-md-11 col-md-offset-1 pl0" v-if="!miniMode">
        <div class="x_panel row" style="margin-top: 15px; padding: 0; border: none">
          <div class="col-xs-3 col-sm-2 col-md-2 resumed-td">
            <small>saldo</small>
            <span>R$200</span>
          </div>
          <div class="col-xs-3 col-sm-2 col-md-2 resumed-td">
            <small>saldo</small>
            <span>R$200</span>
          </div>
          <div class="col-xs-3 col-sm-2 col-md-2 resumed-td">
            <small>saldo</small>
            <span>R$200</span>
          </div>
          <div class="col-xs-3 col-sm-2 col-md-2 resumed-td">
            <small>saldo</small>
            <span>R$200</span>
          </div>
          <div class="col-xs-3 col-sm-2 col-md-2 resumed-td">
            <small>saldo</small>
            <span>R$200</span>
          </div>
          <div class="col-xs-9 col-sm-2 col-md-2 resumed-td">
            <small>saldo</small>
            <span>R$200</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import InfinityViewer      from '../DataViewer/infinityViewer.vue'  
import { Popover }     from 'uiv'

/**
 * Componente movimentaçoes desenvolvido por Gilberto Prudêncio Vaz de Moraes
 * @type {Vue Component}
 */
export default {
  extends: InfinityViewer,
  components: {
    Popover
  },
  props: {
    heightPercent: {
      type: Number,
      default: 100
    },
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
    if (!this.miniMode) {
      $('#'+this.scrollableId).slimScroll();
      self.resizeList();
      $( window ).resize(function() {
        self.resizeList();
      });
    }
    // $('#scrollable1').slimScroll({scrollTo:$('#scrollable1').scrollTop()+1+"px"})
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
    scrollableId(){
      return 'scrollable'+this._uid
    },
    tableSize(){
      return this.miniMode ? 'col-xs-12 col-sm-12 col-md-12' : 'col-xs-12 col-sm-12 col-md-11'
    },
    valueColumnSize(){
      return this.miniMode ? 'col-xs-4 col-sm-4 col-md-4' : 'col-xs-3 col-sm-2 col-md-2'
    },
    optionsColumnSize(){
      return this.miniMode ? 'col-xs-2 col-sm-2 col-md-3' : 'col-xs-1 col-sm-1 col-md-1'
    },
  },
  watch: {

  },
  methods: {
    fetchCategories(){
      axios.get(this.categoriesSource).then((res_s)=>{
        let dados = res_s.data.data;
      },(res_e)=>{
        self.showResponseError(res_e);
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
      var newHeight =  $(window).height() * 0.6 * this.heightPercent/100
      if (newHeight >= 200) {
        $('#'+this.scrollableId).parent().height(newHeight)
        $('#'+this.scrollableId).height(newHeight)
      }
    }
  }
}
</script>

<style lang="css">
.movContainer{
  padding: 10px
}

.scrollable-box{
  height: 200px;
  overflow-y: scroll;
  padding-right: 10px;
}

/*selector of main scrolldiv id*/
.slimScrollDiv > :first-child{
  padding-right: 10px;
}

@media(min-width:992px){
  .pl0{
    padding-left: 0px;
  }
}

/*small devices*/
@media(max-width:991px){
  .slimScrollDiv > :first-child{
    padding-left: 9px;
    padding-right: 10px;
  }
  .custom-btn{
    font-size: 11px;
  }
}

.elipse_over_flow {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.elipse_over_flow > small {
  display: block;
  font-size: 11px;
  color: #999999;
}

.mytable-wrap{
  /*border-bottom: 1px solid #E6E9ED;*/
  padding-left: 11px;
}
.mytable > div{
  padding: 8px;
}

.mytable > div.start{
  border-left: 1px solid #E6E9ED;
  padding-left: 1px
}
.mytable > div.end{
  border-right: 1px solid #E6E9ED;
  padding: 8px 2px 8px 0;
}

.float_data{
  font-size: 17px;
}

.line div.mytable {
  background: #fff;
  border-bottom: 1px solid #E6E9ED;
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

.custom-btn{
  font-size: 1em;
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

.nopadding{
  padding: 0;
}

.daterange{
  line-height: 13px;
  display: inline-block;
}
</style>
