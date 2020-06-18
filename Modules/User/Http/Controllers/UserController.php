<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\User\Entities\User;
use Session;
use Entrust;
use Carbon\Carbon;
use App\RoleUser;
use App\Role;
use App\Comune;
use App\Nazione;
use Module;
use Input;
use File;
use Form;
use Image;
use Hash;
use Modules\Oratorio\Entities\UserOratorio;
use Modules\Attributo\Entities\AttributoUser;
use Modules\Event\Entities\Event;
use Auth;
use Storage;
use Excel;
use Yajra\DataTables\DataTables;
use Modules\User\Http\Controllers\DataTables\UserDataTableEditor;
use Modules\User\Http\Controllers\DataTables\UserDataTable;
use App\Notifications\EmailMessage;
use Notification;
use PDF;

class UserController extends Controller
{
  use ValidatesRequests;

  public function __construct(){
    $this->middleware('permission:view-users')->only(['index', 'data']);
    $this->middleware('permission:edit-users')->only(['store']);
  }

  public $messages = [
    'name.required' => 'Devi inserire un nome valido',
    'cognome.required' => 'Devi inserire un cognome valido',
    'email.required' => 'Devi inserire un indirizzo email valido',
    'password.required' => 'Devi inserire una password valida',
    'email.unique' => 'La mail inserita è già presente nel database',
    'password.min' => 'La password deve essere lunga almeno 8 caratteri'
  ];

  /**
  * Display a listing of the resource.
  * @return Response
  */
  public function index(UserDataTable $dataTable){
    return $dataTable->render('user::index');
  }

  public function store(UserDataTableEditor $editor){
    return $editor->process(request());
  }

  public function action(Request $request){
    $input = $request->all();
    if(!$request->has('check_user')){
      Session::flash("flash_message", "Devi selezionare almeno un utente!");
      return redirect()->route('user.index');
    }
    $json = $input['check_user'];
    //se l'array è vuoto, seleziono tutti gli utenti
    if(count(json_decode($json)) == 0){
      // $users = User::leftJoin('user_oratorio', 'user_oratorio.id_user', 'users.id')->where('user_oratorio.id_oratorio', Session::get('session_oratorio'))->pluck('users.id')->toArray();
      // $json = json_encode($users);
      $json = json_encode([]);
    }
    //$json = json_encode($check_user);
    switch($input['action']){
      case 'email':
      return route('email.create', ['users' => $json]);
      break;
      case 'sms':
      return route('sms.create', ['users' => $json]);
      break;
      case 'telegram':
      return route('telegram.create', ['users' => $json]);
      break;
      case 'group':
      return route('groupusers.select', ['users' => $json]);
      break;
      case 'firebase':
      return route('firebase.create', ['users' => $json]);
      break;
      // case 'whatsapp':
      // return route('whatsapp.create', ['users' => $json]);
      // break;
    }
  }

  public function data(Request $request, Datatables $datatables){
    $input = $request->all();

    $events = Event::orderBy('created_at', 'DESC')->pluck('nome', 'id');

    $builder = User::query()
    ->select('users.*')
    ->leftJoin('user_oratorio', 'user_oratorio.id_user', 'users.id')
    ->where('user_oratorio.id_oratorio', Session::get('session_oratorio'))
    ->orderBy('cognome', 'ASC');

    return $datatables->eloquent($builder)
    ->addColumn('action', function ($entity) use ($events){
      $edit = "<div style=''><div style='display: flow-root'><button class='btn btn-sm btn-primary btn-block' id='editor_edit' style='float: left; width: 50%; margin-right: 2px;'><i class='fas fa-pencil-alt'></i> Modifica</button>";
      $remove = "<button style='float: left; width: 48%; margin: 0px;' class='btn btn-sm btn-danger btn-block' id='editor_remove'><i class='fas fa-trash-alt'></i> Rimuovi</button></div></div>";
      $attributi = "<button class='btn btn-sm btn-primary btn-block' onclick='edit_attributi(".$entity->id.")' ><i class='fas fa-paperclip'></i> Attributi</button>";
      //iscrivi
      $iscrivi = "<div>".Form::open(['method' => 'POST', 'route' => ['subscribe.create']]).
      "<div class='row'><div class='col-5'>".
      Form::hidden('id_user', $entity->id).
      Form::select('id_event', $events, null, ['class' => 'form-control', 'style' => 'padding: 2px; height: auto;']).
      "</div><div class='col-7'><button class='btn btn-sm btn-primary btn-block' type='submit'><i class='fas fa-dolly'></i> Iscrivi all'evento</button></div></div></div>".
      Form::close();

      $iscrivi = "<button class='btn btn-sm btn-primary btn-block' onclick='seleziona_evento(".$entity->id.")' type='button'><i class='fas fa-dolly'></i> Iscrivi ad un evento</button>";


      if(count($events) == 0){
        $iscrivi = "";
      }

      if(Module::find('famiglia') != null && Module::find('famiglia')->enabled()){
        $famiglia = Form::open(['method' => 'GET', 'route' => ['famiglia.user', $entity->id]])."<button class='btn btn-sm btn-primary btn-block'><i class='fas fa-child'></i> Famiglia</button>".Form::close();
      }else{
        $famiglia = "";
      }

      if(!Auth::user()->can('edit-users')){
        $edit = "";
        $remove = "";
      }
      if(!Auth::user()->can('view-attributo')){
        $attributi = "";
      }
      if(!Auth::user()->can('view-famiglia')){
        $famiglia = "";
      }

      return $edit.$remove.$iscrivi.$attributi.$famiglia;
    })
    ->addColumn('path_photo', function ($entity){
      if($entity->photo == null){
        if($entity->sesso == "M"){
          return "<img src='".url("boy.png")."'>";
        }else if($entity->sesso=="F"){
          return "<img src='".url("girl.png")."'>";
        }
      }else{
        if(substr($entity->photo, 0, 4) == 'http'){
          return  "<img src='".$entity->photo."' width=48px>";
        }else{
          return "<img src='".url(Storage::url('public/'.$entity->photo))."' width=48px/>";
        }
      }
    })
    ->addColumn('DT_RowId', function ($entity){
      return $entity->id;
    })
    ->addColumn('email_label', function ($entity){
      if($entity->email_verified_at != null){
        return $entity->email;
      }

      return "<i class='fas fa-exclamation-circle faa-flash animated' style='color: Tomato;'></i> ".$entity->email;
    })
    ->addColumn('role_id', function ($entity){
      if($entity->roles == null || count($entity->roles) == 0) return;
      return $entity->roles[0]->id;
    })
    ->addColumn('comune_nascita_label', function ($entity){
      if($entity->id_nazione_nascita != 118){ //se non è nato in Italia, scrivo lo stato di nascita, ignorando il resto
        return Nazione::find($entity->id_nazione_nascita)->nome_stato;
      }
      if($entity->id_comune_nascita != null){
        return Comune::find($entity->id_comune_nascita)->nome;
      }
    })
    ->filterColumn('nato_il', function($query, $keyword) {
      $sql = "nato_il LIKE ? ";
      $query->whereRaw($sql, ["{$keyword}"]);
    })
    ->rawColumns(['action', 'check', 'path_photo', 'email_label'])
    ->toJson();
  }

  /**
  * Store a newly created resource in storage.
  * @param  Request $request
  * @return Response
  */
  public function store_user(Request $request)
  {
    //Genera user, password e email se non forniti
    if(isset($request['genera_email'])){
      $user = new User;
      $email = "";
      do{
        $email = str_random(20);
        $user = User::where([['email', $email.'@segresta.it'], ['username', $email]])->get();
      }while(count($user)>0);

      $request['email'] = $email.'@segresta.it';
      $request['username'] = $email;
    }

    if(isset($request['genera_password'])){
      $request['password'] = str_random(40);
    }

    $this->validate($request, [
      'name' => 'required',
      'cognome' => 'required',
      'nato_il' => 'required|date_format:d/m/Y',
      'nato_a' => 'required',
      'email' =>'required|unique:users',
      'username' => 'required|unique:users',
      'password' => 'required'
    ]);
    $input = $request->all();
    $date = Carbon::createFromFormat('d/m/Y', $input['nato_il']);
    if(Input::hasFile('photo')){
      $file = $request->photo;
      $filename = $request->photo->store('profile', 'public');
      $path = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix().$filename;
      $image = Image::make($path);
      $image->resize(500,null, function ($constraint) {$constraint->aspectRatio();});
      $image->save($path);
      $input['photo'] = $filename;
    }
    $input['password'] = Hash::make($input['password']);
    //salvo l'utente
    $user = User::create($input);
    //salvo il link utente-oratorio
    $orat = new UserOratorio;
    $orat->id_user=$user->id;
    $orat->id_oratorio = Session::get('session_oratorio');
    $orat->save();

    //salvo attributi
    $i=0;
    if(isset($input['id_attributo']) && count($input['id_attributo'])>0){
      foreach($input['id_attributo'] as $id) {
        $attrib = AttributoUser::create(['id_user' => $user->id, 'id_attributo' => $id, 'valore' => $input['attributo'][$i]]);
        $i++;
      }
    }

    //aggiungo il ruolo
    $roles = Role::where([['name', 'user'], ['id_oratorio', Session::get('session_oratorio')]])->get();
    if(count($roles)>0){
      //creo il ruolo
      $role = new RoleUser;
      $role->user_id = $user->id;
      $role->role_id = $roles[0]->id;
      $role->save();
    }
    Session::flash('flash_message', 'Utente aggiunto!');
    return redirect()->route('user.index');
  }

  /**
  ** Mostra la pagina di aggiornamento profilo utente
  **/

  public function profile(){
    $user = User::findOrFail(Auth::user()->id);
    return view('user::profile')->withUser($user);
  }

  /**
  ** Aggiorna il profilo utente
  **/

  public function updateprofile(Request $request){
    $input = $request->all();
    $user = Auth::user();
    $this->validate($request, [
      'name' => 'required',
      'cognome' => 'required',
      'email' => 'required|email|unique:users,email,'.$user->id,
      'password_new' => 'nullable|min:8',
      'confirm_password' => 'nullable|same:password_new',
    ], $this->messages);

    if($request->hasFile('path_photo')){
      $file = $request->path_photo;
      $filename = $request->path_photo->store('profile', 'public');
      $path = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix().$filename;
      $image = Image::make($path);
      $image->orientate();
      $image->resize(500,null, function ($constraint) {$constraint->aspectRatio();});
      $image->save($path);
      $input['photo'] = $filename;

      //cancello la vecchia immagine se presente
      if($user->photo != ""){
        Storage::delete('public/'.$user->photo);
      }
    }

    $user->fill($input);
    if($input['password_new'] != null){
      $user->password = Hash::make($input['password_new']);
    }

    $user->save();

    //Salvo gli attributi
    $keys = ['id_attributo', 'id_attributouser', 'valore'];
    foreach($keys as $key){
      if(!array_key_exists($key, $input)){
        $input[$key] = array();
      }
    }
    $id_attributo = $input['id_attributo'];
    $id_attributouser = $input['id_attributouser'];
    $valore = $input['valore'];
    $i=0;
    foreach($id_attributo as $id){
      if($id_attributouser[$i]>0){
        $u = AttributoUser::findOrfail($id_attributouser[$i]);
        $u->valore = $valore[$i];
        $u->save();
      }else{
        $u = new AttributoUser();
        $u->id_user = $user->id;
        $u->id_attributo = $id_attributo[$i];
        $u->valore = $valore[$i];
        $u->save();
      }
      $i++;
    }
    //Redirect

    // $query = Session::get('query_param');
    // Session::forget('query_param');
    Session::flash('flash_message', 'Profilo salvato!');
    return redirect()->route('home');


  }

  public function users_list(Request $request){
    $input = $request->all();
    $list = array();

    if($request->has('initialValue') && $input['initialValue'] == "true"){
      $val = str_replace('"', '', $input['value']);
      $user = User::where('id', $val)->orderBy('name', 'ASC')->first();
      return str_replace('\\', '/', json_encode(array('id' => $user->id, 'text' => $user->full_name), JSON_UNESCAPED_SLASHES));

    }else{
      $users = User::select('users.*')->leftJoin('user_oratorio', 'user_oratorio.id_user', 'users.id')
      ->where('cognome', 'LIKE', ($request->has('term')?$input['term']:'').'%')
      ->where('user_oratorio.id_oratorio', Session::get('session_oratorio'))
      ->orderBy('cognome', 'ASC');
    }

    foreach ($users->get() as $user) {
      $user_name = $user->full_name." (".$user->nato_il.")";
      array_push($list, array('id' => $user->id, 'text' => $user_name));
    }

    return str_replace('\\', '/', json_encode(array('results' => $list), JSON_UNESCAPED_SLASHES));
  }

  public static function sendEmailCompleanni(){
    if(User::where('nato_il', 'like', '%-'.Carbon::now()->format('m-d'))->count() > 0){
      //genera pdf
      $folder_name = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix()."/temp/";
      if(!is_dir($folder_name)){
        Storage::makeDirectory("public/temp/");
      }
      $pdf = PDF::loadView('user::compleanni');
      $filename = $folder_name."compleanni_".Carbon::now()->format('d-m-Y').".pdf";
      $pdf->save($filename);


      //invia
      $admins = User::withRole('admin')->get();
      $oggetto = "Compleanni di oggi";
      $messaggio = "Ciao, in allegato trovi l'elenco degli utenti che compiono gli anni oggi. Augura loro un buon compleanno!";
      Notification::send($admins, new EmailMessage($oggetto, $messaggio, $filename));
    }

  }




}
