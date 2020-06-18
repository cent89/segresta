
<?php
use Modules\Event\Entities\Event;
use Modules\Modulo\Entities\Modulo;

$event = Event::find($subscription->id_event);
$array_moduli = json_decode($event->id_moduli);
$moduli = Modulo::whereIn('id', $array_moduli)->orderBy('label', 'ASC');
?>

@if($moduli->count() > 0)
Seleziona il modulo da stampare:<br><br>
@foreach($moduli->get() as $modulo)
  <div class="row justify-content-center">
<div class="col-6" >
  {{ Form::open(['method' => 'GET', 'target' => '_blank', 'route' => ['subscription.print', $subscription->id]]) }}
  {{ Form::hidden('id_modulo', $modulo->id) }}
  <button class='btn btn-primary btn-block' type='submit'><i class='far fa-file-pdf'></i> Stampa {{ $modulo->label }}</button>
  {{ Form::close() }}
</div>
</div>
@endforeach
@else
Nessun modulo disponibile!
@endif
