<?php
require_once ("../clases/conexcion.php");
require_once ("../clases/class.Credito.php");
$db = new MySQL ();
$credito = new creditos ();

$credito->db = $db ;

try
{

	$db->begin();
	
$credito->idcretdito= $_POST['id'];
$credito->deposito = $_POST['pago'];
$credito->tipo_pago = $_POST['tipo'];
$credito->descripcion = utf8_decode($_POST['desc']);

$credito->pagoC();


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