<?php 
 $inputJSON = file_get_contents('php://input');
 
 echo "JSON Recibido\n";
 $misdatos_z = json_decode($inputJSON, true);
 $serie_z  = $misdatos_z["data"][0]["cfdi"]["cfdi__comprobante"]["serie"];
 $folio_z  = $misdatos_z["data"][0]["cfdi"]["cfdi__comprobante"]["folio"];
 $rfc_z    = $misdatos_z["data"][0]["cfdi"]["cfdi__comprobante"]["cfdi__receptor"]["rfc"];
 $nombre_z = $misdatos_z["data"][0]["cfdi"]["cfdi__comprobante"]["cfdi__receptor"]["nombre"];
 echo "Serie:" . $serie_z . "\n";
 echo "Folio:" . $folio_z . "\n";
 echo "Rfc:" . $rfc_z . "\n";
 echo "Nombre:" . $nombre_z . "\n";

?>
