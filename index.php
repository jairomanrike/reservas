<?php require('Config/modeConfiguration.php');

	if (isset($_SESSION['AUTENTICADO'])=='OK'){
		header('Location:view/');
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="Resource/bootstrap-4.5.3-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="Resource/fontawesome/css/all.min.css">
	<title>Reservas SkateColina</title>
	<link rel="shortcut icon" href="../Resource/image/favicon.png"/><!--agregamos un icon-->
</head>
<body class="bg-light" style="background-image: none;">
		
	<div class="container">
		<div class="row justify-content-center align-items-center vh-100">
			<div class="col-md-6">
				<div id="respuesta">
				</div>
				<div class="card shadow">
					<div class="card-header">
						<h4 class="lead text-center">INGRESAR AL SISTEMA DE RESERVAS</h4>
					</div>
					<div class="card-body">
						<form class="needs-validation" novalidate id="credenciales">
						  <div class="form-group">
						    <label for="user">Usuario</label>
						    	<input type="text" class="form-control" id="user" required>					   
						    <div class="invalid-feedback">Campo requerido</div>
						  </div>
						  <div class="form-group">
						    <label for="password">Contraseña</label>
						    	<input type="password" class="form-control" id="password" required >
						    <div class="invalid-feedback">Campo requerido</div>
						  </div>
						  <div class="text-center">						  	
						 	 <button type="submit" class="btn btn-success" id="btnEnviar"><i class="fa fa-share"></i> ENTRAR</button>
						  </div>						 
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="Resource/jquery-3.5.1.min.js"></script>
	<script src="Resource/bootstrap-4.5.3-dist/js/bootstrap.min.js"></script>
	<script src="script/index.js"></script>
</body>
</html>

