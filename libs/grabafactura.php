<?php
  require_once("conecta.php");


  function graba_factura($factura_z, $total_z) {
  	$mifactura_z = json_decode(busca_factura($factura_z["serie"], $factura_z["folio"]));
  	if (empty($mifactura_z )) {
  		$sql = sprintf("insert into facturas (folio, serie, nombre, fecha, timbrado, uuid, total, status, fechatimbrado) values(%s, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
  			$factura_z["folio"],
  			$factura_z["serie"],
  			$factura_z["nombre"],
  			$factura_z["fecha"],
  			$factura_z["timbrada"],
  			$factura_z["uuid"],
  			$total_z,
  			"ACTIVO",
  			$factura_z["fechatimbrado"]
  		);
  		$conn=conecta();
		$rs = mysqli_query($conn,$sql);
		mysqli_close($conn);
  	}


  }

  function actualiza_estado_factura($factura_z, $total_z, $status_z) {
  	$mifactura_z = json_decode(busca_factura($factura_z["serie"], $factura_z["folio"]), true);
  	if (!empty($mifactura_z )) {
  		$idfac_z = $mifactura_z[0]["idfactura"];
  		$sql = sprintf("update facturas set status = '%s' where idfactura = %s",
  			$status_z,
  			$idfac_z
  		);
  		// echo "Idfac:" . $idfac_z . " sql:" . $sql;
  		$conn=conecta();
		$rs = mysqli_query($conn,$sql);
		mysqli_close($conn);
  	}

  }

  function busca_factura($serie_z, $folio_z) {
		$conn=conecta();
		$sql =  sprintf("select * from facturas where serie='%s' and folio=%s", $serie_z, $folio_z);
		$rs = mysqli_query($conn,$sql);
		$encode = array();
		while ($row =  mysqli_fetch_array($rs)) {
			  $encode[] = $row;

		}
		mysqli_close($conn);
		return (json_encode($encode));
    }

  function busca_rango_facturas($condiciones_z) {
		$conn=conecta();
		$miscondiciones_z = json_decode($condiciones_z);
		$sql =  sprintf("select * from facturas where ");
		if($miscondiciones_z["condicion"] == "rango_folios") {
			$sql_z = $sql_z . sprintf(" serie='%s'",$miscondiciones_z["serie"] );
			$sql_z = $sql_z . sprintf(" and folio between %s and %s order by folio",$miscondiciones_z["folioini"], $miscondiciones_z["foliofin"]  );
		}
		if($miscondiciones_z["condicion"] == "rango_fechas") {
			$sql_z = $sql_z . sprintf(" serie='%s'",$miscondiciones_z["serie"] );
			$sql_z = $sql_z . sprintf(" and Date(fecha) between %s and %s order by fecha, folio",$miscondiciones_z["fechaini"], $miscondiciones_z["fechafin"]  );
		}
		if($miscondiciones_z["condicion"] == "uuid") {
			$sql_z = $sql_z . sprintf(" uuid='%s'",$miscondiciones_z["uuid"] );
		}

		$rs = mysqli_query($conn,$sql);
		$encode = array();
		while ($row =  mysqli_fetch_array($rs)) {
			  $encode[] = $row;

		}
		mysqli_close($conn);
		return (json_encode($encode));
    }

  function busca_rango_fac($condiciones_z) {
		$conn=conecta();
		# echo $condiciones_z;
		$miscondiciones_z = json_decode($condiciones_z, true);
		$folioini_z = $miscondiciones_z["folioini"];
		$foliofin_z = $miscondiciones_z["foliofin"];
		$serieini_z = $miscondiciones_z["serieini"];
		$seriefin_z = $miscondiciones_z["seriefin"];
		$fechaini_z = $miscondiciones_z["fechaini"];
		$fechafin_z = $miscondiciones_z["fechafin"];
		$sql_z =  sprintf("select * from facturas where ");
		$sql_z =  $sql_z . sprintf(" folio between %s and %s ", $folioini_z, $foliofin_z);
		$sql_z =  $sql_z . sprintf(" and serie between '%s' and '%s' ", $serieini_z, $seriefin_z);
		$sql_z =  $sql_z . sprintf(" and Date(fecha) between '%s' and '%s' ", $fechaini_z, $fechafin_z);
		#$sentencia = $conn->prepare($sql_z);
		#echo $sql_z . "<br>";
		#$sentencia=$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		#$sentencia->bindParam(":FOLIOINI", $folioini_z);
		#$sentencia->bindParam(":FOLIOINI", $foliofin_z);
		#$sentencia->bindParam(":SERIEINI", $serieini_z);
		#$sentencia->bindParam(":SERIEFIN", $seriefin_z);
		#$sentencia->bindParam(":FECHAINI", $fechaini_z);
		#$sentencia->bindParam(":FECHAFIN", $fechafin_z);
		#$sentencia->execute();

		#$result_z = $sentencia->fetchAll();
		#echo "<br>Resultados:<br>";
		#print_r($result_z);

		$rs = mysqli_query($conn,$sql_z);
		$encode = array();
		while ($row =  mysqli_fetch_array($rs)) {
			  $encode[] = $row;

		}
		mysqli_close($conn);
		return (json_encode($encode));
    }

    function busca_rango_fac_pdo($condiciones_z) {
		$conn=conecta_pdo();
		# echo $condiciones_z;
		$miscondiciones_z = json_decode($condiciones_z, true);
		$folioini_z = $miscondiciones_z["folioini"];
		$foliofin_z = $miscondiciones_z["foliofin"];
		$serieini_z = $miscondiciones_z["serieini"];
		$seriefin_z = $miscondiciones_z["seriefin"];
		$fechaini_z = $miscondiciones_z["fechaini"];
		$fechafin_z = $miscondiciones_z["fechafin"];
		$sql_z =  sprintf("select * from facturas ");
		$sql_z =  $sql_z . sprintf(" where ");
		$sql_z =  $sql_z . sprintf(" folio between :FOLIOINI and :FOLIOFIN ");
		$sql_z =  $sql_z . sprintf(" and serie between :SERIEINI and :SERIEFIN ");
		$sql_z =  $sql_z . sprintf(" and Date(fecha) between :FECHAINI and :FECHAFIN ");
		$sentencia = $conn->prepare($sql_z);
		#echo $sql_z . "<br>";
		
		#$sentencia=$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$sentencia->bindParam(":FOLIOINI", $folioini_z, PDO::PARAM_INT);
		$sentencia->bindParam(":FOLIOFIN", $foliofin_z, PDO::PARAM_INT);
		$sentencia->bindParam(":SERIEINI", $serieini_z, PDO::PARAM_STR );
		$sentencia->bindParam(":SERIEFIN", $seriefin_z, PDO::PARAM_STR );
		$sentencia->bindParam(":FECHAINI", $fechaini_z, PDO::PARAM_STR );
		$sentencia->bindParam(":FECHAFIN", $fechafin_z, PDO::PARAM_STR );
		$sentencia->execute();

		$result_z = $sentencia->fetchAll();
		return (json_encode($result_z));
		#echo "<br>Resultados:<br>";
		#print_r($result_z);

		#$rs = mysqli_query($conn,$sql_z);
		#$encode = array();
		#while ($row =  mysqli_fetch_array($rs)) {
	    #		  $encode[] = $row;

		#}
		#mysqli_close($conn);
		#return (json_encode($encode));
    }


?>
