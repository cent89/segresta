<?php
use Modules\Attributo\Entities\Attributo;
use Modules\Oratorio\Entities\Type;
use Modules\Event\Entities\EventSpec;
use Modules\Event\Entities\Event;
use Modules\Oratorio\Entities\Oratorio;
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Scripts -->
  <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
  <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->

  <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
  <script src="{{ asset('js/tinymce.min.js') }}"></script>
  <script src="{{ asset('js/jquery-ui.js') }}"></script>
  <script src="{{ asset('js/moment-with-locals.min.js') }}"></script>
  <!-- <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script> -->

  <!-- jQuery CDN - Slim version (=without AJAX) -->
  <!-- Popper.JS -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script> -->
  <!-- Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>


  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Bootstrap CSS CDN -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" >



  <!-- Styles -->
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}" >
  <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.1.2/css/rowGroup.dataTables.min.css">
  <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.dataTables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables/css/buttons.dataTables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables/css/rowReorder.dataTables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables/css/fixedHeader.dataTables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables/css/responsive.dataTables.min.css') }}">
  <!-- <link rel="stylesheet" href="{{ asset('plugins/datatables/css/bootstrap-datetimepicker.min.css') }}"> -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables/css/scroller.dataTables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables/css/fixedColumns.dataTables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables/css/select.bootstrap.min.css') }}">

  <!-- <link rel="stylesheet" href="{{ asset('css/bootstrap-glyphicons.css') }}"> -->
  <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/quill.snow.css') }}">
  <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">

  <link rel="stylesheet" href="{{ asset('plugins/editor/css/editor.dataTables.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/editor/css/editor.bootstrap.css') }}">
  <!-- <link rel="stylesheet" href="{{ asset('plugins/editor/css/editor.quill.css') }}"> -->
  <!-- <link rel="stylesheet" href="{{ asset('plugins/editor/css/editor.title.css') }}" > -->
  <!-- <link rel="stylesheet" href="{{ asset('css/font-awesome-animation.min.css')}}"> -->
  <!-- Custom styles for this template-->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/all.css') }}">




  <script src="{{ asset('plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables/js/dataTables.select.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables/js/buttons.print.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables/js/buttons.flash.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables/js/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables/js/jszip.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables/js/pdfmake.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables/js/vfs_fonts.js') }}"></script>
  <script src="{{ asset('plugins/datatables/js/dataTables.rowReorder.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables/js/dataTables.fixedHeader.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables/js/dataTables.keyTable.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables/js/dataTables.scroller.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables/js/dataTables.fixedColumns.min.js') }}"></script>
  <script src="https://cdn.datatables.net/rowgroup/1.1.2/js/dataTables.rowGroup.min.js"></script>

  <script src="{{ asset('js/select2.full.min.js') }}"></script>
  <!-- <script src="{{ asset('js/quill.min.js') }}"></script> -->
  <script src="{{ asset('js/datetime.js') }}"></script>
  <script src="{{ asset('js/popper.min.js') }}"></script>
  <script src="{{ asset('js/popper-utils.min.js') }}"></script>

  <script src="{{ asset('plugins/editor/js/dataTables.editor.js')}}"></script>
  <!-- <script src="{{ asset('plugins/editor/js/editor.autoComplete.js')}}"></script> -->
  <!-- <script src="{{ asset('plugins/editor/js/editor.quill.js')}}"></script> -->
  <script src="{{ asset('plugins/editor/js/editor.select2.js')}}"></script>
  <script src="{{ asset('plugins/editor/js/editor.title.js')}}"></script>
  <!-- <script src="{{ asset('/js/bootstrap-confirmation.js')}}"></script> -->
  <script src="{{ asset('/js/bootbox.all.min.js')}}"></script>
  <script src="{{ asset('/js/signature_pad.min.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/bootstrap.datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

  <script>
  //select2
  (function( factory ){
    if ( typeof define === 'function' && define.amd ) {
      // AMD
      define( ['jquery', 'datatables', 'datatables-editor'], factory );
    }
    else if ( typeof exports === 'object' ) {
      // Node / CommonJS
      module.exports = function ($, dt) {
        if ( ! $ ) { $ = require('jquery'); }
        factory( $, dt || $.fn.dataTable || require('datatables') );
      };
    }
    else if ( jQuery ) {
      // Browser standard
      factory( jQuery, jQuery.fn.dataTable );
    }
  }(function( $, DataTable ) {
    'use strict';


    if ( ! DataTable.ext.editorFields ) {
      DataTable.ext.editorFields = {};
    }

    var _fieldTypes = DataTable.Editor ?
    DataTable.Editor.fieldTypes :
    DataTable.ext.editorFields;

    _fieldTypes.select2 = {
      _addOptions: function ( conf, opts ) {
        var elOpts = conf._input[0].options;

        elOpts.length = 0;

        if ( opts ) {
          DataTable.Editor.pairs( opts, conf.optionsPair, function ( val, label, i ) {
            elOpts[i] = new Option( label, val );
          } );
        }
      },

      create: function ( conf ) {
        conf._input = $('<select/>')
        .attr( $.extend( {
          id: DataTable.Editor.safeId( conf.id )
        }, conf.attr || {} ) );

        var options = $.extend( {
          width: '100%'
        }, conf.opts );

        _fieldTypes.select2._addOptions( conf, conf.options || conf.ipOpts );
        conf._input.select2( options );

        var open;
        conf._input
        .on( 'select2:open', function () {
          open = true;
        } )
        .on( 'select2:close', function () {
          open = false;
        } );

        // On open, need to have the instance update now that it is in the DOM
        this.one( 'open.select2-'+DataTable.Editor.safeId( conf.id ), function () {
          conf._input.select2( options );

          if ( open ) {
            conf._input.select2( 'open' );
          }
        } );

        return conf._input[0];
      },

      get: function ( conf ) {
        var val = conf._input.val();
        val =  conf._input.prop('multiple') && val === null ?
        [] :
        val;

        return conf.separator ?
        val.join( conf.separator ) :
        val;
      },

      set: function ( conf, val ) {
        if ( conf.separator && ! $.isArray( val ) ) {
          val = val.split( conf.separator );
        }

        // Clear out any existing tags
        if ( conf.opts && conf.opts.tags ) {
          conf._input.val([]);
        }

        // The value isn't present in the current options list, so we need to add it
        // in order to be able to select it. Note that this makes the set action async!
        // It doesn't appear to be possible to add an option to select2, then change
        // its label and update the display
        var needAjax = false;

        if ( conf.opts && conf.opts.ajax ) {
          if ( $.isArray( val ) ) {
            for ( var i=0, ien=val.length ; i<ien ; i++ ) {
              if ( conf._input.find('option[value="'+val[i]+'"]').length === 0 ) {
                needAjax = true;
                break;
              }
            }
          }
          else {
            if ( conf._input.find('option[value="'+val+'"]').length === 0 ) {
              needAjax = true;
            }
          }
        }

        if ( needAjax && val ) {
          $.ajax( $.extend( {
            beforeSend: function ( jqXhr, settings ) {
              // Add an initial data request to the server, but don't
              // override `data` since the dev might be using that
              var initData = 'initialValue=true&value='+
              JSON.stringify(val);

              if ( typeof conf.opts.ajax.url === 'function' ) {
                settings.url = conf.opts.ajax.url();
              }

              if ( settings.type === 'GET' ) {
                settings.url += settings.url.indexOf('?') === -1 ?
                '?'+initData :
                '&'+initData;
              }
              else {
                settings.data = settings.data ?
                settings.data +'&'+ initData :
                initData;
              }
            },
            success: function ( json ) {
              var addOption = function ( option ) {
                if ( conf._input.find('option[value="'+option.id+'"]').length === 0 ) {
                  $('<option/>')
                  .attr('value', option.id)
                  .text( option.text )
                  .appendTo( conf._input );
                }
              }

              if ( $.isArray( json ) ) {
                for ( var i=0, ien=json.length ; i<ien ; i++ ) {
                  addOption( json[i] );
                }
              }
              else if ( json.results && $.isArray( json.results ) ) {
                for ( var i=0, ien=json.results.length ; i<ien ; i++ ) {
                  addOption( json.results[i] );
                }
              }
              else {
                addOption( json );
              }

              conf._input
              .val( val )
              .trigger( 'change', {editor: true} );
            }
          }, conf.opts.ajax ) );
        }
        else {
          conf._input
          .val( val )
          .trigger( 'change', {editor: true} );
        }
      },

      enable: function ( conf ) {
        $(conf._input).removeAttr( 'disabled' );
      },

      disable: function ( conf ) {
        $(conf._input).attr( 'disabled', 'disabled' );
      },

      // Non-standard Editor methods - custom to this plug-in
      inst: function ( conf ) {
        var args = Array.prototype.slice.call( arguments );
        args.shift();

        return conf._input.select2.apply( conf._input, args );
      },

      update: function ( conf, data ) {
        var val = _fieldTypes.select2.get( conf );

        _fieldTypes.select2._addOptions( conf, data );

        // Restore null value if it was, to let the placeholder show
        if ( val === null ) {
          _fieldTypes.select2.set( conf, null );
        }

        $(conf._input).trigger('change', {editor: true} );
      },

      focus: function ( conf ) {
        if ( conf._input.is(':visible') && conf.onFocus === 'focus' ) {
          conf._input.select2('open');
        }
      },

      owns: function ( conf, node ) {
        if ( $(node).closest('.select2-container').length || $(node).closest('.select2').length || $(node).hasClass('select2-selection__choice__remove') ) {
          return true;
        }
        return false;
      }
    };


  }));
  //END SELECT 2

  // Datepicker options
  $.datepicker.setDefaults({dateFormat: 'dd/mm/yyyy'});
  // End options

  function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
    sURLVariables = sPageURL.split('&'),
    sParameterName,
    i;

    for (i = 0; i < sURLVariables.length; i++) {
      sParameterName = sURLVariables[i].split('=');

      if (sParameterName[0] === sParam) {
        return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
      }
    }
  }

  </script>


</head>

<body class="d-flex flex-column h-100">

  @include('header')
  @include('header_event')

  <main class="py-4" role="main">
    @include('modals')
    @yield('content')
  </main>

  <footer>
    @include('footer')
  </footer>

  <!-- Scripts -->
  <script>
  (function( factory ){
    if ( typeof define === 'function' && define.amd ) {
      // AMD
      define( ['jquery', 'datatables', 'datatables-editor'], factory );
    }
    else if ( typeof exports === 'object' ) {
      // Node / CommonJS
      module.exports = function ($, dt) {
        if ( ! $ ) { $ = require('jquery'); }
        factory( $, dt || $.fn.dataTable || require('datatables') );
      };
    }
    else if ( jQuery ) {
      // Browser standard
      factory( jQuery, jQuery.fn.dataTable );
    }
  }(function( $, DataTable ) {
    'use strict';


    if ( ! DataTable.ext.editorFields ) {
      DataTable.ext.editorFields = {};
    }

    var _fieldTypes = DataTable.Editor ?
    DataTable.Editor.fieldTypes :
    DataTable.ext.editorFields;


    _fieldTypes.tinymce = {
      create: function ( conf ) {
        var that = this;
        conf._safeId = DataTable.Editor.safeId( conf.id );

        conf._input = $('<div><textarea id="'+conf._safeId+'"></textarea></div>');

        // Because tinyMCE uses an editable iframe, we need to destroy and
        // recreate it on every display of the input
        this
        .on( 'open.tinymceInit-'+conf._safeId, function () {
          tinymce.init( $.extend( true, {
            selector: '#'+conf._safeId
          }, conf.opts, {
            init_instance_callback: function ( editor ) {
              if ( conf._initSetVal ) {
                editor.setContent( conf._initSetVal );
                conf._initSetVal = null;
              }
            }
          } ) );

          var editor = tinymce.get( conf._safeId );

          if ( editor && conf._initSetVal ) {
            editor.setContent( conf._initSetVal );
            conf._initSetVal = null;
          }
        } )
        .on( 'close.tinymceInit-'+conf._safeId, function () {
          var editor = tinymce.get( conf._safeId );


          if ( editor ) {
            editor.destroy();
          }

          conf._initSetVal = null;
          conf._input.find('textarea').val('');
        } );

        return conf._input;
      },

      get: function ( conf ) {
        var editor = tinymce.get( conf._safeId );
        if ( ! editor ) {
          return conf._initSetVal;
        }

        return editor.getContent();
      },

      set: function ( conf, val ) {
        var editor = tinymce.get( conf._safeId );

        // If not ready, then store the value to use when the `open` event fires
        conf._initSetVal = val;
        if ( ! editor ) {
          return;
        }
        editor.setContent( val );
      },

      enable: function ( conf ) {}, // not supported in TinyMCE

      disable: function ( conf ) {}, // not supported in TinyMCE

      destroy: function (conf) {
        var id = DataTable.Editor.safeId(conf.id);

        this.off( 'open.tinymceInit-'+id );
        this.off( 'close.tinymceInit-'+id );
      },

      // Get the TinyMCE instance - note that this is only available after the
      // first onOpen event occurs
      tinymce: function ( conf ) {
        return tinymce.get( conf._safeId );
      }
    };


  }));
  </script>

  <script>


  tinymce.init({
    selector: 'textarea',
    height: 180,
    width : '100%',
    theme: 'modern',
    plugins: [
      'advlist autolink lists link image charmap print preview hr anchor pagebreak',
      'searchreplace wordcount visualblocks visualchars code fullscreen',
      'insertdatetime media nonbreaking save table contextmenu directionality',
      'emoticons template paste textcolor colorpicker textpattern imagetools'
    ],
    toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
    toolbar2: 'print preview media | forecolor backcolor emoticons',
    image_advtab: true,
    templates: [
      { title: 'Test template 1', content: 'Test 1' },
      { title: 'Test template 2', content: 'Test 2' }
    ],
    content_css: [
      '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
      '//www.tinymce.com/css/codepen.min.css',
      "{{ asset('css/tiny.css') }}"
    ]
  });

  $(function() {
    $.datepicker.setDefaults(
      $.extend(
        {'dateFormat':'dd/mm/yy'},
        $.datepicker.regional['it']
      )
    );
    $("#datepicker").datepicker();
    $("#datepicker2").datepicker();
    $("#nato_il").datepicker();
    $(".data").datepicker();
  });

  function add_eventspec(id_sub, id_event, admin){
    var valid_for = $('#valid_for').val(); //è l'id_week
    var event_spec = $('#event_spec').val();
    var event_spec_text = $('#event_spec option:selected').text();
    var id_type = $('#event_spec').find(':selected').data('type');
    var price = $('#event_spec').find(':selected').data('price');

    var t = parseInt($('#contatore_e').val());
    var row = "<tr style='background-color: #dff0d8;'>";
    row += "<td>";
    row += "<input name='id_eventspecvalue["+t+"]' type='hidden' value='0'/>";
    row += "<input name='id_eventspec["+t+"]' type='hidden' value='"+event_spec+"'/>";
    row += "<input name='id_subscription["+t+"]' type='hidden' value='"+id_sub+"'/>";
    row += "<input name='id_week["+t+"]' type='hidden' value='"+valid_for+"'/>";
    row += event_spec_text+"</td>";
    row += "<td>";

    if(id_type>0){
      row += "<select id='valore"+t+"' name='valore["+t+"]' class='form-control'></select>";
      $.get("{{ url('types/options')}}",
      {id_type: id_type },
      function(data2) {
        var model = $("#valore"+t);
        model.empty();
        $.each(data2, function(index_2, element_2) {
          model.append("<option value='"+ element_2.id +"'>" + element_2.option + "</option>");
        });
      });
    }else{
      switch(id_type){
        case -1:
        row += "<input name='valore["+t+"]' type='text' value='' class='form-control'/>";
        break;
        case -2:
        row += "<input name='valore["+t+"]' type='hidden' value='0'/>";
        row += "<input name='valore["+t+"]' type='checkbox' value='1' class='form-control'/>";
        break;
        case -3:
        row += "<input name='valore["+t+"]' type='number' value='' class='form-control'/>";
        break;
        case -4:
        row += "<select id='valore"+t+"' name='valore["+t+"]' class='form-control'></select>";
        $.get("{{ url('admin/groups/dropdown')}}",
        {},
        function(data2) {
          var model = $("#valore"+t);
          model.empty();
          $.each(data2, function(index_2, element_2) {
            model.append("<option value='"+ element_2.id +"'>" + element_2.nome + "</option>");
          });
        });
        break;
      }
    }



    row += "</td>";
    if(admin){
      row += "<td><input name='costo["+t+"]' type='number' value='"+price+"' class='form-control' style='width: 70px;' step='0.1' id='costo_"+t+"' onchange='check_importo(this, "+t+")'/></td>";
      row += "<td>";
      row += "<input name='pagato["+t+"]' type='hidden' value='0'/>";
      row += "<input name='pagato["+t+"]' type='checkbox' value='1' class='form-control'  id='pagato_"+t+"' onchange='check_pagato(this, "+t+")' style='display:none'/>";
      row += "</td>";
      row += "<td><input name='acconto["+t+"]' type='number' value='"+price+"' class='form-control' style='width: 70px;' step='0.1' id='acconto_"+t+"'/></td>";
    }else{
      row += "<td><input name='costo["+t+"]' type='hidden' value='0' class='form-control' style='width: 70px;' />"+price+"€</td>";
      row += "<td>";
      row += "<input name='pagato["+t+"]' type='hidden' value='0'/>";
      row += "</td>";
    }
    row += "<td></td>"; //cestino
    row += "</tr>";



    if(valid_for==0){//inserisco una riga nella tabella delle specifiche generali
      $('#showeventspecvalue tr:last').after(row);
    }else{ //riga nelle tabelle settimanali
      $('#weektable_'+valid_for+' tr:last').after(row);
    }
    $('#contatore_e').val((t+1));




    $('#eventspecsOp').modal('hide');
  }



  /**
  Funzione che viene richiamata quando un select cambia valore; viene popolato lo span (#span_type)
  con un input del tipo corretto (seelct, testo, checkbox).

  sel: il select
  multiple: se viene generato un select, indica se sono possibili scelte multiple
  name: il name da dare all'input generato
  id: l'id da dare all'input generato
  **/
  function change_type(sel, multiple='', name='valore', id='valore', show_checkbox_hidden=true, span_id="span_type"){
    $.get("{{ url('types/type')}}",
    {id_eventspec: sel.value},
    function(data) {
      $.each(data, function(index, element) {
        var row = "";
        if(element.id>0){
          row = "<select id='"+id+"' name='"+name+"' "+multiple+" class='form-control'></select>";
          $.get("{{ url('types/options')}}",
          {id_type: element.id },
          function(data2) {
            var model = $("#"+id+"");
            model.empty();
            $.each(data2, function(index_2, element_2) {
              model.append("<option value='"+ element_2.id +"'>" + element_2.option + "</option>");
            });
          });
        }else{
          switch(element.id){
            case -1:
            row = "<input name='"+name+"' type='text' value='' class='form-control' style='width: 300px'/>";
            break;
            case -2:
            if(show_checkbox_hidden){
              row = "<input name='"+name+"' type='hidden' value='0'/>";
            }
            row += "<input name='"+name+"' type='checkbox' value='1' />";
            break;
            case -3:
            row = "<input name='"+name+"' type='number' value='' class='form-control' style='width: 300px'/>";
            break;
            case -4:
            row = "<select id='"+id+"' name='"+name+"'></select>";
            $.get("{{ url('admin/groups/dropdown')}}",
            {},
            function(data2) {
              var model = $("#"+id+"");
              model.empty();
              $.each(data2, function(index_2, element_2) {
                model.append("<option value='"+ element_2.id +"'>" + element_2.nome + "</option>");
              });
            });
            break;
          }
        }
        $("#"+span_id).html(row);
      });
    });
  }

  function change_attrib(sel, t){
    $.get("{{ url('types/type_attrib')}}",
    {id_attrib: sel.value },
    function(data) {
      $.each(data, function(index, element) {
        var row = "";
        if(element.label=="text"){
          row = "<input name='valore["+t+"]' type='text' value='' class='form-control' style='width: 300px'/>";
        }else if(element.label=="checkbox"){
          row = "<input name='valore["+t+"]' type='hidden' value='0'/>";
          row += "<input name='valore["+t+"]' type='checkbox' value='1'/>";
        }else{
          row = "<select id='valore"+t+"' name='valore["+t+"]'></select>";
          $.get("{{ url('types/options')}}",
          {id_type: element.id },
          function(data2) {
            var model = $("#valore"+t);
            model.empty();
            $.each(data2, function(index_2, element_2) {
              model.append("<option value='"+ element_2.id +"'>" + element_2.option + "</option>");
            });
          });
        }
        $("#span_type"+t).html(row);
      });
    });
  }




  function typeselect_add(id_type){
    var t = parseInt($('#contatore_e').val());
    var row = "<tr>";
    var form = ('{{ Form::text("option[]", "", ["style" => "width: 100%"]) }}').replace(/"/g, '\'');
    form = form.replace("option[]", "option["+t+"]");
    row += "<input name='id_option["+t+"]' type='hidden' value='0'/>";
    row += "<input name='id_type["+t+"]' type='hidden' value='"+id_type+"'/>";
    row += "<td>"+form+"</td>";
    row += "<td><input type='number' min='0' name='ordine["+t+"]' value='0'</td>";
    row += "<td>E</td>";
    row += "</tr>";

    $('#showoptions tr:last').after(row);
    $('#contatore_e').val((t+1));

  }

  function add_cassa(){
    var t = parseInt($('#contatore_c').val());
    var row = "<tr>";
    row += "<td>#<input type='hidden' value='0' name='id["+t+"]'></td>";
    row += "<td><input type='text' name='label["+t+"]' class='form-control'/></td>";
    // row += "<td></td>";
    row += "<td></td>";
    row += "</tr>";

    $('#table_casse tr:last').after(row);
    $('#contatore_c').val((t+1));

  }

  function add_modo_pagamento(){
    var t = parseInt($('#contatore_m').val());
    var row = "<tr>";
    row += "<td>#<input type='hidden' value='0' name='id["+t+"]'></td>";
    row += "<td><input type='text' name='label["+t+"]' class='form-control'/></td>";
    // row += "<td></td>";
    row += "<td></td>";
    row += "</tr>";

    $('#table_modo tr:last').after(row);
    $('#contatore_m').val((t+1));

  }

  function add_tipo_pagamento(){
    var t = parseInt($('#contatore_t').val());
    var row = "<tr>";
    row += "<td>#<input type='hidden' value='0' name='id["+t+"]'></td>";
    row += "<td><input type='text' name='label["+t+"]' class='form-control'/></td>";
    // row += "<td></td>";
    row += "<td></td>";
    row += "</tr>";

    $('#table_tipo tr:last').after(row);
    $('#contatore_t').val((t+1));

  }


  //A seconda dell'attributo selezionato, cambio la casella dove inserire il valore (testo, checkbox, ...)
  function change_attributo_type(sel){
    if(sel.value<0) return;
    $.get("{{ url('attributos/type')}}",
    {id_attributo: sel.value },
    function(data){
      if(data.length>0){
        var row = "";
        $.each(data, function(index, element) {

          if(element.id_type>0){
            row = "<select id='valore' name='valore' class='form-control'></select>";
            $.get("{{ url('types/options')}}",
            {id_type: element.id_type },
            function(data2) {
              var model = $("#valore");
              model.empty();
              $.each(data2, function(index_2, element_2) {
                model.append("<option value='"+ element_2.id +"'>" + element_2.option + "</option>");
              });
            });
          }else{
            switch(element.id_type){
              case -1:
              row = "<input name='valore' type='text' value='' class='form-control'/>";
              break;
              case -2:
              row = "<input name='valore' type='hidden' value='0'/>";
              row += "<input name='valore' type='checkbox' value='1' class='form-control'/>";
              break;
              case -3:
              row = "<input name='valore' type='number' value='' class='form-control' />";
              break;
              case -4:
              row = "<select id='valore' name='valore' class='form-control'></select>";
              $.get("{{ url('admin/groups/dropdown')}}",
              {},
              function(data2) {
                var model = $("#valore");
                model.empty();
                $.each(data2, function(index_2, element_2) {
                  model.append("<option value='"+ element_2.id +"'>" + element_2.nome + "</option>");
                });
              });
              break;
            }
          }

        });
        $("#attrib_value").html(row);
      }
    });


  }

  function load_attrib_registration(sel){
    var body = "";
    $.get("{{ url('attributos/dropdown')}}",
    {id_oratorio: sel.value },
    function(data) {
      if(data.length>0){
        var t = 0;
        body+= "INFORMAZIONI AGGIUNTIVE";
        $.each(data, function(index, element) {
          body += "<div class='form-group'>";
          body += "<label for='attrib_"+element.id+"' class='col-md-4 control-label'>"+element.nome+"</label>";
          body += "<div class='col-md-6'>";
          body += "<input type='hidden' name='id_attributo["+t+"]' value='"+element.id+"'>";

          var row = "";

          if(element.id_type>0){
            body += "<select class='form-control' id='valore"+t+"' name='attributo["+t+"]'>";
            $.ajax({
              async: false,
              data: {id_type: element.id_type},
              type: "GET",
              url: "{{ url('types/options')}}",
              success: function(data2) {
                $.each(data2, function(index_2, element_2) {
                  body += "<option value='"+ element_2.id +"'>" + element_2.option + "</option>";
                });
                body += "</select>";
              }
            });
          }else{
            switch(element.id_type){
              case -1:
              body += "<input name='attributo["+t+"]' type='text' value='' class='form-control' required autofocus style='width: 300px'/>";
              break;
              case -2:
              body += "<input name='attributo["+t+"]' type='hidden' value='0'/>";
              body += "<input class='form-control' name='attributo["+t+"]' type='checkbox' value='1' required />";
              break;
              case -3:
              body += "<input name='attributo["+t+"]' type='number' value='' class='form-control' required style='width: 300px'/>";
              break;
              case -4:
              body += "<select class='form-control' id='valore"+t+"' name='attributo["+t+"]'>";
              $.ajax({
                async: false,
                type: "GET",
                data: {id_oratorio: sel.value},
                url: "{{ url('groups/dropdown')}}",
                success: function(data2) {
                  $.each(data2, function(index_2, element_2) {
                    body += "<option value='"+ element_2.id +"'>" + element_2.nome + "</option>";
                  });
                  body += "</select>";
                }
              });
              break;
            }
          }
          body += "</div>";
          body += "</div>";
          t++;
        });
      }
      $("#attributes").html(body);
    });
    //t++;



  }


  function load_spec_usersubscription(id_subscription, id_event){
    $('#spec1').load("usereventspecvalues?id_sub="+id_subscription+"&id_event="+id_event);
    $('#spec2').load("userspecsubscriptions?id_sub="+id_subscription+"&id_event="+id_event);
    $('#id_event').val(id_event);
  }

  function eventspec_destroy(id_eventspec, index){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
      type: 'POST',
      dataType: 'html',
      data: {id_spec: id_eventspec,
        _token: CSRF_TOKEN},
        url: "{{route('eventspecs.destroy')}}",
        success: function(response) {
          //alert(response);
          $('#row_'+index).remove();
        },
        error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + XMLHttpRequest.responseText + "\n" + exception); },
        async: true
      });
    }

    function elencovalue_destroy(id_v){
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      $.ajax({
        type: 'POST',
        dataType: 'html',
        data: {id_value: id_v,
          _token: CSRF_TOKEN},
          url: "{{route('elenco.destroy_value')}}",
          success: function(response) {
            //alert(response);
            $('#row_'+id_v).remove();
          },
          error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + XMLHttpRequest + "\n" + exception); },
          async: true
        });
      }

      function colonneelenco_add(){
        var t = parseInt($('#contatore').val());
        t = t+1;
        var row = "<tr>";
        row += "<td>";
        row += "<input type='text' name='colonna["+t+"]' class='form-control'/></td>";
        row += "</tr>";

        $('#colonne_elenco tr:last').after(row);
        $('#contatore').val(t);
      }

      function elencovalues_add(num_colonne, keys){
        var key = jQuery.parseJSON(keys);
        var t = parseInt($('#contatore').val());
        t = t+1;
        var row = "<tr>";
        row += "<input name='id_values["+t+"]' type='hidden' value='0'/>";
        row += "<td>#</td>";
        var select = "<select class='form-control' id='id_user["+t+"]' name='id_user["+t+"]'>";
        $.ajax({
          async: false,
          type: "GET",
          data: {},
          url: "{{ url('user/dropdown')}}",
          success: function(data) {
            $.each(data, function(index, element) {
              select += "<option value='"+ element.id +"'>" + element.cognome + " "+element.name+"</option>";
            });
            select += "</select>";
          }
        });

        row += "<td>"+select+"</td>";
        for(var i=0; i<num_colonne; i++){
          row += "<td>";
          row += "<input name='colonna["+t+"]["+key[i]+"]' type='hidden' value='0'/>";
          row += "<input class='form-control' name='colonna["+t+"]["+key[i]+"]' type='checkbox' value='1' />";
        }
        row += "</tr>";

        $('#elenco_values tr:last').after(row);
      }

      // function redirect_check(route, method='POST', send_param=true){
      //   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      //   var selected = [];
      //   $('input[type=checkbox]').each(function() {
      //     if ($(this).is(":checked")){
      //       selected.push($(this).attr('value'));
      //     }
      //   });
      //   if(send_param){
      //     $.redirect(route, {check: JSON.stringify(selected), _token: CSRF_TOKEN}, method);
      //   }else{
      //     $.redirect(route, {}, method);
      //   }
      //
      // }

      function disable_select(checkbox, id_select, inverse=false){
        if(inverse){
          $('#'+id_select).prop('disabled', !checkbox.checked);
        }else{
          $('#'+id_select).prop('disabled', checkbox.checked);
        }

      }

      </script>
      @stack('scripts')
    </body>
    </html>
