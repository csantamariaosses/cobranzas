<?php

require_once("Connection.php");

$id_telefono   = $_POST['id_telefono'];
$id_rut_deudor = $_POST['id_rut_deudor'];
$nuevaArea     = $_POST['nuevaArea'];
$nuevoFono     = $_POST['nuevoFono'];
$id_tipo_telefono   = $_POST['id_tipo_telefono'];
$id_estado_telefono = $_POST['id_estado_telefono'];
$cod_ult_gestion    = $_POST['cod_ult_gestion'];

$str = "nuevo id:".$id_telefono." rut:".$id_rut_deudor." area:".$nuevaArea." Fono:" .$nuevoFono;
//echo "insertar :".$str;

$data = [
    'id_telefono' => $id_telefono,
    'rut'=>$id_rut_deudor,
    'area'=>$nuevaArea,
    'telefono'=>$nuevoFono,
    'id_tipo_telefono'=>$id_tipo_telefono,
    'id_estado_telefono'=>$id_estado_telefono,
    'cod_ult_gestion'=>$cod_ult_gestion
];

$sql = " insert into t_telefonos ";
$sql .= " (id_telefono, rut, area, telefono, id_tipofono, id_estado_telefono, cod_ult_gestion, fecha_ult_gestion, hora_ult_gestion ) values ";
$sql .= " (:id_telefono, :rut, :area, :telefono, :id_tipo_telefono, :id_estado_telefono, :cod_ult_gestion, now(), DATE_FORMAT(NOW( ), '%H:%i:%S' ))";

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
    echo "Error is: " . $e-> etmessage();
}

?>



