@extends('layouts.app')

@section('content')
  <div id="movimentacoes">
    <div class="row">
      <div class="col-sm-12 col-md-10 col-xs-12 col-md-offset-1">
        <gm-movimento-list source="{{route('mov.movimentacoes.index')}}" />
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script src="{{elixir('js/movimentacoes.js')}}"></script>
@endpush
