<?php

namespace Modules\Event\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Event\Entities\EventSpec;
use Modules\Oratorio\Entities\Type;
use OwenIt\Auditing\Contracts\Auditable;
use Carbon\Carbon;

use Session;

class Event extends Model implements Auditable
{

    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['nome', 'anno', 'descrizione', 'id_oratorio', 'active', 'firma', 'image', 'color',
    'more_subscriptions', 'stampa_anagrafica', 'spec_iscrizione', 'grazie', 'template_file', 'pagine_foglio', 'select_famiglia', 'id_moduli', 'is_diocesi',
     'data_apertura', 'data_chiusura', 'max_posti'];

     protected $attributes = [
       'max_posti' => 0,
     ];


    public static $pagine_per_foglio = array('1' => "Una pagina per foglio", '2' => "Due pagine per foglio");

    public static function getPaginePerFoglio(){
      return self::$pagine_per_foglio;
    }

    public function getDataAperturaAttribute($value){
      return $value!=null?Carbon::parse($value)->format('d/m/Y'):"";
    }

    public function setDataAperturaAttribute($value){
      $this->attributes['data_apertura'] = $value!=null?Carbon::createFromFormat('d/m/Y', $value)->toDateString():null;
    }

    public function getDataChiusuraAttribute($value){
      return $value!=null?Carbon::parse($value)->format('d/m/Y'):"";
    }

    public function setDataChiusuraAttribute($value){
      $this->attributes['data_chiusura'] = $value!=null?Carbon::createFromFormat('d/m/Y', $value)->toDateString():null;
    }

    // dice se l'evento ha una sola specifica e questa è di tipo checkbox
    public function isOneSpecEvent(){
      $spec = EventSpec::select()
      ->where('id_event', $this->attributes['id']);

      if($spec->count() == 1 && $spec->first()->id_type == Type::BOOL_TYPE){
        return true;
      }else{
        return false;
      }

    }

    public function transformAudit(array $data): array
    {
      if (Session::has('session_oratorio')) {
        $data['id_oratorio'] = Session::get('session_oratorio');
      }

      return $data;
    }

    // Relation
    public function iscrizioni()
    {
        return $this->hasMany('\Modules\Subscription\Entities\Subscription', 'id_event', 'id');
    }
}
