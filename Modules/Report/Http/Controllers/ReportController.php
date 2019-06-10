<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\User\Entities\User;
use Modules\Event\Entities\Week;
use Modules\Event\Entities\Event;
use Modules\User\Entities\Group;
use Modules\Subscription\Entities\Subscription;
use Modules\Oratorio\Entities\Oratorio;
use Modules\Event\Entities\EventSpecValue;
use Modules\Event\Entities\EventSpec;
use Modules\Oratorio\Entities\TypeSelect;
use Modules\Report\Entities\Report;
use Yajra\DataTables\DataTables;
use Modules\Report\Http\Controllers\DataTables\ReportDataTableEditor;
use Modules\Report\Http\Controllers\DataTables\ReportDataTable;
use Session;
use Form;
use Entrust;
use Carbon;
use Input;
use Excel;
use Storage;
use PDF;

class ReportController extends Controller
{

	public function __construct(){
    $this->middleware('permission:generate-report');
  }

	public function index(ReportDataTable $dataTable){
		if(!Session::has('work_event')){
			Session::flash('flash_message', 'Per accedere ai report salvati, devi prima selezionare un evento con cui lavorare!');
			return redirect()->route('events.index');
		}
    return $dataTable->render('report::index');
  }

  public function store(ReportDataTableEditor $editor){
    return $editor->process(request());
  }

	public function data(Request $request, Datatables $datatables){
		$input = $request->all();

		$builder = Report::query()
		->select('report.*')
		->where('id_event', Session::get('work_event'))
		->orderBy('created_at', 'ASC');

		return $datatables->eloquent($builder)
		->addColumn('action', function ($entity){
			$remove = "<button class='btn btn-sm btn-danger btn-block' id='editor_remove'><i class='fas fa-trash-alt'></i> Rimuovi</button>";
			$genera = Form::open(['route' => $entity->route]).Form::hidden('report', $entity->report).
			"<button class='btn btn-sm btn-primary btn-block'><i class='far fa-file-excel'></i> Genera report</button>".Form::close();

			return $genera.$remove;
		})
		->addColumn('DT_RowId', function ($entity){
			return $entity->id;
		})
		->rawColumns(['action'])
		->toJson();
	}

	public function eventspecreport(){
		if(Session::has('work_event')){
			return view('report::composer_eventspec');
		}else{
			Session::flash('flash_message', 'Per generare il report delle iscrizioni, devi prima selezionare un evento con cui lavorare!');
			return redirect()->route('events.index');
		}
	}

	public function weekreport(){
		if(Session::has('work_event')){
			return view('report::composer_weekspec');
		}else{
			Session::flash('flash_message', 'Per generare il report delle iscrizioni, devi prima selezionare un evento con cui lavorare!');
			return redirect()->route('events.index');
		}

	}

	public function gen_eventspec(Request $request){
		$input = $request->all();
		if($request->has('report')){
			//report contiene il json di tutto il report da generare.
			$input = json_decode($input['report'], true);
		}
		switch($input['format']){
			case 'pdf':
			$pdf = PDF::loadView('report::eventspecreport', compact('input'))->setPaper('a4', 'landscape');
	    return $pdf->download(camel_case("Report").".pdf");
			break;
			case 'excel': return Excel::download(new ReportExport($input), 'report.xlsx');
			break;
			case 'html': return view('report::eventspecreport', ['input' => $input]);
			break;
			case 'save':
			//salvo il json del report nel db, per richiamarlo più velocemente
			$report = new Report();
			$report->titolo = "Il mio nuovo report";
			$report->id_event = Session::get('work_event');
			$report->route = 'report.gen_eventspec';
			$input['format'] = 'excel';
			$report->report = json_encode($input);
			$report->save();
			Session::flash('flash_message', 'Report salvato come modello! Ora assegnagli un nome per riconoscerlo più velocemente.');
			return redirect()->route('report.index');
			break;
		}
	}

	public function gen_weekspec(Request $request){
		$input = $request->all();
		if($request->has('report')){
			//report contiene il json di tutto il report da generare.
			$input = json_decode($input['report'], true);
		}

		switch($input['format']){
			case 'pdf':
			$pdf = PDF::loadView('report::weekreport', compact('input'))->setPaper('a4', 'landscape');
	    return $pdf->download(camel_case("Report").".pdf");
			break;
			case 'excel': return Excel::download(new ReportExportWeek($input), 'report.xlsx');
			break;
			case 'html': return view('report::weekreport2', ['input' => $input]);
			break;
			case 'save':
			//salvo il json del report nel db, per richiamarlo più velocemente
			$report = new Report();
			$report->titolo = "Il mio nuovo report";
			$report->id_event = Session::get('work_event');
			$report->route = 'report.gen_weekspec';
			$input['format'] = 'excel';
			$report->report = json_encode($input);
			$report->save();
			Session::flash('flash_message', 'Report salvato come modello! Ora assegnagli un nome per riconoscerlo più velocemente.');
			return redirect()->route('report.index');
			break;
		}
	}

	public function gen_user(Request $request){
		$input = $request->all();
		return view('report::users', ['input' => $input]);
	}

	public function user(Request $request){
		$input = $request->all();
		return view('report::composer_user');
	}

}
