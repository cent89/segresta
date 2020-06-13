<?php

namespace Modules\User\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Session;
use App\Notifications\VerificaEmail;
use App\Notifications\ResetPassword;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\MyEntrustUserTrait;

class User extends Authenticatable implements MustVerifyEmail, Auditable
{
  use Notifiable;
  use EntrustUserTrait;
  use \OwenIt\Auditing\Auditable;
  use MyEntrustUserTrait;

  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = ['name', 'email', 'password', 'cognome', 'nato_a', 'residente', 'sesso', 'via', 'nato_il',
  'photo', 'cell_number', 'id_nazione_nascita', 'id_comune_nascita', 'id_provincia_nascita', 'id_comune_residenza',
  'id_provincia_residenza', 'tessera_sanitaria', 'cod_fiscale', 'patologie', 'allergie', 'note', 'consenso_affiliazione', 'fcmToken', 'google_id', 'facebook_id', 'api_token'];

  protected $dates = ['nato_il'];

  protected $attributes = [
    'cognome' => '',
    'sesso' => 'M',
    'nato_il' => '2020-01-01',
    'via' => ''
  ];

  /**
  * The attributes that should be hidden for arrays.
  *
  * @var array
  */
  protected $hidden = ['password', 'remember_token'];

  public function getNatoIlAttribute($value){
    return Carbon::parse($value)->format('d/m/Y');
  }

  public function setNatoIlAttribute($value){
    $this->attributes['nato_il'] = $value == null?null:Carbon::createFromFormat('d/m/Y', $value)->toDateString();
  }

  public function getFullNameAttribute(){
    return $this->cognome." ".$this->name;
  }

  public function setIdComuneNascitaAttribute($value){
    $this->attributes['id_comune_nascita'] = $value==''?null:$value;
  }
  public function setIdProvinciaNascitaAttribute($value){
    $this->attributes['id_provincia_nascita'] = $value==''?null:$value;
  }


  /**
  * Many-to-Many relations with Role.
  *
  * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
  */

  public function roles()
  {
    if(Session::has('session_oratorio')){
      //if($this->email == config('app.owner_email')){
      //return $this->belongsToMany(Config::get('entrust.role'), Config::get('entrust.role_user_table'), Config::get('entrust.user_foreign_key'), Config::get('entrust.role_foreign_key'))->where('roles.id_oratorio', null);
      //}else{
      return $this->belongsToMany(Config::get('entrust.role'), Config::get('entrust.role_user_table'), Config::get('entrust.user_foreign_key'), Config::get('entrust.role_foreign_key'))->where('roles.id_oratorio', Session::get('session_oratorio'));
      //}
    }else{
      return $this->belongsToMany(Config::get('entrust.role'), Config::get('entrust.role_user_table'), Config::get('entrust.user_foreign_key'), Config::get('entrust.role_foreign_key'));
    }
  }

  public function sendEmailVerificationNotification()
  {
    $this->notify(new VerificaEmail);
  }

  public function sendPasswordResetNotification($token)
  {
    $this->notify(new ResetPassword($token));
  }

  public function isMaggiorenne(){
    //$data_nascita = Carbon::createFromFormat('d/m/Y', $this->attributes['nato_il']);
    $data_nascita = Carbon::parse($this->attributes['nato_il']);

    return $data_nascita->diffInDays(Carbon::now()) >= 6570;
  }

  public function transformAudit(array $data): array
  {
    if (Session::has('session_oratorio')) {
      $data['id_oratorio'] = Session::get('session_oratorio');
    }

    return $data;
  }

  public function routeNotificationForFcm()
  {
    return $this->fcmToken;
  }


  // Relation
  public function comuneNascita()
  {
    return $this->belongsTo('\App\Comune', 'id_comune_nascita', 'id');
  }

  public function provinciaNascita()
  {
    return $this->belongsTo('\App\Provincia', 'id_provincia_nascita', 'id');
  }

  public function iscrizioni()
  {
    return $this->hasMany('\Modules\User\Entities\User', 'id_user', 'id');
  }

  // public function certificazioni()
  // {
  //   return $this->hasMany('\Modules\Certificazione\Entities\CertificazioneUtente', 'id_user', 'id');
  // }

}
