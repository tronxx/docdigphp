<?php 
	/*
	*
	*
	*/
	class Usuario{
		private $idusuario;
		private $login;
		private $clave;

		public function getId(){
			return $this->idusuario;
		}

		public function setId($idusuario){
			$this->idusuario = $idusuario;
		}

		public function getNombre(){
			return $this->login;
		}

		public function setNombre($login){
			$this->login = $login;
		}

		public function getClave(){
			return $this->clave;
		}

		public function setClave($clave){
			$this->clave = $clave;
		}
	}
?>
