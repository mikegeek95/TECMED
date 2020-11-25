<?php
require_once('class.Sesion.php');
require_once('class.Funciones.php');
require_once('conexcion.php');
require_once('class.Inventario.php');
require_once('class.MovimientoBitacora.php');
require_once('class.Productos.php');
require_once('class.Configuracion.php');
require_once('class.Entregas.php');
require_once('class.Clientes.php');




class ShoppingCar
{
	
	/**** Atributos de tipo objetos ****/
	private $sesion;
	private $funcion;
	private $db;
	private $inventario;
	private $mbitacora;
	private $produ;
	private $confi;
	private $paquetes;
	private $entrega;
	private $clientes;
	
	
	/**** Atributos generales de la clase ****/
	public $row_productos;
	public $numRows;
	public $productos;
	public $idnotas;
	public $cvnom_producto = '';
	public $no_distribuidor = '';
	public $idordenes = '';
	
	
	function ShoppingCar ()
	{
		$this->sesion = new Sesion();
		$this->db = new MySQL();
		$this->funcion = new Funciones();
	    $this->mbitacora = new MovimientoBitacora();
		
		$this->inventario = new Inventario();
		$this->inventario->db = $this->db;
		
		$this->produ = new Producto();		
		$this->produ->db = $this->db;
		
		$this->confi = new Configuracion();
		$this->confi->db = $this->db;
		
		
		
		
		$this->entrega = new Entregas ();
		$this->entrega->db = $this->db;
		
		$this->clientes = new Clientes();
		$this->clientes->db = $this->db;
		
	}// fin de constructor
	
	
	
	/**************** 
	INICIA TODOS LOS PROCESOS DE LAS CESTAS DEL SHOPING CART
	****************/ 
	
	
	 public function addProductoEntrada($item,$cantidad,$costo,$talla)
	{ $encontrado="";
		//SI LA CANTIDAD ES 0 no hagas nada.
		if ($cantidad==0)
		{
		   return;
		}
		//termina.
		
		
		//si trae un producto.... realizas esto...
		if($item)
		{ 
		   if(!isset($_SESSION['itemsEnCestaEntrada']))
		   {  
			  
			  $this->sesion->crearSesion('itemsEnCestaEntrada',null);
			  $_SESSION['itemsEnCestaEntrada'][strtoupper($item."|".$talla)] = $cantidad."|".$costo;
		
		   }
		   else
		   {  
			  foreach($_SESSION['itemsEnCestaEntrada'] as $k => $v)
			  {  
				 if (strtoupper($item."|".$talla) == strtoupper($k))
				 {  
				 
				     $cadena = explode("|",$_SESSION['itemsEnCestaEntrada'][$k]);
				 
					 $_SESSION['itemsEnCestaEntrada'][strtoupper($k)] = $cantidad + $cadena[0] ."|".$costo;
					 $encontrado=true;  
					 
					/* echo '<script type="text/javascript">
					 		setTimeout(function(){$("#bien").slideUp()},3000);
					 </script>';*/
				 } else{
					 $encontrado=false;
				 }  
			  }  
			  if (!$encontrado)
			  {
				   $_SESSION['itemsEnCestaEntrada'][strtoupper($item."|".$talla)]=$cantidad."|".$costo;
				  
					/* echo '<script type="text/javascript">
					 		setTimeout(function(){$("#bien").slideUp()},3000);
					 </script>';*/
			   }    
		    }  
		 }
		  
	 }
	 
	 
	 public function addProducto($item,$cantidad)
	{
		//SI LA CANTIDAD ES 0 no hagas nada.
		if ($cantidad==0)
		{
		   return;
		}
		//termina.
		
		
		//si trae un producto.... realizas esto...
		if($item)
		{ 
		   if(!isset($_SESSION['itemsEnCesta']))
		   {  
			  
			 $this->sesion->crearSesion('itemsEnCesta',null);
			  $_SESSION['itemsEnCesta'][$item] = $cantidad;
		
		   }
		   else
		   {  
			  foreach($_SESSION['itemsEnCesta'] as $k => $v)
			  {  
				 if (strtoupper($item) == strtoupper($k))
				 {  
					 $_SESSION['itemsEnCesta'][strtoupper($k)]=$cantidad;  
					 $encontrado=1;  
				 }  
			  }  
			  if (!$encontrado){ $_SESSION['itemsEnCesta'][$item]=$cantidad; }    
		    }  
		 }
		  
	 }// fin de método addProducto
	 
	 
	 
	 
	 
	  public function delProducto($item)
	 {
		 //$_SESSION['count']--;
		  if (isset($_SESSION['itemsEnCestaEntrada']))
		  {
				foreach($_SESSION['itemsEnCestaEntrada'] as $k => $v)
				{ 
				  if (isset($item))
				   {
					    unset ($_SESSION['itemsEnCestaEntrada'][$item]);
				   }
				   
				}
		  } 
		  
	 }// fin de método delProducto
	 
	 
	
	 
	  /*****************
         TERMINAN LOS METODOS DE LAS CESTAS
      ******************/
	 
	
	
	
	
	
	public function crearCatalogosProductos()
	{		
		
		$cont = 1;
		
		$condicion = '';
		if($this->cvnom_producto!='')
		{
		   $condicion = "AND (clave_producto LIKE '%$this->cvnom_producto%' OR nombre LIKE '%$this->cvnom_producto%')";
		}
					$query_productos = "SELECT * FROM productos WHERE estatus = 1 ".$condicion;
			 
		try
		{
			$productos = $this->db->consulta($query_productos);
			$row_productos = $this->db->fetch_assoc($productos);
			$totalRows = $this->db->num_rows($productos);
			?>
<table width="100%" cellspacing="2" cellpadding="2">
				<tr>
				  <td  align="center">Clave del Producto</td>
					<!--<td  align="center">&nbsp;</td>-->
					<td  align="center">Producto</td>
					<td  align="center">Descripci&oacute;n</td>
					<td  align="center">Existencia</td>
					<td  align="center">Precio Unitario </td>
					<td  align="center">Acci&oacute;n</td>
				</tr>
				<?php 
				if($totalRows>0)
				{
					do
					{
				?>
						<tr>
						  <td width="10%" valign="middle"><input name="didproducto<?php echo $cont;?>" type="hidden" value="<?php echo $row_productos['clave_producto'];?>" id="didproducto<?php echo $cont;?>" />
						  <?php echo htmlentities($row_productos['clave_producto'], ENT_QUOTES | ENT_IGNORE, "ISO-8859-1");?></td>
							<!-- <td width="9%" align="center" valign="middle" style="color:#000"><img src="imagenes/membresia.png" width="80" height="80" /></td>-->
							<td width="21%" valign="middle"><?php echo htmlentities($row_productos['nombre'], ENT_QUOTES | ENT_IGNORE, "ISO-8859-1");?></td>
							<td width="37%"><?php echo htmlentities($row_productos['descripcion'], ENT_QUOTES | ENT_IGNORE, "ISO-8859-1");?></td>
						  <td width="13%" align="center"><?php echo $this->inventario->obtenerStockProducto($row_productos['clave_producto']);?></td>
						  <td width="10%" align="center"><?php echo '$'.$row_productos['precio1'];?></td>
							<td width="9%" valign="top" align="center"> 
								Cantidad:
								<select name="cantidad_producto<?php echo $cont; ?>" id="cantidad_producto<?php echo $cont; ?>" style="border-color:#FFF">
									<?php
									$conta = 1;
									for($x=1;$x<=$this->inventario->obtenerStockProducto($row_productos['clave_producto']);$x++)
									{
									?>
										<option value="<?php echo $x;?>"<?php if($x==1){ echo 'selected';}?>><?php echo $x;?></option>
									<?php 
									   $conta++;
									   if($conta>=100)
									   {
										   $x = $this->inventario->obtenerStockProducto($row_productos['clave_producto']);
									   }
									}
									?>
								</select>
								<br>
							  <a href="#" <?php if($this->inventario->obtenerStockProducto($row_productos['clave_producto'])!=0){?>onclick="agregarCarrito(<?php echo $cont;?>,'d_orden_pedido','didproducto','cantidad_producto')" <?php } ?>><img src="images/001.png" width="15px" height="15px" title=":: Agregar Carrito ::"/></a>
							</td>
						</tr>
				<?php
				        $cont++; 
					}while($row_productos = $this->db->fetch_assoc($productos));
				}
				else
				{
				?>
				   <tr>
					 <td colspan="6">
					   Lo sentimos no contamos con ning&uacute;n producto en nuestra base de datos
					 </td>
				   </tr>
				<?php 
				}
				?>
</table>
		 <?php 						   
		}// fin de try
		catch(Exception $e)
		{
			echo 'Error MySQL'.$e;
		}
	}// fin de método crearCatalogosProductos
	
	
	
	 
	 
	 
	 
	
	 
	 
	 
	
	 
	  public function verCarrito()
	  {
		  $contador = 1;		  
		  $itemsEnCesta = $_SESSION['itemsEnCestaEntrada'];
		  $cantidad = count($itemsEnCesta); // obtenemos la longitud del array de sesion
		  
		  if (isset($itemsEnCesta) && $cantidad>0) // validamos que la session de array exista y que contenga un producto
		  {
		  ?>
          
<div style="height:500px; background-color: #E70003; overflow:auto" >
          
          
                 
  <table width="100%" cellspacing="2" cellpadding="2">
                  <tr>
                    <td width="6%" align="center" valign="top" bgcolor="#CCCCCC" >Acci&oacute;n</td>
                      <td width="6%" align="center" valign="top" bgcolor="#CCCCCC" >C&oacute;digo Productos</td>
                      <td width="18%" align="center" bgcolor="#CCCCCC" >Descripci&oacute;n</td>
                      <td width="13%" align="center" bgcolor="#CCCCCC" > Cantidad </td>
                      <td width="15%" align="center" bgcolor="#CCCCCC" >Precio Unitario</td>
                      <td width="13%" align="center" bgcolor="#CCCCCC" >% Descuento</td>
                      <td width="13%" align="center" bgcolor="#CCCCCC" >Descuento</td>
                      <td width="19%" align="center" bgcolor="#CCCCCC" >Total</td>
                  </tr>
                  <?php 
				  
				  $descuento_total  = 0;
				  $monto_total = 0;
				   foreach(array_reverse($itemsEnCesta,true) as $k => $v)
		           {
					   $this->produ->id_producto = $k;  //enviamos el valor del id producto a la clase de productos
					   $row_productos = $this->produ->ObtenerDatosProducto();  //obtenemos el array con los valores del prodcuto.
					   $array_v = explode('|',$v);
					   
					   $cantidad_produ =$array_v[0];
					   $costo = $row_productos['pv'];
					   $descuento = $row_productos['descuento']/100;
						
					   $sub_total = round($cantidad_produ * $costo,2);  //obtenemos el subtotal del prodcuto cantidad preico.
					   $total_descuento = round($sub_total * $descuento,2);
 					   
					
					   
					    $total = round($sub_total - $total_descuento,2);
					   
						//suma de subtotales descuentos
						
						$descuento_total = $descuento_total + $total_descuento;
						$monto_total = $monto_total + $sub_total;
						
										   
					   
				  ?>
                      <tr>
                        <td align="center" valign="top" bgcolor="#FFFFCC" style="color:#000"><span style="padding-left:5px; padding-right:5px; color:#000"><a href="#" onclick="onclick="eliminarCarrito(<?php echo $k; ?>,'descripcion_carrito')">
                          <input name="didproduct<?php echo $contador;?>" type="hidden" value="<?php echo $k;?>" id="didproduct<?php echo $contador;?>" />
                        <img  src="images/004.png" alt=""  width="15px" height="15px" title=":: Eliminar Carrito ::" /></a></span></td>
                          <td align="center" valign="top" bgcolor="#FFFFCC" style="color:#000"><?php echo utf8_encode($row_productos['idproducto']);?>
                          </td>
                        <td valign="top" bgcolor="#FFFFCC"  style="padding-left:5px; color:#000;"><?php echo htmlentities($row_productos['descripcion'], ENT_QUOTES | ENT_IGNORE, "ISO-8859-1");?></td>
                          <td align="center" valign="top" bgcolor="#FFFFCC"  style="padding-left:5px; color:#000;"><?php echo $cantidad_produ; ?>
           <td align="center" valign="top" bgcolor="#FFFFCC"  style="padding-left:5px; color:#000;">
		          <?php echo '$ '.$costo ?>
           </td>
           <td align="center" valign="top" bgcolor="#FFFFCC" style="padding-left:5px; padding-right:5px; color:#000"  ><span style="padding-left:5px; color:#000;"><?php echo $descuento.'%';?></span></td>
                          <td valign="top" bgcolor="#FFFFCC" style="padding-left:5px; padding-right:5px; color:#000"  >
                                <span style="padding-left:5px; color:#000;"><?php echo '$ '.$total_descuento;?></span>
                          </td>
                          <td valign="top" style="padding-left:5px; padding-right:5px; color:#000" align="left" >
                              <a href="#" onclick="eliminarCarrito(<?php echo $contador; ?>,'d_orden_pedido')" <?php echo $disabled;?>></a>
                          <span style="padding-left:5px; color:#000;"><?php echo '$ '.number_format($sub_total,2);?></span></td>
                      </tr>
				   <?php 
				   
                   }// fin de foreach
				   
				   
				   $iva = 	round(($monto_total- $descuento_total)*.16,2);
				   $total_pagar = $iva + ($monto_total- $descuento_total);	 
				   
				   
				 
                   ?>
                  <tr>
                      <td colspan="7" align="right" style="color:#000">SubTotal</td>
                      <td colspan="2" style=" padding-left:5px; padding-right:5px; color:#000" bgcolor="#F2F2F2">$ <?php echo number_format($monto_total,2,'.',','); ?>
                      <input type="hidden" name="subtotal" id="subtotal" value="<?php echo $subtotal;?>" /></td>
                  </tr>
                  <tr>
                    <td colspan="7" align="right"  style="color:#000">Descuento</td>
                    <td colspan="2" bgcolor="#FF6600" style=" padding-left:5px; padding-right:5px; color:#000" >$ <?php echo number_format($descuento_total,2,'.',','); ?>
                    <input type="hidden" name="descuento_total" id="descuento_total" value="<?php echo $descuento_total;?>" /></td>
                  </tr>
                  <tr>
                      <td colspan="7" align="right"  style="color:#000">IVA</td>
                      <td colspan="2" style=" padding-left:5px; padding-right:5px; color:#000" >$ <?php echo number_format($iva,2,'.',','); ?>
                      <input type="hidden" name="iva" id="iva" value="<?php echo $iva;?>" /></td>
                  </tr>
                  <tr style="font-size:18px;">
                      <td colspan="7" align="right" bgcolor="#CCCCCC"  style="color:#000;">TOTAL A PAGAR</td>
                      <td colspan="2" style="padding-left:5px; padding-right:5px; color:#000;" bgcolor="#CCCCCC">$<span style="padding-left:5px; padding-right:5px; color:#000"><span style="padding-left:5px; color:#000;"><?php echo number_format(round($total_pagar,2),2);?><span style=" padding-left:5px; padding-right:5px; color:#000">
                        <input type="hidden" name="total" id="total" value="<?php echo $total;?>"/>
                      </span></span></span></td>
                  </tr>
                  <!--<tr>
                      <td  colspan="9" style=" padding-left:5px; padding-right:5px; color:#000" align="right" bgcolor="#F2F2F2">
                          <input type="submit" name="button" id="button" value="Levantar Orden" onclick="levantarOrden('contenido',<?php echo $subtotal;?>,<?php echo $iva;?>,<?php echo $total;?>,<?php echo $descuento_total;?>)" class="cajasmodificar">
                      </td>
                  </tr>-->
              </table>
                </div>
<?php 
			     if(!isset($_SESSION['logeado']))
				  {
			  ?>
               <div style="margin: 0 auto; text-align:center; margin-top: 10px;">
                  <input name="btn_pagar" type="button" id="btn_pagar" value="Levantar Pedido" style="height:50px; width:150px; border-radius: 5px; background-color:#093; color:#FFF; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:13px; border:solid 1px #006600; cursor:pointer" onclick="mostrarpagina('registro.php','productos')">
              </div>
              <?php
				  }else
				  {
					  ?>
			     <div style="margin: 0 auto; text-align:center; margin-top: 10px;">
                  <input name="btn_pagar" type="button" id="btn_pagar" value="Generar Orden de Pedido" style="height:50px; width:170px; border-radius: 5px; background-color:#093; color:#FFF; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:13px; border:solid 1px #006600; cursor:pointer" onclick="mostrarpagina('registro.php','productos')">
              </div> 
				  <?php 
				  }
			  ?>
              
		  <?php 
		  }// fin de sesion
		  else
		  {
		  ?>
            <table width="100%" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                      <td align="center">
                        <img src="images/shoppingcart_empty.png"/><br />
                          Tu carrito de compras esta vac&iacute;o<br />
                      </td>
                  </tr>
</table>
      <?php 
		  }// fin de else
	  }// fin de metodo verCarrito
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	   public function verCarritoEntrada()
	  {
		  $contador = 1;
		  if(isset( $_SESSION['itemsEnCestaEntrada'])){
		  $itemsEnCesta = $_SESSION['itemsEnCestaEntrada'];
		  }
		   else{
			 $itemsEnCesta=array ();  
		   }
		  $cantidad = count($itemsEnCesta); // obtenemos la longitud del array de sesion
		  
		  if (isset($itemsEnCesta) && $cantidad>0) // validamos que la session de array exista y que contenga un producto
		  {
		  ?>
         
              <table width="90%" cellspacing="2" cellpadding="2" class="table table-bordered">
              <thead class="px-3 py-5 bg-gradient-success text-white"> 
                  <tr>
                    <td width="6%" valign="top" align="center" style="font-weight: bold;" ><i class="mdi mdi-flash"></i></td>
                      <td width="6%" valign="top" align="center" style="font-weight: bold;" >C&Oacute;DIGO</td>
                      <td width="6%" valign="top" align="center" style="font-weight: bold;" >CAT. PRECIO</td>
					  <td width="6%" valign="top" align="center" style="font-weight: bold;" >VALOR</td>
                      <td width="18%" align="center" style="font-weight: bold;" >NOMBRE</td>
                      <td width="13%" align="center" style="font-weight: bold;" > CANTIDAD</td>
                      <td width="13%" align="center" style="font-weight: bold;" >COSTO</td>
                      <td width="13%" align="center" style="font-weight: bold;" >SUBTOTAL</td>
                  </tr>
               </thead>
                  <tbody> 
                  <?php 
				   foreach(array_reverse($itemsEnCesta,true) as $k => $v)
		           {
					   $array_k = explode("|",$k);
					   $idproducto = $array_k[0];
					   
					   $this->produ->id_producto = $idproducto;
					  // $row_productos = $this->obtenerInformacionProducto($k);
					   $row_productos = $this->produ->ObtenerDatosProducto();
					   
					   $idcategoria_precio = $row_productos['idcategoria_precio'];
					   
					   $sql = "SELECT * FROM categoria_precio WHERE idcategoria_precio = '$idcategoria_precio'";
					   $result_cat = $this->db->consulta($sql);
					   $result_cat_row = $this->db->fetch_assoc($result_cat);
					   
					   $cadena = explode('|',$v);
					   $v_cantidad = $cadena[0];
					   $v_costo = $cadena[1];
					   $talla = $array_k[1];
					   
					   $sql_talla = "SELECT * FROM tallas WHERE idtallas = '$talla'";
					   $resultado_talla = $this->db->consulta($sql_talla);
					   $resultado_talla_row = $this->db->fetch_assoc($resultado_talla);
					    
				  ?>
				  	<tr>
						<td valign="top" align="center" style="color:#000">
							<button type="button" onClick="eliminarCarrito('<?php echo $k; ?>','descripcion_carrito');" title="ELIMINAR" class="btn btn-outline-danger">
								<i class="far fa-trash-alt"></i>
							</button>
                     	</td>
                          <td valign="top" align="center" style="color:#000"><?php echo $this->funcion->imprimir_cadena_utf8 ($idproducto);?>
                          </td>
                          
                          <td valign="top" align="center" style="color:#000"><?php echo $this->funcion->imprimir_cadena_utf8($result_cat_row['nombre']);?>
                          </td>
						  
						  <td valign="top" align="center" style="color:#000"><?php echo $this->funcion->imprimir_cadena_utf8($resultado_talla_row['valor']." ".$resultado_talla_row['unidad']);?>
                          </td>
                          
                        <td align="center" valign="top"  style="padding-left:5px; color:#000;">
						    <?php echo $this->funcion->imprimir_cadena_utf8($row_productos['nombre']);?></td>
                          <td valign="top"  style="padding-left:5px; color:#000;" align="center">
                              <?php 
							 
							  
							  $v_total = number_format($v_cantidad * $row_productos['pv'],2,'.',',');
							  echo $this->funcion->imprimir_cadena_utf8($v_cantidad);?>
                            </td>
                          <td valign="top"  style="padding-left:5px; color:#000;" align="center">$<?php echo $this->funcion->imprimir_cadena_utf8($row_productos['pv']);?></td>
                          <td valign="top"  style="padding-left:5px; color:#000;" align="center">$<?php echo $this->funcion->imprimir_cadena_utf8($v_total);?></td>
                      </tr>
				   <?php 
				   
				   $contador++;
                   }// fin de foreach
                   ?>
                  
                
                  
                  </tbody> 
              </table>
            
		  <?php 
		  }// fin de sesion
		  else
		  {
		  ?>
         
            <table width="100%" border="0" cellspacing="2" cellpadding="2" class="tablesorter">
                  <tr>
                      <td align="center">
                       <!-- <img src="images/shoppingcart_empty.png"/><br />-->
                          La Lista de entradas esta vac&iacute;a<br />
                      </td>
                  </tr>
                  
            </table>
          
      <?php 
		  }// fin de else
	  }// fin de metodo verCarrito
	  
	  
	  
	  //||||||sopping cart de compras----||||||||||||||||||||||||||||||||||||||||||||||||||--------------------------------------------------------------------------------------->
  	  //||||||sopping cart de compras----||||||||||||||||||||||||||||||||||||||||||||||||||--------------------------------------------------------------------------------------->
	  //||||||sopping cart de compras----||||||||||||||||||||||||||||||||||||||||||||||||||--------------------------------------------------------------------------------------->
	  
	  
	  public function addProductoCompras($item,$cantidad)
	{ $encontrado=0;
		//SI LA CANTIDAD ES 0 no hagas nada.
		if ($cantidad==0)
		{
		   return;
		}
		//termina.
		
		
		//si trae un producto.... realizas esto...
		if($item)
		{ 
		   if(!isset($_SESSION['itemsEnCestaCompras']))
		   {  
			  
			  $this->sesion->crearSesion('itemsEnCestaCompras',null);
			  $_SESSION['itemsEnCestaCompras'][$item] = $cantidad;
		
		   }
		   else
		   {  
			  foreach($_SESSION['itemsEnCestaCompras'] as $k => $v)
			  {  
				 if ($item == $k)
				 {  
					 $_SESSION['itemsEnCestaCompras'][$k] = $cantidad;
					 $encontrado=1;  
				 }  
			  }  
			  if (!$encontrado)
			      { 
				      $_SESSION['itemsEnCestaCompras'][$item]=$cantidad; 
				   }    
		    }  
		 }
		  
	 }
	  
	  
	  
	  
	  
	   public function verCarritoCompras()
	  {
		  $contador = 1;
		  if(!isset($_SESSION['itemsEnCestaCompras'])){
		  	$itemsEnCesta=array();
		  }
		  	else{
		  $itemsEnCesta = $_SESSION['itemsEnCestaCompras'];
		}
		  $cantidad = count($itemsEnCesta); // obtenemos la longitud del array de sesion
		  
		  if (isset($itemsEnCesta) && $cantidad>0) // validamos que la session de array exista y que contenga un producto
		  {
		  ?>
         
              <table width="90%" cellspacing="2" cellpadding="2" class="table table-bordered">
              <thead class="px-3 py-5 bg-gradient-info text-white"> 
                  <tr>
                    <td width="6%" valign="top" align="center" >Acci&oacute;n</td>
                      <td width="6%" valign="top" align="center" >C&oacute;digo Producto</td>
                      <td width="18%" align="center" >Nombre</td>
                      <td width="13%" align="center" > Cantidad </td>
                      <td width="13%" align="center" >Costo</td>
                      <td width="13%" align="center" >Total</td>
                  </tr>
               </thead>
                  <tbody> 
                  <?php 
				   foreach(array_reverse($itemsEnCesta,true) as $k => $v)
		           {
					   $this->produ->id_producto = $k;
					  // $row_productos = $this->obtenerInformacionProducto($k);
					   $row_productos = $this->produ->ObtenerDatosProducto();
					    
				  ?>
                      <tr>
                        <td valign="top" align="center" style="color:#000">
                  <span style="padding-left:5px; padding-right:5px; color:#000">
                  <button type="button" class="btn btn-outline-danger" onclick="eliminarCarritoCompras('<?php echo $k; ?>','descripcion_carrito')" >     <i class="far fa-trash-alt"></i>
                  </button>
                        </span>
                     </td>
                          <td valign="top" align="center" style="color:#000"><?php echo $this->funcion->imprimir_cadena_utf8($k);?>
                          </td>
                        <td align="center" valign="top"  style="padding-left:5px; color:#000;">
						    <?php echo $this->funcion->imprimir_cadena_utf8($row_productos['nombre']);?></td>
                          <td valign="top"  style="padding-left:5px; color:#000;" align="center">
                              <?php 
							  $cadena = explode('|',$v);
							  $v_cantidad = $cadena[0];
							 // $v_costo = $cadena[1];
							  
							  $v_total = number_format($v_cantidad * $row_productos['pv'],2,'.',',');
							  echo $this->funcion->imprimir_cadena_utf8($v_cantidad);?>
                            </td>
                          <td valign="top"  style="padding-left:5px; color:#000;" align="center">$<?php echo $this->funcion->imprimir_cadena_utf8($row_productos['pv']);?></td>
                          <td valign="top"  style="padding-left:5px; color:#000;" align="center">$<?php echo $this->funcion->imprimir_cadena_utf8($v_total);?></td>
                      </tr>
				   <?php 
				   
				   $contador++;
                   }// fin de foreach
                   ?>
                  
                
                  <!--<tr>
                      <td  colspan="9" style=" padding-left:5px; padding-right:5px; color:#000" align="right" bgcolor="#F2F2F2">
                          <input type="submit" name="button" id="button" value="Levantar Orden" onclick="levantarOrden('contenido',<?php echo $subtotal;?>,<?php echo $iva;?>,<?php echo $total;?>,<?php echo $descuento_total;?>)" class="cajasmodificar">
                      </td>
                  </tr>-->
                  </tbody> 
              </table>
            
		  <?php 
		  }// fin de sesion
		  else
		  {
		  ?>
         
            <table width="100%" border="0" cellspacing="2" cellpadding="2" class="tablesorter">
                  <tr>
                      <td align="center">
                       <!-- <img src="images/shoppingcart_empty.png"/><br />-->
                          Tu carrito de compras esta vac&iacute;o<br />
                      </td>
                  </tr>
                  
            </table>
          
      <?php 
		  }// fin de else
	  }// fin de metodo verCarrito
	  
	  
	  //termina el shopping cart de compras
	
	  
	  public function delProductoCompras($item)
	 {
		 //$_SESSION['count']--;
		  if (isset($_SESSION['itemsEnCestaCompras']))
		  {
				foreach($_SESSION['itemsEnCestaCompras'] as $k => $v)
				{ 
				  if (isset($item))
				   {
					    unset ($_SESSION['itemsEnCestaCompras'][$item]);
				   }
				   
				}
		  } 
		  
	 }// fin de método delProducto
	 
	 
	 
	 
	 
	 //||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
	 //||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
	 //||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
	 // CARRITO PARA LAS ETIQUETAS
	 //||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
	 
	 
	 public function addProductoEtiquetas($item,$cantidad,$unidad)
	{
		//SI LA CANTIDAD ES 0 no hagas nada.
		if ($cantidad==0)
		{
		   return;
		}
		//termina.
		
		
		//si trae un producto.... realizas esto...
		if($item)
		{ 
		   if(!isset($_SESSION['itemsEnCestaEtiquetas']))
		   {  
			  
			  $this->sesion->crearSesion('itemsEnCestaEtiquetas',null);
			  $this->sesion->crearSesion('contadoretiquetas',null);
			  $_SESSION['contadoretiquetas']=1;			  
			  $_SESSION['itemsEnCestaEtiquetas'][$_SESSION['contadoretiquetas']] = $item."|".$unidad;
		
		   }
		   else
		   {  
			        $_SESSION['contadoretiquetas'] ++;
					 $_SESSION['itemsEnCestaEtiquetas'][$_SESSION['contadoretiquetas']] = $item."|".$unidad;
					   
			}  
			 
		   
		 }
		  
	 }
	  
	  
	  
	  
	  
	   public function verCarritoEtiquetas()
	  {
		  
		  $itemsEnCesta = $_SESSION['itemsEnCestaEtiquetas'];
		  $cantidad = count($itemsEnCesta); // obtenemos la longitud del array de sesion
		  
		  if (isset($itemsEnCesta) && $cantidad>0) // validamos que la session de array exista y que contenga un producto
		  {
		  ?>
         
              <table width="90%" cellspacing="2" cellpadding="2" class="table table-bordered">
              <thead> 
                  <tr>
                    <td width="6%" valign="top" align="center" >Acci&oacute;n</td>
                    <td width="6%" valign="top" align="center" >CODIGO INTERNO SHOPING</td>
                      <td width="6%" valign="top" align="center" >C&oacute;digo Producto</td>
					  <td width="18%" align="center" >VALOR EN  UNIDADES</td>
                      <td width="18%" align="center" >Nombre</td>
                      
                  </tr>
               </thead>
                  <tbody> 
                  <?php 
				   foreach(array_reverse($itemsEnCesta,true) as $k => $v)
		           {	$d= explode("|",$v);
					   $this->produ->id_producto = $d[0];
					  // $row_productos = $this->obtenerInformacionProducto($k);
					   $row_productos = $this->produ->ObtenerDatosProducto();
					    
				  ?>
                      <tr>
                        <td valign="top" align="center" style="color:#000">
                  <span style="padding-left:5px; padding-right:5px; color:#000">
                  <a href="#" onclick="eliminarCarritoEtiquetas('<?php echo $k; ?>','descripcion_carrito')" <?php echo $disabled;?>>                        <img  src="images/004.png" alt=""  width="15px" height="15px" title=":: Eliminar Carrito ::"/>
                  </a>
                        </span>
                     </td>
                        <td valign="top" align="center" style="color:#000"><?php echo $k;?></td>
                          <td valign="top" align="center" style="color:#000"><?php echo utf8_encode($d[0]);?>
                          </td>
						  <td valign="top" align="center" style="color:#000"><?php echo utf8_encode($this->produ->obtenerunidad($d[1]));?>
                          </td>
                        <td align="center" valign="top"  style="padding-left:5px; color:#000;">
						    <?php echo htmlentities($row_productos['nombre'], ENT_QUOTES | ENT_IGNORE, "ISO-8859-1");?></td>
                          
                      </tr>
				   <?php 
				   
				  
                   }// fin de foreach
                   ?>
                  
                
                  <!--<tr>
                      <td  colspan="9" style=" padding-left:5px; padding-right:5px; color:#000" align="right" bgcolor="#F2F2F2">
                          <input type="submit" name="button" id="button" value="Levantar Orden" onclick="levantarOrden('contenido',<?php echo $subtotal;?>,<?php echo $iva;?>,<?php echo $total;?>,<?php echo $descuento_total;?>)" class="cajasmodificar">
                      </td>
                  </tr>-->
                  </tbody> 
              </table>
            
		  <?php 
		  }// fin de sesion
		  else
		  {
		  ?>
         
            <table width="100%" border="0" cellspacing="2" cellpadding="2" class="tablesorter">
                  <tr>
                      <td height="72" align="center">
                        <img src="images/shoppingcart_empty.png"/><br />
                          No Hay Productos en La Lista<br />
                      </td>
                  </tr>
                  
            </table>
          
<?php 
		  }// fin de else
	  }// fin de metodo verCarrito
	  
	  
	  //termina el shopping cart de compras
	
	  
	  public function delProductoEtiquetas($item)
	 {
		 //$_SESSION['count']--;
		  if (isset($_SESSION['itemsEnCestaEtiquetas']))
		  {
				
					    unset ($_SESSION['itemsEnCestaEtiquetas'][$item]);
				
				   
		  } 
		  
	 }// fin de método delProducto
	 
	 
	 
	 
	 
	 
	 
	 //||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
	 //||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
	 //||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
	 // TERMINA CARRITO PARA LAS ETIQUETAS
	 //||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
	 
	 
	 
	 
	 
	 
	 
	  //||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
	 //||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
	 //||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
	 // INICIA CARRITO DE PUNTO DE VENTA
	 //||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
	 
	 
	  public function addPuntodeVenta($item,$cantidad,$sucursal,$idcategoria_precio,$nombre_categoria,$talla)
	{
		
	
		
		//si el producto no existe no hacemos nada...
		
			$this->produ->id_producto = $item;
			$this->produ->idsucursales = $sucursal;
		  	$this->produ->idtallas = $talla;
			$existe = $this->produ->verificaProductoExistenteInventario();
		   
		if($existe == 1)
		  {
	
	            //este if nos sirve para verificar que ya existe la sesion de apunta de venta.
	            if(!isset($_SESSION['PuntaVenta']))
				   {  
					  
					  $this->sesion->crearSesion('PuntaVenta',null);
					  $_SESSION['PuntaVenta'][$item."|".$talla] = $cantidad."|".$idcategoria_precio."|".$nombre_categoria;
				
				   }
				   else  //si nexiste hace un ciclo para buscar el producto y sumarle la nueva cantidad.
				   {  
					  foreach($_SESSION['PuntaVenta'] as $k => $v)
					  {  
						 if ($item."|".$talla==$k)
						 {  
						 
						     //sumamos lo que existe en sesion mas el de ahora 
							 
							  $nuevacantidad = $_SESSION['PuntaVenta'][$k] + $cantidad;						     
							  $sepuede = $this->produ->alcanzaProducto($nuevacantidad);
						 
						 
						     if($sepuede == 1)
							 {
							 	$_SESSION['PuntaVenta'][$k]=$_SESSION['PuntaVenta'][$k]+$cantidad."|".$idcategoria_precio."|".$nombre_categoria; 
								?>
								
							 <h4 class="alert alert-success" style="margin-top: -5px;">EL PRODUCTO SE AGREGO CORRECTAMENTE<?php echo $this->produ->id_producto; ?></h4>
								<?php 
							 }else
							 {
							  ?>
						     <h4 class="alert alert-danger" style="margin-top: -5px;">NO HAY TANTO PRODUCTO EN EXISTENCIA<?php echo $this->produ->id_producto; ?></h4>						  <?php
							 } 
							  $encontrado = 1 ;
						 }  
					  }  
					  
					  if (!$encontrado)
					       { 
					           $_SESSION['PuntaVenta'][$item."|".$talla]=$cantidad."|".$idcategoria_precio."|".$nombre_categoria; 
							}    
					}  
					
						?>
               
                
                
        
		<?php
				
		    }//fin de la comparacion de que si existye el producto en stock.
			else
			{
				?>
                 
            		
                          <h4 class="alert alert-danger" style="margin-top: -5px;">NO EXISTE PRODUCTO O NO HAY PRODUCTO EN STOCK</h4> 
            		
    
        		
        
		<?php
			}
		
		  
	 }// fin de método addProducto
	 
	 
	 
	 
	  
	   public function delProductoPuntodeVenta($item)
	 {
		 //$_SESSION['count']--;
		  if (isset($_SESSION['PuntaVenta']))
		  {
				foreach($_SESSION['PuntaVenta'] as $k => $v)
				{ 
				  if (isset($item))
				   {
					    unset ($_SESSION['PuntaVenta'][$item]);
				   }
				   
				}
		  } 
		  
	 }// fin de método delProducto
	 
	 
	 
	 
	 
	 
	 
	 
	  public function verCarritoPuntodeVenta($cliente)
	  {
		 
		try
		{  
		  $contador = 1;		  
		  $itemsEnCesta = $_SESSION['PuntaVenta'];
		  $cantidad = count($itemsEnCesta); // obtenemos la longitud del array de sesion
		  
		  
	//obtenemos de la clase de configuracion que tipo de configuracion tiene tanto iva como el tipo de descuento que maneja.
	
	
			$row_configuracion = $this->confi->ObtenerInformacionConfiguracion();			
			$iva = $row_configuracion['iva']/100;
			$t_descuento = $row_configuracion['t_descuento'];	  // 0-producto  1 - por paquete 2 - ambos.
		  
//Obtenemos el descuento que tiene el cliente
			
			if($cliente != 0)
			{
				$this->clientes->idCliente = $cliente;
				$row_cliente = $this->clientes->ObtenerInformacionCliente(); //obtenemos toda la informacion del cliente.
				$c_descuento = $row_cliente['porc_desc']; //obtenemos el descuento que tiene configurado el cliente en el sistema.
				
				$idniveles = $row_cliente['idniveles'];
			}else
			{
				$idniveles = 0;
			    $c_descuento = 0;	
			}
		  
		  // validamos que la session de array exista y que contenga un producto
		  
		  if ( isset($itemsEnCesta) && $cantidad > 0 ) 
		      {
		  ?>
          
<div style="height:500px; background-color: #D8D6D6; overflow:auto" >
                    <table width="100%" cellspacing="2" cellpadding="2" class="table table-bordered">
                  <tr>
                    <td width="3%" align="center"  bgcolor="#CCCCCC" >&nbsp;</td>
                    <td>Foto</td>
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
				  
				  $descuento_total  = 0;
				  $monto_total = 0;
				  $sumaproductos =0;
				  
				   foreach(array_reverse($itemsEnCesta,true) as $k => $v)
		           {
					   //echo $k." ".$v;
					   $array_k = explode('|',$k);
					   
					   $this->produ->id_producto = strtoupper(trim($array_k[0]));  //enviamos el valor del id producto a la clase de productos
					   $row_productos = $this->produ->ObtenerDatosProducto();  //obtenemos el array con los valores del prodcuto.
					   $array_v = explode('|',$v);
					   
					   $talla = $array_k[1];
					   $nombre_categoria = $array_v[2];
					   $idcategoria_precio = $array_v[1];
					   $cantidad_produ =$array_v[0];  //obtemos la cantidad de producto en el carrito
					   $sumaproductos = $sumaproductos + $cantidad_produ; //obtenemos la suma de todos los productos que se estan comprando.
					   
					   $costo = $row_productos['pv']; //obtenemos el precio venta ya con IVA.
					   
					   //$descuento = $row_productos['descuento']/100; //obtenemos el porcentaje del descuento en la base de datos del producto.
					   				
					   $SubPorProducto = round($cantidad_produ * $costo,2);  //obtenemos el subtotal del producto cantidad precio.
					   
					   //obtenemos el descuento que trae por nivel
					   $sql = "SELECT * FROM categoria_precios_niveles WHERE idniveles = '$idniveles' AND idcategoria_precio = '$idcategoria_precio'";
					   
					   $result_sql = $this->db->consulta($sql);
					   $result_sql_num = $this->db->num_rows($result_sql);
					   $result_sql_row = $this->db->fetch_assoc($result_sql);
					   
					   if($result_sql_num == 0){
						   $desc_nivel = 0;
					   }else{
						   $desc_nivel = $result_sql_row['descuento'];
					   }
					   
					   //Obtenemos descuento total sumando el descuento del cliente por nivel y el del producto
					   $desc_t = $row_productos['descuento']+$desc_nivel;
					   
					   $descuento = $desc_t/100; //obtenemos el porcentaje del descuento en la base de datos del producto.
					   $DescPorProducto = round($SubPorProducto * $descuento,2); //obtenemos el total del descuento de ese producto.
					   
					   //validamos que si es por producto o ambos se ejecute el descuento.
					   
					   /*if($t_descuento == 0 || $t_descuento == 2)
					   {
					       $DescPorProducto = round($SubPorProducto * $descuento,2); //obtenemos el total del descuento de ese producto.
					   }else
					   {
						   $DescPorProducto = 0;
					   }*/
					   
					   /*if($idcategoria_precio == 7){
						   $DescPorProducto = round($SubPorProducto * 0.6,2); //obtenemos el total del descuento de ese producto en categoria de promocion
					   }else{
						   if($idcategoria_precio == 12){
							   $DescPorProducto = round($SubPorProducto * 0.65,2); //Obtenemos el total del descuento de ese producto en caategoria de liquidacion
						   }
					   }*/
 					   
					   $SubtotalBrutoPorProducto = round($SubPorProducto - $DescPorProducto,2);  //OBTENEMOS EL TOTAL DEL PRRODUCTO MENOS EL DESCUENTO.
					   
					    //suma de subtotales descuentos
						//$total_pagar_sinDescuento = $total_pagar_sinDescuento+$SubtotalBrutoPorProducto;
						$total_pagar_sinDescuento = $total_pagar_sinDescuento+$SubPorProducto;
						$total_pagar = $total_pagar + $SubtotalBrutoPorProducto;
						$SumadeDescuentos = $SumadeDescuentos + $DescPorProducto;
					   
					   
					   $sql_talla = "SELECT * FROM tallas WHERE idtallas = '$talla'";
					   $result_talla = $this->db->consulta($sql_talla);
					   $result_talla_row = $this->db->fetch_assoc($result_talla);
					   
				  ?>
                      <tr>
                        <td align="center" valign="top" bgcolor="#FFFFCC" style="color:#000">
                      
							<button type="button" onClick="delProductoPuntoVenta('<?php echo $k; ?>','<?php echo $cliente; ?>')" title="BORRAR" class="btn btn-danger">
								<i class="mdi mdi-delete-empty"></i>
							</button>
                        </td>
                        
                        
                        <td align="center" bgcolor="#FFFFCC" style="cursor:pointer;" onMouseOver="AbrirModalImagenTwo('ModalImagen<?php echo $this->produ->id_producto; ?>','400','400','<?php echo $this->produ->id_producto; ?>');" onMouseOut="$('#ModalImagen<?php echo $this->produ->id_producto; ?>').css('display','none'); $('#contenido_modal_img').html('');">
                   		<img width="18" height="18" src="images/camara.png" style=" cursor:pointer;" />
                        
                        <!-- MODAL PARA MOSTRAR IMAGEN -->
                        <div id="ModalImagen<?php echo $this->produ->id_producto ?>" class="ventana" style="margin-left:-290px;">
                                <div id="contenido_modal_img<?php echo $this->produ->id_producto; ?>">
                                    <img width="400" height="400" <?php if ($row_productos['foto']==""){ echo 'src="images/no_hay_imagen.png" ';   } else { ?> src="productos/imagenes/<?php echo $row_productos['foto'];} ?>" />
                                </div>
                        </div>
                 	</td>             
                    
                    
                          <td align="center" valign="top" bgcolor="#FFFFCC" style="color:#000"><?php echo utf8_encode($row_productos['idproducto']);?>
                          </td>
						  <td align="center" valign="top" bgcolor="#FFFFCC"  style="padding-left:5px; color:#000;">
		         		 	<?php echo utf8_encode($result_talla_row['valor']." ".$result_talla_row['unidad']); ?>
          				 </td>
                          <td align="center" valign="top" bgcolor="#FFFFCC" style="color:#000"><?php echo utf8_encode($nombre_categoria);?>
                          </td>
                        <td valign="top" bgcolor="#FFFFCC"  style="padding-left:5px; color:#000;"><?php echo htmlentities(strtoupper($row_productos['nombre']), ENT_QUOTES | ENT_IGNORE, "ISO-8859-1");?></td>
                          <td align="center" valign="top" bgcolor="#FFFFCC"  style="padding-left:5px; color:#000;"><?php echo $cantidad_produ; ?>
           <td align="center" valign="top" bgcolor="#FFFFCC"  style="padding-left:5px; color:#000;">
		          <?php echo '$ '.$costo ?>
           </td>
           <td align="center" valign="top" bgcolor="#FFFFCC" style="padding-left:5px; padding-right:5px; color:#000"  ><span style="padding-left:5px; color:#000;"><?php if($idcategoria_precio == 7){echo "50+20";}else{if($idcategoria_precio == 12){echo "50+30";}else{echo $desc_t.'%';}}?></span></td>
                          <td align="center" valign="top" bgcolor="#FFFFCC" style="padding-left:5px; padding-right:5px; color:#000"  >
                                <span style="padding-left:5px; color:#000;"><?php echo '$ '.$DescPorProducto;?></span>
                          </td>
                          <td valign="top" style="padding-left:5px; padding-right:5px; color:#fff;  background-color: #666364;" align="center" >
                          
						     <?php echo "$ ".number_format($SubtotalBrutoPorProducto,2,'.',','); ?>
                             </td>
                      </tr>
				   <?php 
				   
                   }// fin de foreach
				   
				   
				   //Descuento por Paquete.
				   
				  /* if($t_descuento == 1 || $t_descuento == 2 )
				      {
					  
						  $row = $this->paquetes->obtenerQuePaqueteporRango($total_pagar);
						  						  
						  if($row['cuantos'] != 0)
						  {
							$porc_descuento_paquete = $row['descuento'] / 100;
						    $SumadeDescuentosPaquete = $total_pagar * $porc_descuento_paquete;
						  }else
						  {
							$SumadeDescuentosPaquete = 0;
						  }
						  
						  
					  }else
					  {
						  $SumadeDescuentosPaquete = 0;
					  }*/
					  
					  
				    //restar el descuento por paquete si es que existe alguno
					
					$total_pagar = $total_pagar - $SumadeDescuentosPaquete;  
					
					
					//obtenemos el descuento del cliente y obtenemos la cantidad de descuento a realizarle.
					
					
					
										
					
				   
				   //SUMA DE DESCUENTOS PARA OBTENER LOS TOTALES A PAGAR		   
				   
				   
				   
				   $subtotal = 	round($total_pagar/(1+$iva),2);
				   $iva = $total_pagar - $subtotal;	 
				   
				   
				   //TERMINA LAS VARIABLES CON TOTALES DE LA COMPRA CON SU DESCUENTO.
				 
                   ?>
                  <tr>
                      <td colspan="9" align="right" style="color:#000">SubTotal:</td>
                      <td colspan="2" style=" padding-left:5px; padding-right:5px; color:#000" bgcolor="#F2F2F2">$ <?php echo number_format($subtotal,2,'.',','); ?>
                      <input type="hidden" name="v_subtotal" id="v_subtotal" value="<?php echo $subtotal;?>" /></td>
                  </tr>
                  
                  <?php //if($t_descuento == 0 || $t_descuento == 2) {?>
                  
                  <tr>
                    <td colspan="9" align="right"  style="color:#000">Descuento:</td>
                    <td colspan="2" bgcolor="#FF0000" style=" padding-left:5px; padding-right:5px; color:#000" >- $ <?php echo number_format($SumadeDescuentos,2,'.',','); ?>
                      <input type="hidden" name="v_desc_producto" id="v_desc_producto" value="<?php echo $SumadeDescuentos;?>" />
                      
                      <input type="hidden" name="v_niveles" id="v_niveles" value="<?php echo $idniveles;?>" />
                    </td>
                  </tr>
                  
                  
                  <?php
				  //}
                  
                   if($t_descuento == 1 || $t_descuento == 2) {?>
                  
                  <!--<tr>
                    <td colspan="8" align="right"  style="color:#000">Desc. por Paquete:</td>
                    <td colspan="2" bgcolor="#FF0000" style=" padding-left:5px; padding-right:5px; color:#000" >- $ <?php echo number_format($SumadeDescuentosPaquete,2,'.',','); ?>
                      <input type="hidden" name="v_desc_paquete" id="v_desc_paquete" value="<?php echo $SumadeDescuentosPaquete;?>" /></td>
                  </tr>-->
                  <?php
				   }
				  
				  //SI EL CLIENTE ES PUBLICO EN GENERAL.
				  
				  if($row_cliente != 0){ 
				  		
						//$porc_descuento_cliente = $c_descuento / 100;
				  		//$desc_cliente = round($total_pagar * $porc_descuento_cliente,2); //cantidad de descuento a realizar.
						//$total_pagar = $total_pagar - $desc_cliente;
						//$descuento_cliente = number_format($desc_cliente,2,'.',',');
						
						
						 //iniciamos las variables de sesion para poder
		  
						   $s_v1 = $_SESSION['vs_totalproductos']=$sumaproductos; 
						   $s_v2 = $_SESSION['vs_montodescuento'] = number_format(round($total_pagar_sinDescuento,2),2,'.',',');
						   $s_v3 = $_SESSION['vs_descuento']= number_format(round($SumadeDescuentos,2),2,'.',',');
						   $s_v4 = $_SESSION['vs_totalcondescuento']=number_format(round($total_pagar,2),2,'.',',');
		  
						
						
						
				  ?>
                  <!--<tr>
                    <td colspan="8" align="right"  style="color:#000">Desc. por Cliente:</td>
                    <td colspan="2" bgcolor="#FF0000" style=" padding-left:5px; padding-right:5px; color:#000" >- $ <?php echo $descuento_cliente; ?>
                      <input type="hidden" name="v_desc_cliente" id="v_desc_cliente" value="<?php echo $desc_cliente;?>" /></td>
                  </tr>-->
                  <?php
				  }else
				  {
					       $s_v1 = $_SESSION['vs_totalproductos']=$sumaproductos; 
						   $s_v2 = $_SESSION['vs_montodescuento'] = number_format(round($total_pagar_sinDescuento,2),2,'.',',');
						   $s_v3 = $_SESSION['vs_descuento']= number_format(round($DescPorProducto,2),2,'.',',');
						   $s_v4 = $_SESSION['vs_totalcondescuento']=number_format(round($total_pagar,2),2,'.',',');
				  }
				  
				  ?>
                  
                  <tr>
                      <td colspan="9" align="right"  style="color:#000">IVA:</td>
                      <td colspan="2" style=" padding-left:5px; padding-right:5px; color:#000" >$ <?php echo number_format($iva,2,'.',','); ?>
                      <input type="hidden" name="v_iva" id="v_iva" value="<?php echo $iva;?>" /></td>
                  </tr>
                  <tr style="font-size:18px; ">
                      <td colspan="9" align="right"  style="color:#000;">TOTAL A PAGAR:</td>
                      <td colspan="2" style="padding-left:5px; padding-right:5px; color:#000;" bgcolor="#CCCCCC">$<span style="padding-left:5px; padding-right:5px; color:#000"><span style="padding-left:5px; color:#000;"><?php echo number_format(round($total_pagar,2),2);?><span style=" padding-left:5px; padding-right:5px; color:#000">
                        <input type="hidden" name="v_total_pagar" id="v_total_pagar" value="<?php echo $total_pagar;?>"/>
                      </span></span></span></td>
                  </tr>
                  <!--<tr>
                      <td  colspan="9" style=" padding-left:5px; padding-right:5px; color:#000" align="right" bgcolor="#F2F2F2">
                          <input type="submit" name="button" id="button" value="Levantar Orden" onclick="levantarOrden('contenido',<?php echo $subtotal;?>,<?php echo $iva;?>,<?php echo $total;?>,<?php echo $descuento_total;?>)" class="cajasmodificar">
                      </td>
                  </tr>-->
              </table>
              
           </div> 
           
            <div id="d_sumatorias_pedido">
 <table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tbody>
    <tr style="height: 30px; font-style: normal; font-weight: bold; font-size: 16px;"; bgcolor="#959595">
      <td width="18%" align="right" bgcolor="#F0EDED">Total de Productos:</td>
      <td width="9%" align="center" style="background-color: #DADADA; padding: 0px 5px 0px 5px; font-size: 24px;" id="v_totalproducto"><?php echo  $s_v1;?></td>
      <td width="22%" align="right" bgcolor="#F0EDED">Monto sin descuento:</td>
      <td width="11%" align="center" style="background-color: #DADADA; padding: 0px 5px 0px 5px; font-size: 24px;" id="v_montodescuento"><?php echo $s_v2;?></td>
      <td width="12%" align="right" bgcolor="#F0EDED">Descuento:</td>
      <td width="11%" align="center" style="background-color: #DADADA; padding: 0px 5px 0px 5px; font-size: 24px;" id="v_descuento"><?php echo $s_v3; ?></td>
      <td width="9%" align="right" bgcolor="#F0EDED">Total:</td>
      <td width="8%" align="center" style="background-color: #DADADA; padding: 0px 5px 0px 5px; font-size: 24px;" id="v_totaldescuento"><?php echo $s_v4;?></td>
    </tr>
  </tbody>
</table>
    </div>
    
    </div>
              
		  <?php 
		  
		
		  
		  }// fin de sesion
		  else
		  {
		  ?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                      <td align="center">
                        <img src="images/shoppingcart_empty.png"/><br />
                          Tu carrito de compras esta vac&iacute;o<br />
                      </td>
                  </tr>
</table>
      <?php 
		  }// fin de else
		  
		}catch(Exception $e)
        {
		  $v = explode ('|',$e);
		  $n = explode ("'",$v[1]);
		  echo '<div class="alert_error" id="mens">'.$this->db->m_error($n[0]).'</div>'; 	   
        }
		  
	  }// fin de metodo verCarrito
	 
	 
	 
	 
	 function verCarritoPuntodeVentaDatos()
	   {
		   
		  $contador = 1;		  
		  $itemsEnCesta = $_SESSION['PuntaVenta'];
		  $cantidad = count($itemsEnCesta); // obtenemos la longitud del array de sesion
		  
		  
	        //obtenemos de la clase de configuracion que tipo de configuracion tiene tanto iva como el tipo de descuento que maneja.
	
			$row_configuracion = $this->confi->ObtenerInformacionConfiguracion();
			$iva = $row_configuracion['iva']/100;
			$t_descuento = $row_configuracion['t_descuento'];	  // 0-producto  1 - por paquete 2-ambos.
		  
		  
		  if (isset($itemsEnCesta) && $cantidad>0) // validamos que la session de array exista y que contenga un producto
		  {
		 
				  $descuento_total  = 0;
				  $monto_total = 0;
				  
				   foreach($itemsEnCesta as $k => $v)
		           {
					   $this->produ->id_producto = $k;  //enviamos el valor del id producto a la clase de productos
					   $row_productos = $this->produ->ObtenerDatosProducto();  //obtenemos el array con los valores del prodcuto.
					   $array_v = explode('|',$v);
					   
					   $cantidad_produ =$array_v[0];  //obtemos la cantidad de producto en el carrito
					   $costo = $row_productos['pv']; //obtenemos el precio venta ya con IVA.
					   $descuento = $row_productos['descuento']/100; //obtenemos el porcentaje del descuento en la base de datos del producto.
					   
						
					   $SubPorProducto = round($cantidad_produ * $costo,2);  //obtenemos el subtotal del producto cantidad precio.
					   
					   //validamos que si es por producto o ambos se ejecute el descuento.
					   if($t_descuento == 0 || $t_descuento == 2)
					   {
					       $DescPorProducto = round($SubPorProducto * $descuento,2); //obtenemos el total del descuento de ese producto.
					   }else
					   {
						   $DescPorProducto = 0;
					   }
 					   
					   $SubtotalBrutoPorProducto = round($SubPorProducto - $DescPorProducto,2);
					   
					    //suma de subtotales descuentos
						
						$total_pagar = $total_pagar + $SubtotalBrutoPorProducto;
						$SumadeDescuentos = $SumadeDescuentos + $DescPorProducto;
					
				   
                   }// fin de foreach
				   
				   
				   //Descuento por Paquete.
				   
				   if($t_descuento == 1 || $t_descuento == 2 )
				      {
					      //echo "Entro";
						  
						  $row = $this->paquetes->obtenerQuePaqueteporRango($total_pagar);
						  
						  //echo $row['cuantos'];
						  
						  if($row['cuantos'] != 0)
						  {
							$porc_descuento_paquete = $row['descuento'] / 100;
						    $SumadeDescuentosPaquete = $total_pagar * $porc_descuento_paquete;
						  }else
						  {
							$SumadeDescuentosPaquete = 0;
						  }
						  
						  
					  }else
					  {
						  $SumadeDescuentosPaquete = 0;
					  }
					  
					  
				    //restar el descuento por paquete si es que existe alguno
					
					$total_pagar = $total_pagar - $SumadeDescuentosPaquete;  
				   
				   //SUMA DE DESCUENTOS PARA OBTENER LOS TOTALES A PAGAR		   
			   
				   $subtotal = 	round($total_pagar/(1+$iva),2);
				   $iva = $total_pagar - $subtotal;	 
				   
		  }// fin de sesion
		  else
		  {
		 
		  }// fin de else
		   
		   
		   
		   
		   
		   
	   }
	 
	 
	 
	 
	 
	 
	 
	 
	 
	  //||||||||||||| INICIA SHOPING CART DE SALDA||||||||||||||||||/////////////////////////////////////////
	 //||||||||||||| INICIA SHOPING CART DE SALIDA||||||||||||||||||/////////////////////////////////////////
	 //||||||||||||| INICIA SHOPING CART DE SALIDA||||||||||||||||||/////////////////////////////////////////
	 //||||||||||||| INICIA SHOPING CART DE SALIDA||||||||||||||||||/////////////////////////////////////////
	 public function addProductoSalidas($item,$cantidad,$talla)
	{
		//SI LA CANTIDAD ES 0 no hagas nada.
		if ($cantidad==0)
		{
		   return;
		}
		//termina.
		
		
		//si trae un producto.... realizas esto...
		if($item)
		{ $encontrado="";
		   if(!isset($_SESSION['itemsEnCestaSalidas']))
		   {  
			  
			  $this->sesion->crearSesion('itemsEnCestaSalidas',null);
			  $_SESSION['itemsEnCestaSalidas'][$item."|".$talla] = $cantidad;
		
		   }
		   else
		   {  
			  foreach($_SESSION['itemsEnCestaSalidas'] as $k => $v)
			  {  
				 if ($item."|".$talla == $k)
				 {  
					 $_SESSION['itemsEnCestaSalidas'][$k] = $cantidad;
					 $encontrado=1;  
				 }  
			  }  
			  if (!$encontrado)
			      { 
				      $_SESSION['itemsEnCestaSalidas'][$item."|".$talla]=$cantidad; 
				   }    
		    }  
		 }
		  
	 }
	  
	  
	  
	  
	  
	   public function verCarritoSalidas()
	  {
		  $contador = 1;
		  if(!isset($_SESSION['itemsEnCestaSalidas'])){
			  $cantidad=0;
		  }
		   else{
		  $itemsEnCesta = $_SESSION['itemsEnCestaSalidas'];
		  $cantidad = count($itemsEnCesta); // obtenemos la longitud del array de sesion
		   }
		  
		  if (isset($itemsEnCesta) && $cantidad>0) // validamos que la session de array exista y que contenga un producto
		  {
		  ?>
         
              <table width="90%" cellspacing="2" cellpadding="2" class="table table-bordered">
              <thead> 
                  <tr class="px-3 py-5 bg-gradient-danger text-white">
                    <td width="6%" valign="top" align="center" style="font-weight: bold;" ><i class="mdi mdi-flash"></i></td>
                      <td width="6%" valign="top" align="center" style="font-weight: bold;" >C&Oacute;DIGO PRODUCTO</td>
					  <td width="6%" valign="top" align="center" style="font-weight: bold;" >VALOR/UNIDAD</td>
                      <td width="18%" align="center" style="font-weight: bold;" >NOMBRE</td>
					  <td width="13%" align="center" style="font-weight: bold;" >COSTO</td>
                      <td width="13%" align="center" style="font-weight: bold;" >CANTIDAD</td>
					  <td width="13%" align="center" style="font-weight: bold;" >SUBTOTAL</td>
                      
                  </tr>
               </thead>
                  <tbody> 
                  <?php 
				   foreach(array_reverse($itemsEnCesta,true) as $k => $v)
		           {
					   $array_k = explode("|",$k);
					   $this->produ->id_producto = $array_k[0];
					  // $row_productos = $this->obtenerInformacionProducto($k);
					   $row_productos = $this->produ->ObtenerDatosProducto();
					   					   
					   $sql_talla = "SELECT * FROM tallas WHERE idtallas = '$array_k[1]'";
					   $result = $this->db->consulta($sql_talla);
					   $result_row = $this->db->fetch_assoc($result);
					    
				  ?>
                      <tr>
                        <td valign="top" align="center" style="color:#000">
							<button type="button" onClick="eliminarCarritoSalida('<?php echo $k; ?>','descripcion_carrito');" title="ELIMINAR" class="btn btn-outline-danger">
								<i class="far fa-trash-alt"></i>
							</button>
                     	</td>
                          <td valign="top" align="center" style="color:#000"><?php echo $this->funcion->imprimir_cadena_utf8($array_k[0]);?>
                          </td>
						  <td valign="top" align="center" style="color:#000"><?php echo $this->funcion->imprimir_cadena_utf8($result_row['valor']." ".$result_row['unidad']);?>
                          </td>
                        <td align="center" valign="top"  style="padding-left:5px; color:#000;">
						    <?php echo $this->funcion->imprimir_cadena_utf8($row_productos['nombre']);?></td>
						  <td valign="top" align="center" style="color:#000">$<?php echo $row_productos['pv'];?>
                          <td valign="top"  style="padding-left:5px; color:#000;" align="center"><?php echo $v;?></td>
						  <td valign="top" align="center" style="color:#000">$<?php echo $row_productos['pv']* $v;?>
                      	
                          </td>
                      
                      </tr>
				   <?php 
				   
				   $contador++;
                   }// fin de foreach
                   ?>
                  
                
                  <!--<tr>
                      <td  colspan="9" style=" padding-left:5px; padding-right:5px; color:#000" align="right" bgcolor="#F2F2F2">
                          <input type="submit" name="button" id="button" value="Levantar Orden" onclick="levantarOrden('contenido',<?php echo $subtotal;?>,<?php echo $iva;?>,<?php echo $total;?>,<?php echo $descuento_total;?>)" class="cajasmodificar">
                      </td>
                  </tr>-->
                  </tbody> 
              </table>
            
		  <?php 
		  }// fin de sesion
		  else
		  {
		  ?>
         
            <table width="100%" border="0" cellspacing="2" cellpadding="2" class="tablesorter">
                  <tr>
                      <td align="center">
                        <!--<img src="images/shoppingcart_empty.png"/><br />-->
                          Tu carrito de productos esta vac&iacute;o<br />
                      </td>
                  </tr>
                  
            </table>
          
      <?php 
		  }// fin de else
	  }// fin de metodo verCarrito
	  
	  
	  //termina el shopping cart de compras
	
	  
	  public function delProductoSalidas($item)
	 {
		 //$_SESSION['count']--;
		  if (isset($_SESSION['itemsEnCestaSalidas']))
		  {
				foreach($_SESSION['itemsEnCestaSalidas'] as $k => $v)
				{ 
				  if (isset($item))
				   {
					    unset ($_SESSION['itemsEnCestaSalidas'][$item]);
				   }
				   
				}
		  } 
		  
	 }// fin de método delProducto
	 
	 
	 
	 
	 
	 
	 ///carrito para agregar productos a a asignacion.
	 
	 /*
	     *********************************************
		 *********************************************
		 *********************************************
		 *********************************************
		 PRODUCTOS EN CONSIGNACION
	 
	 
	 
	 */
	 
	  public function addProductoConsignacion($item,$cantidad)
	 {
		 $this->produ->id_producto = $item;
		 $existe = $this->produ->verificaProducto();
		 
		
		if($existe != 0)
		{
					//SI LA CANTIDAD ES 0 no hagas nada.
					if ($cantidad==0)
					{
					   return;
					}
					//termina.
					
					
					//si trae un producto.... realizas esto...
					if($item)
					{ 
					   if(!isset($_SESSION['itemsEnCestaConsignacion']))
					   {  
						  
						  $this->sesion->crearSesion('itemsEnCestaConsignacion',null);
						  $_SESSION['itemsEnCestaConsignacion'][$item] = $cantidad;
					
					   }
					   else
					   {  
						  foreach($_SESSION['itemsEnCestaConsignacion'] as $k => $v)
						  {  
							 if ($item == $k)
							 {  
								 $_SESSION['itemsEnCestaConsignacion'][$k] = $v + 1;
								 $encontrado=1;  
							 }  
						  }  
						  
						  if ($encontrado==0)
							  { 
								  $_SESSION['itemsEnCestaConsignacion'][$item]=$cantidad; 
							   }    
						}  
					 }
					 
		}
	 }  //fin de la clase agregar a shopoing cart
	 
	 
	 
	 
	 
	   public function delProductoConsignacion($item)
	 {
		 //$_SESSION['count']--;
		  if (isset($_SESSION['itemsEnCestaConsignacion']))
		  {
				foreach($_SESSION['itemsEnCestaConsignacion'] as $k => $v)
				{ 
				  if (isset($item))
				   {
					    unset ($_SESSION['itemsEnCestaConsignacion'][$item]);
				   }
				   
				}
		  } 
		  
	 }// fin de método delProducto
	 
	 
	 
	 
	 
	 public function verCarritoConsignacion()
	  {
		  $contador = 1;
		  
		  $itemsEnCesta = $_SESSION['itemsEnCestaConsignacion'];
		  $cantidad = count($itemsEnCesta); // obtenemos la longitud del array de sesion
		  
		  
		  if (isset($itemsEnCesta) && $cantidad>0) // validamos que la session de array exista y que contenga un producto
		  {
		  ?>
         
              <table width="90%" cellspacing="2" cellpadding="2" class="tablesorter">
              <thead> 
                  <tr>
                    <td width="6%" valign="top" align="center" >Acci&oacute;n</td>
                      <td width="6%" valign="top" align="center" >C&oacute;digo</td>
                      <td width="18%" align="center" >Nombre</td>
                      <td width="13%" align="center" >Cantidad</td>
                      <td width="13%" align="center" >Costo</td>
                      <td width="13%" align="center" >Total</td>
                  </tr>
               </thead>
                  <tbody> 
                  <?php 
				   foreach(array_reverse($itemsEnCesta,true) as $k => $v)
		           {
					   $this->produ->id_producto = $k;
					  // $row_productos = $this->obtenerInformacionProducto($k);
					   $row_productos = $this->produ->ObtenerDatosProducto();
					    
				  ?>
                      <tr>
                        <td valign="top" align="center" style="color:#000">
                  <span style="padding-left:5px; padding-right:5px; color:#000">
                  <a href="#" onclick="eliminarCarritoConsignacion('<?php echo $k; ?>','d_productos_consignacion')" <?php echo $disabled;?>>                        <img  src="images/004.png" alt=""  width="15px" height="15px" title=":: Eliminar Carrito ::"/>
                  </a>
                        </span>
                     </td>
                          <td valign="top" align="center" style="color:#000"><?php echo utf8_encode($k);?>
                          </td>
                        <td align="center" valign="top"  style="padding-left:5px; color:#000;">
						    <?php echo htmlentities($row_productos['nombre'], ENT_QUOTES | ENT_IGNORE, "ISO-8859-1");?></td>
                          <td valign="top"  style="padding-left:5px; color:#000;" align="center"><?php echo $v;?></td>
                      	<td valign="top" align="center" style="color:#000">$<?php echo number_format($row_productos['pv'],2,'.',',');?>
                          </td>
                      	<td valign="top" align="center" style="color:#000">$<?php echo number_format($row_productos['pv']* $v,2,'.',',');?></td>
                      
                      </tr>
                     
				   <?php 
				   
				   //sumatorias
				   
				   
				   $total = $total + $row_productos['pv']* $v;
				   
				   $iva =  $total / 1.16;
				   
				   
				   $contador++;
                   }// fin de foreach
                   ?>
                  
                  
                  
                  
                   <tr>
                     <td colspan="6" align="center" valign="top" style="color:#000">&nbsp;</td>
                    </tr>
                   <tr>
                        <td colspan="2" align="center" valign="top" style="color:#000">&nbsp;</td>
                        <td align="center" valign="top" style="color:#000">CANTIDAD</td>
                        <td valign="top"  style="padding-left:5px; color:#000;" align="center">0</td>
                        <td valign="top" align="center" style="color:#000;">SUBTOTAL</td>
                        <td align="center" valign="top" bgcolor="#00FF00" style="color:#000">$0</td>
                      </tr>
                      <tr>
                        <td colspan="4" rowspan="2" align="center" valign="top" style="color:#000">&nbsp;</td>
                        <td align="center" valign="top" style="color:#000">I.V.A</td>
                        <td align="center" valign="top" bgcolor="#FFFFCC" style="color:#000">$<?php echo $iva; ?></td>
                      </tr>
                      <tr>
                        <td align="center" valign="top" style="color:#000">TOTAL</td>
                        <td align="center" valign="top" bgcolor="#00FF00" style="color:#000">$<?php echo $total; ?></td>
                      </tr>
                      
                      
                
                  <!--<tr>
                      <td  colspan="9" style=" padding-left:5px; padding-right:5px; color:#000" align="right" bgcolor="#F2F2F2">
                          <input type="submit" name="button" id="button" value="Levantar Orden" onclick="levantarOrden('contenido',<?php echo $subtotal;?>,<?php echo $iva;?>,<?php echo $total;?>,<?php echo $descuento_total;?>)" class="cajasmodificar">
                      </td>
                  </tr>-->
                  </tbody> 
              </table>
            
		  <?php 
		  }// fin de sesion
		  else
		  {
		  ?>
         
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tablesorter">
                  <tr>
                      <td align="center">
                        <img src="images/shoppingcart_empty.png"/><br />
                          Tu carrito de productos esta vac&iacute;o<br />
                      </td>
                  </tr>
                  
            </table>
          
      <?php 
		  }// fin de else
	  }// fin de metodo verCarrito
	  
	  
	  
	  
	  
	  
	  
	  //||||||||||||| INICIA SHOPING CART DE ENTREGA||||||||||||||||||/////////////////////////////////////////
	 //||||||||||||| INICIA SHOPING CART DE ENTREGA||||||||||||||||||/////////////////////////////////////////
	 //||||||||||||| INICIA SHOPING CART DE ENTREGA||||||||||||||||||/////////////////////////////////////////
	 //||||||||||||| INICIA SHOPING CART DE ENTREGA||||||||||||||||||/////////////////////////////////////////
	 public function addProductoEntrega($item,$cantidad)
	{
		 $this->produ->id_producto = $item;
		 $existe = $this->produ->verificaProducto();
		 
		
		if($existe != 0)
		{
			//
					//SI LA CANTIDAD ES 0 no hagas nada.
					if ($cantidad==0)
					{
					   return;
					}
					//termina.
					
					
					//si trae un producto.... realizas esto...
					if($item)
					{
					   if(!isset($_SESSION['itemsEnCestaEntrega']))
					   {  
						  
						  $this->sesion->crearSesion('itemsEnCestaEntrega',null);
						  $_SESSION['itemsEnCestaEntrega'][$item] = $cantidad;
							
					   }
					   else
					   {  
						  foreach($_SESSION['itemsEnCestaEntrega'] as $k => $v)
						  {  
							 if ($item == $k)
							 {  
								 
								 //$this->restarProductoExcedido($k,$c);
								 /*//en este foreach comparo la sesion donde tengo la lista de productos
								 para esta nota de remision, comparo el codigo del producto que tengo en la 
								 sesion vi_productos_entrega con la que tengo en el foreach anterior(itemsEnCestaEntrega) si el codigo es igual al codigo que esta en mi sesion vi_productos , pregunto si la cantidad que esta ingresando es igual a la que tengo el la sesion vi productos , es es igual no hago nada , pero si no le aumento 1 a la cantidad del carrito itemsencestaentrega */
								 foreach($_SESSION['vi_productos_entrega'] as $p => $ps)
							 { 
									
									 
									 if ($k == $p)
									 {
										// echo "hay un igual <br>"; 
										 if ($ps == $v)
										 {
											 //echo "estoy restando <br>";
											  // $_SESSION['itemsEnCestaEntrega'][$k] = $v - 1;
											 
											  return ;
										 }
										 else 
										 {
											 $c =  $_SESSION['itemsEnCestaEntrega'][$k] = $v + 1;
								             $encontrado=1; 
										 }
									 }
										 
							
							  } 
								 
								 
							 } 
							
							
						  }  
						  
						  if ($encontrado==0)
							  { 
								  $_SESSION['itemsEnCestaEntrega'][$item]=$cantidad; 
							   }    
						}  
					 }
					 
		}
	 }//fin de addproductocestaEntrega
	  
	  
	  
	  
	   public function verCarritoEntrega()
	  {
		  $contador = 1;
		  
		  $itemsEnCesta = $_SESSION['itemsEnCestaEntrega'];
		  $cantidad = count($itemsEnCesta); // obtenemos la longitud del array de sesion
		 // $estatus = array ('Incompleto','Completo','Exedido');
		  
		  
		  if (isset($itemsEnCesta) && $cantidad>0) // validamos que la session de array exista y que contenga un producto
		  {
		  ?>
         
              <table width="90%" cellspacing="2" cellpadding="2" class="tablesorter">
              <thead> 
                  <tr>
                    <td width="6%" valign="top" align="center" >Acci&oacute;n</td>
                      <td width="6%" valign="top" align="center" >C&oacute;digo Producto</td>
                      <td width="18%" align="center" >Nombre</td>
                      <td width="13%" align="center" >Cantidad</td>
                      <td width="13%" align="center" >Costo</td>
                  </tr>
               </thead>
                  <tbody> 
                  <?php 
				   foreach(array_reverse($itemsEnCesta,true) as $k => $v)
		           {
					   $this->produ->id_producto = $k;
					  // $row_productos = $this->obtenerInformacionProducto($k);
					   $row_productos = $this->produ->ObtenerDatosProducto();
					   $idnota_remision = $this->sesion->obtenerSesion('idnota_remision');
					   
					   //sabremos la cantidad de producto ingresado y la comparo con la de la base de datos
					   //para imprimir estatus si esta completo o exedido
					   $this->entrega->idnota_remision = $idnota_remision ;
					   $this->entrega->idproduto = $k ;
					   $result_cantidad = $this->entrega->obtenerCantidadProducto($v);
					   
					   //echo "este es result_cantidad = ".$result_cantidad;
					   
					   
					   //sabremos la cantidad de producto ingresado y la comparo con la de la base de datos
					   
					   
					   
					   
					   
					   
					   
					    
				  ?>
                      <tr>
                        <td valign="top" align="center" style="color:#000">
                  <span style="padding-left:5px; padding-right:5px; color:#000">
                  <a href="#" onclick="eliminarCarritoEntrega('<?php echo $k; ?>','descripcion_carrito')" <?php echo $disabled;?>>                        <img  src="images/004.png" alt=""  width="15px" height="15px" title=":: Eliminar Carrito ::"/>
                  </a>
                        </span>
                     </td>
                          <td valign="top" align="center" style="color:#000"><?php echo utf8_encode($k);?>
                          </td>
                        <td align="center" valign="top"  style="padding-left:5px; color:#000;">
						    <?php echo htmlentities($row_productos['nombre'], ENT_QUOTES | ENT_IGNORE, "ISO-8859-1");?></td>
                          <td valign="top"  style="padding-left:5px; color:#000;" align="center"><?php echo $v;?></td>
                      	<td valign="top" align="center" style="color:#000"><?php echo $row_productos['pv'];?>
                          </td>
                         <?php  echo $estatus[$result_cantidad];?>
                          </td>   
                      
                      </tr>
				   <?php 
				   
				   $contador++;
                   }// fin de foreach
                   ?>
                  
                
                  <!--<tr>
                      <td  colspan="9" style=" padding-left:5px; padding-right:5px; color:#000" align="right" bgcolor="#F2F2F2">
                          <input type="submit" name="button" id="button" value="Levantar Orden" onclick="levantarOrden('contenido',<?php echo $subtotal;?>,<?php echo $iva;?>,<?php echo $total;?>,<?php echo $descuento_total;?>)" class="cajasmodificar">
                      </td>
                  </tr>-->
                  </tbody> 
              </table>
            
		  <?php 
		  }// fin de sesion
		  else
		  {
		  ?>
         
            <table width="100%" border="0" cellspacing="2" cellpadding="2" class="tablesorter">
                  <tr>
                      <td align="center">
                        <img src="images/shoppingcart_empty.png"/><br />
                          Tu carrito de productos esta vac&iacute;o<br />
                      </td>
                  </tr>
                  
            </table>
          
      <?php 
		  }// fin de else
	  }// fin de metodo verCarrito
	  
	  
	  //termina el shopping cart de compras
	
	  
	  public function delProductoEntrega($item)
	 {
		 //$_SESSION['count']--;
		  if (isset($_SESSION['itemsEnCestaEntrega']))
		  {
				foreach($_SESSION['itemsEnCestaEntrega'] as $k => $v)
				{ 
				  if (isset($item))
				   {
					    unset ($_SESSION['itemsEnCestaEntrega'][$item]);
				   }
				   
				}
		  } 
		  
	 }// fin de método delProducto
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 public function addTraspasodeProducto($item,$cantidad,$sucursal,$para,$observaciones,$talla)
	{
		
	
		
		//si el producto no existe no hacemos nada...
		
			$this->produ->id_producto = $item;
			$this->produ->idsucursales = $sucursal;
		 	$this->produ->idtallas = $talla;
			$existe = $this->produ->verificaProductoExistenteInventario();
		   
		if($existe == 1)
		  {
	
	            //este if nos sirve para verificar que ya existe la sesion de apunta de venta.
	            if(!isset($_SESSION['Traspaso']))
				   {  
					  
					  $this->sesion->crearSesion('Traspaso',null);
					  $_SESSION['Traspaso'][$item."|".$talla] = $cantidad;
					  $_SESSION['para'] = $para;
					  $_SESSION['de'] = $sucursal;
					  $_SESSION['observaciones'] = $observaciones;
				
				   }
				   else  //si nexiste hace un ciclo para buscar el producto y sumarle la nueva cantidad.
				   {  
					  foreach($_SESSION['Traspaso'] as $k => $v)
					  {  
						 if ($item."|".$talla==$k)
						 {  
						 
						     //sumamos lo que existe en sesion mas el de ahora 
							 
							  $nuevacantidad = $_SESSION['Traspaso'][$k] + $cantidad;						     
							  $sepuede = $this->produ->alcanzaProducto($nuevacantidad);
						 
						 
						     if($sepuede == 1)
							 {
							 	$_SESSION['Traspaso'][$k]=$_SESSION['Traspaso'][$k]+$cantidad."|".$talla; 
								?>
								
							 <h4 class="alert alert-success" style="margin-top: -5px;">EL PRODUCTO SE AGREGO CORRECTAMENTE <?php echo $this->produ->id_producto; ?></h4>
								<?php 
							 }else
							 {
							  ?>
						     <h4 class="alert alert-danger" style="margin-top: -5px;">NO HAY TANTO PRODUCTO EN EXISTENCIA <?php echo $this->produ->id_producto; ?></h4>						  <?php
							 } 
							  $encontrado = 1 ;
						 }  
					  }  
					  
					  if (!$encontrado)
					       { 
					           $_SESSION['Traspaso'][$item."|".$talla]=$cantidad."|".$talla; 
							   $_SESSION['para'] = $para;
							   $_SESSION['de'] = $sucursal;
							   $_SESSION['observaciones'] = $observaciones;
							}    
					}  
					
						?>
               
                
                
        
		<?php
				
		    }//fin de la comparacion de que si existye el producto en stock.
			else
			{
				?>
                 
            		
                          <h4 class="alert_error" style="margin-top: -5px;">NO EXISTE PRODUCTO O NO HAY PRODUCTO EN STOCK</h4> 
            		
    
        		
        
		<?php
			}
		
		  
	 }// fin de método addProducto
	 
	 
	 public function delProductoTraspaso($item)
	 {
		 //$_SESSION['count']--;
		  if (isset($_SESSION['Traspaso']))
		  {
				foreach($_SESSION['Traspaso'] as $k => $v)
				{ 
				  if (isset($item))
				   {
					    unset ($_SESSION['Traspaso'][$item]);
				   }
				   
				}
		  } 
		  
	 }// fin de método delProducto
	 
	 
	
	 public function verCarritoTraspaso()
	  {
		 
		try
		{  
		  $contador = 1;		  
		  $itemsEnCesta = $_SESSION['Traspaso'];
		  $cantidad = count($itemsEnCesta); // obtenemos la longitud del array de sesion
		  $para = $_SESSION['para'];
		  $de = $_SESSION['de'];
		  $observaciones = $_SESSION['observaciones'];
		  
		  
	//obtenemos de la clase de configuracion que tipo de configuracion tiene tanto iva como el tipo de descuento que maneja.
	
	
			$row_configuracion = $this->confi->ObtenerInformacionConfiguracion();			
			$iva = $row_configuracion['iva']/100;
			$t_descuento = $row_configuracion['t_descuento'];	  // 0-producto  1 - por paquete 2 - ambos.
		  
//Obtenemos el descuento que tiene el cliente
			
			if($cliente != 0)
			{
				$this->clientes->idCliente = $cliente;
				$row_cliente = $this->clientes->ObtenerInformacionCliente(); //obtenemos toda la informacion del cliente.
				$c_descuento = $row_cliente['porc_desc']; //obtenemos el descuento que tiene configurado el cliente en el sistema.
			}else
			{
			    $c_descuento = 0;	
			}
		  
		  // validamos que la session de array exista y que contenga un producto
		  
		  if ( isset($itemsEnCesta) && $cantidad > 0 ) 
		      {
				  
				 $sql_sucursal = "SELECT * FROM sucursales WHERE idsucursales = '$de'";
				 $result_sucursal = $this->db->consulta($sql_sucursal);
				 $result_sucursal_row = $this->db->fetch_assoc($result_sucursal);
				 
				 
				 $sql_sucursal2 = "SELECT * FROM sucursales WHERE idsucursales = '$para'";
				 $result_sucursal2 = $this->db->consulta($sql_sucursal2);
				 $result_sucursal2_row = $this->db->fetch_assoc($result_sucursal2);
		  ?>
          
<div style="height:500px; background-color: #D8D6D6; overflow:auto" >
                    <table width="100%" cellspacing="2" cellpadding="2">
                  <tr>
                    <td width="4%" align="center"  bgcolor="#CCCCCC" >&nbsp;</td>
                      <td width="12%" align="center"  bgcolor="#CCCCCC" >Cod. Producto</td>
					  <td width="12%" align="center"  bgcolor="#CCCCCC" >Talla</td>
                      <td width="43%" align="center" bgcolor="#CCCCCC" >Nombre Producto</td>
                      <td width="5%" align="center" bgcolor="#CCCCCC" >Cant.</td>
                      <td width="6%" align="center" bgcolor="#CCCCCC" >P.V</td>
                      <!--<td width="11%" align="center" bgcolor="#CCCCCC" > Desc %</td>-->
                      <td>De</td>
                      <td>Para</td>
                      <td>Observaciones</td>
                      <!--<td width="9%" align="center" bgcolor="#CCCCCC" >Total Desc</td>
                      <td width="10%" align="center" bgcolor="#CCCCCC" >Total</td>-->
                  </tr>
                  <?php 
				  
				  $descuento_total  = 0;
				  $monto_total = 0;
				  $sumaproductos =0;
				  
				   foreach(array_reverse($itemsEnCesta,true) as $k => $v)
		           {
					   $array_k = explode('|',$k);
					   $this->produ->id_producto = strtoupper(trim($array_k[0]));  //enviamos el valor del id producto a la clase de productos
					   $row_productos = $this->produ->ObtenerDatosProducto();  //obtenemos el array con los valores del prodcuto.
					   $array_v = explode('|',$v);
					   
					   $cantidad_produ =$array_v[0];  //obtemos la cantidad de producto en el carrito
					   $idtallas = $array_k[1];
					   $sumaproductos = $sumaproductos + $cantidad_produ; //obtenemos la suma de todos los productos que se estan comprando.
					   
					   $costo = $row_productos['pv']; //obtenemos el precio venta ya con IVA.
					   
					   $descuento = $row_productos['descuento']/100; //obtenemos el porcentaje del descuento en la base de datos del producto.
					   				
					   $SubPorProducto = round($cantidad_produ * $costo,2);  //obtenemos el subtotal del producto cantidad precio.
					   
					   
					   
					   //validamos que si es por producto o ambos se ejecute el descuento.
					   
					   
					   
					   if($t_descuento == 0 || $t_descuento == 2)
					   {
					       $DescPorProducto = round($SubPorProducto * $descuento,2); //obtenemos el total del descuento de ese producto.
					   }else
					   {
						   $DescPorProducto = 0;
					   }
 					   
					   $SubtotalBrutoPorProducto = round($SubPorProducto - $DescPorProducto,2);  //OBTENEMOS EL TOTAL DEL PRRODUCTO MENOS EL DESCUENTO.
					   
					    //suma de subtotales descuentos
						$total_pagar_sinDescuento = $total_pagar_sinDescuento+$SubtotalBrutoPorProducto;
						$total_pagar = $total_pagar + $SubtotalBrutoPorProducto;
						$SumadeDescuentos = $SumadeDescuentos + $DescPorProducto;
						
					   
					   $sql_tallas = "SELECT * FROM tallas WHERE idtallas = '$idtallas'";
					   $result_tallas = $this->db->consulta($sql_tallas);
					   $result_tallas_num = $this->db->num_rows($result_tallas);
					   $result_tallas_row = $this->db->fetch_assoc($result_tallas);
										   
					   
				  ?>
                      <tr>
                        <td align="center" valign="top" bgcolor="#FFFFCC" style="color:#000">
                            <span style="padding-left:5px; padding-right:5px; color:#000">
               			    <a href="#" onclick="delProductoTraspaso('<?php echo $k; ?>')" >
                          				<img  src="images/004.png" alt=""  width="15px" height="15px" title=":: Eliminar Carrito ::" />
                                 </a>
                            </span>
                        </td>
                          <td align="center" valign="top" bgcolor="#FFFFCC" style="color:#000"><?php echo utf8_encode($row_productos['idproducto']);?>
                          </td>
						  <td align="center" valign="top" bgcolor="#FFFFCC" style="color:#000"><?php echo utf8_encode($result_tallas_row['talla']);?>
                          </td>
                        <td valign="top" bgcolor="#FFFFCC"  style="padding-left:5px; color:#000;"><?php echo htmlentities(strtoupper($row_productos['nombre']), ENT_QUOTES | ENT_IGNORE, "ISO-8859-1");?></td>
                          <td align="center" valign="top" bgcolor="#FFFFCC"  style="padding-left:5px; color:#000;"><?php echo $cantidad_produ; ?>
           <td align="center" valign="top" bgcolor="#FFFFCC"  style="padding-left:5px; color:#000;">
		          <?php echo '$ '.$costo ?>
           </td>
           <td align="center" valign="top" bgcolor="#FFFFCC" style="padding-left:5px; padding-right:5px; color:#000"  ><span style="padding-left:5px; color:#000;"><?php echo utf8_encode($result_sucursal_row['sucursal']);?></span></td>
                          <td align="center" valign="top" bgcolor="#FFFFCC" style="padding-left:5px; padding-right:5px; color:#000"  >
                                <span style="padding-left:5px; color:#000;"><?php echo utf8_encode($result_sucursal2_row['sucursal']);?></span>
                          </td>
                          
                          <td align="center" valign="top" bgcolor="#FFFFCC" style="padding-left:5px; padding-right:5px; color:#000"  >
                                <span style="padding-left:5px; color:#000;"><?php echo $observaciones;?></span>
                          </td>
                          
                          <!--<td valign="top" style="padding-left:5px; padding-right:5px; color:#fff;  background-color: #666364;" align="center" >
                          
						     <?php echo "$ ".number_format($SubtotalBrutoPorProducto,2,'.',','); ?>
                             </td>-->
                      </tr>
				   <?php 
				   
                   }// fin de foreach
				   
				   
				   //Descuento por Paquete.
				   
				   if($t_descuento == 1 || $t_descuento == 2 )
				      {
					  
						  $row = $this->paquetes->obtenerQuePaqueteporRango($total_pagar);
						  						  
						  if($row['cuantos'] != 0)
						  {
							$porc_descuento_paquete = $row['descuento'] / 100;
						    $SumadeDescuentosPaquete = $total_pagar * $porc_descuento_paquete;
						  }else
						  {
							$SumadeDescuentosPaquete = 0;
						  }
						  
						  
					  }else
					  {
						  $SumadeDescuentosPaquete = 0;
					  }
					  
					  
				    //restar el descuento por paquete si es que existe alguno
					
					$total_pagar = $total_pagar - $SumadeDescuentosPaquete;  
					
					
					//obtenemos el descuento del cliente y obtenemos la cantidad de descuento a realizarle.
					
					
					
					
					
					
					
				   
				   //SUMA DE DESCUENTOS PARA OBTENER LOS TOTALES A PAGAR		   
				   
				   
				   
				   $subtotal = 	round($total_pagar/(1+$iva),2);
				   $iva = $total_pagar - $subtotal;	 
				   
				   
				   //TERMINA LAS VARIABLES CON TOTALES DE LA COMPRA CON SU DESCUENTO.
				 
                   ?>
                  <!--<tr>
                      <td colspan="7" align="right" style="color:#000">SubTotal:</td>
                      <td colspan="2" style=" padding-left:5px; padding-right:5px; color:#000" bgcolor="#F2F2F2">$ <?php echo number_format($subtotal,2,'.',','); ?>
                      <input type="hidden" name="v_subtotal" id="v_subtotal" value="<?php echo $subtotal;?>" /></td>
                  </tr>-->
                  
                  <?php if($t_descuento == 0 || $t_descuento == 2) {?>
                  
                  <!--<tr>
                    <td colspan="7" align="right"  style="color:#000">Desc. por Producto:</td>
                    <td colspan="2" bgcolor="#FF0000" style=" padding-left:5px; padding-right:5px; color:#000" >- $ <?php echo number_format($SumadeDescuentos,2,'.',','); ?>
                      <input type="hidden" name="v_desc_producto" id="v_desc_producto" value="<?php echo $SumadeDescuentos;?>" /></td>
                  </tr>-->
                  
                  
                  <?php
				  }
                  
                   if($t_descuento == 1 || $t_descuento == 2) {?>
                  
                  <!--<tr>
                    <td colspan="7" align="right"  style="color:#000">Desc. por Paquete:</td>
                    <td colspan="2" bgcolor="#FF0000" style=" padding-left:5px; padding-right:5px; color:#000" >- $ <?php echo number_format($SumadeDescuentosPaquete,2,'.',','); ?>
                      <input type="hidden" name="v_desc_paquete" id="v_desc_paquete" value="<?php echo $SumadeDescuentosPaquete;?>" /></td>
                  </tr>-->
                  <?php
				   }
				  
				  //SI EL CLIENTE ES PUBLICO EN GENERAL.
				  
				  if($row_cliente != 0){ 
				  		
						$porc_descuento_cliente = $c_descuento / 100;
				  		$desc_cliente = round($total_pagar * $porc_descuento_cliente,2); //cantidad de descuento a realizar.
						$total_pagar = $total_pagar - $desc_cliente;
						$descuento_cliente = number_format($desc_cliente,2,'.',',');
						
						
						 //iniciamos las variables de sesion para poder
		  
						   $s_v1 = $_SESSION['vs_totalproductos']=$sumaproductos; 
						   $s_v2 = $_SESSION['vs_montodescuento'] = number_format(round($total_pagar_sinDescuento,2),2,'.',',');
						   $s_v3 = $_SESSION['vs_descuento']= number_format(round($desc_cliente,2),2,'.',',');
						   $s_v4 = $_SESSION['vs_totalcondescuento']=number_format(round($total_pagar,2),2,'.',',');
		  
						
						
						
				  ?>
                  <!--<tr>
                    <td colspan="7" align="right"  style="color:#000">Desc. por Cliente:</td>
                    <td colspan="2" bgcolor="#FF0000" style=" padding-left:5px; padding-right:5px; color:#000" >- $ <?php echo $descuento_cliente; ?>
                      <input type="hidden" name="v_desc_cliente" id="v_desc_cliente" value="<?php echo $desc_cliente;?>" /></td>
                  </tr>-->
                  <?php
				  }else
				  {
					       $s_v1 = $_SESSION['vs_totalproductos']=$sumaproductos; 
						   $s_v2 = $_SESSION['vs_montodescuento'] = number_format(round($total_pagar_sinDescuento,2),2,'.',',');
						   $s_v3 = $_SESSION['vs_descuento']= number_format(round($desc_cliente,2),2,'.',',');
						   $s_v4 = $_SESSION['vs_totalcondescuento']=number_format(round($total_pagar,2),2,'.',',');
				  }
				  
				  ?>
                  
                  <!--<tr>
                      <td colspan="7" align="right"  style="color:#000">IVA:</td>
                      <td colspan="2" style=" padding-left:5px; padding-right:5px; color:#000" >$ <?php echo number_format($iva,2,'.',','); ?>
                      <input type="hidden" name="v_iva" id="v_iva" value="<?php echo $iva;?>" /></td>
                  </tr>
                  <tr style="font-size:18px; ">
                      <td colspan="7" align="right"  style="color:#000;">TOTAL A PAGAR:</td>
                      <td colspan="2" style="padding-left:5px; padding-right:5px; color:#000;" bgcolor="#CCCCCC">$<span style="padding-left:5px; padding-right:5px; color:#000"><span style="padding-left:5px; color:#000;"><?php echo number_format(round($total_pagar,2),2);?><span style=" padding-left:5px; padding-right:5px; color:#000">
                        <input type="hidden" name="v_total_pagar" id="v_total_pagar" value="<?php echo $total_pagar;?>"/>
                      </span></span></span></td>
                  </tr>-->
                  <!--<tr>
                      <td  colspan="9" style=" padding-left:5px; padding-right:5px; color:#000" align="right" bgcolor="#F2F2F2">
                          <input type="submit" name="button" id="button" value="Levantar Orden" onclick="levantarOrden('contenido',<?php echo $subtotal;?>,<?php echo $iva;?>,<?php echo $total;?>,<?php echo $descuento_total;?>)" class="cajasmodificar">
                      </td>
                  </tr>-->
              </table>
              
           </div> 
           
            <div id="d_sumatorias_pedido">
 <table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tbody>
    <tr style="height: 30px; font-style: normal; font-weight: bold; font-size: 16px;"; bgcolor="#959595">
      <td width="18%" align="right" bgcolor="#F0EDED">Total de Productos:</td>
      <td width="9%" align="center" style="background-color: #DADADA; padding: 0px 5px 0px 5px; font-size: 24px;" id="v_totalproducto"><?php echo  $s_v1;?></td>
      <!--<td width="22%" align="right" bgcolor="#F0EDED">Monto sin descuento:</td>
      <td width="11%" align="center" style="background-color: #DADADA; padding: 0px 5px 0px 5px; font-size: 24px;" id="v_montodescuento"><?php echo $s_v2;?></td>
      <td width="12%" align="right" bgcolor="#F0EDED">Descuento  <?php echo $c_descuento; ?>%:</td>
      <td width="11%" align="center" style="background-color: #DADADA; padding: 0px 5px 0px 5px; font-size: 24px;" id="v_descuento"><?php echo $s_v3; ?></td>
      <td width="9%" align="right" bgcolor="#F0EDED">Total:</td>
      <td width="8%" align="center" style="background-color: #DADADA; padding: 0px 5px 0px 5px; font-size: 24px;" id="v_totaldescuento"><?php echo $s_v4;?></td>-->
    </tr>
  </tbody>
</table>
    </div>
    
    </div>
              
		  <?php 
		  
		
		  
		  }// fin de sesion
		  else
		  {
		  ?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                      <td align="center">
                        <img src="images/shoppingcart_empty.png"/><br />
                          Tu carrito de traslados esta vac&iacute;o<br />
                      </td>
                  </tr>
</table>
      <?php 
		  }// fin de else
		  
		}catch(Exception $e)
        {
		  $v = explode ('|',$e);
		  $n = explode ("'",$v[1]);
		  echo '<div class="alert_error" id="mens">'.$this->db->m_error($n[0]).'</div>'; 	   
        }
		  
	  }// fin de metodo verCarrito
	 
	 
	   public function addApartado($item,$cantidad,$sucursal,$idcategoria_precio,$nombre_categoria,$idtallas)
	{
		
	
		
		//si el producto no existe no hacemos nada...
		
			$this->produ->id_producto = $item;
			$this->produ->idsucursales = $sucursal;
		    $this->produ->idtallas = $idtallas;
			$existe = $this->produ->verificaProductoExistenteInventario();
		   
		if($existe == 1)
		  {
	
	            //este if nos sirve para verificar que ya existe la sesion de apunta de venta.
	            if(!isset($_SESSION['Apartado']))
				   {  
					  
					  $this->sesion->crearSesion('Apartado',null);
					  $_SESSION['Apartado'][$item."|".$idtallas] = $cantidad."|".$idcategoria_precio."|".$nombre_categoria;
				
				   }
				   else  //si nexiste hace un ciclo para buscar el producto y sumarle la nueva cantidad.
				   {  
					  foreach($_SESSION['Apartado'] as $k => $v)
					  {  
						 if ($item."|".$idtallas==$k)
						 {  
						 
						     //sumamos lo que existe en sesion mas el de ahora 
							 
							  $nuevacantidad = $_SESSION['Apartado'][$k] + $cantidad;						     
							  $sepuede = $this->produ->alcanzaProducto($nuevacantidad);
						 
						 
						     if($sepuede == 1)
							 {
							 	$_SESSION['Apartado'][$k]=$_SESSION['Apartado'][$k]+$cantidad."|".$idcategoria_precio."|".$nombre_categoria; 
								?>
								
							 <h4 class="alert alert-success" style="margin-top: -5px;">EL PRODUCTO SE AGREGO CORRECTAMENTE<?php echo $this->produ->id_producto; ?></h4>
								<?php 
							 }else
							 {
							  ?>
						     <h4 class="alert alert-danger" style="margin-top: -5px;">NO HAY TANTO PRODUCTO EN EXISTENCIA<?php echo $this->produ->id_producto; ?></h4>						  <?php
							 } 
							  $encontrado = 1 ;
						 }  
					  }  
					  
					  if (!$encontrado)
					       { 
					           $_SESSION['Apartado'][$item."|".$idtallas]=$cantidad."|".$idcategoria_precio."|".$nombre_categoria; 
							}    
					}  
					
						?>
               
                
                
        
		<?php
				
		    }//fin de la comparacion de que si existye el producto en stock.
			else
			{
				?>
                 
            		
                          <h4 class="alert alert-danger" style="margin-top: -5px;">NO EXISTE PRODUCTO O NO HAY PRODUCTO EN STOCK</h4> 
            		
    
        		
        
		<?php
			}
		
		  
	 }// fin de método addProducto
	
	
	public function verCarritoApartado($cliente)
	  {
		 
		try
		{  
		  $contador = 1;		  
		  $itemsEnCesta = $_SESSION['Apartado'];
		  $cantidad = count($itemsEnCesta); // obtenemos la longitud del array de sesion
		  
		  
	//obtenemos de la clase de configuracion que tipo de configuracion tiene tanto iva como el tipo de descuento que maneja.
	
	
			$row_configuracion = $this->confi->ObtenerInformacionConfiguracion();			
			$iva = $row_configuracion['iva']/100;
			$t_descuento = $row_configuracion['t_descuento'];	  // 0-producto  1 - por paquete 2 - ambos.
		  
//Obtenemos el descuento que tiene el cliente
			
			if($cliente != 0)
			{
				$this->clientes->idCliente = $cliente;
				$row_cliente = $this->clientes->ObtenerInformacionCliente(); //obtenemos toda la informacion del cliente.
				$c_descuento = $row_cliente['porc_desc']; //obtenemos el descuento que tiene configurado el cliente en el sistema.
				
				$idniveles = $row_cliente['idniveles'];
			}else
			{
				$idniveles = 0;
			    $c_descuento = 0;	
			}
		  
		  // validamos que la session de array exista y que contenga un producto
		  
		  if ( isset($itemsEnCesta) && $cantidad > 0 ) 
		      {
		  ?>
          
<div style="height:500px; background-color: #D8D6D6; overflow:auto" >
                    <table width="100%" cellspacing="2" cellpadding="2">
                  <tr>
                    <td width="3%" align="center"  bgcolor="#CCCCCC" >&nbsp;</td>
                      <td width="11%" align="center"  bgcolor="#CCCCCC" >Cod. Producto</td>
					  <td width="11%" align="center"  bgcolor="#CCCCCC" >Talla</td>
                      <td width="12%" align="center"  bgcolor="#CCCCCC" >Cat. Producto</td>
                      <td width="33%" align="center" bgcolor="#CCCCCC" >Nombre Producto</td>
                      <td width="5%" align="center" bgcolor="#CCCCCC" >Cant.</td>
                      <td width="6%" align="center" bgcolor="#CCCCCC" >P.V</td>
                      <td width="11%" align="center" bgcolor="#CCCCCC" > Desc %</td>
                      
                      <td width="9%" align="center" bgcolor="#CCCCCC" >Total Desc</td>
                      <td width="10%" align="center" bgcolor="#CCCCCC" >Total</td>
                  </tr>
                  <?php 
				  
				  $descuento_total  = 0;
				  $monto_total = 0;
				  $sumaproductos =0;
				  
				   foreach(array_reverse($itemsEnCesta,true) as $k => $v)
		           {
					   //echo $k." ".$v;
					   $array_k = explode("|",$k);
					   $this->produ->id_producto = strtoupper(trim($array_k[0]));  //enviamos el valor del id producto a la clase de productos
					   $row_productos = $this->produ->ObtenerDatosProducto();  //obtenemos el array con los valores del prodcuto.
					   $array_v = explode('|',$v);
					   $idtallas = $array_k[1];
					   
					   $nombre_categoria = $array_v[2];
					   $idcategoria_precio = $array_v[1];
					   $cantidad_produ =$array_v[0];  //obtemos la cantidad de producto en el carrito
					   $sumaproductos = $sumaproductos + $cantidad_produ; //obtenemos la suma de todos los productos que se estan comprando.
					   
					   $costo = $row_productos['pv']; //obtenemos el precio venta ya con IVA.
					   
					   //$descuento = $row_productos['descuento']/100; //obtenemos el porcentaje del descuento en la base de datos del producto.
					   				
					   $SubPorProducto = round($cantidad_produ * $costo,2);  //obtenemos el subtotal del producto cantidad precio.
					   
					   //obtenemos el descuento que trae por nivel
					   $sql = "SELECT * FROM categoria_precios_niveles WHERE idniveles = '$idniveles' AND idcategoria_precio = '$idcategoria_precio'";
					   
					   $result_sql = $this->db->consulta($sql);
					   $result_sql_num = $this->db->num_rows($result_sql);
					   $result_sql_row = $this->db->fetch_assoc($result_sql);
					   
					   if($result_sql_num == 0){
						   $desc_nivel = 0;
					   }else{
						   $desc_nivel = $result_sql_row['descuento'];
					   }
					   
					   //Obtenemos descuento total sumando el descuento del cliente por nivel y el del producto
					   $desc_t = $row_productos['descuento']+$desc_nivel;
					   
					   $descuento = $desc_t/100; //obtenemos el porcentaje del descuento en la base de datos del producto.
					   $DescPorProducto = round($SubPorProducto * $descuento,2); //obtenemos el total del descuento de ese producto.
					   
					   //validamos que si es por producto o ambos se ejecute el descuento.
					   
					   /*if($t_descuento == 0 || $t_descuento == 2)
					   {
					       $DescPorProducto = round($SubPorProducto * $descuento,2); //obtenemos el total del descuento de ese producto.
					   }else
					   {
						   $DescPorProducto = 0;
					   }*/
 					   
					   $SubtotalBrutoPorProducto = round($SubPorProducto - $DescPorProducto,2);  //OBTENEMOS EL TOTAL DEL PRRODUCTO MENOS EL DESCUENTO.
					   
					    //suma de subtotales descuentos
						//$total_pagar_sinDescuento = $total_pagar_sinDescuento+$SubtotalBrutoPorProducto;
						$total_pagar_sinDescuento = $total_pagar_sinDescuento+$SubPorProducto;
						$total_pagar = $total_pagar + $SubtotalBrutoPorProducto;
						$SumadeDescuentos = $SumadeDescuentos + $DescPorProducto;
					   
					   $sql_talla = "SELECT * FROM tallas WHERE idtallas = '$idtallas'";
					   $result_talla = $this->db->consulta($sql_talla);
					   $result_talla_row = $this->db->fetch_assoc($result_talla);
															   
					   
				  ?>
                      <tr>
                        <td align="center" valign="top" bgcolor="#FFFFCC" style="color:#000">							
							<button type="button" onclick="delProductoApartado('<?php echo $k; ?>','<?php echo $cliente; ?>')" title="BORRAR" class="btn btn-danger"><i class="mdi mdi-delete-empty"></i></button>
							
                        </td>
                          <td align="center" valign="top" bgcolor="#FFFFCC" style="color:#000"><?php echo utf8_encode($row_productos['idproducto']);?>
                          </td>
						  <td align="center" valign="top" bgcolor="#FFFFCC" style="color:#000"><?php echo utf8_encode($result_talla_row['talla']);?>
                          </td>
                          <td align="center" valign="top" bgcolor="#FFFFCC" style="color:#000"><?php echo utf8_encode($nombre_categoria);?>
                          </td>
                        <td valign="top" bgcolor="#FFFFCC"  style="padding-left:5px; color:#000;"><?php echo htmlentities(strtoupper($row_productos['nombre']), ENT_QUOTES | ENT_IGNORE, "ISO-8859-1");?></td>
                          <td align="center" valign="top" bgcolor="#FFFFCC"  style="padding-left:5px; color:#000;"><?php echo $cantidad_produ; ?>
           <td align="center" valign="top" bgcolor="#FFFFCC"  style="padding-left:5px; color:#000;">
		          <?php echo '$ '.$costo ?>
           </td>
           <td align="center" valign="top" bgcolor="#FFFFCC" style="padding-left:5px; padding-right:5px; color:#000"  ><span style="padding-left:5px; color:#000;"><?php echo $desc_t.'%';?></span></td>
                          <td align="center" valign="top" bgcolor="#FFFFCC" style="padding-left:5px; padding-right:5px; color:#000"  >
                                <span style="padding-left:5px; color:#000;"><?php echo '$ '.$DescPorProducto;?></span>
                          </td>
                          <td valign="top" style="padding-left:5px; padding-right:5px; color:#fff;  background-color: #666364;" align="center" >
                          
						     <?php echo "$ ".number_format($SubtotalBrutoPorProducto,2,'.',','); ?>
                             </td>
                      </tr>
				   <?php 
				   
                   }// fin de foreach
				   
				   
				   //Descuento por Paquete.
				   
				  /* if($t_descuento == 1 || $t_descuento == 2 )
				      {
					  
						  $row = $this->paquetes->obtenerQuePaqueteporRango($total_pagar);
						  						  
						  if($row['cuantos'] != 0)
						  {
							$porc_descuento_paquete = $row['descuento'] / 100;
						    $SumadeDescuentosPaquete = $total_pagar * $porc_descuento_paquete;
						  }else
						  {
							$SumadeDescuentosPaquete = 0;
						  }
						  
						  
					  }else
					  {
						  $SumadeDescuentosPaquete = 0;
					  }*/
					  
					  
				    //restar el descuento por paquete si es que existe alguno
					
					$total_pagar = $total_pagar - $SumadeDescuentosPaquete;  
					
					
					//obtenemos el descuento del cliente y obtenemos la cantidad de descuento a realizarle.
					
					
					
					
					
					
					
				   
				   //SUMA DE DESCUENTOS PARA OBTENER LOS TOTALES A PAGAR		   
				   
				   
				   
				   $subtotal = 	round($total_pagar/(1+$iva),2);
				   $iva = $total_pagar - $subtotal;	 
				   
				   
				   //TERMINA LAS VARIABLES CON TOTALES DE LA COMPRA CON SU DESCUENTO.
				 
                   ?>
                  <tr>
                      <td colspan="8" align="right" style="color:#000">SubTotal:</td>
                      <td colspan="2" style=" padding-left:5px; padding-right:5px; color:#000" bgcolor="#F2F2F2">$ <?php echo number_format($subtotal,2,'.',','); ?>
                      <input type="hidden" name="v_subtotal" id="v_subtotal" value="<?php echo $subtotal;?>" /></td>
                  </tr>
                  
                  <?php //if($t_descuento == 0 || $t_descuento == 2) {?>
                  
                  <tr>
                    <td colspan="8" align="right"  style="color:#000">Descuento:</td>
                    <td colspan="2" bgcolor="#FF0000" style=" padding-left:5px; padding-right:5px; color:#000" >- $ <?php echo number_format($SumadeDescuentos,2,'.',','); ?>
                      <input type="hidden" name="v_desc_producto" id="v_desc_producto" value="<?php echo $SumadeDescuentos;?>" />
                      
                      <input type="hidden" name="v_niveles" id="v_niveles" value="<?php echo $idniveles;?>" />
                    </td>
                  </tr>
                  
                  
                  <?php
				  //}
                  
                   if($t_descuento == 1 || $t_descuento == 2) {?>
                  
                  <!--<tr>
                    <td colspan="7" align="right"  style="color:#000">Desc. por Paquete:</td>
                    <td colspan="2" bgcolor="#FF0000" style=" padding-left:5px; padding-right:5px; color:#000" >- $ <?php echo number_format($SumadeDescuentosPaquete,2,'.',','); ?>
                      <input type="hidden" name="v_desc_paquete" id="v_desc_paquete" value="<?php echo $SumadeDescuentosPaquete;?>" /></td>
                  </tr>-->
                  <?php
				   }
				  
				  //SI EL CLIENTE ES PUBLICO EN GENERAL.
				  
				  if($row_cliente != 0){ 
				  		
						//$porc_descuento_cliente = $c_descuento / 100;
				  		//$desc_cliente = round($total_pagar * $porc_descuento_cliente,2); //cantidad de descuento a realizar.
						//$total_pagar = $total_pagar - $desc_cliente;
						//$descuento_cliente = number_format($desc_cliente,2,'.',',');
						
						
						 //iniciamos las variables de sesion para poder
		  
						   $s_v1 = $_SESSION['vs_totalproductos']=$sumaproductos; 
						   $s_v2 = $_SESSION['vs_montodescuento'] = number_format(round($total_pagar_sinDescuento,2),2,'.',',');
						   $s_v3 = $_SESSION['vs_descuento']= number_format(round($SumadeDescuentos,2),2,'.',',');
						   $s_v4 = $_SESSION['vs_totalcondescuento']=number_format(round($total_pagar,2),2,'.',',');
		  
						
						
						
				  ?>
                  <!--<tr>
                    <td colspan="7" align="right"  style="color:#000">Desc. por Cliente:</td>
                    <td colspan="2" bgcolor="#FF0000" style=" padding-left:5px; padding-right:5px; color:#000" >- $ <?php echo $descuento_cliente; ?>
                      <input type="hidden" name="v_desc_cliente" id="v_desc_cliente" value="<?php echo $desc_cliente;?>" /></td>
                  </tr>-->
                  <?php
				  }else
				  {
					       $s_v1 = $_SESSION['vs_totalproductos']=$sumaproductos; 
						   $s_v2 = $_SESSION['vs_montodescuento'] = number_format(round($total_pagar_sinDescuento,2),2,'.',',');
						   $s_v3 = $_SESSION['vs_descuento']= number_format(round($DescPorProducto,2),2,'.',',');
						   $s_v4 = $_SESSION['vs_totalcondescuento']=number_format(round($total_pagar,2),2,'.',',');
				  }
				  
				  ?>
                  
                  <tr>
                      <td colspan="8" align="right"  style="color:#000">IVA:</td>
                      <td colspan="2" style=" padding-left:5px; padding-right:5px; color:#000" >$ <?php echo number_format($iva,2,'.',','); ?>
                      <input type="hidden" name="v_iva" id="v_iva" value="<?php echo $iva;?>" /></td>
                  </tr>
                  <tr style="font-size:18px; ">
                      <td colspan="8" align="right"  style="color:#000;">TOTAL A PAGAR:</td>
                      <td colspan="2" style="padding-left:5px; padding-right:5px; color:#000;" bgcolor="#CCCCCC">$<span style="padding-left:5px; padding-right:5px; color:#000"><span style="padding-left:5px; color:#000;"><?php echo number_format(round($total_pagar,2),2);?><span style=" padding-left:5px; padding-right:5px; color:#000">
                        <input type="hidden" name="v_total_pagar" id="v_total_pagar" value="<?php echo $total_pagar;?>"/>
                      </span></span></span></td>
                  </tr>
                  <!--<tr>
                      <td  colspan="9" style=" padding-left:5px; padding-right:5px; color:#000" align="right" bgcolor="#F2F2F2">
                          <input type="submit" name="button" id="button" value="Levantar Orden" onclick="levantarOrden('contenido',<?php echo $subtotal;?>,<?php echo $iva;?>,<?php echo $total;?>,<?php echo $descuento_total;?>)" class="cajasmodificar">
                      </td>
                  </tr>-->
              </table>
              
           </div> 
           
            <div id="d_sumatorias_pedido">
 <table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tbody>
    <tr style="height: 30px; font-style: normal; font-weight: bold; font-size: 16px;"; bgcolor="#959595">
      <td width="18%" align="right" bgcolor="#F0EDED">Total de Productos:</td>
      <td width="9%" align="center" style="background-color: #DADADA; padding: 0px 5px 0px 5px; font-size: 24px;" id="v_totalproducto"><?php echo  $s_v1;?></td>
      <td width="22%" align="right" bgcolor="#F0EDED">Monto sin descuento:</td>
      <td width="11%" align="center" style="background-color: #DADADA; padding: 0px 5px 0px 5px; font-size: 24px;" id="v_montodescuento"><?php echo $s_v2;?></td>
      <td width="12%" align="right" bgcolor="#F0EDED">Descuento:</td>
      <td width="11%" align="center" style="background-color: #DADADA; padding: 0px 5px 0px 5px; font-size: 24px;" id="v_descuento"><?php echo $s_v3; ?></td>
      <td width="9%" align="right" bgcolor="#F0EDED">Total:</td>
      <td width="8%" align="center" style="background-color: #DADADA; padding: 0px 5px 0px 5px; font-size: 24px;" id="v_totaldescuento"><?php echo $s_v4;?></td>
    </tr>
  </tbody>
</table>
    </div>
    
    </div>
              
		  <?php 
		  
		
		  
		  }// fin de sesion
		  else
		  {
		  ?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                      <td align="center">
                        <img src="images/shoppingcart_empty.png"/><br />
                          Tu carrito de compras esta vac&iacute;o<br />
                      </td>
                  </tr>
</table>
      <?php 
		  }// fin de else
		  
		}catch(Exception $e)
        {
		  $v = explode ('|',$e);
		  $n = explode ("'",$v[1]);
		  echo '<div class="alert_error" id="mens">'.$this->db->m_error($n[0]).'</div>'; 	   
        }
		  
	  }// fin de metodo verCarrito
	  	 
		 
		public function delProductoApartado($item)
	 {
		 //$_SESSION['count']--;
		  if (isset($_SESSION['Apartado']))
		  {
				foreach($_SESSION['Apartado'] as $k => $v)
				{ 
				  if (isset($item))
				   {
					    unset ($_SESSION['Apartado'][$item]);
				   }
				   
				}
		  } 
		  
	 }// fin de método delProducto 
		 
		 
   /*=============== SHOPING CAR DE COTIZACION =======================*/
    public function addCotizacion($item,$cantidad,$sucursal,$idcategoria_precio,$nombre_categoria)
	{
		
	
		
		//si el producto no existe no hacemos nada...
		
			$this->produ->id_producto = $item;
			$this->produ->idsucursales = $sucursal;
			$existe = $this->produ->verificaProductoExistenteInventario();
		   
		if($existe == 1)
		  {
	
	            //este if nos sirve para verificar que ya existe la sesion de apunta de venta.
	            if(!isset($_SESSION['Cotizacion']))
				   {  
					  
					  $this->sesion->crearSesion('Cotizacion',null);
					  $_SESSION['Cotizacion'][$item] = $cantidad."|".$idcategoria_precio."|".$nombre_categoria;
				
				   }
				   else  //si nexiste hace un ciclo para buscar el producto y sumarle la nueva cantidad.
				   {  
					  foreach($_SESSION['Cotizacion'] as $k => $v)
					  {  
						 if ($item==$k)
						 {  
						 
						     //sumamos lo que existe en sesion mas el de ahora 
							 
							  $nuevacantidad = $_SESSION['Cotizacion'][$k] + $cantidad;						     
							  $sepuede = $this->produ->alcanzaProducto($nuevacantidad);
						 
						 
						     if($sepuede == 1)
							 {
							 	$_SESSION['Cotizacion'][$k]=$_SESSION['Cotizacion'][$k]+$cantidad."|".$idcategoria_precio."|".$nombre_categoria; 
								?>
								
							 <h4 class="alert_success" style="margin-top: -5px;">EL PRODUCTO SE AGREGO CORRECTAMENTE<?php echo $this->produ->id_producto; ?></h4>
								<?php 
							 }else
							 {
							  ?>
						     <h4 class="alert_warning" style="margin-top: -5px;">NO HAY TANTO PRODUCTO EN EXISTENCIA<?php echo $this->produ->id_producto; ?></h4>						  <?php
							 } 
							  $encontrado = 1 ;
						 }  
					  }  
					  
					  if (!$encontrado)
					       { 
					           $_SESSION['Cotizacion'][$item]=$cantidad."|".$idcategoria_precio."|".$nombre_categoria; 
							}    
					}  
					
						?>
               
                
                
        
		<?php
				
		    }//fin de la comparacion de que si existye el producto en stock.
			else
			{
				?>
                 
            		
                          <h4 class="alert_error" style="margin-top: -5px;">NO EXISTE PRODUCTO O NO HAY PRODUCTO EN STOCK</h4> 
            		
    
        		
        
		<?php
			}
		
		  
	 }// fin de método addProducto
	 
	 
	 
	 
	 public function verCarritoCotizacion($cliente)
	  {
		 
		try
		{  
		  $contador = 1;		  
		  $itemsEnCesta = $_SESSION['Cotizacion'];
		  $cantidad = count($itemsEnCesta); // obtenemos la longitud del array de sesion
		  
		  
	//obtenemos de la clase de configuracion que tipo de configuracion tiene tanto iva como el tipo de descuento que maneja.
	
	
			$row_configuracion = $this->confi->ObtenerInformacionConfiguracion();			
			$iva = $row_configuracion['iva']/100;
			$t_descuento = $row_configuracion['t_descuento'];	  // 0-producto  1 - por paquete 2 - ambos.
		  
//Obtenemos el descuento que tiene el cliente
			
			if($cliente != 0)
			{
				$this->clientes->idCliente = $cliente;
				$row_cliente = $this->clientes->ObtenerInformacionCliente(); //obtenemos toda la informacion del cliente.
				$c_descuento = $row_cliente['porc_desc']; //obtenemos el descuento que tiene configurado el cliente en el sistema.
				
				$idniveles = $row_cliente['idniveles'];
			}else
			{
				$idniveles = 0;
			    $c_descuento = 0;	
			}
		  
		  // validamos que la session de array exista y que contenga un producto
		  
		  if ( isset($itemsEnCesta) && $cantidad > 0 ) 
		      {
		  ?>
          
<div style="height:500px; background-color: #D8D6D6; overflow:auto" >
                    <table width="100%" cellspacing="2" cellpadding="2">
                  <tr>
                    <td width="3%" align="center"  bgcolor="#CCCCCC" >&nbsp;</td>
                      <td width="11%" align="center"  bgcolor="#CCCCCC" >Cod. Producto</td>
                      <td width="12%" align="center"  bgcolor="#CCCCCC" >Cat. Producto</td>
                      <td width="30%" align="center" bgcolor="#CCCCCC" >Nombre Producto</td>
                      <td width="9%" align="center" bgcolor="#CCCCCC" >Cant.</td>
                      <td width="7%" align="center" bgcolor="#CCCCCC" >P.V</td>
                      <td width="9%" align="center" bgcolor="#CCCCCC" > Desc %</td>
                      
                      <td width="9%" align="center" bgcolor="#CCCCCC" >Total Desc</td>
                      <td width="10%" align="center" bgcolor="#CCCCCC" >Total</td>
                  </tr>
                  <?php 
				  
				  $descuento_total  = 0;
				  $monto_total = 0;
				  $sumaproductos =0;
				  
				   foreach(array_reverse($itemsEnCesta,true) as $k => $v)
		           {
					   //echo $k." ".$v;
					   
					   $this->produ->id_producto = strtoupper(trim($k));  //enviamos el valor del id producto a la clase de productos
					   $row_productos = $this->produ->ObtenerDatosProducto();  //obtenemos el array con los valores del prodcuto.
					   $array_v = explode('|',$v);
					   
					   $nombre_categoria = $array_v[2];
					   $idcategoria_precio = $array_v[1];
					   $cantidad_produ =$array_v[0];  //obtemos la cantidad de producto en el carrito
					   $sumaproductos = $sumaproductos + $cantidad_produ; //obtenemos la suma de todos los productos que se estan comprando.
					   
					   $costo = $row_productos['pv']; //obtenemos el precio venta ya con IVA.
					   
					   //$descuento = $row_productos['descuento']/100; //obtenemos el porcentaje del descuento en la base de datos del producto.
					   				
					   $SubPorProducto = round($cantidad_produ * $costo,2);  //obtenemos el subtotal del producto cantidad precio.
					   
					   //obtenemos el descuento que trae por nivel
					   $sql = "SELECT * FROM categoria_precios_niveles WHERE idniveles = '$idniveles' AND idcategoria_precio = '$idcategoria_precio'";
					   
					   $result_sql = $this->db->consulta($sql);
					   $result_sql_num = $this->db->num_rows($result_sql);
					   $result_sql_row = $this->db->fetch_assoc($result_sql);
					   
					   if($result_sql_num == 0){
						   $desc_nivel = 0;
					   }else{
						   $desc_nivel = $result_sql_row['descuento'];
					   }
					   
					   //Obtenemos descuento total sumando el descuento del cliente por nivel y el del producto
					   $desc_t = $row_productos['descuento']+$desc_nivel;
					   
					   $descuento = $desc_t/100; //obtenemos el porcentaje del descuento en la base de datos del producto.
					   $DescPorProducto = round($SubPorProducto * $descuento,2); //obtenemos el total del descuento de ese producto.
					   
					   //validamos que si es por producto o ambos se ejecute el descuento.
					   
					   /*if($t_descuento == 0 || $t_descuento == 2)
					   {
					       $DescPorProducto = round($SubPorProducto * $descuento,2); //obtenemos el total del descuento de ese producto.
					   }else
					   {
						   $DescPorProducto = 0;
					   }*/
 					   
					   $SubtotalBrutoPorProducto = round($SubPorProducto - $DescPorProducto,2);  //OBTENEMOS EL TOTAL DEL PRRODUCTO MENOS EL DESCUENTO.
					   
					    //suma de subtotales descuentos
						//$total_pagar_sinDescuento = $total_pagar_sinDescuento+$SubtotalBrutoPorProducto;
						$total_pagar_sinDescuento = $total_pagar_sinDescuento+$SubPorProducto;
						$total_pagar = $total_pagar + $SubtotalBrutoPorProducto;
						$SumadeDescuentos = $SumadeDescuentos + $DescPorProducto;
															   
					   
				  ?>
                      <tr>
                        <td align="center" valign="top" bgcolor="#FFFFCC" style="color:#000">
                            <span style="padding-left:5px; padding-right:5px; color:#000">
               			    <a href="#" onclick="delProductoCotizacion('<?php echo $k; ?>','<?php echo $cliente; ?>')" >
                          				<img  src="images/004.png" alt=""  width="15px" height="15px" title=":: Eliminar Carrito ::" />
                                 </a>
                            </span>
                        </td>
                          <td align="center" valign="top" bgcolor="#FFFFCC" style="color:#000"><?php echo utf8_encode($row_productos['idproducto']);?>
                          </td>
                          <td align="center" valign="top" bgcolor="#FFFFCC" style="color:#000"><?php echo utf8_encode($nombre_categoria);?>
                          </td>
                        <td valign="top" bgcolor="#FFFFCC"  style="padding-left:5px; color:#000;"><?php echo htmlentities(strtoupper($row_productos['nombre']), ENT_QUOTES | ENT_IGNORE, "ISO-8859-1");?></td>
                          <td align="center" valign="top" bgcolor="#FFFFCC"  style="padding-left:5px; color:#000;">
						  		<!--<?php echo $cantidad_produ; ?>-->
                                <select id='canti<?php echo $k; ?>' style='font-size:10px;'>
                                	<?php
										for($i=1;$i<=15;$i++){
									?>
                                	<option value='<?php echo $i; ?>' <?php if($i == $cantidad_produ){echo "selected";} ?>><?php echo $i; ?></option>
                                    <?php
										}
									?>
                                </select>
                                
                                
                                <a href="#" onclick="actualizarShoppingCotizacion('<?php echo $k; ?>');" >
                          				<img  src="images/refresh.png" alt=""  width="13px" height="13px" title=":: Actualizar Carrito ::" />
                                 </a>
                                
								
                          </td>
           <td align="center" valign="top" bgcolor="#FFFFCC"  style="padding-left:5px; color:#000;">
		          <?php echo '$ '.$costo ?>
           </td>
           <td align="center" valign="top" bgcolor="#FFFFCC" style="padding-left:5px; padding-right:5px; color:#000"  ><span style="padding-left:5px; color:#000;"><?php echo $desc_t.'%';?></span></td>
                          <td align="center" valign="top" bgcolor="#FFFFCC" style="padding-left:5px; padding-right:5px; color:#000"  >
                                <span style="padding-left:5px; color:#000;"><?php echo '$ '.$DescPorProducto;?></span>
                          </td>
                          <td valign="top" style="padding-left:5px; padding-right:5px; color:#fff;  background-color: #666364;" align="center" >
                          
						     <?php echo "$ ".number_format($SubtotalBrutoPorProducto,2,'.',','); ?>
                             </td>
                      </tr>
				   <?php 
				   
                   }// fin de foreach
				   
				   
				   
				   //SUMA DE DESCUENTOS PARA OBTENER LOS TOTALES A PAGAR		   
				   $subtotal = 	round($total_pagar/(1+$iva),2);
				   $iva = $total_pagar - $subtotal;	 
				   
				   
				   //TERMINA LAS VARIABLES CON TOTALES DE LA COMPRA CON SU DESCUENTO.
				 
                   ?>
                  <tr>
                      <td colspan="7" align="right" style="color:#000">SubTotal:</td>
                      <td colspan="2" style=" padding-left:5px; padding-right:5px; color:#000" bgcolor="#F2F2F2">$ <?php echo number_format($subtotal,2,'.',','); ?>
                      <input type="hidden" name="v_subtotal" id="v_subtotal" value="<?php echo $subtotal;?>" /></td>
                  </tr>
                  
                  <?php //if($t_descuento == 0 || $t_descuento == 2) {?>
                  
                  <tr>
                    <td colspan="7" align="right"  style="color:#000">Descuento:</td>
                    <td colspan="2" bgcolor="#FF0000" style=" padding-left:5px; padding-right:5px; color:#000" >- $ <?php echo number_format($SumadeDescuentos,2,'.',','); ?>
                      <input type="hidden" name="v_desc_producto" id="v_desc_producto" value="<?php echo $SumadeDescuentos;?>" />
                      
                      <input type="hidden" name="v_niveles" id="v_niveles" value="<?php echo $idniveles;?>" />
                    </td>
                  </tr>
                  
                
                  <?php
				  
				  //SI EL CLIENTE ES PUBLICO EN GENERAL.
				  
				  if($row_cliente != 0){ 
				  		
						 //iniciamos las variables de sesion para poder
		  
						   $s_v1 = $_SESSION['vs_totalproductos']=$sumaproductos; 
						   $s_v2 = $_SESSION['vs_montodescuento'] = number_format(round($total_pagar_sinDescuento,2),2,'.',',');
						   $s_v3 = $_SESSION['vs_descuento']= number_format(round($SumadeDescuentos,2),2,'.',',');
						   $s_v4 = $_SESSION['vs_totalcondescuento']=number_format(round($total_pagar,2),2,'.',',');
		  
				  }else{
					       $s_v1 = $_SESSION['vs_totalproductos']=$sumaproductos; 
						   $s_v2 = $_SESSION['vs_montodescuento'] = number_format(round($total_pagar_sinDescuento,2),2,'.',',');
						   $s_v3 = $_SESSION['vs_descuento']= number_format(round($DescPorProducto,2),2,'.',',');
						   $s_v4 = $_SESSION['vs_totalcondescuento']=number_format(round($total_pagar,2),2,'.',',');
				  }
				  
				  ?>
                  
                  <tr>
                      <td colspan="7" align="right"  style="color:#000">IVA:</td>
                      <td colspan="2" style=" padding-left:5px; padding-right:5px; color:#000" >$ <?php echo number_format($iva,2,'.',','); ?>
                      <input type="hidden" name="v_iva" id="v_iva" value="<?php echo $iva;?>" /></td>
                  </tr>
                  <tr style="font-size:18px; ">
                      <td colspan="7" align="right"  style="color:#000;">TOTAL A PAGAR:</td>
                      <td colspan="2" style="padding-left:5px; padding-right:5px; color:#000;" bgcolor="#CCCCCC">$<span style="padding-left:5px; padding-right:5px; color:#000"><span style="padding-left:5px; color:#000;"><?php echo number_format(round($total_pagar,2),2);?><span style=" padding-left:5px; padding-right:5px; color:#000">
                        <input type="hidden" name="v_total_pagar" id="v_total_pagar" value="<?php echo $total_pagar;?>"/>
                      </span></span></span></td>
                  </tr>
                  <!--<tr>
                      <td  colspan="9" style=" padding-left:5px; padding-right:5px; color:#000" align="right" bgcolor="#F2F2F2">
                          <input type="submit" name="button" id="button" value="Levantar Orden" onclick="levantarOrden('contenido',<?php echo $subtotal;?>,<?php echo $iva;?>,<?php echo $total;?>,<?php echo $descuento_total;?>)" class="cajasmodificar">
                      </td>
                  </tr>-->
              </table>
              
           </div> 
           
            <div id="d_sumatorias_pedido">
 <table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tbody>
    <tr style="height: 30px; font-style: normal; font-weight: bold; font-size: 16px;"; bgcolor="#959595">
      <td width="18%" align="right" bgcolor="#F0EDED">Total de Productos:</td>
      <td width="9%" align="center" style="background-color: #DADADA; padding: 0px 5px 0px 5px; font-size: 24px;" id="v_totalproducto"><?php echo  $s_v1;?></td>
      <td width="22%" align="right" bgcolor="#F0EDED">Monto sin descuento:</td>
      <td width="11%" align="center" style="background-color: #DADADA; padding: 0px 5px 0px 5px; font-size: 24px;" id="v_montodescuento"><?php echo $s_v2;?></td>
      <td width="12%" align="right" bgcolor="#F0EDED">Descuento:</td>
      <td width="11%" align="center" style="background-color: #DADADA; padding: 0px 5px 0px 5px; font-size: 24px;" id="v_descuento"><?php echo $s_v3; ?></td>
      <td width="9%" align="right" bgcolor="#F0EDED">Total:</td>
      <td width="8%" align="center" style="background-color: #DADADA; padding: 0px 5px 0px 5px; font-size: 24px;" id="v_totaldescuento"><?php echo $s_v4;?></td>
    </tr>
  </tbody>
</table>
    </div>
    
    </div>
              
		  <?php 
		  
		
		  
		  }// fin de sesion
		  else
		  {
		  ?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                      <td align="center">
                        <img src="images/shoppingcart_empty.png"/><br />
                          Tu carrito de compras esta vac&iacute;o<br />
                      </td>
                  </tr>
</table>
      <?php 
		  }// fin de else
		  
		}catch(Exception $e)
        {
		  $v = explode ('|',$e);
		  $n = explode ("'",$v[1]);
		  echo '<div class="alert_error" id="mens">'.$this->db->m_error($n[0]).'</div>'; 	   
        }
		  
	  }// fin de metodo verCarrito
	  
	  
	  
	     public function delProductoCotizacion($item)
	 {
		 //$_SESSION['count']--;
		  if (isset($_SESSION['Cotizacion']))
		  {
				foreach($_SESSION['Cotizacion'] as $k => $v)
				{ 
				  if (isset($item))
				   {
					    unset ($_SESSION['Cotizacion'][$item]);
				   }
				   
				}
		  } 
		  
	 }// fin de método delProducto
	 
	 
	 
	 
	 public function actProductoCotizacion($item,$cantidad,$sucursal,$idcategoria_precio,$nombre_categoria)
	{
		$this->produ->id_producto = $item;
		$this->produ->idsucursales = $sucursal;
			
		foreach($_SESSION['Cotizacion'] as $k => $v)
		{  
			 if ($item==$k)
			 {  
						 
				 //sumamos lo que existe en sesion mas el de ahora 
				  $nuevacantidad = $cantidad;
				  $sepuede = $this->produ->alcanzaProducto($nuevacantidad);
						 
						     if($sepuede == 1)
							 {
							 	$_SESSION['Cotizacion'][$k]=$cantidad."|".$idcategoria_precio."|".$nombre_categoria; 
								?>
								
							 <h4 class="alert_success" style="margin-top: -5px;">EL PRODUCTO SE AGREGO CORRECTAMENTE<?php echo $this->produ->id_producto; ?></h4>
								<?php 
							 }else
							 {
							  ?>
						     <h4 class="alert_warning" style="margin-top: -5px;">NO HAY TANTO PRODUCTO EN EXISTENCIA<?php echo $this->produ->id_producto; ?></h4>						  <?php
							 } 
							  $encontrado = 1 ;
						 }  
					  }  
					  
					 /* if (!$encontrado)
					       { 
					           $_SESSION['Cotizacion'][$item]=$cantidad."|".$idcategoria_precio."|".$nombre_categoria; 
							}  */
							
							
							  		
	 }// fin de método addProducto
	 
	 
	 //Funcion que sirve para levantar el shopping de nuevo de la tabla de cotizacion
	 //$item,$cantidad,$sucursal,$idcategoria_precio,$nombre_categoria
	public function levantarShoppingCotizacion($idcotizacion,$sucursal)
	{
		//Obtengo los productos de detalle cotizacion
		$sql = "SELECT * FROM detalle_cotizacion WHERE idcotizacion = '$idcotizacion'";
		$result_productos = $this->db->consulta($sql);
		$result_productos_row = $this->db->fetch_assoc($result_productos);
		
		//Si llegara a existir una session de cotizacion la borramos para cargar toda la cotizacion
		$this->sesion->eliminarSesion('Cotizacion');
			
		do
		{
			$item = $result_productos_row['idproducto'];
			$cantidad = $result_productos_row['cantidad'];
			
			//Obtenemos la categoria de precio del producto
			$sql_prod = "SELECT p.*, cp.nombre as name FROM productos p, categoria_precio cp WHERE p.idproducto = '$item' AND p.idcategoria_precio = cp.idcategoria_precio";
			$result_prod = $this->db->consulta($sql_prod);
			$result_prod_row = $this->db->fetch_assoc($result_prod);
			
			$nombre_categoria = $result_prod_row['name'];
			$idcategoria_precio = $result_prod_row['idcategoria_precio'];
			
			
			//si el producto no existe no hacemos nada...
			$this->produ->id_producto = $item;
			$this->produ->idsucursales = $sucursal;
			$existe = $this->produ->verificaProductoExistenteInventario();
			
			if($existe == 1)
			{
				
				//este if nos sirve para verificar que ya existe la sesion de cotizacion.
				if(!isset($_SESSION['Cotizacion']))
				{  
					$this->sesion->crearSesion('Cotizacion',null);
			  
			  		//Hacemos ciclo para cargar todo el shopping
			  		$_SESSION['Cotizacion'][$item] = $cantidad."|".$idcategoria_precio."|".$nombre_categoria;
				}else{  
				
					foreach($_SESSION['Cotizacion'] as $k => $v)
					{  
						if ($item==$k)
						{  
							//sumamos lo que existe en sesion mas el de ahora 
							 
					  	$nuevacantidad = $_SESSION['Cotizacion'][$k] + $cantidad;						     
					  	$sepuede = $this->produ->alcanzaProducto($nuevacantidad);
						 
						if($sepuede == 1)
						{
							$_SESSION['Cotizacion'][$k]=$_SESSION['Cotizacion'][$k]+$cantidad."|".$idcategoria_precio."|".$nombre_categoria; 
						?>
							<h4 class="alert_success" style="margin-top: -5px;">EL PRODUCTO SE AGREGO CORRECTAMENTE<?php echo $this->produ->id_producto; ?></h4>
						
						<?php 
						}else{
						?>
                        
							<h4 class="alert_warning" style="margin-top: -5px;">NO HAY TANTO PRODUCTO EN EXISTENCIA<?php echo $this->produ->id_producto; ?></h4>						  
						<?php
						} 
							  $encontrado = 1 ;
					}  
				}  
					  
			  	if(!$encontrado)
				{ 
					$_SESSION['Cotizacion'][$item]=$cantidad."|".$idcategoria_precio."|".$nombre_categoria; 
				}    
			}
				
				
			
			}else{
			?>
         		<h4 class="alert_error" style="margin-top: -5px;">NO EXISTE PRODUCTO O NO HAY PRODUCTO EN STOCK</h4> 
			<?php
			}
			
		}while($result_productos_row = $this->db->fetch_assoc($result_productos));
		
		
		   
		
	    	  
					
               
   				
			 
	 }
	 
	 
	 /*=================== TERMINA SHOPING CART DE COTIZACION =======================*/
	
	
	
	/* ========================================== INICIA METODOS DE LISTA DE SESION CLIENTES MENSAJES ======================================================== */
	
	public function guardar_cliente_sesion($idcliente,$nombre)
	{
		//este if nos sirve para verificar que ya existe la sesion
		if(!isset($_SESSION['lista_clientes']))
   		{   
	  		$this->sesion->crearSesion('lista_clientes',null);
	  		$_SESSION['lista_clientes'][$idcliente] = $nombre;
?>
			<h4 class="alert alert-success" style="margin-top: -5px;">EL CLIENTE #<?php echo $idcliente; ?> SE AGREGO CORRECTAMENTE A LA LISTA</h4>
<?php
		}else{  
  			foreach($_SESSION['lista_clientes'] as $k => $v)
  			{  
				if($idcliente == $k)
 				{  
					$_SESSION['lista_clientes'][$k] = $nombre; 
?>
					<h4 class="alert alert-success" style="margin-top: -5px;">EL CLIENTE #<?php echo $k; ?> SE AGREGO CORRECTAMENTE A LA LISTA</h4>
<?php
					$encontrado = 1 ;
				}  				    
			}
			if(!$encontrado)
			{ 
				$_SESSION['lista_clientes'][$idcliente] = $nombre; 
?>
				<h4 class="alert alert-success" style="margin-top: -5px;">EL CLIENTE #<?php echo $k; ?> SE AGREGO CORRECTAMENTE A LA LISTA</h4>
<?php
			}
		}
                  
	 }// fin de método addProducto
	 	 
	public function eliminar_cliente_sesion($idcliente)
 	{
  		if(isset($_SESSION['lista_clientes']))
		{
			foreach($_SESSION['lista_clientes'] as $k => $v)
			{ 
				if(isset($idcliente))
				{
					unset($_SESSION['lista_clientes'][$idcliente]);
				}
			}
	  	} 
 	}
	 
	public function ver_clientes_sesion()
	{
		try
		{  
  			$contador = 1;		  
			$itemsEnCesta = $_SESSION['lista_clientes'];
			$cantidad = count($itemsEnCesta);
			
			//validamos que la session de array exista y que contenga un producto		  
			if(isset($itemsEnCesta) && $cantidad > 0 ) 
			{
?>          
	  		<table id="zero_config" class="table table-bordered">
				<thead>
					<tr>
						<th>&nbsp;</th>
						<!--<th># Cliente</th>-->
						<th>Nombre</th>
					</tr>
				</thead>
				
				<tbody>
<?php
					foreach(array_reverse($itemsEnCesta,true) as $k => $v)
		           	{
						if($k != 0){
							$idcliente = $k;
							$nombre = $v;
						}else{
							$idcliente = "";
							$nombre = "TODOS LOS CLIENTES";
						}
?>
						<tr>
							<td width="20" style="text-align: center;">
								<button type="button" onClick="eliminar_lista_clientes('<?php echo $k; ?>')" title="BORRAR" class="btn btn-outline-danger"><i class="mdi mdi-delete-empty"></i></button>
							</td>
							<!--<td width="90" style="text-align: center;"><?php echo $idcliente; ?></td>-->
							<td><?php echo $nombre; ?></td>
						</tr>
<?php
					}
?>
				</tbody>
			</table>

			<script type="text/javascript">
				//var metodo = "var resp=MM_validateForm('v_mensaje','','R'); if(resp==1){ GuardarEspecial('alta_mensaje','mensajes/ga_mensaje.php','mensajes/vi_mensajes.php','main');}";
				//$('#btn-enviar-mensaje').html('<button type="button" onClick="'+metodo+'" class="btn btn-primary alt_btn" style="float: right;">Guardar</button>');
				$('#boton_no_enviar').hide();
				$('#boton_enviar').show();
			</script>
<?php 	  
		  	}else{
?>
			<table id="zero_config" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>&nbsp;</th>
						<th># Cliente</th>
						<th>Nombre</th>
					</tr>
				</thead>
				
				<tbody>
					<tr>
						<td colspan="3" align="center">La lista de clientes esta vacia.</td>
					</tr>
				</tbody>
			</table>

			<script type="text/javascript">
				//var metodo = "alert('Imposible enviar mensaje, debe seleccionar al menos un cliente.')";
				//$('#btn-enviar-mensaje').html('<button type="button" onClick="'+metodo+'" class="btn btn-primary alt_btn" style="float: right;">Guardar</button>');
				$('#boton_enviar').hide();
				$('#boton_no_enviar').show();
				
			</script>

<?php 
		  	}// fin de else
		  
		}catch(Exception $e)
        {
		  $v = explode ('|',$e);
		  $n = explode ("'",$v[1]);
		  echo '<div class="alert_error" id="mens">'.$this->db->m_error($n[0]).'</div>'; 	   
        }
	  }
	/* ========================================== TERMINA METODOS DE LISTA DE SESION CLIENTES MENSAJES ======================================================= */
	 
}// fin de clase ShoppingCar

?>