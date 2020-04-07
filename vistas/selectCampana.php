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


$id_cedente = $_GET['id_cliente'];
$rutusu     = $_SESSION['rutusu'];

$nombreUsuario =  getNombreUsuario( $rutusu  );

//echo "<br>NombreUsuario:".$nombreUsuario;

$nombreCliente = getNombreCedente( $id_cedente );
//echo "<br>nombreCliente:".$nombreCliente;
                 



try {
    $database = new Connection();
    $db = $database->openConnection();
    
    $sql  = " select  ";
    $sql .= " c.id_campana, ";
    $sql .= " c.campana, ";
    $sql .= " r.desc_remesa, ";
    $sql .= " c.total_deudores, ";
    $sql .= " (select count(*) from t_campanas_deu b where c.id_campana=b.id_campana and b.id_gestionado=0) as xx, ";
    $sql .= " c.total_saldo ";
    $sql .= " from t_campanas c ";
    $sql .= " INNER JOIN t_remesas r ON c.id_remesa=r.id_remesa  ";
    $sql .= " inner join t_productos p on r.id_producto = p.id_producto ";
    $sql .= " left  join tl_usuarios u on u.rut = rtrim(ltrim(c.login_ingreso)) ";
    $sql .= " WHERE c.id_estado=1  ";
    $sql .= " and   r.id_estado=1  ";
    $sql .= " and   p.id_cedente = ".$id_cedente;
    $sql .= " and exists (select * from t_campanas_deu crl where rut_ejecutivo = ".$rutusu." and crl.id_campana = c.id_campana  limit 1)  ";
    $sql .= " ORDER BY c.fecha_ingreso DESC ";



    //echo $sql;
    $result = $db->query($sql);
    
    
    $arreglo = array();
    
    if( $result ) {
         
         $cont = 0;
         foreach($result as  $fila ) {
             
             $arreglo['id_campana'][$cont]     = $fila['id_campana'];
             $arreglo['campana'][$cont]        = $fila['campana'];
             $arreglo['desc_remesa'][$cont]    = $fila['desc_remesa'];
             $arreglo['total_deudores'][$cont] = $fila['total_deudores'];
             $arreglo["xx"][$cont]             = $fila['xx'];
             $arreglo['total_saldo'][$cont]    = $fila['total_saldo'];
             $cont++;
        }
    } else {
        echo "<br>No tiene registros";
    }


 } catch (PDOexception $e) {
            echo "Error is: " . $e-> etmessage();
}
$db = null;


?>
<body>
     <?php include "header.php"; ?>
     <div class="container">
        <div class="row center">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4 my-3">
                    <h5>SELECCION CAMPA&Nacute;A</h5>                
            </div>
            <div class="col-sm-4">
                <form name="frm" id="frm" action="controlador.php" method="POST"><input type="submit" name="btnSalir" value="Salir"><input type="hidden" name="accion" value="salir"></form>
            </div>            
        </div>
    </div>
    
     
    
    <div class="container">
         <div class="row">
             <div class="col-sm-2">
             </div>
             <div class="col-sm-8">
                 <h6>Usuario:<?php echo $_SESSION['rutusu'];?> - Nombre:<?php echo $nombreUsuario;?></h6>
                 <h6>Id Cliente:<?php echo $id_cedente;?> - Nombre Cliente:<?php echo $nombreCliente;?></h6>             
             </div>
             <div class="col-sm-2">
             </div>             
         </div>
    </div>         
    
    <br><br>
    <div class="container">
         <div class="row">
             <div class="col-sm-1">
             </div>
             <div class="col-sm-10">
            <table class="tabla-select-campana table-bordered">
                <tr><td>Id Campana</td><td>Nombre Campana</td><td>Cartera</td><td>Nro.Casos</td><td>Casos Sin Gestion</td><td>Monto $</td></tr>
                <?php  
            
                    for( $i= 0; $i < $cont; $i++) {
                        echo "<tr><td>" . $arreglo['id_campana'][$i]."</td>";
                        echo     "<td>" . $arreglo['campana'][$i]   ."</td>";
                        echo     "<td>" . $arreglo['desc_remesa'][$i]   ."</td>";
                        echo     "<td>" . $arreglo['total_deudores'][$i]   ."</td>";
                        echo     "<td>" . $arreglo["xx"][$i]      ."</td>";
                        echo     "<td>" . $arreglo['total_saldo'][$i]   ."</td>";
                    
                        echo     "<td><input type='button' value='->' onClick='selCampana(".$arreglo['id_campana'][$i].",".$id_cedente.");'></td></tr>";
                    }
                
                ?>
            </table>
            </div>
            <div class="col-sm-1">
             </div>
        </div>
    </div>
    <br><br>
	<?php include "footer.php"; ?>    
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>        
    
<script>
    function selCampana( id_campana , id_cedente ) {
        //alert("id_campana:"+ id_campana);
        //alert("id_cedente:"+ id_cedente);
        //var url = "agenteTelefonico.php?id_cliente="+$id_cedente+"&id_campana="+id_campana;
        var url = "agenteTelefonico.php?id_cliente="+id_cedente+"&id_campana="+id_campana;
        //alert( url );
        window.location = url;
        //window.location =  "agenteTelefonico.php?id_cliente="+$id_cedente+"&id_campana="+id_campana;
        //window.location = "agenteTelefonico.php?id_campana="+id_campana;
        //window.location = "agenteTelefonico.php?id_campana="+id_campana;
    }
</script>    
</body>
</html>