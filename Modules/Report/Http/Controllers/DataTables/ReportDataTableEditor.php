<?php

namespace Modules\Report\Http\Controllers\DataTables;

use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTablesEditor;
use Illuminate\Database\Eloquent\Model;
use Modules\Report\Entities\Report;
use Illuminate\Http\Request;
use Session;

class ReportDataTableEditor extends DataTablesEditor
{
  protected $model = Report::class;
  protected $messages = [
    'titolo.required' => 'Il titolo del report è obbligatorio',
  ];

  /**
  * Get create action validation rules.
  *
  * @return array
  */
  public function createRules()
  {
    return [
      'titolo' => 'required'
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
      'titolo' => 'required',
    ];
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

}
