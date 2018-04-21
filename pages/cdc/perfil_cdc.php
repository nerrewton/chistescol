<?php
    require("../../data.php");
    require('../../clases/Spam.class.php');
    require('../../clases/pagina.class.php');
    $objPagina = new Pagina;
    $objSpam = new Spam;
    session_start();
    if(isset($_SESSION['cdc_username'])){
      $id_facebook = $_SESSION['id_facebook'];
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
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
                <div class="panel">
                    <div class="panel-body">
                        <a href="creadorMemes.php" class="btn btn-primary" type="button" tooltip="Prueba la nueva funcionalidad"><strong>Ir al creador de Memes </strong><i class="fa fa-star" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
              <div class="panel panel-success">
                <div class="panel-heading">
                  <div class="row">
                    <h4 class="col-xs-9 col-sm-9">Total Spam: </h4>
                    <h4 class="col-xs-3 col-sm-3">
                      <span class="badge">
                      <?php
                      $valores = $objSpam->ver_spam($id_facebook, $host, $user, $password, $database);
                      echo (isset($valores[0]['total_spam']))?$valores[0]['total_spam']:'0';
                      ?>
                      </span>
                    </h4>
                  </div>
                </div>
                <div class="panel-body">
                  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-primary">
                      <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <span class="badge">
                              <?php
                              $cnt = 0;
                              foreach($valores as $row){
                                ($row['numero_ganados']!=0)?$cnt = $cnt + 1 :'';
                              }
                              echo $cnt;
                              ?>
                            </span>
                            Ganados
                          </a>
                        </h4>
                      </div>
                      <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                          <?php
                          foreach ($valores as $row) {
                            if ($row['numero_ganados']=='0'){

                            }else{
                                echo "<a href='#' style='text-decoration:none;' onclick='javascript:ver_detalle_spam(\" ".$row['fecha']." \",\" ".$row['urlimage']." \");'><div class='btn btn-primary btn-sm' style='margin: 1px'>Fecha: ".str_replace("-","/",$row['fecha'])."</div></a>";
                            }
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="panel panel-danger">
                      <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            <span class="badge">
                              <?php
                                $cnt1 = 0;
                               foreach($valores as $row){
                                 ($row['numero_gastados']!=0)?$cnt1 = $cnt1 + 1 :'';
                               }
                               echo $cnt1;
                              ?>
                            </span>
                            Gastados
                          </a>
                        </h4>
                      </div>
                      <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                          <?php
                          foreach ($valores as $row) {
                            if ($row['numero_gastados']=='0'){

                            }else{
                              echo "<a href='#' style='text-decoration:none;' onclick='javascript:ver_detalle_spam(\" ".$row['fecha']." \",\" ".$row['urlimage']." \");'><div class='btn btn-danger btn-sm' style='margin: 1px'>Fecha: ".str_replace("-","/",$row['fecha'])."</div></a>";
                            }
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
         <!--<div class="col-sm-12">
              <div class="panel panel-info">
                <div class="panel-heading"><h4>Pendientes</h4></div>
                <div class="panel-body">
                  En construcci&oacute;n
                </div>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="panel panel-danger">
                <div class="panel-heading"><h4>Estado</h4></div>
                <div class="panel-body">
                  En construcci&oacute;n
                </div>
              </div>
            </div> -->
          </div>
          <div class="col-sm-9">
            <div class="panel panel-default panel_info">
              <div class="panel-heading"><h4>Detalle del spam</h4></div>
              <div id="imagen_evidencia" class="panel-body">
                Has click en alguno de los registros para ver la imagen de evidencia
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal ver normas -->
        <div class="modal fade" id="ModalNormas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Normas de la p&aacute;gina</h4>
              </div>
              <div class="modal-body">
                <p class="bg-primary">Estas son las reglas para todos los cdcs de Chistes Colombianos, léase y cúmplase a cabalidad.</p>
                <br>
                <p><strong>1.</strong> No se puede hacer spam sin previa autorizaci&oacute;n de Rene Arteaga.</p>
                <br>
                <p><strong>2.</strong> Prohibido subir im&aacute;genes porno o de desnudos.</p>
                <br>
                <p><strong>3.</strong> Prohibido hacer bullying a personas.</p>
                <br>
                <p><strong>4.</strong> No se puede publicar im&aacute;genes que contengan las palabras: <strong class="text-danger">Marica &#9746;</strong>, <strong class="text-danger">Gay &#9746;</strong>, <strong class="text-danger">Maric&oacute;n &#9746;</strong>, <strong class="text-danger">Lesbianas &#9746;</strong> y sus derivados; en caso de necesitar éstas palabras se sugiere usar: <strong class="text-success">Marik &#9745;</strong>, <strong class="text-success">Mk &#9745;</strong> entre otras.</p>
                <br>
                <p><strong>5.</strong> No se puede hacer m&aacute;s de dos spam por d&iacute;a.</p>
              </div>
              <div class="modal-footer">
              </div>
            </div>
          </div>
        </div>
        <!-- alert -->
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
