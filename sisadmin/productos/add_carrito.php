<?php
  require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
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
	   
	  $id = strtoupper(trim($_POST['id']));
	  $talla = $_POST['talla'];
	  $cantidad = $_POST['cantidad'];
	  $idsucursales = $_POST['sucursal'];	
	  $idSucursal = $_POST['idsucursal'];
	  $para = $_POST['para'];
	  $observaciones = $_POST['observaciones'];
	   	
	  $shoping->addTraspasodeProducto($id,$cantidad,$idsucursales,$para,$observaciones,$talla);
	  $shoping->verCarritoTraspaso($idSucursal);
	  
  }catch(Exception $e)
        {
		  $v = explode ('|',$e);
		  $n = explode ("'",$v[1]);
		  echo $db->m_error($n[0]);
        }


?>