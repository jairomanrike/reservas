<?php 
	require_once 'modeConfiguration.php'; // Requerimos el archivo de configuracion

	if (!isset($_SESSION['AUTENTICADO'])) { // verificamos si ya esta autenticado
		header('Location:../');	
	}	
?>