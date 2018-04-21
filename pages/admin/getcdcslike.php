<?php
/**
 * Created by PhpStorm.
 * User: Rene Arteaga
 * Date: 16/10/2017
 * Time: 14:03
 */
ini_set('display_errors', 1);
require('../../clases/cdcs.class.php');
require("../../data.php");

$objCdcs = new Cdcs;
$nombre = $_POST['nombre'];

$result = $objCdcs->getCdcsLike($host, $user, $password, $database, $nombre);

print_r(json_encode($result));