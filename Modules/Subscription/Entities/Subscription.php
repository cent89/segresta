<?php

namespace Modules\Subscription\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Session;

class Subscription extends Model implements  Auditable
{
  use \OwenIt\Auditing\Auditable;

  protected $fillable = ['id_user', 'id_event', 'confirmed', 'type', 'consenso_affiliazione', 'consenso_foto', 'consenso_dati_sanitari'];

  public function getCreatedAtAttribute($value){
    return Carbon::parse($value)->format('d/m/Y');
  }

  public function transformAudit(array $data): array
  {
    if (Session::has('session_oratorio')) {
      $data['id_oratorio'] = Session::get('session_oratorio');
    }

    return $data;
  }
}
