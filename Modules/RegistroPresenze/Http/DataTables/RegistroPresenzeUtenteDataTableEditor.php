<?php

namespace Modules\RegistroPresenze\Http\DataTables;

use Modules\RegistroPresenze\Entities\RegistroPresenzeUtente;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTablesEditor;
use Storage;

class RegistroPresenzeUtenteDataTableEditor extends DataTablesEditor
{
  protected $model = RegistroPresenzeUtente::class;

  protected $messages = [
    // 'nome.required' => 'Il nome è richiesto',
    // 'cognome.required' => 'Il cognome è richiesto',
    // 'email.required' => 'L\'indirizzo email è richiesto',
    // 'data_arrivo.required' => 'La data di arrivo è richiesta',
    // 'data_arrivo.date_format' => 'La data di arrivo deve essere indicata nel formato GG/MM/AAAA',
    // 'data_partenza.required' => 'La data di partenza è richiesta',
    // 'data_partenza.date_format' => 'La data di partenza deve essere indicata nel formato GG/MM/AAAA',
  ];

  /**
  * Get create action validation rules.
  *
  * @return array
  */
  public function createRules()
  {
    return [
      // 'nome' => 'required',
      // 'cognome' => 'required',
      // 'data_arrivo' => 'required|date_format:d/m/Y',
      // 'data_partenza' => 'required|date_format:d/m/Y',
    ];
  }

  public function createMessages(){
    return $this->messages;
  }

  /**
  * Get edit action validation rules.
  *
  * @param Model $model
  * @return array
  */
  public function editRules(Model $model)
  {
    return [
      // 'nome' => 'required',
      // 'cognome' => 'required',
      // 'data_arrivo' => 'required|date_format:d/m/Y',
      // 'data_partenza' => 'required|date_format:d/m/Y',
    ];
  }

  public function editMessages(){
    return $this->messages;
  }

  /**
  * Get remove action validation rules.
  *
  * @param Model $model
  * @return array
  */
  public function removeRules(Model $model)
  {
    return [];
  }

  public function creating(Model $model, array $data)
  {
    return $data;
  }

  public function updating(Model $model, array $data)
  {
    return $data;
  }

  public function deleted(Model $model, array $data){

  }
}
