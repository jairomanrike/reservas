<?php 
    require_once '../Config/autentication.php';
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-CuOF+2SnTUfTwSZjCXf01h7uYhfOBuxIhGKPbfEJ3+FqH/s6cIFN9bGr1HmAg4fQ" crossorigin="anonymous">
    <link rel="stylesheet" href="../Resource/fontawesome/css/all.min.css">
    <title>Reservas SkateColina</title>
    <link rel="shortcut icon" href="../Resource/image/favicon.png"/><!--agregamos un icon-->
</head>
<body>
    
    <?php include 'menu.php' ?>



    <div class="container" style="margin-top:50px">
        <div class="row text-center">
            <div class="col">
            <h1>Bienvenido al sistema</h1>
            <h4 class="text-muted"> <?php echo $_SESSION['PERSONA']['pers_nombre'].' '.$_SESSION['PERSONA']['pers_apellido']; ?></h4>
            <span class="badge badge-pill badge-success">
               
            </span>                
            </div>
        </div>
    </div>
    

    <!-- Optional JavaScript; choose one of the two! -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="script/menu.js"></script>
    <!-- Option 1: Bootstrap Bundle with Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Option 2: Separate Popper.js and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.min.js"></script>
    <!--  -->
</body>
</html>