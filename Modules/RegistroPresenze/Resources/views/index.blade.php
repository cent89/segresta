@extends('layouts.app')

@section('content')
<style>
thead input{
  width: 100%;
}
thead select{
  width: 100%;
}

</style>
<div class="container">

  <div class="row">
    <div class="col">
      <div class="card bg-transparent border-0">
        <h1><i class="far fa-calendar-check"></i> Registro Presenze</h1>
        <p class="lead">Elenchi di presenze agli eventi</p>
        <hr>
      </div>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-5">
      <div class="card">
        <div class="card-body">
          @if(Session::has('flash_message'))
          <div class="alert alert-success">
            {{ Session::get('flash_message') }}
          </div>
          @endif

          {{$dataTable_registro_presenze->table()}}

        </div>
      </div>
    </div>

    <div class="col-7">
      <div class="card">
        <div class="card-body" id="detail_registro">

        </div>
      </div>
    </div>

  </div>
</div>


@endsection

@push('scripts')
{{$dataTable_registro_presenze->scripts()}}
<script>


$(document).ready(function(){
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': '{{csrf_token()}}'
    }
  });

  $('button').removeClass('dt-button');

  // Editor Inline
  $("#dataTable_registro_presenze").on('dblclick', 'tbody td', function (e) {
    if("{{ !Auth::user()->can('edit-registro_presenze') }}") return;
    window.LaravelDataTables["dataTable_registro_presenze-editor"].inline(this, {
      onBlur: 'submit',
      submit: 'allIfChanged'
    });
  });

  // Editor edit
  $("#dataTable_registro_presenze").on('click', 'button#editor_edit', function (e) {
    e.preventDefault();
    if("{{ !Auth::user()->can('edit-registro_presenze') }}") return;
    window.LaravelDataTables["dataTable_registro_presenze-editor"].edit( $(this).closest('tr'), {
      title: 'Modifica',
      buttons: 'Aggiorna'
    });
  });

  // Editor delete
  $("#dataTable_registro_presenze").on('click', 'button#editor_delete', function (e) {
    e.preventDefault();
    if("{{ !Auth::user()->can('edit-registro_presenze') }}") return;
    window.LaravelDataTables["dataTable_registro_presenze-editor"].remove( $(this).closest('tr'), {
      title: 'Cancella record',
      message: 'Sei sicuro di voler eliminare il registro selezionato? Verranno eliminate anche tutte le presenze già registrate!',
      buttons: 'Cancella record'
    } );
  } );


});

function apri_registro(id_registro){
  $("#detail_registro").load("{!! url('admin/registro_presenze_utente?id_registro="+id_registro+"') !!}");
}

</script>
@endpush
