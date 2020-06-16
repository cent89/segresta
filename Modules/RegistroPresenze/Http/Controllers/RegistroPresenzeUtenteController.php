<?php

namespace Modules\RegistroPresenze\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Modules\RegistroPresenze\Http\DataTables\RegistroPresenzeUtenteDataTableEditor;
use Modules\RegistroPresenze\Http\DataTables\RegistroPresenzeUtenteDataTable;
use Modules\RegistroPresenze\Entities\RegistroPresenze;
use Modules\RegistroPresenze\Entities\RegistroPresenzeUtente;
use Modules\User\Entities\User;
use Carbon\Carbon;
use Session;
use Storage;


class RegistroPresenzeUtenteController extends Controller
{

	public function __construct(){
		// $this->middleware('permission:view-certificazione')->only(['index', 'data']);
		// $this->middleware('permission:edit-certificazione')->only(['store']);
	}

	public function index(RegistroPresenzeUtenteDataTable $dataTable, Request $request)
	{
		$input = $request->all();

		if($request->has('id_registro')){
			return $dataTable->with('id_registro', $input['id_registro'])->render('registro_presenze::users', ['id_registro' => RegistroPresenze::find($input['id_registro'])]);
		}
	}

	public function store(RegistroPresenzeUtenteDataTableEditor $editor)
	{
		$request = request();
		$input = $request->all();

		return $editor->process(request());
	}



}
