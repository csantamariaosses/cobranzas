<?php
require_once("Connection.php");


$sql = " select max(id_direccion)  as maxId ";
$sql .= " from t_direcciones ";

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



