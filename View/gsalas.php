<?php 
    require_once '../Config/autentication.php';
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="../Resource/fontawesome/css/all.min.css">
    <title>Home</title>
</head>
<body>
    <?php  include 'menu.php'?>

    <div class="container mt-2">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header lead">
                        <div class="row">                        
                            <div class="col"> Gestión de clases</div>
                            <div class="col"><button type="button" class="btn btn-success float-right btn-sm" id="btnNuevoClase"> <i class="fa fa-plus"></i> Agregar</button></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <label for="nombreBusqueda" class="">Clase</label>
                                <input type="text" class="form-control" id="nombreBusqueda" placeholder="Ingresa las iniciales de la clase">
                                <small id="rptaConsuta">
                                   
                                </small> 
                            </div>
                                   
                            <div class="col mt-4">                                            
                                <button type="submit" class="btn btn-success" id="btnSearch"><i class="fa fa-search"></i> Buscar</button>
                            </div>                                    
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RESULTADOS DE LA BUSQUEDA -->
    <div class="container mt-1" style="display: none;" id="tabla">
        <div class="row">
            <div class="col">
                <!-- CARD -->
                <div class="card shadow">
                    <div class="card-header lead">Lista de resuldatos</div>
                        <div class="card-body">
                            <table class="table  text-center" id="tableListado">
                                 <thead class="bg-light">
                                    <th width="50">#</th>
                                    <th width="250">Clase</th>
                                    <th width="250">Profesor</th>
                                    <th width="100">Acciones</th>
                                </thead>
                                <tbody id="resultadosTabla"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PARA AREGAR UN NUEVO REGISTRO -->
<div class="modal fade" id="ModalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h4 class="modal-title lead" id="exampleModalLabel">Nueva Clase</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>           
       <div class="modal-body">
            <p id="rptaNuevaSala"></p>
                <form id="formSala">
                    <div class="form-group my-1">
                        <label for="nombre">Clase <span style="color:red">*</span></label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese nombre de la sala" required>                   
                    </div>
                    <div class="form-group my-1">
                        <label for="responsable">Profesor <span style="color:red">*</span></label>
                        <input type="text" class="form-control" id="responsable" name="responsable" placeholder="Ingrese el responsable de la sala" required>
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


  <!-- MODAL PARA ACTUALIZAR UN NUEVO REGISTRO -->
<div class="modal fade" id="modalFormUpdate" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h4 class="modal-title lead" id="exampleModalLabel2">Actualializar Clase</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>           
       <div class="modal-body">
            <p id="rptaActualizarSala" style="display:none;"></p>
                <form id="formSalaUpdate">
                    <div class="form-group">
                        <label for="nombre">Clase <span style="color:red">*</span></label>
                        <input type="text" class="form-control" id="nombreu" name="nombreu" placeholder="" required>                        
                    </div>
                    <div class="form-group my-1">
                        <label for="responsableu">Profesor <span style="color:red">*</span></label>
                        <input type="text" class="form-control" id="responsableu" name="responsableu">
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
    <script src="script/salas.js"></script>

   
</body>
</html>