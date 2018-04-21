<?php

/**
 * Created by PhpStorm.
 * User: Rene Arteaga
 * Date: 14/10/2017
 * Time: 15:09
 */

class Memes
{
    private $conexion;

    function connect_db($host, $user, $password, $database){
        $this->conexion= mysqli_connect($host, $user, $password, $database) or die("Error al conectarse con la base de datos");
    }

    function getMemes($host, $user, $password, $database){
        $this->connect_db($host, $user, $password, $database);
        $query = "SELECT * FROM memes order by fecha_carga DESC, categoria;";
        $consulta = mysqli_query($this->conexion, $query);
        $tmp = array();
        while ($valores = mysqli_fetch_array($consulta)) {
            $tmp[] = $valores;
        }
        return $tmp;
        mysqli_close($this->conexion);

    }
    function getLastMeme($host, $user, $password, $database){
        $this->connect_db($host, $user, $password, $database);
        $query = "SELECT * FROM memes order by fecha_carga desc limit 1;";
        $consulta = mysqli_query($this->conexion, $query);
        $tmp = mysqli_fetch_array($consulta);
        return $tmp;
        mysqli_close($this->conexion);
    }
    function insertarMeme($host, $user, $password, $database, $fecha, $url, $id_facebook){
        $this->connect_db($host, $user, $password, $database);
        $query = "INSERT INTO memes(fecha_carga, url_meme, uploadby_id_facebook)
                  VALUES('$fecha','$url','$id_facebook');";
        $consulta = mysqli_query($this->conexion, $query);
        mysqli_close($this->conexion);
        return $consulta;
    }
}