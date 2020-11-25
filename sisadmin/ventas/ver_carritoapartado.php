<?php
  require_once("../clases/class.Sesion.php");

  $se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}

   require_once("../clases/conexcion.php");
   require_once("../clases/class.ShoppingCar.php");  
   
   try
   {
	  $db = new MySQL();
	  $shoping = new ShoppingCar();
	  $idCliente = $_POST['idcliente'];
	  $shoping->verCarritoApartado($idCliente);
	  
  }catch(Exception $e)
        {
		  $v = explode ('|',$e);
		  $n = explode ("'",$v[1]);
		  echo $db->m_error($n[0]);
        }


?>