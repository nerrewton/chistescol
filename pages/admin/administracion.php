<?php
    require("../../data.php");
    require('../../clases/Spam.class.php');
    require('../../clases/pagina.class.php');
    require('../../clases/cdcs.class.php');

    $objPagina = new Pagina;
    $objSpam = new Spam;
    $objCdcs = new Cdcs;

    ini_set('display_errors', 1);
    session_start();
    if(isset($_SESSION['cdc_username']) && $_SESSION['tipo'] =='admin'){
      $id_facebook = $_SESSION['id_facebook'];
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='-1'>
    <meta http-equiv='pragma' content='no-cache'>
    <link rel="stylesheet" href="../../css/font-awesome.min.css">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/pages.css">
    <title>Chistes Colombianos</title>
  </head>
  <body>
    <?php echo $objPagina->getHeaderPages($_SESSION["cdc_nombre"],$_SESSION['id_facebook']); ?>
    <section class="main">
      <div class="container">
        <div class="row panel_content">
          <div class="row col-sm-3">
            <div class="col-sm-12">
              <div class="panel panel-success">
                <div class="panel-heading">
                    <h4>Administraci&oacute;n cdcs </h4>
                </div>
                <div class="panel-body">
                  <div class="form-group">
                    <label for="sel1">Elija Cdc:</label>
                    <select class="form-control" id="cdcElegido" onchange="mostrar_cdc(this.value);">
                      <option disabled selected value> -- Seleccione un Cdc -- </option>
                      <?php
                        $Cdcs_normales = $objCdcs->get_cdcs($host, $user, $password, $database);
                          foreach($Cdcs_normales as $valores){
                            echo '<option value="'.$valores['id_facebook'].'">'.$valores['nombre_cdc'].'</option>';
                          }
                       ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="panel panel-info">
                <div class="panel-heading"><h4>Spam gastados</h4></div>
                <div class="panel-body">
                  Panel content
                </div>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="panel panel-danger">
                <div class="panel-heading"><h4>Solicitudes</h4></div>
                <div class="panel-body">
                  <?php
                    $numSolicitudes = $objCdcs->getNumSolicitudes($host, $user, $password, $database);
                    print_r("<span>".$numSolicitudes[0]."</span>");
                   ?>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-9">
            <div class="panel panel-default panel_info">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-sm-9">
                    <h4 id="info_cdc">Informaci&oacute;n <small class="nombre_cdc" id="nombrecdc"></small></h4>
                  </div>
                  <div class="col-sm-3">
                    <button type="button" class="btn btn-success btn-lg" disabled="disabled" id="btngano" onclick="insertar_spam(1);" data-toggle="modal" data-target="#ModalSubirImagen">Gan&oacute;</button>
                    <button type="button" class="btn btn-warning btn-lg" disabled="disabled" id="btngasto" onclick="insertar_spam(2);" data-toggle="modal" data-target="#ModalSubirImagen">Gast&oacute;</button>
                  </div>
                </div>
              </div>
              <div class="panel-body">
                <div class="info_cdc panel" id="info">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
		<!-- Modal subir imagen -->
      <div class="modal fade" id="ModalSubirImagen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Ingrese evidencia</h4>
            </div>
            <div class="modal-body">
              <input type="file" id="imagen_evidencia" name="imagen_evidencia"/>
            </div>
            <div class="modal-footer">
              <button id="modalCerrar" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button id="modalGuardar" type="button" data-dismiss="modal" class="btn btn-primary">Guardar</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal ver imagen -->
        <div class="modal fade" id="ModalVerImagen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Imagen del spam</h4>
              </div>
              <div id="VerImagen" class="modal-body">

              </div>
              <div class="modal-footer">
              </div>
            </div>
          </div>
        </div>
	</section>
    <?php //echo $objPagina->getFooter(); ?>
    <script src="../../js/jquery-3.2.1.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/funciones_cdc.js"></script>
  </body>
</html>
<?php }else{
  echo "No tiene permisos para esta pagina";
  header('location:../../index.php');
}
?>
