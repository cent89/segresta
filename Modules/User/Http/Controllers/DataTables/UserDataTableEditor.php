<?php

namespace Modules\User\Http\Controllers\DataTables;

use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTablesEditor;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Oratorio\Entities\UserOratorio;
use Modules\Famiglia\Entities\ComponenteFamiglia;
use Session;
use App\RoleUser;
use App\Role;

class UserDataTableEditor extends DataTablesEditor
{
  protected $model = User::class;
  protected $actions = ['create', 'edit', 'remove', 'upload'];
  protected $messages = [
    'cognome.required' => 'Il cognome è obbligatorio',
    'name.required' => 'Il nome è obbligatorio',
    'email.required' => 'L\'email è obbligatoria',
    'email.unique' => 'L\'indirizzo email indicato è già presente nel database',
    'nato_il.required' => 'La data di nascita è obbligatoria',
    'nato_il.date_format' => 'La data di nascita deve essere nel formato GG/MM/AAAA',
    'id_comune_nascita.required' => 'Devi indicare il comune di nascita scegliendolo dell\'elenco',
    'id_comune_residenza.required' => 'Devi indicare il comune di residenza scegliendolo dell\'elenco',
    'via.required' => 'Devi indicare l\'indirizzo di residenza',
  ];

  /**
  * Get create action validation rules.
  *
  * @return array
  */
  public function createRules()
  {
    return [
      'cognome' => 'required',
      'name'  => 'required',
      'email' => 'email|unique:users,email',
      'nato_il' => 'required|date_format:d/m/Y',
      'id_comune_residenza' => 'required',
      'via' => 'required'
    ];
  }

  public function createMessages(){
    return $this->messages;
  }

  /**
  * Get edit action validation rules.
  *
  * @param Model $model
  * @return array
  */
  public function editRules(Model $model)
  {
    return [
      'cognome' => 'required',
      'name'  => 'required',
      'email' => 'email|unique:users,email,'.$model->id,
      'nato_il' => 'required|date_format:d/m/Y',
      'id_comune_residenza' => 'required',
      'via' => 'required'
    ];
  }

  /**
  * Get remove action validation rules.
  *
  * @param Model $model
  * @return array
  */
  public function removeRules(Model $model)
  {
    return [];
  }

  public function creating(Model $model, array $data)
  {
    if(isset($data['cod_fiscale'])){
      $data['cod_fiscale'] = strtoupper($data['cod_fiscale']);
    }

    return $data;
  }

  public function created(Model $model, array $data)
  {
    //salvo il link utente-oratorio
    $orat = new UserOratorio;
    $orat->id_user = $model->id;
    $orat->id_oratorio = Session::get('session_oratorio');
    $orat->save();

    //aggiungo il ruolo
    $roles = Role::where([['name', 'user'], ['id_oratorio', Session::get('session_oratorio')]])->get();
    if(count($roles)>0){
      //creo il ruolo
      $role = new RoleUser;
      $role->user_id = $model->id;
      $role->role_id = $roles[0]->id;
      $role->save();
    }

    //ruolo familiare
    if(isset($data['tipo_legame']) && isset($data['famiglia_id'])){
      $componente = new ComponenteFamiglia;
      $componente->id_famiglia = $data['famiglia_id'];
      $componente->id_user = $model->id;
      $componente->tipo_legame = $data['tipo_legame'];
      $componente->save();
    }

    // Invio email di verifica email
    $model->sendEmailVerificationNotification();

    return $model;
  }

  public function updating(Model $model, array $data)
  {
    if(isset($data['cod_fiscale'])){
      $data['cod_fiscale'] = strtoupper($data['cod_fiscale']);
    }

    if(isset($data['role_id'])){
      $role = RoleUser::where([['user_id', $model->id],['role_id', $model->roles[0]->id]])->first();
      $role->role_id = $data['role_id'];
      $role->save();
    }

    //ruolo familiare
    if(isset($data['tipo_legame']) && isset($data['componente_id'])){
      $componente = ComponenteFamiglia::find($data['componente_id']);
      if($componente != null){
        $componente->tipo_legame = $data['tipo_legame'];
        $componente->save();
      }
    }


    return $data;
  }

  public function upload(Request $request){
    $input = $request->all();
    //$file = $input['upload'];
    if($request->has('upload')){
      $filename = $request->upload->store('profile', 'public');

      return response()->json([
        'data'   => [],
        'upload' => [
          'id' => $filename
        ],
      ]);
    }

    return;

  }

}
