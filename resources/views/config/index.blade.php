<?php
use App\Config;

?>
@extends('layouts.app')


@section('pageTitle')
<div class="pageTitle">
  <h1><i class="fas fa-cogs"></i> Configurazione</h1>
  <p>|| Parametri di configurazione della piattaforma</p>
</div>
@endsection

@section('content')
<style>
thead input{
  width: 100%;
}
thead select{
  width: 100%;
}

</style>
<div class="container">

  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          @if(Session::has('flash_message'))
          <div class="alert alert-success">
            {{ Session::get('flash_message') }}
          </div>
          @endif

          {!! Form::open(['route' => 'config.save', 'files' => true]) !!}
          @foreach(Config::groupBy('group')->pluck('group')->toarray() as $group)
          <h2>{{ $group }}</h2>

          @foreach(Config::where('group', $group)->orderBy('order', 'ASC')->get() as $config)
          <div class="form-row">
            <div class="form-group col">
              {!! Form::hidden('key['.$config->key.']', $config->key) !!}
              {!! Form::label('key['.$config->key.']', $config->display_name) !!}
              @switch($config->type)
              @case('file')
              {!! Form::file('value['.$config->key.']', null, ['class' => 'form-control']) !!}
              @break
              @case('boolean')
              <br>
              {!! Form::radio('value['.$config->key.']', 1, $config->value==true, ['class' => '']) !!} SI
              {!! Form::radio('value['.$config->key.']', 0, $config->value==false, ['class' => '']) !!} NO
              @break
              @case('textarea')
              {!! Form::textarea('value['.$config->key.']', $config->value, ['class' => 'form-control']) !!}
              @break
              @case('number')
              {!! Form::number('value['.$config->key.']', $config->value, ['class' => 'form-control']) !!}
              @break
              @case('hours')
              <br>
              @foreach(range(0,24) as $h)
              {!! Form::checkbox('value['.$config->key.'][]', $h, in_array($h, json_decode($config->value)), ['class' => '']) !!} {{ $h}}
              @endforeach
              @break
              @default
              {!! Form::text('value['.$config->key.']', $config->value, ['class' => 'form-control']) !!}
              @endswitch
            </div>
          </div>
          @endforeach
          @endforeach

          <div class="form-row">
            <div class="form-group col">
              {!! Form::submit('Salva', ['class' => 'btn btn-primary form-control']) !!}
            </div>

            <div class="form-group col">
              {!! Form::submit('Test invio email', ['name' => 'test_email', 'class' => 'btn btn-primary form-control']) !!}
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


$(document).ready(function(){
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': '{{csrf_token()}}'
    }
  });


});



</script>
@endpush
