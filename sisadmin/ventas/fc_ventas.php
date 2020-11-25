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
	//Declaramos objeto de sesión
	$se = new Sesion();
	//Validamos la sesión existente
	if(!isset($_SESSION['se_SAS']))
	{
		//Si no existe mandamos a login..
		header("Location: ../login.php");
		exit;
	}
/*============================================*/

	//importamos clases a utilizar 
	require_once("../clases/conexcion.php");
	require_once("../clases/class.ShoppingCar.php");
	require_once("../clases/class.Ventas.php");
   	require_once("../clases/class.Tallas.php");
	require_once("../clases/class.Clientes.php");
	require_once("../clases/class.Fechas.php");
	require_once("../clases/class.Configuracion.php");

	//Declaración de objetos de clase.
   	$db = new MySQL();
   	$carrito = new ShoppingCar();
   	$ta = new Tallas();
	$ve = new Ventas();
	$cl = new Clientes();
	$fe = new Fechas();
	$conf = new Configuracion();

   	//envio de objeto de conexión a las clases que lo requieren
	$ta->db = $db;
	$ve->db = $db;
	$cl->db = $db;
	$conf->db = $db;
   
	//Declaramos y asignamos valor a variables que vamos a utilizar
   	$idsucursales = $_SESSION['se_sas_Sucursal'];
	$idnota_remision = $_GET['id'];

/*========================== INICIA CONSULTAS ==========================*/

	//Obtenemos la lista de tallas disponibles
	$result_tallas = $ta->TallasActivas();
	$result_tallas_row = $db->fetch_assoc($result_tallas);
	$result_tallas_num = $db->num_rows($result_tallas);

	//Obtenemos datos generales del pedido
	$ve->id_notaremision = $idnota_remision;
	$result_pedido = $ve->obtener_generales_pedido();
	$result_pedido_row = $db->fetch_assoc($result_pedido);

	//Obtenemos el id del cliente de la consulta de los datos del pedido
	$idcliente = $result_pedido_row['idcliente'];
	$fecha_pedido = explode(" ",$result_pedido_row['fechapedido']);

	//Validamos si es un cliente normal o de publico general
	if($idcliente != 0)
	{
		$cl->idCliente = $idcliente;
		$datos_cliente = $cl->ObtenerInformacionCliente();
		$nombre_cliente = utf8_encode($datos_cliente['nombre']." ".$datos_cliente['paterno']." ".$datos_cliente['materno']);
	}else{
		$nombre_cliente = "PUBLICO GENERAL";
	}


	//Obtenemos los productos que tiene el pedido
	$result_pedido_detalle = $ve->obtener_detalles_pedido();
	$result_pedido_detalle_num = $db->num_rows($result_pedido_detalle);
	$result_pedido_detalle_row = $db->fetch_assoc($result_pedido_detalle);

	$row_configuracion = $conf->ObtenerInformacionConfiguracion();			
	$iva = $row_configuracion['iva']/100;


/*========================== TERMINA CONSULTAS =========================*/



?>

<script type="text/javascript" src="js/fn_PuntodeVenta.js"></script>
	
<div class="card mb-3">
	<div class="card-header">
		<h5 class="card-title" style="float: left; margin-top: 5px;">MODIFICAR ORD. COMPRA</h5>
		<button type="button" onClick="aparecermodulos('ventas/vi_pedidos.php','main');" class="btn btn-info" style="float: right;">VER PEDIDOS</button>
		<div style="clear: both;"></div>
	</div>
</div>

	<div class="row">
		<div class="col-md-6">
			<div class="card mb-3">
				<div class="card-header">
					<h5 class="card-title" style="float: left; margin-top: 5px;">DATOS GENERALES</h5>
				</div>

				<div class="card-body">
					<div class="form-group">
						 <label># PEDIDO</label>
						<input name="v_idnota_remision" class="form-control" type="text" id="v_idnota_remision"  onkeypress="bloquearMas(event.keyCode);" value="<?php echo $idnota_remision; ?>" readonly />
					</div>
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								 <label>FECHA</label>
								<input name="v_f_pedido" class="form-control" type="text" id="v_f_pedido" onkeypress="bloquearMas(event.keyCode);" value="<?php echo $fe->f_esp($fecha_pedido[0]); ?>" readonly />
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group">
								 <label>HORA</label>
								<input name="v_f_pedido" class="form-control" type="text" id="v_f_pedido" onkeypress="bloquearMas(event.keyCode);" value="<?php echo $fecha_pedido[1]; ?>" readonly />
							</div>
						</div>
					</div>
					
					
					<div class="form-group">
						 <label>CLIENTE</label>
						<input name="v_nombre_cliente" class="form-control" type="text" id="v_nombre_cliente" placeholder="Jose Luis Gomez Aguiar"  onkeypress="bloquearMas(event.keyCode);" value="<?php echo $nombre_cliente; ?>" readonly />
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-6">
			<div class="card mb-3">
				<div class="card-header">
					<h5 class="card-title" style="float: left; margin-top: 5px;">AGREGA PRODUCTOS</h5>
					<button type="button" onClick="L_Productos_edit('<?php echo $idnota_remision; ?>');" class="btn btn-info" style="float: right;">PRODUCTOS</button>
					<div style="clear: both;"></div>
				</div>

				<div class="card-body">
					<div class="form-group">
						 <label>TALLA</label>
						<select name="talla" id="talla" class="form-control">
							<?php
							do
							{
							?>
							<option value="<?php echo $result_tallas_row['idtallas']; ?>"><?php echo utf8_encode($result_tallas_row['talla']); ?></option>
							<?php
							}while($result_tallas_row = $db->fetch_assoc($result_tallas));
							?>
						</select>
					</div>
					
					<div class="form-group">
						 <label>ID PRODUCTO</label>
						<input type="text" name="v_idproducto" id="v_idproducto" class="form-control" onKeyDown="bloquear_enie(event.keyCode);" onkeypress="bloquear_enie(event.keyCode); addproducto_edit('<?php echo $idnota_remision; ?>')"/>
						<input name="v_cantidad" type="hidden" id="v_cantidad" value="1" />
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-12">
			<div class="card mb-3">
				<div class="card-header">
					<h5 class="card-title" style="float: left; margin-top: 5px;">DETALLES</h5>
				</div>

				<div class="card-body">
					<div id="d_productos_shoping" >
					 	<div style="min-height:500px; background-color: #D8D6D6; overflow:auto" >
                    		<table width="100%" cellspacing="2" cellpadding="2" class="table table-bordered">
                  				<tr>
                    				<td width="3%" align="center"  bgcolor="#CCCCCC" >&nbsp;</td>
                    				<td>Foto</td>
									<td>Existencia</td>
                      				<td width="11%" align="center"  bgcolor="#CCCCCC" >Cod. Producto</td>
					  				<td width="6%" align="center" bgcolor="#CCCCCC" >Talla</td>
                      				<td width="12%" align="center"  bgcolor="#CCCCCC" >Cat. Producto</td>
                      				<td width="33%" align="center" bgcolor="#CCCCCC" >Nombre Producto</td>
                      				<td width="5%" align="center" bgcolor="#CCCCCC" >Cant.</td>
                      				<td width="6%" align="center" bgcolor="#CCCCCC" >P.V</td>
                      				<td width="11%" align="center" bgcolor="#CCCCCC" > Desc %</td>
                      				<td width="9%" align="center" bgcolor="#CCCCCC" >Total Desc</td>
                      				<td width="10%" align="center" bgcolor="#CCCCCC" >Total</td>
                  				</tr>
                      			
								
								<?php
								if($result_pedido_detalle_num != 0){
									$subtotal = 0;
									$descuento = 0;
									$total_pagar = 0;
									$total_productos = 0;
									do
									{
										$sql_existencia = "SELECT * FROM inventario WHERE idproducto = '".$result_pedido_detalle_row['idproducto']."' AND idtallas = '".$result_pedido_detalle_row['idtallas']."' AND idsucursales = '".$result_pedido_row['idsucursales']."'";
										$result_existencia = $db->consulta($sql_existencia);
										$result_existencia_row = $db->fetch_assoc($result_existencia);
										
										$existencia = $result_existencia_row['existencia'];	
										
										if($existencia <= 0){
											$existencia = 0;
											$color = '#b50000';
										}else{
											$color = '#FFFFCC';
										}
								?>
								<tr>
                        			<td align="center" valign="top" bgcolor="<?php echo $color; ?>" style="color:#000">                            			
										<button type="button" onclick="eliminar_de_nota('<?php echo $result_pedido_detalle_row['idproducto']; ?>','<?php echo $idnota_remision; ?>','<?php echo $result_pedido_detalle_row['idtallas']; ?>')" title="BORRAR" class="btn btn-danger">
											<i class="mdi mdi-delete-empty"></i>
										</button>
										
                        			</td>
									
                        			<td align="center" bgcolor="<?php echo $color; ?>" style="cursor:pointer;" onMouseOver="AbrirModalImagenTwo('ModalImagen<?php echo $result_pedido_detalle_row['idproducto']; ?>','400','400','<?php echo $result_pedido_detalle_row['idproducto'] ?>');" onMouseOut="$('#ModalImagen<?php echo $result_pedido_detalle_row['idproducto']; ?>').css('display','none'); $('#contenido_modal_img').html('');">
                   						<img width="18" height="18" src="images/camara.png" style=" cursor:pointer;" />
                        
										<!-- MODAL PARA MOSTRAR IMAGEN -->
										<div id="ModalImagen<?php echo $result_pedido_detalle_row['idproducto']; ?>" class="ventana" style="margin-left:-290px;">
											<div id="contenido_modal_img<?php echo $result_pedido_detalle_row['idproducto']; ?>">
												<img width="400" height="400" <?php if ($result_pedido_detalle_row['foto']==""){ echo 'src="images/no_hay_imagen.png" ';   } else { ?> src="productos/imagenes/<?php echo $result_pedido_detalle_row['foto'];} ?>" />
											</div>
										</div>
                 					</td>   
									
									<td align="center" valign="top" bgcolor="<?php echo $color; ?>" style="color:#000"><?php echo $existencia; ?></td>
                    
                          			<td align="center" valign="top" bgcolor="<?php echo $color; ?>" style="color:#000"><?php echo utf8_encode($result_pedido_detalle_row['idproducto']);?></td>
									
						  			<td align="center" valign="top" bgcolor="<?php echo $color; ?>"  style="padding-left:5px; color:#000;"><?php echo utf8_encode($result_pedido_detalle_row['talla']); ?></td>
									
                         			<td align="center" valign="top" bgcolor="<?php echo $color; ?>" style="color:#000"><?php echo utf8_encode($result_pedido_detalle_row['nombre_categoria']);?></td>
									
                        			<td valign="top" bgcolor="<?php echo $color; ?>"  style="padding-left:5px; color:#000;"><?php echo utf8_encode($result_pedido_detalle_row['nombre']); ?></td>
									
                          			<td align="center" valign="top" bgcolor="<?php echo $color; ?>"  style="padding-left:5px; color:#000;"><?php echo $result_pedido_detalle_row['cantidad']; ?></td>
           
									<td align="center" valign="top" bgcolor="<?php echo $color; ?>"  style="padding-left:5px; color:#000;"><?php echo '$ '.$result_pedido_detalle_row['costo']; ?></td>
							
           							<td align="center" valign="top" bgcolor="<?php echo $color; ?>" style="padding-left:5px; padding-right:5px; color:#000"  >
										<span style="padding-left:5px; color:#000;">
											<?php echo $result_pedido_detalle_row['descuento_porc']."%"; ?>
										</span>
									</td>
							
                          			<td align="center" valign="top" bgcolor="<?php echo $color; ?>" style="padding-left:5px; padding-right:5px; color:#000"  >
                                		<span style="padding-left:5px; color:#000;"><?php echo '$ '.$result_pedido_detalle_row['descuento'];?></span>
                          			</td>
							
                          			<td valign="top" style="padding-left:5px; padding-right:5px; color:#fff;  background-color: #666364;" align="center" >
						     			<?php echo "$ ".number_format($result_pedido_detalle_row['total'],2,'.',','); ?>
                             		</td>
                      			</tr>
								<?php
										$subtotal = $subtotal + $result_pedido_detalle_row['subtotal'];
										$descuento = $descuento + $result_pedido_detalle_row['descuento'];
										$total_pagar = $total_pagar + $result_pedido_detalle_row['total'];
										$total_productos = $total_productos + $result_pedido_detalle_row['cantidad'];
									}while($result_pedido_detalle_row = $db->fetch_assoc($result_pedido_detalle));
									
									$subtotal = round($total_pagar/(1+$iva),2);
				   					$iva = $total_pagar - $subtotal;	 
								}
								?>
				   
								<tr>
									<td colspan="10" align="right" style="color:#000">SubTotal:</td>
									<td colspan="2" style=" padding-left:5px; padding-right:5px; color:#000" bgcolor="#F2F2F2">$ <?php echo number_format($subtotal,2,'.',','); ?></td>
								</tr>
                  				
								<tr>
                    				<td colspan="10" align="right"  style="color:#000">Descuento:</td>
                    				<td colspan="2" bgcolor="#FF0000" style=" padding-left:5px; padding-right:5px; color:#000" >- $ <?php echo number_format($descuento,2,'.',','); ?></td>
                  				</tr>
                  				
								<tr>
                      				<td colspan="10" align="right"  style="color:#000">IVA:</td>
                      				<td colspan="2" style=" padding-left:5px; padding-right:5px; color:#000" >$ <?php echo number_format($iva,2,'.',','); ?></td>
                  				</tr>
								
                  				<tr style="font-size:18px; ">
                      				<td colspan="10" align="right"  style="color:#000;">TOTAL A PAGAR:</td>
                      				<td colspan="2" style="padding-left:5px; padding-right:5px; color:#000;" bgcolor="#CCCCCC">
										<span style="padding-left:5px; padding-right:5px; color:#000">
											<?php echo "$ ".number_format(round($total_pagar,2),2);?>
										</span>
									</td>
                 				</tr>
              				</table>
           				</div> 
						
						<div id="d_sumatorias_pedido">
 							<table width="100%" border="0" cellspacing="2" cellpadding="2">
  								<tbody>
									<tr style="height: 30px; font-style: normal; font-weight: bold; font-size: 16px;"; bgcolor="#959595">
									  <td width="18%" align="right" bgcolor="#F0EDED">Total de Productos:</td>
									  <td width="9%" align="center" style="background-color: #DADADA; padding: 0px 5px 0px 5px; font-size: 24px;" id="v_totalproducto"><?php echo  $total_productos;?></td>
									  <td width="22%" align="right" bgcolor="#F0EDED">Monto sin descuento:</td>
									  <td width="11%" align="center" style="background-color: #DADADA; padding: 0px 5px 0px 5px; font-size: 24px;" id="v_montodescuento"><?php echo $subtotal;?></td>
									  <td width="12%" align="right" bgcolor="#F0EDED">Descuento:</td>
									  <td width="11%" align="center" style="background-color: #DADADA; padding: 0px 5px 0px 5px; font-size: 24px;" id="v_descuento"><?php echo number_format($descuento,2,'.',','); ?></td>
									  <td width="9%" align="right" bgcolor="#F0EDED">Total:</td>
									  <td width="8%" align="center" style="background-color: #DADADA; padding: 0px 5px 0px 5px; font-size: 24px;" id="v_totaldescuento"><?php echo number_format($total_pagar,2,'.',',');?></td>
									</tr>
  								</tbody>
							</table>
    					</div>
						
					</div>
				</div>
				
				<!--<div class="card-footer text-muted">
					<input name="v_sucursal" type="hidden" id="v_sucursal" value="<?php echo $idsucursales;  ?>" />
					<button type="button" onClick="G_Pedido();" class="btn btn-success alt_btn" style="float: right;" <?php echo $disabled; ?>>GENERAR PEDIDO</button>
				</div>-->
			</div>
		</div>
		
		<!--<div class="col-md-12">
			<div class="card">
				<div class="card-body">	
					<button type="button" onClick="modificar_pedido();" class="btn btn-primary alt_btn" style="float: right;" <?php echo $disabled; ?>>Generar Pedido</button>					
				</div>
			</div>
		</div>-->
	</div>