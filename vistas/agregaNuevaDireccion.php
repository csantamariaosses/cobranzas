<?php

require_once("Connection.php");

$id_rut_deudor  = $_POST['rut'];                      
$id_direccion   = $_POST['id_direccion'];
$nuevaDireccion = $_POST['direccion'];
$nuevaComuna    = $_POST['comuna'];
$rutusu         = $_POST['loginIngreso'];
$id_estado_direccion = $_POST['id_estado'];

//$str = "nuevo id:".$id_direccion." rut:".$id_rut_deudor." direccion:".$nuevaDireccion." comuna:" .$nuevaComuna. " rutusu:".$rutusu. " id_estado:".$id_estado_direccion;
//echo "insertar :".$str;

$data = [
    'id_direccion' => $id_direccion,
    'rut'          => $id_rut_deudor,
    'direccion'    => $nuevaDireccion,
    'comuna'       => $nuevaComuna,
    'id_estado_direccion' =>$id_estado_direccion,
    'loginIngreso'        => $rutusu,
];

$sql  = " insert into t_direcciones ";
//$sql .= " (id_direccion, rut, direccion, comuna, id_estado_direccion, ) values ";
//$sql .= " (:id_direccion, :rut, :direccion, :comuna )";

$sql .= " (id_direccion, rut, direccion, comuna , id_estado_direccion, fecha_ingreso, login_ingreso ) values ";
$sql .= " (:id_direccion, :rut, :direccion, :comuna, :id_estado_direccion, now(),:loginIngreso )";

//echo $sql;

try {
    $database = new Connection();
    $db = $database->openConnection();
                
    $select  = $db->prepare( $sql );
    $select->execute( $data );
    
    if( $select ) {
        echo "1";    
    } else {
        echo "0";
    }
} catch( PDOexception $e ) {
    echo "Error is: " . $e->getmessage();
}


?>



