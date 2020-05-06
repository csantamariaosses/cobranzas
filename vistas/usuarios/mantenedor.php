<!doctype html>
<html>
<head>
<title></title>
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


$where = " where 1=1 ";
if ( isset( $_POST["filtroRut"]) and strlen( $_POST["filtroRut"] ) > 0  ) {
	$filtroRut = $_POST['filtroRut'];
	$where .= " and  rut='" .$filtroRut.  "'";
}

if ( isset( $_POST["filtroNombre"]) and strlen( $_POST["filtroNombre"] ) > 0 ) {
    $filtroNombre = $_POST['filtroNombre'];
	$where .= " and  nombre like '%" . $filtroNombre . "%'";
}


if ( isset( $_POST["filtroApellido"])   and strlen( $_POST["filtroApellido"] ) > 0   ) {
    $filtroApellido = $_POST['filtroApellido'];
	$where .= " and  nombre like '%" . $filtroApellido . "%'";
}






require_once("../Connection.php");
require_once("../funcionesADO.php");

$nombreUsuario = getNombreUsuario( $rutusu  );

$sql  = " SELECT id, rut,dgv,Nombre,id_estado_usuario,t_cargos.DSCR_CRG, testado.DESCESTADO, ";
$sql .= " t_sucursales.DES_SCRSL, fechaSistema ";
$sql .= " FROM tl_usuarios inner join testado on (tl_usuarios.id_estado_usuario = testado.ID_ESTADO) ";
$sql .= " inner join t_cargos     on (tl_usuarios.ID_CRG = t_cargos.ID_CRG) ";
$sql .= " inner join t_sucursales on (tl_usuarios.ID_SCRSL = t_sucursales.ID_SCRSL) ";
$sql .=  $where;
$sql .= " order by fechaSistema  desc ";
//echo $sql;
$database = new Connection();
$db = $database->openConnection();
$result = $db->query($sql);
$i= 0;
$iMax = 0;
if( $result ) {
     foreach ($result as $row) {
         $array['id'][$i]    = $row['id'];
         $array['rut'][$i]    = $row['rut'];
         $array['dgv'][$i]    = $row['dgv'];
         $array['Nombre'][$i]    = $row['Nombre'];
         $array['id_estado_usuario'][$i]    = $row['id_estado_usuario'];
         $array['DSCR_CRG'][$i]    = $row['DSCR_CRG'];
         $array['DESCESTADO'][$i]    = $row['DESCESTADO'];
         $array['DES_SCRSL'][$i]    = $row['DES_SCRSL'];
         $array['fechaSistema'][$i]    = $row['fechaSistema'];
         
         //echo  $array['dgv'][$i] ;
         
         //echo "<br>".$row['Nombre']. " ". $row['jerarquia']. " ". $row['sistema'];
         $i++;
     }
     $iMax = $i;
}


?>

<body>
  
 <div class="container filtro">
   <FORM name="frm" method="post">
    <table width="85%" border="0" cellpadding="1" cellspacing="2" align="center">
    	<tr><td width="20%" height="21"></td><td>FILTRO</td></tr>
    	<tr><td width="20%" height="21"><FONT SIZE="1" COLOR="#666699">&nbsp;<b>Rut (sin digito V.):</font></td><td><input type="text" name="filtroRut" id="filtroRut" class="text"></td></tr>
    	<tr><td width="20%" height="21"><FONT SIZE="1" COLOR="#666699">&nbsp;<b>Nombre</font></td><td><input type="text" name="filtroNombre" id="filtroNombre" class="text"></td></tr>
        <tr><td width="20%" height="21"><FONT SIZE="1" COLOR="#666699">&nbsp;<b>Apellido</font></td><td><input type="text" name="filtroApellido" id="filtroApellido" class="text"></td></tr>	
    	<tr><td></td><td><input type="submit" name="btnBuscar" id="btnBuscar" value="Buscar"></td></tr>
	</table>
	</form>
 </div>  
   
   
<div class="container listado">
    <table width="85%"border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
		<td><font face="verdana" size="1">Registros <font color="#FF0000"><?php  echo $inicio ?> </font>
			al <font color="#FF0000"><?php echo $fin?></font> de un total de
			<font color="#FF0000"><?php echo $iMax?></font></font>
		</td>
		<td align="right"><font face="verdana" size="1">Página <font color="#FF0000"><? echo $_SESSION["pagina"] ?>
			</font> de <font color="#FF0000"><?php echo $iMax ?></font></font>
		</td>
	</tr>
	</table>
	<br><hr>
	  <form name="frmListado"  id="frmListado" action="usuarioEditar.php" method="POST">  
	        <input type="hidden" name="hd_id" id="hd_id" value="hola">
		<table class="table table-hover" width="100%">
		     <thead  class="thead-dark">
               <tr>
			    <th align="center"><font face="verdana" size="1">Id</b></font></td>			
				<th align="center"><font face="verdana" size="1">Rut</b></font></td>
				<th align="center"><font face="verdana" size="1">Nombre</b></font></td>		
				<th align="center"><font face="verdana" size="1">Cargo</b></font></td>		
				<th align="center"><font face="verdana" size="1">Sucursal</b></font></td>		
        	    <th align="center"><font face="verdana" size="1">Estado</b></font></td>
        	    <th align="center"><font face="verdana" size="1">FechaSist</b></font></td>
        	  </thead>
			</tr>
			<tbody>
			<?php
			$contador = 0;
			while( $contador < $iMax ) { 
			?>
				<tr onClick=" Seleccion(<?php echo $array['id'][$contador];?>);">
			        <td align="left"><font face="verdana" size="1">&nbsp;&nbsp;<?php echo $array['id'][$contador];?></font></td>
		            <td align="left"><font face="verdana" size="1">&nbsp;&nbsp;<?php echo $array['rut'][$contador]. "-".  $array['dgv'][$contador];?></font></td>
					<td align="left"><font face="verdana" size="1">&nbsp;&nbsp;<?php echo $array['Nombre'][$contador];?></font></td>		
					<td align="left"><font face="verdana" size="1">&nbsp;&nbsp;<?php echo  $array['DSCR_CRG'][$contador];  ?></font></td>		
					<td align="left"><font face="verdana" size="1">&nbsp;&nbsp;<?php echo  $array['DES_SCRSL'][$contador];  ?></font></td>
					<td align="left"><font face="verdana" size="1">&nbsp;&nbsp;<?php echo  $array['DESCESTADO'][$contador];  ?></font></td>
				    <td align="left"><font face="verdana" size="1">&nbsp;&nbsp;<?php echo  $array['fechaSistema'][$contador];  ?></font></td>
				</tr>	
				
			<?php 
			    $contador = $contador + 1;
			} ?>
			</tbody>
		</table>
		</form>
 </div>  
 



<?php include "footer.php"; ?>    
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>                  
<script>
function Seleccion(id){
   //alert(">>"+id);
   //document.forms[1].action = "usuarioEditar.php";
   document.getElementById("hd_id").value = id;
   document.getElementById("frmListado").action = "usuarioEditar.php";
   document.getElementById("frmListado").submit();
   
    
}

function over(fila_){
   // alert("jjj"+fila_);
    var fila = "fila"+fila_;
    alert("fila:"+fila);
    //document.getElementById( "tblListado" ).style.backgroundColor = "blue";
    $("#tblListado").rows(1).css("background-color", "yellow");
}
</script>

</body>
</html>