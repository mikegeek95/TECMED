<?php
   require_once("../clases/conexcion.php");
   require_once("../clases/class.ShoppingCar.php");
   
   
   $db = new MySQL();
   $shoping = new ShoppingCar();
   
  $id = $_POST['id'];
  $cantidad = $_POST['cantidad'];

  $shoping->delProductoTraspaso($id);
  
  $shoping->verCarritoTraspaso();



?>