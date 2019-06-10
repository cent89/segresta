<?php

namespace Modules\Attributo\Entities;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Session;

class Attributo extends Model implements Auditable
{
  use \OwenIt\Auditing\Auditable;
  protected $fillable = ['nome', 'ordine', 'id_oratorio', 'note', 'id_type', 'hidden' ];

  public static function getLista(){
    $list = array();
    foreach (Attributo::orderBy('nome', 'ASC')->get() as $p) {
      array_push($list, array('id' => $p->id, 'nome' => $p->nome));
    }

    return json_encode($list, JSON_HEX_APOS|JSON_HEX_QUOT);
  }

  public function transformAudit(array $data): array
  {
    if (Session::has('session_oratorio')) {
      $data['id_oratorio'] = Session::get('session_oratorio');
    }

    return $data;
  }

}
