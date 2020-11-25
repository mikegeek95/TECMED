<?php
require_once('class.Sesion.php');


class EntradasySalidas
{
	public $db; //objeto de la clase de conexcion

	
	//variables de ENCABEZADO DE la entrada.
	
	public $idusuario;
	public $fecha_compra;
	public $idfactura;
	public $idproveedor;
	public $tipo;
	public $montototal;
	public $fecha_salida;
	public $idsalidas;
	public $identrada;
	public $idsucursales;
	
	//variables para insersion de detalle entrada
	
	public $identrada_detalle;
	public $idproducto;
	public $cantidad;
	public $costo;
	public $descuento;
	public $subtotal;
	public $total_detalle;
	public $id_compra ;
	public $id_nota_remision ;
	public $sucursal;
	public $descripcion ; // me sirve para validar el tipo de entrada que es , por compra, devolucion y otros en estecaso OTROS
	public $talla;
		
	
	
	//funcion para guardar los estados 
	
	public function GuardarEntradaInventario()
	{
		//echo $this->id_compra.' id nota de remision = '.$this->id_nota_remision;
		
	
	  $query ="INSERT INTO entradas(tipoentrada,idusuarios,idnota_remision,idcompras,fecha_entrada,descripcion,idsucursales) VALUES ('$this->tipo','$this->idusuario','$this->id_nota_remision','$this->id_compra','$this->fecha_compra','$this->descripcion','$this->sucursal');";		
		
		
		$resp=$this->db->consulta($query);
		$this->identrada_detalle = $this->db->id_ultimo();
		
		
		
	}
	
	
	public function GuardarDetalleInventario()
	{
		
		
		$query="INSERT INTO entradas_detalles(identradas,idproducto,cantidad,idtallas)VALUES('$this->identrada_detalle','$this->idproducto','$this->cantidad','$this->talla');";
			
		$resp = $this->db->consulta($query);
		
		
		//Buscamos que ya este el producto ne la sucursal
		$query = "SELECT * FROM inventario WHERE idproducto = '$this->idproducto' AND idsucursales = '$this->sucursal' AND idtallas = '$this->talla'";
		$result_producto = $this->db->consulta($query);
		$result_producto_num = $this->db->num_rows($result_producto);
		$result_producto_row = $this->db->fetch_assoc($result_producto);
		
		if($result_producto_num == 0){
			//Insert
			$queryalta = "INSERT INTO inventario (idproducto,idtallas,idsucursales,existencia) VALUES ('$this->idproducto','$this->talla','$this->sucursal','$this->cantidad');";
			$resp = $this->db->consulta($queryalta);
		}else{
			//Update
			$existencia = $result_producto_row['existencia'];
			
			$nva_existencia = $existencia + $this->cantidad;
			
			$queryalta = "UPDATE inventario SET existencia = '$nva_existencia' WHERE idproducto = '$this->idproducto' AND idsucursales = '$this->sucursal' AND idtallas = '$this->talla'";
			$resp = $this->db->consulta($queryalta);
		}
		
		//$queryalta = "UPDATE productos SET entradas =  (entradas + $this->cantidad) , existencia = (existencia + $this->cantidad) WHERE idproducto = '$this->idproducto' ";
		
		//$resp = $this->db->consulta($queryalta);
		
		
	}
	
	
	
	public function GuardarSalidaInventario()
	{
		//echo $this->id_compra.' id nota de remision = '.$this->id_nota_remision;
		
	
	   $query ="INSERT INTO salidas (idusuarios,idsucursales,fecha,tipo,idnota_remision) VALUES ('$this->idusuario','$this->sucursal','$this->fecha_salida','$this->tipo','$this->id_nota_remision')";		
		
		$resp=$this->db->consulta($query);
		$this->identrada_detalle = $this->db->id_ultimo();
		
		
		
	}
	
	
	public function GuardarDetalleSalidaInventario()
	{
		
		 $query="INSERT INTO salidas_detalles (idsalidas , idproducto , cantidad , precio, idtallas  ) VALUES ('$this->identrada_detalle','$this->idproducto','$this->cantidad' , '$this->costo','$this->talla'   )";
			
		$resp = $this->db->consulta($query);
		
 	
		 $querybaja = "UPDATE inventario SET existencia = (existencia - $this->cantidad) WHERE idproducto = '$this->idproducto' AND idsucursales = '$this->sucursal' AND idtallas = '$this->talla' ";
		
		$resp = $this->db->consulta($querybaja);
		
		
	}
	
	
	function validarNotaRemision ()
	{
		$r ;
	 $sql_EyS =  "SELECT * FROM nota_remision WHERE idnota_remision = ".$this->id_nota_remision ;
		$result_EyS = $this->db->consulta ($sql_EyS);
		$result_EyS_num = $this->db->num_rows ($result_EyS);
	
		if ($result_EyS_num != 0)
		{
			//si existe la nota de remision
			$r = 1 ;
		}
		else 
		{
			//no existe la nota de remision
			$r = 0;
		}
		
		return $r ;
		
	}
	
	
		 
		 function validarIdNotaRemisionPagada ()
		 {
			 $r ;
	  $sql_EyS =  "SELECT * FROM nota_remision WHERE idnota_remision = ".$this->id_nota_remision." AND ( estatus = 1 OR estatus = 3 ) " ;
		$result_EyS = $this->db->consulta ($sql_EyS);
		$result_EyS_num = $this->db->num_rows ($result_EyS);
	
		if ($result_EyS_num != 0)
		{
			//si existe la nota de remision
			$r = 1 ;
		}
		else 
		{
			//no existe la nota de remision
			$r = 0;
		}
		
		return $r ;
			 
			 
		 }
		 function validarNotaRemisionEntregada ()
		 {
			 r ;
	 $sql_EyS =  "SELECT * FROM nota_entrega WHERE idnota_remision = '".$this->id_nota_remision." ' " ;
		$result_EyS = $this->db->consulta ($sql_EyS);
		$result_EyS_num = $this->db->num_rows ($result_EyS);
	
		if ($result_EyS_num != 0)
		{
			//si existe la nota de remision
			$r = 1 ;
		}
		else 
		{
			//no existe la nota de remision
			$r = 0;
		}
		
		return $r ;
		 }
	function verSalidasDetalle ()
	{
		 $sql_salidad = "SELECT
						sd.cantidad,
						p.idproducto,
						p.nombre ,
						p.pv
						
						FROM
						salidas s , salidas_detalles sd , productos p
						WHERE
						s.idsalidas = sd.idsalidas
						AND
						sd.idproducto = p.idproducto
						AND
						s.idsalidas = '$this->idsalidas'";
						
			$result_salidad = $this->db->consulta($sql_salidad);			
			
			$rows_array = array();

	     while($result= $this->db->fetch_object($result_salidad))
			{
			  $rows_array[] = $result;
			}
			
			return $rows_array;
	}//fin de ver salida detalle
	
	function verDatosSalida()
	{
		$sql_salida = "SELECT * FROM salidas WHERE idsalidas = '$this->idsalidas'";
		$result_salida = $this->db->consulta($sql_salida);
		$result_salida_row = $this->db->fetch_assoc($result_salida);
		
		return $result_salida_row;
		
	}
	
	function verDatosEntrada()
	{
		$sql_entrada = "SELECT * FROM entradas WHERE identradas = '$this->identrada'";
		$rescult_entrada = $this->db->consulta($sql_entrada);
		$rescult_entrada_row = $this->db->fetch_assoc($rescult_entrada);
		
		return $rescult_entrada_row ;
	}
	
	function verEntradasDetalle ()
	{
		$sql_entradad = "SELECT
						ed.cantidad,
						e.tipoentrada as tipo,
						p.idproducto,
						p.nombre ,
						p.pv,
						t.unidad,
						t.valor
						FROM
						entradas e , entradas_detalles ed , productos p, tallas t
						WHERE
						e.identradas = ed.identradas
						AND
						ed.idproducto = p.idproducto
						AND
						ed.idtallas=t.idtallas
						and
						e.identradas= '$this->identrada'";
		$result_entradad = $this->db->consulta($sql_entradad);
		$arreglo = array();
		
		while($result_entradad_obj = $this->db->fetch_object($result_entradad))
		{
			$arreglo[] = $result_entradad_obj;
		}
		
		return $arreglo ;
	}
}
?>