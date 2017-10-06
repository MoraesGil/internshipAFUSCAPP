@extends('layouts.app')

@section('content')
  <!-- page content -->
  <div class="right_col" role="main" >
    <div id="dashboard">
      <!-- top tiles -->
      <div class="row tile_count">
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
          <span class="count_top"><i class="fa fa-user"></i> Vales do mês</span>
          <div class="count">120</div>
          <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> ultimo mês</span>
        </div>
      </div>
      <!-- /top tiles -->
      <div class="row">
        <div class="col-md-12 col-sm-4 col-xs-12">
           <gm-movimento-list />
        </div>

      </div>
    </div>
  </div>
  <!-- /page content -->

@endsection

@push('js')
  <script src="{{asset('js/dashboard.js')}}"></script>
@endpush
