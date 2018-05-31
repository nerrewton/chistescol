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
                        <div id="spam-ganados-por-cdc" style="min-width:400px; height:400px; margin: 0 auto;"></div>
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
    <script src="../../plugins/highCharts/highcharts.js"></script>
    <script>
    <?php
        $arrayDataSerie = array();
        $Categories = array();
        $ArrayEstadisticas = $objSpam->getEstadisticas($host, $user, $password, $database);

        foreach($ArrayEstadisticas as $ArrayItem){
            $red = mt_rand(0,255);
            $green = mt_rand(0,255);
            $blue = mt_rand(0,255);
            $Categories[] = '\''.$ArrayItem['nombre'].'\'';
            $arrayDataSerie[] = '{color: \'rgba('.$red.','.$green.','.$blue.',.6)\', y:'.$ArrayItem['numero'].'}';
        }
        echo 'var yAxisSeries = [{name:\'Ganados\',data:['.implode(',',$arrayDataSerie).']}];';
        echo 'var xAxisCategories = ['.implode(',',$Categories).'];';
    ?>

    $(document).ready(function(){
      graph_spam_ganados('spam-ganados-por-cdc','Spam ganados',xAxisCategories,yAxisSeries);
    });

    function graph_spam_ganados(div, titulo,xAxisCategories,yAxisSeries){
        Highcharts.chart(div, {
          chart: {
              type: 'column'
          },
          title: {
              text: titulo
          },
          credits: {
              enabled: false
          },
          exporting: {
              enabled: false
          },
          xAxis: {
            categories: xAxisCategories,
            crosshair: true
          },
          yAxis: {
              min: 0,
              title: {
                  text: 'Numero de spam ganados'
              }
          },
          tooltip: {
              headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
              pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                  '<td style="padding:0"><b>{point.y}</b></td></tr>',
              footerFormat: '</table>',
              shared: true,
              useHTML: true
          },
          plotOptions: {
              column: {
                  pointPadding: 0.2,
                  borderWidth: 0,
                  dataLabels: {
                      enabled: true
                  }
              }
          },
          series: yAxisSeries
      });
    }
    </script>
  </body>
</html>
