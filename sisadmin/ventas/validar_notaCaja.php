<?php

require_once("../clases/conexcion.php");

require_once("../clases/class.Caja.php");



$db = new MySQL ();

$caja = new Caja();



$caja->db = $db ;

try

{

$caja->idnota_remision = $_POST['id'];

$result = $caja->validarNotaCaja();



echo $result;

}//fin del try

catch(Exeption $e)

{

	 $v = explode ('|',$e);

		  $n = explode ("'",$v[1]);

		  echo  $db->m_error($n[0]);

 }



?>