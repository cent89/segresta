<?php

namespace Modules\RegistroPresenze\Http\DataTables;

use Modules\RegistroPresenze\Entities\RegistroPresenze;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTablesEditor;
use Storage;

class RegistroPresenzeDataTableEditor extends DataTablesEditor
{
  protected $model = RegistroPresenze::class;

  protected $messages = [
    'titolo.required' => 'Il nome dell\'elenco è obbligatorio',
    'data.required' => 'Devi indicare una data',
    'data.date_format' => 'La data deve essere nel formato GG/MM/AAAA',
  ];

  /**
  * Get create action validation rules.
  *
  * @return array
  */
  public function createRules()
  {
    return [
      'titolo'  => 'required',
      'data' => 'required|date_format:d/m/Y',
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
      'titolo'  => 'required',
      'data' => 'required|date_format:d/m/Y',
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

  public function created(Model $model, array $data)
  {


    return $model;
  }

  public function updating(Model $model, array $data)
  {
    return $data;
  }
  public function deleted(Model $model, array $data){
  }
}
