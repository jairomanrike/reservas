<?php 
    require_once '../Config/autentication.php';
 ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="../Resource/fontawesome/css/all.min.css">
	<title>Reservas</title>
</head>
<body>

	<?php include 'menu.php' ?>

	<div class="container">
		<div class="row">
			<div class="col my-2">
				<div id="rptaListaSala" class=""></div>
				<div class="card shadow">
					<div class="card-header">
						Nueva Clase
					</div>
					<div class="card-body">
						<form id="formReserva">
							<div class="row">
								<div class="col-5">
									<label for="sala" class="">Clase:</label>
									<select name="sala" id="sala" class="form-control">
										<option value="">Selecccionar...</option>										
									</select>
									<small id="rptaConsulta"></small>
								</div>
								<div class="col-2 mt-4">
									<button class="btn btn-success" id="btnConsultar"><i class="fa fa-search"></i> Buscar</button>
								</div>
								<div class="col text-center my-2" id="rstaResponsable">
									
								</div>
							</div>
							<div class="row">
								<div class="col">
									<label for="fecha_inicial" class="">Fecha y hora inicial:</label>
									<input type="datetime-local" class="form-control" name="fecha_inicial">
									<small id="rptaFechaInicial"></small>
								</div>
								<div class="col">
									<label for="fecha_final" class="">Fecha y hora final:</label>
									<input type="datetime-local" class="form-control" name="fecha_final">
									<small id="rptaFechaFinal"></small>
								</div>
								<div class="col">
									<label for="precio" class="">Precio:</label>
									<input type="numeric" class="form-control" name="precio">
									<small id="rptaprecio"></small>
								</div>	
							</div>
							<div class="row">
								<div class="col my-2">
									<button class="btn btn-success float-right" type="submit"><i class="fa fa-check"></i> Reservar</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col">
				<div class="card shadow"  id="card">
					<div class="card-header lead">
						Listado de reservas
					</div>
					<div class="card-body">
						<table class="table text-center" id="tableReservas">
							<thead class="bg-light">
								<th>#</th>
								<th>Clase</th>
								<th>Fecha y hora inicial</th>
								<th>Fecha y hora final</th>
								<th>Precio</th>
								<th>Solicitante</th>
								<th>Acciones</th>
							</thead>
							<tbody></tbody>
						</table>
					</div>	
				</div>
			</div>
		</div>
	</div>


	<!-- VENTANA MODAL PARA ACTUALIZAR LA RESERVA -->
	<div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	    	<form id="formUpdate">
			      <div class="modal-header  bg-light">
			        <h5 class="modal-title lead" id="exampleModalLabel">Actualializar reserva</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			      	<div class="row">
			      		<div class="col">
			      			<label for="">Clase:</label>
                        	<p class="text-primary" id="salau"></p>
			      		</div>
			      		<div class="col">
			      			<label for="">Profesor:</label>
                        	<p  class="text-primary" id="responsableu"></p>
			      		</div>
			      	</div>

			      	<div class="row">
			      		<div class="col">
			      			<label for="">Fecha y hora inicial:</label>
                        	<p class="text-danger" id="fechainicialu">></p>
			      		</div>
			      		<div class="col">
			      			<label for="">Fecha y hora final:</label>
                        	<p  class="text-danger" id="fechafinalu"></p>
			      		</div>
						  <div class="col">
			      			<label for="">Precio:</label>
                        	<p  class="text-danger" id="preciou"></p>
			      		</div>
			      	</div>
			        	
                    	<div class="row">
								<div class="col">
									<label for="sala" class="">Nueva fecha y hora inicial <span style="color:red">*</span></label>
									<input type="datetime-local" class="form-control" name="fecha_inicialu" id="fecha_inicialu" required>
									<small id="rptaFechaInicialu"></small>
								</div>
								<div class="col">
									<label for="sala" class="">Nueva fecha y hora final <span style="color:red">*</span></label>
									<input type="datetime-local" class="form-control" name="fecha_finalu" id="fecha_finalu" required>
									<small id="rptaFechaFinalu"></small>
								</div>									
							</div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
			        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Guardar</button>
			      </div>	      
	  		</form>
	    </div>
	  </div>
	</div>
	<!-- 	FIN MODAL  -->

	 <!-- Optional JavaScript; choose one of the two! -->
	 <script src="https://code.jquery.com/jquery-3.5.1.min.js" ></script>
    <!-- Option 1: Bootstrap Bundle with Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Option 2: Separate Popper.js and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.min.js" ></script>
    <!--  -->
    <script src="../Resource/jquery.dataTables.min.js"></script>
    <script src="../Resource/fontawesome/js/all.min.js"></script>

    <script src="../Resource/sweetalert2.js"></script>

	   <!-- Script -->
	<script src="script/menu.js"></script>
    <script src="script/reservas.js"></script>
</body>
</html>