<?php 
  require_once("libs/grabafactura.php");

	$factura_z = json_decode(file_get_contents('php://input'), true);
    if ($factura_z["data"][0]["cfdi_respuesta"]["timbrada"] == "true") {
        $uuid_z = $factura_z["data"][0]["cfdi_complemento"]["uuid"];
        $fechatimbrado_z = $factura_z["data"][0]["cfdi_complemento"]["fecha_timbrado"];

        $nvafac_z = array(
          "serie" => $factura_z["data"][0]["cfdi"]["cfdi__comprobante"]["serie"],
          "folio" => $factura_z["data"][0]["cfdi"]["cfdi__comprobante"]["folio"],
          "fecha" => $factura_z["data"][0]["cfdi"]["cfdi__comprobante"]["fecha"],
          "nombre" => $factura_z["data"][0]["cfdi"]["cfdi__comprobante"]["cfdi__receptor"]["nombre"],
          "timbrada" => $factura_z["data"][0]["cfdi_respuesta"]["timbrada"],
          "uuid" => $uuid_z,
          "fechatimbrado" => $fechatimbrado_z
        );
        $mifac_z = json_encode($nvafac_z);
        graba_factura($nvafac_z);
        echo $mifac_z;
     }
?>
