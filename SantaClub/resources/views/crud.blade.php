@extends('layouts.app')

@section('content')
  <div id="app">
    <data-viewer source="{{$dataSource}}" title="{{$pageTitle}}" :buttons="['add','edit','delete','print','download']"/>
  </div>
@endsection

@push('js')
  <script src="{{elixir('js/crud.js')}}"></script>
@endpush
