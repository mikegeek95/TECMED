<?php

    require_once("../clases/class.ShoppingCar.php");

	require_once("../clases/class.Productos.php");

    require_once("../clases/class.Entregas.php");

	require_once("../clases/conexcion.php");

	require_once("../clases/class.Sesion.php");

	

	



	

	try

	{

		

		//generamos los objetos

		$db = new MySQL();

		$carrito = new ShoppingCar();

		$prod = new Producto();

		$entrega = new Entregas() ;

		$s = new Sesion();

		

		

		$cod = $_POST['v_idproducto'];

		

		$cantidad = $_POST['v_cantidad'];	

		

		$idnota_remision = $_POST['idnota_remision'];

		

		//validamos si existe el producto en catalogos.

		

		

		$prod->db = $db;

		$entrega->db = $db;

		//$productosSesion = $s->obtenerSesion('vi_productos_entrega');

	

		$prod->id_producto = $cod;

		$result_produ = $prod->validarProductoparaAltainventario();

		

		$entrega->idnota_remision = $idnota_remision ;

		$entrega->idproduto = $cod ;

		$result_entrega = $entrega->existeProductoenNotaRemision();

		



		

	if ($result_entrega == 1){	

		if($result_produ != 0)

		{

			

		    $carrito->addProductoEntrega($cod,$cantidad);

		  

		}else

		{

			echo '<div style="margin: auto;">EL PRODUCTO NO EXISTE O ESTA DESACTIVADO EN CATALOGO DE PRODUCTOS, NECESITAS DARLE DE ALTA</div>';

			

		}//fin del else

		

	}//fin del if result entrega

	else

	{

		echo '<div id="error" class="alert_error" style="margin: auto;">EL PRODUCTO '.$cod.' NO ESTA EN ESTA NOTA DE REMISIÓN</div><br>';

		echo "<script >

				setTimeout (	function (){ $('#error').slideUp()},4000 );

		</script>" ;

	}



			$carrito->verCarritoEntrega();

			echo '<script type="text/javascript">

			

				verTablaProductoEntrega();

			</script>';

	}

	   catch(Exception $e)

        {

		  $v = explode ('|',$e);

		// echo $v[1];

	     $n = explode ("'",$v[1]);

		 $n[0];

	$result = $db->m_error($n[0]);

	echo $result ;	

        }

	

?>