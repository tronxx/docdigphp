<?php 
	//carga la plantilla con la header y el footer
    $archivo_z = "login/login.php";
	if(!file_exists($archivo_z)) {
		$archivo_z = "login/login.php";
	}
		header("location: " . $archivo_z);
	//require_once($archivo_z);	
 ?>
 