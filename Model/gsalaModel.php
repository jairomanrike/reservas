<?php

    class Sala  
    {    
        private $conexion;

        public function __construct($conexion){
          $this->conexion = $conexion;  
        }

        function getListSearchRoom($query){       

            $sql = "SELECT * FROM principal.sala  WHERE sala_nombre ILIKE '%$query%' ORDER BY sala_nombre DESC";
           
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

        function setInsertRoom($nombre,$responsable,$fecha,$usuario){

            $sql="INSERT INTO principal.sala (sala_nombre,
                                              sala_responsable,
                                              sala_fecha_registro,
                                              acce_id )
                                              values ('$nombre',
                                                      '$responsable',
                                                      '$fecha',
                                                      '$usuario')";

            // echo $sql;

            $response = $this->conexion->ejecutarConsulta($sql);

            $afectados = $this->conexion->filasAfectadas();

            if($afectados){

                return true;

            }
            else{

                return false;

            }

        }



        function getExitRoom($nombre){       

            $sql = "SELECT sala_id FROM principal.sala  WHERE UPPER(sala_nombre)='$nombre'";
            // echo $sql;
            $response = $this->conexion->ejecutarConsulta($sql);

            $CountSala = $this->conexion->cuentaFilas();

            if ($CountSala>0){

                return true;

            }else {

                return false;

            }
        }


        function getInfoRoom($query){       

            $sql = "SELECT * FROM principal.sala  WHERE sala_id =$query";
           
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


        function setUpdateRoom($sala_id,$sala_nombre,$sala_responsable,$fecha_registro,$usuario){

            $sql="UPDATE principal.sala SET sala_nombre = '$sala_nombre',
                                            sala_responsable = '$sala_responsable',
                                            sala_fecha_actualizacion = '$fecha_registro',
                                            acce_id = $usuario
                                        WHERE sala_id = $sala_id";

             // echo $sql;

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