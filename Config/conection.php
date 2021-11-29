<?php

    class Conexion  // Clase que conecta con la base de datos
    { 
        private $conexion;
        private $resultado;
      
            function __construct(){
                if(!isset($this->conexion)){
                     $this->conexion = pg_connect("host=localhost port=5432 dbname=reservas user=postgres password=admin")
                or die ("error para conectarse a la base de datos");
                }
             }

            public function ejecutarConsulta($sql){
                $this->resultado=pg_query($this->conexion,$sql);
             }
      
            public function extraerRegistros(){
                if($fila=pg_fetch_assoc($this->resultado)){
                    return $fila;
                }
                else{
                    return false;
                }
            }
      
            public function cuentaFilas(){
                return pg_num_rows($this->resultado);
            }
      
            public function filasAfectadas(){
                if(pg_affected_rows($this->resultado)){
                    return true;
                }
                else{
                    return false;
                }
            }
      
            public function iniciar(){
                $this->ejecutarConsulta("BEGIN");
            }
      
      
            public function confirmar(){
                $this->ejecutarConsulta("COMMIT");
                $this->cerrar();
            }
          
            public function revertir(){
                $this->ejecutarConsulta("ROLLBACK");
                $this->cerrar();
            }
            
            public function cerrar(){
                if(isset($this->conexion)){
                    return pg_close($this->conexion);
                }      
            }
    } #FIN DE CLASS
?>
