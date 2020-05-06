<?php
require_once("Connection.php");


$sql = " select max(id_telefono) as maxId ";
$sql .= " from t_telefonos ";

try {
$database = new Connection();
$db = $database->openConnection();
            
$select  = $db->prepare( $sql );
$select->execute( $data );

$maxId = "0";
if( $select ) {
    if( !empty( $select )) {
        foreach ($select as $row) {
            $maxId = $row['maxId'];
        }
    } else {
        $maxId = "0";
    }
  
} 
echo $maxId;

} catch( PDOexception $e ) {
    echo "Error is: " . $e-> etmessage();
        
}

?>



