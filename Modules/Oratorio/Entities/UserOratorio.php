<?php

namespace Modules\Oratorio\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Carbon\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Session;

class UserOratorio extends Authenticatable implements Auditable
{
  use \OwenIt\Auditing\Auditable;
  use Notifiable;
  use EntrustUserTrait;

  protected $table = 'user_oratorio';
  protected $fillable = ['id_user', 'id_oratorio'];

  public function transformAudit(array $data): array
  {
    if (Session::has('session_oratorio')) {
      $data['id_oratorio'] = Session::get('session_oratorio');
    }

    return $data;
  }
}
