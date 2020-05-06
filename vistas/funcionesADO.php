<?php

function existeUsuario($rutusu , $password , $grupo ) {
    try {
            $database = new Connection();
            $db = $database->openConnection();
            $sql = "SELECT id_grupo, nom_grupo FROM tl_grupo order by nom_grupo ";
            
            
            $conteo = 0;
            $sql  = " SELECT count(usu.id ) as conteo ";
            $sql .= " FROM tl_usu_grupo  usgr ";
            $sql .= "  inner join tl_usuarios usu on (usu.rut = usgr.RUT_USUARIO) ";
            $sql .= "  inner join t_sucursales s on (usu.id_scrsl = s.id_scrsl) ";
    		$sql .= "  WHERE usu.id_estado_usuario = 1  ";
    		$sql .= "  and usgr.RUT_USUARIO='" .$rutusu."'";
    		$sql .= "  AND usgr.ID_GRUPO_USU='".$grupo . "' ";
    		$sql .= "  and usu.clave='". $password."'";
            
        
            //echo "<br>sql:" . $sql;    
            $result = $db->query($sql);
        
            //echo "<br/>";

            if( $result ) {
                if( !empty( $result )) {
                    foreach ($result as $row) {
                        $conteo = $row['conteo'];
                    }
                }
              
            } 
            return $conteo;

    } catch (PDOexception $e) {
            echo "Error is: " . $e-> etmessage();
    }
}


function getInfoUser($rutusu) {
    try {
     $database = new Connection();
            $db = $database->openConnection();
            $sql = "SELECT id_grupo, nom_grupo FROM tl_grupo order by nom_grupo ";
            
            
            
            $sql  = " SELECT usgr.rut_usuario, usgr.id_grupo_usu, usgr.id_estado_usu_grupo, usgr.fecha_asig,";
            $sql .= " usu.id, usu.rut, usu.dgv, usu.nombre, usu.clave, usu.id_estado_usuario, usu.correo, usu.online, ";
            $sql .= " usu.ID_CRG, usu.ID_SCRSL, usu.login, usu.telefono, ";
            $sql .= " s.ID_SCRSL, s.DES_SCRSL, s.ID_ESTADO, s.DRCC_SCRSL, s.ID_COMUNA, s.TLFN_SCRSL, s.FAX_SCRSL, ";
            $sql .= " s.NOMB_NCGD, s.id_sucu_ant, s.correo, usu.anexo ";
            $sql .= " FROM tl_usu_grupo  usgr ";
            $sql .= "  inner join tl_usuarios usu on (usu.rut = usgr.RUT_USUARIO) ";
            $sql .= "  inner join t_sucursales s on (usu.id_scrsl = s.id_scrsl) ";
    		$sql .= "  WHERE usu.id_estado_usuario = 1  ";
    		$sql .= "  and usgr.RUT_USUARIO='" .$rutusu."'";
    		$sql .= "  AND usgr.ID_GRUPO_USU='".$grupo . "' ";
    		$sql .= "  and usu.clave='". $password."'";
            
        
            //echo "<br>sql:" . $sql;    
            $result = $db->query($sql);
        
            //echo "<br/>";
            $id = 0;
            if( $result ) {
                return $result;
            } 
            $db = null;
    } catch (PDOexception $e) {
            echo "Error is: " . $e-> etmessage();
    }
    
}




function getNombreUsuario( $id_rut_usuario  ) {
    $nombreUsuario = "";
    $database = new Connection();
    $db = $database->openConnection();    
    $sql = " select nombre from tl_usuarios  where rut =" .$id_rut_usuario;
    //echo "<br>".$sql;
    $result = $db->query($sql);
    if( $result ) {
        foreach ($result as $row) {
            $nombreUsuario  = $row['nombre'];
        }
    }
    return $nombreUsuario;
    
}



function getNombreCedente( $id_cedente ) {
    $nombreCedente = "";
    $database = new Connection();
    $db = $database->openConnection();    
    $sql = " select cli_nombre from t_clientes where id_cliente =" .$id_cedente;
    $result = $db->query($sql);
    if( $result ) {
        foreach ($result as $row) {
            $nombreCedente  = $row['cli_nombre'];
        }
    }
    return $nombreCedente;
    
}


function getIdRemesa( $id_campana ) {
    $id_remesa = 0;
    $database = new Connection();
    $db = $database->openConnection();
    $remesa = "select id_remesa from t_campanas where id_campana=" . $id_campana;
    $result = $db->query($remesa);
    if( $result ) {
        foreach ($result as $row) {
            $id_remesa  = $row['id_remesa'];
        }
    }
    return $id_remesa;
}


function getNombreRemesa( $id_remesa  ) {
    $desc_remesa = "";
    $database = new Connection();
    $db = $database->openConnection();
    $remesa = "select desc_remesa from t_remesas  where id_remesa =" . $id_remesa;
    
    $result = $db->query($remesa);
    if( $result ) {
        foreach ($result as $row) {
            $desc_remesa  = $row['desc_remesa'];
        }
    }
    return $desc_remesa;
}



function getNombreCampana( $id_campana  ) {
    $nombreCampana = "";
    $database = new Connection();
    $db = $database->openConnection();
    $sql = "select campana from t_campanas where id_campana =" . $id_campana;
    $result = $db->query($sql);
    if( $result ) {
        foreach ($result as $row) {
            $nombreCampana  = $row['campana'];
        }
    }
    return $nombreCampana;
}



function getNombreDeudor( $id_rut_deudor ) {
    $nombreDeudor = "";
    $database = new Connection();
    $db = $database->openConnection();
    $sql = "select nombre from t_deudor where id_rut_deudor =" . $id_rut_deudor;
    $result = $db->query($sql);
    if( $result ) {
        foreach ($result as $row) {
            $nombreDeudor  = $row['nombre'];
        }
    }
    return $nombreDeudor;
}

function getIdProducto( $id_remesa ) {
    $id_producto = 0;

    $database = new Connection();
    $db = $database->openConnection();
    $sql = "select id_producto from t_remesas where id_remesa = " . $id_remesa;
    $result = $db->query($sql);
    if( $result ) {
        foreach ($result as $row) {
            $id_producto  = $row['id_producto'];
        }
    }
    return $id_producto;
}


function getIdCedente( $id_producto) {
    $id_cedente = 0;
   
    $database = new Connection();
    $db = $database->openConnection();
    $sql = " select id_cedente from t_productos where id_producto =" . $id_producto;
    $result = $db->query($sql);
    if( $result ) {
        foreach ($result as $row) {
            $id_cedente  = $row['id_cedente'];
        }
    }
    return $id_cedente;
}


function totalAsignado($id_campana, $rutusu) {
    $total = 0;
    $database = new Connection();
    $db = $database->openConnection();
    $sql = " select count(*) as total from t_campanas_deu where id_campana=".$id_campana ." and rut_ejecutivo=".$rutusu;
    $result = $db->query($sql);
    if( $result ) {
        foreach ($result as $row) {
            $total  = $row['total'];
        }
    }
    return $total;
}


function totalGestionados($id_campana, $rutusu){
    $totalGestionados = 0;
    $database = new Connection();
    $db = $database->openConnection();
    $sql = "select count(*) as total from t_campanas_deu where id_campana=".$id_campana." and rut_ejecutivo=".$rutusu." and id_gestionado<> 0 ";
    $result = $db->query($sql);
    if( $result ) {
        foreach ($result as $row) {
            $totalGestionados  = $row['total'];
        }
    }
    return $totalGestionados;
}

         
function getNombreEjecutivo( $rutusu) {
    $nombreEjecutivo = "";
    $database = new Connection();
    $db = $database->openConnection();
    $sql = "select nombre from tl_usuarios  where rut =".$rutusu;
    //echo $sql;
    $result = $db->query($sql);
    if( $result ) {
        foreach ($result as $row) {
            $nombreEjecutivo  = $row['nombre'];
        }
    }
    return $nombreEjecutivo;
}


function p_datos_clie ( $id_deudor){
    $database = new Connection();
    $db = $database->openConnection();
    $sql  = " select ";
    $sql .= " A.id_rut_deudor, ";         
    $sql .= " A.dv,          "; 
    $sql .= " rtrim(ltrim(REPLACE(A.nombre,char(13),''))) as nombreDeudor,";
    $sql .= " A.fecha_ult_gestion, "; 
    $sql .= " A.fecha_ult_compromiso,           ";
    $sql .= " B.desc_remesa,           ";
    $sql .= " A.cod_clte,           ";
    $sql .= " A.fecha_llegada,         ";  
    $sql .= " A.total_doctos,           ";
    $sql .= " A.total_saldo_inicial,       ";    
    $sql .= " A.total_mora,           ";
    $sql .= " A.tramo_dias,           ";
    $sql .= " A.tramo_mora,           ";
    $sql .= " A.fecha_asig_ejecutivo,    ";       
    $sql .= " B.id_producto,           ";
    $sql .= " P.NOMBRE_PRODUCTO,          "; 
    $sql .= " P.ID_CEDENTE,           ";
    $sql .= " C.CLI_NOMBRE,           ";
    $sql .= " S.DES_SCRSL,           ";
    $sql .= " U.NOMBRE,           ";
    $sql .= " G.NOMBRE_CODIGO_GESTION, ";                 
    $sql .= " '',           ";
    $sql .= " '',           ";
    $sql .= " '',           ";
    $sql .= " A.tramo_proyectado,           ";
    $sql .= " A.total_pagos_sicc,           ";
    $sql .= " A.total_pagos_cedente,           ";
    $sql .= " A.dias,           ";
    $sql .= " A.fecha_ult_actualizacion,           ";
    $sql .= " A.total_gestiones,           ";
    $sql .= " A.total_rebajas,           ";
    $sql .= " (A.total_saldo_inicial) - (A.total_pagos_sicc + A.total_pagos_cedente + A.total_rebajas) as Saldo_Actual,           ";
    $sql .= " B.ID_ESTADO,  ";
    $sql .= " A.marca1,        ";   
    $sql .= " isnull(A.t_costas) as costa , ";
    $sql .= " T.prefesion, ";
    $sql .= " T.fecha_nac, ";
    $sql .= " A.renegociar, ";
    $sql .= " A.marca2, ";
    $sql .= " D.nom_determina, ";
    $sql .= " A.id_remesa, ";
    $sql .= " A.id_estado, ";
    $sql .= " E.sepuedecobrar, ";
    $sql .= " E.Mensaje, ";
    $sql .= " A.fecha_cierre as fecha_cierre,           ";
    $sql .= " (select count(*)-1 from t_deudor inner join t_remesas on t_deudor.id_remesa = t_remesas.id_remesa where t_remesas.id_estado = 1 and id_rut_deudor = A.id_rut_deudor) as OTRASDEU,           ";
    $sql .= " A.total_saldo_act,           ";
    $sql .= " A.tramo_cliente, ";
    $sql .= " A.DICOM,        ";
    $sql .= " DOC.otrodato5     ";
    $sql .= " from t_deudor A      ";      
    $sql .= " inner join t_remesas B  on(A.id_remesa = B.id_remesa)            ";
    $sql .= " inner join t_productos P  on(B.id_producto = P.ID_PRODUCTO)         ";   
    $sql .= " inner join t_clientes C  ON (P.ID_CEDENTE=C.ID_CLIENTE)   ";         
    $sql .= " left JOIN t_sucursales S  ON(S.ID_SCRSL = A.id_sucursal)    ";        
    $sql .= " left JOIN tl_usuarios U  ON (U.RUT = A.rut_ejecutivo)  ";          
    $sql .= " left JOIN t_codigo_gestion G  ON(G.ID_CODIGO_GESTION = A.codigo_ult_gestion)           ";
    $sql .= " LEFT join t_persona T  on (T.rut=A.ID_RUT_DEUDOR)           ";
    $sql .= " left join t_determinacion D  on D.id_determina=A.id_determina  ";         
    $sql .= " LEFT join tp_estado_deudor E  on A.id_estado = E.id_estado_deudor ";       
    $sql .= " LEFT join t_documentos_short DOC  on A.id_deudor = DOC.id_deudor     ";     
    $sql .= " where A.id_deudor=".$id_deudor;
    $sql .= " limit 1  ";
    //echo $sql;
    $result = $db->query($sql);
    if( $result ) {
        return $result;
    }
    
}   


function sp_estadoTelefonos( $id_rut_deudor){
   $database = new Connection();
   $db = $database->openConnection();
    
   $sql  = " SELECT   ";
   $sql .= " t.id_telefono, ";
   $sql .= " t.telefono,     ";          
   $sql .= " c.nombre_estado_telefono, ";
   $sql .= " t.area,   ";
   $sql .= " p.nombre_telefono,   ";
   $sql .= " x.empresa_celular,  ";  
   $sql .= " ' ',   ";
   $sql .= " CASE WHEN ";   
   $sql .= " fecha_ult_gestion is null and fecha_ult_gestion_maquina is null THEN 'Sin Gestion'     ";
   $sql .= " ELSE 'Gestionado'  ";
   $sql .= "  END  ";
   $sql .= " FROM    ";
   $sql .= "      t_telefonos t                 ";
   $sql .= "     INNER JOIN tp_telefono p  ON t.id_tipofono=p.id_telefono                ";
   $sql .= "    INNER JOIN tp_estado_telefono c  ON(t.id_estado_telefono = c.id_estado_telefono)                ";
   $sql .= "      left join tp_cia_celular x on t.id_cia_celular = x.id_emp_celular       ";
   $sql .= " WHERE    ";
   $sql .= "      rut = ".$id_rut_deudor;
   $result = $db->query($sql);
    if( $result ) {
        return $result;
    }
   
}


function detalleCredito( $id_rut_deudor ){
   $database = new Connection();
   $db = $database->openConnection();
   $sql  = " select 1,OPDET_OPERACION,ROL_JUICIO, EST_JUICIO ";
   $sql .= " from detalle_cuotas_k_120220 ";
   $sql .= " where rut = ".$id_rut_deudor;
   $sql .= " group by OPDET_OPERACION,ROL_JUICIO, EST_JUICIO ";
   //cho "<br><br>".$sql;
   
   $result = $db->query($sql);
   if( $result ) {
       return $result;
   }
}


function getNumCuotasCredito( $id_deudor) {
   $cantidad = 0;
   $database = new Connection();
   $db = $database->openConnection();
   $sql = " select count(*) as cantidad from t_documentos_short where  id_deudor = ". $id_deudor;
   //echo "<br>".$sql;
   $result = $db->query($sql);
   if( $result ) {
       foreach ($result as $row) {
            $cantidad  = $row['cantidad'];
      }
   }
   return $cantidad;
}

function getNumCuotasPorCobrar( $id_deudor ) {
   $cantidad = 0;
   $database = new Connection();
   $db = $database->openConnection();
   $sql = " select count(*) as cantidad from t_documentos_short where  saldo_act > 0 and id_deudor = ".$id_deudor; 
   $result = $db->query($sql);
   if( $result ) {
       foreach ($result as $row) {
            $cantidad  = $row['cantidad'];
      }
   }
   return $cantidad;
}


function getNumDiasMora( $id_deudor) {
   $cantidad = 0;
   $database = new Connection();
   $db = $database->openConnection();
   
   
   $sql =  " select timestampdiff( day,fecha_vcto, now())  as cantidad ";
   $sql .= " from t_documentos_short ";
   $sql .= " where id_deudor = " .$id_deudor;
   $sql .= " and saldo_act > 0 ";
   $sql .= " limit 1 ";
   //echo "<br>diasMora:" .$sql;
   
   $result = $db->query($sql);

    if( $result ) {
       foreach ($result as $row) {
            $cantidad  = $row['cantidad'];
      }
   }
   return $cantidad;
   
   
}


function getTotalSaldoCapital( $id_rut_deudor) {
   $capital = 0;
   $database = new Connection();
   $db = $database->openConnection();
   $sql  = " select capital ";
   $sql .= " from datos_kativo_140220 ";
   $sql .= " where rut = ".$id_rut_deudor;
   //echo "<br>".$sql;
   
   $result = $db->query($sql);

   if( $result ) {
       foreach ($result as $row) {
            $capital  = $row['capital'];
      }
   }
   return $capital;
  
}

function getInteres( $id_rut_deudor) {
   $interes = 0;
   $database = new Connection();
   $db = $database->openConnection();
   $sql  = " select inter ";
   $sql .= " from datos_kativo_140220 ";
   $sql .= " where rut = ".$id_rut_deudor;
   //echo "<br>".$sql;
   
   $result = $db->query($sql);

   if( $result ) {
       foreach ($result as $row) {
            $interes  = $row['inter'];
      }
   }
   return $interes;
  
}



function getTotalPagos( $id_deudor ) {
   $totalPagos = 0;
   $database = new Connection();
   $db = $database->openConnection();
   $sql = " select sum(monto_pago) as monto_pago  from t_pagos_cedente where id_deudor = " .$id_deudor;
   //echo  "<br>TotPagos:" . $sql;
   
   $result = $db->query($sql);

   
   if( $result ) {
       foreach ($result as $row) {
            $totalPagos  = $row['monto_pago'];
      }
   }
   return $totalPagos;
   
}



function getMaxIdTelefonos() {
   $maxId = 0;
   $database = new Connection();
   $db = $database->openConnection();
   $sql = " select maxm( id_telefono ) as maxId  from t_telefonos ";

   $result = $db->query($sql);
   if( $result ) {
       foreach ($result as $row) {
            $maxId  = $row['maxId'];
      }
   }
   return $maxId;
   
}


function getTipoTelefono(){
   $database = new Connection();
   $db = $database->openConnection();
   $sql  = " select ID_TELEFONO, NOMBRE_TELEFONO ";
   $sql .= " from tp_telefono ";
   
   $result = $db->query($sql);
   if( $result ) {
       return $result;
   }
}



function getTipoGestion(){
   $database = new Connection();
   $db = $database->openConnection();
   $sql = " select id_gestion, nombre_gestion ";
   $sql .= " from tp_gestion ";
   $sql .= " where id_estado = 1 ";
   echo $sql;
   $result = $db->query($sql);

   
   if( $result ) {
       return $result;
   }
   
}


function  origenLlamada(){
   $database = new Connection();
   $db = $database->openConnection();
   $sql = " select rtrim(ltrim(id_origen_llamada)) as id_origen_llamada,nombre_origen_llamada from t_origen_llamada ";
   $result = $db->query($sql);

   if( $result ) {
       return $result;
   }
   
}




function getResultadoDeLaGestion(){
   $database = new Connection();
   $db = $database->openConnection();
   $sql  = " select  ";
   $sql .= " A.id_codigo_gestion, ";
   $sql .= " B.nombre_codigo,";
   $sql .= " A.id_registro ";
   $sql .= " from t_sna_tp_gestion_codigo A  ";
   $sql .= " inner join t_codigos_gestion_sicc  B ON A.id_codigo_gestion = B.id_codigo_gestion  ";
   $sql .= " where A.id_tp_gestion =1";
   $sql .= " and A.id_codigo_gestion <> 5  ";
   $sql .= " and clasificacion is not null  ";
   $sql .= " order by B.nombre_codigo ";
   
   echo $sql;
   
   
   $result = $db->query($sql);

   
   if( $result ) {
       return $result;
   }
  
}



function listTelefonosDeudor($id_rut_deudor) {
    $database = new Connection();
    $db = $database->openConnection();
    $sql  = " select  ";
    $sql .= " rtrim(ltrim(id_telefono)) as id_telefono, ";
    $sql .= " telefono,area,c.NOMBRE_ESTADO_TELEFONO, ";
    $sql .= " '' as prefijo  ";
    $sql .= " FROM t_telefonos t  "; 
    $sql .= " inner join tp_estado_telefono c on(t.id_estado_telefono=c.ID_ESTADO_TELEFONO)   ";
    $sql .= " where rut=". $id_rut_deudor;
    $sql .= " order by id_telefono  ";
    echo $sql;
    
     $result = $db->query($sql);

   
   if( $result ) {
       return $result;
   }
}

function getListadoDireccion( $id_deudor ) {
    $database = new Connection();
    $db = $database->openConnection();
    $database = new Connection();
    $db = $database->openConnection();
    $sql  =" select  ";
    $sql .= " rtrim(ltrim(D.id_direccion)) id_direccion, ";
    $sql .= " D.direccion  ";
    $sql .= " FROM t_deudor A  ";
    $sql .= " INNER JOIN t_sna_dir_deudor B  ON A.id_deudor = B.id_deudor  ";
    $sql .= " INNER JOIN t_direcciones D ON B.id_direccion = D.id_direccion  ";
    $sql .= " where A.id_deudor = " .$id_deudor;
    $sql .= " AND id_estado_direccion=1  ";
    $sql .= " order by D.id_direccion ";
    echo $sql;
    
    $result = $db->query($sql);

   
   if( $result ) {
       return $result;
   }
    
}


function  getEmailContacto( $id_rut_deudor ){
    $database = new Connection();
    $db = $database->openConnection();
    $sql  =  " select id_mail,email from t_email where rut = ".$id_rut_deudor;
    //echo $sql;
    
    $result = $db->query($sql);
   
    if( $result ) {
       return $result;
    }
    
}




function listAreasTelefonicas() {
    $database = new Connection();
    $db = $database->openConnection();
    $sql  =  " select codigo as area from t_areas_telefonicas ";
    //echo $sql;
    
    $result = $db->query($sql);
   
    if( $result ) {
       return $result;
    }
}


function getComunas() {
     $database = new Connection();
    $db = $database->openConnection();
    $sql  =  " select nombre from t_comunas order by nombre  ";
    //echo $sql;
    
    $result = $db->query($sql);
   
    if( $result ) {
       return $result;
    }
}