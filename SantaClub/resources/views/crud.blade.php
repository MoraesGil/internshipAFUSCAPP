{{-- @author Gilberto Prudêncio Vaz de Moraes <moraesdev@gmail.com>   --}}
@extends('layouts.app')

@section('content')
  <div id="app"> 
    <gm-crud
    :row-buttons="{{json_encode($dataViewerOptions['row'])}}"
    :top-buttons="{{json_encode($dataViewerOptions['top'])}}"
    resource-name="{{$resourceName}}"
    resource-url="{{route($resourceName.'.index')}}"
    >
    <template slot="title">
    {{$pageTitle}}
  </template>
</gm-crud>
</div>
@endsection

@push('js')
  <script src="{{elixir('js/crud.js')}}"></script>
  <script type="text/javascript">
  $( document ).ready(function() {

    new Vue({
      el:'#app',
      data(){
        return {

        }
      },
      mounted(){


      },
      destroyed: function() {

      },
      methods:{

      }
    })
  });
  </script>
@endpush
