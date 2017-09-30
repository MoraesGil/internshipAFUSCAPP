

@extends('layout')
@section('content')
  <div id="DataViewer">
    <data-viewer source="{{$source}}" title="{{$title}}" :optionsrow="['add','edit','delete','print','download']"/>
  </div>
@endsection
