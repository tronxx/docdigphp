<?php 
    function checa_sesion() {
        $status = session_status();
        if(!isset($_SESSION['usuario'])){
          $status = PHP_SESSION_NONE;
        }
        if($status == PHP_SESSION_NONE){
            echo "No Tengo Sesion Activa<br>" . $status . " - " . PHP_SESSION_NONE;
          //There is no active session
          $archivo_z = "login/login.php";
          if(!file_exists($archivo_z)) {
              $archivo_z = "login/login.php";
          }
          $abrelogin_z = "location: " . $archivo_z;
          header($abrelogin_z);
        } 
    }
?>
