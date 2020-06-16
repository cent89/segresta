<?php

namespace Modules\RegistroPresenze\Http\DataTables;

use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Modules\RegistroPresenze\Entities\RegistroPresenze;
use Form;
use DB;
use Auth;
use Storage;
use Session;

class RegistroPresenzeDataTable extends DataTable
{
  public function __construct(){
    $this->dataTableVariable = 'dataTable_registro_presenze';
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
    ->addColumn('aperto_display', function($entity){
      return view('checkbox', ['value' => $entity->aperto]);
    })
    ->addColumn('event_display', function($entity){
      return $entity->evento->nome;
    })
    ->addColumn('action', function($entity){
      $edit = "<button class='btn btn-sm btn-primary btn-block' id='editor_edit'><i class='fas fa-pen'></i></button>";
      $delete = "<button class='btn btn-sm btn-danger btn-block' id='editor_delete'><i class='fas fa-trash'></i></button>";
      $apri = "<button class='btn btn-sm btn-primary btn-block' onclick='apri_registro(".$entity->id.")'><i class='fas fa-user-check'></i></button>";
      // $download =Session::get('work_event')Session::get('work_event')Session::get('work_event')Session::get('work_event')Session::get('work_event') Form::open(['method' => 'GET', 'route' => ['certificazione.download', $entity->id]])."<button class='btn btn-sm btn-primary btn-block'><i class='fas fa-cloud-download-alt'></i></button>".Form::close();

      // if($entity->menuCliente->count() > 0){
      //   $delete = "<button class='btn btn-sm btn-danger btn-block' id='editor_delete' disabled ><i class='fas fa-trash'></i></button>";
      // }

      return $edit.$apri.$delete;
    })
    ->rawColumns(['action', 'aperto_display']);
  }


  /**
  * Get query source of dataTable.
  *
  * @param \App\RegistroPresenze $model
  * @return \Illuminate\Database\Eloquent\Builder
  */
  public function query(RegistroPresenze $model)
  {
    return $model->newQuery()
    ->where('id_oratorio', Session::get('session_oratorio'))
    ->orderBy('data', 'DESC');
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
      ->text('<i class="fas fa-plus"></i> Nuovo registro')
      ->formTitle('Nuovo registro')
      ->formMessage('Crea un nuovo registro')
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
      // ->responsive()
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
          Fields\Hidden::make('id_oratorio', 'id_oratorio')->default(Session::get('session_oratorio')),
          Fields\Hidden::make('id_event', 'id_event')->default(Session::get('work_event')),
          Fields\Text::make('titolo', 'Titolo'),
          Fields\Date::make('data', 'Data')->format('DD/MM/YYYY')->locale('it'),
          Fields\Radio::make('aperto', 'Attivo?')
          ->options([['label' => 'Si', 'value' => 1], ['label' => 'No', 'value' => 0]])
          ->separator("")
          ->default(1)
          ->unselectedValue(0),
        ])
      )->setTemplate('editor.editor');
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
        Column::make('titolo')->title('Titolo')->responsivePriority(1),
        Column::make('id_event')->title('Evento')->data('event_display'),
        Column::make('data')->title('Data')->responsivePriority(1),
        Column::make('aperto')->title('Aperto?')->data('aperto_display')->editField('aperto')->addClass('text-center'),
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
