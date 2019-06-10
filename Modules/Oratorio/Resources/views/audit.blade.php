<?php
use App\Audit;
use Modules\User\Entities\User;
?>

@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col">
      <div class="card bg-transparent border-0">
        <h1><i class="fas fa-stream"></i> Log attività</h1>
        <p class="lead">Elenco delle attività svolte su Segresta da amministratori ed utenti</p>
        <hr>
      </div>
    </div>
  </div>

  @if(Session::has('flash_message'))
  <div class="alert alert-success">
    {{ Session::get('flash_message') }}
  </div>
  @endif

  <div class="row justify-content-center" style="margin-top: 20px;">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <table class="table table-bordered" id="logTable" style="width: 100%">
            <thead>
              <tr>
                <th>Id</th>
                <th>Utente</th>
                <th>Operazione</th>
                <th>Modello</th>
                <th>ID</th>
                <th>Valori vecchi</th>
                <th>Valori nuovi</th>
                <th>Url</th>
                <th>Indirizzo IP</th>
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



$(document).ready(function(){
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': '{{csrf_token()}}'
    }
  });

  $('#logTable').DataTable({
    processing: true,
    serverSide: true,
    dom: 'frtip',
    language: { "url": "{{ asset('Italian.json') }}" },
    ajax: "{!! route('oratorio.log_audit') !!}",
    columns: [
      { data: 'id', visible: false},
      { data: 'user_label'},
      { data: 'event'},
      { data: 'auditable_type'},
      { data: 'auditable_id'},
      { data: 'old_values' },
      { data: 'new_values'},
      { data: 'url' },
      { data: 'ip_address'},
    ],


  });

});

</script>
@endpush
