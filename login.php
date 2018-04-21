<?php

  require ("clases/Login.class.php");
  session_start();
  $objLogin = new Login;

  if (isset($_POST['username']) && isset($_POST['password']) && $_POST['username']!="" && $_POST['password']!="") {

    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $values = $objLogin->validar_usuario($username, $password);
    if ($values=="") {
      header('Location: index.php?error=2');
    }else{
      //session_start();
      $_SESSION['cdc_username'] = $username;
      $_SESSION['id_facebook'] = $values['id_facebook'];
      $_SESSION['cdc_nombre'] = $values['nombre_cdc'];
      $_SESSION['id'] = $values['id'];
      $_SESSION['tipo'] = $values['tipo'];
      if ($values['tipo']=='admin') {
        header('Location: pages/admin/administracion.php');
        //Se crea log
        $Contenido ="Username: ".$username.", Id_facebook: ".$values['id_facebook'].", Nombre cdc: ".$values['nombre_cdc'].", Tipo: ".$values['tipo'];
        logfile("logs/logByPasswordAdmin.log", $Contenido);
        //Se crea log
      }else{
        header('Location: pages/cdc/perfil_cdc.php');
        //Se crea log
        $Contenido ="Username: ".$username.", Id_facebook: ".$values['id_facebook'].", Nombre cdc: ".$values['nombre_cdc'].", Tipo: ".$values['tipo'];
        logfile("logs/logByPasswordCdcs.log", $Contenido);
        //Se crea log
      }
    }
  }elseif(isset($_POST['FBID'])){

    $values = $objLogin->validar_usuario_fb($_POST['FBID'],$_POST['FULLNAME'],$_POST['EMAIL'],$_POST['GENDER']);
    //print_r($_POST['FBID'].$_POST['FULLNAME'].$_POST['EMAIL'].$_POST['GENDER'].$_POST['UPDATETIME']);
    //print_r ($values);
    if($values =="exito"){
      $result = $objLogin->get_usuario_by_IDfacebook($_POST['FBID']);
      //print_r($result);
      $_SESSION['cdc_username'] = $result['username'];
      $_SESSION['id_facebook'] = $result['id_facebook'];
      $_SESSION['cdc_nombre'] = $result['nombre_cdc'];
      $_SESSION['id'] = $result['id'];
      $_SESSION['tipo'] = $result['tipo'];
      if ($result['tipo']=='admin') {
        echo "admin";
        //header('Location: pages/admin/administracion.php');
      }else{
        echo "cdc";
        //header('Location: pages/cdc/perfil_cdc.php');
      }
    }else{
      print_r($values);
    }
    //Se crea log
    $Contenido ="Id_facebook: ".$_POST['FBID'].", Nombre Completo: ".$_POST['FULLNAME'].", Correo: ".$_POST['EMAIL'].", Genero: ".$_POST['GENDER'];
    logfile("logs/logByFacebook.log", $Contenido);
    //Se crea log
  }else{
    header('Location: index.php?error=1');
  }

  //funcion de creacion de logs
  function logfile($nombrelog, $texto){
    $abrir = fopen($nombrelog, "a");
    date_default_timezone_set("America/Bogota");
    $fecha = date("Y-m-d H:i:s");
    $cadena = "[".$fecha."]"." ".$texto."\r\n";
    fwrite($abrir, $cadena);
    fclose($abrir);

  }
