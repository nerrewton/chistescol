<?php
  //aqui se incluyen clases y archivos requeridos
  require('clases/pagina.class.php');
  $objPagina = new Pagina;
  session_start();
  session_destroy();
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Chistes Colombianos</title>
  </head>
  <body>
    <?php echo $objPagina->getHeader(); ?>
    <section class="main">
      <div class="container">
        <div class="row">
          <div class="col-sm-4">
          </div>
          <div class="col-sm-4 login-box">
            <!-- Alert launch when error -->
            <?php if(isset($_GET['error'])) { if($_GET['error']==1) { ?>
              <div class="alert alert-danger" role="alert">
                <strong>Warning!</strong> No se pueden dejar los campos vac&iacute;os.
              </div>
            <?php }elseif ($_GET['error']==2) { ?>
              <div class="alert alert-danger" role="alert">
                <strong>Warning!</strong> El usuario no est&aacute; en la base de datos.
              </div>
            <?php } }?>
            <form action="login.php" method="post">
              <!--<div class="form-group">
                <label for="username" class="col-sm-12">User name:</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="username" name="username" placeholder="User name">
                </div>
              </div>
              <div class="form-group">
                <label for="password" class="col-sm-12">Password:</label>
                <div class="col-sm-12">
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>
              </div> -->
              <div class="col-sm-12 block-btn text-center">
                <h1>Ingresa haciendo click en el bot&oacute;n</h1>
                <!--<button type="submit" class="btn btn-success">Login</button> -->
                <button id="LogFB" type="button" class="btn btn-primary">Login width Facebook <i class="fa fa-facebook-square"></i></button>
              </div>
            </form>
          </div>
          <div class="col-sm-4">
            <div class="alert alert-info alert-dismissable fade in" style="width:100%; float:right; margin-top:15px;">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Info!</strong> Ahora puedes ingresar con el boton de Facebook !, Env&iacute;ale la solicitud al Admin.
            </div>
            <!--<div class="alert alert-danger alert-dismissable fade in" style="width:100%; float:right; margin-top:15px;">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Nota!</strong> Pronto se eliminar&aacute; la opci&oacute;n de ingresar con user y password a la palataforma, s&oacute;lo se permitir&aacute; el ingreso con el bot&oacute;n de Facebook!.
            </div> -->
          </div>
        </div>
      </div>
    </section>
    <?php echo $objPagina->getFooter(); ?>
	<script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/funciones_cdc.js"></script>
    <script>
      <?php
          if(isset($_SESSION['FBID'])){
            echo '
            $.ajax({
              type: "post",
              url: "login.php",
              data: {
                FBID: "'.$_SESSION['FBID'].'",
                FULLNAME : "'.$_SESSION['FULLNAME'].'",
                EMAIL : "'.$_SESSION['EMAIL'].'",
                GENDER : "'.$_SESSION['GENDER'].'"
              },
              success:function(data){
                  if(data == "Facebook ok"){
                    alert("'.$_SESSION['FULLNAME'].', Se envío tu solicitud al administrador para aprobar tu perfil");
                  }else if (data == "admin"){
                    window.location.href ="pages/admin/administracion.php";
                  }else{
                    window.location.href ="pages/cdc/perfil_cdc.php";
                  }
                  console.log(data);
              }
            });
                  ';
        }else{}
      ?>
      $("#LogFB").click(function(){
        window.location.href ="FacebookLog/fbconfig.php";
      });
    </script>
  </body>
</html>
