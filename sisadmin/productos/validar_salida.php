<?php
require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}

//aqui valido la salida que se pone en el campo id nota de remision del modulo salidas

require_once ("../clases/conexcion.php");

require_once ("../clases/class.EntradasySalidas.php");



$db = new MySQL ();

$eys = new EntradasySalidas ();



$eys->db = $db ;



$nota = $_POST['id'];

$eys->id_nota_remision = $nota ;



$que_paso = $eys->validarNotaRemision();



echo $que_paso ;





?>