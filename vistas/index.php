<!doctype html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">    
<link rel="stylesheet" href="css/styles.css">
<style>
/*
body {
    
}
#titulo {
    background-color:#033;
    color:#FFF;
    margin-top:50px;
}    

#sub-titulo {
    background-color:#033;
    color:#FFF;
    /*margin-top:50px; */
}    
.frm {
    background-color:#cccccc;
}

.form-control {
    height:30px;
    font-family:Arial;
    font-size:15px;
}

.etiqueta {
    font-family:Arial;
    font-size:15px;
}
*/
</style>
<?php
require_once ("Connection.php");

function fnCbGrupo() {
    try {
        $database = new Connection();
        $db = $database->openConnection();
        $sql = "SELECT id_grupo, nom_grupo FROM tl_grupo order by nom_grupo ";
        $result = $db->query($sql);
    
        echo "<br/>";
        //$result = $filas->fetch(PDO::FETCH_ASSOC);
        echo "<option value='0'>Seleccione...</option>";
        foreach($result as  $fila ) {
            echo "<option value='".$fila['id_grupo']. "'>" . $fila['nom_grupo']."</option>>";
        }
        $db = null;
    }
    catch (PDOexception $e) {
        echo "Error is: " . $e-> etmessage();
    }
}
?>
</head>    
<body>
    <?php include "header.php"; ?>
    <?php //include "footer.php"; ?>  
        <hr>
    <div class="container">    
        <div class="row">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4">
                <div align="center" id="titulo">LOGIN</div>            
            </div>
            <div class="col-sm-4">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4 frm" >
                  <form name="frm" id="frm"  method="POST">
                      <br>
                      <div class="form-group">
                        <label for="usuario" class="etiqueta">Usuario</label>
                        <input type="text" class="form-control" name="rutusu" id="rutusu" aria-describedby="Usuario" maxlength="11" size="10" width="10" onBlur="validOnBlurRut();">
                      </div>
                      <div class="form-group">
                        <label for="usuario" class="etiqueta">Password</label>
                        <input type="password" class="form-control" name="password" id="password" aria-describedby="Password">
                      </div>
                       <div class="form-group">
                        <label for="usuario" class="etiqueta">Grupo Usuario</label>
                        <select name="cbGrupo"  id="cbGrupo" class="form-control"><?php fnCbGrupo() ?></select>
                      </div>
                      <div class="form-group">
                        <input type="button" class="form-control" id="btnSubmit" value="Ingresar" onClick="validar();">
                      </div>
                      
                       <?php if( isset(  $_GET['msg'] ) ) { ?>
                        <div class="alert alert-danger alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                          <strong>Warning!</strong> Usuario o password no corresponden.
                        </div>
                       <?php } ?>    
                      
            
                  </form>          
            </div>
            <div class="col-sm-4">
            </div>              
        </div>
        
    </div>
    <br><br>
 <?php include "footer.php"; ?>   
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>    
<script>
    $(document).ready(function() {
       // alert("ready!" );
        $("#rutusu").keyup(function() {
            var rut = $("#rutusu").val();
            var rutFormato = formatoRut( rut );
            //alert( rutFormato );
            document.getElementById("rutusu").value= rutFormato;
            
            
        });
    });

function formatoRut( rut ) {
    var x = rut
    x = x.replace('-','');
    x = x.replace('.','');
    //alert( x );
    
    var largo = x.length;
    var rutReform = "";
    if( largo >1 ){    
        var rut_    = "";
        var rut__   = "";
        var digito_ = "";
        
        //alert( x );
        rut_ = x.substr(0,largo-1);
        rut__ = new Intl.NumberFormat().format( rut_);
        //alert( rut__);
        digito_ = x.substr(-1);
        rutReform = rut__ + "-" + digito_;
    } else {
        rutReform = x;
    }
    //alert(rut + " * " + digito);
    
    return rutReform; 
}


function validOnBlurRut(){
    
    var rut = $("#rutusu").val();
    var largoRut = rut.length;
    //alert("largoRut:"+largoRut);
    if( rut.length > 0 ) {
       // alert("valida OnBlur rut");
        if( !checkRut(rut) ) {
            alert("Rut ingreasdo es invalido ...!");
             //document.getElementById("rutusu").value= "";
            document.getElementById("rutusu").style.borderColor="#ff0000";
            //document.getElementById("rutusu").focus();
        }  else {
             document.getElementById("rutusu").style.borderColor="#000000";
        }     
    }

    
}


function checkRut(rut) {
    // Despejar Puntos
    var valor = rut.replace(/\./g,'');
    // Despejar Guión
    valor = valor.replace('-','');
    
    //alert( "valorRut:" + valor);
    
    // Aislar Cuerpo y Dígito Verificador
    cuerpo = valor.slice(0,-1);
    dv = valor.slice(-1).toUpperCase();
    
    // Formatear RUN
    //rut.value = cuerpo + '-'+ dv
    
    // Si no cumple con el mínimo ej. (n.nnn.nnn)
    if(cuerpo.length < 7) { 
        return false;
    }
    
    // Calcular Dígito Verificador
    suma = 0;
    multiplo = 2;
    
    // Para cada dígito del Cuerpo
    for(i=1;i<=cuerpo.length;i++) {
    
        // Obtener su Producto con el Múltiplo Correspondiente
        index = multiplo * valor.charAt(cuerpo.length - i);
        
        // Sumar al Contador General
        suma = suma + index;
        
        // Consolidar Múltiplo dentro del rango [2,7]
        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
  
    }
    
    // Calcular Dígito Verificador en base al Módulo 11
    dvEsperado = 11 - (suma % 11);
    
    // Casos Especiales (0 y K)
    dv = (dv == 'K')?10:dv;
    dv = (dv == '0')?11:dv;
    
    //alert("dv"+dv+" dv esperado:"+dvEsperado);
    
    // Validar que el Cuerpo coincide con su Dígito Verificador
    if(dvEsperado != dv) {  return false; }
    
    // Si todo sale bien, eliminar errores (decretar que es válido)
    return true;
}
/*
Function ValidaRut(Dato) {
	cadena = right("000000000"&Dato.value, 9)
	j=4
	for i = 1 to 9
		cad = mid(cadena,i,1)
		h = cad * j
		suma = suma + h
		J=j-1
		if j < 2 then
			j = 7
		end if 
	next
	Resto = suma mod 11
	digito = 11 - resto
	L =  document.frm.dgvusu.value
	if digito = 11 then
		dgv = 0 
	elseif digito = 10 then
		dgv = "K"
	else
		dgv = digito
	end if
	if digito = 10 then 
		if lcase(dgv) <> lcase(L) then
			msgbox "Rut Incorrecto",vbexclamation,"Error"
			dato.focus
			dato.select
			exit function
		end if 
	else
		if lcase(L) <> lcase(dgv) then
			msgbox "Rut Incorrecto",vbexclamation,"Error"
			dato.focus
			dato.select
			exit function
		end if 
	end if 
}
*/

function validar() {
    //alert("validar");

    if (document.frm.rutusu.value == ""){
			alert("El Rut no puede estar vacio");
			return false;
	}
	
	var rut = $("#rutusu").val();
	//alert("valida rut:"+rut);
    if( rut.lenght > 0 ) {
        //alert( "check rut:"+ rut);    
        if( !checkRut(rut) ) {
            alert(">Rut ingreasdo es invalido ...!");
             //document.getElementById("rutusu").value= "";
            document.getElementById("rutusu").style.borderColor="#ff0000";
            //document.getElementById("rutusu").focus();
        }  else {
             document.getElementById("rutusu").style.borderColor="#000000";
        }      
    }
	
	
	if (document.frm.password.value == "") {
			alert("Debe Ingresar la Password");
			document.frm.password.focus();
			return false;
	}
	if (document.frm.cbGrupo.value == "0"){
			alert("Debe seleccionar el grupo del usuario");	
			document.frm.cbGrupo.focus();
			return false;
	}
    //alert("ok");
    //document.accion.valu = "loginCtrl.php";
    //document.frm.accion.value = "loginCtrl.php";
	//document.frm.submit();
	document.getElementById("frm").action = "loginCtrl.php";
	document.getElementById("frm").submit();
	//return true;
    
}
</script>
</body>
</html>