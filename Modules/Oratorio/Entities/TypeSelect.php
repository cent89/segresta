<?php

namespace Modules\Oratorio\Entities;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Session;

class TypeSelect extends Model implements Auditable
{
  use \OwenIt\Auditing\Auditable;

  protected $fillable = ['id_type', 'option', 'ordine'];

  public function transformAudit(array $data): array
  {
    if (Session::has('session_oratorio')) {
      $data['id_oratorio'] = Session::get('session_oratorio');
    }

    return $data;
  }
}
