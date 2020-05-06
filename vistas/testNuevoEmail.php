<?php
require_once("Connection.php");

$id_rut_deudor = $_POST['id_rut_deudor'];
$nuevoEmail = $_POST['nuevoEmail'];


$str = $id_rut_deudor . " " .$nuevoEmail;

//echo $str;


$data = [
    'rut'   => $id_rut_deudor,
    'email' => $nuevoEmail,
];

$sql = " select count(*) as conteo ";
$sql .= " from t_email ";
$sql .= " where rut =:rut";
$sql .= " and   email  =:email";

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
