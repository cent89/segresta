<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Config;
use Session;

class ConfigController extends Controller
{
  // public static $permission_group = "Configurazione";
  // public static $permissions = [
  //   'view-config' => 'Vedi la pagina',
  //   'create-config' => 'Permetti la creazione',
  //   'edit-config' => 'Permetti la modifica',
  //   'remove-config' => 'Permetti la cancellazione'
  // ];
  //
  // public function __construct(){
  //   $this->middleware('permission:view-config')->only(['index']);
  //   $this->middleware('permission:create-config|edit-config|remove-config')->only(['save']);
  // }

  public function index()
  {
    return view('config.index');
  }

  public function save(Request $request){
    $input = $request->all();
    // $index = 0;
    $index_file = 0;

    foreach($input['key'] as $key => $value){
      $config = Config::find($value);
      switch ($config->type) {
        case 'file':
        $file = $request->file('value');
        if($file != null && array_key_exists($key, $file)){
          $filename = $file[$key]->storeAs('public', $file[$key]->getClientOriginalName());
          $config->value = $filename;
          $index_file++;
        }
        break;

        case 'hours':
        $config->value = json_encode($request->value[$key]);
        break;

        default:
        $config->value = $request->value[$key];
        // $index++;
        break;
      }
      $config->save();
    }

    Session::flash('flash_message', 'Configurazione aggiornata');
    return redirect()->route('config.index');
  }


}
