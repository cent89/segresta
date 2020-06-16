<?php

namespace Modules\RegistroPresenze\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RegistroPresenzeUtente extends Model
{
  protected $table = 'registro_presenze_utente';
  protected $fillable = ['id_user', 'id_registro', 'presente'];

  // Relation
  public function user()
  {
      return $this->belongsTo('\Modules\User\Entities\User', 'id_user', 'id');
  }

  public function registroPresenza()
  {
    return $this->belongsTo('\Modules\RegistroPresenze\Entities\RegistroPresenze', 'id_registro', 'id');
  }
}
