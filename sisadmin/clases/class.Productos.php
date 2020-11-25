<?php
class Producto
{
	public $db;//objeto de la clase de conexcion
	public $id_producto;//identificador del producto
	//public $id_producto_anterior;//este id se guardara para poder hacer el UPDATE ya que el id_producto puede cambiar el valor
	public $cod_proveedor;//identificador del producto ante el proveedor
	public $subcategoria;//identificador de la categoria
	public $idcategoria_precio;
	public $nombre;//nombre del producto
	public $descripcion;//descripcion del producto
	public $pc;//Precio Costo
	public $pv;//Precio Venta
	public $pm;//Precio Mayoreo
	public $descuento;//descuento del producto
	public $foto;//foto del producto
	public $thumb;//thum del producto 
	public $entradas; // entradas del producto
	public $existncia;//existencia tipo varchar
	public $cantidadmin; //cantidad minima para el stock
	public $salidas;//salida del producto
	public $estatus;//estatus del producto
	public $unidad; //unidad del producto pz,lt,kg
	public $idnota_remision;

	public $opciones;//para traer la cadena que se imprimira a lo ultimo en <option></option>
	
	public $idsucursales;
	public $sms;
	
	public $idproductos_imagenes;
	public $ultimo_id_imagens;
	
	public $depende;
	
	public $idtallas;
	public $idsobrepedido_camp;
	
	public function Producto()
	{
			
		$this->opciones ="";
		
	}
	
	
	//funcion para guardar los estados 
	
	public function GuardarProducto()
	{
		 $query='INSERT INTO productos (idproducto , cod_proveedor, idsubcategoria , nombre , descripcion , pc,pv , descuento , stok_min , estatus , unidad, idcategoria_precio  ) VALUES ("'.$this->id_producto.'","'.$this->cod_proveedor.'","'.$this->subcategoria.'" , "'.$this->nombre.'" , "'.$this->descripcion.'" , "'.$this->pc.'","'.$this->pv.'", "'.$this->descuento.'" , "'.$this->cantidadmin.'" , "'.$this->estatus.'" , "'.$this->unidad.'","'.$this->idcategoria_precio.'" )';
		$resp=$this->db->consulta($query);
			
		//echo $query;
		
		
	}
	
	
	//funcion para modificar estado
	public function ModificarProducto()
	{
		$query='UPDATE productos SET idsubcategoria = "'.$this->subcategoria.'" , cod_proveedor = "'.$this->cod_proveedor.'",nombre = "'.$this->nombre.'" , descripcion = "'.$this->descripcion.'" , pc = "'.$this->pc.'", pv = "'.$this->pv.'",  descuento = "'.$this->descuento.'" , stok_min = "'.$this->cantidadmin.'" , estatus = "'.$this->estatus.'" , unidad = "'.$this->unidad.'", idcategoria_precio = "'.$this->idcategoria_precio.'" WHERE idproducto = "'.$this->id_producto.'"';
		$resp = $this->db->consulta($query);
		
		
	}
	
	///funcion para objeter datos de un producto
	public function ObtenerDatosProducto()
	{
		$query="SELECT * FROM productos WHERE idproducto = '$this->id_producto'";
		$resp=$this->db->consulta($query);
		$rows=$this->db->fetch_assoc($resp);
		$total = $this->db->num_rows($resp);
		//echo $total;
		return $rows;
	}
	
	public function obtproductos()
	{
		$sql = "SELECT p.idproducto AS CODIGOPRODUCTO,p.cod_proveedor AS CODIGOPROVEEDOR,p.nombre AS NOMBREPRODUCTO,p.pv AS COSTOACTUAL FROM productos p";
		$resp = $this->db->consulta($sql);
		return $resp;
	}
	
	public function obtenerProductosSucursal()
	{
		$sql = "SELECT p.idproducto AS CODIGOPRODUCTO,p.cod_proveedor AS CODIGOPROVEEDOR,p.nombre AS NOMBREPRODUCTO,p.pv AS COSTOACTUAL,i.existencia AS EXISTENCIA,s.sucursal as SUCURSAL, i.idtallas as TALLA FROM productos p, inventario i, sucursales s WHERE p.idproducto=i.idproducto AND i.idsucursales=s.idsucursales AND i.idsucursales='$this->idsucursales'";
		$resp = $this->db->consulta($sql);
		return $resp;
	}
		
	///funcion para objeter datos de un producto en general enviando un arreglo
	public function ObtenerDatosProductos_Array()
	{
		$query="SELECT * FROM productos";
		$resp=$this->db->consulta($query);
		$rows=$this->db->fetch_assoc($resp);
		$total = $this->db->num_rows($resp);
		
		 $rows_array = array();

	     while($result= $this->db->fetch_object($resp))
			{
			  $rows_array[] = $result;
			}
			
			
			return $rows_array;
	}
	
	
	//funcion validar producto, id del producto
	
	public function validarProducto()
	{   
	 
		
		
			$query="SELECT * FROM productos WHERE idproducto = '$this->id_producto'";
			$resp=$this->db->consulta($query);
			$rows=$this->db->fetch_assoc($resp);
			$total = $this->db->num_rows($resp);
			echo $total;
			//return $total;
		
	   
	   
		}
		
		
	//funcion para validar producto en lista ya activo.
	
	
	public function validarProductoparaAltainventario()
	{   
	 
		
		
	    	$query="SELECT * FROM productos WHERE idproducto = '$this->id_producto' AND estatus = 1";
			$resp=$this->db->consulta($query);
			$rows=$this->db->fetch_assoc($resp);
			$total = $this->db->num_rows($resp);
			return $total;
			   
	   
		}	
	
	//termina validar producto
	
	//funcion para obtener la lista de una categoria para el producto y para saber si la categoria esta seleccionada
	public function lista($idcategoria,$nivel,$seleccionado)
	 {
		 
		$query= "SELECT * FROM categorias where idcategoria = $idcategoria";
		$resp = $this->db->consulta($query);
		$fila = $this->db->fetch_assoc($resp);
		
		$espacio = "";
		
		for($x=1 ; $x<=$nivel ; $x++)
		{
			$espacios = $espacios."&nbsp;&nbsp;";
		}
		
			if($fila['depende'] == 0)
			{
			
				$desactivado = ' disabled="disabled" ';
			}
			
			else 
			{
				$desactivado = "";
			}
		
			if($fila['idcategoria'] == $seleccionado )
			    {
				   $selec = ' selected="selected" ';
				}else
				{
					$selec='';
				}
				
			
			
		echo '<option value="'.$fila['idcategoria'].'" '.$selec.' >'.$espacios.' '.$fila['nombre'].' '.'</option>';
		
		
		$query2= "SELECT * FROM categorias where depende = $idcategoria";
		$resp2 = $this->db->consulta($query2);
		$fila2 = $this->db->fetch_assoc($resp2);
		$fila2_num = $this->db->num_rows($resp2);
		
		 if($fila2_num != 0)
		{
					
				do
				{
				 
				   $this->lista($fila2['idcategoria'],$nivel+1,$seleccionado);
					
				}while($fila2 = $this->db->fetch_assoc($resp2));
		}else
		{
			
			   $nivel-1;
			
			 
		}
		
		
			
	}
	
	function verificaProducto ()
	{
		$sql_produto = "SELECT * FROM productos WHERE idproducto = '".$this->id_producto."'" ;
		$result_producto = $this->db->consulta($sql_produto);
		$result_producto_row = $this->db->fetch_assoc($result_producto);
		$result_producto_row_num = $this->db->num_rows($result_producto);
		
		if ($result_producto_row_num <= 0)
		{
			return 0; // no hay producto, el producto no existe
		}
		else 
		{
			return 1 ;// si existe el producto, 
		}
	}
	
	/*
	probando metodo
	*/
	
	function verificaProductoExistenteInventario ()
	{
		
		//$sql_produto = "SELECT * FROM productos WHERE idproducto = '".$this->id_producto."' AND existencia > 0" ;
		$sql_produto = "SELECT * FROM productos p, inventario i, sucursales s WHERE p.idproducto=i.idproducto AND i.idsucursales=s.idsucursales AND i.idsucursales='".$this->idsucursales."' AND p.idproducto = '".$this->id_producto."' AND i.existencia > 0 AND i.idtallas = '$this->idtallas'";
		
		$result_producto = $this->db->consulta($sql_produto);
		$result_producto_row = $this->db->fetch_assoc($result_producto);
		$result_producto_row_num = $this->db->num_rows($result_producto);
		
		if ($result_producto_row_num <= 0)
		{
			return 0; // no hay producto, el producto no existe
		}
		else 
		{
			return 1 ;// si existe el producto, 
		}
	}
			
			
	function alcanzaProducto ($cantidad)
	{
		$resultado ;
		//$sql_producto = "SELECT * FROM productos WHERE idproducto = '$this->id_producto'"; 
		$sql_producto = "SELECT * FROM productos p, inventario i, sucursales s WHERE p.idproducto=i.idproducto AND i.idsucursales=s.idsucursales AND i.idsucursales='$this->idsucursales' AND p.idproducto = '$this->id_producto' AND i.idtallas = '$this->idtallas;'";
		$result_producto = $this->db->consulta ($sql_producto);
		$result_producto_row = $this->db->fetch_assoc ($result_producto);
		
		//echo'la cantidad es :'. $cantidad.'la existencia es : '.$result_producto_row['existencia'];
		if ($cantidad > $result_producto_row['existencia'])
		{
			//la cantidad es mayo o igual a la existencia, no pude darle salida al producto
			$resultado = 0 ;
		}
		else 
		{
			//la cantidad no es mayor ni igual a la existencia, si puede darle salida
			$resultado = 1;
		}
		
		return $resultado ;
	}
	
	function alcanzaProductoPagina($cantidad)
	{
		$resultado ;
		//$sql_producto = "SELECT * FROM productos WHERE idproducto = '$this->id_producto'"; 
		$sql_producto = "SELECT * FROM productos p, inventario i, sucursales s WHERE p.idproducto=i.idproducto AND i.idsucursales=s.idsucursales AND i.idsucursales='$this->idsucursales' AND p.idproducto = '$this->id_producto' AND i.idtallas = '$this->idtallas;'";
		$result_producto = $this->db->consulta ($sql_producto);
		$result_producto_row = $this->db->fetch_assoc ($result_producto);
		
		$sql_pendientes = "SELECT SUM(cantidad) as cantidad FROM nota_remision nr, nota_descripcion nd WHERE nr.idnota_remision = nd.idnota_remision AND nr.estatus = '0' AND nd.idproducto = '$this->id_producto' AND nd.idtallas = '$this->idtallas'";
		$result_pendientes = $this->db->consulta($sql_pendientes);
		$result_pendientes_row = $this->db->fetch_assoc($result_pendientes);
				
		//echo'la cantidad es :'. $cantidad.'la existencia es : '.$result_producto_row['existencia'];
		if ($cantidad > ($result_producto_row['existencia'] - $result_pendientes_row['cantidad'] ))
		{
			//la cantidad es mayo o igual a la existencia, no pude darle salida al producto
			$resultado = 0 ;
		}
		else 
		{
			//la cantidad no es mayor ni igual a la existencia, si puede darle salida
			$resultado = 1;
		}
		
		return $resultado ;
	}
	
	function stockMinimo()
	{
		
		$resultado ;
		$sql_producto = "SELECT * FROM productos p, inventario i, sucursales s WHERE p.idproducto=i.idproducto AND i.idsucursales=s.idsucursales AND i.idsucursales='$this->idsucursales' AND p.idproducto = '$this->id_producto'"; 
		$result_producto = $this->db->consulta ($sql_producto);
		$result_producto_row = $this->db->fetch_assoc ($result_producto);
		
		//die($result_producto_row['existencia']."d");
		
		//echo'la cantidad es :'. $cantidad.'la existencia es : '.$result_producto_row['existencia'];
		if ($result_producto_row['existencia'] <= 10)
		{
			//EL PRODUCTO ESTA APUNTO DE ACAVARSE
			$resultado = 0 ;
		}
		else 
		{
			//EL PRODUCTO AUN NO ESTA APUNTO DE ACAVARSE
			$resultado = 1;
		}
		
		//die($resultado." sd");
		return $resultado ;
		
	}
		
	
	function revisarProductoNotaR ()
	{
		$resultado ;
		
		 $sql_producto = "SELECT * FROM nota_descripcion WHERE idnota_remision = $this->idnota_remision AND idproducto = '$this->id_producto' ";
		
		$result_producto = $this->db->consulta ($sql_producto);
		
		$result_producto_row_num = $this->db->num_rows ($result_producto);
		
		
		if ($result_producto_row_num != 0)
		{
			$resultado = 1 ;
		}
		
		else 
		{
			$resultado = 0;
		}
		
		return $resultado ;
		
		
	}	 
	
	
	function Producto_En_Consignacion($id)
	  {
		  $sql_producto = "SELECT sum(cd.cantidad) AS t_consignacion
FROM consignacion_detalles cd, consignacion c
WHERE cd.idconsignacion = c.idconsignacion AND c.estatus = 1 AND cd.idproducto = TRIM($id) group by cd.idproducto";
		
		$result_producto = $this->db->consulta ($sql_producto);
		$result_row = $this->db->fetch_array($result_producto);
		
		return $result_row['t_consignacion'];
		
		
		
	  }
	  
	  
	  public function obtimagenesdeproducto()
	  {
		  $sql = "SELECT * FROM productos_imagenes WHERE idproducto = '$this->id_producto'";
		  $resp = $this->db->consulta($sql);
		  return $resp;
	  }
	  
	  public function guardarProductoImagenes()
	  {
		$sql = "INSERT INTO productos_imagenes (idproducto,estatus) VALUES ('$this->id_producto','$this->estatus');";
		$this->db->consulta($sql);
		$this->ultimo_id_imagens = $this->db->id_ultimo();
	  }
	  
	  public function modificarProductoImagenes()
	  {
		  $sql = "UPDATE productos_imagenes SET estatus = '$this->estatus' WHERE idproductos_imagenes = '$this->idproductos_imagenes'";
		  $this->db->consulta($sql);
	  }
	  
	  public function buscarProductoImagenes()
	  {
		  $sql = "SELECT * FROM productos_imagenes WHERE idproductos_imagenes = '$this->idproductos_imagenes'";
		  $resp = $this->db->consulta($sql);
		  return $resp;
	  }
	
	public function obtenerunidad($id)
	{
		$sql_etiquetas = "SELECT * FROM tallas WHERE idtallas = '$id' ";
		
		$result_etiquetas = $this->db->consulta($sql_etiquetas);
		$result_etiquetas_row = $this->db->fetch_assoc($result_etiquetas);
		
		return $result_etiquetas_row['valor']." ".$result_etiquetas_row['unidad'] ;
		
	}
		 
	
}
?>