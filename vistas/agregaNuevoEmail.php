<?php

require_once("Connection.php");

$rutusu        = $_POST['loginIngreso'];
$id_email      = $_POST['id_email'];
$id_rut_deudor = $_POST['rut'];
$nuevoEmail    = $_POST['email'];
$id_estado_telefono = 1;

$str = "nuevo id:".$id_email." rut:".$id_rut_deudor." email:".$nuevoEmail." usuario:" .$rutusu;
//echo "insertar :".$str;


$data = [
    'id_email' => $id_email,
    'rut'=>$id_rut_deudor,
    'email'=>$nuevoEmail,
    'id_estado'=>$id_estado_telefono,
    'loginIngreso' => $rutusu,

];

$sql = " insert into t_email ";
$sql .= " (id_mail, rut, email, fecha_ingreso, login_ingreso, id_estado, fecha_ult_modif, login_ult_modif ) values ";
$sql .= " (:id_email, :rut, :email, now(),:loginIngreso,:id_estado, now(),:loginIngreso)";

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



