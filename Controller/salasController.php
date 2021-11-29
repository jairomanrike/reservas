<?php 
	require_once '../Config/modeConfiguration.php';
	header('Content-type: application/json; charset=utf-8');

	if (!$_GET){
		echo json_encode($data=array("status"=>false,"message"=>""));
		exit();
	}
	
	
	switch($_GET["option"]){

		case "search":

			if(empty($_POST["query"])){
			echo json_encode($data=array("status"=>false,"message"=>"Ingrese un valor para realizar la consulta"));
			exit();
		 	}

		 	$query=$_POST["query"];

			require_once('../Config/conection.php');
			$conexion = new Conexion();

			 require_once '../Model/gsalaModel.php';
			 $obtSala=new Sala($conexion);

			 $response = $obtSala->getListSearchRoom($query);

			if($response){
				echo json_encode($data=array("status"=>true,
											 "message"=>"",
											 "datos"=>$response));
			}else{
				echo json_encode(array('status'=>false,
										'message'=>'No se encontrar registros'));
			}

		break;

		case "insert":


			$nombre = $_POST['nombre'];
			$responsable = $_POST['responsable'];

			if (strlen($nombre)>100){
				echo json_encode($data=array("status"=>false,"message"=>"El nombre de la sala no debe superar mas de 100 caracteres"));
				exit();
			}

			if (strlen($responsable)>100){
				echo json_encode($data=array("status"=>false,"message"=>"El nombre del responsable no debe superar mas de 200 caracteres"));
				exit();
			}

			// $p=" SELECT * FROM users PAPA";

			require_once '../Config/clean.php';

			$obtClean=new Clean($nombre);

			$nombre=$obtClean->cleanString();

			$obtClean=new Clean($responsable);

			$responsable=$obtClean->cleanString();

			require_once '../Config/conection.php';

			$conexion=new Conexion();

			require_once '../Model/gsalaModel.php';

			$obtSala=new Sala($conexion);

			$Existe=$obtSala->getExitRoom(strtoupper($nombre));

			if($Existe){
				echo json_encode($data=array("status"=>false,"message"=>'Lo sentimos, la "'.$nombre.'" ya exite'));
				exit();
			}

			$conexion->iniciar();

			$response=$obtSala->setInsertRoom($nombre,
											  $responsable,
											  date('Y-m-d H:i:s'),
											  $_SESSION['PERSONA']['acce_id']);

			if ($response){
				echo json_encode($data=array("status"=>true,
											 "message"=>'Nueva "'.$nombre.'" creada'));
				$conexion->confirmar();		
				exit();
			}else{
				echo json_encode($data=array("status"=>false,
											 "message"=>"El registro no se pudo guardado"));
				$conexion->revertir();
				exit();
			}

		break;

		case "select":

			if(empty($_GET["query"])){
				echo json_encode($data=array("status"=>false,"message"=>"Ingrese un valor para realizar la consulta"));
				exit();
		 	}

		 	$query=$_GET["query"];

		 	require_once "../Config/clean.php";

 			$obtClean = new Clean($query);

 			$query = $obtClean->cleanString($query);

 			if (!filter_var($query, FILTER_VALIDATE_INT)) {
 				echo json_encode($data = array('status' =>false, 'message' =>'Sala no existe'));
 				exit();
 			}
	
			require_once '../Config/conection.php';

 			$conexion =new Conexion();

 			require_once '../Model/gsalaModel.php';

 			$obtSala = new Sala($conexion);

 			$response = $obtSala->getInfoRoom($query);

 			if ($response){
 					echo json_encode($data=array("status"=>true,
											 "message"=>"",
											 "datos"=>$response));
 					exit();
 			}else{
 				echo json_encode($data = array('status' =>false, 'message' =>'Sala no existe'));
 				exit();
 			}

		break;

		case "update":

			if (empty($_POST['id'])){
				echo json_encode($data=array("status"=>false,"message"=>"Opcion no valida"));
				exit();
			}

			if (empty($_POST['nombreu'])){
				echo json_encode($data=array("status"=>false,"message"=>"Todos los campos del formulario son obligatorios"));
				exit();
			}

			if (empty($_POST['responsableu'])){
				echo json_encode($data=array("status"=>false,"message"=>"Todos los campos del formulario son obligatorios"));
				exit();
			}

			$id = $_POST['id'];
			$nombre = $_POST['nombreu'];
			$profesor = $_POST['responsableu'];

			if (strlen($nombre)>100){
				echo json_encode($data=array("status"=>false,"message"=>"El nombre de la sala no debe superar mas de 100 caracteres"));
				exit();
			}


			require_once '../Config/clean.php';

			$obtClean=new Clean($nombre);

			$nombre=$obtClean->cleanString();
			
			require_once '../Config/conection.php';

			$conexion=new Conexion();

			require_once '../Model/gsalaModel.php';

			$obtSala=new Sala($conexion);

			$Existe=$obtSala->getExitRoom(strtoupper($nombre));

			if($Existe){
				echo json_encode($data=array("status"=>false,"message"=>'Lo sentimos, la "'.$nombre.'" ya exite'));
				exit();
			}

			$conexion->iniciar();

			$response=$obtSala->setUpdateRoom($id,
											  $nombre,
											  $profesor,
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