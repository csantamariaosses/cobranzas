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
// echo $sql;
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
	  		<?php if(  $iSubM > 0  ) { 
	  		    //echo "<br>Hola";
	  		    for( $z = 0; $z < $iSubMenuMax; $z++ ) {
	  		        //echo "<br>".$SubMenu['carpeta'][$z];
	  		        if(  strcmp($SubMenu['carpeta'][$z],"N") == 0  ) { ?>
	  		          <tr>							
			           <td width="2%" nowrap><font face="Tahoma" size="1">&nbsp;</font></td>
			           <td width="2%" nowrap><font face="Tahoma" size="1">--</font></td>
			           <td><font face="Tahoma" size="1">
			           <a href='javaScript:opciones("<?php echo $SubMenu['url'][$z]?> ")'><?php echo $SubMenu['nombre'][$z]?></a>
			           <a href="<?php echo  $SubMenu['url'][$z]?>" target="formularios"><?php echo $SubMenu['nombre'][$z]?></a>
			           
			            </font></td>
		              </tr>
		          <?php    
	  		         }
	  		    }
	  		 } ?>
	  	    
	    </table>
  </td>
    </tr>
  <?php } ?>
</table>