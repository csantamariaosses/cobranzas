<!doctype html>
<html>
<head>
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

$rutusu     = $_SESSION['rutusu'];
$id_cedente = $_GET['id_cliente'];
$id_campana = $_GET['id_campana'];


$nombreEjecutivo =  getNombreUsuario( $rutusu  );
$nombreCedente = getNombreCedente($id_cedente );

$id_remesa = getIdRemesa( $id_campana );
$nombreRemesa = getNombreRemesa( $id_remesa );
$nombreCampana = getNombreCampana( $id_campana  );

$id_producto = getIdProducto( $id_remesa );

//$id_cedente = getIdCedente( $id_producto);



$sql   = "select r.desc_remesa,d.id_deudor,d.id_rut_deudor,d.dv,d.nombre,d.fecha_ult_gestion,d.fecha_ult_compromiso,r.id_producto,isnull(a.area),isnull(a.fono), r.desc_remesa ";
$sql .=  "  from t_campanas c ";
$sql .=  "  inner join t_remesas r on(c.id_remesa=r.id_remesa) ";
$sql .=  "  inner join t_campanas_deu a on(a.id_campana=c.id_campana) ";
$sql .=  "  left join t_deudor d on(d.id_deudor=a.id_deudor) ";
$sql .=  "  where c.id_campana=". $id_campana ;
$sql .=  "  and   a.rut_ejecutivo=". $rutusu;
$sql .=  "  and   a.id_gestionado=0 ";	
$sql .=  "  and   d.id_estado <> 2 " ;
$sql .=  "  order by a.prioridad ";
$sql .=  "  limit 5 ";


$database = new Connection();
$db = $database->openConnection();

$arr = array();
$result = $db->query($sql);
if( $result ) {
    $cont = 0;
    foreach ($result as $row) {
        
        $arr['id_deudor'][$cont] = $row['id_deudor'];
        $arr['id_rut_deudor'][$cont] = $row['id_rut_deudor'].'-'.$row['dv'];
        $arr['nombre'][$cont] = $row['nombre'];
        $arr['id_producto'][$cont] = $row['id_producto'];
        $arr['fecha_ult_gestion'][$cont] = $row['fecha_ult_gestion'];
        $arr['fecha_ult_compromiso'][$cont] = $row['fecha_ult_compromiso'];
        $arr['desc_remesa'][$cont] = $row['desc_remesa'];
    
        $cont++;
    }
    

}


$totalAsignado = totalAsignado($id_campana, $rutusu);
$totalGestionados = totalGestionados($id_campana, $rutusu);
$totalSinGestionar = $totalAsignado - $totalGestionados;

?>
<body>
    <?php include "header.php"; ?>
    
    <div class="container">
        <div class="row center">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4 my-3">
                    <h5>AGENTE TELEFONICO</h5>                
            </div>
            <div class="col-sm-4">
                <form name="frmSalir" id="frmSalir" action="controlador.php" method="POST"><input type="submit" name="btnSalir" value="Salir"><input type="hidden" name="accion" value="salir"></form>
            </div>            
        </div>
    </div>
    

    
    <div align="center">

    <H6><?php echo $rutusu?> - <?php echo $nombreEjecutivo;?></h6>
    <h6>Cedente:<?php echo $id_cedente;?> - <?php echo $nombreCedente;?></h6>
    <h6>Campana:<?php echo $id_campana;?> - <?php echo $nombreCampana;?></h6>
    <h6>Remesa:<?php echo$id_remesa;?> - <?php echo $nombreRemesa;?></h6>
    </div>
    <br>
    <hr>
    <br>
    <form name="frm" id="frm" method="POST">
        <input type="hidden" name="id_deudor"  id="id_deudor">
        <input type="hidden" name="id_cedente" id="id_cedente">
        <input type="hidden" name="id_campana" id="id_campana">
        <input type="hidden" name="id_remesa"  id="id_remesa">
        
    <div class="container">
        <div class="row">
            <div class="col-sm-1">
            </div>
            <div class="col-sm-10">
                    <table class="table tabla-select-campana table-bordered">
        <tr>
            <td>ID Deudor</td><td> Rut Deudor</td><td> Nombre Deudor</td><td> Cartera</td><td> Fecha Ult. Gestion</td><td> Fecha Compromiso </td>
        </tr>
                    <?php 
                    for( $i=0; $i < $cont; $i++) { 
                        echo "<tr onClick='javascript:Seleccion2(". $arr['id_deudor'][$i].",".$id_cedente.",".$id_campana.",".$id_remesa.")'>";
                        echo "<td>". $arr['id_deudor'][$i]."</td>";
                        echo "<td align='center'>". $arr['id_rut_deudor'][$i]."</td>";
                        echo "<td>". $arr['nombre'][$i]."</td>";
                        echo "<td>". $arr['desc_remesa'][$i]."</td>";
                        echo "<td>". $arr['fecha_ult_gestion'][$i]."</td>";
                        echo "<td>". $arr['fecha_ult_compromiso'][$i]."</td>";
                        echo "<tr>";
                     } ?>
                </table>
            </div>
            <div class="col-sm-1">
            </div>            
        </div>
    </div>

    </form>
    </div> 
    
    <BR>

<div align='center'>

<table align="center" width="50%" cellpadding="0" cellspacing="0" border="1">
  <tr>
    <td width="100%" align="center"  colspan="2"   bgcolor="#003333">
		<font face="verdana" size="2" color="#FFFFFF">CAMPA&Ntilde;A&nbsp;::&nbsp;&nbsp;<?php echo $nombreCampana?></font>
	</td>
  </tr>
  <tr>
	<td><strong><font face="verdana" size="2" >Total Asignado Campa&ntilde;a </font></strong></td>
	<td align='right'><?php echo $totalAsignado;?></td>
  </tr>
  <tr>
	<td><strong><font face="verdana" size="2" >Total Gestionados </font></strong></td>
	<td  align='right'><?php  echo $totalGestionados;?></td>
  </tr>  
  <tr>
	<td><strong><font face="verdana" size="2" >Total Sin Gestionar </font></strong></td>
	<td  align='right'><?php echo $totalSinGestionar;?></td>
  </tr>    
 </table>
</div>   
<br>
<div align='center'>  
       <input type="button" name="ACTUALIZA" value="ACTUALIZAR" style="FONT-SIZE: 10px; WIDTH: 120px; COLOR: #FF0000; BACKGROUND-COLOR: #ffffff; font-face: verdana" onClick="Actualizar()"></td>    
  </div>
<br><br>  
<?php include "footer.php"; ?>  

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>          
<script>
function selCampana( id ) {
    window.location = "AgenteTelefonico.php?valor='"+id;
}
    
function Actualizar() {
	location. reload();
}

function Seleccion2(id_deudor, id_cedente, id_campana, id_remesa)
{

    //alert(id_deudor+ " "+ id_cedente+ " " + id_campana+ " " + id_remesa);
    document.getElementById("id_deudor").value = id_deudor;
    document.getElementById("id_cedente").value = id_cedente;
    document.getElementById("id_campana").value = id_campana;
    document.getElementById("id_remesa").value = id_remesa;
	document.frm.action = "gestionBanmedica.php";
	document.frm.submit();
}
</script>    
</body>
</html>