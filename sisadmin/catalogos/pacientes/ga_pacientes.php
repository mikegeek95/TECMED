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
require_once("../../clases/class.Clientes.php");
require_once('../../clases/class.MovimientoBitacora.php');
require_once('../../clases/class.Funciones.php');


try
{
	$db= new MySQL();
	$cli= new Clientes();
	$md = new MovimientoBitacora();
	$f = new Funciones();
	
	$cli->db = $db;
	$md->db = $db;
		
	
	$db->begin();
	
	//enviamos datos a las variables de la tablas	
	
	if($_POST['v_f_nacimiento'] == ""){
		$f_nacimiento = "2000-01-01";
	}else{
		$f_nacimiento = trim($_POST['v_f_nacimiento']);
	}
	
	$cli->idCliente = $f->guardar_cadena_utf8($_POST['id']);
	$cli->nombre = trim($f->guardar_cadena_utf8($_POST['v_nombre']));
	$cli->paterno = trim($f->guardar_cadena_utf8($_POST['v_paterno']));
	$cli->materno = trim($f->guardar_cadena_utf8($_POST['v_materno']));
	$cli->direccion = trim($f->guardar_cadena_utf8($_POST['v_direccion']));
	$cli->telefono = trim($f->guardar_cadena_utf8($_POST['v_telefono']));
	$cli->fax = trim($f->guardar_cadena_utf8($_POST['v_telefono']));
	$cli->email = trim($f->guardar_cadena_utf8($_POST['v_email']));
	$cli->sexo = trim($f->guardar_cadena_utf8($_POST['v_sexo']));
	$cli->estatus = trim($f->guardar_cadena_utf8($_POST['v_estatus']));
	$cli->f_nacimiento = $f_nacimiento;
	
	$cli->nivel = trim($_POST['v_nivel']);
	
	
	
	
	//variables de lo fiscal
	
	$cli->fis_razonsocial = trim($f->guardar_cadena_utf8($_POST['v_fis_razonsocial']));
	$cli->fis_rfc = trim($f->guardar_cadena_utf8($_POST['v_fis_rfc']));
	$cli->fis_direccion = trim($f->guardar_cadena_utf8($_POST['v_fis_direccion']));
	$cli->fis_no_ext = trim($f->guardar_cadena_utf8($_POST['v_fis_no_ext']));
	$cli->fis_no_int = trim($f->guardar_cadena_utf8($_POST['v_fis_no_int']));
	$cli->fis_cp = trim($f->guardar_cadena_utf8($_POST['v_fis_cp']));
	$cli->fis_estado = trim($f->guardar_cadena_utf8($_POST['v_fis_estado']));
	$cli->fis_ciudad = trim($f->guardar_cadena_utf8($_POST['v_fis_ciudad']));
	$cli->fis_col= trim($f->guardar_cadena_utf8($_POST['v_fis_col']));

	
	
	if($cli->idCliente==0){
		//guardando
	$cli->GuardarNewCliente();

	$md->guardarMovimiento(utf8_decode('Clientes'),'cliente',utf8_decode('Nuevo Cliente creado con el ID :'.$cli->ultimoIDCliente));
	}
	else{
	//guardando
	$cli->ModificarCliente();
	$md->guardarMovimiento(utf8_decode('Clientes'),'cliente',utf8_decode('Modificar Cliente con el ID :'.$cli->idCliente));
}
	$db->commit();
	echo "1|".$_POST['id'];
	
	
}
catch(Exception $e)
{
	$db->rollback();
	
	echo $e ;
}
?>