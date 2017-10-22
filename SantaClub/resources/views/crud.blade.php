@extends('layouts.app')

@section('content')
  <div id="app">

    <modal v-model="form_modal" title="Cadastro" @hide="closeform">
      <form is="{{$resourceName}}"></form>
      <div slot="footer">
        <button type="button" class="btn btn-default">Cancel</button>
        <button type="button" class="btn btn-success">Gravar</button>
      </div>
    </modal>

    <data-viewer source="{{route($resourceName.'.index')}}" title="{{$pageTitle}}"
    :buttons="['add','edit','delete','print','download']"
    @add="create"
    @edit="edit"
    @detail="edit"
    @delete="destroy"
    @download="edit"
    @print="report"
    />

  </div>
@endsection

@push('js')
  <script src="{{elixir('js/crud.js')}}"></script>
@endpush
