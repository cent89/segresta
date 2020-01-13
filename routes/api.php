<?php

use Illuminate\Http\Request;
use Modules\User\Entities\User;
use Modules\Oratorio\Entities\Oratorio;
use Modules\Oratorio\Entities\UserOratorio;
use Modules\Event\Entities\Event;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
  return $request->user();
})->middleware('auth:api');

// Route::get('oratori', function (Request $request){
//   $oratori = Oratorio::all();
//   return response()->json($oratori);
// });

Route::post('login', function (Request $request){
  if($request->email == ''){
    return response()->json();;
  }
  $user = User::where('email', $request->email)->first();
  $result = [];
  if($user != null){
    $user_oratorio = UserOratorio::where('id_user', $user->id)->first();
    $oratorio = Oratorio::find($user_oratorio->id_oratorio);
    $result['full_name'] = $user->full_name;
    $result['nome_oratorio'] = $oratorio->nome;
    $result['email'] = $user->email;
    $result['id_oratorio'] = $oratorio->id;

    if($oratorio->logo != '' && $oratorio->logo != null){
      $result['logo_oratorio'] = url(Storage::url('public/'.$oratorio->logo));
    }else{
      $result['logo_oratorio'] = asset('/assets/logo_new_orizzontale_b.png');
    }
  }

  return response()->json($result);
});

Route::post('events', function (Request $request){
  if($request->email == '' || !$request->has('id_oratorio')){
    return response()->json();
  }

  $user = User::where('email', $request->email)->first();
  if($user == null){
    return response()->json();
  }

  $result = [];
  foreach( Event::where([['id_oratorio', $request->id_oratorio], ['active', 1]])->get() as $event){
    $r = ['nome' => $event->nome, 'id' => $event->id, 'color' => $event->color];
    $r['image'] = url(Storage::url('public/'.$event->image));
    array_push($result, $r);
  }



  return response()->json($result);
});

Route::post('event', function (Request $request){
  if($request->email == '' || !$request->has('id_oratorio')){
    return response()->json();
  }

  $user = User::where('email', $request->email)->first();
  if($user == null){
    return response()->json();
  }

  $event = Event::where('id', $request->id_evento)->first();
  $result = ['nome' => $event->nome, 'id' => $event->id, 'color' => $event->color, 'descrizione' => $event->descrizione];
  $result['image'] = url(Storage::url('public/'.$event->image));




  return response()->json($result);
});
