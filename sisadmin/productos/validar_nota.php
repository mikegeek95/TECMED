<?php
require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}


require_once ("../clases/conexcion.php");

require_once ("../clases/class.Notaremision.php");

try {

$db = new MySQL ();

$not = new NotasRemision ();



$not->db = $db ;





$not->idnotaremision = $_POST['id'];



//echo "EL id de compra es:".$not->idnotaremision;

$not->validar_nota();





}





catch (Exception $e )

{

	echo "ERROR: ".$e;

}





?>