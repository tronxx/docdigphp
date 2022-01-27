<?php 
  require_once("libs/grabafactura.php");
  header('Access-Control-Allow-Origin: *');
  header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
  header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
  header('Content-Type: application/json');

  if(isset($_POST["folioini"])) $folioini_z =  $_POST["folioini"];
  if(isset($_POST["foliofin"])) $foliofin_z =  $_POST["foliofin"];
  if(isset($_POST["serieini"])) $serieini_z =  $_POST["serieini"];
  if(isset($_POST["seriefin"])) $seriefin_z =  $_POST["seriefin"];
  if(isset($_POST["fechaini"])) $fechaini_z =  $_POST["fechaini"];
  if(isset($_POST["fechafin"])) $fechafin_z =  $_POST["fechafin"];
  if(isset($_POST["modo"])) $modo_z =  $_POST["modo"];

  if(isset($_GET["folioini"])) $folioini_z =  $_GET["folioini"];
  if(isset($_GET["foliofin"])) $foliofin_z =  $_GET["foliofin"];
  if(isset($_GET["serieini"])) $serieini_z =  $_GET["serieini"];
  if(isset($_GET["seriefin"])) $seriefin_z =  $_GET["seriefin"];
  if(isset($_GET["fechaini"])) $fechaini_z =  $_GET["fechaini"];
  if(isset($_GET["fechafin"])) $fechafin_z =  $_GET["fechafin"];
  if(isset($_GET["modo"])) $modo_z =  $_GET["modo"];

  if($modo_z == "CONSULTAR") {
    $condiciones_z["folioini"]=$folioini_z;
    $condiciones_z["foliofin"]=$foliofin_z;
    $condiciones_z["serieini"]=$serieini_z;
    $condiciones_z["seriefin"]=$seriefin_z;
    $condiciones_z["fechaini"]=$fechaini_z;
    $condiciones_z["fechafin"]=$fechafin_z;
    # echo json_encode($condiciones_z);
    $facturas_z =busca_rango_fac_pdo(json_encode($condiciones_z));
    echo $facturas_z;
  }
?>

