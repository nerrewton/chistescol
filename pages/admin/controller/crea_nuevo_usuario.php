<?php
  require("../../../data.php");
  require('../../../clases/cdcs.class.php');
  require('../../../clases/Spam.class.php');

  ini_set('display_errors',true);
  date_default_timezone_set('America/Bogota');

  $objCdcs = new Cdcs;
  $objSpam = new Spam;

  $nombre = $_POST['nombre'];
  $id_facebook = $_POST['id_facebook'];
  $fecha = date('Y-m-d H:i:s');

  $success_spam = $objSpam->insert_spam_new_cdc($host, $user, $password, $database, $nombre, $fecha, $id_facebook);
  $success_cdcs = $objCdcs->insert_cdc($host, $user, $password, $database, $nombre, $fecha, $id_facebook);

  if($success_cdcs && $success_spam){
    $success_solicitud = $objCdcs->delete_solicitud($host, $user, $password, $database, $id_facebook);
    if($success_solicitud){
        echo "success";
    }
  }else{
    echo "error";
  }