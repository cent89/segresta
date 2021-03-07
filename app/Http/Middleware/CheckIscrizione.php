<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Modules\Subscription\Entities\Subscription;
use Modules\Famiglia\Entities\ComponenteFamiglia;

class CheckIscrizione
{
  /**
  * Handle an incoming request.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \Closure  $next
  * @return mixed
  */
  public function handle($request, Closure $next)
  {
    if(Auth::user()->can('edit-admin-iscrizioni')){
      return $next($request);
    }

    // Controllo se l'iscrizione è dell'utente loggato o famigliari
    $iscrizione = Subscription::find($request->id_subscription);
    $componenti = ComponenteFamiglia::getComponenti(Auth::user()->id, false);
    foreach($componenti as $componente){
      if($componente->id == $iscrizione->id_user){
        return $next($request);
      }
    }

    return redirect('home');
  }
}
