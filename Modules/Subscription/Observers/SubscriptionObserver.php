<?php

namespace Modules\Subscription\Observers;

use Modules\Subscription\Entities\Subscription;


class SubscriptionObserver
{
  public function created(Subscription $subscription)
  {

  }

  public function creating(Subscription $subscription)
  {
    $max_numero = Subscription::where('id_event', $subscription->id_event)->max('numero');
    if($max_numero == null){
      $subscription->numero = 1;
    }else{
      $subscription->numero = intval($max_numero) + 1;
    }
  }

  /**
  * Handle the commessa "updated" event.
  *
  * @param  \App\Subscription  $commessa
  * @return void
  */
  public function updated(Subscription $subscription)
  {
    //
  }

  /**
  * Handle the commessa "deleted" event.
  *
  * @param  \App\Commessa  $commessa
  * @return void
  */
  public function deleted(Subscription $subscription)
  {
    //
  }

  /**
  * Handle the commessa "restored" event.
  *
  * @param  \App\Commessa  $commessa
  * @return void
  */
  public function restored(Subscription $subscription)
  {
    //
  }

  /**
  * Handle the commessa "force deleted" event.
  *
  * @param  \App\Commessa  $commessa
  * @return void
  */
  public function forceDeleted(Subscription $subscription)
  {
    //
  }
}
