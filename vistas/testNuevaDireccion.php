<?php
require_once("Connection.php");

$id_rut_deudor = $_POST['id_rut_deudor'];
$nuevaDireccion = $_POST['nuevaDireccion'];
$nuevaComuna = $_POST['nuevaComuna'];


$str = $id_rut_deudor . " " .$nuevaDireccion." ".$nuevaComuna;

//echo $str;


$data = [
    'rut'   => $id_rut_deudor,
    'direccion' => $nuevaDireccion,
    'comuna' => $nuevaComuna,
];

$sql = " select count(*) as conteo ";
$sql .= " from t_direcciones  ";
$sql .= " where rut =:rut";
$sql .= " and   direccion =:direccion";
$sql .= " and   comuna    =:comuna";

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
