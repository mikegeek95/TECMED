<?php

    include_once("../../clases/class.ShoppingCar.php");

	include_once("../../clases/class.Compras.php");

	include_once("../../clases/conexcion.php");

	require_once("../../clases/class.Productos.php");

	

	



	

	try

	{

		

		//generamos los objetos

		$db = new MySQL();

		$carrito = new ShoppingCar();

		$prod = new Producto();

		

		

		$cod = $_POST['v_idproducto'];

		$cantidad = $_POST['v_cantidad'];	

		

		//validamos si existe el producto en catalogos.

		

		

		$prod->db = $db;

		$prod->id_producto = $cod;

		$result_produ = $prod->validarProductoparaAltainventario();

		

		if($result_produ != 0)

		{

		    $carrito->addProductoCompras($cod,$cantidad);

		  

		}else

		{

			echo '<div style="margin: auto;">EL PRODUCTO NO EXISTE O ESTA DESACTIVADO EN CATALOGO DE PRODUCTOS, NECESITAS DARLE DE ALTA</div>';

			

		}

		$carrito->verCarritoCompras();

	}

	   catch(Exception $e)

        {

		  echo "Error. ".$e;	

        }

	

?>