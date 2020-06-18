<?php
use Modules\Oratorio\Entities\Oratorio;
use App\Provincia;
use App\Comune;
use App\Nazione;
?>

@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col">
      <div class="card bg-transparent border-0">
        <h1><i class='fas fa-calendar-alt'></i> Registrazione</h1>
        <p class="lead">Registrati alla piattaforma!</p>
        <hr>
      </div>
    </div>
  </div>


  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          {!! Form::open(['method' => 'POST', 'route' => ['register']]) !!}
          {!! Form::hidden('id_oratorio', $oratorio->id) !!}
          @csrf

          <h3>Informazioni generali</h3>
          <p>I campi con (*) sono obbligatori</p>

          <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">Nome (*)</label>

            <div class="col-md-6">
              <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

              @if ($errors->has('name'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('name') }}</strong>
              </span>
              @endif
            </div>
          </div>

          <div class="form-group row">
            <label for="cognome" class="col-md-4 col-form-label text-md-right">Cognome (*)</label>

            <div class="col-md-6">
              <input id="cognome" type="text" class="form-control{{ $errors->has('cognome') ? ' is-invalid' : '' }}" name="cognome" value="{{ old('cognome') }}" required autofocus>

              @if ($errors->has('cognome'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('cognome') }}</strong>
              </span>
              @endif
            </div>
          </div>

          <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">Indirizzo email (*)</label>

            <div class="col-md-6">
              <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

              @if ($errors->has('email'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
              </span>
              @endif
            </div>
          </div>

          <div class="form-group row">
            <label for="cell_number" class="col-md-4 col-form-label text-md-right">Numero di cellulare (*)</label>

            <div class="col-md-6">
              <input id="cell_number" type="text" class="form-control{{ $errors->has('cell_number') ? ' is-invalid' : '' }}" name="cell_number" value="{{ old('cell_number') }}" required autofocus>

              @if ($errors->has('cell_number'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('cell_number') }}</strong>
              </span>
              @endif
            </div>
          </div>

          <div class="form-group row">
            <label for="sesso" class="col-md-4 col-form-label text-md-right">Sesso (*)</label>

            <div class="col-md-6">
              <select id="sesso" class="form-control" name="sesso"><option value="M">Uomo</option><option value="F">Donna</option></select>

              @if ($errors->has('sesso'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('sesso') }}</strong>
              </span>
              @endif
            </div>
          </div>

          <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}  (*)</label>

            <div class="col-md-6">
              <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

              @if ($errors->has('password'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('password') }}</strong>
              </span>
              @endif
            </div>
          </div>

          <div class="form-group row">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Conferma password  (*)</label>

            <div class="col-md-6">
              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
            </div>
          </div>

          <h3>Luogo e data di nascita</h3>

          <div class="form-group row">
            <label for="nato_il" class="col-md-4 col-form-label text-md-right date">Data di nascita (*)</label>

            <div class="col-md-6">
              <input id="nato_il" type="text" class="form-control{{ $errors->has('nato_il') ? ' is-invalid' : '' }}" name="nato_il" value="{{ old('nato_il') }}" required autofocus>

              @if ($errors->has('nato_il'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('nato_il') }}</strong>
              </span>
              @endif
            </div>
          </div>

          <div class="form-group row">
            <label for="id_nazione_nascita" class="col-md-4 col-form-label text-md-right">Nazione di nascita</label>

            <div class="col-md-6">
                {{ Form::select('id_nazione_nascita', Nazione::orderBy('nome_stato')->pluck('nome_stato', 'id'), old('id_nazione_nascita'), ['class' => $errors->has("id_nazione_nascita")?"form-control is-invalid":"form-control", 'id' => 'id_nazione_nascita', 'autofocus', 'placeholder' => 'Seleziona una nazione']) }}

              @if ($errors->has('id_nazione_nascita'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('id_nazione_nascita') }}</strong>
              </span>
              @endif
            </div>
          </div>

          <div class="form-group row" id="div_provincia_nascita">
            <label for="id_provincia_nascita" class="col-md-4 col-form-label text-md-right">Provincia di nascita</label>

            <div class="col-md-6">
              {{ Form::select('id_provincia_nascita', Provincia::orderBy('nome')->pluck('nome', 'id'), old('id_provincia_nascita'), ['class' => $errors->has("id_provincia_nascita")?"form-control is-invalid":"form-control", 'id' => 'id_provincia_nascita', 'autofocus', 'placeholder' => 'Seleziona una provincia']) }}


              @if ($errors->has('id_provincia_nascita'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('id_provincia_nascita') }}</strong>
              </span>
              @endif
            </div>
          </div>

          <div class="form-group row" id="div_comune_nascita">
            <label for="id_comune_nascita" class="col-md-4 col-form-label text-md-right">Comune di nascita</label>

            <div class="col-md-6">
              {{ Form::select('id_comune_nascita', array(), old('id_comune_nascita'), ['class' => $errors->has("id_comune_nascita")?"form-control is-invalid":"form-control", 'id' => 'id_comune_nascita', 'autofocus', 'required']) }}

              @if ($errors->has('id_comune_nascita'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('id_comune_nascita') }}</strong>
              </span>
              @endif
            </div>
          </div>

          <h3>Residenza</h3>

          <div class="form-group row">
            <label for="id_provincia_residenza" class="col-md-4 col-form-label text-md-right">Provincia di residenza</label>

            <div class="col-md-6">
              {{ Form::select('id_provincia_residenza', Provincia::orderBy('nome')->pluck('nome', 'id'), old('id_provincia_residenza'), ['class' => $errors->has("id_provincia_residenza")?"form-control is-invalid":"form-control", 'id' => 'id_provincia_residenza', 'autofocus', 'required']) }}
              @if ($errors->has('id_provincia_nascita'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('id_provincia_residenza') }}</strong>
              </span>
              @endif
            </div>
          </div>

          <div class="form-group row">
            <label for="id_comune_residenza" class="col-md-4 col-form-label text-md-right">Comune di residenza</label>

            <div class="col-md-6">
              {{ Form::select('id_comune_residenza', array(), old('id_comune_residenza'), ['class' => $errors->has("id_comune_residenza")?"form-control is-invalid":"form-control", 'id' => 'id_comune_residenza', 'autofocus', 'required']) }}

              @if ($errors->has('id_comune_residenza'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('id_comune_residenza') }}</strong>
              </span>
              @endif
            </div>
          </div>

          <div class="form-group row">
            <label for="via" class="col-md-4 col-form-label text-md-right">Indirizzo</label>

            <div class="col-md-6">
              <input id="via" type="text" class="form-control{{ $errors->has('via') ? ' is-invalid' : '' }}" name="via" value="{{ old('via') }}" autofocus>

              @if ($errors->has('via'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('via') }}</strong>
              </span>
              @endif
            </div>
          </div>

          <div class="form-group row">
            <div class="form-group col">
              @if(config('app.privacy.gdpr_registrazione.mostra'))
							<h3 style="text-align: center">
								{!! \App\Config::render(config('app.privacy.gdpr_registrazione.titolo'), ['nome_parrocchia' => $oratorio->nome_parrocchia]) !!}
							</h3>
							{!! \App\Config::render(config('app.privacy.gdpr_registrazione.testo'), ['nome_parrocchia' => $oratorio->nome_parrocchia, 'nome_diocesi' => $oratorio->nome_diocesi, 'indirizzo_parrocchia' => $oratorio->indirizzo_parrocchia, 'email_parrocchia' => $oratorio->email]) !!}

							<div class="form-row">
								<div class="form-group col" style="text-align: center">
									{!! Form::label('consenso_gdpr', 'Esprimo il consenso') !!}
									{!! Form::radio('consenso_gdpr', 1, null, ['class' => 'form-control', 'onclick' => 'enable_confirm_button()', config('app.privacy.gdpr_registrazione.obbligatorio')==1?'required':'']) !!}
								</div>
								<div class="form-group col" style="text-align: center">
									{!! Form::label('consenso_gdpr', 'Nego il consenso') !!}
									{!! Form::radio('consenso_gdpr', 0, null, ['class' => 'form-control', 'onclick' => 'enable_confirm_button()', config('app.privacy.gdpr_registrazione.obbligatorio')==1?'required':'']) !!}
								</div>
							</div>
							@endif

              @if(config('app.privacy.affiliazione.registrazione.mostra'))
							<h3 style="text-align: center">
								{!! \App\Config::render(config('app.privacy.affiliazione.titolo'), ['nome_evento' => '', 'nome_parrocchia' => $oratorio->nome_parrocchia]) !!}
							</h3>
							{!! \App\Config::render(config('app.privacy.affiliazione.testo'), ['nome_evento' => '', 'nome_parrocchia' => $oratorio->nome_parrocchia, 'nome_diocesi' => $oratorio->nome_diocesi, 'indirizzo_parrocchia' => $oratorio->indirizzo_parrocchia, 'email_parrocchia' => $oratorio->email]) !!}

							<div class="form-row">
								<div class="form-group col" style="text-align: center">
									{!! Form::label('consenso_affiliazione', 'Esprimo il consenso') !!}
									{!! Form::radio('consenso_affiliazione', 1, null, ['class' => 'form-control', config('app.privacy.affiliazione.registrazione.obbligatorio')==1?'required':'']) !!}
								</div>
								<div class="form-group col" style="text-align: center">
									{!! Form::label('consenso_affiliazione', 'Nego il consenso') !!}
									{!! Form::radio('consenso_affiliazione', 0, null, ['class' => 'form-control', config('app.privacy.affiliazione.registrazione.obbligatorio')==1?'required':'']) !!}
								</div>
							</div>
							@else
							{!! Form::hidden('consenso_affiliazione', 0) !!}
							@endif
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-6 col-md-offset-4">
              {!! Form::submit('Registrati', ['class' => 'btn btn-primary form-control', 'disabled', 'id' => 'confirm_button']) !!}
            </div>
          </div>


          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
</div>


@endsection

@push('scripts')
<script>
function enable_confirm_button(){
  var consenso_1 = $("#consenso_gdpr").is(":checked");
  var richiesto = $("#consenso_gdpr").prop('required');
  if(richiesto && !consenso_1){
    $("#confirm_button").prop('disabled', true);
  }else{
    $("#confirm_button").prop('disabled', false);
  }
}

function update_comune(select_provincia, select_comune){
  $('#'+select_comune).empty();
  $.ajax({
    type: 'GET',
    dataType: 'json',
    url: "{{route('comune.lista')}}",
    data: {
      id_provincia: $('#'+select_provincia).val()
    },
    success: function(response) {
      $.each(response, function(key, value){
        $('#'+select_comune).append($('<option>', { value : value.id }).text(value.nome));
      });
    },
    error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + XMLHttpRequest.responseText + "\n" + exception); },
    async: false
  });


}

$('#id_provincia_nascita').on('change', function(){
  if($('#id_nazione_nascita').val() != 118) null;
  update_comune('id_provincia_nascita', 'id_comune_nascita');
});

$('#id_provincia_residenza').on('change', function(){
  update_comune('id_provincia_residenza', 'id_comune_residenza');
});

$('#id_nazione_nascita').on('change', function(){
  var nazione = $('#id_nazione_nascita').val();
  if(nazione == 118){
    $('#div_provincia_nascita').show();
    $('#div_comune_nascita').show();
    update_comune('id_provincia_nascita', 'id_comune_nascita');
  }else{
    $('#div_provincia_nascita').hide();
    $('#div_comune_nascita').hide();
    // $('#id_provincia_nascita').empty();
    $('#id_comune_nascita').empty();
  }
});


$(document).ready(function(){
  update_comune('id_provincia_nascita', 'id_comune_nascita');
  update_comune('id_provincia_residenza', 'id_comune_residenza');
  enable_confirm_button();

});
</script>
@endpush
