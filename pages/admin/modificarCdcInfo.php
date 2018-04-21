<?php
/**
 * Created by PhpStorm.
 * User: Rene Arteaga
 * Date: 16/10/2017
 * Time: 15:31
 */

ini_set('display_errors', 1);
require("../../data.php");
require('../../clases/cdcs.class.php');
require('../../clases/Spam.class.php');

$objSpam = new Spam;
$objCdcs = new Cdcs;
$idViejo = $_POST['idviejo'];
$idNuevo = $_POST['idnuevo'];

$objSpam->changeInfo($host, $user, $password, $database, $idViejo, $idNuevo);
$objCdcs->changeInfo($host, $user, $password, $database, $idViejo, $idNuevo);

echo 'success';


