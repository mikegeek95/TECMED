<?php
    include_once("../../clases/class.ShoppingCar.php");
	include_once("../../clases/class.Productos.php");
	include_once("../../clases/conexcion.php");

	try{
		//generamos los objetos
		$db = new MySQL();
		$carrito = new ShoppingCar();
		$prod = new Producto();
	
		//Recibimos parametros
		$cod = trim(strtoupper($_POST['v_idproducto']));
		$costo = $_POST['v_costo'];
		$cantidad = $_POST['v_cantidad'];
		$talla = $_POST['talla'];


		//validamos si existe el producto en catalogos.	
		$prod->db = $db;
		$prod->id_producto = $cod;
		$prod->talla = $talla;
		
		$result_produ = $prod->validarProductoparaAltainventario();

		if($result_produ != 0){
		    $carrito->addProductoEntrada($cod,$cantidad,$costo,$talla);
		}else{
			echo '<div id="error" style="margin: auto;" class="alert alert-danger">EL PRODUCTO NO EXISTE O ESTA DESACTIVADO EN CATALOGO DE PRODUCTOS, NECESITAS DARLE DE ALTA</div><br>';
			echo '<script type="text/javascript">

			

					setTimeout(function ()

					{

						$("#error").slideUp();

						

						},3000);

			</script>' ;
		}
		$carrito->verCarritoEntrada();
	}catch(Exception $e){
		  echo "Error. ".$e;	

    }
?>