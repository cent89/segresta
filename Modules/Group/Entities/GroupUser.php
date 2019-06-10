<?php

namespace Modules\Group\Entities;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Session;

class GroupUser extends Model implements Auditable
{
  use \OwenIt\Auditing\Auditable;
  
  protected $fillable = ['id_user', 'id_group'];

  public function transformAudit(array $data): array
  {
    if (Session::has('session_oratorio')) {
      $data['id_oratorio'] = Session::get('session_oratorio');
    }

    return $data;
  }
}
