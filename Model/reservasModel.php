<?php 

	class Reserva{
		
		private $conexion;

		function __construct($conexion) {
			$this->conexion = $conexion;
		}

		function listRoom(){

			$sql = "SELECT sala_id,sala_nombre FROM principal.sala";

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

		function getInfoResponsableByRoom($sala){

			$sql = "SELECT sala_responsable
					FROM principal.sala 
					WHERE sala_id=$sala";

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

		function getInfoReservationByRoom($sala){

			$sql = "SELECT r.rese_id, 
						   r.sala_id,
						   r.acce_id, 
						   r.rese_fecha_hora_inicial,
						   r.rese_fecha_hora_final,
                           rese_precio, 
						   r.rese_fecha_registro,
						   s.sala_nombre,
						   a.acce_username
					FROM principal.reserva r,principal.sala s, principal.acceso a
					WHERE r.sala_id=$sala
					AND s.sala_id=r.sala_id
					AND a.acce_id=r.acce_id";

			$response = $this->conexion->ejecutarConsulta($sql);

			$cantidad = $this->conexion->cuentaFilas();

			$data = array();

			if($cantidad>0){
				
				while($row = $this->conexion->extraerRegistros()){
					$data[] = $row;
				}
				return $data;
			}else{
				return $data;
			}

		}

		function getExitReservation($sala,$fecha_incial,$fecha_final){       

            $sql = "SELECT rese_id FROM principal.reserva  WHERE sala_id = $sala
                                                            AND rese_fecha_hora_final = '$fecha_final'
                                                            AND rese_fecha_hora_inicial = '$fecha_incial'
                    UNION
                    SELECT rese_id FROM principal.reserva  WHERE sala_id = $sala            		
                                                            AND rese_fecha_hora_inicial <= '$fecha_incial'
                                                            AND rese_fecha_hora_final >= '$fecha_final'
                    UNION 
                    SELECT rese_id FROM principal.reserva  WHERE sala_id = $sala            		
                                                            AND rese_fecha_hora_inicial >= '$fecha_incial'
                                                            AND rese_fecha_hora_final <= '$fecha_final'
                    ";

            $response=$this->conexion->ejecutarConsulta($sql);

            $CountSala=$this->conexion->cuentaFilas();

            if ($CountSala>0) {
                return true;
            }else {
                return false;
            }
        }

		function setInsertReservation($sala,$fecha_incial,$fecha_final,$precio,$responsable,$fecha_registro){

            $sql="INSERT INTO principal.reserva (sala_id,
                                              acce_id,
                                              rese_fecha_hora_inicial,
                                              rese_fecha_hora_final,
                                              rese_fecha_registro,
                                              rese_precio )
                                              values ('$sala',
                                                      '$responsable',
                                                      '$fecha_incial',
                                                      '$fecha_final',
                                                  	  '$fecha_registro',
                                                      '$precio')";


            $response=$this->conexion->ejecutarConsulta($sql);

            $afectados=$this->conexion->filasAfectadas();

            if($afectados){
                return true;
            }
            else{
                return false;
            }

        }



        function setDeleteReservation($reserva){

            $sql="DELETE FROM principal.reserva WHERE rese_id=$reserva";

            $response=$this->conexion->ejecutarConsulta($sql);

            $afectados=$this->conexion->filasAfectadas();

            if($afectados){
                return true;
            }
            else{
                return false;
            }

        }


        function getInfoReservation($query){       

            $sql = "SELECT * FROM principal.reserva r INNER JOIN principal.sala s using(sala_id) WHERE rese_id = $query";
           
            $response = $this->conexion->ejecutarConsulta($sql);

            $CountSala = $this->conexion->cuentaFilas();

            if ($CountSala>0) {
            
                    $data = array();

                    while ($row = $this->conexion->extraerRegistros()) {

                    $data[] = $row;

                }
            
                return $data;
                
            }else {
                return 0;
            }
        }

        function setUpdateReservation($reserva_id,$fecha_inicial,$fecha_final,$fecha_registro,$precio,$usuario){

            $sql="UPDATE principal.reserva SET rese_fecha_hora_final='$fecha_final',
                                            rese_fecha_hora_inicial='$fecha_inicial',
                                            rese_precio = '$precio',
                                            rese_fecha_actualizacion='$fecha_registro',
                                            acce_id=$usuario
                                        WHERE rese_id=$reserva_id";

            $response = $this->conexion->ejecutarConsulta($sql);

            $afectados = $this->conexion->filasAfectadas();

            if($afectados){

                return true;

            }
            else{

                return false;

            }

        }
	

	}

 ?>