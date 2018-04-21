<?php
  require("../../data.php");
  require('../../clases/Spam.class.php');

  $objSpam = new Spam;
  $id_facebook = $_POST['id'];

  $valores = $objSpam->ver_spam($id_facebook, $host, $user, $password, $database);
  print_r(json_encode($valores));
