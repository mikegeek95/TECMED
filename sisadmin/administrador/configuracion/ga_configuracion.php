<?php
require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../../login.php");
	exit;
}


require_once("../../clases/conexcion.php");
require_once("../../clases/class.Configuracion.php");
require_once('../../clases/class.MovimientoBitacora.php');
require_once("../../clases/class.Funciones.php");


try
{
	$db= new MySQL();
	$conf= new Configuracion();
	$md = new MovimientoBitacora();
	$f = new Funciones();
	
	
	//Como no sabemos cuantos archivos van a llegar, iteramos la variable $_FILES
    $ruta="../../images/configuracion/";
	
	
	$conf->db=$db;	
	$md->db = $db;
	$db->begin();
		
		
	//recibiendo datos
	$conf->nombre_empresa = $f->guardar_cadena_utf8( $_POST['v_nombre_empresa']);
	$conf->url = $f->guardar_cadena_utf8($_POST['v_url']);
	$conf->email = $f->guardar_cadena_utf8($_POST['v_email']);
	$conf->direccion = $f->guardar_cadena_utf8($_POST['v_direccion']);
	$conf->telefonos = $f->guardar_cadena_utf8($_POST['v_telefono']);
	$conf->email_pedido = $f->guardar_cadena_utf8($_POST['v_email_pedido']);
	$conf->clave_caja = $f->guardar_cadena_utf8($_POST['clave_caja']);
	$conf->notas_print = $f->guardar_cadena_utf8($_POST['formato_impresion']);
	$conf->porc_comision = $f->guardar_cadena_utf8($_POST['comision']);
	
	$conf->razon_social = $f->guardar_cadena_utf8($_POST['v_razonsocial']);
	$conf->rfc = $f->guardar_cadena_utf8($_POST['v_rfc']);
	$conf->direccion_fiscal = $f->guardar_cadena_utf8( $_POST['v_dfiscal']);
	$conf->no_int_fiscal = $f->guardar_cadena_utf8($_POST['v_nint']);
	$conf->no_ext_fiscal = $f->guardar_cadena_utf8($_POST['v_next']);
	$conf->ciudad_fiscal = $f->guardar_cadena_utf8($_POST['v_ciudad']);
	$conf->estado_fiscal = $f->guardar_cadena_utf8($_POST['v_estado']);
	$conf->cp_fiscal = $f->guardar_cadena_utf8($_POST['v_cp']);
	$conf->colonia_fiscal = $f->guardar_cadena_utf8($_POST['v_colonia']);
	
	
	$conf->iva = $f->guardar_cadena_utf8($_POST['v_iva']);
	$conf->t_descuento = $f->guardar_cadena_utf8($_POST['v_tipo_descuento']);
	$conf->cuentasbancarias = $f->guardar_cadena_utf8($_POST['v_cuentas']);
	$conf->moneda = $f->guardar_cadena_utf8($_POST['v_moneda']);
	
	
   $conf->v_e_cuenta = $f->guardar_cadena_utf8($_POST['v_e_cuenta']);
   $conf->v_e_clave = $f->guardar_cadena_utf8($_POST['v_e_clave']);
   $conf->v_e_pop = $f->guardar_cadena_utf8($_POST['v_e_pop']);
   $conf->v_e_pentrante = $f->guardar_cadena_utf8($_POST['v_e_pentrante']);
   $conf->v_e_smtp = $f->guardar_cadena_utf8($_POST['v_e_smtp']);
   $conf->v_e_psaliente = $f->guardar_cadena_utf8($_POST['v_e_psaliente']);
   $conf->v_e_autenticacion = $f->guardar_cadena_utf8($_POST['v_e_autenticacion']);
   $conf->v_e_ss = $f->guardar_cadena_utf8($_POST['v_e_ss']);
	
	$conf->horario = $f->guardar_cadena_utf8($_POST['v_horario']);
	$conf->facebook = $f->guardar_cadena_utf8($_POST['v_facebook']);
	$conf->instagram = $f->guardar_cadena_utf8($_POST['v_instagram']);
	$conf->twitter = $f->guardar_cadena_utf8($_POST['v_twiter']);
	$conf->youtube = $f->guardar_cadena_utf8($_POST['v_youtube']);
	

	
	
	
	//guardando
	
	//evaluamos si ya existia la configuracion de la empresa. con la variable
	
	$id =  $_POST['v_id'];
	
	
	if($id == 0)
	{
	
	$conf->GuardarNewConfiguracion();
	$md->guardarMovimiento(utf8_decode('Configuracion'),'configuracion',utf8_decode('Guardando Configuracion de la empresa-'.$conf->ultimoIDConfiguracion));
	}else
	{
		
	$conf->idConfiguracion = $id;
	$conf->ModificarConfiguracion();
	$md->guardarMovimiento(utf8_decode('Configuracion'),'configuracion',utf8_decode('Modificamos la Configuracion de la empresa-'.$conf->idConfiguracion));
	}
	
	$c=0;
	foreach ($_FILES as $key) 
	  {
		
		$c = explode("/",$key['type']);
		
		if($c[1]=="png"){
			
		
		if($key['error'] == UPLOAD_ERR_OK ){//Verificamos si se subio correctamente
		   
		  $nombre = $f->conver_especial($key['name']);//Obtenemos el nombre del archivo
		  $temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
		  $tamano= ($key['size'] / 1000)."Kb"; //Obtenemos el tamaño en KB
		  
		   //obtenemos el nombre del archivo anterior para ser eliminado si existe
		  
		  $sql = "SELECT logo FROM configuracion";
		  $result_borrar = $db->consulta($sql);
		  $result_borrar_row = $db->fetch_assoc($result_borrar);
		  $nombreborrar = $result_borrar_row['logo'];		  
		  
		  if($nombreborrar != "")
		  {
			  unlink($ruta.$nombreborrar); 
		  }
		  
		  
		  move_uploaded_file($temporal, $ruta . $nombre); //Movemos el archivo temporal a la ruta especificada
		  //El echo es para que lo reciba jquery y lo ponga en el div "cargados"
		  
		 
		  $sql = "UPDATE configuracion SET logo = '$nombre'";
		   
		  $result = $db->consulta($sql);	 
		}}
		
		if($c[1]=="jpg" || $c[1]=="jpeg"){
			
		
			if($key['error'] == UPLOAD_ERR_OK ){//Verificamos si se subio correctamente
		   
		  $nombre = $f->conver_especial($key['name']);//Obtenemos el nombre del archivo
		  $temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
		  $tamano= ($key['size'] / 1000)."Kb"; //Obtenemos el tamaño en KB
		  
		   //obtenemos el nombre del archivo anterior para ser eliminado si existe
		  
		  $sql = "SELECT logonosotros FROM configuracion";
		  $result_borrar = $db->consulta($sql);
		  $result_borrar_row = $db->fetch_assoc($result_borrar);
		  $nombreborrar = $result_borrar_row['logonosotros'];		  
		  
		  if($nombreborrar != "")
		  {
			  unlink($ruta.$nombreborrar); 
		  }
		  
		  
		  move_uploaded_file($temporal, $ruta . $nombre); //Movemos el archivo temporal a la ruta especificada
		  //El echo es para que lo reciba jquery y lo ponga en el div "cargados"
		  
		 
		  $sql = "UPDATE configuracion SET logonosotros = '$nombre'";
		   
		  $result = $db->consulta($sql);	 
		}
		}
		$c++;
	  }
	
	
	
	
	$db->commit();
	echo 1;
	
	
}
catch(Exception $e)
{
	$db->rollback();
	$v = explode ('|',$e);
		// echo $v[1];
	     $n = explode ("'",$v[1]);
		 $n[0];
	$result = $db->m_error($n[0]);
	echo $result ;
}
?>