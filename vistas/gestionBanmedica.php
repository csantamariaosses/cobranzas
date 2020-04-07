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
//echo "<br>rut:".$rutusu;

$id_deudor = $_POST['id_deudor'];
$id_cedente = $_POST['id_cedente'];
$id_campana = $_POST['id_campana'];
$id_remesa = $_POST['id_remesa'];

/*
echo "<br>id_deudor:" . $id_deudor;
echo "<br>id_cedente:" . $id_cedente;
echo "<br>id_campana:" . $id_campana;
echo "<br>id_remesa:" . $id_remesa;
*/
$nombreEjecutivo = getNombreEjecutivo( $rutusu );
//echo "<br>nombreUser:" . $nombreEjecutivo;

$datosClie = p_datos_clie ( $id_deudor);
if( !empty( $datosClie )) {
    foreach ($datosClie as $row) {
        $fecha_asig_ejecutivo = $row['fecha_asig_ejecutivo'];
        $fecha_llegada        = $row['fecha_llegada'];
        $desc_remesa          = $row['desc_remesa'];
        $id_rut_deudor        = $row['id_rut_deudor'];
        $nombreDeudor         = $row['nombreDeudor'];
        //echo "<br>fechaAsignacion:".$fecha_asig_ejecutivo;
        // echo "<br>fechaLLegada:".$fecha_llegada;
         // echo "<br>nombreDeudor:".$nombreDeudor;
    }
    $fecha_asig_ejecutivo = substr($fecha_asig_ejecutivo,8,2) ."/".substr($fecha_asig_ejecutivo,5,2)."/".substr($fecha_asig_ejecutivo,0,4);
    $fecha_llegada = substr($fecha_llegada,8,2) ."/".substr($fecha_llegada,5,2)."/".substr($fecha_llegada,0,4);
}




function fnCbTelefonos( $id_rut_deudor ) {
    $listadoTelefonos = sp_estadoTelefonos( $id_rut_deudor);
    $arr_telefonos = array();
    foreach( $listadoTelefonos as $row  ) {
        echo "<option value='".$row['id_telefono']."'>(".$row['area'].")".$row['telefono']." - " .$row['nombre_estado_telefono']."</option>";
        
    }    
}







function fnCbDetalleCredito( $id_rut_deudor ) {
    $detalleAbogado = detalleCredito( $id_rut_deudor );
    foreach( $detalleAbogado as $row  ) {
       echo "<option value='".$row['1']."'>".$row['OPDET_OPERACION'] . ", ". $row['ROL_JUICIO']. ", ". $row['EST_JUICIO']. "</option>";
    }
}



$numCuotasCredito = getNumCuotasCredito( $id_deudor);
$numCuotasPorCobrar =  getNumCuotasPorCobrar( $id_deudor );
$numDiasMora = getNumDiasMora( $id_deudor);
$totalSaldoCapital = getTotalSaldoCapital( $id_rut_deudor);
$interes  = getInteres( $id_rut_deudor);
$totalInteres = round($numDiasMora * $interes);
$totalPagos = round(getTotalPagos( $id_deudor ),0);

//$totalACobrar = CAPITAL_liq)+CDBL(TOTTAL_GAT)+CDBL(Total_Interes))

 
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
        <div class="row center">
            <div class="col-sm-12">
                    <h6>Ejecutivo:<?php echo $rutusu;?> - <?php echo $nombreEjecutivo?></h6>                
            </div>
        </div>
    </div>
    <hr>
    <div align="center">
        <b>Informacion Deudor:</b> <?php echo $id_deudor;?>- <b>Fecha Asignacion:</b> <?php echo $fecha_asig_ejecutivo;?> - <b>Fecha LLegada:</b><?php echo $fecha_llegada?>
        <b>Asignacion:</b> <?php echo $desc_remesa;?> 
    </div>
    <hr><br><br>
    <div align='center'>
    <table>
        <tr><td>Id deudor</td><td><?php echo $id_deudor;?></td></tr>
        <tr><td>Rut</td><td><?php echo $id_rut_deudor;?></td></tr>
        <tr><td>Nombre</td><td><?php echo $nombreDeudor;?></td></tr>
        <tr><td>Telefono</td><td><select name="cbTelefonos" id="cbTelefonos"><?php fnCbTelefonos( $id_rut_deudor );?></select></td></tr>
        <tr><td>Detalle Credito:</td><td><select name="cbDetalleCredito" id="cbDetalleCredito"><?php fnCbDetalleCredito( $id_rut_deudor );?></select></td></tr>
    </table>
    </div>
    <hr>
    <div align='center'>
    <table  class="tabla-gestiones">
        
        <tr><t colsapn='2'><h6>Detalle Deuda al</h6</td></tr>
        <tr><td>Nro. CUOTAS DEL CREDITO:</td><td align='right'><?php echo $numCuotasCredito?></td></tr>
        <tr><td>Nro. CUOTAS POR COBRAR:</td><td  align='right'><?php echo $numCuotasPorCobrar?></td></tr>
        <tr><td>Nro. DIAS MORA:</td><td  align='right'><?php echo $numDiasMora?></td></tr>
        <tr><td>TOTAL SALDO CAPITAL:</td><td  align='right'><?php echo number_format($totalSaldoCapital)?></td></tr>
        <tr><td>INTERES 0,8%:</td><td  align='right'><?php echo number_format($interes)?></td></tr>
        <tr><td>TOTAL INTERES 0,8%:</td><td  align='right'><?php echo number_format($totalInteres)?></td></tr>
        <tr><td>TOTAL PAGOS:</td><td  align='right'><?php echo number_format($totalPagos)?></td></tr>
         <tr><td>TOTAL A COBRAR:</td><td  align='right'><?php ?></td></tr>
    </table>    
    </div>
    
    <br><hr><br>
   
     <form name="frm" id="frm" action="ingGestion.php"  method="POST">
        <input type="hidden" name="rutusu" id="rutusu" value="<?php echo $rutusu?>">
        <input type="hidden" name="id_deudor" id="id_deudor" value="<?php echo $id_deudor?>">
        <input type="hidden" name="id_rut_deudor" id="id_rut_deudor" value="<?php echo $id_rut_deudor?>">
        <input type="hidden" name="id_cedente" id="id_cedente" value="<?php echo $id_cedente?>">
        <input type="hidden" name="id_campana" id="id_campana" value="<?php echo $id_campana?>">
        <input type="hidden" name="id_remesa" id="id_remesa" value="<?php echo $id_remesa?>">
        
    <div align="center"> 
        
        <input type="button" class="Boton" name="IngGestion" value="ING. GESTION" onClick="Ing_Gestion();">&nbsp;
    	<input type="button" class="boton" name="F_At" value="AGENDAR" onClick="agendar()">&nbsp;
    	<input type="button" class="boton" name="Pasa_Deu" value="PASAR DEUDOR" onClick="P_Deudor()">&nbsp;
    	<input type="button" class="boton" name="Dir" value="DIRECCIONES" onClick="Dir_()">&nbsp;
    	<input type="button" class="boton" name="Tel" value="TELEFONOS" onClick="Fono()">&nbsp;
    	<input type="button" class="boton" name="ayuda" value="AYUDA" onClick="ayuda1()">&nbsp;
    	<input type="button" class="boton" name="EMAIL" value="EMAIL"  onClick="mail_cr()">&nbsp;
    </div>
    <div align="center"> 
        <input type="button" class="boton" name="vedoctos" value="VER DOCTOS" onClick="verdoctos()">&nbsp;
    	<input type="button" class="boton" name="vepagos" value="VER PAGOS" onClick="verpagos()">&nbsp;
    	<input type="button" class="boton" name="vegestion" value="VER GESTIONES" onClick="vergestion()">&nbsp;
    	<input type="button" class="boton" name="veendic" value=" " onClick="">&nbsp;
    	<input type="button" class="boton" name="veconve" value=" " onClick="">&nbsp;
    	<input type="button" class="boton" name="Estados" value=" " onClick="verFicha();">
    	<input type="button" class="boton" name="Volver" value="VOLVER" onClick="tvolver()">&nbsp;
	</div>
    </form>
	<br><br>
	<?php include "footer.php"; ?>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>        	
<script>
    function Ing_Gestion(){
        //alert("kkk");
        document.getElementById("frm").submit();
    }
</script>	
</body>
</html>