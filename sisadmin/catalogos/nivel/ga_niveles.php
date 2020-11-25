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
require_once("../../clases/class.Categoria_Descuento.php");
require_once('../../clases/class.MovimientoBitacora.php');
require_once('../../clases/class.Funciones.php');

try
{

	$db= new MySQL();
	$cd = new categoria_descuento();
	$md = new MovimientoBitacora();
	$f = new Funciones();
	
	$cd->db = $db;
	$md->db = $db;

	$db->begin();
	

	//enviamos datos a las variables de la tablas
	$cd->nombre =trim($f->guardar_cadena_utf8($_POST['nivel']));
	$cd->estatus =$f->guardar_cadena_utf8($_POST['estatus']);
	$cd->idniveles=$_POST['id'];

	if($cd->idniveles==0){
		//guardando
	$cd->guardarNivel();
	$md->guardarMovimiento(utf8_decode('Nivel'),'niveles',utf8_decode('Nueva Nivel creado con el ID :'.$cd->ultimoidnivel));
	}else{
	//MODIFICADO
	$cd->modificarNivel();
	$md->guardarMovimiento(utf8_decode('niveles'),'niveles',utf8_decode('Modificamos Nivel con el ID :'.$cd->idniveles));
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