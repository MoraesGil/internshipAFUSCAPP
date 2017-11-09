<script>
/**
* Componente dataViwerBase
* @author Gilberto Prudêncio Vaz de Moraes <moraesdev@gmail.com>
* @type {Vue Component}
*/
import axios from 'axios'
import _ from 'lodash'

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
    otherFilters: {
      type: Array,
      default: function() {
        return []
      }
    },
  },
  mounted() {
    this.fetchItems();

  },
  destroyed: function() {

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
      var url = this.source + '?order_column=' +
      this.orderBy.column + '&order_direction=' +
      this.orderBy.direction + '&search_term=' +
      this.searchTerm.trim() + '&page=' + this.pagination.current_page+this.Filters

      return url.replace('custom_','');
    },
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
    doSearch:_.debounce(
      function () {
        this.search()
      },
      500
    ),
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
    fetchItems() {
      var self = this;
      this.isLoading = true;
      if(this.source!='')
      axios.get(self.SourceUrl).then((res) => {
        this.isLoading = false;
        self.pagination = res.data;
      }).catch((err) => {
        this.isLoading = false;
        self.showResponseError(err); //Mixin
      });
    },
    infiniteHandler($state,scrollableId = null){
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
          self.showResponseError(res_e);
        });
      }, 1000)
    },
    oderBy(column) {
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
