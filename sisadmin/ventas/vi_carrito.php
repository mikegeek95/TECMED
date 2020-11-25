<?php
   require_once("../clases/conexcion.php");
   require_once("../clases/class.ShoppingCar.php");
   
   $db = new MySQL();
   $carrito = new ShoppingCar();
   
   $desc = $_POST['desc'];
   $carrito->verCarritoPuntodeVentaDescTotal($desc);


?>