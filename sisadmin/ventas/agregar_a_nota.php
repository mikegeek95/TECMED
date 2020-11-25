<?php
/*==========================*
 *	CALZADO DAYANARA		*
 *  CAPSE 18/02/19			*
 *	ISC JOSE CARLOS 		*
 * SANTILLAN MONTEISNOS		*
 *==========================*/

//Validamos que exista una sesion para continuar leyendo la página
/*=============================================*/
	//Importamos clase de sesion 
	require_once("../clases/class.Sesion.php");
	//Declaramos el objeto de sesión
	$se = new Sesion();

	if(!isset($_SESSION['se_SAS']))
	{
		//Si no existe la sesión enviamos a login y no hacemos nada
		header("Location: ../login.php");
		exit;
	}
/*============================================*/

	//importamos clases a utilizar 
	require_once("../clases/conexcion.php");
   	require_once("../clases/class.ShoppingCar.php");
   	require_once("../clases/class.Productos.php"); 
   	require_once("../clases/class.Categoria_Descuento.php"); 
	require_once("../clases/class.Ventas.php");
	require_once("../clases/class.Configuracion.php");
	require_once('../clases/class.MovimientoBitacora.php');
   
   	try
   	{
		//Declaramos los objetos de clase
		$db = new MySQL();
  		$shoping = new ShoppingCar();
  		$pro = new Producto();
  		$cd = new categoria_descuento();
		$ve = new Ventas();
		$conf = new Configuracion();
		$md = new MovimientoBitacora();
	  
		//Enviamos objeto de conexión a las clases que lo van a utilizar
  		$pro->db = $db;
		$cd->db = $db;
		$ve->db = $db;
		$conf->db = $db;
		$md->db = $db;
		
		$db->begin();
	   
		//Recibimos parametros 
  		$idproducto = trim(strtoupper($_POST['idproducto']));
  		$cantidad = $_POST['cantidad'];
  		$idnota_remision = $_POST['idnota_remision'];	
		$talla = $_POST['idtallas'];
  		$idsucursales = $_SESSION['se_sas_Sucursal'];
		
		//Obtenemos datos de configuracion
		$row_configuracion = $conf->ObtenerInformacionConfiguracion();
		$iva = $row_configuracion['iva']/100;
		$t_descuento = $row_configuracion['t_descuento'];	  // 0-producto  1 - por paquete 2-ambos.
		
		//Obtenemos los datos de la nota de remision
		$result_nota = $ve->obtener_generales_pedido();
		$result_nota_row = $db->fetch_assoc($result_nota);
		$idniveles = $result_nota_row['idniveles'];
		
	  	//obtenemos los datos del producto
	  	$pro->id_producto = $idproducto;
	  	$result_producto = $pro->ObtenerDatosProducto();
	 	$idcategoria_precio = $result_producto['idcategoria_precio'];
		$costo = $result_producto['pv']; //obtenemos el precio venta ya con IVA.
		$desc = $result_producto['descuento'];
		
		//Obtenemos los datos de la categoria de precio
	 	$cd->idcategoria_precio = $idcategoria_precio;
	 	$result_categoria = $cd->buscarCategoriaPrecio();
	 	$result_categoria_row = $db->fetch_assoc($result_categoria);
	 	$nombre_categoria = $result_categoria_row['nombre'];
		
		//Validamos que exista el producto
		$pro->idsucursales = $idsucursales;
		$pro->idtallas = $talla;
		$existe = $pro->verificaProductoExistenteInventario();
		if($existe == 1)
		{
			//Validamos que el producto no exista en la nota
			$ve->idproduct = $idproducto;
			$ve->idtallas = $talla;
			$ve->id_notaremision = $idnota_remision;
			$ve->id_NuevoNotaRemision = $idnota_remision;
			
			$validacion_nota = $ve->validar_producto_nota();
			$validacion_nota_num = $db->num_rows($validacion_nota);
			$validacion_nota_row = $db->fetch_assoc($validacion_nota);
			
			$sql = "SELECT * FROM categoria_precios_niveles WHERE idniveles = '$idniveles' AND idcategoria_precio = '$idcategoria_precio'";
					   
		   	$result_sql = $db->consulta($sql);
		   	$result_sql_num = $db->num_rows($result_sql);
		   	$result_sql_row = $db->fetch_assoc($result_sql);

		   	if($result_sql_num == 0){
			   $desc_nivel = 0;
		   	}else{
			   $desc_nivel = $result_sql_row['descuento'];
		   	}
			
			
										
			if($validacion_nota_num == 0){
				//Es nuevo, no existe en la nota
				
				$alcanza = $pro->alcanzaProducto($cantidad);
				
				$SubPorProducto = round($cantidad * $costo,2);
			
				//Obtenemos descuento total sumando el descuento del cliente por nivel y el del producto
				$desc_t = $desc+$desc_nivel;
				$descuento = $desc_t/100; 												//obtenemos el porcentaje del descuento en la base de datos del producto.
				$DescPorProducto = round($SubPorProducto * $descuento,2); 				//obtenemos el total del descuento de ese producto.
				$SubtotalBrutoPorProducto = round($SubPorProducto - $DescPorProducto,2);
				
				$query = "INSERT INTO nota_descripcion (idnota_remision, idproducto, idtallas, cantidad, costo, subtotal, descuento_porc, descuento, total, nombre_categoria) VALUES ('$idnota_remision','$idproducto','$talla','$cantidad','$costo','$SubPorProducto','$desc_t','$DescPorProducto','$SubtotalBrutoPorProducto','$nombre_categoria');";
				
			}else{
				//Existe en la nota
				$cantidad_en_nota = $validacion_nota_row['cantidad'];
								
				$nueva_cantidad = $cantidad + $cantidad_en_nota;
				
				$SubPorProducto = round($nueva_cantidad * $costo,2);
			
				//Obtenemos descuento total sumando el descuento del cliente por nivel y el del producto
				$desc_t = $desc+$desc_nivel;
				$descuento = $desc_t/100; 												//obtenemos el porcentaje del descuento en la base de datos del producto.
				$DescPorProducto = round($SubPorProducto * $descuento,2); 				//obtenemos el total del descuento de ese producto.
				$SubtotalBrutoPorProducto = round($SubPorProducto - $DescPorProducto,2);
				
				$alcanza = $pro->alcanzaProducto($nueva_cantidad);
				
				$query_borrar = "DELETE FROM nota_descripcion WHERE idproducto = '$idproducto' AND idtallas = '$talla' AND idnota_remision = '$idnota_remision'";
				$db->consulta($query_borrar);
				
				$query = "INSERT INTO nota_descripcion (idnota_remision, idproducto, idtallas, cantidad, costo, subtotal, descuento_porc, descuento, total, nombre_categoria) VALUES ('$idnota_remision','$idproducto','$talla','$nueva_cantidad','$costo','$SubPorProducto','$desc_t','$DescPorProducto','$SubtotalBrutoPorProducto','$nombre_categoria');";
			}
						
			if($alcanza > 0){
				$db->consulta($query);
				$md->guardarMovimiento(utf8_decode('nota_descripcion'),'nota_descripcion',utf8_decode('Se agrego a la nota #:'.$idnota_remision.' el producto con id: '.$idproducto.' y talla: '.$talla));
				
				$result_totales = $ve->obtenerTotalesVenta();
	
				$descuento = $result_totales['descuento'];
				$total = $result_totales['total'];
				$subtotal = number_format($result_totales['total']/1.16,2,'.',',');
				$iva = number_format(($total - $subtotal),2,'.',',');

				$ve->desc_producto = $descuento;
				$ve->total = $total;
				$ve->subtotal = $subtotal;
				$ve->iva = $iva;

				//Actualizamos totales
				$ve->actualizarTotales();
				
				
				$db->commit();
				echo 1;	
			}else{
				echo 0;
				exit();
			}
		}else{
			echo 0;
			exit();
		}
  	}catch(Exception $e){
		  $v = explode ('|',$e);
		  $n = explode ("'",$v[1]);
		  echo $db->m_error($n[0]);
  	}
?>