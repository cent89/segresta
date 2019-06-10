<?php

namespace Modules\Event\Entities;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Session;

class EventSpecValue extends Model implements Auditable
{
  use \OwenIt\Auditing\Auditable;

  protected $fillable = ['id_eventspec', 'valore', 'id_subscription', 'id_week', 'costo', 'pagato', 'acconto'];

  public function transformAudit(array $data): array
  {
    if (Session::has('session_oratorio')) {
      $data['id_oratorio'] = Session::get('session_oratorio');
    }

    return $data;
  }
}
