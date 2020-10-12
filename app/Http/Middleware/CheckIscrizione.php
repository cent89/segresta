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
    $padre = ComponenteFamiglia::getPadre(Auth::user()->id);
    $madre = ComponenteFamiglia::getMadre(Auth::user()->id);
    if($iscrizione->id_user == Auth::user()->id || ($padre != null && $iscrizione->id_user == $padre->id) || ($madre != null && $iscrizione->id_user == $madre->id)){
      return $next($request);
    }

    return redirect('home');
  }
}
