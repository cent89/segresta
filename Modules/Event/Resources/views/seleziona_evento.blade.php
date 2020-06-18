
<?php
use Modules\Event\Entities\Event;

$events = Event::orderBy('created_at', 'DESC');
?>

@if($events->count() > 0)
Seleziona l'evento a cui iscrivere l'utente:<br><br>
@foreach($events->get() as $event)
<div class="row justify-content-center">
  <div class="col-6" >
    {{ Form::open(['method' => 'POST', 'route' => ['subscribe.create']]) }}
    {{ Form::hidden('id_user', $user->id) }}
    {{ Form::hidden('id_event', $event->id) }}
    <button class='btn btn-primary btn-block' type='submit'><i class='far fa-file-pdf'></i> {{ $event->nome }}</button>
    {{ Form::close() }}
  </div>
</div>
@endforeach
@else
Nessun evento disponibile!
@endif
