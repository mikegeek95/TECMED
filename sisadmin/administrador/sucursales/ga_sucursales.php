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
require_once('../../clases/class.Sucursales.php');
require_once('../../clases/class.MovimientoBitacora.php');
require_once('../../clases/class.Funciones.php');


try
{
	$db= new MySQL();
	$su= new Sucursales();
	$md = new MovimientoBitacora();
	$f = new Funciones();
	
	$su->db = $db;
	$md->db = $db;	
	
	$db->begin();
		
	//recibiendo datos
	$su->nombre = trim($f->guardar_cadena_utf8($_POST['nombre']));
	$su->direccion = trim($f->guardar_cadena_utf8($_POST['direccion']));
	$su->tel = trim($f->guardar_cadena_utf8($_POST['tel']));
	$su->email = trim($f->guardar_cadena_utf8($_POST['email']));
	$su->notas_print = $f->guardar_cadena_utf8($_POST['notas_print']);
	
	$su->estatus= $f->guardar_cadena_utf8($_POST['estatus']);
	$su->idsucursales = $f->guardar_cadena_utf8($_POST['v_id']);
	
	if($su->idsucursales==0 || $su->idsucursales==1){$su->tipo==0;}else{$su->tipo= $f->guardar_cadena_utf8($_POST['tipo']);}
	
	
	
	
	
	if($su->idsucursales == 0){
		//Insert
		//guardando
		
		
		$su->guardar_sucursal();
		$md->guardarMovimiento(utf8_decode('sucursales'),'sucursales',utf8_decode('Nueva Sucursal creada -'.$su->idsucursales));
	}else{
		//Update
		
		$su->modificar_sucursal();
		$md->guardarMovimiento(utf8_decode('sucursales'),'sucursales',utf8_decode('Modifico Sucursal con ID: -'.$su->idsucursales));
	}
	
	
	$db->commit();
	echo 1;
	
	
}
catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}
?>