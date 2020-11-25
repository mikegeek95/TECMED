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

require_once ("../clases/class.Etiquetas.php");



$db = new MySQL ();

$etiquetas = new Etiquetas ();



$etiquetas->db = $db;





try

{
	$db->begin();




$etiquetas->descripcion = $_POST['descripcion'];

$etiquetas->idetiquetas = $_POST['id'];





$etiquetas->modificarEtiqueta();

$db->commit();

}



catch (Exception $e)

{
	$db->rollback();
	echo "El error: ".$e;

}



?>