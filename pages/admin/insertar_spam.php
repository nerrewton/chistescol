<?php
  require("../../data.php");
  require('../../clases/Spam.class.php');

  $objSpam = new Spam;
  $tipo = json_decode($_POST['tipo']);
  $array = json_decode($_POST['arreglo_spam_cdc'],true);

  $dbNombreUltimo = $objSpam->getUltimaImagenName( $host, $user, $password, $database);

  $nombreAnterior = substr(str_replace("images/","",$dbNombreUltimo['urlimage']),0,-4);
  $nombreNew = $nombreAnterior + 1;
  $src = $_FILES['file']['tmp_name'];
  //$targ = "../../images/".$_FILES['file']['name'];
  $targ = "../../images/".$nombreNew.".png";
  //move_uploaded_file($src, $targ);
  compress_image($src,$targ,80);

  $urlImg = str_replace("../../","",$targ);
  //print_r(json_encode($array[0]['nombre']));
  //print_r(json_encode(str_replace("../../","",$targ)));
  //print_r(json_encode($tipo));
  //echo json_encode("Se insertaron los datos correctamente");
  date_default_timezone_set("America/Bogota");
  $fecha = date("Y-m-d H:i:s");

  $objSpam->insertar_spam($urlImg,$tipo,$array,$fecha, $host, $user, $password, $database);
  echo json_encode("Se insertaron los datos correctamente");

  function compress_image($source_url, $destination_url, $quality) {

		$info = getimagesize($source_url);

        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source_url);

        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($source_url);

        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($source_url);

        imagejpeg($image, $destination_url, $quality);

	}
