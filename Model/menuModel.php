<?php 
	
	class Menu{

		private $conexion;
		private $rol;


		function __construct($conexion,$rol){
			$this->conexion = $conexion;
			$this->rol = $rol;
		}

		function getMenuAccess(){

			$sql = "SELECT  m.modu_id,
							m.modu_nombre,
							m.modu_url, 
							m.modu_activo 
					FROM principal.modulo_rol mr, principal.modulo m
					WHERE mr.rol_id=$this->rol
					AND mr.moro_activo='SI'
					AND m.modu_id=mr.modu_id
					AND m.modu_activo='SI'";

			$response = $this->conexion->ejecutarConsulta($sql);

			$cantidad = $this->conexion->cuentaFilas();

			
			if($cantidad>0){
				
				$data = array();

				while($row = $this->conexion->extraerRegistros()){

					$data[] = $row;
				}
				return $data;
			}else{
				return 0;
			}

		}
	}

 ?>