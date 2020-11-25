<?php
try {
     require_once("../clases/conexcion.php");
	 require_once("../clases/class.Clientes.php");
	 require_once("../clases/class.Sesion.php");
	 require_once("../clases/class.Categoria_Descuento.php");
	 require_once("../clases/class.Tallas.php");
	 
	 $db= new MySQL();
	 $cli = new Clientes();
	 $cd = new categoria_descuento();
	 $ta = new Tallas();
	 
	 
	 $cli->db = $db;
	 $cd->db = $db;
	 $ta->db = $db;
	 
	 
	 $se = new Sesion();

//eliminamos toda sesion que pueda existir con el carrito

//$se->eliminarSesion('itemsEnCestaDevolucion');

	 
	
	//enviamos datos a las variables de la tablas	
	$idorden =  $_POST['v_idorden'];
	$dev = $_POST['dev'];
	
	$sql = "SELECT * FROM nota_remision WHERE idnota_remision = $idorden";
	$sql .= ($dev == 1) ? " AND estatus = '1'":"";
	$result_orden = $db->consulta($sql);
	$result_orden_row = $db->fetch_assoc($result_orden);
	$result_orden_num = $db->num_rows($result_orden);


	   if ($result_orden_num <= 0)
	   {
		   echo "<p style='text-align:center; color:red;'>Lo sentimos no se encontraron los resultados de la busqueda</p> ";
		 
		 }
	else 
	{	
	
	    
                //OBTENEMOS VALORES DE LA TABLA DE NO. DE ORDEN
				
				$fecha_realizacion = $result_orden_row['fechapedido'];
				$fecha_depago =  $result_orden_row['fecha_pago'];
				$idcliente =  $result_orden_row['idcliente'];
				$idniveles = $result_orden_row['idniveles'];
			     
				$porc_descuento = 	$result_orden_row['porc_desc_directo'];
				$subtotal =  $result_orden_row['subtotal'];
				$iva =  $result_orden_row['iva'];
				$desc_paquete =  $result_orden_row['desc_paquetes'];
				$desc_producto = $result_orden_row['desc_producto'];
				$desc_directo = $result_orden_row['desc_directo'];
				$total =  $result_orden_row['total'];
		   
				//obtenemos el nombre del cliente
				
				$cli->idCliente = $idcliente;
				$result_cliente = $cli->ObtenerInformacionCliente();
				
				
				if($idcliente != 0){
					$nombrecliente = $result_cliente['nombre'].' '.$result_cliente['paterno'].' '.$result_cliente['materno'];
					$desc_cliente = $result_cliente['porc_desc'];
				}else{
					$nombrecliente = "PUBLICO GENERAL";
				}
				
				
				//Obtenemos el nombre del nivel que trae el cliente
				$cd->idniveles = $idniveles;
				$result_nivel = $cd->buscarNivel();
				$result_nivel_row = $db->fetch_assoc($result_nivel);
				
				$nivel = utf8_encode($result_nivel_row['nombre']);
				
		   
		   ?>



        	<div style="font-size: 11px; color: #1F1F20; text-transform: uppercase; text-shadow: 0 1px 0 #fff;">
        		
                <table width="100%" border="0" cellspacing="2" cellpadding="2">
                  <tbody>
                    
                    <tr>
                      <td width="20%">NO. VENTA: <?php echo $idorden; ?></td>
                      <td>FECHA: <?php echo $fecha_realizacion; ?></td>
                      <td>FECHA DE PAGO: <?php echo $fecha_depago; ?></td>
                    </tr>
                    
                    <tr>
                      <td width="20%">ID CLIENTE: <?php echo $idcliente; ?>
                       </td>
                      <td width="40%">CLIENTE: <?php echo utf8_encode($nombrecliente); ?></td>
                      <!--<td width="22%">DESC. CLIENTE: <?php echo $desc_producto; ?></td>-->
                      <td>NIVEL DE DESCUENTO: <?php echo $nivel; ?></td>
                    </tr>
                    
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="2">&nbsp;</td>
                    </tr>
                    </tbody>
                </table>
             </div>
             
             
             <table  class="" cellspacing="0" id="d_modulos" style="border-top: 1px #7B7979 solid; width: 100%; font-size: 12px;"> 
			<thead> 
				<tr> 
   					<th width="30" align="center" style="text-align: center;">DEV</th>
                    <th align="center" style="text-align: center;">FOTO</th>
                    <th align="center" style="text-align: center;">COD. PRODUCTO</th>
					<th align="center" style="text-align: center;">TALLA</th>
                    <th align="center" style="text-align: center;">CAT</th>
                    <th align="center" style="text-align: center;">NOMBRE</th>
                    <th align="center" style="text-align: center;">CANTIDAD</th>
                    <th align="center" style="text-align: center;">PV.</th>
                    <!--<th align="center">% DESC</th>-->
                    <th align="center" style="text-align: center;">DESC</th>
                    <th align="center" style="text-align: center;">TOTAL</th>
              </tr> 
			</thead> 
			<tbody> 
            
            
            <?php
			
			
			$sql_detalle = "SELECT nd.*,p.nombre, cp.nombre as cat, p.foto as foto, cp.idcategoria_precio, nd.idtallas FROM nota_descripcion nd, productos p, categoria_precio cp WHERE p.idproducto = nd.idproducto AND p.idcategoria_precio = cp.idcategoria_precio AND nd.idnota_remision = $idorden";
			$r_detalle = $db->consulta($sql_detalle);
			$r_detalle_row = $db->fetch_assoc($r_detalle);
			$r_detalle_num = $db->num_rows($r_detalle);
			
			
			if($r_detalle_num!=0)
			{
			
			$cantidadProducto = 0;
			$subtotal = 0;
			
            do
			{  
				$idproducto = $r_detalle_row['idproducto'];
			
				$sql_devueltos = "SELECT cd.*, COUNT(cdd.idproducto), SUM(cdd.cantidad) as devueltos FROM cliente_devolucion cd, cliente_devolucion_detalle cdd  WHERE cdd.idnota_remision = '$idorden' AND cdd.idproducto = '$idproducto' AND cd.idcliente_devolucion = cdd.idcliente_devolucion AND cd.estatus = 1";
				$result_devueltos = $db->consulta($sql_devueltos);
				$result_devueltos_row = $db->fetch_assoc($result_devueltos);
		 		
				if($result_devueltos_row['devueltos'] == ''){
					$devueltos = '0';
				}else{
					$devueltos = $result_devueltos_row['devueltos'];
				}
				
				
				$ta->idtallas = $r_detalle_row['idtallas'];
				$result_tallas = $ta->buscarTalla();
				$result_tallas_row = $db->fetch_assoc($result_tallas);
			?>
            
				
				<tr> 
   				   <td width="30" align="center" bgcolor="#E8E7E7"><?php  echo $devueltos; ?></td>			
                   <td align="center" bgcolor="#E8E7E7" style="cursor:pointer;" onMouseOver="AbrirModalImagenTwo('ModalImagen<?php echo $idproducto; ?>','400','400','<?php echo $idproducto; ?>');" onMouseOut="$('#ModalImagen<?php echo $idproducto; ?>').css('display','none'); $('#contenido_modal_img').html('');">
                   		<img width="18" height="18" src="images/camara.png" style=" cursor:pointer;" />
                        
                        <!-- MODAL PARA MOSTRAR IMAGEN -->
                        <div id="ModalImagen<?php echo $idproducto ?>" class="ventana" style="margin-left:-290px;">
                                <div id="contenido_modal_img<?php echo $idproducto; ?>">
                                    <img width="400" height="400" <?php if ($r_detalle_row['foto']==""){ echo 'src="images/no_hay_imagen.png" ';   } else { ?> src="productos/imagenes/<?php echo $r_detalle_row['foto'];} ?>" />
                                </div>
                        </div>
                 	</td>                  
   				   <td align="center" bgcolor="#E8E7E7" ><?php echo strtoupper($r_detalle_row['idproducto']); ?> </td>
					<td align="center" bgcolor="#E8E7E7" ><?php echo utf8_encode($result_tallas_row['talla']); ?> </td>
   				   <td align="center" bgcolor="#E8E7E7" ><?php echo utf8_encode($r_detalle_row['cat']); ?> </td>
   				   <td align="left" bgcolor="#E8E7E7"><?php echo utf8_encode($r_detalle_row['nombre']); ?></td>
   				   <td align="center" bgcolor="#E8E7E7"><?php echo $r_detalle_row['cantidad']; ?></td>
   				   <td align="center" bgcolor="#E8E7E7"><?php echo $r_detalle_row['costo']; ?></td>
                   <!--<td align="center" bgcolor="#E8E7E7"><?php if($r_detalle_row['idcategoria_precio'] == 7){echo "50+20";}else{ echo $r_detalle_row['descuento_porc']." %";} ?></td>-->
   				   <td align="center" bgcolor="#E8E7E7"><?php  echo "$ ".$r_detalle_row['descuento']; ?></td>
                  

                  <td align="center" bgcolor="#E8E7E7"><?php echo number_format(($r_detalle_row['cantidad']*$r_detalle_row['costo']-$r_detalle_row['descuento']),2,'.',','); ?></td>
                  <!--Aqui estaba el thum -->
                    
                </tr>
				
            <?php 
			   $subtotal = $subtotal + $r_detalle_row['cantidad']*$r_detalle_row['costo'];
			   $cantidadProducto += $r_detalle_row['cantidad'];
			   
			   } while($r_detalle_row = $db->fetch_assoc($r_detalle));
			   
			  
			   
			   ?>
			   <tr>
			     <td align="center" colspan="9" >&nbsp;</td>
			     <td align="right">&nbsp;</td>
		      </tr>
			   <tr>
				  <td align="center" colspan="5" >&nbsp;</td>
				  <td align="center" bgcolor="#C9C6C6">Cantidad:</td>
				  <td align="center"><?php echo $cantidadProducto; ?></td>
				  <td align="center">&nbsp;</td>
			     <td align="center" bgcolor="#C9C6C6">SubTotal:</td>
				  <td align="right">$ <?php echo number_format($subtotal,2,'.',','); ?></td>
			  </tr>
				<tr>
				  <td align="center" colspan="7" >&nbsp;</td>
				  <!--<td align="center" bgcolor="#C9C6C6">DESC. %</td>
				  <td align="center"><?php echo $porc_descuento; ?> %</td>-->
				  <td align="center"><input name="v_porcdesc" type="hidden" id="v_porcdesc" value="<?php echo $porc_descuento; ?>"></td>
				  <td align="center" bgcolor="#C9C6C6">Desc Dir + Desc Nivel</td>
				  <td align="right">$ <?php echo number_format($desc_directo + $desc_producto,2,'.',','); ?></td>
			  </tr>
				<tr>
				  <td align="center" colspan="5" >&nbsp;</td>
				  <td align="center">&nbsp;</td>
				  <td align="center">&nbsp;</td>
				  <td align="center">&nbsp;</td>
				  <td align="center" bgcolor="#C9C6C6">Total:</td>
				  <td align="right">$ <?php echo $total; ?></td>
			  </tr>
			   
			   <?php
			   
			   
			}else
			{
				?>
				<tr>
				  <td colspan="6" align="center" >NO EXISTE PRODUCTO EN ESTA ORDEN</td>
			  </tr>
				
				<?php
			}
			?>
            	
			</tbody> 
			</table>
              <br>        
           <?php 
		    }
			//$se->eliminarSesion('itemsEnCestaDevolucion'); 
		   }
		   catch(Exception $e)
{
	$db->rollback();
	echo "Error. ".$e;
}		


		   ?> 