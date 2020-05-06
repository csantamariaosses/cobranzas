<?php
require_once("Connection.php");

$id_rut_deudor = $_POST['id_rut_deudor'];
$nuevaArea = $_POST['nuevaArea'];
$nuevoFono = $_POST['nuevoFono'];

$str = $id_rut_deudor . " " .$nuevaArea. " ".$nuevoFono;
//echo $id_rut_deudor . " " .$nuevaArea. " ".$nuevoFono;
//echo $id_rut_deudor . " ". $nuevaArea;
//echo $str;

$data = [
    'area'=>$nuevaArea,
    'telefono'=>$nuevoFono,
    'rut'=>$id_rut_deudor,
];

$sql = " select count(*) as conteo ";
$sql .= " from t_telefonos ";
$sql .= " where area =:area";
$sql .= " and   telefono =:telefono";
$sql .= " and   rut =:rut ";

try {
$database = new Connection();
$db = $database->openConnection();
            
$select  = $db->prepare( $sql );
$select->execute( $data );

$conteo = "0";
if( $select ) {
    if( !empty( $select )) {
        foreach ($select as $row) {
            $conteo = $row['conteo'];
        }
    } else {
        $conteo = "0";
    }
  
} 
echo  $conteo;

} catch( PDOexception $e ) {
    echo "Error is: " . $e-> etmessage();
        
}

?>



