
<div class="form-row">
  <div class="form-group col">
    {!! Form::label('id_user', 'Utente a cui intestare la certificazione (maggiorenne)') !!}<br>
    <select id="id_user" name="id_user" style="width: 100%"></select>
  </div>

  <div class="form-group col" style="display: none" id="div_famigliare">
    {!! Form::label('id_famigliare', 'Figlio') !!}<br>
    <select id="id_famigliare" name="id_famigliare" style="width: 100%"></select>
  </div>
</div>

<div class="form-row" style="width: 100%;">
  <div class="form-group col" style="height: 300px; width: 100%; text-align: center">
    <canvas id="signature-pad" class="signature-pad"></canvas>
    {!! Form::hidden('signature_image', null, ['id' => 'signature_image']) !!}
  </div>

</div>

<div class="form-row">
  <div class="form-group col">
    {!! Form::button('Salva', ['class' => 'btn btn-primary form-control', 'onclick' => 'salva_certificazione()']) !!}
  </div>
</div>

<script>
var canvas = document.getElementById("signature-pad");
var signaturePad;
function resizeCanvas(){
  var ratio =  Math.max(window.devicePixelRatio || 1, 1);
  canvas.width = 1000 * ratio;
  canvas.height = 300 * ratio;
  canvas.getContext("2d").scale(ratio, ratio);
}

$(document).ready(function(){

  signaturePad = new SignaturePad(canvas, {
    onEnd: function () {
      $("#signature_image").val(signaturePad.toDataURL());
    }
  });
  window.addEventListener("resize", resizeCanvas);
  resizeCanvas();

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

  $('#id_user').on('select2:select', function (e) {
    var data = e.params.data;
    $("#div_famigliare").show();

    $('#id_famigliare').select2({
      placeholder: "Seleziona un famigliare",
      allowClear: true,
      ajax: {
        method: 'POST',
        url: "{{ route('famiglia.users_list') }}",
        dataType: 'json',
        data: function(params) {
          return {
            term: params.term || '',
            page: params.page || 1,
            id_user: data.id
          }
        },
        cache: true
      }
    });

  });

});

function salva_certificazione(){
  if($("#id_user").val() == null || $("#id_user").val() == ''){
    bootbox.alert("Seleziona un'utente prima di salvare");
    return;
  }

  if(signaturePad.isEmpty()){
    bootbox.alert("Devi firmare prima di salvae!");
    return;
  }

  $.ajax({
    type: "POST",
    async: false,
    url: "{{ route('certificazione_utente.salva') }}",
    data: {
      id_certificazione: "{{ $id_certificazione }}",
      id_user: $("#id_user").val(),
      id_famigliare: $("#id_famigliare").val(),
      signature_image: $('#signature_image').val(),
      _token : "{{csrf_token()}}",
    },
    success: function(data){
      window.LaravelDataTables["dataTable_certificazione_utente"].ajax.reload();
      $("#modal_entity").modal('hide');
    },
    error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + XMLHttpRequest.responseText + "\n" + exception); },
  });
}




</script>
