<?php

require_once("../clases/class.Imagen.php");

$img = new Imagen();



//recibimos nombre de la imagen

//$img->nombreimagen = $_POST['nombre'];



$img->nombreimagen = $_POST['nombre'];

 

$img->borrarImagen();









?>