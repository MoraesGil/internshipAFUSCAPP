<template>
  <div class="x_panel">
    <div class="x_title">
      <h2> {{title}}</h2>
      <button data-toggle="tooltip" title="Adicionar Registro" type="button" class="btn btn-default pull-right" @click="optionClick('add')"> Novo <i class="fa fa-plus fa-fw"></i></button>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <div class="row">
        <div class="col-md-10 col-sm-8 col-xs-9 form-group has-feedback">
          <input type="text" class="form-control" name="busca" v-model="searchTerm" placeholder="Buscar">
        </div>
        <div class="col-md-2 col-sm-4 col-xs-3 form-group has-feedback">
          <button type="button" name="button" class="btn btn-block btn-default" v-on:click="clickSearchButton($event)">
            <input type="checkbox" checked data-toggle="tooltip" title="Filtrar automaticamente" v-model="autoSearch" class="pull-left" />
            <i class="fa fa-search"></i> buscar
          </button>
        </div>
      </div>
      <h1 v-if="!pagination.total" class="text-center">Não há dados para ser exibidos</h1>
      <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered" v-if="pagination.total">
          <thead>
            <tr>
              <th v-for="(column,key) in pagination.columns " @click="toggleOrder(key)">
                <span>{{column}}</span>
                <span v-if="key === orderBy.column">
                  <span v-if="orderBy.direction === 'desc'"><i class="fa fa-sort-amount-desc"></i></span>
                  <span v-else><i class="fa fa-sort-amount-asc"></i></span>
                </span>
                <span v-else><i class="fa fa-sort"></i></span>
              </th>
              <template v-if="hasOptionsRow">
                <th class="fit"> opções <i class="fa fa-gear fa-fw"></i> </th>
              </template>
            </tr>
          </thead>
          <tbody>
            <tr v-for="row in pagination.data">
              <td v-for="(value,key) in row">
                {{ value }}
              </td>
              <td class="fit text-center">
                <template v-for="option in validOptionsRow">
                  <button v-if="option == 'detail'" data-toggle="tooltip" title="Detalhes" type="button" class="btn btn-default btn-xs" @click="optionClick('detail')">
                    <i class="fa fa-eye fa-fw"></i>
                  </button>
                  <button v-if="option == 'edit'" data-toggle="tooltip" title="Editar" type="button" class="btn btn-warning btn-xs" @click="optionClick('edit')">
                    <i class="fa fa-edit fa-fw"></i>
                  </button>
                  <button v-if="option == 'delete'" data-toggle="tooltip" title="Excluir" type="button" class="btn btn-danger btn-xs" @click="optionClick('delete')">
                    <i class="fa fa-trash fa-fw"></i>
                  </button>
                  <button v-if="option == 'print'" data-toggle="tooltip" title="Imprimir" type="button" class="btn btn-info btn-xs hidden-xs" @click="optionClick('print')">
                    <i class="fa fa-print fa-fw"></i>
                  </button>
                  <button v-if="option == 'download'" data-toggle="tooltip" title="Baixar" type="button" class="btn btn-default btn-xs hidden-xs" @click="optionClick('download')">
                    <i class="fa fa-download fa-fw"></i>
                  </button>
                </template>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <hr>
      <!-- BEGIN FOOTER -->
      <div class="footer pull-right">
        <nav v-if="pagination.total > 0 &&  pagination.last_page>1">
          <ul class="pagination">
            <li v-bind:class="[pagination.current_page == 1 ? 'disabled' : '']">
              <a href="#" aria-label="previous" @click.prevent="changePage(1)">
                <i class="fa fa-angle-double-left"></i>
              </a>
            </li>
            <li v-bind:class="[pagination.current_page == 1 ? 'disabled' : '']">
              <a href="#" aria-label="previous" @click.prevent="changePage(pagination.current_page - 1)">
                <i class="fa fa-angle-left"></i>
              </a>
            </li>
            <li v-for="page in pagesNumber" v-bind:class="[page == isActived ? 'active' : '']">
              <a href="#" @click.prevent="changePage(page)">{{page}}</a>
            </li>
            <li v-bind:class="[pagination.current_page ==  pagination.last_page ? 'disabled' : '']">
              <a href="#" aria-label="Next" @click.prevent="changePage(pagination.current_page + 1)">
                <i class="fa fa-angle-right"></i>
              </a>
            </li>
            <li v-bind:class="[pagination.current_page ==  pagination.last_page ? 'disabled' : '']">
              <a href="#" aria-label="Next" @click.prevent="changePage(pagination.last_page)">
                <i class="fa fa-angle-double-right"></i>
              </a>
            </li>
          </ul>
        </nav>
        <!-- END FOOTER -->
      </div>
    </div>
  </div>
 </template>

<script>
import axios from 'axios'
import _ from 'lodash'

/**
 * Componente gridView desenvolvido por Gilberto Prudêncio Vaz de Moraes
 * @type {Vue Component}
 */
export default {
  props: {
    source: {
      type: String,
      default: ''
    },
    searchable: {
      type: Boolean,
      default: true
    },
    title: {
      type: String,
      default: 'Title'
    },
    optionsrow: {
      type: Array,
      default: function() {
        return []
      }
    },
    otherFilters: {
      type: Array,
      default: function() {
        return []
      }
    }
  },
  mounted() {
    this.fetchItems();
  },
  data() {
    return {
      rowOptionsList: ['delete', 'detail', 'download', 'edit', 'print'],
      autoSearch: true,
      searchTerm: '',
      searchPageBack: null,
      pagination: {
        total: 0,
        per_page: null,
        current_page: 1,
        last_page: null,
        from: null,
        to: null,
      },
      offset: 4,
      orderBy: {
        direction: 'desc',
        column: ''
      }
    }
  },
  computed: {
    Filters(){
      var filtros;
      try {
        filtros = this.otherFilters.map(function(x) {
          return '&'+Object.keys(x)+'='+x[Object.keys(x)]
        })
      }
      catch(err) {
        filtros = ''
        console.log(err.message);
      }
      return filtros
    },
    SourceUrl(){
      if (this.source.trim() == '') {
        return '';
      }
      return this.source + '?order_column=' +
      this.orderBy.column + '&order_direction=' +
      this.orderBy.direction + '&search_term=' +
      this.searchTerm.trim() + '&page=' + this.pagination.current_page+this.Filters;
    },
    hasOptionsRow(){
      return this.validOptionsRow.length>0;
    },
    AddEnabled() {
      return this.optionsrow.indexOf('add') >= 0 ? 'add' : '';
    },
    validOptionsRow: function() {
      return this.optionsrow.filter((el, i) => {
        return this.rowOptionsList.indexOf(el) >= 0;
      });
    },
    isActived: function() {
      return this.pagination.current_page;
    },
    pagesNumber: function() {
      var pagesArray = [];
      // return pages;
      if (!this.pagination.to) {
        return [];
      }
      var from = this.pagination.current_page - this.offset

      if (from < 1) {
        from = 1;
      }

      var to = from + this.offset;

      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page
      }

      while (from <= to) {
        pagesArray.push(from);
        from++;
      }
      return pagesArray;
    }
  },
  watch: {
    searchTerm(val) {
      if (this.autoSearch) {
        this.doSearch();
      }
    },
  },
  methods: {
    doSearch:_.debounce(
      function () {
        this.search()
      },
      500
    ),
    optionClick(option){
      this.$emit('optionclick',option)
    },
    clickSearchButton(event) {
      if (event.target.tagName != "BUTTON") {
        if (this.autoSearch) {
          this.search()
        }
      } else {
        if (!this.autoSearch) {
          this.search()
        }
      }
    },
    changePage(page) {
      if (this.pagination.current_page != page && page <= this.pagination.last_page && page > 0) {
        this.pagination.current_page = page;
        this.fetchItems(page);
      }
    },
    search() {
      if (this.searchPageBack == null) {
        // this.searchPageBack = this.pagination.current_page;
        this.pagination.current_page = 1;
      }
      if (this.searchTerm == '') {
        this.pagination.current_page = this.searchPageBack;
        this.searchPageBack = null;
      }
      this.fetchItems(this.pagination.current_page);
    },
    fetchItems(current_page) {
      var self = this;
      if(this.source!='')
      axios.get(self.SourceUrl).then((res) => {
        self.pagination = res.data;
      }).catch((err) => {
        self.showAlertError(err); //Mixin
      });
      $('[data-toggle="tooltip"]').tooltip();
    },
    infiniteHandler($state,scrollableId = null){
      console.log('scrool Height: '+$('#'+scrollableId).scrollTop());
      var self = this;
      if(this.source!='')
      setTimeout(function () {
        self.pagination.current_page+=1;
        axios.get(self.SourceUrl).then((res_s)=>{
          let dados = res_s.data.data;

          if (res_s.data.next_page_url == null) {
            $state.complete();
          }
          if (dados.length > 0) {
            self.pagination.data = self.pagination.data.concat(dados);
            $state.loaded();
            if (scrollableId !=null) {
              window.setTimeout(()=>{
                $('#'+scrollableId).slimScroll({scrollTo:$('#'+scrollableId).scrollTop()})
              }, 120);
            }
          }
        },(res_e)=>{
          self.showAlertError(res_e);
        });
      }, 1000)
    },
    toggleOrder(column) {
      if (column === this.orderBy.column) {
        this.orderBy.direction = this.orderBy.direction === 'desc' ? 'asc' : 'desc';
      } else {
        this.orderBy.column = column;
        this.orderBy.direction = 'asc';
      }
      this.fetchItems(this.pagination.current_page);
    },
  }
}
</script>
<style media="screen">
.table td.fit,
.table th.fit {
  white-space: nowrap;
  width: 1%;
}
</style>
