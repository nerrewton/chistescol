<?php

  class Spam {
    private $conexion;

    function connect_db($host, $user, $password, $database){
      $this->conexion= mysqli_connect($host, $user, $password, $database) or die("Error al conectarse con la base de datos");
    }

    function ver_spam($id_facebook, $host, $user, $password, $database){
      $this->connect_db($host, $user, $password, $database);
      $dec = mysqli_set_charset($this->conexion, 'utf8');
      $query = "SELECT * FROM registro_spam WHERE id_facebook='$id_facebook' ORDER BY fecha DESC LIMIT 15";
      $consulta = mysqli_query($this->conexion, $query);
      $tmp = array();
      while ($valores = mysqli_fetch_array($consulta)) {
        $tmp[] = $valores;
      }
      return $tmp;
      mysqli_close($this->conexion);

    }
    function insertar_spam($urlImg,$tipo,$array,$fecha, $host, $user, $password, $database){
      $this->connect_db($host, $user, $password, $database);
      $dec = mysqli_set_charset($this->conexion, 'utf8');
      $id_facebook = $array[0]['id_facebook'];
      $nombre = $array[0]['nombre'];
      $fecha = $fecha;
      if ($tipo =='1'){
        $total_spam = (int)$array[0]['total_spam'] + 1;
        $query = "INSERT INTO registro_spam(nombre, fecha, numero_ganados, numero_gastados, id_facebook,total_spam,urlimage) VALUES('$nombre','$fecha','1','0','$id_facebook','$total_spam','$urlImg')";
      }elseif ($tipo =='2'){
        $total_spam = (int)$array[0]['total_spam'] - 1;
        $query = "INSERT INTO registro_spam(nombre, fecha, numero_ganados, numero_gastados, id_facebook, total_spam,urlimage) VALUES('$nombre','$fecha','0','1','$id_facebook','$total_spam','$urlImg')";
      }
      $consulta = mysqli_query($this->conexion, $query);
      mysqli_close($this->conexion);
    }

    function getEstadisticas($host, $user, $password, $database){
        $this->connect_db($host, $user, $password, $database);
        $dec = mysqli_set_charset($this->conexion, 'utf8');
        $query = "select count(*) as numero, id_facebook, nombre from registro_spam where numero_ganados=1 group by id_facebook order by numero desc;";
        $consulta = mysqli_query($this->conexion, $query);
        $tmp = array();
        while ($valores = mysqli_fetch_array($consulta)) {
        $tmp[] = $valores;
        }
        return $tmp;
        mysqli_close($this->conexion);
    }
    function getUltimaImagenName($host, $user, $password, $database){
        $this->connect_db($host, $user, $password, $database);
        $dec = mysqli_set_charset($this->conexion, 'utf8');
        $query = "select urlimage from registro_spam order by fecha desc limit 1;";
        $consulta = mysqli_query($this->conexion, $query);
        $tmp = mysqli_fetch_array($consulta);
        return $tmp;
        mysqli_close($this->conexion);
    }
    function changeInfo($host, $user, $password, $database, $idViejo, $idNuevo){
        $this->connect_db($host, $user, $password, $database);
        $query ="UPDATE registro_spam SET id_facebook = '$idNuevo' WHERE id_facebook ='$idViejo'";
        $consulta = mysqli_query($this->conexion, $query);
        mysqli_close($this->conexion);
        return $consulta;
    }
  }
