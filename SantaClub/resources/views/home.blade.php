@extends('layouts.app')

@section('content')
  <div id="dashboard">
    <!-- top tiles -->
    <div class="row tile_count ">
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Associados Internos</span>
        <div class="count">2500</div>
        <span class="count_bottom"><i class="green">80% </i> do total</span>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Associados Externos</span>
        <div class="count">2500</div>
        <span class="count_bottom"><i class="green">80% </i> do total</span>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Associados Ativos </span>
        <div class="count">3000</div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> ultimo mês</span>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Convênios</span>
        <div class="count">200</div>
        <span class="count_bottom">Total cadastrado</span>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Alguma coisa..</span>
        <div class="count">120</div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> ultimo mês</span>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Vales do mês</span>
        <div class="count">120</div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> ultimo mês</span>
      </div>
    </div>
    <!-- /top tiles -->
    <div class="row">
      <div class="col-sm-6 col-md-4 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Contas a pagar  </h2>
            <ul class="nav navbar-right panel_toolbox">
              <li>
                <a href="#" @click.prevent="clickTeste('contas 1')">Ver Todas</a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <ul class="to_do">
              <li>
                <p>
                  Em Atraso
                </p>
              </li>
            </ul>
            <gm-movimento-list source="http://estagio.dev/movimentacoes" :mini-mode="true" :height-percent="50" :other-filters="[{plimit:5}]"/>
          </div>
          <div class="x_content">
            <ul class="to_do">
              <li>
                <p>
                  Próximas
                </p>
              </li>
            </ul>
            <gm-movimento-list source="http://estagio.dev/movimentacoes" :mini-mode="true" :height-percent="50" :other-filters="[{plimit:5}]"/>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Contas a Receber </h2>
            <ul class="nav navbar-right panel_toolbox">
              <li>
                <a href="#" @click.prevent="clickTeste('contas 2')">Ver Todas</a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <ul class="to_do">
              <li>
                <p>
                  Em Atraso
                </p>
              </li>
            </ul>
            <gm-movimento-list source="http://estagio.dev/movimentacoes" :mini-mode="true" :height-percent="50" :other-filters="[{plimit:5}]"/>
          </div>
          <div class="x_content">
            <ul class="to_do">
              <li>
                <p>
                  Próximas
                </p>
              </li>
            </ul>
            <gm-movimento-list source="http://estagio.dev/movimentacoes" :mini-mode="true" :height-percent="50" :other-filters="[{plimit:5}]"/>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-4">
        <div class="row">
          <div class="col-sm-6 col-md-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Acesso rápido</h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">

              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Top Categorias do mês</h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <table class="" style="width:100%">
                  <tbody><tr>
                    <th style="width:37%;">
                      <p>Top 5</p>
                    </th>
                    <th>
                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <p class="">Categoria</p>
                      </div>

                    </th>
                  </tr>
                  <tr>
                    <td>
                      grafico aqui

                    </td>
                    <td>
                      <table class="tile_info">
                        <tbody><tr>
                          <td>
                            <p><i class="fa fa-square blue"></i>IOS </p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p><i class="fa fa-square green"></i>Android </p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p><i class="fa fa-square purple"></i>Blackberry </p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p><i class="fa fa-square aero"></i>Symbian </p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p><i class="fa fa-square red"></i>Others </p>
                          </td>
                        </tr>
                      </tbody></table>
                    </td>
                  </tr>
                </tbody></table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('css')
<style media="screen">
.movContainer{
  padding: 0px !important;
}
</style>
@endpush

@push('js')
  <script src="{{elixir('js/dashboard.js')}}"></script>
@endpush
