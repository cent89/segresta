<?php

namespace Modules\Attributo\Entities;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Session;

class AttributoUser extends Model implements Auditable
{
  use \OwenIt\Auditing\Auditable;

  protected $fillable = ['id_user', 'id_attributo', 'valore'];

  public function transformAudit(array $data): array
  {
    if (Session::has('session_oratorio')) {
      $data['id_oratorio'] = Session::get('session_oratorio');
    }

    return $data;
  }
}
