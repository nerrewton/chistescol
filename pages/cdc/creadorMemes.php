<?php
/**
 * Created by PhpStorm.
 * User: Rene Arteaga
 * Date: 14/10/2017
 * Time: 14:34
 */
    session_start();
    require('../../clases/pagina.class.php');
    require('../../clases/Memes.class.php');
    require("../../data.php");
    $objPagina = new Pagina;
    $objMemes = new Memes();
    ini_set('display_errors', true);
    if(isset($_SESSION['cdc_username'])){
    $id_facebook = $_SESSION['id_facebook'];

        (isset($_GET['id']))? $urlimg = $_GET['id'] : $urlimg = "";


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <script src="../../js/jquery-3.2.1.min.js"></script>
        <script src="../../js/jquery-ui.min.js"></script>
        <!-- includes meme gen-->
        <script src="../../plugins/memeGen/colorpicker/spectrum.js"></script>
        <script type="text/javascript" src="../../plugins/memeGen/dist/jquery.memegenerator.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../../plugins/memeGen/dist/jquery.memegenerator.min.css">
        <link rel="stylesheet" type="text/css" href="../../plugins/memeGen/colorpicker/spectrum.css">
        <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <!-- fin includes meme gen-->
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
                <div class="col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-sm-7">
                                    <h4>Memes disponibles</h4>
                                </div>
                                <div class="col-sm-5">
                                    <form id="formMeme" method="post" action="gestionCdc/subirMeme.php" enctype="multipart/form-data">
                                        <label id="labelMeme" class="btn btn-success" for="uploadMeme">Subir nuevo <i class="fa fa-upload" aria-hidden="true"></i></label>
                                        <input id="uploadMeme" name="memetoupload" onchange="subirMeme(this.value)" type="file" style="display: none">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body text-center" style="overflow-y: auto; max-height: 400px;">
                            <div class="col-sm-12">
                            <?php
                            $arrayMemes = $objMemes->getMemes($host, $user, $password, $database);

                            foreach($arrayMemes as $key => $meme){
                                echo ($urlimg == $meme['url_meme'])?'<div class="thumbnail row" style="background-color: rgba(170, 170, 170,0.5)">':'<div class="thumbnail row">';
                                echo '<div class="col-sm-12 text-center">';
                                echo '<img id="meme'.$meme['url_meme'].'" width="70%" height="auto" src="../../images/memes/'.$meme['url_meme'].'.jpg" onclick="selectImg(\''.$meme['url_meme'].'\')" style="margin:5px;">';
                                echo '</div>';
                                echo '</div>';
                            }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="bootstrap">
                                <img id="image-to-download" src="../../images/memes/<?php echo $urlimg; ?>.jpg">
                            </div>
                            <div class="col-md-12 text-center">
                                <button id="download" class="btn btn-lg btn-success" <?php echo ($urlimg=="")?'style="display:none"':"" ?> > Descargar <i class="fa fa-download" aria-hidden="true"></i></button>
                            </div>
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
    </section>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/memeGenFunctions.js"></script>
    <script>
        function selectImg(url) {
            window.location.href = location.protocol + "//" + location.host + location.pathname+"?id="+url;
        }

        function subirMeme(memefile) {

            if(memefile !="" && memefile != null ){
                if(memefile.match(".jpg")!=null || memefile.match(".png")!=null || memefile.match(".gif")!=null || memefile.match(".jpeg")!=null){
                    var form = $("#formMeme");
                    $("#labelMeme").html("Subiendo ...");
                    form.submit();
                }else{
                    alert("El archivo debe ser una imagen !");
                }

            }else{
                alert("Debes seleccionar una imagen");
            }
        }
    </script>
    </body>
</html>
<?php } ?>