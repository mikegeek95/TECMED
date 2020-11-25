<?php

require_once("../clases/conexcion.php");

require_once("../clases/class.Caja.php");





$db = new MySQL();

$caja = new Caja ();



$caja->db = $db ;

try

{

	

$caja->idnota_remision = $_POST['id'];





$cliente = $caja->obtenerDatosClienteCajas();



$totalP = $caja->obtenerTotalProducto();



$total = $caja->obtenerDatosPedido();

$nombreC ;



if ($cliente['cliente'] == "" )

{

	$nombreC = "Venta General";

}

else

{

	$nombreC = $cliente['cliente'] ;

}



echo utf8_encode ($nombreC)."|".$totalP['totalp']."|".$total['total'] ;





}//fin del try



catch (Exception $e)

{

	$v = explode ('|',$e);

		// echo $v[1];

	     $n = explode ("'",$v[1]);

		 $n[0];

	$result = $db->m_error($n[0]);

	echo $result ;

}







?>