<?php

namespace Modules\RegistroPresenze\Http\DataTables;

use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Modules\RegistroPresenze\Entities\RegistroPresenzeUtente;
use Form;
use DB;
use Auth;
use Storage;

class RegistroPresenzeUtenteDataTable extends DataTable
{
  public function __construct(){
    $this->dataTableVariable = 'dataTable_registro_presenze_utente';
  }

  /**
  * Build DataTable class.
  *
  * @param mixed $query Results from query() method.
  * @return \Yajra\DataTables\DataTableAbstract
  */
  public function dataTable($query)
  {
    return datatables()
    ->eloquent($query)
    ->setRowId('id')
    ->addColumn('presente_display', function($entity){
      return view('checkbox', ['value' => $entity->presente]);
    })
    ->addColumn('user_label', function($entity){
      return $entity->user->full_name;
    })
    ->addColumn('action', function($entity){
      $edit = "<button class='btn btn-sm btn-primary btn-block' id='editor_edit'><i class='fas fa-pen'></i></button>";
      $delete = "<button class='btn btn-sm btn-danger btn-block' id='editor_delete'><i class='fas fa-trash'></i></button>";

      // if($entity->menuCliente->count() > 0){
      //   $delete = "<button class='btn btn-sm btn-danger btn-block' id='editor_delete' disabled ><i class='fas fa-trash'></i></button>";
      // }

      return $edit.$delete;
    })
    ->rawColumns(['action']);
  }


  /**
  * Get query source of dataTable.
  *
  * @param \App\RegistroPresenzeUtente $model
  * @return \Illuminate\Database\Eloquent\Builder
  */
  public function query(RegistroPresenzeUtente $model)
  {
    $query =  $model->newQuery()
    ->orderBy('created_at', 'DESC');

    if($this->id_registro){
      $query->where('id_registro', $this->id_registro);
    }

    return $query;
  }

  /**
  * Optional method if you want to use html builder.
  *
  * @return \Yajra\DataTables\Html\Builder
  */
  public function html()
  {
    $buttons = [];
    array_push(
      $buttons, Button::make('create')
      ->editor('editor')
      ->className('btn btn-sm btn-primary')
      ->text('<i class="fas fa-plus"></i> Nuova presenza')
      ->formTitle('Nuovo presenza')
      ->formMessage('Crea un nuova presenza')
      ->formButtons(
        [Button::raw('Annulla')
        ->className('btn btn-secondary ml-2')
        ->actionClose(),
        Button::raw('Salva')
        ->className('btn btn-success ml-2')
        ->actionHandler('create')]
        )
      );

      return $this->builder()
      ->setTableId($this->dataTableVariable)
      ->columns($this->getColumns())
      ->minifiedAjax()
      ->responsive()
      ->orderCellsTop(true)
      // ->select()
      ->selectSelector('td:not(:last-child)')
      ->selectStyle('os')
      ->dom(count($buttons)==0?'rtip':'Brtip')
      ->orderBy(1, 'asc')
      ->buttons($buttons)
      ->editor(
        Editor::make()
        ->fields([
          Fields\Hidden::make('id_registro', 'id_registro')->default($this->id_registro),
          Fields\Select2::make('id_user', 'Utente')
          ->placeholder('Seleziona utente')
          ->ajax(['url' => route('user.users_list'), 'dataType' => 'json', 'data' => 'function(params) {
            return {
              term: params.term || "",
              page: params.page || 1
            }
          }']),
          Fields\Radio::make('presente', 'Presente?')
          ->options([['label' => 'Si', 'value' => 1], ['label' => 'No', 'value' => 0]])
          ->separator("")
          ->default(1)
          ->unselectedValue(0)
        ])

      )
      ->initComplete("function(settings, json){
        // aggiungi_filtri_colonne();
      }")
      ->setTemplate('editor.editor');
    }

    /**
    * Get columns.
    *
    * @return array
    */
    protected function getColumns()
    {
      return [
        // Column::make('id')->title('ID')->width('2%')->responsivePriority(1),
        Column::make('id_user')->title('Utente')->data('user_label'),
        Column::make('presente')->title('Presente?')->data('presente_display')->editField('presente')->addClass('text-center'),
        Column::computed('action')
        ->exportable(false)
        ->printable(false)
        ->width('5%')
        ->addClass('text-center')
        ->responsivePriority(1),
      ];
    }

    /**
    * Get filename for export.
    *
    * @return string
    */
    protected function filename()
    {
      return 'Cliente_' . date('YmdHis');
    }

  }
