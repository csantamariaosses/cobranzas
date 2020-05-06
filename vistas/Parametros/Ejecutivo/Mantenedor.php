<!doctype html>
<html>
<head>
    <tile>Mantenedor</tile>
</head>   
<?php
session_start();
$rutusu = $_SESSION['rutusu'];

echo $rutusu;

if(!isset($_SESSION['rutusu'])) { 
    $rutusu = $_SESSION['rutusu'];
    if( strcmp($rutusu,"") == 0) {
        echo "sesion expirada";
        echo "<br>reconectar <a href='https://www.slcltda.cl/cobranza/vistas/index.php'>aqui</a>";
        exit();        
    }

}


require_once("../../Connection.php");
require_once("../../funcionesADO.php");


$sql  = " SELECT rut,dgv,Nombre,id_estado_usuario,t_cargos.DSCR_CRG, testado.DESCESTADO, ";
$sql .= " t_sucursales.des_scrsl ";
$sql .= " FROM tl_usuarios inner join testado on (tl_usuarios.id_estado_usuario = testado.ID_ESTADO) ";
$sql .= " inner join t_cargos     on (tl_usuarios.ID_CRG = t_cargos.ID_CRG) ";
$sql .= " inner join t_sucursales on (tl_usuarios.ID_SCRSL = t_sucursales.ID_SCRSL) ";
$sql .= " order by fechaSistema  desc ";

echo "<br>".$sql;

$database = new Connection();
$db = $database->openConnection();
$result = $db->query($sql);
$i= 0;
if( $result ) {
     foreach ($result as $row) {
         $Menu['rut'][$i]    = $row['rut'];
         $Menu['dgv'][$i]    = $row['dgv'];
         $Menu['nombre'][$i]    = $row['Nombre'];
         $Menu['id_estado_usuario'][$i]    = $row['id_estado_usuario'];
         $Menu['DSCR_CRG'][$i]    = $row['DSCR_CRG'];
         $Menu['DESCESTADO'][$i]    = $row['DESCESTADO'];
         //echo "<br>".$row['Nombre']. " ". $row['jerarquia']. " ". $row['sistema'];
         $i++;
     }
}


?>
<body>
    <h4>Mantenedor Ejecutivos</h4>
    <FORM name="frm" method="post">
        <table width="100%" bgcolor="#666699" border="0" CLASS="TABLA" cellpadding="0" cellspacing="0" align="center" >
        	<tr>
        		<td align="center">&nbsp;<font face="verdana" size="2" color="#FFFFFF"><b>Mantenedor de Usuarios</b></font></td>
        	</tr>
        </table>
        <br>
        <form method="post" action="mantenedor.asp" name="frm">
        <input type="hidden" name="accion">
        <input type="hidden" name="where" value="<%=Request("where")%>">
        <input type="hidden" name="valor">
        <input type="hidden" name="direccion">
        <input type="hidden" name="order" value="<%=Request("order")%>">
        <input type="hidden" name="Ascen">
        <input type="hidden" name="qstTabla" value="<%=Request("qstTabla")%>">
        <%if not rs.eof then%>
        <table width="85%" border="0" cellpadding="1" cellspacing="2" align="center">
        	<tr><td width="20%" height="21"></td><td>FILTRO</td></tr>
        	<tr><td width="20%" height="21"><FONT SIZE="1" COLOR="#666699">&nbsp;<b>Rut (sin digito V.):</font></td><td><input type="text" name="filtroRut" id="filtroRut" class="text"></td></tr>
        	<tr><td width="20%" height="21"><FONT SIZE="1" COLOR="#666699">&nbsp;<b>Nombre</font></td><td><input type="text" name="filtroNombre" id="filtroNombre" class="text"></td></tr>
            <tr><td width="20%" height="21"><FONT SIZE="1" COLOR="#666699">&nbsp;<b>Apellido</font></td><td><input type="text" name="filtroApellido" id="filtroApellido" class="text"></td></tr>	
        	<tr><td></td><td><input type="submit" name="btnBuscar" id="btnBuscar" value="Buscar"></td></tr>
        </table>
   </form>
    
</body>
</html>