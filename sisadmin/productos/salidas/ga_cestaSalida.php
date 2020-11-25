<?php
require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();

    include_once("../../clases/class.ShoppingCar.php");
	include_once("../../clases/class.Productos.php");
	include_once("../../clases/conexcion.php");

	try
	{

		//generamos los objetos

		$db = new MySQL();
		$carrito = new ShoppingCar();
		$productos = new Producto ();
		

		$cod = trim($_POST['v_idproducto']);
		$cantidad = $_POST['v_cantidad'];	
		//$idsucursales = $_SESSION['se_sas_Sucursal'];
		$idsucursales = $_POST['sucursal'];
		$talla = $_POST['talla'];

		//validamos si existe el producto en catalogos.

		$productos->db = $db;
	    $productos->id_producto = $cod;
		$productos->idsucursales = $idsucursales;
		$productos->idtallas = $talla;
		$result_productos = $productos->validarProductoparaAltainventario();
		
		$dato_producto = $productos->ObtenerDatosProducto();
		
		//Obtenemos existencia de inventario del producto
		$sql_existencia = "SELECT * FROM inventario WHERE idproducto = '$cod' AND idsucursales = '$idsucursales' AND idtallas = '$talla'";
		$result_existencia = $db->consulta($sql_existencia);
		$result_existencia_row = $db->fetch_assoc($result_existencia);
		
		$alcanza = $productos->alcanzaProducto($cantidad);
		$minimo = $productos->stockMinimo();

		//echo "alcanza es :".$alcanza;

		//echo "EL MINIMO ES : ".$minimo;

		if($result_productos != 0)
		{	
			if ($alcanza == 1)
	     	 {
				if ($minimo == 0 )
				{
					echo '<div id="stockm" class="alert alert-warning" style="margin:auto;">EL PRODUCTO :'.$productos->id_producto.' ESTA POR AGOTARSE LA EXISTENCIA ACTUAL ES '.$result_existencia_row['existencia'].' SI HACE ESTA SALIDA LA CANTIDAD SERA '.($result_existencia_row['existencia']-$cantidad).'<br></div><br>';

					echo '<script>setTimeout(function(){$("#stockm").slideUp(1000);},3000);	</script>';

					$carrito->addProductoSalidas($cod,$cantidad,$talla);
					$carrito->verCarritoSalidas();
				}else{
					$carrito->addProductoSalidas($cod,$cantidad,$talla);
					$carrito->verCarritoSalidas();
				}
			}//fin del if ($alcanza == 1)
			else {if ($alcanza == 0)
				{
					echo '<div style="margin:auto;" id="noalcanza" class="alert alert-danger" >LA CANTIDAD DEL PRODUCTO :'.$productos->id_producto.' ES MENOR A LA CANTIDAD QUE DESEA SACAR, EXISTENCIA = '.$result_existencia_row['existencia'].'</div>
<br>';
			
					echo '<script>setTimeout(function(){$("#noalcanza").slideUp(1000);},3000);	</script>';
					$carrito->verCarritoSalidas();
					exit ;
				}

		    $carrito->addProductoSalidas($cod,$cantidad,$talla);
			}
		}else{

			echo '<div style="margin: auto;" id="msj" class="alert alert-danger" >EL PRODUCTO NO EXISTE O ESTA DESACTIVADO EN CATALOGO DE PRODUCTOS, NECESITAS DARLE DE ALTA<br></div><br>';
			echo '<script>setTimeout(function(){$("#msj").slideUp(1000);},3000);	</script>';
			$carrito->verCarritoSalidas();

		}

	}//fin del try
	
	catch(Exception $e)
  	{
		  $v = explode ('|',$e);
		// echo $v[1];
	     $n = explode ("'",$v[1]);
		 $n[0];
		 echo $db->m_error($n[0]);	
  	}
?>