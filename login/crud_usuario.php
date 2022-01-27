<?php 
	require_once('../libs/conecta.php');
	require_once('usuario.php');
	
	class CrudUsuario{

		public function __construct(){}

		//inserta los datos del usuario
		public function insertar($usuario){
			$db=DB::conectar();
			$insert=$db->prepare('INSERT INTO car_usuarios VALUES(NULL,:login, :clave)');
			$insert->bindValue('login',$usuario->getNombre());
			//encripta la clave
			$pass=password_hash($usuario->getClave(),PASSWORD_DEFAULT);
			$insert->bindValue('clave',$pass);
			$insert->execute();
		}

		//obtiene el usuario para el login
		public function obtenerUsuario($login, $clave){
			$conn=conecta_pdo();
			$sql_z =  sprintf("select * from car_usuarios where login = :LOGIN ");
			$sentencia = $conn->prepare($sql_z);
			$sentencia->bindParam(":LOGIN", $login, PDO::PARAM_STR );
			$sentencia->execute();
			$result_z = $sentencia->fetch();
   		 	$registro = $result_z;

			//$db=conecta_pdo();
			//$select=$db->prepare('SELECT * FROM car_usuarios WHERE LOGIN=:login');//AND clave=:clave
			//$select->bindValue(':login',$login, PDO::PARAM_STR);
			//$select->execute();
			//$registro=$select->fetch();
			$usuario=new Usuario();
			//verifica si la clave es correcta
			//echo "Login:" . $login . "**<br> Clave:" . $clave . "**<br> Registro[CLAVE]:" . $registro['CLAVE'] . "<br>";
			//echo json_encode($result_z,true);
			//echo '<br>' . $sql_z. '<br>';
			if ($clave == $registro['CLAVE']) {				
				//if (password_verify($clave, $registro['clave'])) {				
				//si es correcta, asigna los valores que trae desde la base de datos
				$usuario->setId($registro['IDUSUARIO']);
				$usuario->setNombre($registro['LOGIN']);
				$usuario->setClave($registro['CLAVE']);
			}			
			return $usuario;
		}

		//busca el nombre del usuario si existe
		public function buscarUsuario($login){
			$db=Db::conectar();
			$select=$db->prepare('SELECT * FROM car_usuarios WHERE login=:login');
			$select->bindValue('login',$login);
			$select->execute();
			$registro=$select->fetch();
			if($registro['Idusuario']!=NULL){
				$usado=False;
			}else{
				$usado=True;
			}	
			return $usado;
		}
	}
?>