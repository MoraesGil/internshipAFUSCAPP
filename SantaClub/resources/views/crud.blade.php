{{-- @author Gilberto Prudêncio Vaz de Moraes <moraesdev@gmail.com>   --}}
@extends('layouts.app')

@section('content')
  <div id="app">
    <gm-crud 
    resource-name="{{$resourceName}}"
    resource-url="{{route($resourceName.'.index')}}"
    title="{{$pageTitle}}"
    :row-buttons="['edit','delete']"
    :top-buttons="['add']"
    >
  </div>
@endsection

@push('js')
  <script src="{{elixir('js/crud.js')}}"></script>
@endpush
