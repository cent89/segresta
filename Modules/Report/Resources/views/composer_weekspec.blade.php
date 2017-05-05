<?php
use App\EventSpec;
use App\Week;
use App\Group;
use App\Type;
use App\TypeSelect;
use App\Attributo;
?>

@extends('layouts.app')

@section('content')

<div class="container" style="">
	<div class="row">
		<h1>Report iscrizioni settimanale</h1>
		<p>Attraverso questa pagina puoi generare il report delle iscrizioni dell'evento corrente. Oltre a quelle settimanali, puoi scegliere quali informazioni generali inserire nel report. Puoi anche settare un filtro su uno o più campi, mettendo una spunta nella colonna "Filtra" e indicando il valore del filtro.</p>
		<hr>
	</div>
    <div class="row" style="margin-left: 0px; margin-right: 0px;">
        <div class="">
		<div class="panel panel-default" style="">
		<div class="panel-heading">Stampa report iscrizioni</div>
		<div class="panel-body">			
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
                    echo "<b>Settimana dal ".$week->from_date." al ". $week->to_date."</b><br>";
                    //get campi per ogni settimana
                    $specs = (new EventSpec)
					->select('event_specs.id_type', 'event_specs.hidden', 'event_specs.id', 'event_specs.label', 'event_specs.descrizione', 'event_specs.valid_for')
					->where([['id_event', $id_event], ['event_specs.general', 0]])
					->get();
                    ?>
                    <table class='testgrid'>
                    <tr>
                    <th>Check</th>
                    <th style="width: 60%;">Campo</th>
                    <th>Filtra?</th>
                    <th>Valore del filtro</th>
                    </tr>
                    
                    @foreach($specs as $spec)
                    	<?php
					$valid = json_decode($spec->valid_for, true);
					?>
					@if($valid[$week->id]==1)
					<tr>
					<td><input name="week[{{$w}}][{{$loop->index}}]" value="{{$spec->id}}" type="checkbox"/></td>
					<td>{{$spec->label}}</td>
					<td><input type='hidden' name="week_filter[{{$w}}][{{$loop->index}}]" value="0"/>
					<input name="week_filter[{{$w}}][{{$loop->index}}]" value="1" type="checkbox"/></td>
					<td>
						<input name="week_filter_id[{{$w}}][{{$loop->index}}]" type="hidden" value="{{$spec->id}}" />
					
					@if($spec->id_type>0)
						{!! Form::select('week_filter_value['.$w.']['.$loop->index.']', TypeSelect::where('id_type', $spec->id_type)->orderBy('ordine', 'ASC')->pluck('option', 'id'), '', ['class' => 'form-control'])!!}
					@else
						@if($spec->id_type==-1)
							{!! Form::text('week_filter_value['.$w.']['.$loop->index.']', '', ['class' => 'form-control']) !!}
						@elseif($spec->id_type==-2)
							{!! Form::hidden('week_filter_value['.$w.']['.$loop->index.']', 0) !!}
							{!! Form::checkbox('week_filter_value['.$w.']['.$loop->index.']', 1, '', ['class' => 'form-control']) !!}
						@elseif($spec->id_type==-3)
							{!! Form::number('week_filter_value['.$w.']['.$loop->index.']', '', ['class' => 'form-control']) !!}
						@elseif($spec->id_type==-4)
							{!! Form::select('week_filter_value['.$w.']['.$loop->index.']', Group::where('id_oratorio', Session::get('session_oratorio'))->orderBy('nome', 'ASC')->pluck('nome', 'id'), '', ['class' => 'form-control'])!!}				
						@endif
					@endif
					
					</td>
					</tr>
					@endif
				@endforeach				
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
            	<table class='testgrid'>
                    <tr>
                    <th>Check</th>
                    <th style="width: 60%;">Specifica</th>
                    <th>Filtra?</th>
                    <th>Valore del filtro</th>
                    </tr>
                    
                    @foreach($specs as $spec)
                    	<tr>
					<td><input name="spec[{{$loop->index}}]" value="{{$spec->id}}" type="checkbox"/></td>
					<td>{{$spec->label}}</td>
					<td><input type='hidden' name="spec_filter[{{$loop->index}}]" value="0"/>
					<input name="spec_filter[{{$loop->index}}]" value="1" type="checkbox"/></td>
					<td>
						<input name="spec_filter_id[{{$loop->index}}]" type="hidden" value="{{$spec->id}}" />
					
					@if($spec->id_type>0)
						{!! Form::select('spec_filter_value['.$loop->index.']', TypeSelect::where('id_type', $spec->id_type)->orderBy('ordine', 'ASC')->pluck('option', 'id'), '', ['class' => 'form-control'])!!}
					@else
						@if($spec->id_type==-1)
							{!! Form::text('spec_filter_value['.$loop->index.']', '', ['class' => 'form-control']) !!}
						@elseif($spec->id_type==-2)
							{!! Form::hidden('spec_filter_value['.$loop->index.']', 0) !!}
							{!! Form::checkbox('spec_filter_value['.$loop->index.']', 1, '', ['class' => 'form-control']) !!}
						@elseif($spec->id_type==-3)
							{!! Form::number('spec_filter_value['.$loop->index.']', '', ['class' => 'form-control']) !!}
						@elseif($spec->id_type==-4)
							{!! Form::select('spec_filter_value['.$loop->index.']', Group::where('id_oratorio', Session::get('session_oratorio'))->orderBy('nome', 'ASC')->pluck('nome', 'id'), '', ['class' => 'form-control'])!!}				
						@endif
					@endif
					
					</td>
					</tr>
                    @endforeach
			</table>
				
			<h4>Passo 4: In quale formato vuoi il tuo report?</h4>
			{!! Form::radio('pdf', 'pdf', true) !!} PDF
			{!! Form::submit('Genera!', ['class' => 'btn btn-primary form-control']) !!}
			{!! Form::close() !!}
		</div>
			
			
			
           		
                   
                </div>
            </div>
            
    </div>
</div>
       
        
<?php

?>
@endsection
	<script>
	$('link[rel=stylesheet]').remove();
</script>