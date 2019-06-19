<?php
use Modules\Event\Entities\EventSpec;
use Modules\Event\Entities\Week;
use Modules\User\Entities\Group;
use Modules\Oratorio\Entities\Type;
use Modules\Oratorio\Entities\TypeSelect;
use Modules\Attributo\Entities\Attributo;
?>

@extends('layouts.app')

@section('content')

<div class="container" style="">
	<div class="row">
		<div class="col">
			<div class="card bg-transparent border-0">
				<h1><i class='far fa-file-alt'></i> Report iscrizioni generale</h1>

				<p class="lead">
					Attraverso questa pagina puoi generare il report delle iscrizioni dell'evento corrente. Oltre a quelle di base, puoi scegliere quali informazioni inserire nel report.
					Puoi anche settare un filtro a uno o più campi, mettendo una spunta nella colonna "Filtra" e indicando il valore del filtro.<br>
					Puoi decidere l'ordine con cui mostrare le specifiche (le colonne della tabella del report) semplicemente trascinando le righe della prima tabella qui sotto.
				</p>
				<hr>
			</div>
		</div>
	</div>

	<div class="row justify-content-center" style="margin-top: 20px;">
		<div class="col">
			<div class="card">
				<div class="card-body">

					<div style="width: 100%; float: left;  padding: 5px;">
						<h4>Passo 1: Scegli le infomazioni <b>riguardanti l'iscrizione</b> da inserire nel report:</h4>
						{!! Form::open(['route' => 'report.gen_eventspec']) !!}
						<?php
						$id_event=Session::get('work_event');

						$specs = (new EventSpec)
						->select('event_specs.label', 'event_specs.id', 'event_specs.id_type as id_type')
						->where([['event_specs.id_event', $id_event], ['event_specs.general', 1]])
						->orderBy('event_specs.label', 'asc')
						->get();
						?>
						<table class='table table-bordered' id='specs_table'>
							<thead><tr>
								<th>Check</th>
								<th style="width: 60%;">Specifica</th>
								<th>Filtra?</th>
								<th>Valore del filtro:</th>
							</tr></thead>
							<tbody>


								@foreach($specs as $spec)
								<tr>
									<td>
										<input name="spec_order[]" value="{{$loop->index}}" type="hidden" />
										<input name="spec[]" value="{{$spec->id}}" type="checkbox"/>
									</td>
									<td>{{$spec->label}}</td>
									<td>
										<input name="filter[{{$loop->index}}]" value="0" type="hidden" />
										<input name="filter[{{$loop->index}}]" value="{{$spec->id}}" type="checkbox" class="form-control" onchange="disable_select(this, 'filter_value_{{$loop->index}}', true)"/>
									</td>

									<td>

										{!! Form::hidden('filter_value['.$loop->index.']', 0) !!}

										@if($spec->id_type>0)
										{!! Form::select('filter_value['.$loop->index.']', TypeSelect::where('id_type', $spec->id_type)->orderBy('ordine', 'ASC')->pluck('option', 'id'), '', ['class' => 'form-control', 'disabled' => 'true', 'id' => "filter_value_".$loop->index])!!}
										@else
										@if($spec->id_type==-1)
										{!! Form::text('filter_value['.$loop->index.']', '', ['class' => 'form-control', 'disabled' => 'true', 'id' => "filter_value_".$loop->index]) !!}
										@elseif($spec->id_type==-2)
										{!! Form::checkbox('filter_value['.$loop->index.']', 1, '', ['class' => 'form-control', 'disabled' => 'true', 'id' => "filter_value_".$loop->index]) !!}
										@elseif($spec->id_type==-3)
										{!! Form::number('filter_valore['.$loop->index.']', '', ['class' => 'form-control', 'disabled' => 'true', 'id' => "filter_value_".$loop->index]) !!}
										@endif
										@endif

									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						<br>
					</div>

					<div style="width: 100%; float: left;">
						<h4>Passo 2: Scegli le infomazioni <b>anagrafiche degli utenti</b> da inserire nel report:</h4>

						<table class='table table-bordered' id='user_table'>
							<thead><tr>
								<th>Check</th>
								<th style='width: 60%;'>Specifica</th>
								<th>Filtra?</th>
								<th>Valore del filtro:</th>
							</tr></thead>
							<tbody>

								<?php

								$c = [];
								$c[] = ['id'=>'email', 'label'=>'Email'];
								$c[] = ['id'=>'cell_number', 'label'=>'Numero Cell.'];
								$c[] = ['id'=>'nato_il', 'label'=>'Data di nascita'];
								$c[] = ['id'=>'nato_a', 'label'=>'Luogo di nascita'];
								$c[] = ['id'=>'sesso', 'label'=>'Sesso'];
								$c[] = ['id'=>'residente', 'label'=>'Residenza'];
								$c[] = ['id'=>'via', 'label'=>'Indirizzo'];

								?>

								@foreach($c as $column)
								<tr>
									<td><input name="spec_user[]" value="{{$column['id']}}" type="checkbox"/></td>
									<td>{{$column['label']}}</td>
									<td>
										<input name="user_filter[]" value="1" type="checkbox" class="form-control" onchange="disable_select(this, 'user_filter_value_{{$loop->index}}', true)"/></td>
										<td>
											<input name="user_filter_id[]" type="hidden" value="{{$column['id']}}"/>

											{!! Form::text('user_filter_value[]', '', ['class' => 'form-control', 'disabled' => 'true', 'id' => "user_filter_value_".$loop->index]) !!}

										</td>
									</tr>
									@endforeach
								</tbody>
							</table><br>


							<h4>Passo 3: Scegli gli attributi degli utenti da inserire nel report:</h4>

							<table class='table table-bordered' id=''>
								<thead><tr>
									<th>Check</th>
									<th style='width: 60%;'>Attributo</th>
									<th>Filtra?</th>
									<th>Valore del filtro:</th>
								</tr></thead>
								<?php
								$attributos = Attributo::select('attributos.*')->where('attributos.id_oratorio', Session::get('session_oratorio'))->orderBy('ordine', 'ASC')->get();
								?>

								@foreach($attributos as $a)
								<tr>
									<td>
										<input name="att_spec_order[]" value="{{$loop->index}}" type="hidden" />
										<input name="att_spec[]" value="{{$a->id}}" type="checkbox"/>
									</td>
									<td>{{$a->nome}}</td>
									<td>
										<input name="att_filter[{{$loop->index}}]" value="0" type="hidden" />
										<input name="att_filter[{{$loop->index}}]" value="{{$a->id}}" type="checkbox" class="form-control" onchange="disable_select(this, 'att_filter_value_{{$loop->index}}', true)"/>
									</td>
									<td>
										@if($a->id_type>0)
										{!! Form::select('att_filter_value['.$loop->index.']', TypeSelect::where('id_type', $a->id_type)->orderBy('ordine', 'ASC')->pluck('option', 'id'), '', ['class' => 'form-control', 'disabled' => 'true', 'id' => "att_filter_value_".$loop->index])!!}
										@else
										@if($a->id_type==-1)
										{!! Form::text('att_filter_value['.$loop->index.']', '', ['class' => 'form-control', 'disabled' => 'true', 'id' => "att_filter_value_".$loop->index]) !!}
										@elseif($a->id_type==-2)
										{!! Form::hidden('att_filter_value['.$loop->index.']', 0) !!}
										{!! Form::checkbox('att_filter_value['.$loop->index.']', 1, '', ['class' => 'form-control', 'disabled' => 'true', 'id' => "att_filter_value_".$loop->index]) !!}
										@elseif($a->id_type==-3)
										{!! Form::number('att_filter_value['.$loop->index.']', '', ['class' => 'form-control', 'disabled' => 'true', 'id' => "att_filter_value_".$loop->index]) !!}
										@endif
										@endif
									</td>
								</tr>
								@endforeach
							</table><br>

							<h4>Passo 4: In quale formato vuoi il tuo report?</h4>
							{!! Form::radio('format', 'html', false) !!} HTML
							{!! Form::radio('format', 'pdf', true) !!} PDF
							{!! Form::radio('format', 'excel', false) !!} Excel
							{!! Form::radio('format', 'save', false) !!} Salva come modello

							@if(Module::find('famiglia') != null && Module::find('famiglia')->enabled())
							<br><br>
							<h4>Passo 5: Aggiungere le informazioni su Padre e Madre?</h4>
							{!! Form::radio('stampa_famiglia', 1, false) !!} SI
							{!! Form::radio('stampa_famiglia', 0, true) !!} NO
							@else
							{!! Form::hidden('stampa_famiglia', '0') !!}
							@endif

							<h4>Passo 6: Mostra solo gli utenti che hanno pagato tutte le specifiche</h4>
							{!! Form::hidden('solo_pagato', '0') !!}
							{!! Form::checkbox('solo_pagato', '1', true) !!}

							{!! Form::submit('Genera!', ['class' => 'btn btn-primary form-control']) !!}
							{!! Form::close() !!}
						</div>



					</div>
				</div>

			</div>
		</div>

		<script>

		$(document).ready(function(){
			// Drag adn Drop delle righe della tabella
			var fixHelper = function(e, ui) {
				ui.children().each(function() {
					$(this).width($(this).width());
				});
				return ui;
			};

			$("#specs_table tbody").sortable({
				stop: function(event, ui){
				}
			}).disableSelection();

		});
		</script>

		@endsection
