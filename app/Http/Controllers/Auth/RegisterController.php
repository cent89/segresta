<?php

namespace App\Http\Controllers\Auth;

use Modules\User\Entities\User;
use App\Role;
use App\RoleUser;
use Modules\Attributo\Entities\AttributoUser;
use Modules\Oratorio\Entities\UserOratorio;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Session;

class RegisterController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Register Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles the registration of new users as well as their
  | validation and creation. By default this controller uses a trait to
  | provide this functionality without requiring any additional code.
  |
  */

  use RegistersUsers;

  /**
  * Where to redirect users after login / registration.
  *
  * @var string
  */
  protected $redirectTo = '/home';

  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->middleware('guest');
  }

  /**
  * Get a validator for an incoming registration request.
  *
  * @param  array  $data
  * @return \Illuminate\Contracts\Validation\Validator
  */
  protected function validator(array $data)
  {
    return Validator::make($data, [
      'name' => 'required|max:255',
      'email' => 'required|email|max:255|unique:users',
      'password' => 'required|min:8|confirmed',
      'nato_il' => 'required|date_format:d/m/Y',
      'id_comune_nascita' => 'required',
      'cognome' => 'required',
      'sesso' => 'required',
      'id_comune_residenza' => 'required',
      'via' => 'required',
      'cell_number' => 'required|max:11',
    ]);
  }

  /**
  * Create a new user instance after a valid registration.
  *
  * @param  array  $data
  * @return User
  */
  protected function create(array $data){
    $user = User::create($data);
    $user->password = bcrypt($data['password']);
    $user->save();

    //salvo l'oratorio e il ruolo solo se id_oratorio>0
    if($data['id_oratorio']>0){
      //salvo il ruolo 'user'
      $role = Role::where([['name', '=', 'user'],['id_oratorio', $data['id_oratorio']]])->first();
      $user->attachRole($role);
      //collego l'utente all'oratorio selezionato
      $useroratorio = UserOratorio::create(['id_user' => $user->id, 'id_oratorio' => $data['id_oratorio']]);
    }
    //salvo gli attributi
    // $i=0;
    // foreach($id_attributo as $id) {
    //   $attrib = AttributoUser::create(['id_user' => $user->id, 'id_attributo' => $id, 'valore' => $attributo[$i]]);
    //   $i++;
    // }
    return $user;

  }
}
