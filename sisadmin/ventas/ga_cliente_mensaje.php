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
	  
	   $pro->db = $db;
	   $cd->db = $db;
	   
	   $idcliente = $_POST['idcliente'];
	   $nombre = $_POST['nombre'];
	 	
	   $shoping->guardar_cliente_sesion($idcliente,$nombre);
	   $shoping->ver_clientes_sesion();
	  
   }catch(Exception $e)
	{
	  $v = explode ('|',$e);
	  $n = explode ("'",$v[1]);
	  echo $db->m_error($n[0]);
	}
?>