<?php
require_once("../clases/conexcion.php");
require_once("../clases/class.Caja.php");

$db = new MySQL ();
$caja = new Caja ();

$caja->db = $db ;

$caja->idnota_remision = $_POST['id_nota_remision'];

try
{
	$datos = $caja->obtenerDatosPedido();
	
	//regresamos una cadena con todos los valores
	
	$total = $datos['total'];
	$cliente = utf8_encode($datos['nombre'].' '.$datos['paterno'].' '.$datos['materno']);
	echo "$total|$cliente";
	
	
}//fin del try
catch(Exception $e)
{
	$v = explode ('|',$e);
		// echo $v[1];
	     $n = explode ("'",$v[1]);
		 $n[0];
	$result = $db->m_error($n[0]);
	echo $result ;
	
}


?>