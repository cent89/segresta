<?php
use Modules\Event\Entities\Event;
use Modules\Event\Entities\Week;
use Modules\Oratorio\Entities\TypeSelect;
use Modules\Oratorio\Entities\Type;
use Modules\User\Entities\User;
use Modules\Oratorio\Entities\Oratorio;
use Modules\Event\Entities\EventSpec;
use Modules\User\Entities\Group;
use Modules\Famiglia\Entities\Famiglia;
use Modules\Famiglia\Entities\ComponenteFamiglia;

//specifiche dell'evento
$specs = (new EventSpec)
->select('event_specs.id_type', 'event_specs.hidden', 'event_specs.id', 'event_specs.label', 'event_specs.descrizione', 'event_specs.price', 'event_specs.acconto', 'event_specs.obbligatoria')
->where([['id_event', $event->id], ['event_specs.general', 1]])
->orderBy('event_specs.ordine', 'ASC')
->get();

$weeks = Week::select('id', 'from_date', 'to_date', 'descrizione')->where('id_event', $event->id)->orderBy('from_date', 'asc')->get();
$index = 0;
$oratorio = Oratorio::find(Session::get('session_oratorio'));
if($oratorio == null){
	return redirect()->route('login');
}
$user = User::find($id_user);

if(Module::find('famiglia') != null && Module::find('famiglia')->enabled() ){
	$padre = ComponenteFamiglia::getPadre($id_user);
	$madre = ComponenteFamiglia::getMadre($id_user);
}else{
	$padre = "";
	$madre = "";
}
?>

@extends('layouts.app')
@section('content')

<div class="container">
	<div class="row">
		<div class="col">
			<div class="card bg-transparent border-0">
				<h1><i class='fas fa-user'></i> Iscrizione all'evento <i> {{$event->nome}}</i></h1>
				<p class="lead">Inserisci le informazioni richieste per questo evento, poi clicca su "Salva"</p>
				<hr>
			</div>
		</div>
	</div>

	<div class="row justify-content-center" style="margin-top: 20px;">
		<div class="col-md-10">
			<div class="card">
				<div class="card-body">
					{!! Form::open(['route' => 'subscribe.savesubscribe', 'id' => 'prova']) !!}

					@if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('owner'))
					{!! Form::hidden('type', 'ADMIN') !!}
					{!! Form::hidden('confirmed', '1') !!}
					@else
					{!! Form::hidden('type', 'WEB') !!}
					{!! Form::hidden('confirmed', '0') !!}
					@endif

					{!! Form::hidden('id_event', $event->id) !!}

					<nav>
						<div class="nav nav-tabs" id="nav-tab" role="tablist">
							@if($event->select_famiglia)
							<a class="nav-item nav-link active" id="nav-famiglia-tab" data-toggle="tab" href="#nav-famiglia" role="tab" aria-controls="nav-famiglia" aria-selected="true">Utente</a>
							@endif

							@if(!$event->isOneSpecEvent())
							@if(count($specs)>0)
							<a class="nav-item nav-link" id="nav-generali-tab" data-toggle="tab" href="#nav-generali" role="tab" aria-controls="nav-generali" aria-selected="true">Informazioni generali</a>
							@endif
							@if(count($weeks)>0)
							<a class="nav-item nav-link" id="nav-settimanali-tab" data-toggle="tab" href="#nav-settimanali" role="tab" aria-controls="nav-settimanali" aria-selected="false">Informazioni settimanali</a>
							@endif
							@endif

							<a class="nav-item nav-link" id="nav-salva-tab" data-toggle="tab" href="#nav-salva" role="tab" aria-controls="nav-salva" aria-selected="false">Salva</a>
						</div>
					</nav>

					<div class="tab-content" id="nav-tabContent">
						<!--  Se abilitata la sezione di un membro della famiglia, genero un select con nome variabile id_user-->
						@if($event->select_famiglia)
						<div class="tab-pane fade show active" id="nav-famiglia" role="tabpanel" aria-labelledby="nav-famiglia-tab" style="margin-top: 20px;">
							{!! Form::label('id_user', 'Seleziona un componente della famiglia per cui stai eseguendo l\'iscrizione all\'evento') !!}
							{!! Form::select('id_user', ComponenteFamiglia::getComponenti($id_user), null, ['class' => 'form-control', 'required'])!!}
							<br><br>
							@if(count($specs) > 0 && !$event->isOneSpecEvent())
							<button class='btn btn-lg btn-success' id="to_general"><i class="fas fa-angle-double-right"></i> Avanti</button>
							@elseif(count($weeks) > 0)
							<button class='btn btn-lg btn-success' id="to_settimana"><i class="fas fa-angle-double-right"></i> Avanti</button>
							@else
							<button class='btn btn-lg btn-success' id="to_salva"><i class="fas fa-angle-double-right"></i> Avanti</button>
							@endif
						</div>
						@else
						{!! Form::hidden('id_user', $id_user) !!}
						@endif

						@if(!$event->isOneSpecEvent())

						<div class="tab-pane fade @if(!$event->select_famiglia ) show active @endif" id="nav-generali" role="tabpanel" aria-labelledby="nav-generali-tab" style="margin-top: 20px;">
							@foreach($specs as $spec)
							<?php
							$price = json_decode($spec->price, true);
							$acconto = json_decode($spec->acconto, true);
							if(count($price)==0) $price[0]=0;
							if(count($acconto)==0) $acconto[0]=0;
							$txt_obbligatoria = "";
							if($spec->obbligatoria){
								$txt_obbligatoria = "<i style='color: red'>richiesto</i>";
							}
							?>
							<div class="form-row" style="{!! (($spec->hidden && Auth::user()->hasRole('user'))?'display:none':'display:') !!}">
								{!! Form::hidden('id_spec['.$index.']', $spec->id) !!}
								{!! Form::hidden('id_week['.$index.']', 0) !!}

								<!-- Nome e valore della specifica -->
								<div class="form-group col">
									{!! Form::label($spec->id, $spec->label) !!} {!! $txt_obbligatoria !!}
									@if(strlen($spec->descrizione)>0)
									<p> {{ $spec->descrizione }} </p>
									@endif
									@if($spec->id_type > 0)
									{!! Form::select('specs['.$index.']', TypeSelect::where('id_type', $spec->id_type)->orderBy('ordine', 'ASC')->pluck('option', 'id'), '', ['class' => 'form-control', 'placeholder'=>'Seleziona un\'opzione', ($spec->obbligatoria==1)?'required':''])!!}
									@else
									@if($spec->id_type == Type::TEXT_TYPE)
									{!! Form::text('specs['.$index.']', '', ['class' => 'form-control', ($spec->obbligatoria==1)?'required':'']) !!}
									@elseif($spec->id_type == Type::BOOL_TYPE)
									{!! Form::hidden('specs['.$index.']', 0) !!}
									{!! Form::checkbox('specs['.$index.']', 1, '', ['class' => 'form-control']) !!}
									@elseif($spec->id_type == Type::NUMBER_TYPE)
									{!! Form::number('specs['.$index.']', '', ['class' => 'form-control', ($spec->obbligatoria==1)?'required':'']) !!}
									@elseif($spec->id_type == Type::DATE_TYPE)
									{!! Form::text('specs['.$index.']', '', ['class' => 'form-control date', ($spec->obbligatoria==1)?'required':'']) !!}
									@endif
									@endif
								</div>

								<!-- COSTO  -->
								<div class="form-group col-2">

									@if(Auth::user()->hasRole('user'))
									@if(floatval($price[0]) > 0)
									{!! Form::label('costo['.$index.']', "Prezzo") !!}
									{!! Form::hidden('costo['.$index.']', $price[0]) !!}
									{{ number_format(floatval($price[0]), 2, ',', '') }}€
									@endif
									@else
									{!! Form::label('costo['.$index.']', "Prezzo") !!}
									{!! Form::number('costo['.$index.']', $price[0], ['class' => 'form-control', 'step' => '0.1']) !!}
									@endif
								</div>

								<!-- ACCONTO  -->
								<div class="form-group col-2">
									@if(Auth::user()->hasRole('user'))
									@if(floatval($price[0]) > 0)
									{!! Form::label('acconto['.$index.']', "Acconto") !!}
									{!! Form::hidden('acconto['.$index.']', 0) !!}
									{{ number_format(floatval($price[0]), 2, ',', '') }}€
									@endif
									@else
									{!! Form::label('acconto['.$index.']', "Acconto") !!}
									{!! Form::number('acconto['.$index.']', $acconto[0], ['class' => 'form-control', 'step' => '0.1']) !!}
									@endif
								</div>

								<!-- PAGATO  -->
								@if(Auth::user()->hasRole('user'))
								{!! Form::hidden('pagato['.$index.']', 0) !!}
								@else
								<div class="form-group col-2">
									{!! Form::label('pagato['.$index.']', "Pagato") !!}
									{!! Form::hidden('pagato['.$index.']', 0) !!}
									{!! Form::checkbox('pagato['.$index.']', 1, false, ['class' => 'form-control']) !!}
								</div>
								@endif


							</div>
							@php
							$index++
							@endphp
							@endforeach

							<button class='btn btn-lg btn-success' id="to_settimana"><i class="fas fa-angle-double-right"></i> Avanti</button>

						</div>

						@if(count($weeks)>0)
						<div class="tab-pane fade" id="nav-settimanali" role="tabpanel" aria-labelledby="nav-settimanali-tab" style="margin-top: 20px;">
							@foreach($weeks as $w)
							<?php
							$specs = (new EventSpec)
							->select('event_specs.id_type', 'event_specs.hidden', 'event_specs.id', 'event_specs.label', 'event_specs.descrizione', 'event_specs.valid_for', 'event_specs.price', 'event_specs.acconto', 'event_specs.obbligatoria')
							->where([['id_event', $event->id], ['event_specs.general', 0]])
							->orderBy('event_specs.ordine', 'ASC')
							->get();
							?>

							@if(count($specs)>0)
							<h2>Settimana {{$loop->index+1}} - dal {{$w->from_date}} al {{$w->to_date}}</h2>
							@if($w->descrizione != null && $w->descrizione != '')
							<p style="font-size: 20px;"><b>{{ $w->descrizione }}</b></p>
							@endif
							@endif

							@foreach($specs as $spec)
							<?php
							$valid = json_decode($spec->valid_for, true);
							$price = json_decode($spec->price, true);
							$acconto = json_decode($spec->acconto, true);
							if(count($price)==0) $price[$w->id]=0;
							if(count($acconto)==0) $acconto[$w->id]=0;
							$txt_obbligatoria = "";
							if($spec->obbligatoria){
								$txt_obbligatoria = "<i style='color: red'>richiesto</i>";
							}
							?>
							@if($valid[$w->id]==1)
							<div class="form-row" style="{!! (($spec->hidden && Auth::user()->hasRole('user'))?'display:none':'display:') !!}">
								{!! Form::hidden('id_spec['.$index.']', $spec->id) !!}
								{!! Form::hidden('id_week['.$index.']', $w->id) !!}

								<!-- Nome e valore della specifica -->
								<div class="form-group col">
									{!! Form::label($spec->id, $spec->label) !!} {!! $txt_obbligatoria !!}
									@if(strlen($spec->descrizione)>0)
									<p> {{$spec->descrizione}} </p>
									@endif


									@if($spec->id_type > 0)
									{!! Form::select('specs['.$index.']', TypeSelect::where('id_type', $spec->id_type)->orderBy('ordine', 'ASC')->pluck('option', 'id'), '', ['class' => 'form-control', 'placeholder'=>'Seleziona un\'opzione', ($spec->obbligatoria==1)?'required':''])!!}
									@else
									@if($spec->id_type == Type::TEXT_TYPE)
									{!! Form::text('specs['.$index.']', '', ['class' => 'form-control', ($spec->obbligatoria==1)?'required':'']) !!}
									@elseif($spec->id_type == Type::BOOL_TYPE)
									{!! Form::hidden('specs['.$index.']', 0) !!}
									{!! Form::checkbox('specs['.$index.']', 1, '', ['class' => 'form-control']) !!}
									@elseif($spec->id_type == Type::NUMBER_TYPE)
									{!! Form::number('specs['.$index.']', '', ['class' => 'form-control', ($spec->obbligatoria==1)?'required':'']) !!}
									@elseif($spec->id_type == Type::DATE_TYPE)
									{!! Form::text('specs['.$index.']', '', ['class' => 'form-control date', ($spec->obbligatoria==1)?'required':'']) !!}
									@endif
									@endif


								</div>

								<!--  COSTO -->
								<div class="form-group col-2">
									{!! Form::label('costo['.$index.']', "Costo") !!}
									@if(strlen($spec->descrizione)>0)
									<p>&nbsp;</p>
									@endif

									@if(Auth::user()->hasRole('user'))
									{!! Form::hidden('costo['.$index.']', $price[$w->id]) !!}
									{{ number_format(floatval($price[$w->id]), 2, ',', '') }}€
									@else
									{!! Form::number('costo['.$index.']', $price[$w->id], ['class' => 'form-control', 'step' => '0.1']) !!}
									@endif
								</div>

								<!--  ACCONTO -->
								<div class="form-group col-2">
									{!! Form::label('acconto['.$index.']', "Acconto") !!}
									@if(strlen($spec->descrizione)>0)
									<p>&nbsp;</p>
									@endif
									@if(Auth::user()->hasRole('user'))
									{!! Form::hidden('acconto['.$index.']', $acconto[$w->id]) !!}
									{{ number_format(floatval($acconto[$w->id]), 2, ',', '') }}€
									@else
									{!! Form::number('acconto['.$index.']', $acconto[$w->id], ['class' => 'form-control', 'step' => '0.1']) !!}
									@endif
								</div>
								<!-- PAGATO  -->
								@if(Auth::user()->hasRole('user'))
								{!! Form::hidden('pagato['.$index.']', 0) !!}
								@else
								<div class="form-group col-2">
									{!! Form::label('pagato['.$index.']', "Pagato") !!}
									@if(strlen($spec->descrizione)>0)
									<p>&nbsp;</p>
									@endif
									{!! Form::hidden('pagato['.$index.']', 0) !!}
									{!! Form::checkbox('pagato['.$index.']', 1, false, ['class' => 'form-control']) !!}
								</div>
								@endif
							</div>
							@php
							$index++
							@endphp
							@endif <!-- endid valid  -->
							@endforeach <!-- end foreach specifiche  -->

							@endforeach <!-- end foreach settimane  -->

							<button class='btn btn-lg btn-success' id="to_salva"><i class="fas fa-angle-double-right"></i> Avanti</button>
						</div>
						@endif

						@else
						<?php
						// se arrivo qui, ho una sola specifica per tutto l'evento, e questa è bool
						$spec = EventSpec::select()
			      ->where([['id_event', $event->id], ['id_type', Type::BOOL_TYPE]])
						->first();

						$price = json_decode($spec->price, true);
						 ?>
						{!! Form::hidden('id_spec[0]', $spec->id) !!}
						{!! Form::hidden('id_week[0]', 0) !!}
						{!! Form::hidden('specs[0]', 1) !!}
						{!! Form::hidden('costo[0]', $price[0]) !!}
						{!! Form::hidden('acconto[0]', 0) !!}
						{!! Form::hidden('pagato[0]', 0) !!}

						@endif <!-- Controllo se l'evento ha una sola specifica -->


						<div class="tab-pane fade @if($event->isOneSpecEvent() && !$event->select_famiglia) show active @endif" id="nav-salva" role="tabpanel" aria-labelledby="nav-salva-tab" style="margin-top: 20px;">
							@if(config('app.privacy.gdpr.iscrizione.mostra'))
							<h3 style="text-align: center">
								{!! \App\Config::render(config('app.privacy.gdpr.titolo'), ['nome_evento' => $event->nome, 'nome_parrocchia' => $oratorio->nome_parrocchia]) !!}
							</h3>
							{!! \App\Config::render(config('app.privacy.gdpr.testo'), ['nome_evento' => $event->nome, 'nome_parrocchia' => $oratorio->nome_parrocchia, 'nome_diocesi' => $oratorio->nome_diocesi, 'indirizzo_parrocchia' => $oratorio->indirizzo_parrocchia, 'email_parrocchia' => $oratorio->email]) !!}

							<div class="form-row">
								<div class="form-group col" style="text-align: center">
									{!! Form::label('consenso_affiliazione', 'Esprimiamo il consenso') !!}
									{!! Form::radio('consenso_affiliazione', 1, null, ['class' => 'form-control', config('app.privacy.gdpr.iscrizione.obbligatorio')==1?'required':'']) !!}
								</div>
								<div class="form-group col" style="text-align: center">
									{!! Form::label('consenso_affiliazione', 'Neghiamo il consenso') !!}
									{!! Form::radio('consenso_affiliazione', 0, null, ['class' => 'form-control', config('app.privacy.gdpr.iscrizione.obbligatorio')==1?'required':'']) !!}
								</div>
							</div>
							@else
							{!! Form::hidden('consenso_affiliazione', 0) !!}
							@endif

							@if(config('app.privacy.riservatezza.iscrizione.mostra'))
							<h3 style="text-align: center">
								{!! \App\Config::render(config('app.privacy.riservatezza.titolo'), ['nome_evento' => $event->nome, 'nome_parrocchia' => $oratorio->nome_parrocchia]) !!}
							</h3>
							{!! \App\Config::render(config('app.privacy.riservatezza.testo'), ['nome_evento' => $event->nome, 'nome_parrocchia' => $oratorio->nome_parrocchia, 'nome_diocesi' => $oratorio->nome_diocesi, 'indirizzo_parrocchia' => $oratorio->indirizzo_parrocchia, 'email_parrocchia' => $oratorio->email]) !!}

							<div class="form-row">
								<div class="form-group col" style="text-align: center">
									{!! Form::label('consenso_dati_sanitari', 'Esprimiamo il consenso') !!}
									{!! Form::radio('consenso_dati_sanitari', 1, null, ['class' => 'form-control', config('app.privacy.riservatezza.iscrizione.obbligatorio')==1?'required':'']) !!}
								</div>
								<div class="form-group col" style="text-align: center">
									{!! Form::label('consenso_dati_sanitari', 'Neghiamo il consenso') !!}
									{!! Form::radio('consenso_dati_sanitari', 0, null, ['class' => 'form-control', config('app.privacy.riservatezza.iscrizione.obbligatorio')==1?'required':'']) !!}
								</div>
							</div>
							@else
							{!! Form::hidden('consenso_dati_sanitari', 0) !!}
							@endif



							@if(config('app.privacy.trattamento_foto.iscrizione.mostra'))
							<h3 style="text-align: center">
								{!! \App\Config::render(config('app.privacy.trattamento_foto.titolo'), ['nome_evento' => $event->nome, 'nome_parrocchia' => $oratorio->nome_parrocchia]) !!}
							</h3>
							{!! \App\Config::render(config('app.privacy.trattamento_foto.testo'), ['nome_evento' => $event->nome, 'nome_parrocchia' => $oratorio->nome_parrocchia, 'nome_diocesi' => $oratorio->nome_diocesi, 'indirizzo_parrocchia' => $oratorio->indirizzo_parrocchia, 'email_parrocchia' => $oratorio->email]) !!}

							<p>
								Noi sottoscritti, genitori del minore oggetto di questa iscrizione:
							</p>
							<ul>
								<li><b>Padre</b>: {{ $padre != null?$padre->full_name:'' }}</li>
								<li><b>Madre</b>: {{ $madre != null?$madre->full_name:'' }}</li>
							</ul>

							<div class="form-row">
								<div class="form-group col" style="text-align: center">
									{!! Form::label('consenso_foto', 'Autorizziamo') !!}
									{!! Form::radio('consenso_foto', 1, null, ['class' => 'form-control', config('app.privacy.trattamento_foto.iscrizione.obbligatorio')==1?'required':'']) !!}
								</div>
								<div class="form-group col" style="text-align: center">
									{!! Form::label('consenso_foto', 'Non autorizziamo') !!}
									{!! Form::radio('consenso_foto', 0, null, ['class' => 'form-control', config('app.privacy.trattamento_foto.iscrizione.obbligatorio')==1?'required':'']) !!}
								</div>
							</div>

							<p>
								{{ $oratorio->nome_parrocchia }} a trattare le foto ed i video relativi a nostro/a figlio/figlia secondo le finalità
								e nei limiti indicati nel foglio informativo che ci è stato consegnato.
							</p>

							@else
							{!! Form::hidden('consenso_foto', 0) !!}
							@endif

							@if($event->firma_genitori)
							<div class="form-row" style="width: 100%; margin-top: 40px">
							  <div class="form-group col" style="height: 350px; width: 100%; text-align: center">
							    <h3>Firma padre</h3>
							    <canvas id="signature_padre-pad" class="signature-pad"></canvas>
							    {!! Form::hidden('signature_padre', null, ['id' => 'signature_padre']) !!}
							  </div>
							</div>

							<div class="form-row" style="width: 100%; margin-top: 40px">
							  <div class="form-group col" style="height: 350px; width: 100%; text-align: center">
							    <h3>Firma madre</h3>
							    <canvas id="signature_madre-pad" class="signature-pad"></canvas>
							    {!! Form::hidden('signature_madre', null, ['id' => 'signature_madre']) !!}
							  </div>
							</div>
							@endif


							<button class='btn btn-lg btn-success' type="submit"><i class="far fa-save"></i> Salva iscrizione</button>
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
var form = document.getElementById("prova");
form.noValidate = true;

var canvas_padre = document.getElementById("signature_padre-pad");
var canvas_madre = document.getElementById("signature_madre-pad");
var signaturePad_padre;
var signaturePad_madre;

function resizeCanvas(){
  var ratio =  Math.max(window.devicePixelRatio || 1, 1);
  canvas_padre.width = 1000 * ratio;
  canvas_padre.height = 300 * ratio;
  canvas_padre.getContext("2d").scale(ratio, ratio);
  canvas_madre.width = 1000 * ratio;
  canvas_madre.height = 300 * ratio;
  canvas_madre.getContext("2d").scale(ratio, ratio);
}

form.onsubmit = function(e) {
  e.preventDefault();
  this.reportValidity();
  if(this.checkValidity()) return form.submit();
  alert('Alcuni campi obbligatori non sono stati compilati!');
}


$('#to_settimana').on('click', function (e) {
	e.preventDefault();
	if("{{ count($weeks) }}" > 0){
		$('#nav-tab a[href="#nav-settimanali"]').tab('show')
	}else{
		$('#nav-tab a[href="#nav-salva"]').tab('show')
	}
});

$('#to_salva').on('click', function (e) {
	e.preventDefault();
	$('#nav-tab a[href="#nav-salva"]').tab('show')
});

$('#to_general').on('click', function (e) {
	e.preventDefault();
	$('#nav-tab a[href="#nav-generali"]').tab('show')
});

$(document).ready(function(){
  $('.date').datetimepicker({
    locale: 'it',
    sideBySide: true,
    format: 'DD/MM/YYYY'
  });

	if("{{$event->firma_genitori}}"){
		signaturePad_padre = new SignaturePad(canvas_padre, {
	    onEnd: function () {
	      $("#signature_padre-pad").val(signaturePad_padre.toDataURL());
	    }
	  });
	  signaturePad_madre = new SignaturePad(canvas_madre, {
	    onEnd: function () {
	      $("#signature_madre-pad").val(signaturePad_madre.toDataURL());
	    }
	  });

	  window.addEventListener("resize", resizeCanvas);
	  resizeCanvas();
	}



});

</script>
@endpush
