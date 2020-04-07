<!doctype html>
<html>
<head>
<title></title>    
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">      
<link rel="stylesheet" href="css/styles.css">  
</head>
<?php
session_start();
require_once("Connection.php");
require_once("funcionesADO.php");

$rutusu     = $_SESSION['rutusu'];
$id_deudor  = $_POST['id_deudor'];
$id_cedente = $_POST['id_cedente'];
$id_campana = $_POST['id_campana'];
$id_remesa  = $_POST['id_remesa'];

echo "<br>rutusu:" . $rutusu;
echo "<br>id_deudor:" . $id_deudor;
echo "<br>id_cedente:" . $id_cedente;
echo "<br>id_campana:" . $id_campana;
echo "<br>id_remesa:" . $id_remesa;


$cbTipoGestion = $_POST['cbTipoGestion'];
$cbOrigenLlamada = $_POST['cbOrigenLlamada'];
$cbRsultadoGestion = $_POST['cbRsultadoGestion'];
$cbFonosContacto = $_POST['cbFonosContacto'];
$cbDireccionDeContacto = $_POST['cbDireccionDeContacto'];
$cbEmailDeContacto = $_POST['cbEmailDeContacto'];

/*
$nombreEjecutivo =  getNombreUsuario( $rutusu  );
$nombreCedente = getNombreCedente($id_cedente );

$id_remesa = getIdRemesa( $id_campana );
$nombreRemesa = getNombreRemesa( $id_remesa );
$nombreCampana = getNombreCampana( $id_campana  );

$id_producto = getIdProducto( $id_remesa );
*/

echo "<br>TipoGestion:".$cbTipoGestion;
echo "<br>OrigenLlamada:".$cbOrigenLlamada;
echo "<br>ResultadoGestion:".$cbRsultadoGestion;
echo "<br>FonosContacto:".$cbFonosContacto;
echo "<br>Direccion:".$cbDireccionDeContacto;
echo "<br>EmailContacto:".$cbEmailDeContacto;



?>
<body>
 <?php include "header.php"; ?>
    
    <div class="container">
        <div class="row center">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4 my-3">
                    <h5>GESTION INFO</h5>                
            </div>
            <div class="col-sm-4">
                <form name="frmSalir" id="frmSalir" action="controlador.php" method="POST"><input type="submit" name="btnSalir" value="Salir"><input type="hidden" name="accion" value="salir"></form>
            </div>            
        </div>
    </div>    
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div align='center'>Gestion Guardada</div>
        </div>
    </div>
</div>    
	<br><br>
	<?php include "footer.php"; ?>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>        	
</body>
</html>