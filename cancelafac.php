
<?php 

  require_once("registrar.php");
  require_once("certificados.php");
  require_once("libs/grabafactura.php");

  $uuid_z = "";
  $email_z = "";
  $serie_z = "";
  $folio_z = "";
  $rfccli_z = "";
  $otal_z = "-1";
  $uuidrel_z = "";
  $modo_z = "INTERACTIVO";
  $modoenviado_z = "";
  $peticion_z = "POST";

  if(isset($_POST["uuid"]))  $uuid_z  =  $_POST["uuid"];
  if(isset($_POST["email"])) $email_z =  $_POST["email"];
  if(isset($_POST["modo"]))  $modo_z  =  $_POST["modo"];
  if(isset($_POST["serie"])) $serie_z =  $_POST["serie"];
  if(isset($_POST["folio"])) $folio_z =  $_POST["folio"];
  if(isset($_POST["total"])) $total_z =  $_POST["total"];
  if(isset($_POST["rfccli"])) $rfccli_z =  $_POST["rfccli"];
  if(isset($_POST["motivo"])) $motivo_z =  $_POST["motivo"];
  if(isset($_POST["uuidrel"])) $uuidrel_z =  $_POST["uuidrel"];
  if(isset($_POST["modo_interactivo"])) $modoenviado_z =  $_POST["modo_interactivo"];


  if(isset($_GET["uuid"]))  $uuid_z  =  $_GET["uuid"];
  if(isset($_GET["email"])) $email_z =  $_GET["email"];
  if(isset($_GET["modo"]))  $modo_z  =  $_GET["modo"];
  if(isset($_GET["serie"])) $serie_z =  $_GET["serie"];
  if(isset($_GET["folio"])) $folio_z =  $_GET["folio"];
  if(isset($_GET["motivo"])) $motivo_z =  $_GET["motivo"];
  if(isset($_GET["uuidrel"])) $uuidrel_z =  $_GET["uuidrel"];
  if(isset($_GET["modo_interactivo"])) $modoenviado_z =  $_GET["modo_interactivo"];

  if($modo_z == "ENVIAR") {
    $cadena_z = cancela_fac($uuid_z, $email_z, $serie_z, $folio_z, $total_z, $rfccli_z, $motivo_z, $uuidrel_z);

    if ($modoenviado_z != "msg_enviado") {
      echo $cadena_z;
    }
    if ($modoenviado_z == "msg_enviado") {
      mensaje_enviado("Solicitud de Cancelacion Enviada");
    }
  }

  if($modo_z == "INTERACTIVO") {
    dibuja_formulario();
  }


	function cancela_fac(String $uuid_z, $correo_z, $serie_z, $folio_z, $total_z, $rfccli_z, $motivo_z, $uuidrel_z) {
	date_default_timezone_set('America/Merida');
	$cert = new Certificados();
	$miskeys_z = json_decode(file_get_contents("tokens.json"), true);
	$factura_z = json_decode(file_get_contents("cancela.json"), true);
	$date = new DateTime();
	// $date->modify('-10 hours');
	// $uuid = "31698B51-735D-44CB-B8D0-4515851C36BD";
  $entorno_z = $miskeys_z["entorno"];
  $ambiente_z = $miskeys_z["ambiente"];
  $misdatfiscal_z = json_decode(file_get_contents("datosfiscales.json"), true);
  
  // $date->modify('-10 hours');
  $factura_z["meta"]["ambiente"]= $ambiente_z;
  $factura_z["meta"]["empresa_uid"]= $miskeys_z["id"];
  $factura_z["meta"]["empresa_api_key"] = $miskeys_z[$entorno_z]["KeyPublica"];
  $factura_z["meta"]["objeto"] = "factura";
  $factura_z["data"][0]["datos_fiscales"]["certificado_pem"]  =  $cert->contenidoCertificado("certificado.cer");
  $factura_z["data"][0]["datos_fiscales"]["llave_pem"]        = $cert->contenidoLlave("key.pem");
  $factura_z["data"][0]["datos_fiscales"]["llave_password"]   = $cert->passwordLlave("passw.txt");

	// echo "Facturacion empresa_api_key:" .  $factura_z["meta"]["empresa_api_key"] . "<br>";
  $factura_z["data"][0]["rfc_emisor"] = $misdatfiscal_z["rfc"];
  $factura_z["data"][0]["folios"][0]["rfc_receptor"] = $rfccli_z;
	$factura_z["data"][0]["folios"][0]["uuid"] = $uuid_z;
  $factura_z["data"][0]["folios"][0]["total"] = $total_z;
  $factura_z["data"][0]["folios"][0]["motivo"] = $motivo_z;
  if(!empty($uuidrel_z)) {
    $factura_z["data"][0]["folios"][0]["folio_sustituto"] = $uuidrel_z;
  }

	$url = "https://api.docdigitales.com/v1/cancelaciones/solicitar";
  //echo json_encode($factura_z, true);
	$facturaDescargada = registra_conexion($url, $factura_z);
	$cadena_z = json_encode($facturaDescargada);
  $faccancel_z["serie"]=$serie_z;
  $faccancel_z["folio"]=$folio_z;
  actualiza_estado_factura($faccancel_z, $total_z, "CANCELADO");
  return ($cadena_z);

	//$link_z = $facturaDescargada["data"]["link"];
	//$uuid = $facturaGenerada["data"][0]["cfdi_complemento"]["uuid"];
	//$idfac = $facturaGenerada["meta"]["respuesta_uid"];

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
    $uuid_z = "";
    $serie_z ="";
    $folio_z = "";
    if(isset($_POST["uuid"]))  $uuid_z  =  $_POST["uuid"];
    if(isset($_POST["serie"])) $serie_z =  $_POST["serie"];
    if(isset($_POST["folio"])) $folio_z =  $_POST["folio"];

    $cadena_z = '<H2> Cancelacion de Facturas</h2>

      Teclee los datos de la Factura a Cancelar:
      <form action="cancelafac.php" method="POST" >
        <div style="width: 30%">
        <label for="uuid"> Uuid:</label>
        </div>
        <div style="width: 70%">
        <input type="text" id="uuid" name="uuid" value="' . $uuid_z .'" size="50">
        </div>
        <div style="width: 30%">
        <label for="serie"> Serie:</label>
        </div>
        <div style="width: 70%">
        <input type="text" id="serie" name="serie" value="' . $serie_z .'" size="50" >
        </div>
        <div style="width: 30%">
        <label for="folio"> Folio:</label>
        </div>
        <div style="width: 70%">
        <input type="text" id="folio" name="folio" value="'. $folio_z . '" size="50" >
        </div>
        <div style="width: 30%">
        <label for="rfccli"> RFC Cliente:</label>
        </div>
        <div style="width: 70%">
        <input type="text" id="rfccli" name="rfccli" size="50" >
        </div>
        <div style="width: 30%">
        <label for="total"> Total:</label>
        </div>
        <div style="width: 70%">
        <input type="text" id="total" name="total" size="50" >
        </div>
        <div style="width: 30%">
        <label for="motivo"> Motivo Cancelacion:</label>
        </div>
        <div style="width: 70%">
        <select name="motivo" id="motivo">
          <option value = "01">Comprobante Emitido con errores con relacion</option>
          <option value = "02">Comprobante Emitido con errores sin relacion</option>
          <option value = "03" selected> No se llevo a cabo la operacion</option>
          <option value = "04">Operacion nominativa relacionada en una factura global</option>
        </select>
        </div>
        <div style="width: 30%">
        <label for="uuidrel"> Uuid Relacionado:</label>
        </div>
        <div style="width: 70%">
        <input type="text" id="uuidrel" name="uuidrel" size="50">
        Deje en blanco Si no tiene folio relacionado
        </div>

        <div style="width: 30%">
        <label for="email"> Correo Destino:</label>
        </div>
        <div style="width: 70%">
        <input type="email" id="email" name="email" size="50">
        </div>
        <input type="hidden" id="modo_interactivo" name="modo_interactivo" value="msg_enviado" >
       
        <input type="submit" name="modo" value="ENVIAR">
      </form>
      </body>
      </html>

    ';
   echo $cadena_z;
 }

 function mensaje_enviado($mensaje_z) {
    $cad_z = "<script>";
    $cad_z = $cad_z . "alert(' . $mensaje_z . ');";
    $cad_z = $cad_z . "window.location = 'cancelafac.php';";
    $cad_z = $cad_z . "</script>";
    echo $cad_z;
  }


?>
