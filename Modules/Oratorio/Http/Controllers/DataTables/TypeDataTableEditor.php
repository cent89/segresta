<?php

namespace Modules\Oratorio\Http\Controllers\DataTables;

use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTablesEditor;
use Illuminate\Database\Eloquent\Model;
use Modules\Oratorio\Entities\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Session;
use App\RoleUser;
use App\Role;

class TypeDataTableEditor extends DataTablesEditor
{
  protected $model = Type::class;

  public $message = [
    'label.required' => 'Devi specificare una nome',
    'description.required' => 'Devi specificare una descrizione',
  ];

  /**
  * Get create action validation rules.
  *
  * @return array
  */
  public function createRules()
  {
    return [
        'label' => 'required',
        'description' => 'required',
    ];
  }

  public function createMessages(){
    return $this->message;
  }

  public function editRules(Model $model)
  {
    return [
      'label' => 'required',
      'description' => 'required',
    ];
  }

  public function removeRules(Model $model)
  {
    return [];
  }

  public function editMessages(){
    return $this->message;
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
