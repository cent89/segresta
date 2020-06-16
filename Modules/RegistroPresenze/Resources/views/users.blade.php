

{{ $dataTable_registro_presenze_utente->table() }}


{{ $dataTable_registro_presenze_utente->scripts() }}
<script>

$(document).ready(function(){
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': '{{csrf_token()}}'
    }
  });

  $('button').removeClass('dt-button');

  // Editor Inline
  $("#dataTable_registro_presenze_utente").on('dblclick', 'tbody td', function (e) {
    if("{{ !Auth::user()->can('edit-registro_presenze') }}") return;
    window.LaravelDataTables["dataTable_registro_presenze_utente-editor"].inline(this, {
      onBlur: 'submit',
      submit: 'allIfChanged'
    });
  });

  // Editor edit
  $("#dataTable_registro_presenze_utente").on('click', 'button#editor_edit', function (e) {
    e.preventDefault();
    if("{{ !Auth::user()->can('edit-registro_presenze') }}") return;
    window.LaravelDataTables["dataTable_registro_presenze_utente-editor"].edit( $(this).closest('tr'), {
      title: 'Modifica',
      buttons: 'Aggiorna'
    });
  });

  // Editor delete
  $("#dataTable_registro_presenze_utente").on('click', 'button#editor_delete', function (e) {
    e.preventDefault();
    if("{{ !Auth::user()->can('edit-registro_presenze') }}") return;
    window.LaravelDataTables["dataTable_registro_presenze_utente-editor"].remove( $(this).closest('tr'), {
      title: 'Cancella record',
      message: 'Sei sicuro di voler eliminare la presenza selezionata?',
      buttons: 'Cancella record'
    } );
  } );


});

function aggiungi_filtri_colonne(){
  //filtro sulle colonne
  $('#dataTable_registro_presenze_utente thead tr').clone(true).appendTo( '#dataTable_registro_presenze_utente thead' );
  $('#dataTable_registro_presenze_utente thead tr:eq(1) th:visible').each( function (i) {
    // $(this).unbind();
    switch(i){
      case 0: // data
      $(this).html("<input type='text' class='data'/>");
      break;

      case 1: // utente
      $(this).html("<select style='width: 100%' id='id_user'></select>");
      break;

      default:
      $(this).html( "" );
      break;
    }



    // Faccio il parse del testo inserito dall'utente prima di filtrarlo

    $( 'input, select', this ).on( 'keyup change', function () {
      if(this.value == ""){
        window.LaravelDataTables["dataTable_registro_presenze_utente"].columns().search('').draw();
      }else{
        if (window.LaravelDataTables["dataTable_registro_presenze_utente"].column(i).search() !== this.value){
          valore_filtro = this.value;
          switch(i){
            case 0:
            valore_filtro = moment(this.value, "DD/MM/YYYY").format("YYYY-MM-DD");
            break;

            default:
            valore_filtro = this.value;
            break;
          }
          window.LaravelDataTables["dataTable_registro_presenze_utente"].column(i).search( valore_filtro ).draw();
        }
      }
    } );
  });

  $(".data").datepicker({
  });

  $('#id_user').select2({
    placeholder: "Seleziona un'utente",
    ajax: {
      method: 'GET',
      url: "{{ route('user.users_list') }}",
      dataType: 'json',
      data: function(params) {
        return {
          term: params.term || '',
          page: params.page || 1
        }
      },
      cache: true
    }
  });
}

function show_compila_certificazione(id_certificazione){
  $("#modal_dettaglio").load("{!! url('admin/certificazione_utente/compila?id_certificazione="+id_certificazione+"') !!}");
  $("#modal_entity").modal('show');
}

</script>
