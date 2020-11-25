<?php

require_once("../clases/conexcion.php");

require_once("../clases/class.Credito.php");



$db = new MySQL();

$credito = new creditos();





$pendientes = $credito->verListaCreditos();



foreach($pendientes as $p)

{

	$p->idcredito ;

	$p->idnota_remision ;

	$p->idcliente;

	$p->cantidad ;

}



?>