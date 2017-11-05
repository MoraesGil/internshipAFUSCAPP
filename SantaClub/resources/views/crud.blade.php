{{-- @author Gilberto Prudêncio Vaz de Moraes <moraesdev@gmail.com>   --}}
@extends('layouts.app')

@section('content')
  <div id="app">
    <input type="hidden" name="" value="{{route($resourceName.'.index')}}" id="resourceUrl">

    <modal v-model="form_modal" title="Cadastro" @hide="form_modal = false" :size="modalSize" :auto-focus="true">
      <form v-if="form_modal" is="{{$resourceName}}"  :target-url="resourceUrl" :entity-src="entity"></form>
      <div slot="footer">
        <button type="button" class="btn btn-default" @click="form_modal = false">Cancel</button>
        <button type="button" class="btn btn-success" @click="saveChanges">Gravar</button>
      </div>
    </modal>

    <data-viewer :source="resourceUrl" title="{{$pageTitle}}"
    :buttons="['add','edit','delete']"
    @add="create"
    @edit="edit"
    @detail="show"
    @delete="destroy"
    @download="download"
    @print="report"
    />

  </div>
@endsection

@push('js')
  <script src="{{elixir('js/crud.js')}}"></script>
@endpush
