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

require_once ("../clases/class.Compras.php");

try {

$db = new MySQL ();

$compras = new Compras ();



$compras->db = $db ;





$compras->id_compra = $_POST['id'];



//echo "EL id de compra es:".$compras->id_compra;



$compras->validar_compra();





}





catch (Exception $e )

{

	echo "ERROR: ".$e;

}







?>