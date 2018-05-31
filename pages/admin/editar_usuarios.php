<?php

    require("../../data.php");
    require('../../clases/pagina.class.php');
    require('../../clases/cdcs.class.php');

    $objPagina = new Pagina;
    $objCdcs = new Cdcs;

    ini_set('display_errors', 1);
    session_start();

?>

<!DOCTYPE html>

<html>

  <head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <meta http-equiv='cache-control' content='no-cache'>

    <meta http-equiv='expires' content='-1'>

    <meta http-equiv='pragma' content='no-cache'>
    <!-- Boostrap Toogle-->
    <link href="../../css/bootstrap-toggle.min.css" rel="stylesheet">
    <!-- Boostrap Toogle-->
    <!-- DataTable -->
    <link rel="stylesheet" href="../../css/jquery.dataTables.min.css">
    <!-- DataTable -->
    <link rel="stylesheet" href="../../css/font-awesome.min.css">

    <link rel="stylesheet" href="../../css/bootstrap.min.css">

    <link rel="stylesheet" href="../../css/style.css">

    <link rel="stylesheet" href="../../css/pages.css">

    <script src="../../js/jquery-3.2.1.min.js"></script>

    <script src="../../js/bootstrap.min.js"></script>

    <!-- DataTable -->
    <script src="../../js/jquery.dataTables.min.js"></script>
    <!-- DataTable -->
    <!-- Boostrap Toogle-->
    <script src="../../js/bootstrap-toggle.min.js"></script>
    <!-- Boostrap Toogle-->
    <script src="../../js/jquery.toaster.js"></script>

    <title>Chistes Colombianos</title>

  </head>

  <body>

    <?php echo $objPagina->getHeaderPages($_SESSION["cdc_nombre"],$_SESSION['id_facebook']); ?>

    <section class="main">

      <div class="container">

        <div class="row panel_content">

            <div class="col-sm-12">

                <div class="panel panel-default panel_info">

                    <div class="panel-heading text-center">

                        <h3>Editar usuarios</h3>

                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-2 col-xs-12">
                                <button class="btn btn-success" data-toggle="modal" data-target="#modal_nuevo_usuario" onclick="limpiar_campos()"><i class="fa fa-plus"></i> Agregar</button>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">

                                <table id="table_usuarios" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Nombre</th>
                                            <th class="text-center">Id Facebook</th>
                                            <th class="text-center">Correo</th>
                                            <th class="text-center">Estado</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $array_cdcs = $objCdcs->get_all_cdcs($host, $user, $password, $database);
                                        foreach($array_cdcs as $key => $data){
                                            $estado = ($data['activo'] == 1)?'checked':'';

                                            echo '<tr>';
                                            echo '<td>'.$data['nombre_cdc'].'</td>';
                                            echo '<td>'.$data['id_facebook'].'</td>';
                                            echo '<td>'.$data['fb_fbmail'].'</td>';
                                            echo '<td><input type="checkbox" '.$estado.' data-toggle="toggle" data-size="small" onchange="cambiar_estado(\''.$data['id_facebook'].'\',this)"></td>';
                                            echo '<td><button class="btn btn-primary" onclick="editar_usuario(\''.$data['nombre_cdc'].'\', \''.$data['id_facebook'].'\', \''.$data['activo'].'\');" data-toggle="modal" data-target="#modal_editar_usuario"><i class="fa fa-pencil"></i> Editar</button></td>';
                                            echo '</tr>';
                                        }
                                        ?>
                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

      </div>

      <!-- Modal nuevo usuario -->
      <div class="modal fade" id="modal_nuevo_usuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <form id="form_nuevo_cdc">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user"></i> Nuevo creador de contenidos</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label" for="nombre">Nombre:</label>
                                <input id="nombre" type="text" class="form-control" name="nombre" placeholder="Nombre" />
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="id">Id Facebook:</label>
                                <input id="id" type="text" class="form-control" name="id_facebook" placeholder="Id Facebook" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <input type="button" onclick="crear_usuario()" data-dismiss="modal" class="btn btn-primary" value="Guardar"/>
                </div>
              </div>
          </form>
        </div>
      </div>

      <!-- Modal editar usuario -->
      <div class="modal fade" id="modal_editar_usuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <form id="form_editar_cdc">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user"></i> Editar creador de contenidos</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label" for="nombre">Nombre:</label>
                                <input id="edit_nombre" type="text" class="form-control" name="nombre" placeholder="Nombre" />
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="id">Id Facebook:</label>
                                <input id="edit_id" type="text" class="form-control" name="id_facebook" placeholder="Id Facebook" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <input type="button" onclick="update_usuario()" data-dismiss="modal" class="btn btn-primary" value="Guardar"/>
                </div>
              </div>
          </form>
        </div>
      </div>

	</section>

    <?php //echo $objPagina->getFooter(); ?>

    <script src="../../js/funciones_cdc.js"></script>

    <script src="../../js/editar_usuarios_fn.js"></script>

  <script>
    $(document).ready(function(){
        $('#table_usuarios').DataTable({
            ordering: true,
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
    });
  </script>

  </body>

</html>