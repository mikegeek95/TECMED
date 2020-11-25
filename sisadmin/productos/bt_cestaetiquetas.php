<?php
    include_once("../clases/class.Sesion.php");
	include_once("../clases/class.ShoppingCar.php");
	
	$carrito = new ShoppingCar();	
	$se = new Sesion();
	$nom_sesion = $_POST['v_nombresesion'];
	$se->eliminarSesion($nom_sesion);
	
	$carrito->verCarritoEtiquetas();	
	
?>