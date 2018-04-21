<?php

  class Login {

    private $conexion;

    function connect_db(){
      require("./data.php");
      $this->conexion= mysqli_connect($host, $user, $password, $database) or die("Error al conectarse con la base de datos");
    }

    function validar_usuario($username, $password){
      $this->connect_db();
      $dec = mysqli_set_charset($this->conexion, 'utf8');
      $query = "SELECT * FROM cdcs WHERE username='$username' AND password= '$password'";
      $consulta = mysqli_query($this->conexion, $query);

      while ($valores=mysqli_fetch_array($consulta)) {
        $tmp = $valores;
      }
      return $tmp;
      mysqli_close($this->conexion);
    }
    function validar_usuario_fb($FBID, $FULLNAME, $EMAIL, $GENDER){
      $this->connect_db();
      $dec = mysqli_set_charset($this->conexion, 'utf8');
      $query = "SELECT * FROM cdcs WHERE id_facebook= '$FBID'";
      $consulta = mysqli_query($this->conexion, $query);
      $exits = 0;
      while ($valores=mysqli_fetch_array($consulta)) {
         $exits = 1;
      }
      if($exits == "0"){
        $tmp = "Facebook ok";
        $query = "INSERT INTO fb_cdcs(fb_fbid,fb_fbname,fb_fbmail,fb_fbgender,fb_fbactivo) VALUES('$FBID','$FULLNAME','$EMAIL','$GENDER','0')";
        //$consulta = mysqli_query($this->conexion, $query);
      }else{
        $query = "INSERT INTO fb_cdcs(fb_fbid,fb_fbname,fb_fbmail,fb_fbgender,fb_fbactivo) VALUES('$FBID','$FULLNAME','$EMAIL','$GENDER','1')";
        $tmp = "exito";
      }
      $consulta = mysqli_query($this->conexion, $query);
      return $tmp;
      mysqli_close($this->conexion);
    }
    function get_usuario_by_IDfacebook($id_facebook){
      $this->connect_db();
      $dec = mysqli_set_charset($this->conexion, 'utf8');
      $query = "SELECT * FROM cdcs WHERE id_facebook='$id_facebook'";
      $consulta = mysqli_query($this->conexion, $query);

      while ($valores=mysqli_fetch_array($consulta)) {
        $tmp = $valores;
      }
      return $tmp;
      mysqli_close($this->conexion);
    }

  }
