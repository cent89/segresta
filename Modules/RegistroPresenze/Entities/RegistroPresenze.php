<?php

namespace Modules\RegistroPresenze\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RegistroPresenze extends Model
{
  protected $table = "registro_presenze";
  protected $fillable = ['id_oratorio', 'id_event', 'data', 'titolo', 'aperto'];

  public function oratorio()
  {
      return $this->belongsTo('\Modules\Oratorio\Entities\Oratorio', 'id_oratorio', 'id');
  }

  public function evento()
  {
      return $this->belongsTo('\Modules\Event\Entities\Event', 'id_event', 'id');
  }

  public function getDataAttribute($value){
    return $value!=null?Carbon::parse($value)->format('d/m/Y'):"";
  }

  public function setDataAttribute($value){
    $this->attributes['data'] = $value!=null?Carbon::createFromFormat('d/m/Y', $value)->toDateString():null;
  }
}
