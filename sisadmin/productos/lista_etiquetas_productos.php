<?php
require_once ("../clases/class.Sesion.php");
$sesion = new Sesion ();	
require_once ("../clases/conexcion.php");
require_once ("../clases/class.Etiquetas.php");
require_once("../clases/class.ShoppingCar.php");



try {


$db = new MySQL ();
$etiquetas = new Etiquetas ();
$carrito = new ShoppingCar ();


$etiquetas->db = $db ;

 $etiquetas->idetiquetas = $_GET['id'];

$etiquetas->verProductosEtiquetas();



}
catch (Exception $e)
{
	echo "Error: ".$e."el id es : ".$etiquetas->idetiquetas;
}
 
 ?>      