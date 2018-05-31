var arreglo_spam_cdc;

function mostrar_cdc(cdc_seleccionado){
  $('#nombrecdc').show();
  var Namecdc = "#cdcElegido option[value='"+cdc_seleccionado+"']";
  $('#nombrecdc').text($(Namecdc).text());
  $('#btngano').attr("disabled", false);
  $('#btngasto').attr("disabled", false);
  var id = cdc_seleccionado;

  $.ajax({
    type: 'POST',
    url: '../admin/get_info_cdc.php',
    dataType: 'json',
    data:{
      id: id
    },
    success:function(data){
      set_values_cdc(data);
      arreglo_spam_cdc = data;
      //console.log(data);
    }

  });
}

function set_values_cdc(arreglo){
  var rows="";
  $('#info').html('<div class="table-responsive"><table class="table" id="myTable"><thead><tr><th>Total spam</th><th>Spam ganados</th><th>Spam gastados</th><th>Fecha</th><th>Imagen</th></tr></thead><tbody id="SpamCdc"></tbody></table></div>');
  var cnt = 0;
  for (var total_spam in arreglo){

    rows = rows+"<tr><td>"+arreglo[cnt]['total_spam']+"</td><td>"+arreglo[cnt]['numero_ganados']+"</td><td>"+arreglo[cnt]['numero_gastados']+"</td><td>"+arreglo[cnt]['fecha']+"</td><td><a href='#' onclick='VerImagen(\"../../"+arreglo[cnt]['urlimage']+"\")' title='Ver imagen' data-toggle='modal' data-target='#ModalVerImagen'><img src='../../"+arreglo[cnt]['urlimage']+"' height='30'></a></td></tr>";
    cnt ++;
  }
  $('#SpamCdc').html(rows);
  $('#myTable').DataTable({
    ordering: false,
    pageLength: 5,
    oLanguage: {
        			"sLengthMenu": "Mostrando _MENU_ registros por p&aacute;gina",
        			"sZeroRecords": "No se encontraron registros - !lo sentimos!",
        			"sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
        			"sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
                    "sSearch":"Buscar:",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sPrevious": "<<",
                        "sNext":     ">>",
                        "sLast":     "\xdaltimo"
                    },
        			"sInfoFiltered": "(Filtrado de un total de _MAX_ registros)"
        		}
  });
}

function insertar_spam(tipo) {

  	$("#modalGuardar").unbind().click(function(){
  		//imagen evidencia

      var	imagen_src = $("#imagen_evidencia").prop('files')[0];
      $("#imagen_evidencia").val('');
  		var form = new FormData();
      form.set('file', imagen_src);
  		arreglo = JSON.stringify(arreglo_spam_cdc);
  		type = JSON.stringify(tipo);
      form.set('tipo', type);
      form.set('arreglo_spam_cdc', arreglo);

      console.log(form.getAll('tipo'));

  	  $.ajax({
  		type: 'POST',
  		url: '../admin/insertar_spam.php',
  		dataType: 'json',
  		data:form,
  		contentType: false,
  		processData:false,
      async:false,
  		success:function(data){
  		  var id_name = arreglo_spam_cdc[0]['id_facebook'];
  		  mostrar_cdc(id_name);
  		}


    });
  	});
}

function ver_detalle_spam(fecha,urlimg){

  var url = "../../"+urlimg.replace(/\s/g, '');
  $("#imagen_evidencia").addClass("text-center");
  $("#imagen_evidencia").html("<img style='max-height:400px;' src='"+url+"' title='imagen del spam' alt='imagen del spam'>");
  //console.log(fecha);
}

function VerImagen(UrlImagen){
  $('#VerImagen').html("<img style='max-height:450px; margin-left:20%;' src='"+UrlImagen+"' title='imagen del spam' alt='imagen del spam'>");
  //console.log(UrlImagen);
}
