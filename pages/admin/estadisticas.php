<?php

    require("../../data.php");
    require('../../clases/pagina.class.php');
    require('../../clases/Spam.class.php');

    $objPagina = new Pagina;
    $objSpam = new Spam;

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
            <div class="col-sm-12">
                <div class="panel panel-default panel_info">
                    <div class="panel-heading text-center">
                        <h3>Estad&iacute;sticas</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID Facebook</th>
                                        <th>Nombre</th>
                                        <th>Publicaciones > 14k</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $ArrayEstadisticas = $objSpam->getEstadisticas($host, $user, $password, $database);
                                        //print_r($ArraySolicitudes);
                                        foreach($ArrayEstadisticas as $ArrayItem){
                                            echo '<tr>';
                                            echo '<td>'.$ArrayItem['id_facebook'].'</td>';
                                            echo '<td>'.$ArrayItem['nombre'].'</td>';
                                            echo '<td>'.$ArrayItem['numero'].'</td>';
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
	</section>
    <?php //echo $objPagina->getFooter(); ?>
    <script src="../../js/jquery-3.2.1.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/funciones_cdc.js"></script>
  </body>
</html>