<?php



require_once ("../clases/conexcion.php");

require_once ("../clases/class.Credito.php");

try{



$db = new MySQL ();

$credito = new creditos ();



$credito->db = $db ;





$credito->idnota_remision = $_POST['idnota_remision'];



$deuda = $credito->obtenerDeuda();

$total_pagos = $credito->totalPagos();





//$credito->idcretdito = $deuda['idcredito'];

$credito->idcretdito = $deuda['idcredito'];

$pagoHoy = $credito->saberSiPagaronHoy();

$hisotiral = $credito->obtenerDatosHistorialPago();

$adeudoCero ; //$credito->adeudoCero();

$que = $credito->existeCredito();



if ($deuda['debe'] != 0 )

{

	$adeudoCero = 0 ;

}



else if ($deuda['debe'] == 0 )

{

	$adeudoCero = 1 ;

}





if ($deuda['debe'] =="" )

{

	$que = 0 ;

}



if ($deuda['debe'] != "" )

{

	$que = 1 ;

}









echo $total_pagos['totalp']."|".$deuda['debe']."|".$credito->idnota_remision."|".$que."|".utf8_encode($deuda['cliente'])."|".$deuda['email']."|".$deuda['idcredito']."|".$pagoHoy."|".$adeudoCero."|".$deuda['deudatotal'];





/*echo "yo soy totalpagos = ".$total_pagos['totalp']."| yo soy debe = ".$deuda['debe']."| yo soy la nota de remision = ".$credito->idnota_remision."| yo soy que = ".$que."| yo soy el cliente = ".utf8_encode($deuda['cliente'])."| yo soy el email = ".$deuda['email']."| yo soy el idcredito = ".$deuda['idcredito']."| yo soy pago hoy = ".$pagoHoy."| yo soy deuda cero =".$adeudoCero;*/

 



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