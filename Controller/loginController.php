<?php 
	
	require_once '../Config/modeConfiguration.php';
	header('Content-type: application/json; charset=utf-8');

	if (!isset($_POST['user']) OR !isset($_POST['password'])){
		echo "K0";
		exit();
	}else{
		if (empty($_POST['user']) OR empty($_POST['password'])) {
			echo "K0";
			exit();
		}
	}

	$username = $_POST['user'];
	$password = $_POST['password'];

	if (strlen($username)>20) {
		echo json_encode($datos=array('status'=>false,'message'=>'<strong>Lo sentimos,</strong> el usuario no debe exceder más de 20 caracteres.'));
		exit();
	}

	if (strlen($password)>30) {
		echo json_encode($datos=array('status'=>false,'message'=>'<strong>Lo sentimos,</strong> la contraseña no debe exceder más de 30 caracteres.'));
		exit();
	}

	require_once '../Config/clean.php';

	$obtClean = new Clean($username);

	$username = $obtClean->cleanString();

	$obtClean = new Clean($password);

	$password = $obtClean->cleanString();


	require_once '../Config/conection.php';
	$conection = new Conexion();

	require_once '../Model/autenLogin.php';
	$obtlogin=new Login($conection);

	$result = $obtlogin->loginUser($username,$password);

	if ($result) {
	
		$_SESSION['AUTENTICADO']=true;
		$_SESSION['PERSONA']=$result;
		echo json_encode($datos=array('status'=>true,'url'=>'view/'));
	}else{
		echo json_encode($datos=array('status'=>false,'message'=>'<strong>Lo sentimos,</strong> El usuario o la contraseña no coinciden, por favor verifique nuevamente...'));
	}

?>