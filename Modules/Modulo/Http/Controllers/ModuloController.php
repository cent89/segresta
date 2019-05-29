<?php

namespace Modules\Modulo\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Modulo\Http\Controllers\DataTables\ModuloDataTableEditor;
use Modules\Modulo\Http\Controllers\DataTables\ModuloDataTable;
use Modules\Modulo\Entities\Modulo;
use Modules\Event\Entities\Event;
use Yajra\DataTables\DataTables;
use Modules\Event\Entities\EventSpec;
use Modules\Oratorio\Entities\Oratorio;
use Modules\Event\Entities\Week;
use Form;
use Storage;
use Session;

class ModuloController extends Controller
{
  public function index(ModuloDataTable $dataTable){
		return $dataTable->render('modulo::index');
  }

  public function store(ModuloDataTableEditor $editor){
    return $editor->process(request());
  }

  public function data(Request $request, Datatables $datatables){
    $input = $request->all();
    $builder = Modulo::query()
    ->where('id_oratorio', Session::get('session_oratorio'))
    ->orderBy('label', 'ASC');

    return $datatables->eloquent($builder)
    ->addColumn('action', function ($entity){
      $edit = "<div style=''><div style='display: flow-root'><button class='btn btn-sm btn-primary btn-block' id='editor_edit' style='float: left; width: 50%; margin-right: 2px;'><i class='fas fa-pencil-alt'></i> Modifica</button>";
      $remove = "<button style='float: left; width: 48%; margin: 0px;' class='btn btn-sm btn-danger btn-block' id='editor_remove'><i class='fas fa-trash-alt'></i> Rimuovi</button></div></div>";
      $download = Form::open(['method' => 'GET', 'route' => ['modulo.download', $entity->id]])."<button class='btn btn-sm btn-primary btn-block'><i class='fas fa-cloud-download-alt'></i> Download</button>".Form::close();
      $anteprima = Form::open(['method' => 'GET', 'route' => ['modulo.anteprima', $entity->id]])."<button class='btn btn-sm btn-primary btn-block'><i class='fas fa-eye'></i> Anteprima</button>".Form::close();

      //se il modulo è usato in qualche evento, impedisco eliminazione
      foreach(Event::where('id_oratorio', Session::get('session_oratorio'))->get() as $event){
        $array_moduli = json_decode($event->id_moduli);
        if($array_moduli != null && in_array($entity->id, $array_moduli)){
          $remove = "";
          break;
        }
      }
      return $edit.$remove.$anteprima.$download;
    })
		->addColumn('DT_RowId', function ($entity){
      return $entity->id;
    })
    ->rawColumns(['action'])
    ->toJson();
  }

  public function download($id){
    $modulo = Modulo::find($id);
    if($modulo!=null){
      $storagePath  = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();
			$file = $storagePath.$modulo->path_file;
			if(Storage::disk('public')->exists($modulo->path_file)){
				return response()->download($storagePath.$modulo->path_file);
			}else{
				Session::flash('flash_message', 'Il file non esiste!');
				return redirect()->route('modulo.index');
			}
    }else{
      Session::flash('flash_message', "Il documento non esiste");
  		return redirect()->route('modulo.index');
    }
  }

  public function stampa_modulo_evento(Request $request, $id_modulo){
    //$sub = Subscription::findOrFail($id_subscription);
    $event = Event::findOrFail(Session::get('work_event'));
    $oratorio = Oratorio::findOrFail($event->id_oratorio);
    //utente a cui è intestata l'iscrizione
    //$user = User::findOrFail($sub->id_user);


    $padre = "";
    $madre = "";

    $storagePath  = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();

    $modulo = Modulo::find($id_modulo);
    $template = new \PhpOffice\PhpWord\TemplateProcessor($storagePath.$modulo->path_file);

    $template->setValue('nominativo', '');
    $template->cloneBlock('dati_anagrafici');

    $template->setValue('nome_oratorio', $oratorio->nome);
    $template->setValue('email_oratorio', $oratorio->email);
    $template->setValue('nome_parrocchia', $oratorio->nome_parrocchia);
    $template->setValue('indirizzo_parrocchia', $oratorio->indirizzo_parrocchia);
    $template->setValue('nome_diocesi', $oratorio->nome_diocesi);
    $template->setValue('luogo_data_modulo', $oratorio->luogo_firma_moduli.", ...................");
    $template->setValue('nome_evento', $event->nome);
    $template->setValue('id_subscription', ".....");
    $template->setValue('padre', "");
    $template->setValue('madre', "");
    $template->setValue('figlio', "");
    $template->setValue('patologie', "");
    $template->setValue('allergie', "");
    $template->setValue('note', "");
    $template->setValue('luogo_nascita', "");
    $template->setValue('data_nascita', "");
    $template->setValue('comune_residenza', "");
    $template->setValue('indirizzo', "");
    $template->setValue('tessera_sanitaria', "");
    $template->setValue('telefono', "");
    $template->setValue('cellulare', "");
    $template->setValue('email', "");
    $template->setValue('cellulare_genitore', "");
    $template->setValue('email_genitore', "");

    $template->setValue('classe_frequentata', '');

    $template->setValue('consenso_affiliazione_si', "");
    $template->setValue('consenso_affiliazione_no', "");

    $template->setValue('consenso_dati_sanitari_si', "");
    $template->setValue('consenso_dati_sanitari_no', "");

    //specifiche generali
    $importo_totale = 0;
    $acconto_totale = 0;
    $da_pagare = 0;
    $specs = (new EventSpec)->select()
    ->where([['event_specs.id_event', $event->id], ['event_specs.general', 1]])
    ->orderBy('event_specs.ordine', 'asc')->get();
    if(count($specs)>0){
      $template->cloneRow('specifica_g', count($specs));
      $i = 1;
      foreach($specs as $spec){
        $template->setValue('specifica_g#'.$i, $spec->label);
        $template->setValue('valore_g#'.$i, "");
        $template->setValue('costo_g#'.$i, '');
        $template->setValue('acconto_g#'.$i, '');
        $template->setValue('pagato_g#'.$i, '');
        $i++;
      }
    }

    //specifiche Settimanali
    $weeks = (new Week)->select('id', 'from_date', 'to_date')->where('id_event', $event->id)->orderBy('from_date', 'asc')->get();
    if(count($weeks)>0){
      $template->cloneBlock('settimana', count($weeks));
      $w = 1;
      foreach($weeks as $week){
        $i = 1;
        $template->setValue('nome_settimana#'.$w, "Settimana $w - dal ".$week->from_date." al ".$week->to_date);
        $specs = (new EventSpec)->select()
        ->where([['event_specs.id_event', $event->id], ['event_specs.general', 0]])
        ->orderBy('event_specs.ordine', 'asc')->get();
        if(count($specs)>0){
          //prima di clonare la riga, devo sapere quante sono dal json_decode
          $c=0;
          foreach($specs as $spec){
            $valid = json_decode($spec->valid_for, true);
            if(isset($valid[$week->id]) && $valid[$week->id] == 1) $c++;
          }
          if($c>0) $template->cloneRow('specifica_w#'.$w, $c);
          //ora posso popolare la tabella clonata
          foreach($specs as $spec){
            $valid = json_decode($spec->valid_for, true);
            if(isset($valid[$week->id]) && $valid[$week->id] == 1){
              $template->setValue('specifica_w#'.$w.'#'.$i, $spec->label);
              $template->setValue('valore_w#'.$w.'#'.$i, '');
              $costi = json_decode($spec->price, true);
              $acconti = json_decode($spec->acconto, true);
              if(isset($acconti[$week->id])){
                $acconto = $acconti[$week->id];
              }else{
                $acconto = 0;
              }
              $template->setValue('costo_w#'.$w.'#'.$i, "");
              $template->setValue('acconto_w#'.$w.'#'.$i, "");
              $template->setValue('pagato_w#'.$w.'#'.$i, '');
              $i++;
            }
          }
        }
        $w++;
      }
    }else{
      $template->deleteBlock('settimana');
    }

    //salvo il file docx/pdf nella temp
		$filename = "/temp/subscription_preview";
		$storagePath  = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();
		if(!Storage::exists("public/temp")){
			Storage::makeDirectory("public/temp", 0755, true);
		}

		//$path = sys_get_temp_dir().$filename.".docx";
		$path = $storagePath.$filename.".docx";
		$output = $storagePath;
		$template->saveAs($path);

		//converto il file in pdf
		$exec = "unoconv -f pdf ".$path;
		shell_exec($exec);
		//stampo 1/2 pagine per foglio in base alle impostazioni
		$response_file = $output.$filename.".pdf";
		switch($event->pagine_foglio){
			case 2:
			$cmd = "pdfjam --nup 2x1 --landscape --a4paper --outfile ".$output."/".$filename."-2up.pdf ".$response_file;
			shell_exec($cmd);
			$response_file = $output.$filename."-2up.pdf";
			break;
		}
		return response()->file($response_file);

  }
}
