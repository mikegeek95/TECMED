<?php
require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}

require_once('../clases/class.Imagen.php');



$img = new Imagen;


$img->idproducto = $_POST['id_producto'];

$img->nombreimagen = $img->idproducto."-".$_FILES['archivo']['name'];

$img->nombretemporal = $_FILES['archivo']['tmp_name'];

$img->m = $_POST['tipo'];



$img->ponerValoresPredeterminados();

$img->borrarArchivoAnterior();

$img->moverArchivo();

$img->mostrarMensaje();
?>

