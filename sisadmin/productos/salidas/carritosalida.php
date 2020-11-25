<?php 
require_once("../../clases/class.ShoppingCar.php");
	
$carrito = new ShoppingCar();

//Eliminamos la sesion que ya tenia cargada por que puede generar error, ya que la cesta tiene que ir por sucursal
unset($_SESSION['itemsEnCestaSalidas']);

 $carrito->verCarritoSalidas();		

?>