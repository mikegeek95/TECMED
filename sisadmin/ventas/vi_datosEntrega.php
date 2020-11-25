<?php



require_once ("../clases/conexcion.php");



require_once ("../clases/class.Sesion.php");

require_once ("../clases/class.Entregas.php");



$db = new MySQL ();

$entrega = new Entregas ();

$s = new Sesion();



$entrega->db = $db ;



//creo la sesion con la nota de remision para poder hacen una consulta en vercarritoEntrega,

$s->eliminarSesion('idnota_remision');

$s->crearSesion('idnota_remision',$_POST['idnota_remision']);



try

{



$entrega->idnota_remision = $_POST['idnota_remision'];



$datos_cliente = $entrega->datosCliente();

$total_productos = $entrega->totalProductos();





echo utf8_encode($datos_cliente['cliente'])."|".$total_productos['total']."|";



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