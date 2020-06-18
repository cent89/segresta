<?php

namespace Modules\Group\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Group\Entities\Group;
use Modules\Group\Entities\GroupUser;
use Session;
use Entrust;
use Input;
use DB;
use Yajra\DataTables\DataTables;
use Modules\Group\Http\Controllers\DataTables\GroupDataTableEditor;
use Modules\Group\Http\Controllers\DataTables\GroupDataTable;

class GroupController extends Controller
{

  public function __construct(){
    $this->middleware('permission:view-gruppo')->only(['index', 'data', 'componenti']);
    $this->middleware('permission:edit-gruppo')->only(['store']);
  }

  /**
  * Display a listing of the resource.
  *
  * @return Response
  */

  public function index(GroupDataTable $dataTable){
    return $dataTable->render('group::index');
  }

  public function store(GroupDataTableEditor $editor){
    return $editor->process(request());
  }

  public function data(Request $request, Datatables $datatables){
    $input = $request->all();

    $builder = Group::query()
    ->select('groups.*', DB::raw("CONCAT(users.cognome, ' ', users.name) as responsabile_label"))
    ->leftJoin('users', 'users.id', 'groups.id_responsabile')
    ->where('id_oratorio', Session::get('session_oratorio'))
    ->orderBy('nome', 'ASC');

    return $datatables->eloquent($builder)
    ->addColumn('action', function ($entity){
      $edit = "<button class='btn btn-sm btn-primary btn-block' id='editor_edit'><i class='fas fa-pencil-alt'></i> Modifica</button>";
      $remove = "<button class='btn btn-sm btn-danger btn-block' id='editor_remove'><i class='fas fa-trash-alt'></i> Rimuovi</button>";
      $detail = "<button class='btn btn-sm btn-primary btn-block' onclick='load_componenti(".$entity->id.")'><i class='fas fa-info'></i> Componenti</button>";

      if(!Auth::user()->can('edit-gruppo')){
        $edit = "";
        $remove = "";
      }

      return $edit.$remove.$detail;
    })
    ->addColumn('DT_RowId', function ($entity){
      return $entity->id;
    })
    ->filterColumn('responsabile_label', function($query, $keyword) {
			$sql = "users.name LIKE ? OR users.cognome LIKE ?";
			$query->whereRaw($sql, ["%{$keyword}%", "%{$keyword}%"]);
		})
    ->rawColumns(['action'])
    ->toJson();
  }

  public function componenti($id_gruppo){
    return view('group::componenti')->withGroup(Group::find($id_gruppo));
  }

  public function action(Request $request){
    $input = $request->all();
    if(!$request->has('check_group')){
      Session::flash("flash_message", "Devi selezionare almeno un utente!");
      return redirect()->route('group.index');
    }
    $json = $input['check_group'];
    // $users = GroupUser::select('*')->whereIn('id_group', json_decode($json));
    //se l'array è vuoto, seleziono tutti i gruppi

    if(count(json_decode($json)) == 0){
      // $users = User::leftJoin('user_oratorio', 'user_oratorio.id_user', 'users.id')->where('user_oratorio.id_oratorio', Session::get('session_oratorio'))->pluck('users.id')->toArray();
      // $json = json_encode($users);
      $json = json_encode(GroupUser::select('*')->pluck('id_user')->toArray());
    }else{
      $json = json_encode(GroupUser::select('*')->whereIn('id_group', json_decode($json))->pluck('id_user')->toArray());
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

}
