<?php

  class Cdcs {
    private $conexion;

    function connect_db($host, $user, $password, $database){
      $this->conexion= mysqli_connect($host, $user, $password, $database) or die("Error al conectarse con la base de datos");
    }
    function get_cdc(){
      return "hola rene";
    }
    function get_cdcs($host, $user, $password, $database){

      $this->connect_db($host, $user, $password, $database);
      $dec = mysqli_set_charset($this->conexion, 'utf8');
      $query = "SELECT nombre_cdc, id_facebook FROM cdcs WHERE activo ='1' AND tipo ='cdc_normal' order by nombre_cdc;";
      $consulta = mysqli_query($this->conexion, $query);
      $tmp = array();
      while($valores = mysqli_fetch_array($consulta)){
        $tmp = array_merge($tmp, array($valores));
      }

      return $tmp;
      mysqli_close($this->conexion);
    }
    function getNumSolicitudes($host, $user, $password, $database){
        $this->connect_db($host, $user, $password, $database);
        $dec = mysqli_set_charset($this->conexion, 'utf8');
        $query = "SELECT count(*) FROM fb_cdcs WHERE fb_fbactivo = 0";
        $consulta = mysqli_query($this->conexion, $query);
        while ($valores=mysqli_fetch_array($consulta)) {
          $tmp = $valores;
        }
        return $tmp;
        mysqli_close($this->conexion);
    }

    function getSolicitudes($host, $user, $password, $database){
        $this->connect_db($host, $user, $password, $database);
        $dec = mysqli_set_charset($this->conexion, 'utf8');
        $query = "SELECT * FROM fb_cdcs WHERE fb_fbactivo = 0";
        $consulta = mysqli_query($this->conexion, $query);
        $tmp = array();
        while ($valores=mysqli_fetch_array($consulta)) {
          $tmp []= $valores;
        }
        return $tmp;
        mysqli_close($this->conexion);
    }
      function getCdcsLike($host, $user, $password, $database, $nombre){
          $this->connect_db($host, $user, $password, $database);
          $dec = mysqli_set_charset($this->conexion, 'utf8');
          $query = "SELECT nombre_cdc, id_facebook FROM cdcs WHERE nombre_cdc LIKE '%$nombre%';";
          $consulta = mysqli_query($this->conexion, $query);
          $tmp = array();
          while ($valores=mysqli_fetch_array($consulta)) {
              $tmp []= $valores;
          }
          return $tmp;
          mysqli_close($this->conexion);
      }
      function changeInfo($host, $user, $password, $database, $idViejo, $idNuevo){
          $this->connect_db($host, $user, $password, $database);
          $query ="UPDATE cdcs SET id_facebook = '$idNuevo' WHERE id_facebook ='$idViejo'";
          $consulta = mysqli_query($this->conexion, $query);
          mysqli_close($this->conexion);
          return $consulta;
      }
  }
