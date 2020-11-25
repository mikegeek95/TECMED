<?php
require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}


require_once("../clases/conexcion.php");
require_once("../clases/class.Ventas.php");
require_once("../clases/class.Devoluciones.php");


$db = new MySQL ();
$ventas = new Ventas();
$dev = new Devoluciones();

$iddevolucion = $_POST['id'];

$dev->db = $db;
$dev->iddevolucion = $iddevolucion;

//$ventas->db = $db;
//$ventas->id_notaremision = $_POST['id'];

try{
	$db->begin();
	
	
	
	$result = $dev->cancelarPedidoPagado();
	//$result = $ventas->cancelarPedidoPagado();
	
	
	echo $result;
	
	
	$db->commit();
}//fin del try
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