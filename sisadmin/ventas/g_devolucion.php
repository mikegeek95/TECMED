<?php
require_once("../clases/class.Sesion.php");
require_once("../clases/conexcion.php");
require_once("../clases/class.Devoluciones.php");
require_once('../clases/class.MovimientoBitacora.php');
require_once('../clases/class.Fechas.php');

$sesion = new Sesion();



try
{
	$db = new MySQL();
	$de = new Devoluciones();
	$md = new MovimientoBitacora();
	$fe = new Fechas();
	//$ven->db = $db;
	//$conf->db = $db;
	$md->db = $db;
	$de->db = $db;
	
	$db->begin();

	//OBTENEMOS SI EN EL CARRITO EXISTEN PRODUCTOS...

	$itemsEnCesta = $sesion->obtenerSesion('itemsEnCestaDevolucion');
	$notas = $sesion->obtenerSesion('idnotarems');
	$idsucursal = $_SESSION['se_sas_Sucursal'];
	$idusuariosistema = $sesion->obtenerSesion('se_sas_Usuario');

	if($itemsEnCesta != false)	

	{
		
		//creamos la orden de devolucion primero
		$sql = "INSERT INTO cliente_devolucion(idsucursales,idusuarios) VALUES ('$idsucursal','$idusuariosistema');";
		$db->consulta($sql);
		$ultimoid=$db->id_ultimo();
		
		
		//ciclo de las notas que vienen en la devolucion
		foreach(array_reverse($notas,true) as $idrem => $val)
		{
			$idventa = $idrem;
		
			//obtenemos el cliente al que le agregaremos el saldo de la devolucion
			$sql_nota = "SELECT * FROM nota_remision WHERE idnota_remision = '$idventa'";
			$sql_nota_result = $db->consulta($sql_nota);
			$sql_nota_row = $db->fetch_assoc($sql_nota_result);
			
			$cliente = $sql_nota_row['idcliente'];
			
			//guardamos entrada en las tablas entradas,entradas_detalles con tipoentrada = 1, que es el concepto de POR DEVOLUCION.
			$sql_entrada = "INSERT INTO entradas (idsucursales,tipoentrada,idusuarios,idnota_remision,descripcion) VALUES('$idsucursal','1','$idusuariosistema','$idventa','Ingreso por motivo de devolucion');";
			$db->consulta($sql_entrada);
			$ultimoidentrada=$db->id_ultimo();
			
			
			//recorremos la session para poder ingresar todo a descripcion de la devolucion.
	    	$sumatotal = 0;
			
			foreach(array_reverse($itemsEnCesta,true) as $k => $v)
		    {
				
			   	$result_split = explode("|",$k);
				$idnota = $result_split[1];
				$idproducto = $result_split[0];
				$idtallas = $result_split[2];
				$cantidad_produ = $v;
				
			//die("la venta es ".$idventa." y el producto que traemos es d ela nota ".$idnota." y ".$idproducto." CANTIDAD: ".$cantidad_produ);
				
				if($idventa == $idnota){
				
					//OBTENEMOS LOS VALORES DEL PRODUCTO Y COSTO EN LA NOTA DE REMISION
					$sql = "SELECT * FROM nota_descripcion WHERE idproducto = '$idproducto' AND idnota_remision = $idventa AND idtallas = '$idtallas'";
					$result = $db->consulta($sql);
					$result_row = $db->fetch_assoc($result);
					$costo = $result_row['costo'];
					$descuento_porc = $result_row['descuento_porc'];
					//$desc_producto = $result_row['descuento'];
					
					$descuento = $result_row['descuento_porc']/100;
					$desc_producto = round(($costo*$cantidad_produ)*$descuento,2);
						
									
					$subtotal = number_format(($costo * $cantidad_produ) - $desc_producto,2,'.',',');
					//$sumatotal = $sumatotal + $subtotal;
					
					
					//actualizar inventarios.
					$sql_producto = "SELECT * FROM inventario WHERE idproducto = '$idproducto' AND idsucursales = '$idsucursal' AND idtallas = '$idtallas'";
					$result_producto = $db->consulta($sql_producto);
					$result_producto_row = $db->fetch_assoc($result_producto);
					$result_producto_num = $db->num_rows($result_producto);
					
					if($result_producto_num == 0){
						//Insertamos datos nuevos por que el producto no ha entrado
						$sql_inventario = "INSERT INTO inventario (idproducto,idtallas,idsucursales,existencia) VALUES ('$idproducto','$idtallas','$idsucursal','$cantidad_produ');";
						$db->consulta($sql_inventario);
					
					}else{
						//Actualizamos inventario a lo que ya esta
						//Obtenemos la existencia de ese producto para sumarlo con la cantidad de devolucion
						$existencia = $result_producto_row['existencia'];
						//sumanmos la existencia que tenia con la cantidad de devolucion
						$existencia = $existencia + $cantidad_produ;
						
						//Actualizamos existencia en inventario de la sucursal
						$sql_inventario = "UPDATE inventario SET existencia = '$existencia' WHERE idproducto = '$idproducto' AND idsucursales = '$idsucursal' AND idtallas = '$idtallas'";
						$db->consulta($sql_inventario);
					
					}
									
					//Guardamos el detalle de la devolucion
					$sqlproducto = "INSERT INTO cliente_devolucion_detalle(idcliente_devolucion,idproducto,cantidad,pv, porc_desc,total_descuento,total,idnota_remision,idtallas) VALUES ('$ultimoid','$idproducto','$cantidad_produ','$costo','$descuento_porc','$desc_producto','$subtotal','$idventa','$idtallas');";		
					$db->consulta($sqlproducto);
					

					//Guardamos el detalle de la entrada
					$sqlentrada_detalle = "INSERT INTO entradas_detalles (identradas,idproducto,cantidad,idtallas) VALUES ('$ultimoidentrada','$idproducto','$cantidad_produ','$idtallas');";
					$db->consulta($sqlentrada_detalle);
					
					//die("insertamos detalle");
					//$md->guardarMovimiento(utf8_decode('Cliente devolucion'),'cliente_devolucion_detalle',utf8_decode('Ingresamos producto a la  devolucion con id :'.$ultimoid.' el id producto es:'.$idproducto));
				}
				 
	        }
		}


		//$idventa = $_POST['idventa']; 
		//$desc = $_POST['desc']; 
		//$subtotal_total = $_POST['subtotal'];
		//$descuento_total= $_POST['descuento'];
		//$iva_total = $_POST['iva'];
		//$total_total = $_POST['total'];
					
		/*$idusuariosistema = $sesion->obtenerSesion('se_sas_Usuario');
		
		//obtenemos el cliente al que le agregaremos el saldo de la devolucion
		$sql_nota = "SELECT * FROM nota_remision WHERE idnota_remision = '$idventa'";
		$sql_nota_result = $db->consulta($sql_nota);
		$sql_nota_row = $db->fetch_assoc($sql_nota_result);*/
		
		//$cliente = $sql_nota_row['idcliente'];
		//$idsucursal = $sql_nota_row['idsucursales'];
		//$idsucursal = $_SESSION['se_sas_Sucursal'];
	
		/*//creamos la orden de devolucion primero
		$sql = "INSERT INTO cliente_devolucion(idnota_remision,idsucursales,idusuarios) VALUES ('$idventa','$idsucursal','$idusuariosistema');";
		$db->consulta($sql);
		$ultimoid=$db->id_ultimo();
		
		//guardamos entrada en las tablas entradas,entradas_detalles con tipoentrada = 1, que es el concepto de POR DEVOLUCION.
		$sql_entrada = "INSERT INTO entradas (idsucursales,tipoentrada,idusuarios,idnota_remision,descripcion) VALUES('$idsucursal','1','$idusuariosistema','$idventa','Ingreso por motivo de devolucion');";
		$db->consulta($sql_entrada);
		$ultimoidentrada=$db->id_ultimo();*/
	
	   
		//recorremos la session para poder ingresar todo a descripcion de la devolucion.
	    //$sumatotal = 0;
	
	/* foreach(array_reverse($itemsEnCesta,true) as $k => $v)
		    {
			    
				$idproducto = $k;
				$cantidad_produ = $v;
				
				
				//OBTENEMOS LOS VALORES DEL PRODUCTO Y COSTO EN LA NOTA DE REMISION
			    $sql = "SELECT * FROM nota_descripcion WHERE idproducto = '$idproducto' AND idnota_remision = $idventa";
				$result = $db->consulta($sql);
				$result_row = $db->fetch_assoc($result);
				$costo = $result_row['costo'];
				$descuento_porc = $result_row['descuento_porc'];
				//$desc_producto = $result_row['descuento'];
				
				$descuento = $result_row['descuento_porc']/100;
				$desc_producto = round(($costo*$cantidad_produ)*$descuento,2);
					
								
				$subtotal = number_format(($costo * $cantidad_produ) - $desc_producto,2,'.',',');
				//$sumatotal = $sumatotal + $subtotal;
				
				
				//actualizar inventarios.
				$sql_producto = "SELECT * FROM inventario WHERE idproducto = '$idproducto' AND idsucursales = '$idsucursal'";
				$result_producto = $db->consulta($sql_producto);
				$result_producto_row = $db->fetch_assoc($result_producto);
				$result_producto_num = $db->num_rows($result_producto);
				
				if($result_producto_num == 0){
					//Insertamos datos nuevos por que el producto no ha entrado
					$sql_inventario = "INSERT INTO inventario (idproducto,idsucursales,existencia) VALUES ('$idproducto','$idsucursal','$cantidad_produ');";
					$db->consulta($sql_inventario);
				
				}else{
					//Actualizamos inventario a lo que ya esta
					//Obtenemos la existencia de ese producto para sumarlo con la cantidad de devolucion
					$existencia = $result_producto_row['existencia'];
					//sumanmos la existencia que tenia con la cantidad de devolucion
					$existencia = $existencia + $cantidad_produ;
					
					//Actualizamos existencia en inventario de la sucursal
					$sql_inventario = "UPDATE inventario SET existencia = '$existencia' WHERE idproducto = '$idproducto' AND idsucursales = '$idsucursal'";
					$db->consulta($sql_inventario);
				
				}
				
				//Guardamos el detalle de la devolucion
				$sqlproducto = "INSERT INTO cliente_devolucion_detalle(idcliente_devolucion,idproducto,cantidad,pv, porc_desc,total_descuento,total) VALUES ('$ultimoid','$idproducto','$cantidad_produ','$costo','$descuento_porc','$desc_producto','$subtotal');";	
				
				$db->consulta($sqlproducto);
				
				
				//Guardamos el detalle de la entrada
				$sqlentrada_detalle = "INSERT INTO entradas_detalles (identradas,idproducto,cantidad) VALUES ('$ultimoidentrada','$idproducto','$cantidad_produ');";
				$db->consulta($sqlentrada_detalle);
				
				//die("insertamos detalle");
				//$md->guardarMovimiento(utf8_decode('Cliente devolucion'),'cliente_devolucion_detalle',utf8_decode('Ingresamos producto a la  devolucion con id :'.$ultimoid.' el id producto es:'.$idproducto));	
				 
	        }
	 */
	 
	 
	 		$sql_totales = "SELECT SUM((pv*cantidad)) as costo, SUM(total_descuento) as total_descuento, SUM(total) as total FROM cliente_devolucion_detalle WHERE idcliente_devolucion = '$ultimoid'";
			$result_totales = $db->consulta($sql_totales);
			$result_totales_row = $db->fetch_assoc($result_totales);
		
			$sub_total = $result_totales_row['costo'];
			$desc_total = $result_totales_row['total_descuento'];
			$total_dev = $result_totales_row['total'];
			$iva_total = round($total_dev*.16,2);
			
			$sql_update = "UPDATE cliente_devolucion SET subtotal = '$sub_total', descuento = '$desc_total', iva = '$iva_total', total = '$total_dev' WHERE idcliente_devolucion = '$ultimoid'";
			$db->consulta($sql_update);
			
			//subtotal,descuento,iva,total
	 //actualizamos la devolucion.
	 
	      //$descuento = $sumatotal * ($desc/100);
		  
		  //$total = $sumatotal - $descuento;
		  
		  //$iva = $total - round(($total / 1.16));
	 
	
	if($cliente > 0){
		
		//Buscamos si el cliente ya tiene saldo o no
		$sql_monedero_cliente = "SELECT * FROM clientes WHERE idcliente = '$cliente'";
		$result_monedero_cliente = $db->consulta($sql_monedero_cliente);
		$result_monedero_cliente_num = $db->num_rows($result_monedero_cliente);
		$result_monedero_cliente_row = $db->fetch_assoc($result_monedero_cliente);

		$saldo_anterior = $result_monedero_cliente_row['saldo_monedero'];
	
		//Sumamos el saldo que ya tiene con el total de la devolucion
		$saldo_actual = $saldo_anterior + $total_dev;


		//die($saldo." ".$total_total);
	
		//realizamos el guardado de su dinero en monedero del cliente.
	
		$sqlmonedero = "UPDATE clientes SET saldo_monedero = '$saldo_actual' WHERE idcliente = '$cliente'";
		$db->consulta($sqlmonedero);
	
		$sql_cliente_monedero = "INSERT INTO cliente_monedero (idcliente,monto,tipo,saldo_ant,saldo_act,idcliente_devolucion) VALUES ('$cliente','$total_dev','0','$saldo_anterior','$saldo_actual','$ultimoid');";
		$db->consulta($sql_cliente_monedero);
	}
	
	//eliminamos la sesion del carrito
    $sesion->eliminarSesion('itemsEnCestaDevolucion');
	$sesion->eliminarSesion('idnotarems');
	$sesion->eliminarSesion('idclient');
	
	
	$md->guardarMovimiento(utf8_decode('Cliente devolucion'),'cliente_devolucion_detalle',utf8_decode('Realizamos devolucion con id :'.$ultimoid.' el usuario:'.$idusuariosistema));
	
	$db->commit();	
	
	$suc = $_SESSION['se_sas_Sucursal'];
	$sql_imp = "SELECT * FROM sucursales WHERE idsucursales = '$suc'";
	$result_imp = $db->consulta($sql_imp);
	$result_imp_row = $db->fetch_assoc($result_imp);
	$impresion = $result_imp_row['notas_print'];	

	echo "1|".$ultimoid."|".$impresion;

	}else{ 
           throw new Exception('No Funciona la conexcion. El Error es el siguiente: |10000');
         }

	 }catch(Exception $e) {
		  $db->rollback();	
		  $v = explode ('|',$e);
		  $n = explode ("'",$v[1]);
		  echo "0|Se hizo rollback ". $db->m_error($n[0]);   }

?>