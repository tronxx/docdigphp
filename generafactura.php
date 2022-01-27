<?php 
  require_once("registrar.php");
  require_once("certificados.php");
  require_once("libs/grabafactura.php");

  date_default_timezone_set('America/Merida');
  $cert = new Certificados();
  $miskeys_z = json_decode(file_get_contents("tokens.json"), true);
  $factura_z = json_decode(file_get_contents('php://input'), true);
  $misdatfiscal_z = json_decode(file_get_contents("datosfiscales.json"), true);
  $date = new DateTime();
  // $date->modify('-10 hours');
  $entorno_z = $miskeys_z["entorno"];
  $ambiente_z = $miskeys_z["ambiente"];
  // $date->modify('-10 hours');
  // Defino el Entorno Sandbox o Produccion 
  // Defino Ambiente S de Sandbox o P de Produccion
  $factura_z["meta"]["ambiente"]= $ambiente_z;
  $factura_z["meta"]["empresa_uid"]= $miskeys_z["id"];
  $factura_z["meta"]["empresa_api_key"] = $miskeys_z[$entorno_z]["KeyPublica"];
  $pagoofactura_z = "factura";
  $tipo_comprobante_z = $factura_z["data"][0]["cfdi"]["cfdi__comprobante"]["tipo_comprobante"];
  if( $tipo_comprobante_z == "P") {
      $pagoofactura_z = "recepcion";
  }
  if($tipo_comprobante_z == "I") {
      $pagoofactura_z = "factura";
  }
  if($tipo_comprobante_z == "E") {
      $pagoofactura_z = "factura";
  }


  $factura_z["meta"]["objeto"] = $pagoofactura_z;
  $folio_z =  $factura_z["data"][0]["cfdi"]["cfdi__comprobante"]["folio"];
  $serie_z = $factura_z["data"][0]["cfdi"]["cfdi__comprobante"]["serie"];
  $yaexiste_z = json_decode(busca_factura($serie_z, $folio_z));
  if(empty($yaexiste_z) )  {
     //echo "Facturacion empresa_api_key:" .  $factura_z["meta"]["empresa_api_key"] . "<br>";

      $factura_z["data"][0]["datos_fiscales"]["certificado_pem"]  =  $cert->contenidoCertificado("certificado.cer");
      $factura_z["data"][0]["datos_fiscales"]["llave_pem"]        = $cert->contenidoLlave("key.pem");
      $factura_z["data"][0]["datos_fiscales"]["llave_password"]   = $cert->passwordLlave("passw.txt");
      $factura_z["data"][0]["cfdi"]["cfdi__comprobante"]["cfdi__emisor"]["rfc"] = $misdatfiscal_z["rfc"];
      $factura_z["data"][0]["cfdi"]["cfdi__comprobante"]["cfdi__emisor"]["nombre"] = $misdatfiscal_z["nombre"];
      $factura_z["data"][0]["cfdi"]["cfdi__comprobante"]["cfdi__emisor"]["regimen_fiscal"] = $misdatfiscal_z["regimen"];
       $total_z = $factura_z["data"][0]["cfdi"]["cfdi__comprobante"]["total"];
     // -> Bloqueo el cambio de Fecha $factura_z["data"][0]["cfdi"]["cfdi__comprobante"]["fecha"] = $date->format('Y-m-d\TH:i:s');  
    //  echo "Facturacion datos_fiscales llave_password:" .  $factura_z["data"][0]["datos_fiscales"]["llave_password"] . "<br>";

      // $facturaGenerada = $api->generacionFactura($factura);
      if ($pagoofactura_z == "recepcion") {
         $url = "https://api.docdigitales.com/v1/recepciones_pago/generar";
      } else {
        $url = "https://api.docdigitales.com/v1/facturas/generar";
      }
      $facturaGenerada = registra_conexion($url, $factura_z);
      $uuid_z = "-1";
      $fechatimbrado_z = "-1";
      if ($facturaGenerada["data"][0]["cfdi_respuesta"]["timbrada"] == "true") {
        $uuid_z = $facturaGenerada["data"][0]["cfdi_complemento"]["uuid"];
        $fechatimbrado_z = $facturaGenerada["data"][0]["cfdi_complemento"]["fecha_timbrado"];

          $nvafac_z = array(
            "serie" => $facturaGenerada["data"][0]["cfdi"]["cfdi__comprobante"]["serie"],
            "folio" => $facturaGenerada["data"][0]["cfdi"]["cfdi__comprobante"]["folio"],
            "fecha" => $facturaGenerada["data"][0]["cfdi"]["cfdi__comprobante"]["fecha"],
            "nombre" => $facturaGenerada["data"][0]["cfdi"]["cfdi__comprobante"]["cfdi__receptor"]["nombre"],
            "timbrada" => $facturaGenerada["data"][0]["cfdi_respuesta"]["timbrada"],
            "uuid" => $uuid_z,
            "fechatimbrado" => $fechatimbrado_z
          );
          $mifac_z = json_encode($nvafac_z);
          graba_factura($nvafac_z, $total_z);
      }

  } else {
    $facturaGenerada = $yaexiste_z;
    $facturaGenerada["error"] = "Esta factura ya ha sido timbrada";
  }

  echo json_encode($facturaGenerada);
?>
