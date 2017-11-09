<template>
  <div class="x_panel">
    <div class="x_title">
      <h2> {{title}}</h2>
      <template v-for="btn in topButtons">
        <a class="btn btn-default pull-right"  @click="buttonClick(btn)">
          {{btn.label}}  <i :class="btn.icon"></i>
        </a>
      </template>
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
      <h1 v-if="!pagination.total && !isLoading" class="text-center">Não há dados para ser exibidos</h1>

      <h1 class="text-center" style="margin-top:60px;" v-show="isLoading">
        <i class="fa fa-spinner fa-pulse fa-fw"></i>
      </h1>

      <div class="table-responsive" v-if="pagination.total && !isLoading">
        <table class="table table-hover table-striped table-bordered">
          <thead>
            <tr>
              <template v-for="(column,key) in pagination.columns ">
                <th v-if="notHidden(key)" @click="oderBy(key)">
                  <span>{{column}}</span>
                  <span v-if="key === orderBy.column">
                    <span v-if="orderBy.direction === 'desc'"><i class="fa fa-sort-amount-desc"></i></span>
                    <span v-else><i class="fa fa-sort-amount-asc"></i></span>
                  </span>
                  <span v-else><i class="fa fa-sort"></i></span>
                </th>
              </template>
              <template v-if="rowButtons.length>0">
                <th class="fit"> opções <i class="fa fa-gear fa-fw"></i> </th>
              </template>
            </tr>
          </thead>
          <tbody>
            <tr v-for="row in pagination.data">
              <template v-for="(value,key) in row">
                <td v-if="notHidden(key)">
                  <div v-html="value"></div>
                </td>
              </template>

              <td class="fit text-center" v-if="rowButtons.length>0">
                <template v-for="btn in rowButtons">
                  <a data-toggle="tooltip" :title="btn.label" class="btn btn-default btn-xs" @click="buttonClick(btn,row)">
                    <i :class="btn.icon"></i>
                  </a>
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
/**
* @author Gilberto Prudêncio Vaz de Moraes <moraesdev@gmail.com>
*/
const AVAILABLE_BUTTONS = {
  add : {
    label : 'Novo',
    icon : 'fa fa-plus',
    places: ['t','r'],
    default_place:'t'
  },
  print : {
    label : 'Relatório',
    icon : 'fa fa-print',
    places: ['t','r'],
    default_place:'t'
  },
  delete : {
    label : 'Excluir',
    icon : 'fa fa-trash',
    places: ['r'],
    default_place:'r'
  },
  detail : {
    label : 'Detalhes',
    icon : 'fa fa-eye',
    places: ['r'],
    default_place:'r'
  },
  download : {
    label : 'Baixar',
    icon : 'fa fa-download',
    places: ['t','r'],
    default_place:'r'
  },
  edit : {
    label : 'Alterar',
    icon : 'fa fa-edit',
    places: ['r'],
    default_place:'r'
  },
};

/**
* Componente gridViewer
* @author Gilberto Prudêncio Vaz de Moraes <moraesdev@gmail.com>
* @type {Vue Component}
*/
import BaseViewer      from './baseViewer.vue'

export default {
  extends: BaseViewer,
  props: {
    optionsrow: {
      type: Array,
      default: function() {
        return []
      }
    },
    buttons: {
      type: Array,
      default: function() {
        return []
      }
    }
  },
  mounted() {
    this.loadButtons();
    this.eventHub.$on('refreshgridViewer',this.fetchItems);
  },
  destroyed: function() {
    this.eventHub.$off('refreshgridViewer');
  },
  data() {
    return {
      isLoading : true,
      topButtons:[],
      rowButtons:[],
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
        hidden_columns:[],
        primary:null
      },
      offset: 4,
      orderBy: {
        direction: 'desc',
        column: ''
      }
    }
  },
  computed: {

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
    source(val){
      this.fetchItems()
    },
    searchTerm(val) {
      if (this.autoSearch) {
        this.doSearch();
      }
    },
  },
  methods: {
    buttonClick(btn,row){
      if (row) {
        var par = _.merge(row,
          {
            primary: row[this.pagination.primary],
            title:   row[this.pagination.title_column] || 'Cód: '+row[this.pagination.primary]
          });
        }
        switch (btn.label) {
          case AVAILABLE_BUTTONS['add'].label: {
            this.$emit('add')
          }
          break;
          case AVAILABLE_BUTTONS['delete'].label: {
            this.$emit('delete',par)
          }
          break;
          case AVAILABLE_BUTTONS['detail'].label: {
            this.$emit('detail',par)
          }
          break;
          case AVAILABLE_BUTTONS['download'].label: {
            this.$emit('download',par)
          }
          break;
          case AVAILABLE_BUTTONS['edit'].label: {
            this.$emit('edit',par)
          }
          break;
          case AVAILABLE_BUTTONS['print'].label: {
            this.$emit('print',par)
          }
          break;

          default:
            break;
          }
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
        notHidden(value){
          return this.pagination.hidden_columns == null || this.pagination.hidden_columns.map(x => x).indexOf(value) === -1;
        },
        loadButtons(){
          this.buttons.forEach((val,i)=>{
            var btn =  val.split(":");
            var valid = Object.keys(AVAILABLE_BUTTONS).indexOf(btn[0]) !==-1;

            if (valid) {
              btn[1] = AVAILABLE_BUTTONS[btn[0]].places.indexOf(btn[1]) !== -1 ? btn[1] : AVAILABLE_BUTTONS[val].default_place;
              if (btn[1] == 't') {
                this.topButtons.push(AVAILABLE_BUTTONS[btn[0]])
              }
              if (btn[1] == 'r') {
                this.rowButtons.push(AVAILABLE_BUTTONS[btn[0]])
              }
            }
          });
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
