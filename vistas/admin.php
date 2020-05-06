<!doctype html>
<html>
<head>
<title>Admin</title>    
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">      
<link rel="stylesheet" href="css/styles.css">
</head>    
<?php
session_start();
$rutusu = $_SESSION['rutusu'];



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

$nombreUsuario = getNombreUsuario( $rutusu  );

$sql  = " Select me.Nombre, me.jerarquia, me.sistema, me.carpeta ";
$sql .= " from tl_menu me ";
$sql .= " inner join tl_permiso per on (per.jerarquia = me.jerarquia) ";
$sql .= " where me.carpeta = 'S' ";
$sql .= " and me.Tipo='P' ";
$sql .= " and per.id_grupo='33' ";
$sql .= " order by me.jerarquia ";
//echo "<br>Men".$sql;
$database = new Connection();
$db = $database->openConnection();
$result = $db->query($sql);
$i= 0;
if( $result ) {
     foreach ($result as $row) {
         $Menu['nombre'][$i]    = $row['Nombre'];
         $Menu['jerarquia'][$i] = $row['jerarquia'];
         $Menu['sistema'][$i]   = $row['sistema'];
         //echo "<br>".$row['Nombre']. " ". $row['jerarquia']. " ". $row['sistema'];
         $i++;
     }
}
$iMenuMax = $i;
$vv = 0;
$iSubMenu = 0;
?>
<body>
    <?php include "header.php"; ?>
 
   <div class="container">
        <div class="row center">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4 my-3">
                    <h5>ADMIN</h5>  
                    <h6><?php echo $rutusu. " - " . $nombreUsuario?></h6>
            </div>
            <div class="col-sm-4">
                <form name="frmSalir" id="frmSalir" action="controlador.php" method="POST"><input type="submit" name="btnSalir" value="Salir"><input type="hidden" name="accion" value="salir"></form>
            </div>            
        </div>
    </div>
    
    
   <div class="container">
       <div class="row">
            <div class="col-sm-3">
                Menu
                <table cellpadding="0" cellspacing="0" border="0" width="70%">
                	<tr>
                		<td colspan="2" align="center"><font face="Tahoma" size="2"><b><a href="centro.asp" target="mainFrame" class="Menu">Menu</a></b></font></td>
                	</tr>

                	<?php for($i=0; $i< $iMenuMax; $i++ ) {?>
                	<tr>
                		<td width="2%"><a href="#"><img src="images/carpeta.png" id="ima" onClick="javascript:Abre(<?php echo $i ?>)" style="cursor:hand" width="25" height="25"></a></td>
                		<td><font face="Tahoma" size="2">&nbsp;<?php echo  $Menu['nombre'][$i] ?></font></td>
                	</tr>
                	
                	<tr>
              	    	<td colspan="2">
			       <?php
			
    				 $sql  = " Select nombre,  me.jerarquia, url, glosa, carpeta from tl_menu me ";
    				 $sql .= " inner join tl_permiso per on (per.jerarquia = me.jerarquia)";
    				 $sql .= " where Tipo='S' and left(me.jerarquia,2) ='". substr($Menu['jerarquia'][$i],0,2) ."'";
    				 $sql .= " and per.id_grupo='".$_SESSION['id_grupop']."'";
    				 $sql .= " order by NOMBRE ";
    				// echo "subMenu:".$sql;
    				 $result_2 = $db->query($sql);
    				 $iSubM= 0;
                    if( $result_2 ) {
                         foreach ($result_2 as $row) {
                             $SubMenu['nombre'][$iSubM]    = $row['nombre'];
                             $SubMenu['jerarquia'][$iSubM] = $row['jerarquia'];
                             $SubMenu['url'][$iSubM]       = $row['url'];
                             $SubMenu['glosa'][$iSubM]     = $row['glosa'];
                             $SubMenu['carpeta'][$iSubM]   = $row['carpeta'];
                             //echo "<br>". $SubMenu['nombre'][$iSubM];
                             $iSubM++;
                         }
                    }
                    $iSubMenuMax = $iSubM;
				 
			       ?>
                	  	<table id="submenu" style="display:none" width="100%">		
                	  		<?php if(  $iSubMenuMax > 0  ) { 
                	  		    for( $z = 0; $z < $iSubMenuMax; $z++ ) {
                	  		         //echo "SubMenu::".$SubMenu['carpeta'][$z];
                	  		        if(  strcmp($SubMenu['carpeta'][$z],"N") == 0  ) { ?>
                	  		          <tr>							
							           <td width="2%" nowrap><font face="Tahoma" size="1">&nbsp;</font></td>
							           <td width="2%" nowrap><font face="Tahoma" size="1">--</font></td>
							           <td><font face="Tahoma" size="1">
							              <a href='javaScript:opciones("<?php echo $SubMenu['url'][$z]?> ")'><?php echo $SubMenu['nombre'][$z]?></a>
							            </font></td>
						              </tr>
						          <?php    
                	  		         } 
                	  		         if( strcmp($SubMenu['carpeta'][$z],"S") == 0) {
                	  		       ?>
                	  		       <tr>

	        						<td width="2%" nowrap><font face="Tahoma" size="1">&nbsp;</font></td>
			         				<td width="2%" nowrap><font face="Tahoma" size="1">
			         				    <?php $izImag = "".$i."-".$z.""; ?>
			         				    <?php $izParam = "'".$i."-".$z."'"; ?>
			         				   <a href="#"><img src="images/carpeta.png" id="imaS" onClick="javascript:AbreS(<?php echo $iSubMenu++?>)" style="cursor:hand" height="20"></a></font></td>
					         		<td><font face="Tahoma" size="1"><?php echo $SubMenu['nombre'][$z]?></font></td>
       						       </tr>
                                   <tr>
							           <td colspan="4">
						               <?php 
            	                          $sql  = " Select nombre,  me.jerarquia, url, glosa, carpeta from tl_menu me ";
            				  			  $sql .= " inner join tl_permiso per on (per.jerarquia = me.jerarquia)  ";
            				 			  $sql .= " where Tipo='SS' and left(me.jerarquia,3) = '".  substr($SubMenu['jerarquia'][$z],0,3) ."'";
            				 			  $sql .= " and per.id_grupo='".$_SESSION['id_grupop']."'";
            							  $sqk .= " order by NOMBRE ";
            							 // echo $sql;
	                        
                                            $result_3 = $db->query($sql);
                                            $iSubSubM= 0;?>
                                            
                                            <?php
                                            if( $result_3 ) {
                                               //echo "****";
                                                foreach ($result_3 as $row) {
                                                 $SubSubMenu['nombre'][$iSubSubM]    = $row['nombre'];
                                                 $SubSubMenu['jerarquia'][$iSubSubM] = $row['jerarquia'];
                                                 $SubSubMenu['url'][$iSubSubM]       = $row['url'];
                                                 $SubSubMenu['glosa'][$iSubSubM]     = $row['glosa'];
                                                 $SubSubMenu['carpeta'][$iSubSubM]   = $row['carpeta'];
                                                // echo "<br>>>>". $SubSubMenu['carpeta'][$iSubSubM];
                                                 $iSubSubM++;
                                                }
                                            }
                                            $iSubSubMenuMax = $iSubSubM;
                                            ?>
                                          <table id="submenuS" style="display:none" width="100%">
                                            <?php
                                            if( $iSubSubMenuMax > 0 ) {
                                                for( $vn = 0; $vn < $iSubSubMenuMax; $vn++ ) { 
                                                    //echo "SubSubMenu Carpeta/Enlace:".$SubSubMenu['carpeta'][$vn].":";
                                                     if(  strcmp($SubSubMenu['carpeta'][$vn],"N") == 0  ) {    ?>
                                                    <tr>
                										<td width="2%" nowrap><font face="Tahoma" size="1">&nbsp;</font></td>
                										<td width="2%" nowrap><font face="Tahoma" size="1">&nbsp;&nbsp;&nbsp;&nbsp;</font></td>
                										<td width="2%" nowrap><font face="Tahoma" size="1">--</font></td>
                										<td><font face="Tahoma" size="1">
                										<a href='javaScript:opciones("<?php echo $SubSubMenu['url'][$vn]?> ")'><?php echo $SubSubMenu['nombre'][$vn]?></a>
                									    </font></td>
                									</tr>
                                                   <?php
                                                     } 
                                                     if(  strcmp($SubSubMenu['carpeta'][$vn],"S") == 0  )  {
                                                         ?>
                                                      <tr>
                    	        						<td width="2%" nowrap><font face="Tahoma" size="1">&nbsp;</font></td>
                    			         				<td width="2%" nowrap><font face="Tahoma" size="1"><img src="images/carpeta.png" id="imaS" onClick="javascript:AbreS(<?php echo $vv++?>)" style="cursor:hand" height="11"></font></td>
                    					         		<td><font face="Tahoma" size="1"><?php echo $SubSubMenu['nombre'][$z]?></font></td>
                           						      </tr>
                           						 <?php      
                                                     }
                                                }//for
                                               
                                            } // if
                	                        ?>
                                           </table>
                	  		       <?php      
                	  		         }
                	  		          
                	  		    }
                	  		 } ?>
                	  	    
                	    </table>
	              </td>
	                </tr>
	                
	              <?php } ?>
                </table>
           </div>
            <div class="col-sm-9">
                    
                    <div id="div_contenido">
                        <iframe name="frame-centro" id="frame-centro" src="adminPpal.php" frameborder="0" height="400" width="900" scrolling="auto" class="iframe-full-height"></iframe>
                    </div>
            </div>
        </div>
   </div>       

<br><br>    
	<?php include "footer.php"; ?>    
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>                  
<script>
$( document ).ready(function() {
    //alert( "ready!" );
     //$("#frame-centro").load("adminPpal.php");
     $("#frame-centro").src = "https://wwf.org";
     
});

function Abre(id){
    
    //document.all.ima[id].src = "images/open.png";
   	if (this.document.all.submenu[id].style.display == '') 	{
   	   // alert("abierta");
		this.document.all.submenu[id].style.display = 'none';
		document.all.ima[id].src = "images/carpeta.png";
	} else {
	   // alert("cerrada");
		this.document.all.submenu[id].style.display = '';
		document.all.ima[id].src = "images/open.png";
	}
			
}


function AbreS(id)  {
    //alert("subM"+id);
    if (this.document.all.submenuS[id].style.display == '') 	{
   	    //alert("abierta");
		this.document.all.submenuS[id].style.display = 'none';
		document.all.imaS[id].src = "images/carpeta.png";
	} else {
	   // alert("cerrada");
		this.document.all.submenuS[id].style.display = '';
		document.all.imaS[id].src = "images/open.png";
	}
			
		
}

   
function opciones( item )  {
    var _item_ = item.replace('asp','php');
   // alert( _item_ );
   // $("#frame-centro").load( "/Parametros/Ejecutivo/Mantenedor.php" );
    //document.getElementById('frame-centro').load( "Parametros/Ejecutivo/Mantenedor.php");
    //$("#frame-centro").load("https://www.google.com");
    document.getElementById("frame-centro").src = _item_;
    /*
    $.ajax({
        type: "GET",
        url:  _item_,
        success: function(datos) {
            $("#div_contenido").load(datos);
        }
    });
    */
    /*
    $.ajax({
       type: "GET",
       url:  _item_
    }).done( function( datos ) {
        $("#div_contenido").load(datos);
    }).fail( function() {
        alert( 'Error!!' );
    }).always( function() {
        alert( 'Always' );
    });
   */
}
</script>
</body>    
    
</html>