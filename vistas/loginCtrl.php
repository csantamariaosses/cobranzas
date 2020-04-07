<?php
session_start();
require_once("Connection.php");
require_once("funcionesADO.php");

$rutusu   = $_POST['rutusu'];
$password = $_POST['password'];
$grupo    = $_POST['cbGrupo'];


/*echo "<br>user:".$rutusu;
echo "<br>pwd:".$password;
echo "<br>grupo:".$grupo;
*/
$arr_rutusu = explode("-", $rutusu);
$rutusu = $arr_rutusu[0];

$existe = existeUsuario($rutusu, $password, $grupo );
//echo "<br>conteo:". $existe;

if( $existe > 0  ) {
    $infoUser = getInfoUser($rutusu, $password, $grupo);
    if( !empty( $infoUser )) {
        foreach ($infoUser as $row) {
            $id = $row['id'];
            $nombre = $row['nombre'];
            $grupo = $row['grupo']; 
            //echo "<br>nom:".$nombre;
        }
    }
    //echo "<br>Existe";
    
    if( strcmp( $grupo, "33") == 0 ) {
        //echo "<br>ok";
        header('Location: admin.php');
        exit();
        //header("Location: http://www.ejemplo.es");
    } else {
        //echo "ejecutivo telefonico";
        $_SESSION['rutusu'] = $rutusu;
        header('Location: seleccionCedente.php');
        exit();
    }
    
} else  {
    //echo "<br>NO Existe";
    header('Location: index.php?msg=Usuario o password no corresponden..!!');
    exit();
}


