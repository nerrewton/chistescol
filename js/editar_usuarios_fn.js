function cambiar_estado(id,checkbox){
    var estado_nuevo;

    if(checkbox.checked){
        estado_nuevo = 1;
    }else{
        estado_nuevo = 0;
    }

    $.ajax({
        type:'post',
        url:'controller/cambia_estado.php',
        data:{
            id:id,
            estado:estado_nuevo
        },
        success: function(data){
            //console.log(data);
            if(data == "success"){
                $.toaster({ priority : 'success', title : '&Eacute;xito', message : 'El estado se actualiz&oacute; exitosamente.'});
            }else{
                $.toaster({ priority : 'danger', title : 'Error', message : 'No se pudo actualizar el estado'});
            }
        }
    });
}

function limpiar_campos(){
    $('#nombre').val('');
    $('#id').val('');
    $('#edit_nombre').val('');
    $('#edit_id').val('');
}

function validate_vacios(){

    var id_variables = ['#nombre','#id'];
    var has_error = false;

    $.each(id_variables,function(i){
        if($(id_variables[i]).val() == ''){
            has_error = true;
        }
    });

    return has_error;
}

function crear_usuario(){

    if(validate_vacios()){
        $.toaster({ priority : 'danger', title : 'Error', message : 'Los campos no pueden estar vac&iacute;os'});
        return;
    }

    var form = $("#form_nuevo_cdc").serialize();

    $.ajax({
        type:'post',
        url:'controller/crea_nuevo_usuario.php',
        data: form,
        success: function (data){
            //console.log(data);
            if(data == "success"){
                $.toaster({ priority : 'success', title : '&Eacute;xito', message : 'Se ingres&oacute; el nuevo usuario exitosamente.'});
                setTimeout(function(){
                    location.reload();
                  }, 3000);
            }else{
                $.toaster({ priority : 'danger', title : 'Error', message : 'No se pudo ingresar el usuario'});
            }
        }
    });
}

function editar_usuario(nombre, id, estado){
    limpiar_campos();

    $('#edit_nombre').val();
    $('#edit_id').val();
}

function update_usuario(){

    if(validate_vacios()){
        $.toaster({ priority : 'danger', title : 'Error', message : 'Los campos no pueden estar vac&iacute;os'});
        return;
    }

    var form = $("#form_editar_cdc").serialize();

    $.ajax({
        type:'post',
        url:'controller/update_usuario.php',
        data: form,
        success: function (data){
            //console.log(data);
            if(data == "success"){
                $.toaster({ priority : 'success', title : '&Eacute;xito', message : 'Se actualizaron los datos del usuario exitosamente.'});
                setTimeout(function(){
                    location.reload();
                  }, 3000);
            }else{
                $.toaster({ priority : 'danger', title : 'Error', message : 'No se pudo actualizar la informaci&oacute;n del usuario'});
            }
        }
    });
}