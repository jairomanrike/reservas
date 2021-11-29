<?php 
	
	require_once '../Config/modeConfiguration.php';

	$rol = $_SESSION['PERSONA']['rol_id'];

	if(empty($rol)){
		echo json_encode('error');exit();
	}

	require_once '../Config/conection.php';

	$conexion =new Conexion();


	require_once '../Model/menuModel.php';

	$obtMenu = new Menu($conexion,$rol);

	$response = $obtMenu->getMenuAccess();

	if($response){
		echo json_encode($datos = array("status"=>true,"datos"=>$response));exit();		
	}else{
		echo json_encode('error');exit();
	}

 ?>