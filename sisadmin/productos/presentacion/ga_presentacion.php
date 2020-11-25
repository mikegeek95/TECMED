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
require_once("../../clases/class.Tallas.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.MovimientoBitacora.php");

try
{
	$db = new MySQL();
	$ta = new Tallas();
	$md = new MovimientoBitacora();
	$f=new Funciones();

	$ta->db = $db;	
	$md->db = $db;

	$db->begin();		

	//enviamos datos a las variables de la tablas	

	$ta->idtallas = $_POST['id'];
	$ta->talla = $f->guardar_cadena_utf8($_POST['talla']);
	$ta->unidad = $f->guardar_cadena_utf8($_POST['v_unidad']);
	$ta->descripcion = $f->guardar_cadena_utf8($_POST['descripcion']);
	$ta->estatus = $_POST['estatus'];


	//MODIFICADO
if($ta->idtallas==0){	//guardando
	$ta->guardarTalla();
	$md->guardarMovimiento(utf8_decode('Tallas'),'tallas',utf8_decode('Nueva Talla con el ID :'.$ta->idtallas));
}else{
	$ta->modificarTalla();
	$md->guardarMovimiento(utf8_decode('Tallas'),'tallas',utf8_decode('Modificamos la talla con el ID :'.$ta->idtallas));
}
	

	$db->commit();
	echo 1;

}catch(Exception $e)
{

	 $v = explode ('|',$e);
		// echo $v[1];
	     $n = explode ("'",$v[1]);
		 $n[0];
		 echo '<div class="alert_error">'. $db->m_error($n[0]).'</div>';
		 	
	$db->rollback();

}

?>