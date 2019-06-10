<?php

namespace Modules\Oratorio\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Session;

class Oratorio extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable;
	
	protected $fillable = ['nome', 'nome_parrocchia', 'indirizzo_parrocchia', 'nome_diocesi', 'email', 'logo',
	'sms_sender', 'reg_visible', 'reg_token', 'last_login', 'last_id_event', 'luogo_firma_moduli', 'cf_parrocchia', 'piva_parrocchia'];

	public function getLastLoginAttribute($value){
		return Carbon::parse($value)->format('d/m/Y - H:i:s');
	}

	public function transformAudit(array $data): array
  {
    if (Session::has('session_oratorio')) {
      $data['id_oratorio'] = Session::get('session_oratorio');
    }

    return $data;
  }
}
