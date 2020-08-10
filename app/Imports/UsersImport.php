<?php

namespace App\Imports;

use Modules\User\Entities\User;
use Modules\Oratorio\Entities\UserOratorio;
use App\RoleUser;
use App\Comune;
use App\Nazione;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\Importable;
use Carbon\Carbon;

HeadingRowFormatter::default('none');

class UsersImport implements ToModel, WithHeadingRow
{
  /**
  * @param array $row
  *
  * @return \Illuminate\Database\Eloquent\Model|null
  */
  public function model(array $row)
  {
    $user = new User;
    $user->name = $row['nome'];
    $user->cognome = $row['cognome'];
    $user->email = strtolower($row['email']);
    // $data = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['data_nascita']);
    // $user->nato_il = Carbon::instance($data)->format('d/m/Y');
    $user->nato_il = $row['data_nascita'];
    $user->sesso = $row['sesso'];
    $user->via = $row['indirizzo']==null?'': $row['indirizzo'];;
    $user->cell_number = $row['telefono']==null?'': $row['telefono'];
    $user->consenso_affiliazione = $row['trattamento_dati']=='SI'?true:false;

    // NASCITA
    if($row['provincia_nascita'] == 'EE'){
      //estero
      $nazione_nascita = Nazione::where('nome_stato', strtolower($row['comune_nascita']))->first();
      if($nazione_nascita != null){
        $user->id_nazione_nascita = $nazione_nascita->id;
      }
    }else{
      $comune_nascita = Comune::where('nome', strtolower($row['comune_nascita']))->first();
      if($comune_nascita != null){
        $user->id_comune_nascita = $comune_nascita->id;
        $user->id_provincia_nascita = $comune_nascita->id_provincia;
      }
      $user->id_nazione_nascita = 118;
    }

    // RESIDENZA
    $comune_residenza = Comune::where('nome', strtolower($row['comune_residenza']))->first();
    if($comune_residenza != null){
      $user->id_comune_residenza = $comune_residenza->id;
      $user->id_provincia_residenza = $comune_residenza->id_provincia;
    }

    $user->note = $row['note'];

    $user->save();

    UserOratorio::create(['id_user' => $user->id, 'id_oratorio' => 1]);
    RoleUser::create(['user_id' => $user->id, 'role_id' => 2]);

    return $user;
  }
}
