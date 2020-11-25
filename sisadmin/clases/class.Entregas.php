<?php
require_once('class.Sesion.php');

class Entregas {

	//clases externas
	public $db ;//para la conexion

	

	

	//atributos de la tabl nota_entrega
	public $idnota_entrega ;
	public $idnota_remision;
	public $idusuarios ;

	

	

	//atributos de la tabla nota_entrega_detalle

	

	

	public $idproduto;

	public $cantidad ;

	private $s ;

	

	function Entregas()

	{

		$this->s = new Sesion ();

	}

	

	

	function datosCliente ()

	{

		 $sql_cliente = "SELECT  CONCAT(cl.nombre,' ',cl.paterno,' ' ,cl.materno) AS cliente, cl.idcliente 

 FROM

 clientes cl , nota_remision n 



WHERE 

n.idcliente = cl.idcliente



AND

n.idnota_remision =  '$this->idnota_remision' ";

		$result_cliente = $this->db->consulta($sql_cliente);

		$result_cliente_row = $this->db->fetch_assoc($result_cliente);

		

		return $result_cliente_row;

	}

	

	function totalProductos ()

	{

		$sql_total = "SELECT COUNT(nd.idproducto) AS total FROM nota_descripcion nd WHERE nd.idnota_remision = '$this->idnota_remision'";

		$result_total = $this->db->consulta($sql_total);

		$result_total_row = $this->db->fetch_assoc($result_total);

		return $result_total_row;	

	}

	

	function verProductos ()

	{

		

          $sql_verp = "SELECT

						nd.idproducto ,

						nd.cantidad ,

						p.nombre

						

						FROM 

						nota_descripcion nd , productos p

						WHERE

						nd.idproducto = p.idproducto 

						AND

						

						

						idnota_remision =  '$this->idnota_remision' ";

		$result_verp = $this->db->consulta($sql_verp);				

		$arreglo  = array();



	     while($result_verp_row_object = $this->db->fetch_object($result_verp))

			{

			  $arreglo[] = $result_verp_row_object;

			}

			

			return $arreglo;

		

			 

			 

			 

		 

	}

	

	

	function guardarEntrega ()

	{

		$idusuario = $this->s->obtenerSesion('se_sas_Usuario');

		 $sql_entrega = "INSERT INTO nota_entrega (idnota_remision , idusuarios ) VALUES ('$this->idnota_remision','$idusuario')";

		$result_entrega = $this->db->consulta($sql_entrega);

		$this->idnota_entrega = $this->db->id_ultimo();

		//echo 1 ;

	}//fin de guardarEntrega

	

	

	function guardarEntregaDetalle ()

	{

		$sql_entradaDetalle = "INSERT INTO nota_entrega_detalle (idnota_entrega , idproducto , cantidad) VALUES ('$this->idnota_entrega','$this->idproduto','$this->cantidad')";

		$result_entradaDetalle = $this->db->consulta($sql_entradaDetalle);

		

	}//fin de guardar entrega detalle

	

	

	function datosUsuario ()

	{

		$sql_usuario = "SELECT CONCAT(u.nombre,' ',u.paterno,' ',u.materno) AS nombreU 





						FROM usuarios u , nota_entrega n 

						WHERE

						n.idusuarios = u.idusuarios 

						AND 

						n.idnota_remision = '$this->idnota_remision' ";

		 $result_usuario = $this->db->consulta($sql_usuario);				

		 $result_usuario_row = $this->db->fetch_assoc($result_usuario);

		 

		 return $result_usuario_row ;

	}

	

	function existeProductoenNotaRemision ()

	{

		$que ;

		 $sql_producto = "SELECT cantidad FROM nota_descripcion WHERE idnota_remision = '$this->idnota_remision' AND idproducto = '$this->idproduto' ";	

		$result_producto = $this->db->consulta($sql_producto);

		//$result_producto_row = $this->db->fetch_assoc($result_producto);

		$result_producto_row_num = $this->db->num_rows($result_producto);

		

		if ($result_producto_row_num != 0)

		{

			$que = 1 ;

		}

		else 

		{

			$que = 0 ;

		}

		return $que;

		

		

	}//fin de obtenerCantidadProducto

	

	

	function obtenerCantidadProducto ($cantidad)

	{

		//echo "la cantidad es = ".$cantidad;

		$que ;

		 $sql_producto = "SELECT cantidad FROM nota_descripcion WHERE idnota_remision = '$this->idnota_remision' AND idproducto = '$this->idproduto' ";	

		$result_producto = $this->db->consulta($sql_producto);

		$result_producto_row = $this->db->fetch_assoc($result_producto);

		//echo "esto es resutl_proucto_row = ".$result_producto_row['cantidad'];

		if ($result_producto_row['cantidad'] == $cantidad )

		{

			$que = 1;

		}

		else if($result_producto_row['cantidad'] > $cantidad)

		{

			$que = 0 ;

		}

		else  

		{

			$que = 2 ;

		}

		

		return $que;

		

	}//fin de obtenerCantidadProducto

	

/*	function restarProducto ()

	{

		$sql_producto = "UPDATE productos SET existencia = (existencia - '$this->cantidad') WHERE idproducto = '$this->idproduto'";

		$result_producto = $this->db->consulta($sql_producto); 

		

	}*/

	

	

	

}//fin de clase entregas





?>