<?php 
require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../../login.php");
	exit;
}

require_once('../../clases/conexcion.php');
require_once('../../clases/class.MovimientoBitacora.php');
require_once("../../clases/class.Gastos.php");
require_once("../../clases/class.Funciones.php");

try
{
	$md = new MovimientoBitacora();
	$db = new MySQL();
	$ga = new Gastos();
	$f = new Funciones();
	$md->db = $db;
	
	$db->begin();
	
	$ga->db=$db;
		
	$ga->idgastos_categoria = $f->guardar_cadena_utf8($_POST['id']);
	$ga->categoria = $f->guardar_cadena_utf8 ($_POST['v_gasto']);
	$ga->descripcion = $f->guardar_cadena_utf8($_POST['v_descripcion']);
	$ga->tipo = $f->guardar_cadena_utf8($_POST['v_tipo']);
	$ga->estatus = $f->guardar_cadena_utf8($_POST['v_estatus']);
	
	if($ga->idgastos_categoria==0){
		$ga->GuardarNewGasto(); //guardado de plaza en la base de datos
		
	$md->guardarMovimiento($f->guardar_cadena_utf8('Gastos'),'Gastos',$f->guardar_cadena_utf8('se agrego una nuevo concepto de gasto con el id '.$ga->ultimoIDGasto));
	
	}
	else{
	$ga->ModificarGasto(); //guardado de plaza en la base de datos
		
	$md->guardarMovimiento($f->guardar_cadena_utf8('Gastos'),'Gastos',$f->guardar_cadena_utf8('se Modifico una nuevo concepto de gasto con el id '.$ga->idgastos_categoria));
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