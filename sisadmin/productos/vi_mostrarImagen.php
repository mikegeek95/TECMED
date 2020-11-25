<?php
require_once('../clases/class.Imagen.php');



$img = new Imagen;



$donde = $_POST['donde'];

$img->m = $_POST['tipo'];

$img->idproducto = $_POST['id_producto'];



$img->ponerValoresPredeterminados();

$img->mostrarNuevaImagen($donde);

//echo 'entro';

?>

