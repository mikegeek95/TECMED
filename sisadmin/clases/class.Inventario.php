<?php
class Inventario
{
  
    public $db;
	
	public $idusuarios;//id de usuario que esta realizando la operacion
	public $clave_producto;//clave del producto para dar de alta en la tabla de inventario
	public $entradas;//cantida  de producto que va a entrar en el sistema
	public $salidas;//cantidad de salidas que va a salir del sistema
	public $ultimo_idinventario;//ultimo id del inventario si es que se agrego uno nuevo sino
	
	public $idinventario;//id del inventario que va en la tabla de inventario historial
	public $fecha;//fecha que se esta dando de alta el producto
	public $tipo;//identificador para saber si es salida o entrada de producto
	public $descripcion;//variable vasia en caso de que se antrada y en caso de salidad especifica el motivo de la salida
	public $codigo_barras;//codigo de la etiqueta colocada en el producto
	
	public $cantidad_entrada;//cantidad de producto que se encuentra en entradas de la tabla inventario
	public $cantidad_salidas;//cantidad de salidas que hay en el inventario
	public $ProductoTipo;//tipo de producto que esta siendo consultado para saber si esta de baja o nop
	
	public $existencia_productos;//varibles para comprovar la existencia del producto 0 para sin existencia 1 para conexistencia
	public $estatusProducto;//varibles para ver si el producto se encuentra activo sin baja o si ya se dio de baja
	
	
	//funcion para validar que el estatus del producto este activo para proceder a agregar a inventario
	public function validarEstatusProducto($codigo)
    {
        $query="SELECT estatus FROM productos WHERE clave_producto='$codigo'";
		$resp=$this->db->consulta($query);
		$rows=$this->db->fetch_assoc($resp);
		
		return $rows['estatus'];
		$this->db->liberar($resp);
    }
	
	//funcion para validar codigo de barras la existencia en e inventario-- si exiete regresa la cantidad que tiene -- sino regresa cero
	public function validarInventarioProducto($codigo)
	{
		$query="SELECT * FROM inventario WHERE codigo_barras='$codigo'";
		$resp=$this->db->consulta($query);
		$rows=$this->db->fetch_assoc($resp);
		$totalRows=$this->db->num_rows($resp);
		
		
		if($totalRows==0)
		{
			$this->existencia_productos=0;
		}
		else
		{
			$this->existencia_productos=1;
			$this->estatusProducto=$rows['tipo'];
		}
		
		$this->ProductoTipo=$rows['tipo'];
		
		$this->db->liberar($resp);
	}
	
	//funcion para comprobar la existencia del registro en la tabla de inventario para agregar producto
	public function CompruebaProductoInventario($codigo)
	{
		$si_esta=0;
		
		$query="SELECT * FROM productos WHERE clave_producto='$codigo'";
		$resp=$this->db->consulta($query);
		$rows=$this->db->fetch_assoc($resp);
		$totalRows=$this->db->num_rows($resp);
		
		if($totalRows!=0)
		{
			$this->cantidad_salidas=$rows['salidas'];
			$this->cantidad_entrada=$rows['entradas'];
			$this->clave_producto=$rows['clave_producto'];
			$si_esta=1;
		}
		return $si_esta;
		$this->db->liberar($resp);
	}
	
	//funcion para insertar el registro de un nuevo producto
	public function AgregarProducto()
	{
		$query="INSERT INTO inventario(idusuarios,clave_producto,entradas)VALUES($this->idusuarios,'$this->clave_producto',$this->entradas)";
		$resp=$this->db->consulta($query);
		$rows=$this->db->fetch_assoc($resp);
		$totalRows=$this->db->num_rows($resp);
		//$this->ultimo_idinventario=$this->db->id_ultimo();
		$this->idinventario=$this->db->id_ultimo();
		
		$this->db->liberar($resp);
	}
    
	//funcion para agregar registro en el inventario_historial 
	public function AgregarProductoInventarioHistorial()
	{
		$query="INSERT INTO inventario(clave_producto,fecha_entrada,tipo,descripcion_entrada,codigo_barras,idusuario_entrada)VALUES('$this->clave_producto',NOW(),$this->tipo,'$this->descripcion','$this->codigo_barras',$this->idusuarios)";
		$resp=$this->db->consulta($query);
		$rows=$this->db->fetch_assoc($resp);
		$totalRows=$this->db->num_rows($resp);
		
		$this->db->liberar($resp);
	}
	
	//funcion para agregar registro en el inventario_historial 
	public function ActualizarProductoInventarioHistorial()
	{
		$query="UPDATE inventario SET fecha_salida=NOW(),tipo=$this->tipo,descripcion_salida='$this->descripcion',idusuario_salida=$this->idusuarios WHERE codigo_barras='$this->codigo_barras'";
		$resp=$this->db->consulta($query);
		$rows=$this->db->fetch_assoc($resp);
		$totalRows=$this->db->num_rows($resp);
		
		$this->db->liberar($resp);
	}
	
	//funcion para modificar la cantidad de producto entrante en el inventario
    public function modificarEntrada()
    {
        $query="UPDATE productos SET entradas=$this->entradas WHERE clave_producto='$this->clave_producto'";
		$resp=$this->db->consulta($query);
		
		$this->db->liberar($resp);
    }

    //funcion para modificar la cantidad de producto saliente en el inventario
    public function modificarSalida()
    {
        $query="UPDATE productos SET salidas=$this->salidas WHERE clave_producto='$this->clave_producto'";
		$resp=$this->db->consulta($query);
		
		$this->db->liberar($resp);
    }
		
    public function generarReporteEntrada()
    {
       
    }

   
    public function generarReporteSalida()
    {
       
    }

	//funcion para sacar el total de productos en invetario
    public function obtenerStockProducto($codigo)
    {
		$query_stock = "SELECT entradas - salidas AS existencia FROM productos WHERE clave_producto = '$codigo'";
		$stock = $this->db->consulta($query_stock);
		$row_stock = $this->db->fetch_assoc($stock);
		$totalRows = $this->db->num_rows($stock);
		
		if($totalRows>0)
		{
			return $row_stock['existencia'];
		}
		else
		{
			return '0';
		}
        
    }// fin de  obtenerStockProducto

} /* end of class Inventario */

?>