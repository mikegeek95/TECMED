<?php

    include_once("../clases/class.ShoppingCar.php");

	

	$carrito = new ShoppingCar();

	$cod = $_POST['v_idproducto'];

	

	$carrito->delProductoCompras($cod);

	

	$carrito->verCarritoCompras();	

	

?>