<!doctype html>
<html>
<head>
<title></title>    
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">      
<link rel="stylesheet" href="css/styles.css">
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
//require_once("funcionesADO.php");



try {
    
    $database = new Connection();
    $db = $database->openConnection();
    $SQL_CEDENTES = "select id_cliente,cli_razon_soc from t_clientes where cli_estado = 1 order by cli_razon_soc";

    $result = $db->query( $SQL_CEDENTES );
    $arreglo = array();
    if( $result ) {
        $cont = 0;
        foreach( $result as  $fila ) {
            $arreglo['id_cliente'][$cont++] = $fila['id_cliente'];
            $arreglo['cli_razon_soc'][$cont++] = $fila['cli_razon_soc'];

        }
        
        $db = null;
    }
    
     $db = null;

}catch (PDOexception $e) {
    echo "Error is: " . $e-> etmessage();

}


?>
</head>
<body>
    <?php include "header.php"; ?>
    <div class="container">
        <div class="row center">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4 my-3">
                    <h5>SELECCION CEDENTE</h5>                
            </div>
            <div class="col-sm-4">
                <form name="frm" id="frm" action="controlador.php" method="POST"><input type="submit" name="btnSalir" value="Salir"><input type="hidden" name="accion" value="salir"></form>
            </div>            
        </div>
    </div>
    
    <div class="container my-3">
        <div class="row center">
            <div class="col-sm-12">
                <h6>Usuario:<?php echo $_SESSION['rutusu'];?></h6>
            </div>    
        </div>
    </div>    
        
    <div class="container my-3">        
        <div class="row center">
            <div class="col-sm-2">
            </div>
            <div class="col-sm-8 center">
                
                <table class="table">
                    <tr><td>idCliente</td><td>Cliente</td><td></td></td></tr>
                    <?php 
                    for( $i= 0; $i < sizeof(  $arreglo ) -1; $i++) {
                        echo "<tr><td>" . $fila['id_cliente'][$i]."</td><td>". $fila['cli_razon_soc']."</td><td><input type='button' value='->' onClick='selCliente(".$fila['id_cliente'][$i].")'></td></tr>";
                    }
                    ?>
                </table>
            </div>
            <div class="col-sm-2">
            </div>
        </div>
    </div>
    <br><br>
	<?php include "footer.php"; ?>    
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>        

<script>
    function selCliente( id ) {
        //alert("id:"+ id);
        window.location = "selectCampana.php?id_cliente="+id;
    }
</script>
</body>
</html>