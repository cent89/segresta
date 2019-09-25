<?php

namespace Modules\Attributo\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Oratorio\Entities\TypeSelect;
use Modules\Oratorio\Entities\Type;
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

  public static function getPrintableValue($id_type, $value){
    if($id_type > 0){
      //il valore è da ricercare negli elenchi a scelta multipla creati dall'utente
      $select = TypeSelect::where('id', $value)->get();
      if(count($select)>0){
        return $select[0]->option;
      }else{
        return "n/a";
      }
    }

    switch($id_type){
      case Type::TEXT_TYPE:
      return $value;
      case Type::BOOL_TYPE:
      if($value==0) return "NO";
      else return "SI";
      case Type::NUMBER_TYPE:
      return $value;
      case Type::DATE_TYPE:
      return $value;
    }
  }

}
