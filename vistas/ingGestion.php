<!doctype html>
<html>
<head>
    <title></title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">      
<link rel="stylesheet" href="css/styles.css">      
</head>    
<?php
session_start();
if(!isset($_SESSION['rutusu'])) { 
    $rutusu = $_SESSION['rutusu'];
    if( strcmp($rutusu,"") == 0) {
        echo "sesion expirada";
        echo "<br>reconectar <a href='https://www.slcltda.cl/cobranza/vistas/index.php'>aqui</a>";
        exit();        
    }

}

require_once("Connection.php");
require_once("funcionesADO.php");

 

$rutusu = $_SESSION['rutusu'];
$rutusu = $_POST['rutusu'];
$id_deudor = $_POST['id_deudor'];
$id_rut_deudor = $_POST['id_rut_deudor'];
$id_deudor = $_POST['id_deudor'];
$id_cedente = $_POST['id_cedente'];
$id_campana = $_POST['id_campana'];
$id_remesa = $_POST['id_remesa'];

//echo "<br>rutusu:" . $rutusu;
//echo "<br>id_deudor:" . $id_deudor;
//echo "<br>id_rut_deudor:" . $id_rut_deudor;



//echo "<br>id_deudor:" . $id_deudor;
//echo "<br>id_cedente:" . $id_cedente;
//echo "<br>id_campana:" . $id_campana;
//echo "<br>id_remesa:" . $id_remesa;

$nombreEjecutivo = getNombreEjecutivo( $rutusu );
$nombreDeudor    = getNombreDeudor( $id_rut_deudor);
$nombreCampana   = getNombreCampana( $id_campana  );
                   


function fnCbTipoGestion() {
    $arrTipoGestion = getTipoGestion();
    echo "<option value='0'>Seleccione...</option>";
    foreach($arrTipoGestion as $row ) {
        echo "<option value='" .$row['id_gestion']."'>". $row['id_gestion']. "-". $row['nombre_gestion']."</option>";
    }
}



function fnCbOrigenLlamada() {
    $arrTipoGestion = origenLlamada();
    echo "<option value='0'>Seleccione...</option>";
    foreach($arrTipoGestion as $row ) {
        echo "<option value='" .$row['id_origen_llamada']."'>".$row['id_origen_llamada']."-". $row['nombre_origen_llamada']."</option>";
    }
}


function fnCbResultadoDeLaGestion() {
  $arr = getResultadoDeLaGestion();
  echo "<option value='0'>Seleccione...</option>";
  foreach( $arr as $row ) {
     echo "<option value='" .$row['id_codigo_gestion']."'>".$row['id_codigo_gestion']."-".$row['nombre_codigo']."</option>";
  }    
}


function fnCbFonosContacto( $id_rut_deudor ) {
    $arr = listTelefonosDeudor($id_rut_deudor);
    echo "<option value='0'>Seleccione...</option>";
    foreach( $arr as $row ) {
       echo "<option value='" .$row['id_telefono']."'>[".$row['id_telefono']."]".$row['area']. "-".$row['telefono']."-".$row['NOMBRE_ESTADO_TELEFONO']."</option>";
    }    
}

function fnCbAreasTelefonicas(){
    $arr = listAreasTelefonicas();
    echo "<option value='0'>Seleccione...</option>";
    foreach( $arr as $row ) {
       echo "<option value='" .$row['area']."'>".$row['area']."</option>";
    }
}



function fnCbDireccionDeContacto( $id_deudor ) {
    $arr  = getListadoDireccion( $id_deudor );

    echo "<option value='0'>Seleccione...</option>";
    foreach( $arr as $row ) {
       echo "<option value='" .$row['id_direccion']."'>[".$row['id_direccion']."]".$row['direccion']."</option>";
    }    
}


function fnCbEmailDeContacto( $id_rut_deudor ) {
    $arr  = getEmailContacto( $id_rut_deudor );

    echo "<option value='0'>Seleccione...</option>";
    foreach( $arr as $row ) {
       echo "<option value='".$row['id_mail']."'>[".$row['id_mail']."]".$row['email']."</option>";
    }        
}


function fnCbTipoTelefono(){
    $arr  = getTipoTelefono();

    echo "<option value='0'>Seleccione...</option>";
    foreach( $arr as $row ) {
       echo "<option value='".$row['ID_TELEFONO']."'>[".$row['ID_TELEFONO']."]".$row['NOMBRE_TELEFONO']."</option>";
    }        
}

function fnCbComuna(){
    $arr  = getComunas();

    echo "<option value='0'>Seleccione...</option>";
    foreach( $arr as $row ) {
       echo "<option value='".$row['nombre']."'>".$row['nombre']."</option>";
    }            
}

?>
<body>
    <?php include "header.php"; ?>
 
   <div class="container">
        <div class="row center">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4 my-3">
                    <h5>INGRESA GESTION</h5>                
            </div>
            <div class="col-sm-4">
                <form name="frmSalir" id="frmSalir" action="controlador.php" method="POST"><input type="submit" name="btnSalir" value="Salir"><input type="hidden" name="accion" value="salir"></form>
            </div>            
        </div>
    </div>    
    
    
    <div class="container">
        <div class="row center">
            <div class="col-sm-1">
            </div>
            <div class="col-sm-10">
                    <b>Ejecutivo:</b><?php echo $rutusu. " - " .$nombreEjecutivo?><br>
                    <b>Deudor:</b><?php echo $id_rut_deudor ." - ". $nombreDeudor;?><br>
                    <b>Campana:</b><?php echo $id_campana ." - ". $nombreCampana;?>
            </div>
            <div class="col-sm-1">
            
            </div>            
        </div>
    </div>
   
    <hr>
        <form name="frm" id="frm" action="guardaGestion.php" method="POST">
            <input type="hidden" name="id_deudor" id="id_deudor" value="<?php echo $id_deudor?>">
            <input type="hidden" name="id_rut_deudor" id="id_rut_deudor" value="<?php echo $id_rut_deudor?>">
            
            <input type="hidden" name="id_cedente" id="id_cedente" value="<?php echo $id_cedente?>">
            <input type="hidden" name="id_campana" id="id_campana" value="<?php echo $id_campana?>">
            <input type="hidden" name="id_remesa"  id="id_remesa" value="<?php echo $id_remesa?>">
            
        <div class="containe">
            <div class="row">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-6">
                    <table class="tabla-gestiones">
                        <tr><td>Tipo Gestion:</td><td><select name="cbTipoGestion"  id="cbTipoGestion" onChange="cbChangeTipoGestion(this.value);"><?php fnCbTipoGestion();?></select></td></tr>
                        <tr><td>Origen de Llamada:</td><td><select name="cbOrigenLlamada" id="cbOrigenLlamada"><?php fnCbOrigenLLamada();?></select></td></tr>
                        <tr><td>Resultado de la Gestion:</td><td><select name="cbRsultadoGestion" id="cbRsultadoGestion"  onChange="cbChangeResultadoGestion(this.value);"><?php fnCbResultadoDeLaGestion();?></select></td></tr>
                        <tr><td>Fono de Contacto:</td><td><select name="cbFonosContacto" id="cbFonosContacto"  onChange="cbChangeTelefono(this.value)"><?php fnCbFonosContacto( $id_rut_deudor );?></select><button type="button" class="btn btn-default" data-toggle="modal" data-target="#ModalNuevoFono">
<span style="font-size:12px;color:blue;">Nuevo Fono</span></button></td></tr>
                        
                        <tr><td>Direccion de Contacto:</td><td><select name="cbDireccionDeContacto" id="cbDireccionDeContacto"><?php fnCbDireccionDeContacto( $id_deudor );?></select><button type="button" class="btn btn-default" data-toggle="modal" data-target="#ModalNuevaDireccion"><span style="font-size:12px;color:blue;">Nueva Direccion</span></button></td></tr>
                        <tr><td>Email de Contacto:</td><td><select name="cbEmailDeContacto" id="cbEmailDeContacto"><?php fnCbEmailDeContacto( $id_rut_deudor );?></select><button type="button" class="btn btn-default" data-toggle="modal" data-target="#ModalNuevoEmail"><span style="font-size:12px;color:blue;">Nuevo Email</span></button></td></tr>
            
                    </table>
                   
                </div>
                <div class="col-sm-3">
                </div>                
            </div>
            <div class="row">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-6">
                    <input type="button" name="btnSubmit" value="Siguiente" onClick="validar();">             
                </div>
                <div class="col-sm-3">
                </div>
            </div>
        </div>    
       
        </form>

    <br><br>
    
    
    <!-- Modal Nuevo Fono-->
<div class="modal fade" id="ModalNuevoFono" tabindex="-1" role="dialog" aria-labelledby="ModalNuevoFonoTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalNuevoFonoTitle">Nuevo Telefono</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <table>
              <tr><td>Telefono</td><td><select name="areaNuevoFono" id="areaNuevoFono"><? fnCbAreasTelefonicas();?></select><input type="text" name="telefonoNuevo" id="telefonoNuevo"></td></tr>
              <tr><td>Tipo Telefono:</td><td><select name="tipoTelefono" id="tipoTelefono" ><? fnCbTipoTelefono();?></select></td></tr>
          </table>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onClick="guardaNuevoFono();">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Nueva Direccion-->
<div class="modal fade" id="ModalNuevaDireccion" tabindex="-1" role="dialog" aria-labelledby="ModalNuevaDireccionTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Nueva Direccion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <table>
                <tr><td>Direccion:</td><td><input type="text" name="direccion" id="direccion" size="30"></td></tr>
                <tr><td>Comuna:</td><td><select name="cbComunas" id="cbComunas" ><? fnCbComuna();?></select></td></tr>              
          </table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary"  data-dismiss="modal" onClick="guardaNuevaDireccion(<?php echo $rutusu?>);">Save changes</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal Nuevo Email-->
<div class="modal fade" id="ModalNuevoEmail" tabindex="-1" role="dialog" aria-labelledby="ModalNuevoEmailTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Nuevo Email</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" name="email" id="email">@<input type="text" name="emailDominio" id="emailDominio">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onClick="guardaNuevoEmail(<?php echo $rutusu?>);">Save changes</button>
      </div>
    </div>
  </div>
</div>
	<?php include "footer.php"; ?>    
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>              
<script>

$(document).ready( function(){
   //alert("hola");

});

function validar(){
    var tipoGestion = document.getElementById("cbTipoGestion").value;
    var cbOrigenLlamada = document.getElementById("cbOrigenLlamada").value;
    var cbRsultadoGestion = document.getElementById("cbRsultadoGestion").value;
    var cbFonosContacto = document.getElementById("cbFonosContacto").value;
    var cbDireccionDeContacto = document.getElementById("cbDireccionDeContacto").value;
    var cbEmailDeContacto = document.getElementById("cbEmailDeContacto").value;
    
    if( tipoGestion == "0" ) {
        alert("Debe seleccionar el Tipo de Gestion");
        return false;
    }
    if( cbOrigenLlamada == "0" ) {
        alert("Debe seleccionar el Origen de la Llamada");
        return false;
    }
    if( cbRsultadoGestion == "0" ) {
        alert("Debe seleccionar el Resultado de la gestion");
        return false;
    } 
    //alert("ok...");
    document.frm.submit();
   
}    

var tipoGestion = "";
var resultadoGestion = "";
var idTelefono = 0;
function cbChangeTipoGestion( valor) {
    //alert("cambio Tipo Gestion."+valor);
    tipoGestion = valor;
    
}


function cbChangeTelefono( valor ) {
    idTelefono = valor ;
    //alert("fonoCtto"+idTelefono);
}


function cbChangeResultadoGestion( valor ){
    //alert("cambio Resultado de la Gestion:"+valor);
    resultadoGestion = valor;
    
    //alert("tipo:"+tipoGestion+ " result:"+ resultadoGestion); 
    
    //if( tipoGestion == 1 and  resultadoGestion != 14  and resultadoGestion != 10 and numero_fono == 0  ) {
        
	   //echo "<script>alert('Favor seleccionar Teléfono...');";
	   //echo "javascript:history.back(1);";
	  
	   
    //}
    if( tipoGestion == 1 && idTelefono == 0 ) {
        //alert("tipoGestion = 1 ");
    }
    
    
}


function mostrarNuevoFono(){
     $('#idNuevoFono').show();
}


function guardaNuevoFono(){
     var nuevaArea = $("#areaNuevoFono").val();
     var nuevoFono = $("#telefonoNuevo").val();
     var id_rut_deudor = $("#id_rut_deudor").val();
     //alert("rut:"+id_rut_deudor+" area:"+nuevaArea + " fono:"+nuevoFono)
     //$('#ModalNuevoFono').modal('hide');
     
     $.ajax({
        // En data puedes utilizar un objeto JSON, un array o un query string
        data: {
           "id_rut_deudor" : id_rut_deudor,
           "nuevaArea" : nuevaArea,
           "nuevoFono" : nuevoFono,
        },
        //Cambiar a type: POST si necesario
        type: "POST",
        // Formato de datos que se espera en la respuesta
        dataType: "text",
        // URL a la que se enviará la solicitud Ajax
        url: "testNuevoFono.php",
    })
     .done(function( data ) {
          //alert("ya existe:"+data);
          if( data == 0 ) {
              //alert("agregar fono")
              $.ajax({
                 data:{
                     "rut"       : id_rut_deudor,
                     "nuevaArea" : nuevaArea,
                     "nuevoFono" : nuevoFono,
                 },
                //Cambiar a type: POST si necesario
                type: "POST",
                // Formato de datos que se espera en la respuesta
                dataType: "text",
                // URL a la que se enviará la solicitud Ajax
                url: "getMaxIdTelefonos.php",
              })
              .done(function( data ) {
                  //alert( "ultimo id:"+data );
                  
                  var id_telefono = eval(data)+1;
                  var id_tipo_telefono=1;
                  var id_estado_telefono = 1;
                  var cod_ult_gestion = 1;
                  var cod_ult_gestion = 1;
                  
                
                  $.ajax({
                    data:{
                      "id_rut_deudor"       : id_rut_deudor,
                      "nuevaArea" : nuevaArea,
                      "nuevoFono" : nuevoFono,
                      "id_telefono"        : id_telefono,
                      "id_tipo_telefono"   : id_tipo_telefono,
                      "id_estado_telefono" : id_estado_telefono,

                    },
                    //Cambiar a type: POST si necesario
                    type: "POST",
                    // Formato de datos que se espera en la respuesta
                    dataType: "text",
                    // URL a la que se enviará la solicitud Ajax
                    url: "agregaNuevoFono.php",
                  })
                  .done(function( data ) {
                      //alert( "status insert:"+data );
                      if( eval(data) == 1 ){
                          //alert( "if status insert:"+ data)
                          var newTelef = "["+id_telefono+"]"+nuevaArea+"-"+nuevoFono;
                          //alert("nuevoTelef:"+newTelef);
                          
                          $("#cbFonosContacto").append($("<option></option>")
                               .attr("value",id_telefono)
                               .text(newTelef));
                          //$('#ModalNuevoFono').hide();
                          
                      }
                  })
                  .fail(function( jqXHR, textStatus, errorThrown ) {
                     if ( console && console.log ) {
                        console.log( "La solicitud a fallado: " +  textStatus);
                     }
                  });
                  
                  
                  
              })
             .fail(function( jqXHR, textStatus, errorThrown ) {
                 if ( console && console.log ) {
                     console.log( "La solicitud a fallado: " +  textStatus);
                 }         
             });
             
              
          } 
          if( data >= 1 ) {
             alert("fono ya existe")
          } 
         
     })
     .fail(function( jqXHR, textStatus, errorThrown ) {
         if ( console && console.log ) {
             console.log( "La solicitud a fallado: " +  textStatus);
         }
    });
    
}


function guardaNuevoEmail( rutusu ){
    //alert("guarda nuevo email");
    
     var nuevoEmail = $("#email").val();
     var nuevoEmailDominio = $("#emailDominio").val();
     var id_rut_deudor = $("#id_rut_deudor").val();
     var nuevoEmail_ = nuevoEmail +"@"+ nuevoEmailDominio;
     //alert("rut:" + id_rut_deudor + "nuevoEmail"+nuevoEmail_);
     /*
     if( testNuevoEmail(id_rut_deudor, nuevoEmail_) > 0 ) {
         alert("Ya existe ");
     } else {
         alert("Nuevo");   
     }
     */

     
     $.ajax({
        // En data puedes utilizar un objeto JSON, un array o un query string
        data: {
           "id_rut_deudor" : id_rut_deudor,
           "nuevoEmail" : nuevoEmail_,
        },
        //Cambiar a type: POST si necesario
        type: "POST",
        // Formato de datos que se espera en la respuesta
        dataType: "text",
        // URL a la que se enviará la solicitud Ajax
        url: "testNuevoEmail.php",
    })
     .done(function( data ) {
          //alert("data:"+data);
          
          if( eval(data) == 0 ) {
              //alert("agregar Email")
              
              $.ajax({
                 data:{
                     "rut"       : id_rut_deudor,
                     "nuevoEmail" : nuevoEmail_,
                 },
                //Cambiar a type: POST si necesario
                type: "POST",
                // Formato de datos que se espera en la respuesta
                dataType: "text",
                // URL a la que se enviará la solicitud Ajax
                url: "getMaxIdEmail.php",
              })
              .done(function( data ) {
                  //alert( "ultimo id:"+data );
                  //alert( "rutusu:"+ rutusu );
                  
                  var id_email = eval(data)+1;
                  var id_estado = 1;

                  $.ajax({
                    data:{
                      "id_email"  : id_email,
                      "rut"       : id_rut_deudor,
                      "email"     : nuevoEmail_,
                      "loginIngreso" : rutusu,
                      "id_estado" : id_estado,

                    },
                    //Cambiar a type: POST si necesario
                    type: "POST",
                    // Formato de datos que se espera en la respuesta
                    dataType: "text",
                    // URL a la que se enviará la solicitud Ajax
                    url: "agregaNuevoEmail.php",
                  })
                  .done(function( data ) {
                      //alert( "*** status insert:"+data );
                      if( eval(data) == 1 ){
                          //alert( "if status insert:"+ data)
                          var newEmail = "["+id_email+"]"+nuevoEmail_;
                          //alert("nuevoTelef:"+newTelef);
                          //alert("agrega email a cb valor:"+id_email+ " texto:"+newEmail);
                          $("#cbEmailDeContacto").append($("<option></option>")
                               .attr("value",id_email)
                               .text(newEmail));
                          //alert("agregado email a cb");
                      }
                      
                  })
                  .fail(function( jqXHR, textStatus, errorThrown ) {
                     if ( console && console.log ) {
                        console.log( "La solicitud a fallado: " +  textStatus);
                     }
                  });
                 
                  
                  
              })
             .fail(function( jqXHR, textStatus, errorThrown ) {
                 if ( console && console.log ) {
                     console.log( "La solicitud a fallado: " +  textStatus);
                 }         
             });
             
            
              
          } 
          if( eval(data) >= 1 ) {
             alert("Email ya existe");
          } 
         
     })
     .fail(function( jqXHR, textStatus, errorThrown ) {
         if ( console && console.log ) {
             console.log( "La solicitud a fallado: " +  textStatus);
         }
    });
    

    
}



function guardaNuevaDireccion( rutusu ){
    //alert("guarda nueva direccion");
    
     var nuevaDireccion = $("#direccion").val();
     var nuevaComuna = $("#cbComunas").val();
     var id_rut_deudor = $("#id_rut_deudor").val();
     
     //alert("rut:" + id_rut_deudor + "nuevaDireccion:"+nuevaDireccion + " comuna:"+ nuevaComuna);

   
     $.ajax({
        // En data puedes utilizar un objeto JSON, un array o un query string
        data: {
           "id_rut_deudor" : id_rut_deudor,
           "nuevaDireccion" : nuevaDireccion,
           "nuevaComuna" : nuevaComuna,
        },
        //Cambiar a type: POST si necesario
        type: "POST",
        // Formato de datos que se espera en la respuesta
        dataType: "text",
        // URL a la que se enviará la solicitud Ajax
        url: "testNuevaDireccion.php",
    })
     .done(function( data ) {
          //alert("test Nueva Direccion:"+data);
          
          if( eval(data) == 0 ) {
              //alert("agregar Direccion");
              
              $.ajax({
                 data:{
                     "rut"            :id_rut_deudor,
                     "nuevaDireccion" :nuevaDireccion,
                     "nuevaComuna"    :nuevaComuna,
                 },
                //Cambiar a type: POST si necesario
                type: "POST",
                // Formato de datos que se espera en la respuesta
                dataType: "text",
                // URL a la que se enviará la solicitud Ajax
                url: "getMaxIdDireccion.php",
              })
              .done(function( data ) {
                  //alert( "ultimo id:"+data );
                  //alert( "rutusu:"+ rutusu );
                  
                  var id_direccion = eval(data)+1;
                  var id_estado = 1;

                   
                  $.ajax({
                    data:{
                      "rut"          : id_rut_deudor,
                      "id_direccion" : id_direccion,
                      "direccion"    : nuevaDireccion,
                      "comuna"       : nuevaComuna,
                      "loginIngreso" : rutusu,
                      "id_estado"    : id_estado,
                    },
                    //Cambiar a type: POST si necesario
                    type: "POST",
                    // Formato de datos que se espera en la respuesta
                    dataType: "text",
                    // URL a la que se enviará la solicitud Ajax
                    url: "agregaNuevaDireccion.php",
                  })
                  .done(function( data ) {
                      //alert( "*** status insert:"+data );
                      
                      if( eval(data) == 1 ){
                          
                          var nuevaDireccion_ = "["+id_direccion+"]"+nuevaDireccion+" - "+nuevaComuna;
                          //alert("agrega direccion a cb valor:"+id_direccion + " texto:"+nuevaDireccion_ );
                          $("#cbDireccionDeContacto").append($("<option></option>")
                               .attr("value",id_direccion)
                               .text( nuevaDireccion_ ));
                          //alert("agregado direccion a cb");
                      }
                      
                      
                  })
                  .fail(function( jqXHR, textStatus, errorThrown ) {
                     if ( console && console.log ) {
                        console.log( "La solicitud a fallado: " +  textStatus);
                     }
                  });
                 
              })
             .fail(function( jqXHR, textStatus, errorThrown ) {
                 if ( console && console.log ) {
                     console.log( "La solicitud a fallado: " +  textStatus);
                 }         
             });
             
            
              
          } 
          if( eval(data) >= 1 ) {
             alert("Direccion  ya existe");
          } 
          
         
         
     })
     .fail(function( jqXHR, textStatus, errorThrown ) {
         if ( console && console.log ) {
             console.log( "La solicitud a fallado: " +  textStatus);
         }
    });
    

    
}


function testNuevoEmail(id_rut_deudor, nuevoEmail_){
    
    alert("testNuevoEmail:"+id_rut_deudor+" email:"+nuevoEmail_)
    var test = 0;
    $.ajax({
        // En data puedes utilizar un objeto JSON, un array o un query string
        data: {
           "id_rut_deudor" : id_rut_deudor,
           "nuevoEmail" : nuevoEmail_,
        },
        //Cambiar a type: POST si necesario
        type: "POST",
        // Formato de datos que se espera en la respuesta
        dataType: "text",
        // URL a la que se enviará la solicitud Ajax
        url: "testNuevoEmail.php",
    })
     .done(function( data ) {
         return eval( data );
    })
    .fail(function( jqXHR, textStatus, errorThrown ) {
         if ( console && console.log ) {
             console.log( "La solicitud a fallado: " +  textStatus);
         }
    });

}
</script>    
</body>
</html>