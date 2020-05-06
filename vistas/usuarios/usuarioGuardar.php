<!doctype html>
<html>
<head>
<title>Actualiza Usuario</title>  
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">          
<link rel="stylesheet" href="../css/styles.css">
</head>    
<?php
session_start();
$rutusu = $_SESSION['rutusu'];

if(!isset($_SESSION['rutusu'])) { 
    $rutusu = $_SESSION['rutusu'];
    if( strcmp($rutusu,"") == 0) {
        echo "sesion expirada";
        //echo "<br>reconectar <a href='https://www.slcltda.cl/cobranza/vistas/index.php'>aqui</a>";
        exit();        
    }
}

require_once("../Connection.php");
require_once("../funcionesADO.php");

$database = new Connection();
$db = $database->openConnection();

if( isset( $_POST['hd_id'])) {  $id = $_POST['hd_id']; } else  { echo "session expirada";exit();}
if( isset( $_POST['rut'])) {    $rut = $_POST['rut']; } else  { $rut = "0";}
if( isset( $_POST['nombre'])) {   $nombre = $_POST['nombre']; } else  { $nombre = "";}
//if( isset( $_POST['cbEstadoUsr'])) {   $cbEstadoUsr = $_POST['cbEstadoUsr']; } else  { $cbEstadoUsr = "0";}
if( isset( $_POST['correo'])) {   $correo = $_POST['correo']; } else  { $correo = "0";}
//if( isset( $_POST['cbCargo'])) {   $cbCargo = $_POST['cbCargo']; } else  { $cbCargo = "0";}
//if( isset( $_POST['cbSucural'])) {   $cbSucural = $_POST['cbSucural']; } else  { $cbSucural = "0";}
if( isset( $_POST['telefono']) and strlen($_POST['telefono'])> 0 ) {   $telefono = $_POST['telefono']; } else  { $telefono = "0";}

$arr_rut = explode("-",$rut);
$rut_ = $arr_rut[0];
$dgv_ = $arr_rut[1];

$cbEstadoUsr = $_POST['cbEstadoUsr'];
$cbCargo = $_POST['cbCargo'];
$cbSucursal = $_POST['cbSucursal']; 
$telefono = $_POST['telefono'];



try {
$data = [
    'rut' => $rut_,
    'dgv' => $dgv_,
    'nombre' => $nombre,
    'cbEstadoUsr' => $cbEstadoUsr,
    'correo' => $correo,
    'cbCargo' => $cbCargo,
    'cbSucursal' => $cbSucursal,
    'telefono' => $telefono,
    'id' => $id,
];
$sql = "update tl_usuarios set rut=:rut,dgv=:dgv, nombre=:nombre, id_estado_usuario=:cbEstadoUsr, correo=:correo,ID_CRG=:cbCargo, ID_SCRSL=:cbSucursal, telefono=:telefono, fechaSistema=now()  where id=:id";
$stmt= $db->prepare($sql);
$stmt->execute($data);
$status = true;
} catch( Exception $e ){
    echo $e;
    $status = false;
}
?>
<body>
<?php  if( $status ) {  ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12 my-20">
            <div class="alert alert-success">
                <strong>Success!</strong> Datos Actualizados en forma Correcta
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <form action="mantenedor.php" method="POST">
                <p align="center"><input type="submit" value="Continuar"></p>
            </form>
        </div>
    </div>
</div>

<?php }  
?>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>                  
</body>
</html>
