<?php

namespace Modules\Event\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Event\Entities\EventSpec;
use Modules\Oratorio\Entities\Type;
use OwenIt\Auditing\Contracts\Auditable;

use Session;

class Event extends Model implements Auditable
{

    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['nome', 'anno', 'descrizione', 'id_oratorio', 'active', 'firma', 'image', 'color',
    'more_subscriptions', 'stampa_anagrafica', 'spec_iscrizione', 'grazie', 'template_file', 'pagine_foglio', 'select_famiglia', 'id_moduli', 'is_diocesi'];

    public static $pagine_per_foglio = array('1' => "Una pagina per foglio", '2' => "Due pagine per foglio");

    public static function getPaginePerFoglio(){
      return self::$pagine_per_foglio;
    }

    // dice se l'evento ha una sola specifica e questa è di tipo checkbox
    public function isOneSpecEvent(){
      $count = EventSpec::select()
      ->where([['id_event', $this->attributes['id']], ['id_type', Type::BOOL_TYPE]])
      ->count();

      return $count == 1?true:false;
    }

    public function transformAudit(array $data): array
    {
      if (Session::has('session_oratorio')) {
        $data['id_oratorio'] = Session::get('session_oratorio');
      }

      return $data;
    }
}
