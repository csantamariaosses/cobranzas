<!doctype html>
<html>
<head>
<title>Modifica Usuarios
</title>   
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

$id = $_POST['hd_id'];

require_once("../Connection.php");
require_once("../funcionesADO.php");

$database = new Connection();
$db = $database->openConnection();

$sql = " select id, rut, dgv, nombre , id_estado_usuario, correo, id_crg, ID_SCRSL, telefono, fechaSistema ";
$sql .= " from tl_usuarios ";
$sql .= " where id=".$id;

$result = $db->query($sql);
if( $result ) {
     foreach ($result as $row) {
        // echo "<br>".$row['rut'];
         $rut = $row['rut'];
         $dgv = $row['dgv'];
         $nombre = $row['nombre'];
         $id_estado_usuario = $row['id_estado_usuario'];
         $correo = $row['correo'];
         $id_crg = $row['id_crg'];
         $id_scrsl = $row['ID_SCRSL'];
         $telefono = $row['telefono'];
         $fechaSistema = $row['fechaSistema'];
         $rut = $rut."-".$dgv;
     }
}     
         
         

function cbEstadoUsuario($db, $id_estado_usuario){
    $sql = " select ID_ESTADO, DESCESTADO";
    $sql .= " from testado ";
    //echo $sql;
    $result = $db->query($sql);
    echo "<option value='0'>Seleccione</option>";
    
    if( $result ) {
         foreach ($result as $row) {
             if( strcmp($row['ID_ESTADO'],$id_estado_usuario) == 0 ) {
                echo "<option value='".$row['ID_ESTADO']."' selected>".$row['ID_ESTADO']."-".$row['DESCESTADO']."</option>";
             } else  {
                echo "<option value='".$row['ID_ESTADO']."' >".$row['ID_ESTADO']."-".$row['DESCESTADO']."</option>"; 
             }
         }
    }
}


function cbCargoUsuario($db, $id_crg){
    $sql = " select ID_CRG, DSCR_CRG ";
    $sql .= " from t_cargos ";
    //echo $sql;
    $result = $db->query($sql);
    echo "<option value='0'>Seleccione</option>";
    
    if( $result ) {
         foreach ($result as $row) {
             if( strcmp($row['ID_CRG'],$id_crg) == 0 ) {
                echo "<option value='".$row['ID_CRG']."' selected>".$row['ID_CRG']."-".$row['DSCR_CRG']."</option>";
             } else  {
                echo "<option value='".$row['ID_CRG']."' >".$row['ID_CRG']."-".$row['DSCR_CRG']."</option>"; 
             }
         }
    }
    
}


function cbSucursalUsuario($db, $id_scrsl){
    $sql = " select 	ID_SCRSL, DES_SCRSL ";
    $sql .= " from t_sucursales ";
    //echo $sql;
    $result = $db->query($sql);
    echo "<option value='0'>Seleccione</option>";
    
    if( $result ) {
         foreach ($result as $row) {
             if( strcmp($row['ID_SCRSL'],$id_scrsl) == 0 ) {
                echo "<option value='".$row['ID_SCRSL']."' selected>".$row['ID_SCRSL']."-".$row['DES_SCRSL']."</option>";
             } else  {
                echo "<option value='".$row['ID_SCRSL']."' >".$row['ID_SCRSL']."-".$row['DES_SCRSL']."</option>"; 
             }
         }
    }
    
    
}





?>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <p class="text-center"><h4>Modifica Usuario.</h4></p>
            </div>
        </div>
    </div>
    
<div class="container">
    <div class="row">
         <div class="col-sm-12">
            <form name="frmUsuario" id="frmUsuario" action="usuarioGuardar.php" method="POST">
                <input type="hidden" name="hd_id" id="hd_id" value="<?php echo $id?>">
            <table>
                <tr><td>Id</td><td><input type= "text" name="id" id="id" value="<?php echo $id?>" disabled></td></tr>
                <tr><td>Rut</td><td><input type= "text" name="rut" id="rut" value="<?php echo $rut?>"></td></tr>
                <tr><td>Nombre</td><td><input type= "text" name="nombre" id="nombre" value="<?php echo $nombre?>"></td></tr>
                <tr><td>Id-estado</td><td><select name="cbEstadoUsr" id="cbEstadoUsr"><?php cbEstadoUsuario($db,$id_estado_usuario);?></select></td></tr>
                <tr><td>Correo</td><td><input type= "text" name="correo" id="correo" value="<?php echo $correo?>"></td></tr>
                <tr><td>Cargo</td><td><select name="cbCargo" id="cbCargo"><?php cbCargoUsuario($db,$id_crg);?></select></td></tr>
                <tr><td>Sucursal</td><td><select name="cbSucursal" id="cbSucursal"><?php cbSucursalUsuario($db,$id_scrsl);?></select></td></tr>
                <tr><td>Telefono</td><td><input type= "text" name="telefono" id="telefono" value="<?php echo $telefono?>"></td></tr>
                <tr><td>Fecha Sistema</td><td><input type= "text" name="fechaSistema" id="fechaSistema" value="<?php echo $fechaSistema?>" disabled></td></tr>
                <tr><td></td><td><input type= "button" name="btnVolver" id="btnVolver" value="Volver"><input type= "submit" name="btnGuardar" id="btnGuardar" value="Guardar"></td></tr>
            </table>
            </form>
       </div>
    </div>
</div> 
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>                  
<script>
$("#btnVolver").click( function (){
    document.location = "mantenedor.php";
});   
</script>
</body>
</html>