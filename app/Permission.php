<?php namespace App;

use Zizaco\Entrust\EntrustPermission;
use OwenIt\Auditing\Contracts\Auditable;
use Session;

class Permission extends EntrustPermission implements Auditable
{

  use \OwenIt\Auditing\Auditable;


  public function transformAudit(array $data): array
  {
    if (Session::has('session_oratorio')) {
      $data['id_oratorio'] = Session::get('session_oratorio');
    }

    return $data;
  }


}
