<!doctype html>
<html>
<head>
    <title></title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">      
<link rel="stylesheet" href="css/styles.css">      
</head>    
<?php
session_start();
if(!isset($_SESSION['rutusu'])) { 
    $rutusu = $_SESSION['rutusu'];
    if( strcmp($rutusu,"") == 0) {
        echo "sesion expirada";
        echo "<br>reconectar <a href='https://www.slcltda.cl/cobranza/vistas/index.php'>aqui</a>";
        exit();        
    }

}

require_once("Connection.php");
require_once("funcionesADO.php");

 

$rutusu = $_SESSION['rutusu'];
$rutusu = $_POST['rutusu'];
$id_deudor = $_POST['id_deudor'];
$id_rut_deudor = $_POST['id_rut_deudor'];
$id_deudor = $_POST['id_deudor'];
$id_cedente = $_POST['id_cedente'];
$id_campana = $_POST['id_campana'];
$id_remesa = $_POST['id_remesa'];

//echo "<br>rutusu:" . $rutusu;
//echo "<br>id_deudor:" . $id_deudor;
//echo "<br>id_rut_deudor:" . $id_rut_deudor;



//echo "<br>id_deudor:" . $id_deudor;
//echo "<br>id_cedente:" . $id_cedente;
//echo "<br>id_campana:" . $id_campana;
//echo "<br>id_remesa:" . $id_remesa;

$nombreEjecutivo = getNombreEjecutivo( $rutusu );
$nombreDeudor    = getNombreDeudor( $id_rut_deudor);
$nombreCampana   = getNombreCampana( $id_campana  );
                   


function fnCbTipoGestion() {
    $arrTipoGestion = getTipoGestion();
    echo "<option value='0'>Seleccione...</option>";
    foreach($arrTipoGestion as $row ) {
        echo "<option value='" .$row['id_gestion']."'>". $row['nombre_gestion']."</option>";
    }
}



function fnCbOrigenLlamada() {
    $arrTipoGestion = origenLlamada();
    echo "<option value='0'>Seleccione...</option>";
    foreach($arrTipoGestion as $row ) {
        echo "<option value='" .$row['id_origen_llamada']."'>". $row['nombre_origen_llamada']."</option>";
    }
}


function fnCbResultadoDeLaGestion() {
  $arr = getResultadoDeLaGestion();
  echo "<option value='0'>Seleccione...</option>";
  foreach( $arr as $row ) {
     echo "<option value='" .$row['id_codigo_gestion']."'>".$row['nombre_codigo']."</option>";
  }    
}


function fnCbFonosContacto( $id_rut_deudor ) {
    $arr = listTelefonosDeudor($id_rut_deudor);
    echo "<option value='0'>Seleccione...</option>";
    foreach( $arr as $row ) {
       echo "<option value='" .$row['id_telefono']."'>".$row['area']. "-".$row['telefono']."-".$row['NOMBRE_ESTADO_TELEFONO']."</option>";
    }    
}



function fnCbDireccionDeContacto( $id_deudor ) {
    $arr  = getListadoDireccion( $id_deudor );

    echo "<option value='0'>Seleccione...</option>";
    foreach( $arr as $row ) {
       echo "<option value='" .$row['id_direccion']."'>".$row['direccion']."</option>";
    }    
}


function fnCbEmailDeContacto( $id_rut_deudor ) {
    $arr  = getEmailContacto( $id_rut_deudor );

    echo "<option value='0'>Seleccione...</option>";
    foreach( $arr as $row ) {
       echo "<option value='".$row['id_mail']."'>".$row['email']."</option>";
    }        
}



?>
<body>
    <?php include "header.php"; ?>
 
   <div class="container">
        <div class="row center">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4 my-3">
                    <h5>INGRESA GESTION</h5>                
            </div>
            <div class="col-sm-4">
                <form name="frmSalir" id="frmSalir" action="controlador.php" method="POST"><input type="submit" name="btnSalir" value="Salir"><input type="hidden" name="accion" value="salir"></form>
            </div>            
        </div>
    </div>    
    
    
    <div class="container">
        <div class="row center">
            <div class="col-sm-1">
            </div>
            <div class="col-sm-10">
                    <b>Ejecutivo:</b><?php echo $rutusu. " - " .$nombreEjecutivo?><br>
                    <b>Deudor:</b><?php echo $id_rut_deudor ." - ". $nombreDeudor;?><br>
                    <b>Campana:</b><?php echo $id_campana ." - ". $nombreCampana;?>
            </div>
            <div class="col-sm-1">
            
            </div>            
        </div>
    </div>
   
    <hr>
        <form name="frm" id="frm" action="guardaGestion.php" method="POST">
            <input type="hidden" name="id_deudor" id="id_deudor" value="<?php echo $id_deudor?>">
            <input type="hidden" name="id_rut_deudor" id="id_rut_deudor" value="<?php echo $id_rut_deudor?>">
            
            <input type="hidden" name="id_cedente" id="id_cedente" value="<?php echo $id_cedente?>">
            <input type="hidden" name="id_campana" id="id_campana" value="<?php echo $id_campana?>">
            <input type="hidden" name="id_remesa"  id="id_remesa" value="<?php echo $id_remesa?>">
            
        <div class="containe">
            <div class="row">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-6">
                    <table class="tabla-gestiones">
                        <tr><td>Tipo Gestion:</td><td><select name="cbTipoGestion"  id="cbTipoGestion"><?php fnCbTipoGestion();?></select></td></tr>
                        <tr><td>Origen de Llamada:</td><td><select name="cbOrigenLlamada" id="cbOrigenLlamada"><?php fnCbOrigenLLamada();?></select></td></tr>
                        <tr><td>Resultado de la Gestion:</td><td><select name="cbRsultadoGestion" id="cbRsultadoGestion"><?php fnCbResultadoDeLaGestion();?></select></td></tr>
                        <tr><td>Fono de Contacto:</td><td><select name="cbFonosContacto" id="cbFonosContacto"><?php fnCbFonosContacto( $id_rut_deudor );?></select></td></tr>
                        <tr><td>Direccion de Contacto:</td><td><select name="cbDireccionDeContacto" id="cbDireccionDeContacto"><?php fnCbDireccionDeContacto( $id_deudor );?></select></td></tr>
                        <tr><td>Email de Contacto:</td><td><select name="cbEmailDeContacto" id="cbEmailDeContacto"><?php fnCbEmailDeContacto( $id_rut_deudor );?></select></td></tr>
            
                    </table>
                </div>
                <div class="col-sm-3">
                </div>                
            </div>
            <div class="row">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-6">
                    <input type="button" name="btnSubmit" value="Siguiente" onClick="validar();">             
                </div>
                <div class="col-sm-3">
                </div>
            </div>
        </div>    
       
        </form>

    <br><br>
	<?php include "footer.php"; ?>    
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>              
<script>
function validar(){
    var tipoGestion = document.getElementById("cbTipoGestion").value;
    var cbOrigenLlamada = document.getElementById("cbOrigenLlamada").value;
    var cbRsultadoGestion = document.getElementById("cbRsultadoGestion").value;
    var cbFonosContacto = document.getElementById("cbFonosContacto").value;
    var cbDireccionDeContacto = document.getElementById("cbDireccionDeContacto").value;
    var cbEmailDeContacto = document.getElementById("cbEmailDeContacto").value;
    
    if( tipoGestion == "0" ) {
        alert("Debe seleccionar el Tipo de Gestion");
        return false;
    }
    if( cbOrigenLlamada == "0" ) {
        alert("Debe seleccionar el Origen de la Llamada");
        return false;
    }
    if( cbRsultadoGestion == "0" ) {
        alert("Debe seleccionar el Resultado de la gestion");
        return false;
    } 
    //alert("ok...");
    document.frm.submit();
   
}    
</script>    
</body>
</html>