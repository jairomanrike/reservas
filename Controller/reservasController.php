<?php 
	require_once('../Config/autentication.php');
	require_once "../Config/clean.php";
	require_once '../Config/conection.php';
	require_once '../Model/reservasModel.php';

 	if (!$_GET['option']) {
 		echo json_encode(array('error'));
 		exit;
 	}

 	$option = $_GET['option']; 

 	switch ($option) { // Switch para captarar la accion que el cliente envia por el metodo GET

 		case "getResponsable":

 			if (empty($_GET['query'])){
 				echo json_encode($data = array("status" =>false, "message" =>"Sala no existe"));
 				exit();
 			}

 			$query = $_GET['query'];

 			require_once "../Config/clean.php";

 			$obtClean = new Clean($query);

 			$query = $obtClean->cleanString($query);

 			if (!filter_var($query, FILTER_VALIDATE_INT)) {
 				echo json_encode($data = array("status" =>false, "message" =>"Sala no existe"));
 			}

 			

 			$conexion = new Conexion();

 			

 			$obtReserva = new Reserva($conexion);

 			$response = $obtReserva->getInfoResponsableByRoom($query);

 			if ($response) {

 				foreach($response as $item){
 				$responsable = $item['sala_responsable'];
 				}
 				 echo json_encode($datos = array("status"=>true,"data"=>$responsable));
 				exit;
 			}else{
 				echo json_encode($datos = array("status"=>false));
 				exit;
 			}


 		break;

 		case "search":
 			
 			if (empty($_GET['query'])){  // Verificamos que vanga algo por parameros
 				exit();
 			}

 			$query = $_GET['query'];

 			$obtClean = new Clean($query);

 			$query = $obtClean->cleanString();

 			if (!filter_var($query, FILTER_VALIDATE_INT)) {
 				echo json_encode($data = array("status" =>false, "message" =>"Sala no existe"));
 			}
 			$conexion = new Conexion();


 			$obtReserva = new Reserva($conexion);

 			$response = $obtReserva->getInfoReservationByRoom($query);

 				$data = array();

 				$i = 1;

 				foreach ($response as $item){
 					$data[] = array(
				            "0"=>$i,
							"1"=>$item['sala_nombre'],
				            "2"=>$item['rese_fecha_hora_inicial'],
				            "3"=>$item['rese_fecha_hora_final'],
							"4"=>$item['rese_precio'],				          
				            "5"=>$item['acce_username'],				            
				            "6"=>'<button class="btn btn-primary btn-sm" onclick="fnConsulta('.$item['rese_id'].')"><i class="fa fa-edit"></i></button>'.
				             ' '.'<button class="btn btn-danger btn-sm" id="delete" onclick="deleteItem('.$item['rese_id'].')"><i class="fa fa-trash"></i> </button>',
				            );
 					$i++;
 				}

 				$results = array(
		             "sEcho"=>1,//info para datatables
		             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
		             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
		             "aaData"=>$data); 
				echo json_encode($results);
 				exit();

 		break;
 		
 		case "listRoom":

 			$conexion = new Conexion();

 			$obtReserva = new Reserva($conexion);

 			$response = $obtReserva->listRoom();

 			if ($response) {
 				echo json_encode($datos = array("status"=>true,
 											    "data"=>$response));
 				exit;
 			}else{
 				echo json_encode($datos = array("status"=>false));
 				exit;
 			}
 		break;

 		case "insert":
 			
			// Verificamos todos los parametros que nos envian
 			if (!$_POST){
 				echo json_encode($datos = array("status"=>false,
 												"message"=>"No se procesara el formulario"));
 				exit;
 			}

 			if (empty($_POST["sala"])) {
 				echo json_encode($datos = array("status"=>false,
 												"element"=>"rptaConsulta",
 												"message"=>"Seleccione una sala"));
 				exit();
 			}

 			if (empty($_POST["fecha_inicial"])) {
 				echo json_encode($datos = array("status"=>false,
 												"element"=>"rptaFechaInicial",
 												"message"=>"Ingrese la fecha y hora inical"));
 				exit();
 			}

 			if (empty($_POST["fecha_final"])) {
 				echo json_encode($datos = array("status"=>false,
 												"element"=>"rptaFechaFinal",
 												"message"=>"Ingrese la fecha y hora final"));
 				exit();
 			}

			 if (empty($_POST["precio"])) {
				echo json_encode($datos = array("status"=>false,
												"element"=>"rptaprecio",
												"message"=>"Ingrese el precio"));
				exit();
			}

			
 			$sala = $_POST["sala"];
 			$fecha_inicial = $_POST["fecha_inicial"];
 			$fecha_final = $_POST["fecha_final"];
			$precio = $_POST["precio"];

 			$obtClean = new Clean($sala);

 			$sala = $obtClean->cleanString($sala);

 			if (!filter_var($sala, FILTER_VALIDATE_INT)) {
 				echo json_encode($data = array('status' =>false,'element' =>'rptaConsulta','message' =>'Sala no existe'));
				 exit();
 			}

			if (!filter_var($precio, FILTER_VALIDATE_INT)) {
				echo json_encode($data = array('status' =>false,'element' =>'rptaprecio','message' =>'El precio no es valido'));
				exit();
			}

 			$fecha_inicial = str_replace("T"," ", $fecha_inicial.':00');

 			if($obtClean->checkDate($fecha_inicial)==false){
 				echo json_encode($fecha_inicial);
 				echo json_encode($datos = array("status"=>false,
 												"element"=>"rptaFechaInicial",
 												"message"=>"Ingrese una fecha y hora inical correcta"));
 				exit();
 			}

 			if($obtClean->checkDateOld2($fecha_inicial)==false){
 				echo json_encode($datos = array("status"=>false,
 												"element"=>"rptaFechaInicial",
 												"message"=>"La fecha y hora inical no puede se menor o igual a la fecha actual"));
 				exit();
 			}

 			$fecha_final = str_replace("T"," ", $fecha_final.':00');

 			if($obtClean->checkDate($fecha_final)==false){
 				echo json_encode($datos = array("status"=>false,
 												"element"=>"rptaFechaFinal",
 												"message"=>"Ingrese una fecha y hora final correcta"));
 				exit();
 			}


 			if($obtClean->checkDateOld2($fecha_final)==false){
 				echo json_encode($datos = array("status"=>false,
 												"element"=>"rptaFechaFinal",
 												"message"=>"La fecha y hora final no puede se menor o igual a la fecha actual"));
 				exit();
 			}

 			if($obtClean->checkDateOld($fecha_inicial,$fecha_final)==false){
 				echo json_encode($datos = array("status"=>false,
 												"element"=>"rptaFechaFinal",
 												"message"=>"La fecha final no puede ser menor o igual que a la fecha inical"));
 				exit();
 			}

 			$conexion = new Conexion();


 			$obtReserva = new Reserva($conexion);

 			$responseExists = $obtReserva->getExitReservation($sala,$fecha_inicial,$fecha_final);

 			if($responseExists){
 				echo json_encode($datos = array("status"=>false,
 												"element"=>"rptaConsulta",
 												"message"=>"Esta sala no se puede reservar para la fecha y hora seleccionadas, porque ya se encuentra reservada"));
 				exit();
 			}


 			$response=$obtReserva->setInsertReservation($sala,$fecha_inicial,$fecha_final,$precio,$_SESSION["PERSONA"]['acce_id'],date('Y-m-d H:i:s'));

 			if ($response) {
 				echo json_encode($datos = array("status"=>true,
 												"element"=>"",
 												"message"=>"La reserva fue guarda"));
 				exit();
 			}else{

 			}

 		break;

 		case "delete":

 			if (empty($_GET['query'])){
 				echo json_encode('search');
 				exit();
 			}

 			$query = $_GET['query'];

 			$obtClean = new Clean($query);

 			$query = $obtClean->cleanString();

 			if (!filter_var($query, FILTER_VALIDATE_INT)) {
 				echo json_encode($data = array('status' =>false, 'message' =>'La reserva no existe'));
 			}

 			$conexion =new Conexion();

 			$obtReserva = new Reserva($conexion);

 			$response = $obtReserva->setDeleteReservation($query);

 			if ($response){
				echo json_encode($datos = array("status"=>true,
 												"element"=>"",
 												"message"=>"La reserva fue eliminada"));
 				exit();
 			}else{
 				echo json_encode($datos = array("status"=>true,
 												"element"=>"",
 												"message"=>"La reserva no pudo ser eliminada"));
 				exit();
 			}

 		break;

 		case "select":

			if(empty($_GET["query"])){
				echo json_encode($data = array("status"=>false,"message"=>"Ingrese un valor para realizar la consulta"));
				exit();
		 	}

		 	$query=$_GET["query"];

 			$obtClean = new Clean($query);

 			$query = $obtClean->cleanString($query);

 			if (!filter_var($query, FILTER_VALIDATE_INT)) {
 				echo json_encode($data = array('status' =>false, 'message' =>'Sala no existe'));
 				exit();
 			}
	
 			$conexion =new Conexion();

 			$obtReserva = new Reserva($conexion);

 			$response = $obtReserva->getInfoReservation($query);

 			if ($response){
 					echo json_encode($data = array("status"=>true,
											 "message"=>"",
											 "datos"=>$response));
 					exit();
 			}else{
 				echo json_encode($data = array('status' =>false, 'message' =>'La reseva no existe'));
 				exit();
 			}

		break;

		case "update":

			if (empty($_POST['id'])){
				echo json_encode($data = array("status"=>false,
											 "message"=>"Opcion no valida"));
				exit();
			}

			if (empty($_POST['sala'])){
				echo json_encode($datos = array("status"=>false, 												
 												"message"=>"Opcion no valida"));
 				exit();
			}

			if (empty($_POST['fecha_inicialu'])){
				echo json_encode($datos = array("status"=>false,
 												"element"=>"rptaFechaInicialu",
 												"message"=>"Ingrese la fecha y hora inical"));
 				exit();
			}

			if (empty($_POST['fecha_finalu'])){
				echo json_encode($datos = array("status"=>false,
 												"element"=>"rptaFechaFinalu",
 												"message"=>"Ingrese la fecha y hora inical"));
 				exit();
			}


			$reserva = $_POST["id"];
			$sala = $_POST["sala"];
 			$fecha_inicial = $_POST["fecha_inicialu"];
 			$fecha_final = $_POST["fecha_finalu"];
			$precio = $_POST["precio"];

			
			

 			$obtClean = new Clean($reserva);

 			$reserva = $obtClean->cleanString($reserva);

 			if (!filter_var($reserva, FILTER_VALIDATE_INT)) {
 				echo json_encode($data = array('status' =>false,'element' =>'rptaConsulta','message' =>'La reserca no existe'));
				 exit();
 			}

			if (!filter_var($precio, FILTER_VALIDATE_INT)) {
				echo json_encode($data = array('status' =>false,'element' =>'rptaprecio','message' =>'El precio no es valido'));
				exit();
			}

 			$sala = $obtClean->cleanString($sala);

 			if (!filter_var($sala, FILTER_VALIDATE_INT)) {
 				echo json_encode($data = array('status' =>false,'element' =>'rptaConsulta','message' =>'La sala no existe'));
				 exit();
 			}

 			$fecha_inicial = str_replace("T"," ", $fecha_inicial.':00');

 			if($obtClean->checkDate($fecha_inicial)==false){
 				echo json_encode($fecha_inicial);
 				echo json_encode($datos = array("status"=>false,
 												"element"=>"rptaFechaInicialu",
 												"message"=>"Ingrese una fecha y hora inical correcta"));
 				exit();
 			}

 			if($obtClean->checkDateOld2($fecha_inicial)==false){
 				echo json_encode($datos = array("status"=>false,
 												"element"=>"rptaFechaInicialu",
 												"message"=>"La fecha y hora inical no puede se menor o igual a la fecha actual"));
 				exit();
 			}

 			$fecha_final = str_replace("T"," ", $fecha_final.':00');

 			if($obtClean->checkDate($fecha_final)==false){
 				echo json_encode($datos = array("status"=>false,
 												"element"=>"rptaFechaFinalu",
 												"message"=>"Ingrese una fecha y hora final correcta"));
 				exit();
 			}


 			if($obtClean->checkDateOld2($fecha_final)==false){
 				echo json_encode($datos = array("status"=>false,
 												"element"=>"rptaFechaFinalu",
 												"message"=>"La fecha y hora final no puede se menor o igual a la fecha actual"));
 				exit();
 			}

 			if($obtClean->checkDateOld($fecha_inicial,$fecha_final)==false){
 				echo json_encode($datos = array("status"=>false,
 												"element"=>"rptaFechaFinalu",
 												"message"=>"La fecha final no puede ser menor o igual que a la fecha inical"));
 				exit();
 			}

			$conexion=new Conexion();

			$obtReserva=new Reserva($conexion);

			$responseExists = $obtReserva->getExitReservation($sala,$fecha_inicial,$fecha_final);


			if($responseExists){
 				echo json_encode($datos = array("status"=>false,
 												"element"=>"rptaFechaFinal",
 												"message"=>"Esta sala no se puede reservar para la fecha y hora seleccionadas, porque ya se encuentra reservada"));
 				exit();
 			}

			$conexion->iniciar();

			$response=$obtReserva->setUpdateReservation($reserva,
													  $fecha_inicial,
													  $fecha_final,
													  $precio,
													  date('Y-m-d H:i:s'),
													  $_SESSION['PERSONA']['acce_id']);

			if ($response){
				echo json_encode($data=array("status"=>true,
											 "message"=>'Informacion actualizada'));
				$conexion->confirmar();		
				exit();
			}else{
				echo json_encode($data=array("status"=>false,
											 "message"=>"El registro no se pudo guardado"));
				$conexion->revertir();
				exit();
			}

			
		break;
 	}
 ?>