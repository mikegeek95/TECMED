<?php

require_once("class.Sesion.php");



class Compras 

{

	

	public $db ; //para la clase mysql

	public $id_compra;

	public $idusuarios ;

	public $fecha_compra ;

	public $prioridad ;

	public $descripcion ;

	public $estatus ;

	public $id_producto;

	public $cantidad ;

	public $costo ;
	
	public $sucursal;

	public $id_compra_detalle;

	

	private $s ;

	

	function Compras ()

	{

		$this->s = new Sesion ();

	}	

	

	function guardarCompra ()

	{

		$usuario = $this->s->obtenerSesion('se_sas_Usuario');

		$sql_compra = "INSERT INTO compras (idusuarios  , prioridad , descripcion, idsucursales) VALUES ('$usuario'  , '$this->prioridad' , '$this->descripcion', '$this->sucursal' ) ";

		$result_comra = $this->db->consulta ($sql_compra);

		$this->id_compra =  $this->db->id_ultimo();

		

	}

	

	function guardaCompraDetalle ()

	{

		

	    $sql_compra = "INSERT INTO compra_detalle (idcompras , idproducto  , cantidad ) VALUES ('$this->id_compra' , '$this->id_producto' , '$this->cantidad'  ) ";

		$result_comra = $this->db->consulta ($sql_compra);

		$this->id_compra_detalle =  $this->db->id_ultimo();

	}

	

	function modificarCompra ()

	{

		$sql_compra ="UPDATE compras SET fecha_compra = '$this->fecha_compra' , prioridad = $this->prioridad , descripcion = '$this->descripcion' , estatus = $this->estatus , idsucursales = '$this->sucursal' WHERE idcompras = ".$this->id_compra;

		$result_comra = $this->db->consulta($sql_compra);

		

	}

	
	function detallecompra ($id)

	{

		$sql_compra ="select * from compra_detalle cd, productos p where p.idproducto=cd.idproducto and idcompras=$id";
		$result_comra = $this->db->consulta($sql_compra);

		return $result_comra;

	}
	

	function validar_compra ()

	{

		$sql_compra = "SELECT * FROM compras WHERE idcompras =".$this->id_compra;

		$result_comra = $this->db->consulta($sql_compra);

		$result_comra_row = $this->db->fetch_assoc ($result_comra);

		$result_comra_row_num = $this->db->num_rows($result_comra);

		

		

		if ($result_comra_row_num > 0)

		{

			echo 1;

		}else 

		{

			echo 0 ; 

		}

		

	}

	

	

	

	

}

?>