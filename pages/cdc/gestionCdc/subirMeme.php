<?php
/**
 * Created by PhpStorm.
 * User: Rene arteaga
 * Date: 14/10/2017
 * Time: 17:45
 */
ini_set('display_errors', true);
date_default_timezone_set('America/Bogota');
session_start();
require('../../../clases/Memes.class.php');
require("../../../data.php");
$objMemes = new Memes();
$urlBefore = $objMemes->getLastMeme($host, $user, $password, $database);
$urlNew = INTVAL($urlBefore[0]) + 1;
$fecha = date('Y-m-d H:i:s');
$id_facebook = $_SESSION['id_facebook'];

$meme = $_FILES['memetoupload']['tmp_name'];
$targ = "../../../images/memes/".$urlNew.".jpg";

compress_image($meme,$targ,100);

$objMemes->insertarMeme($host, $user, $password, $database, $fecha, $urlNew, $id_facebook);
//echo "Se insertaron los datos correctamente";

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

header("location: http://chistescol.com/chistescol/pages/cdc/creadorMemes.php?id=".$urlNew);