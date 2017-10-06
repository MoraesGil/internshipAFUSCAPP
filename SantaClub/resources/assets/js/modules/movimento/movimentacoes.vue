<template lang="html">
  <div class="x_panel">
    <div class="x_title">
      <h2>{{title}} </h2>
      <small class="pull-right">{{subtitle}}</small>
      <div class="clearfix"></div>
    </div>
    <div class="">
      <table class="table-hover main-table">
        <tbody>
          <tr >
            <td class="first">
              <i class="fa fa-circle fa-fw red"></i>
            </td>
            <td class="description"  >
              <table class="fixed-table">
                <tr>
                  <td>
                    <a href="#">
                      Folha de pagamento da santa casa Mar/2017
                      <small>
                        10/09/2017
                      </small>
                    </a>
                  </td>
                </tr>
              </table>
            </td>
            <td class="value">
              R$ -7.700,26
            </td>
            <td class="end">
              <div class="pull-right">
                <i class="fa fa-thumbs-o-up fa-fw pull-left"></i>
                <i class="fa fa-chevron-down fa-fw pull-left"></i>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      default: 'Title'
    },
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


  },
  mounted() {

  },
  data() {
    return {
      searchTerm:'',
      items:[],
      currentPage:0,
    }
  },
  computed: {

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

table > tbody > tr > td.description {
  padding: 11px 2px 9px;
  font-weight: 600;
}

table > tbody > tr > td.description > div{
  width: 1px;
  overflow: hidden;
  text-overflow: ellipsis;

}
table > tbody > tr > td.value {
  text-align: right;
  color: #778789;
  white-space: nowrap;
  width: 1%;
  padding:0  2px;
}

table > tbody > tr > td.description small {
  display: block;
  font-size: 11px;
  color: #999999;
}

table > tbody > tr > td.first {
  width: 5px;
}
table > tbody > tr > td.end {
  width: 50px;
  padding: 0 2px;
}
</style>
