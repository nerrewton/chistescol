<?php
  require("../../../data.php");
  require('../../../clases/cdcs.class.php');
  ini_set('display_errors',true);

  $objCdcs = new Cdcs;
  $id_facebook = $_POST['id'];
  $activo = $_POST['estado'];

  $success = $objCdcs->change_activo($host, $user, $password, $database, $id_facebook, $activo);

  if($success){
    echo "success";
  }else{
    echo "error";
  }
