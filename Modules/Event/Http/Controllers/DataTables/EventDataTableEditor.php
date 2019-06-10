<?php

namespace Modules\Event\Http\Controllers\DataTables;

use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTablesEditor;
use Illuminate\Database\Eloquent\Model;
use Modules\Event\Entities\Event;
use Modules\Oratorio\Entities\Oratorio;
use Session;

class EventDataTableEditor extends DataTablesEditor
{
  protected $model = Event::class;

  /**
  * Get create action validation rules.
  *
  * @return array
  */
  public function createRules()
  {
    return [];
  }

  public function createMessages(){
    return [];
  }

  /**
  * Get edit action validation rules.
  *
  * @param Model $model
  * @return array
  */
  public function editRules(Model $model)
  {
    return [];
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
    // if($model->id == Auth::user()->last_id_event){
    //   $oratorio->last_id_event = null;
    //   $oratorio->save();
    // }
  }

}
