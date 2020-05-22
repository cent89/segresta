<?php

use Illuminate\Http\Request;
use Modules\User\Entities\User;
use Modules\Oratorio\Entities\Oratorio;
use Modules\Oratorio\Entities\UserOratorio;
use Modules\Event\Entities\Event;
use Modules\Event\Entities\EventSpec;
use Modules\Event\Entities\EventSpecValue;
use Modules\Oratorio\Entities\TypeSelect;
use Modules\Oratorio\Entities\Type;
use Modules\Subscription\Entities\Subscription;
use Modules\Subscription\Http\Controllers\SubscriptionController;
use Modules\Famiglia\Entities\ComponenteFamiglia;
use Modules\Modulo\Entities\Modulo;
use Modules\Event\Entities\Week;
use Modules\Attributo\Entities\Attributo;
use Modules\Attributo\Entities\AttributoUser;
use App\RoleUser;
use App\Role;
use Carbon\Carbon;
use App\Nazione;
use App\Provincia;
use App\Comune;
use App\Notifications\EmailMessage;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('login', function (Request $request){
  if($request->email == ''){
    return response()->json(['result' => 'error', 'message' => 'Errore nel login!']);
  }

  $user = User::where('email', $request->email)->first();
  if($user != null){
    if(!Hash::check($request->password, $user->password)){
      return response()->json(['result' => 'error', 'message' => 'Email o password errati!']);
    }
    if($user->email_verified_at == null){
      $user->sendEmailVerificationNotification();
      return response()->json(['result' => 'error', 'message' => 'Attenzione, la tua email non risulta verificata. Controlla la tua casella email!']);
    }
    // Aggiorno il token fcm
    $user->fcmToken = $request->fcmToken;
    // Genero il token per le api
    if($user->api_token == null){
      $user->api_token = Str::random(60);
    }
    $user->save();
    // Compongo il risultato per l'app
    $result = [];
    $user_oratorio = UserOratorio::where('id_user', $user->id)->first();
    $oratorio = Oratorio::find($user_oratorio->id_oratorio);
    $result['id'] = $user->id;
    $result['full_name'] = $user->full_name;
    $result['nome_oratorio'] = $oratorio->nome;
    $result['email'] = $user->email;
    $result['id_oratorio'] = $oratorio->id;
    $result['api_token'] = $user->api_token;

    if($oratorio->logo != '' && $oratorio->logo != null){
      $result['logo_oratorio'] = url(Storage::url('public/'.$oratorio->logo));
      $result['hasLogo'] = true;
    }else{
      $result['logo_oratorio'] = asset('/assets/logo_new_orizzontale_b.png');
      $result['hasLogo'] = false;
    }
    return response()->json(['result' => 'ok', 'user' => $result]);
  }else{
    return response()->json(['result' => 'error', 'message' => 'Email o password errati!']);
  }

});

Route::post('form_registrazione', function (Request $request){

  // Form
  $form = [
    'schema' => ['title' => 'Registrazione', 'type' => 'object'],
    'uiSchema' => []
  ];

  $properties = [];
  $uiSchema = [];
  $required = [];

  $properties['generali'] = [
    'type' => 'string',
    'title' => 'Informazioni generali',
    'displayLabel' => false
  ];
  $uiSchema['generali'] = ["ui:widget" => 'CustomHeading'];
  $uiSchema['ui:order'][] = 'generali';


  $properties['name'] = [
    'type' => 'string',
    'title' => 'Nome',
    'default' => '',
    'minLength' => 2
  ];
  $required[] = 'name';

  $properties['cognome'] = [
    'type' => 'string',
    'title' => 'Cognome',
    'default' => '',
    'minLength' => 2
  ];
  $required[] = 'cognome';

  $properties['email'] = [
    'type' => 'string',
    'title' => 'Email',
    'format' => 'email',
    'default' => '',
    'minLength' => 5
  ];
  $required[] = 'email';

  $properties['password'] = [
    'type' => 'string',
    'title' => 'Password',
    'default' => '',
    'minLength' => 8
  ];
  $required[] = 'password';
  $uiSchema['password'] = ["ui:widget" => 'PasswordInput'];

  $properties['conferma_password'] = [
    'type' => 'string',
    'title' => 'Conferma Password',
    'default' => '',
    'minLength' => 8
  ];
  $required[] = 'conferma_password';
  $uiSchema['conferma_password'] = ["ui:widget" => 'PasswordInput'];

  $properties['cell_number'] = [
    'type' => 'string',
    'title' => 'Cellulare',
    'default' => '',
    'minLength' => 2
  ];
  $required[] = 'cell_number';

  $properties['cod_fiscale'] = [
    'type' => 'string',
    'title' => 'Codice Fiscale',
    'default' => ''
  ];

  $properties['tessera_sanitaria'] = [
    'type' => 'string',
    'title' => 'Tessera Sanitaria',
    'default' => ''
  ];

  $opzioni = array();
  $opzioni[] = ['type' => 'string', 'title' => 'Maschio', 'enum' => ['M']];
  $opzioni[] = ['type' => 'string', 'title' => 'Femmina', 'enum' => ['F']];
  $properties['sesso'] = [
    'type' => 'string',
    'title' => 'Sesso',
    'anyOf' => $opzioni,
    'default' => 'M'
  ];

  $properties['consenso_affiliazione'] = [
    'type' => 'boolean',
    'title' => 'Consenso affiliazione e ricezione comunicazioni',
    'default' => false
  ];
  $uiSchema['consenso_affiliazione'] = ["ui:widget" => 'radio'];

  $properties['nascita'] = [
    'type' => 'string',
    'title' => 'Luogo e data di nascita',
    'displayLabel' => false
  ];
  $uiSchema['nascita'] = ["ui:widget" => 'CustomHeading'];

  $properties['nato_il'] = [
    'type' => 'string',
    'default' => Carbon::now()->toDateString(),
    'title' => 'Data di nascita',
  ];
  $required[] = 'nato_il';
  $uiSchema['nato_il'] = ["ui:widget" => 'CustomDatePicker'];

  $opzioni = array();
  foreach(Nazione::orderBy('nome_stato', 'ASC')->get() as $option){
    $opzioni[] = ['type' => 'number', 'title' => $option->nome_stato, 'enum' => [$option->id]];
  };
  $properties['id_nazione_nascita'] = [
    'type' => 'number',
    'title' => 'Nazione di nascita',
    'anyOf' => $opzioni,
    'default' => 118
  ];

  $properties['residenza'] = [
    'type' => 'string',
    'title' => 'Residenza',
    'displayLabel' => false
  ];
  $uiSchema['residenza'] = ["ui:widget" => 'CustomHeading'];

  $opzioni = array();
  foreach(Comune::orderBy('nome', 'ASC')->get() as $option){
    $opzioni[] = [
      'name' => $option->nome." (".$option->provincia->sigla_automobilistica.")",
      'id' => $option->id,
      'checked' => false
    ];
  };
  $properties['id_comune_residenza'] = [
    'type' => 'number',
    'title' => 'Comune di residenza',
    'anyOf' => $opzioni,
    'default' => 0
  ];
  $uiSchema['id_comune_residenza'] = ["ui:widget" => 'SelectComune'];

  $properties['via'] = [
    'type' => 'string',
    'title' => 'Indirizzo',
    'default' => '',
    'minLength' => 2
  ];
  $required[] = 'via';

  $properties['dati_sanitari'] = [
    'type' => 'string',
    'title' => 'Dati sanitari',
    'displayLabel' => false
  ];
  $uiSchema['dati_sanitari'] = ["ui:widget" => 'CustomHeading'];

  $properties['patologie'] = [
    'type' => 'string',
    'title' => 'Patologie',
    'default' => ''
  ];
  $properties['allergie'] = [
    'type' => 'string',
    'title' => 'Allergie',
    'default' => ''
  ];
  $properties['note'] = [
    'type' => 'string',
    'title' => 'Note',
    'default' => ''
  ];

  //Attributi
  $attributi = Attributo::where([['hidden', 0], ['id_oratorio', 1]])->orderBy('ordine', 'ASC');
  if($attributi->count() > 0){
    $properties['attributi'] = [
      'type' => 'string',
      'title' => 'Informazioni aggiuntive',
      'displayLabel' => false
    ];
    $uiSchema['attributi'] = ["ui:widget" => 'CustomHeading'];

    foreach($attributi->get() as $attributo){
      switch($attributo->id_type){
        case Type::TEXT_TYPE:
        $properties['att_'.$attributo->id] = [
          'type' => 'string',
          'title' => $attributo->nome,
          'default' => ''
        ];
        $uiSchema['att_'.$attributo->id] = ["ui:placeholder" => ''];
        break;

        case Type::BOOL_TYPE:
        $properties['att_'.$attributo->id] = [
          'type' => 'boolean',
          'title' => $attributo->nome,
          'default' => ''
        ];
        $uiSchema['att_'.$attributo->id] = ["ui:widget" => 'radio'];
        break;

        case Type::NUMBER_TYPE:
        $properties['att_'.$attributo->id] = [
          'type' => 'number',
          'title' => $attributo->nome,
          'default' => ''
        ];
        $uiSchema['att_'.$attributo->id] = ['ui:widget' => 'updown'];
        break;

        case Type::DATE_TYPE:
        $properties['att_'.$attributo->id] = [
          'type' => 'date',
          'title' => $attributo->nome,
          'default' => ''
        ];
        $uiSchema['att_'.$attributo->id] = [];
        break;

        default:
        $opzioni = array();
        $opzioni_names = array();
        foreach(TypeSelect::where('id_type', $attributo->id_type)->orderBy('ordine', 'ASC')->get() as $option){
          $opzioni[] = ['type' => 'number', 'title' => $option->option, 'enum' => [$option->id]];
        };
        $properties['att_'.$attributo->id] = [
          'type' => 'number',
          'title' => $attributo->nome,
          'anyOf' => $opzioni,
          'default' => '',
        ];
      }
    }
  }


  $form['schema']['properties'] = $properties;
  $form['schema']['required'] = $required;
  $uiSchema['ui:order'][] =  '*';
  $form['uiSchema'] = $uiSchema;


  return response()->json($form);
});

// Salva le informazioni sul profilo
Route::post('nuovo_utente', function (Request $request){
  try{
    // Prima faccio il check della mail
    if(User::where('email', $request->formData['email'])->count() > 0){
      return response()->json(['result' => 'error', 'title' => 'Attenzione', 'msg' => 'La mail inserita esiste già!']);
    }

    // Check della password
    if($request->formData['password'] != $request->formData['conferma_password']){
      return response()->json(['result' => 'error', 'title' => 'Attenzione', 'msg' => 'La password non coincide con quella di conferma']);
    }

    $user = new User();
    $user->email = $request->formData['email'];
    $user->password = Hash::make($request->formData['password']);

    $user->name = $request->formData['name'];
    $user->cognome = $request->formData['cognome'];
    $user->sesso = $request->formData['sesso'];
    $user->nato_il = Carbon::parse($request->formData['nato_il'])->format('d/m/Y');
    if($request->id_comune_nascita != null && $request->id_comune_nascita != ''){
      $comune = Comune::find($request->id_comune_nascita);
      $user->comuneNascita()->associate($comune);
      $user->provinciaNascita()->associate($comune->provincia);
    }
    $user->id_nazione_nascita = $request->formData['id_nazione_nascita'];
    $user->via = $request->formData['via'];
    $user->cod_fiscale = $request->formData['cod_fiscale'];
    $user->tessera_sanitaria = $request->formData['tessera_sanitaria'];
    $user->cell_number = $request->formData['cell_number'];
    $user->consenso_affiliazione = $request->formData['consenso_affiliazione'];
    $user->patologie = $request->formData['patologie'];
    $user->allergie = $request->formData['allergie'];
    $user->note = $request->formData['note'];
    $user->save();
    $user->sendEmailVerificationNotification();

    //salvo il link utente-oratorio
    $orat = new UserOratorio;
    $orat->id_user = $user->id;
    $orat->id_oratorio = 1;
    $orat->save();

    //aggiungo il ruolo
    $roles = Role::where([['name', 'user'], ['id_oratorio', 1]])->get();
    if(count($roles)>0){
      //creo il ruolo
      $role = new RoleUser;
      $role->user_id = $user->id;
      $role->role_id = $roles[0]->id;
      $role->save();
    }

    //salvo gli attributi
    foreach($request->formData as $key => $value){
      $att = explode('_', $key);
      if(count($att) == 2 && $att[0] == 'att'){
        $au = new AttributoUser();
        $au->id_attributo = intval($att[1]);
        $au->id_user = $user->id;
        $au->valore = $value;
        $au->save();
      }
    }

    return response()->json(['result' => 'ok', 'title' => 'Successo', 'msg' => 'Profilo salvato correttamente! Controlla la tua casella di posta per confermare il tuo indirizzo email']);
  }catch(\Exception $e){
    return response()->json(['result' => 'error', 'title' => 'Errore', 'msg' => 'Non è stato possibile salvare un nuovo utente. Riprovare.']);
  }
});

// Route per l'upload della foto profilo
Route::post('foto', function (Request $request){
  try{
    $user = User::find($request->id_user);
    if($user == null){
      return response()->json(['result' => 'error', 'title' => 'Errore']);
    }
    $path = $request->photo->store('profile', 'public');
    $user->photo = $path;
    $user->save();

    $url = url(Storage::url('public/'.$path));

    return response()->json(['result' => 'ok', 'path' => $url]);
  }catch(\Excepion $e){
    return response()->json(['result' => 'error', 'msg' => 'Errore nel caricamento dell\'immagine']);
  }

});

Route::middleware(['auth:api'])->group(function () {
  Route::post('logout', function (Request $request){
    $user = User::where('email', $request->email)->first();
    if($user != null){
      // Aggiorno il token fcm
      $user->fcmToken = null;
      $user->save();
      return response()->json(['result' => 'ok']);
    }else{
      return response()->json(['result' => 'error', 'message' => 'Logout fallito!']);
    }
  });

  Route::post('events', function (Request $request){
    if($request->email == '' || !$request->has('id_oratorio')){
      return response()->json(['result' => 'error', 'title' => 'Errore', 'msg' => 'Errore di autenticazione (1)']);
    }

    $user = User::where('email', $request->email)->first();
    if($user == null){
      return response()->json(['result' => 'error', 'title' => 'Errore', 'msg' => 'Errore di autenticazione (2)']);
    }

    $result = [];
    $now = Carbon::now()->toDateString();
    foreach( Event::where([['id_oratorio', $request->id_oratorio], ['active', 1], ['data_apertura', '<=', $now], ['data_chiusura', '>=', $now]])->orderBy('id', 'DESC')->get() as $event){
      if($event->max_posti == 0 || ($event->max_posti > 0 && $event->iscrizioni->count() <= $event->max_posti)){
        $r = ['nome' => $event->nome, 'id' => $event->id, 'color' => $event->color];
        $r['image'] = url(Storage::url('public/'.$event->image));
        array_push($result, $r);
      }
    }

    return response()->json($result);
  });

  Route::post('event', function (Request $request){
    if($request->email == '' || !$request->has('id_oratorio')){
      return response()->json(['result' => 'error', 'title' => 'Errore', 'msg' => 'Errore di autenticazione (1)']);
    }

    $user = User::where('email', $request->email)->first();
    if($user == null){
      return response()->json(['result' => 'error', 'title' => 'Errore', 'msg' => 'Errore di autenticazione (2)']);
    }

    $event = Event::where('id', $request->id_evento)->first();
    $result['event'] = ['nome' => $event->nome, 'id' => $event->id, 'color' => $event->color, 'descrizione' => $event->descrizione];
    if($event->image == null || $event->image == ''){
      // $result['image'] = null;
    }else{
      $result['event']['image'] = url(Storage::url('public/'.$event->image));
    }

    return response()->json($result);
  });

  Route::post('specifiche', function (Request $request){
    if($request->email == '' || !$request->has('id_oratorio')){
      return response()->json(['result' => 'error', 'title' => 'Errore', 'msg' => 'Errore di autenticazione (1)']);
    }

    $user = User::where('email', $request->email)->first();
    if($user == null){
      return response()->json(['result' => 'error', 'title' => 'Errore', 'msg' => 'Errore di autenticazione (2)']);
    }

    $event = Event::find($request->id_evento);

    // Form
    $form = [
      'schema' => ['title' => 'Iscrizione', 'type' => 'object'],
      'uiSchema' => []
    ];

    $properties = [];
    $uiSchema = [];
    $required = [];

    // Inserisco la scelta dell'utente se l'evento prevede la scelta di un membro della famiglia
    if($event->select_famiglia == 1){
      $padre = ComponenteFamiglia::getPadre($user->id);
      $madre = ComponenteFamiglia::getMadre($user->id);

      if($padre == null && $madre == null){
        return response()->json(['result' => 'error', 'title' => 'Famiglia', 'msg' => 'Non hai una indicato i componenti della famiglia nel tuo profilo']);
      }

      $opzioni = array();
      $opzioni[] = ['type' => 'number', 'title' => $user->full_name, 'enum' => [$user->id]];
      $opzioni[] = ['type' => 'number', 'title' => $padre->full_name, 'enum' => [$padre->id]];
      $opzioni[] = ['type' => 'number', 'title' => $madre->full_name, 'enum' => [$madre->id]];

      $properties['user'] = [
        'type' => 'number',
        'title' => 'Utente che vuoi iscrivere: ',
        'anyOf' => $opzioni
      ];

      $required[] = 'user';
      $uiSchema['ui:order'][] = 'user';
    }

    // Specifiche generali

    $specs = EventSpec::
    select('event_specs.id_type', 'event_specs.id', 'event_specs.label', 'event_specs.descrizione', 'event_specs.price', 'event_specs.acconto', 'event_specs.obbligatoria')
    ->where([['id_event', $request->id_evento], ['event_specs.general', 1], ['event_specs.hidden', 0]])
    ->orderBy('event_specs.ordine', 'ASC');

    if($specs->count() > 0){

      // Titolo della sezione
      $properties['generali'] = [
        'type' => 'string',
        'title' => 'Informazioni generali',
        'displayLabel' => false
      ];
      $uiSchema['generali'] = ["ui:widget" => 'CustomHeading'];
      $uiSchema['ui:order'][] = 'generali';


      foreach($specs->get() as $spec){
        if($spec->obbligatoria){
          $required[] = 'spec_0_'.$spec->id;
        }
        $uiSchema['ui:order'][] = 'spec_0_'.$spec->id;
        // // tipo specifica
        switch($spec->id_type){
          case Type::TEXT_TYPE:
          $properties['spec_0_'.$spec->id] = [
            'type' => 'string',
            'title' => $spec->label
          ];
          $uiSchema['spec_0_'.$spec->id] = ["ui:placeholder" => ''];
          break;

          case Type::BOOL_TYPE:
          $properties['spec_0_'.$spec->id] = [
            'type' => 'boolean',
            'title' => $spec->label,
            'default' => false,
            'description' => $spec->descrizione
          ];
          $uiSchema['spec_0_'.$spec->id] = ["ui:widget" => 'radio'];
          break;

          case Type::NUMBER_TYPE:
          $properties['spec_0_'.$spec->id] = [
            'type' => 'number',
            'title' => $spec->label
          ];
          $uiSchema['spec_0_'.$spec->id] = ['ui:widget' => 'updown'];
          break;

          case Type::DATE_TYPE:
          $properties['spec_0_'.$spec->id] = [
            'type' => 'date',
            'title' => $spec->label
          ];
          $uiSchema['spec_0_'.$spec->id] = [];
          break;

          default:
          $opzioni = array();
          foreach(TypeSelect::where('id_type', $spec->id_type)->orderBy('ordine', 'ASC')->get() as $option){
            $opzioni[] = ['type' => 'number', 'title' => $option->option, 'enum' => [$option->id]];
          };
          $properties['spec_0_'.$spec->id] = [
            'type' => 'number',
            'title' => $spec->label,
            'anyOf' => $opzioni
          ];
        }
      }
    }

    // Specifiche settimanali

    $weeks = Week::select('id', 'from_date', 'to_date')->where('id_event', $request->id_evento)->orderBy('from_date', 'asc');
    if($weeks->count() > 0){

      foreach($weeks->get() as $week){
        // Titolo della sezione
        $properties['settimana_'.$week->id] = [
          'type' => 'string',
          'title' => 'Settimana dal '.$week->from_date.' al '.$week->to_date,
          'displayLabel' => false
        ];
        $uiSchema['settimana_'.$week->id] = ["ui:widget" => 'CustomHeading'];
        $uiSchema['ui:order'][] = 'settimana_'.$week->id;


        $specs = EventSpec::
        select('event_specs.id_type', 'event_specs.id', 'event_specs.label',
        'event_specs.descrizione', 'event_specs.price', 'event_specs.acconto', 'event_specs.obbligatoria', 'valid_for')
        ->where([['id_event', $request->id_evento], ['event_specs.general', 0], ['event_specs.hidden', 0]])
        ->orderBy('event_specs.ordine', 'ASC');

        foreach($specs->get() as $spec){
          $valid = json_decode($spec->valid_for, true);
          $price = json_decode($spec->price, true);
          $acconto = json_decode($spec->acconto, true);
          if(count($price)==0) $price[$week->id]=0;
          if(count($acconto)==0) $acconto[$week->id]=0;


          if($valid[$week->id]==1){
            if($spec->obbligatoria){
              $required[] = 'spec_'.$week->id.'_'.$spec->id;
            }
            $uiSchema['ui:order'][] = 'spec_'.$week->id.'_'.$spec->id;
            // // tipo specifica
            switch($spec->id_type){
              case Type::TEXT_TYPE:
              $properties['spec_'.$week->id.'_'.$spec->id] = [
                'type' => 'string',
                'title' => $spec->label
              ];
              $uiSchema['spec_'.$week->id.'_'.$spec->id] = ["ui:placeholder" => 'ciao'];
              break;

              case Type::BOOL_TYPE:
              $properties['spec_'.$week->id.'_'.$spec->id] = [
                'type' => 'boolean',
                'title' => $spec->label,
                'default' => false
              ];
              $uiSchema['spec_'.$week->id.'_'.$spec->id] = ["ui:widget" => 'radio'];
              break;

              case Type::NUMBER_TYPE:
              $properties['spec_'.$week->id.'_'.$spec->id] = [
                'type' => 'number',
                'title' => $spec->label
              ];
              $uiSchema['spec_'.$week->id.'_'.$spec->id] = ['ui:widget' => 'updown'];
              break;

              case Type::DATE_TYPE:
              $properties['spec_'.$week->id.'_'.$spec->id] = [
                'type' => 'date',
                'title' => $spec->label
              ];
              $uiSchema['spec_'.$week->id.'_'.$spec->id] = [];
              break;

              default:
              $opzioni = array();
              foreach(TypeSelect::where('id_type', $spec->id_type)->orderBy('ordine', 'ASC')->get() as $option){
                $opzioni[] = ['type' => 'number', 'title' => $option->option, 'enum' => [$option->id]];
              };
              $properties['spec_'.$week->id.'_'.$spec->id] = [
                'type' => 'number',
                'title' => $spec->label,
                'anyOf' => $opzioni
              ];
            }
          }

        }


      }

    }

    $properties['trattamenti'] = [
      'type' => 'string',
      'title' => 'Trattamento dati personali',
      'displayLabel' => false
    ];
    $uiSchema['trattamenti'] = ["ui:widget" => 'CustomHeading'];
    $uiSchema['ui:order'][] = 'trattamenti';

    $properties['consenso_dati_sanitari'] = [
      'type' => 'boolean',
      'title' => 'Acconsento al trattamento dei miei dati sanitari',
      'default' => false
    ];
    $uiSchema['consenso_dati_sanitari'] = ["ui:widget" => 'radio'];

    $properties['consenso_affiliazione'] = [
      'type' => 'boolean',
      'title' => 'Acconsento alla ricezione di messaggi',
      'default' => false
    ];
    $uiSchema['consenso_affiliazione'] = ["ui:widget" => 'radio'];

    $properties['consenso_foto'] = [
      'type' => 'boolean',
      'title' => 'Acconsento al trattamento di foto e video',
      'default' => false
    ];
    $uiSchema['consenso_foto'] = ["ui:widget" => 'radio'];


    $form['schema']['properties'] = $properties;
    $uiSchema['ui:order'][] =  '*';
    $form['uiSchema'] = $uiSchema;
    $form['schema']['required'] = $required;

    return response()->json($form);
  });






  Route::post('salva_iscrizione', function (Request $request){
    if($request->email == ''){
      return response()->json();
    }

    $user = User::where('email', $request->email)->first();
    if($user == null){
      return response()->json();
    }

    // try{
    // Creo una nuova iscrizione
    $iscrizione = new Subscription;
    $iscrizione->id_event = $request->id_evento;
    $iscrizione->id_user = $user->id;
    $iscrizione->confirmed = 0;
    $iscrizione->type = 'APP';
    $iscrizione->save();

    foreach($request->formData as $key => $value){
      if($key == 'generali' || $key == 'settimanali') continue;
      if($key == 'consenso_dati_sanitari'){
        $iscrizione->consenso_dati_sanitari = $value;
        $iscrizione->save();
        continue;
      }
      if($key == 'consenso_foto'){
        $iscrizione->consenso_foto = $value;
        $iscrizione->save();
        continue;
      }
      if($key == 'consenso_affiliazione'){
        $iscrizione->consenso_affiliazione = $value;
        $iscrizione->save();
        continue;
      }
      if($key == 'user'){
        // è la specifica che contiene l'utente intestatario dell'iscrizione
        $iscrizione->id_user = $value;
        $iscrizione->save();
        continue;
      }

      $iscrizione->save();
      $key = explode('_', $key);
      $id_event_spec = $key[2];
      $id_week = $key[1];
      //cerco la EventSpec corrispondente
      $spec = EventSpec::find($id_event_spec);
      if($spec == null) continue;
      $spec_value = new EventSpecValue;
      $spec_value->id_eventspec = $spec->id;
      $spec_value->valore = $value;
      $spec_value->id_subscription = $iscrizione->id;
      $spec_value->id_week = $id_week;
      $spec_value->save();
    }

    return response()->json(['result' => 'ok', 'title' => 'Iscrizione avvenuta con successo', 'iscrizione_id' => $iscrizione->id]);

    // }catch(\Exception $e){
    //   return response()->json(['result' => 'error', 'title' => 'Errore', 'msg' => 'Impossibile salvare l\'iscrizione, contatta l\'amministratore!']);
    // }

  });

  Route::post('moduli', function (Request $request){
    if($request->email == ''){
      return response()->json();
    }

    $user = User::where('email', $request->email)->first();
    if($user == null){
      return response()->json();
    }

    $moduli = [];
    $iscrizione = Subscription::find($request->iscrizione_id);
    $array_moduli = json_decode($iscrizione->evento->id_moduli);
    foreach(Modulo::whereIn('id', $array_moduli)->orderBy('label', 'ASC')->get() as $modulo){
      $url = SubscriptionController::print_subscription(request()->merge(['id_modulo' => $modulo->id, 'type' => 'url']), $request->iscrizione_id);
      $moduli[] = ['name' => $modulo->label, 'url' => $url];
    }


    return response()->json(['moduli' => $moduli, 'grazie' => $iscrizione->evento->grazie]);
  });

  Route::post('profilo', function (Request $request){
    if($request->email == ''){
      return response()->json(['result' => 'error', 'title' => 'Errore', 'msg' => 'Errore di autenticazione (1)']);
    }

    $user = User::where('email', $request->email)->first();
    if($user == null){
      return response()->json(['result' => 'error', 'title' => 'Errore', 'msg' => 'Errore di autenticazione (2)']);
    }

    // Form
    $form = [
      'schema' => ['title' => 'Profilo', 'type' => 'object'],
      'uiSchema' => []
    ];

    $form['id_user'] = $user->id;
    if($user->photo != null && $user->photo != ''){
      if(substr($user->photo, 0, 4) == 'http'){
        $form['url_foto_profilo'] = $user->photo;
      }else{
        $form['url_foto_profilo'] = url(Storage::disk('public')->url($user->photo));
      }
    }

    $properties = [];
    $uiSchema = [];
    $required = [];

    $properties['generali'] = [
      'type' => 'string',
      'title' => 'Informazioni generali',
      'displayLabel' => false
    ];
    $uiSchema['generali'] = ["ui:widget" => 'CustomHeading'];
    $uiSchema['ui:order'][] = 'generali';


    $properties['name'] = [
      'type' => 'string',
      'title' => 'Nome',
      'default' => $user->name,
      'minLength' => 2
    ];
    $required[] = 'name';

    $properties['cognome'] = [
      'type' => 'string',
      'title' => 'Cognome',
      'default' => $user->cognome,
      'minLength' => 2
    ];
    $required[] = 'cognome';

    // $properties['email'] = [
    //   'type' => 'string',
    //   'title' => 'Email',
    //   'format' => 'email',
    //   'default' => $user->email,
    //   'minLength' => 5
    // ];
    // $required = 'name';

    $properties['cell_number'] = [
      'type' => 'string',
      'title' => 'Cellulare',
      'default' => $user->cell_number,
      'minLength' => 2
    ];
    $required[] = 'cell_number';

    $properties['cod_fiscale'] = [
      'type' => 'string',
      'title' => 'Codice Fiscale',
      'default' => $user->cod_fiscale
    ];
    $properties['tessera_sanitaria'] = [
      'type' => 'string',
      'title' => 'Tessera Sanitaria',
      'default' => $user->tessera_sanitaria
    ];
    $properties['consenso_affiliazione'] = [
      'type' => 'boolean',
      'title' => 'Consenso affiliazione e ricezione comunicazioni',
      'default' => boolval($user->consenso_affiliazione)
    ];
    $uiSchema['consenso_affiliazione'] = ["ui:widget" => 'radio'];

    $properties['nascita'] = [
      'type' => 'string',
      'title' => 'Luogo e data di nascita',
      'displayLabel' => false
    ];
    $uiSchema['nascita'] = ["ui:widget" => 'CustomHeading'];

    $properties['nato_il'] = [
      'type' => 'string',
      'default' => Carbon::createFromFormat('d/m/Y', $user->nato_il)->toDateString(),
      'title' => 'Data di nascita',
    ];
    $uiSchema['nato_il'] = ["ui:widget" => 'CustomDatePicker'];

    $opzioni = array();
    foreach(Nazione::orderBy('nome_stato', 'ASC')->get() as $option){
      $opzioni[] = ['type' => 'number', 'title' => $option->nome_stato, 'enum' => [$option->id]];
    };
    $properties['id_nazione_nascita'] = [
      'type' => 'number',
      'title' => 'Nazione di nascita',
      'anyOf' => $opzioni,
      'default' => $user->id_nazione_nascita
    ];

    $properties['residenza'] = [
      'type' => 'string',
      'title' => 'Residenza',
      'displayLabel' => false
    ];
    $uiSchema['residenza'] = ["ui:widget" => 'CustomHeading'];

    $opzioni = array();
    foreach(Comune::orderBy('nome', 'ASC')->get() as $option){
      $opzioni[] = [
        'name' => $option->nome." (".$option->provincia->sigla_automobilistica.")",
        'id' => $option->id,
        'checked' => $user->id_comune_residenza == $option->id
      ];
    };
    $properties['id_comune_residenza'] = [
      'type' => 'number',
      'title' => 'Comune di residenza',
      'anyOf' => $opzioni,
      'default' => $user->id_comune_residenza
    ];
    $uiSchema['id_comune_residenza'] = ["ui:widget" => 'SelectComune'];

    $properties['via'] = [
      'type' => 'string',
      'title' => 'Indirizzo',
      'default' => $user->via,
      'minLength' => 2
    ];
    $required[] = 'via';

    $properties['dati_sanitari'] = [
      'type' => 'string',
      'title' => 'Dati sanitari',
      'displayLabel' => false
    ];
    $uiSchema['dati_sanitari'] = ["ui:widget" => 'CustomHeading'];

    $properties['patologie'] = [
      'type' => 'string',
      'title' => 'Patologie',
      'default' => $user->patologie
    ];
    $properties['allergie'] = [
      'type' => 'string',
      'title' => 'Allergie',
      'default' => $user->allergie
    ];
    $properties['note'] = [
      'type' => 'string',
      'title' => 'Note',
      'default' => $user->note
    ];

    //Attributi
    $attributi = Attributo::where([['hidden', 0], ['id_oratorio', $request->id_oratorio]])->orderBy('ordine', 'ASC');
    if($attributi->count() > 0){
      $properties['attributi'] = [
        'type' => 'string',
        'title' => 'Informazioni aggiuntive',
        'displayLabel' => false
      ];
      $uiSchema['attributi'] = ["ui:widget" => 'CustomHeading'];

      foreach($attributi->get() as $attributo){
        $valore = AttributoUser::where([['id_user', $user->id],['id_attributo', $attributo->id]])->first();
        switch($attributo->id_type){
          case Type::TEXT_TYPE:
          $properties['att_'.$attributo->id] = [
            'type' => 'string',
            'title' => $attributo->nome,
            'default' => $valore!=null?$valore->valore:''
          ];
          $uiSchema['att_'.$attributo->id] = ["ui:placeholder" => ''];
          break;

          case Type::BOOL_TYPE:
          $properties['att_'.$attributo->id] = [
            'type' => 'boolean',
            'title' => $attributo->nome,
            'default' => $valore!=null?$valore->valore:''
          ];
          $uiSchema['att_'.$attributo->id] = ["ui:widget" => 'radio'];
          break;

          case Type::NUMBER_TYPE:
          $properties['att_'.$attributo->id] = [
            'type' => 'number',
            'title' => $attributo->nome,
            'default' => $valore!=null?$valore->valore:''
          ];
          $uiSchema['att_'.$attributo->id] = ['ui:widget' => 'updown'];
          break;

          case Type::DATE_TYPE:
          $properties['att_'.$attributo->id] = [
            'type' => 'date',
            'title' => $attributo->nome,
            'default' => $valore!=null?$valore->valore:''
          ];
          $uiSchema['att_'.$attributo->id] = [];
          break;

          default:
          $opzioni = array();
          $opzioni_names = array();
          foreach(TypeSelect::where('id_type', $attributo->id_type)->orderBy('ordine', 'ASC')->get() as $option){
            $opzioni[] = ['type' => 'number', 'title' => $option->option, 'enum' => [$option->id]];
          };
          $properties['att_'.$attributo->id] = [
            'type' => 'number',
            'title' => $attributo->nome,
            'anyOf' => $opzioni,
            'default' => $valore!=null?intval($valore->valore):'',
          ];
        }
      }
    }


    $form['schema']['properties'] = $properties;
    $uiSchema['ui:order'][] =  '*';
    $form['uiSchema'] = $uiSchema;
    $form['schema']['required'] = $required;


    return response()->json($form);
  });



  // Salva le informazioni sul profilo
  Route::post('salva_profilo', function (Request $request){
    try{
      if($request->email == ''){
        return response()->json(['result' => 'error', 'title' => 'Errore', 'msg' => 'Errore di autenticazione (1)']);
      }


      $user = User::where('email', $request->email)->first();
      if($user == null){
        return response()->json(['result' => 'error', 'title' => 'Errore', 'msg' => 'Errore di autenticazione (2)']);
      }

      $user->name = $request->formData['name'];
      $user->cognome = $request->formData['cognome'];
      $user->nato_il = Carbon::parse($request->formData['nato_il'])->format('d/m/Y');
      if($request->id_comune_nascita != null && $request->id_comune_nascita != ''){
        $comune = Comune::find($request->id_comune_nascita);
        $user->comuneNascita()->associate($comune);
        $user->provinciaNascita()->associate($comune->provincia);
      }
      $user->id_nazione_nascita = $request->formData['id_nazione_nascita'];
      $user->via = $request->formData['via'];
      $user->cod_fiscale = $request->formData['cod_fiscale'];
      $user->tessera_sanitaria = $request->formData['tessera_sanitaria'];
      $user->cell_number = $request->formData['cell_number'];
      $user->consenso_affiliazione = $request->formData['consenso_affiliazione'];
      $user->patologie = $request->formData['patologie'];
      $user->allergie = $request->formData['allergie'];
      $user->note = $request->formData['note'];
      $user->save();

      //salvo gli attributi
      foreach($request->formData as $key => $value){
        $att = explode('_', $key);
        if(count($att) == 2 && $att[0] == 'att'){
          $au = AttributoUser::where([['id_user', $user->id], ['id_attributo', intval($att[1])]])->first();
          if($au == null){
            $au = new AttributoUser;
            $au->id_attributo = intval($att[1]);
            $au->id_user = $user->id;
          }
          $au->valore = $value;
          $au->save();
        }
      }

      return response()->json(['result' => 'ok', 'title' => 'Successo', 'msg' => 'Profilo salvato correttamente!']);
    }catch(\Exception $e){
      return response()->json(['result' => 'error', 'title' => 'Errore', 'msg' => 'Errore nel salvataggio del profilo!']);
    }
  });

  Route::post('sendEmail', function (Request $request){
    try{
      if($request->email == ''){
        return response()->json(['result' => 'error', 'title' => 'Errore', 'msg' => 'Errore di autenticazione (1)']);
      }

      $oratorio = Oratorio::find($request->id_oratorio);

      Notification::route('mail', $oratorio->email)->notify(new EmailMessage($request->oggetto, $request->messaggio));

      return response()->json(['result' => 'ok', 'title' => 'Ok!', 'msg' => 'Messaggio inviato correttamente!']);
    }catch(\Exception $e){
      return response()->json(['result' => 'error', 'title' => 'Errore', 'msg' => 'Errore nell\'invio del messaggio']);
    }
  });


});
