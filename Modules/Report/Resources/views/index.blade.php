@extends('layouts.app')

<?php
use Modules\Report\Entities\Report;
?>

@section('content')
<div class="container">
  <div class="row">
    <div class="col">
      <div class="card bg-transparent border-0">
        <h1><i class="far fa-file-alt"></i> Report salvati</h1>
        <p class="lead">Lista report salvati come modelli, pronti da generare</p>
        <hr>
      </div>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-6">
      <div class="card">
        <div class="card-body">
          @if(Session::has('flash_message'))
          <div class="alert alert-success">
            {{ Session::get('flash_message') }}
          </div>
          @endif

          <p>In questa pagina trovi i report salvati come modello. Clicca sul pulsante "Genera" per geneare un report in formato excel delle tue iscrizioni, in base al modello salvato.</p>
          <p>Per creare un modello, vai nella pagina del report generale o settimanale, compila i vari campi (colonne, filtri, ...) e poi clicca su "Salva come modello".</p>

          <table class="table table-bordered" id="reportTable" style="width: 100%">
            <thead>
              <tr>
                <th>Id</th>
                <th>Titolo</th>
                <th></th>
              </tr>
            </thead>
          </table>

        </div>
      </div>
    </div>

  </div>
</div>

@endsection

@push('scripts')
<script>
var editor;

$(document).ready(function(){
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': '{{csrf_token()}}'
    }
  });

  editor = new $.fn.dataTable.Editor({
    ajax: {
      url: "{{route('report.index')}}"
    },
    display: "lightbox",
    table: "#reportTable",
    fields: [
      {label: "Titolo", name: "titolo"},
    ]
  });

  $('#reportTable').on('click', 'tbody td', function (e) {
    editor.inline(this, {
      onBlur: 'submit',
      submit: 'allIfChanged'
    });
  });

  // Delete a record
  $('#reportTable').on('click', 'button#editor_remove', function (e) {
    e.preventDefault();

    editor.remove( $(this).closest('tr'), {
      title: 'Cancella record',
      message: 'Sei sicuro di voler eliminare il report selezionato?',
      buttons: 'Cancella report'
    });
  });

  $('#reportTable').DataTable({
    dom: "lftipr",
    responsive: true,
    processing: true,
    serverSide: true,
    language: { "url": "{{ asset('Italian.json') }}" },
    ajax: "{!! route('report.data') !!}",
    columns: [
      { data: 'id', name: 'id', visible: false},
      { data: 'titolo' },
      { data: 'action', orderable: false, searchable: false}
    ]

  });

});
</script>
@endpush
