<?php

namespace Modules\Modulo\Entities;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Session;

class Modulo extends Model implements Auditable
{
  use \OwenIt\Auditing\Auditable;
  
  protected $table = "modulo";
  protected $fillable = ['label', 'path_file', 'id_oratorio'];

  public function transformAudit(array $data): array
  {
    if (Session::has('session_oratorio')) {
      $data['id_oratorio'] = Session::get('session_oratorio');
    }

    return $data;
  }
}
