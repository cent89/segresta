<?php
use Modules\Event\Entities\Event;
use Modules\Oratorio\Entities\Oratorio;
?>



<div class="container">
	@if(!Auth::guest() && (Auth::user()->can('edit-event') || Auth::user()->can('edit-admin-iscrizioni')) )
	<?php
	$user = Auth::user();
	$oratorio = null;
	$event = null;
	if(Session::get('session_oratorio') != null){
		$oratorio = Oratorio::where('id', Session::get('session_oratorio'))->first();
	}

	if(Session::get('work_event') != null){
		$event = Event::where('id', Session::get('work_event'))->first();
	}else if($oratorio != null && $user->last_id_event != null){
		$event = Event::where('id', $user->last_id_event)->first();
		if($event != null) Session::put('work_event', $event->id);
	}

	$buttons_1 = array(
		["label" => "Specifiche evento",
		"desc" => "",
		"url" => "eventspecs.index",
		"class" => "btn-primary",
		"icon" => ""],
		["label" => "Iscrizioni",
		"desc" => "",
		"url" => "subscription.index",
		"class" => "btn-primary",
		"icon" => ""]
	);



	$buttons_2 = array(
		["label" => "Seleziona evento",
		"desc" => "",
		"url" => "events.index",
		"class" => "btn-primary",
		"icon" => ""]
	);
	$buttons = array();

	// $event = null;
	// if(Session::get('work_event') != null){
	// 	$event = Event::find(Session::get('work_event'));
	// }
	?>
	<div style="height: 55px; margin-top: 10px; padding: 10px; background-color: red">
			@if($event != null &&  $event->id_oratorio == Session::get('session_oratorio'))
			<div style="padding: 5px; float:left; margin-right: 5px; background-color: #FF6347;" >
				<b>{{$event->nome}}</b>
				 - <i>{{ (strlen(strip_tags($event->descrizione)) > 60) ? substr(strip_tags($event->descrizione), 0, 60) . '...' : strip_tags($event->descrizione) }}</i>
			 </div>
			<?php $buttons=$buttons_1; ?>

				@else
				<div style="float:left; margin-right: 5px;">Non hai specificato nessun evento!</div>
				<?php $buttons = $buttons_2; ?>
				@endif

			<div style="float:left; margin-right: 5px;"> <i class="fa fa-star" aria-hidden="true"></i>
				Accesso rapido: </div>
				@foreach ($buttons as $button)
				<div style="float:left; margin-right: 5px;">
					{!! Form::open(['route' => $button['url'], 'method' => 'GET']) !!}
					{!! Form::hidden('id_event', Session::get('work_event'), ['id' => 'id_event']) !!}
					{!! Form::submit($button['label'], ['class' => 'btn '.$button['class']]) !!}
					{{$button['desc']}}
					{!! Form::close() !!}
				</div>
				@endforeach
		</div>
		@endif
	</div>
