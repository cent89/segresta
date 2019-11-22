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
				<h1><i class='far fa-file-alt'></i> Report iscrizioni settimanale</h1>

				<p class="lead">
					Attraverso questa pagina puoi generare il report delle iscrizioni dell'evento corrente. Oltre a quelle settimanali,
					puoi scegliere quali informazioni generali inserire nel report. Puoi anche settare un filtro su uno o più campi, mettendo una spunta nella colonna "Filtra"
					e indicando il valore del filtro.<br>
					Puoi decidere l'ordine con cui mostrare le specifiche (le colonne della tabella del report) semplicemente trascinando le righe delle tabelle delle settimane.
				</p>
				<hr>
			</div>
		</div>
	</div>

	<div class="row justify-content-center" style="margin-top: 20px;">
		<div class="col">
			<div class="card">
				<div class="card-body">
					{!! Form::open(['route' => 'report.gen_weekspec']) !!}
					<?php
					$id_event=Session::get('work_event');
					?>
					<div style="float: left; width: 100%; padding: 5px;">
						<h4>Passo 1: Scegli le infomazioni <b>riguardanti le settimane</b> da inserire nel report:</h4>
						<?php
						$weeks = Week::where('id_event', $id_event)->orderBy('from_date', 'ASC')->get();
						$w=0;

						foreach($weeks as $week){
							$index = 0;
							echo "<b>Settimana dal ".$week->from_date." al ". $week->to_date."</b><br>";
							//get campi per ogni settimana
							$specs = (new EventSpec)
							->select('event_specs.id_type', 'event_specs.hidden', 'event_specs.id', 'event_specs.label', 'event_specs.descrizione', 'event_specs.valid_for')
							->where([['id_event', $id_event], ['event_specs.general', 0]])
							->get();
							?>
							<table class='table table-bordered draggable'>
								<tr>
									<th>Check</th>
									<th style="width: 60%;">Campo</th>
									<th>Filtra?</th>
									<th>Valore del filtro</th>
								</tr>
								<tbody>


									@foreach($specs as $spec)
									<?php
									$valid = json_decode($spec->valid_for, true);
									?>
									@if($valid[$week->id]==1)
									<tr>
										<td><input name="week[{{$w}}][]" value="{{$spec->id}}" type="checkbox"/></td>
										<td>{{$spec->label}}</td>
										<td>
											<input name="week_filter[{{$w}}][{{$loop->index}}]" value="0" type="hidden"/>
											<input name="week_filter[{{$w}}][{{$loop->index}}]" value="{{$spec->id}}" type="checkbox" class="form-control" onchange="disable_select(this, 'week_filter_value_{{$w}}_{{$index}}', true)"/>
										</td>
										<td>

											{!! Form::hidden('week_filter_value['.$w.']['.$loop->index.']', 0) !!}

											@if($spec->id_type>0)
											{!! Form::select('week_filter_value['.$w.']['.$loop->index.']', TypeSelect::where('id_type', $spec->id_type)->orderBy('ordine', 'ASC')->pluck('option', 'id'), '', ['class' => 'form-control', 'disabled' => 'true', 'id' => "week_filter_value_".$w."_".$index])!!}
											@else
											@if($spec->id_type==-1)
											{!! Form::text('week_filter_value['.$w.']['.$loop->index.']', '', ['class' => 'form-control', 'disabled' => 'true', 'id' => "week_filter_value_".$w."_".$index]) !!}
											@elseif($spec->id_type==-2)
											{!! Form::hidden('week_filter_value['.$w.']['.$loop->index.']', 0) !!}
											{!! Form::checkbox('week_filter_value['.$w.']['.$loop->index.']', 1, '', ['class' => 'form-control', 'disabled' => 'true', 'id' => "week_filter_value_".$w."_".$index]) !!}
											@elseif($spec->id_type==-3)
											{!! Form::number('week_filter_value['.$w.']['.$loop->index.']', '', ['class' => 'form-control', 'disabled' => 'true', 'id' => "week_filter_value_".$w."_".$index]) !!}
											@endif
											@endif

										</td>
									</tr>
									<?php $index++; ?>
									@endif

									@endforeach
								</tbody>
							</table>
							<br>
							<?php
							$w++;
						}
						?>

						<h4>Passo 2: Scegli quali altre colonne, <b>prese dalle Specifiche generali</b>, inserire nel report</h4>
						<?php
						$specs = (new EventSpec)
						->select('event_specs.label', 'event_specs.id', 'event_specs.id_type as id_type')
						->where([['event_specs.id_event', $id_event], ['event_specs.general', 1]])
						->orderBy('event_specs.label', 'asc')
						->get();
						?>
						<table class='table table-bordered draggable'>
							<tr>
								<th>Check</th>
								<th style="width: 60%;">Specifica</th>
								<th>Filtra?</th>
								<th>Valore del filtro</th>
							</tr>
							<tbody>

								@foreach($specs as $spec)
								<tr>
									<td><input name="spec[]" value="{{$spec->id}}" type="checkbox"/></td>
									<td>{{$spec->label}}</td>
									<td>
										<input name="spec_filter[{{$loop->index}}]" value="0" type="hidden"/>
										<input name="spec_filter[{{$loop->index}}]" value="{{$spec->id}}" type="checkbox" class="form-control" onchange="disable_select(this, 'spec_filter_value_{{$loop->index}}', true)"/></td>
										<td>

											{!! Form::hidden('spec_filter_value['.$loop->index.']', 0) !!}

											@if($spec->id_type>0)
											{!! Form::select('spec_filter_value['.$loop->index.']', TypeSelect::where('id_type', $spec->id_type)->orderBy('ordine', 'ASC')->pluck('option', 'id'), '', ['class' => 'form-control', 'disabled' => 'true', 'id' => "spec_filter_value_".$loop->index])!!}
											@else
											@if($spec->id_type==-1)
											{!! Form::text('spec_filter_value['.$loop->index.']', '', ['class' => 'form-control', 'disabled' => 'true', 'id' => "spec_filter_value_".$loop->index]) !!}
											@elseif($spec->id_type==-2)
											{!! Form::hidden('spec_filter_value['.$loop->index.']', 0) !!}
											{!! Form::checkbox('spec_filter_value['.$loop->index.']', 1, '', ['class' => 'form-control', 'disabled' => 'true', 'id' => "spec_filter_value_".$loop->index]) !!}
											@elseif($spec->id_type==-3)
											{!! Form::number('spec_filter_value['.$loop->index.']', '', ['class' => 'form-control', 'disabled' => 'true', 'id' => "spec_filter_value_".$loop->index]) !!}
											@endif
											@endif

										</td>
									</tr>
									@endforeach
								</tbody>
							</table>





							<h4>Passo 3: Scegli le infomazioni <b>anagrafiche degli utenti</b> da inserire nel report:</h4>

							<table class='table table-bordered' id=''>
								<thead><tr>
									<th>Check</th>
									<th style='width: 60%;'>Specifica</th>
									<th>Filtra?</th>
									<th>Valore del filtro:</th>
								</tr></thead>

								<?php

								$c = [];
								$c[] = ['id'=>'email', 'label'=>'Email'];
								$c[] = ['id'=>'cell_number', 'label'=>'Numero Cell.'];
								$c[] = ['id'=>'nato_il', 'label'=>'Data di nascita'];
								$c[] = ['id'=>'nato_a', 'label'=>'Luogo di nascita'];
								$c[] = ['id'=>'sesso', 'label'=>'Sesso'];
								$c[] = ['id'=>'residente', 'label'=>'Residenza'];
								$c[] = ['id'=>'via', 'label'=>'Indirizzo'];
								$c[] = ['id'=>'patologie', 'label'=>'Patologie'];
								$c[] = ['id'=>'allergie', 'label'=>'Allergie'];
								$c[] = ['id'=>'note', 'label'=>'Note'];

								?>

								@foreach($c as $column)
								<tr>
									<td><input name="spec_user[{{$loop->index}}]" value="{{$column['id']}}" type="checkbox"/></td>
									<td>{{$column['label']}}</td>
									<td><input type='hidden' name="user_filter[{{$loop->index}}]" value="0"/>
										<input name="user_filter[{{$loop->index}}]" value="1" type="checkbox" class="form-control" onchange="disable_select(this, 'user_filter_value_{{$loop->index}}', true)"/></td>
										<td>
											<input name="user_filter_id[{{$loop->index}}]" type="hidden" value="{{$column['id']}}"/>

											{!! Form::text('user_filter_value['.$loop->index.']', '', ['class' => 'form-control', 'disabled' => 'true', 'id' => "user_filter_value_".$loop->index]) !!}

										</td>
									</tr>
									@endforeach
								</table><br>


								<h4>Passo 4: Scegli gli attributi degli utenti da inserire nel report:</h4>

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
										<td><input name="att_spec[{{$loop->index}}]" value="{{$a->id}}" type="checkbox"/></td>
										<td>{{$a->nome}}</td>
										<td>
											<input type="hidden" name="att_filter[{{$loop->index}}]" value="0"/>
											<input name="att_filter[{{$loop->index}}]" value="1" type="checkbox" class="form-control" onchange="disable_select(this, 'att_filter_value_{{$loop->index}}', true)"/>
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




								<h4>Passo 5: In quale formato vuoi il tuo report?</h4>
								{!! Form::radio('format', 'html', false) !!} HTML
								{!! Form::radio('format', 'pdf', true) !!} PDF
								{!! Form::radio('format', 'excel', false) !!} Excel
								{!! Form::radio('format', 'save', false) !!} Salva come modello

								@if(Module::find('famiglia') != null && Module::find('famiglia')->enabled())
								<br><br>
								<h4>Passo 6: Aggiungere le informazioni su Padre e Madre?</h4>
								{!! Form::radio('stampa_famiglia', 1, false) !!} SI
								{!! Form::radio('stampa_famiglia', 0, true) !!} NO
								@else
                {!! Form::hidden('stampa_famiglia', '0') !!}
                @endif

								<h4>Passo 7: Mostra solo gli utenti che hanno pagato tutte le specifiche</h4>
								{!! Form::radio('solo_pagato', 1, true) !!} SI
								{!! Form::radio('solo_pagato', 0, false) !!} NO

								<br><br>
								Mostra i filtri applicati nella parte alta della pagina
								{!! Form::hidden('mostra_fitri', '0') !!}
								{!! Form::checkbox('mostra_fitri', '1', true) !!}
								<br><br>
								{!! Form::submit('Genera!', ['class' => 'btn btn-primary form-control']) !!}

							</div>
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

			$(".draggable tbody").sortable({
				stop: function(event, ui){
				}
			}).disableSelection();

		});
		</script>
		@endsection
