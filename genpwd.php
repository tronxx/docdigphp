
<?php 

  $uuid_z = "";
  $email_z = "";
  $tienda_z = "";
  $modo_z = "INTERACTIVO";
  $peticion_z = "POST";
  date_default_timezone_set('America/Merida');

  if(isset($_POST["tienda"])) $tienda_z =  $_POST["tienda"];
  if(isset($_POST["modo"]))  $modo_z  =  $_POST["modo"];

  if($modo_z == "ENVIAR") {
    $cadena_z = genera_pwd($tienda_z);
  }

  if($modo_z == "INTERACTIVO") {
    dibuja_formulario();
  }



  function dibuja_formulario()
  {

    require_once("layouts/header.php");

    date_default_timezone_set('America/Merida');
    session_start();
    $archivo_z = "checa_sesion.php";
    if(!file_exists($archivo_z)) {
      $archivo_z = "checa_sesion.php";
    }
    require_once($archivo_z);	
    checa_sesion();
    $misdatfiscal_z = json_decode(file_get_contents("datosfiscales.json"), true);
    $nemp_z = $misdatfiscal_z["nombre"];
    $mistiendas_z = json_decode(file_get_contents("tiendas.json"), true);
    $cad_z = "";
    $option_z = '<select name="tienda" id="tienda">';
    foreach ( $mistiendas_z as $mitienda_z ) {

      $option_z = $option_z . '<option value="' . $mitienda_z["id"]  . '">' . $mitienda_z["nombre"] . '</option>';
    }
    $option_z = $option_z . '</select>';
  
    $cadena_z = '<H2>Generacion de password</h2>

    <table border="1">
      <tr><td>
      <form action="genpwd.php" method="POST" >
        <label for="tienda"> Seleccione la Tienda:</label>' . $option_z . '
        <input type="submit" name="modo" value="ENVIAR">
      </form>
      </td></tr>
      </table>
      </body>
      </html>
    ';
   echo $cadena_z;
 }

 function genera_pwd($tienda_z) {

  require_once("layouts/header.php");

  date_default_timezone_set('America/Merida');
  session_start();
  $archivo_z = "checa_sesion.php";
  if(!file_exists($archivo_z)) {
    $archivo_z = "checa_sesion.php";
  }
  require_once($archivo_z);	
  checa_sesion();
  $misdatfiscal_z = json_decode(file_get_contents("datosfiscales.json"), true);
    $nemp_z = $misdatfiscal_z["nombre"];
    $date_z = new DateTime();
    $cad1_z = $tienda_z .  $date_z->format('Ymd:H');
    $cad_z = strtoupper(md5($cad1_z)) . '  -';
  
    $cadena_z = '<H2>Generacion de password</h2>

    <table border="1">
      <tr><td>
      <div style="width: 30%">
        <label for="mipwd"> Password:</label>
      </div>
      <div style="width: 70%">
        <input type="text" id="mipwd" name="mipwd" value="' . $cad_z . '" size="50" >
      </div>
      </td>
      </tr>
      </table>
      </body>
      </html>

    ';
    echo $cadena_z;
    return("true");

 }

?>
