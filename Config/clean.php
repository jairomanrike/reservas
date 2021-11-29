<?php

	class Clean { // Clase Clean para limpiar los que venga en los input

		 private $cadena;
		 private $fecha_hora;

		function __construct(string $cadena) {
			 $this->cadena = $cadena;

		}

		public function cleanString() {

			$this->cadena=trim($this->cadena);
			$this->cadena=stripslashes($this->cadena);
			$this->cadena=str_replace("<script>","",$this->cadena);
			$this->cadena=str_replace("</script>", "", $this->cadena);
			$this->cadena=str_replace("<script src=>", "", $this->cadena);
			$this->cadena=str_replace("<script type=>", "", $this->cadena);
			$this->cadena=str_replace("SELECT * FROM", "", $this->cadena);
			$this->cadena=str_replace("DELETE FROM", "", $this->cadena);
			$this->cadena=str_replace("INSERT INTO", "", $this->cadena);
			$this->cadena=str_replace("SELECT COUNT(*) FROM", "", $this->cadena);
			$this->cadena=str_replace("select * from", "", $this->cadena);
			$this->cadena=str_replace("delete from", "", $this->cadena);
			$this->cadena=str_replace("insert into", "", $this->cadena);
			$this->cadena=str_replace("select count(*) from", "", $this->cadena);
			$this->cadena=str_replace("DROP TABLE", "", $this->cadena);
			$this->cadena=str_replace("drop table", "", $this->cadena);
			$this->cadena=str_replace("where =", "", $this->cadena);
			$this->cadena=str_replace("LIKE", "", $this->cadena);
			$this->cadena=str_replace("IS NULL;", "", $this->cadena);
			$this->cadena=str_replace('OR "a"="a"', "", $this->cadena);
			$this->cadena=str_replace('OR "1"="1"', "", $this->cadena);
			$this->cadena=str_replace('OR "a"="a"', "", $this->cadena);
			$this->cadena=str_replace('OR "1"="1"', "", $this->cadena);
			$this->cadena=str_replace("WHERE =", "", $this->cadena);
			$this->cadena=str_replace(">", "", $this->cadena);
			$this->cadena=str_replace(">=", "", $this->cadena);
			$this->cadena=str_replace("<", "", $this->cadena);
			$this->cadena=str_replace("<=", "", $this->cadena);
			$this->cadena=str_replace("[", "", $this->cadena);
			$this->cadena=str_replace("]", "", $this->cadena);
			$this->cadena=str_replace("==", "", $this->cadena);
			// $this->cadena=str_replace("T","", $this->cadena);
			

			return $this->cadena;
		}


		public function checkDate($date){

			if (date('Y-m-d H:i:s', strtotime($date)) == $date) {
		      return true;
		    } else {
		      return false;
		    }
			
		}

		public function checkDateOld($fecha_inicial,$fecha_final){
			if ($fecha_final <= $fecha_inicial) {
				return false;
			}else{
				return true;
			}
		}

		public function checkDateOld2($fecha){

			$fecha_actual = date("Y-m-d H:i:s");

			if ($fecha <= $fecha_actual) {
				return false;
			}else{
				return true;
			}
		}
	}

 ?>