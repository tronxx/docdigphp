<?php 
  require_once("libs/grabafactura.php");
  require_once("layouts/header.php");

  date_default_timezone_set('America/Merida');
  $modo_z = "INTERACTIVO";
  $peticion_z = "POST";
  session_start();
  $archivo_z = "checa_sesion.php";
  if(!file_exists($archivo_z)) {
    $archivo_z = "checa_sesion.php";
  }
  require_once($archivo_z);	
  checa_sesion();
  

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
    $facturas_z = json_decode(busca_rango_fac_pdo(json_encode($condiciones_z)), true);
    $cadena_z = "";
    $cadena_z = $cadena_z . "<label>Facturas con Folios entre " . $folioini_z . " y " . $foliofin_z . "</label> " ;
    $cadena_z = $cadena_z . "y Series entre " . $serieini_z . " y " . $seriefin_z . "</label> " ;

    $cadena_z = $cadena_z . "y Fecha entre " . $fechaini_z . " y " . $fechafin_z . "</label><br> " ;
    $cadena_z = $cadena_z . '<table border="1"  class="table table-hover"><tr>';
    $cadena_z = $cadena_z . "<th>Folio</th>";
    $cadena_z = $cadena_z . "<th>Serie</th>";
    $cadena_z = $cadena_z . "<th>Nombre</th>";
    $cadena_z = $cadena_z . "<th>Fecha</th>";
    $cadena_z = $cadena_z . "<th>Total</th>";
    $cadena_z = $cadena_z . "<th>Uuid</th>";
    $cadena_z = $cadena_z . "<th>Estado</th>";
    $cadena_z = $cadena_z . "<th>Accion</th>";
    $cadena_z = $cadena_z . "</tr>";
    foreach ($facturas_z as $mifactura_z) {
       $cadena_z = $cadena_z . "<tr>";
       $cadena_z = $cadena_z . "<td>". $mifactura_z["folio"]   . "</td>";
       $cadena_z = $cadena_z . "<td>". $mifactura_z["serie"]   . "</td>";
       $cadena_z = $cadena_z . "<td>". $mifactura_z["nombre"]  . "</td>";
       $cadena_z = $cadena_z . "<td>". $mifactura_z["fecha"]   . "</td>";
       $cadena_z = $cadena_z . "<td>". $mifactura_z["total"]    . "</td>";
       $cadena_z = $cadena_z . "<td>". $mifactura_z["uuid"]    . "</td>";
       if($mifactura_z["status"] == "ACTIVO") {
         $color_z = '  style="background-color:#52be80"';
       } else {
         $color_z = '  style="background-color:#e74c3c "';

       }
       $cadena_z = $cadena_z . "<td " . $color_z . ">". $mifactura_z["status"]    . "</td>";
       $boton_z = '<form method="post" action="envia.php">';
       $boton_z = $boton_z . '<input type="hidden" name="uuid" value="' . $mifactura_z["uuid"] . '">';
       $boton_z = $boton_z . '<input type="hidden" name="serie" value="' . $mifactura_z["serie"] . '">';
       $boton_z = $boton_z . '<input type="hidden" name="folio" value="' . $mifactura_z["folio"] . '">';
       $boton_z = $boton_z . '<input type="submit" name="enviar" value="' . "Enviar" . '">';
       $boton_z = $boton_z . '</form>';
       $boton_z = $boton_z . '<form method="post" action="descarga.php">';
       $boton_z = $boton_z . '<input type="hidden" name="uuid" value="' . $mifactura_z["uuid"] . '">';
       $boton_z = $boton_z . '<input type="hidden" name="serie" value="' . $mifactura_z["serie"] . '">';
       $boton_z = $boton_z . '<input type="hidden" name="folio" value="' . $mifactura_z["folio"] . '">';
       $boton_z = $boton_z . '<input type="submit" name="enviar" value="' . "Descargar" . '">';
       $boton_z = $boton_z . '</form>';
       $boton_z = $boton_z . '<form method="post" action="cancelafac.php">';
       $boton_z = $boton_z . '<input type="hidden" name="uuid" value="' . $mifactura_z["uuid"] . '">';
       $boton_z = $boton_z . '<input type="hidden" name="serie" value="' . $mifactura_z["serie"] . '">';
       $boton_z = $boton_z . '<input type="hidden" name="folio" value="' . $mifactura_z["folio"] . '">';
       $boton_z = $boton_z . '<input class="btn-danger" type="submit" name="enviar" value = "Cancelar">' ;
       $boton_z = $boton_z . '</form>';

       $cadena_z = $cadena_z . "<td>". $boton_z    . "</td>";

       $cadena_z = $cadena_z . "</tr>\n";
    }
    $cadena_z = $cadena_z . "</table></body></html>";
    echo $cadena_z;

  }

  if($modo_z == "INTERACTIVO") {
    dibuja_formulario();
  }

  function buscar_facturas( $fecini_z, $fecfin_z, $serieini_z, $seriefin_z) {

  }

  function dibuja_formulario() {

    date_default_timezone_set('America/Merida');
    $fechafin_z = date('Y-m-d');
    $fechaini_z = substr($fechafin_z, 0, 8) . '01' ;

    $cadena_z = '

    <table border="1"  class="table table-hover">
      <tr>
      <td> Consultar factura:</td>
      </tr>
      <tr><td>
      <form action="consultafac.php" method="POST" >
        <label for="folioini"> Folio Inicial:</label>
        <input type="text" value="1" id="edt_folioini" name="folioini">
        <label for="foliofin"> Folio Final:</label>
        <input type="text" value="999999" id="edt_foliofin" name="foliofin">
        <br>
        <label for="serieini"> Serie Inicial:</label>
        <input type="text" id="edt_serieini" name="serieini">
        <label for="seriefin"> Serie Final:</label>
        <input type="text" id="edt_seriefin" name="seriefin">
        <br>
        <label for="fechaini"> Fecha Inicial:</label>
        <input type="date" id="edt_fechaini" name="fechaini" 
        value="' . $fechaini_z .'" >
        <label for="fechafin"> Fecha Final:</label>
        <input type="date" id="edt_fechafin" name="fechafin"
        value="' . $fechafin_z . '">
        <br>
        <input type="submit" name="modo" value="CONSULTAR">
      </form>
      </td></tr>
      </table>
      </body>
      </html>

    ';
   echo $cadena_z;
 }

?>