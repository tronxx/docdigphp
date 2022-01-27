<?php
    error_reporting(E_ALL  ^  E_WARNING );    

    $accion_z = "";
    //$accion_z = "$_GET['accion']";
  	
    if($accion_z == "getcia") {
      $cia_z = $_GET['cia'];
      busca_cia($cia_z);
    }

	function busca_cia($cia_z) {
		return (0);
	}

	function conecta() {
        $misdatosbd_z = json_decode(file_get_contents("datosbd.json"), true);

		$data_source=$misdatosbd_z["source"];
		$user= $misdatosbd_z["user"];
		$password=strrev($misdatosbd_z["pwd"]);
		$basedatos = $misdatosbd_z["database"];
		//$data_source='localhost:3306';
		//$user='root';
		//$password='';
		//$basedatos = 'facturacion';

       $conn=mysqli_connect($data_source,$user,$password, $basedatos );
		if (!($conn)) { 
		  echo "<p>Connection to DB failed: ";
		  echo "Ha ocurrido un error en la conexion a la BD";
		  echo "</p>\n";
		}
		// mysql_select_db('my_database') or die('No se pudo seleccionar la base de datos');
		//$db = mysqli_select_db( $conn, ) or die ( "No se ha podido conectar a la base de datos" );
 	    
		return ($conn);
	}

	function conecta_pdo() {
		$datosbd_z = "datosbd.json";
		if(!file_exists($datosbd_z)) {
			$datosbd_z = "../datosbd.json";
		}
        $misdatosbd_z = json_decode(file_get_contents($datosbd_z), true);

		$data_source=$misdatosbd_z["source"];
		$user= $misdatosbd_z["user"];
		$password=strrev($misdatosbd_z["pwd"]);
		$basedatos = $misdatosbd_z["database"];
		//$data_source='localhost:3306';
		//$user='root';
		//$password='';
		//$basedatos = 'facturacion';
		$conn = new PDO('mysql:host='. $data_source. ';dbname=' . $basedatos, $user, $password);
		if (!($conn)) { 
		  echo "<p>Connection to DB failed: ";
		  echo "Ha ocurrido un error en la conexion a la BD";
		  echo "</p>\n";
		}
 	    
		return ($conn);

	}

	
?>
