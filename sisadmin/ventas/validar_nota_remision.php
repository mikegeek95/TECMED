<?php

//aqui valido la salida que se pone en el campo id nota de remision del modulo salidas

require_once ("../clases/conexcion.php");

require_once ("../clases/class.EntradasySalidas.php");



$db = new MySQL ();

$eys = new EntradasySalidas ();



$eys->db = $db ;



$nota = $_POST['id'];

$eys->id_nota_remision = $nota ;



$que_paso = $eys->validarIdNotaRemisionPagada();

$quepasodos = $eys->validarNotaRemisionEntregada();



echo $que_paso."|".$quepasodos ;





?>