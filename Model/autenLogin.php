<?php 
	
	class Login{ // En todas las clases de la carpeta model generamos el constructor y obtemos la conexion a la base datos

		private $conexion; 

		function __construct($conexion) {
			$this->conexion = $conexion;
		}



		function loginUser($username, $password){ //

			$sql = "SELECT * FROM principal.acceso a, principal.persona p
				    WHERE a.acce_username='$username'
				    AND p.pers_id=a.pers_id 
				    AND a.acce_activo ='SI'";	


			$response = $this->conexion->ejecutarConsulta($sql);
			$cantidad = $this->conexion->cuentaFilas();

			if ($cantidad>0){

				while($row = $this->conexion->extraerRegistros()){

					if (password_verify($password,$row["acce_password"])) {
						return $row;
					}
				}
			}

			return 0;
		}

	}

 ?>