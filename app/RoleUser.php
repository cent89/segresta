<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Session;

class RoleUser extends Model implements Auditable
{

	use \OwenIt\Auditing\Auditable;


	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = ['user_id', 'role_id'];
	protected $table = 'role_user';

	public function transformAudit(array $data): array
	{
		if (Session::has('session_oratorio')) {
			$data['id_oratorio'] = Session::get('session_oratorio');
		}

		return $data;
	}

}
