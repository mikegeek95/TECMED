<?php
    require_once("../clases/class.ShoppingCar.php");
	require_once("../clases/class.Etiquetas.php");
	require_once("../clases/conexcion.php");

	
	

	
	try
	{
		
		//generamos los objetos
		$db = new MySQL();
		$carrito = new ShoppingCar();

		
		
		
		$cod = $_POST['v_idproducto'];  //aca esta el maldito id
		$cantidad = $_POST['v_cantidad'];
		$unidad = $_POST['unidad'];
		
		//validamos si existe el producto en catalogos.
		
		for($x=1 ; $x<= $cantidad ; $x++)
		{
		   $carrito->addProductoEtiquetas($cod,$cantidad,$unidad);
		}
		
		$carrito->verCarritoEtiquetas();
	}
	   catch(Exception $e)
        {
		  echo "Error. ".$e;	
        }
	
?>