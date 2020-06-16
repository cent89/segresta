<?php

namespace Modules\RegistroPresenze\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Modules\RegistroPresenze\Http\DataTables\RegistroPresenzeDataTableEditor;
use Modules\RegistroPresenze\Http\DataTables\RegistroPresenzeDataTable;
use Modules\RegistroPresenze\Entities\RegistroPresenze;
use Session;
use Storage;


class RegistroPresenzeController extends Controller
{

	public function __construct(){
    $this->middleware('permission:view-registro_presenze')->only(['index', 'data']);
    $this->middleware('permission:edit-registro_presenze')->only(['store']);
  }

	public function index(RegistroPresenzeDataTable $dataTable)
  {
    return $dataTable->render('registro_presenze::index');
  }

  public function store(RegistroPresenzeDataTableEditor $editor)
  {
    $request = request();
    $input = $request->all();

    return $editor->process(request());
  }

	// public function download($id){
	// 	$certificazione = Certificazione::find($id);
	// 	if($certificazione!=null){
	// 		$storagePath  = Storage::disk('modelli_certificazioni')->getDriver()->getAdapter()->getPathPrefix();
	// 		$file = $storagePath.$certificazione->path_pdf;
	// 		if(Storage::disk('modelli_certificazioni')->exists($certificazione->path_pdf)){
	// 			return response()->download($storagePath.$certificazione->path_pdf);
	// 		}else{
	// 			Session::flash('flash_message', 'Il file non esiste!');
	// 			return redirect()->route('certificazione.index');
	// 		}
	// 	}else{
	// 		Session::flash('flash_message', "Il documento non esiste");
	// 		return redirect()->route('certificazione.index');
	// 	}
	// }

}
