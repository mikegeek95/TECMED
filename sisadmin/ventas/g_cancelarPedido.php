<?php
require_once("../clases/conexcion.php");
require_once("../clases/class.Ventas.php");


$db = new MySQL ();
$ventas = new Ventas();
$ventas->db = $db;

$ventas->id_notaremision = $_POST['id'];

try{
	$db->begin();
	$result = $ventas->cancelarPedidoPagado();
	echo $result;
	/*if ($result = 1)
	{
		echo '1';
	}else 
	{
		echo '0';
	}*/
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