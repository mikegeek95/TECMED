<?php
   require_once("../clases/conexcion.php");
   require_once("../clases/class.ShoppingCar.php");
   
   
   $db = new MySQL();
   $shoping = new ShoppingCar();
   
  $idcliente = $_POST['idcliente'];

  $shoping->eliminar_cliente_sesion($idcliente);
  $shoping->ver_clientes_sesion();
?>