 <?php 
  require_once("registrar.php");
  require_once("certificados.php");
  require_once("libs/grabafactura.php");
  
  date_default_timezone_set('America/Merida');
  $cert = new Certificados();
  $miskeys_z = json_decode(file_get_contents("tokens.json"), true);
  $factura_z = json_decode(file_get_contents('php://input'), true);
  $date = new DateTime();
  $entorno_z = $miskeys_z["entorno"];
  $ambiente_z = $miskeys_z["ambiente"];
  // $date->modify('-10 hours');
  // Defino el Entorno Sandbox o Produccion 
  // Defino Ambiente S de Sandbox o P de Produccion
  $factura_z["meta"]["ambiente"]= $ambiente_z;
  $factura_z["meta"]["empresa_uid"]= $miskeys_z["id"];
  $factura_z["meta"]["empresa_api_key"] = $miskeys_z[$entorno_z]["KeyPublica"];

      $factura_z["data"][0]["datos_fiscales"]["certificado_pem"]  =  $cert->contenidoCertificado("certificado.cer");
      $factura_z["data"][0]["datos_fiscales"]["llave_pem"]        = $cert->contenidoLlave("key.pem");
      $factura_z["data"][0]["datos_fiscales"]["llave_password"]   = $cert->passwordLlave("passw.txt");
      $factura_z["data"][0]["cfdi"]["cfdi__comprobante"]["fecha"] = $date->format('Y-m-d\TH:i:s');  

      //$facturaGenerada = $api->generacionFactura($factura);
      $url = "https://api.docdigitales.com/v1/recepciones_pago/generar";
      $facturaGenerada = registra_conexion($url, $factura_z);
      echo json_encode($facturaGenerada);
      //$uuid = $facturaGenerada["data"][0]["cfdi_complemento"]["uuid"];
      //$idfac = $facturaGenerada["meta"]["respuesta_uid"];
      //echo "<tr><td>Uuid:" . $uuid . "</td></tr>";
      //echo "<tr><td>idRespuesta:" . $idfac . "</td></tr>";
      //$cadena_z = '<textarea name="comment"> ' . json_encode($facturaGenerada) . '</textarea>';

	//$link_z = $facturaDescargada["data"]["link"];
	//$uuid = $facturaGenerada["data"][0]["cfdi_complemento"]["uuid"];
	//$idfac = $facturaGenerada["meta"]["respuesta_uid"];
	//echo "<tr><td>Respuesta:<br>" . $cadena_z . "</td></tr>";

?>
