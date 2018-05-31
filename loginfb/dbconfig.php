<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'ljvgejop_rene');    // DB username
define('DB_PASSWORD', 'colombia65');    // DB password
define('DB_DATABASE', 'ljvgejop_chistescol');      // DB name
$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die( "Unable to connect");
$database = mysql_select_db(DB_DATABASE) or die( "Unable to select database");
?>
