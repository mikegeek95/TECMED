<?php
class Clientes
{
	public $db;//objeto de conecxion con la base de datos
	
	public $idCliente;//ide del Cliente  
	public $ultimoIDCliente;//ultimo id del Cliente
	

		
	//DATOS GENERALES
	
	public $no_tarjeta;
	public $nombre;
	public $paterno;
	public $materno;
	public $direccion;
	public $telefono;
	public $fax;
	public $email;
	public $sexo;
	public $f_nacimiento;
	public $usuario;
	public $clave;
	public $estatus;
	public $descuento;
	public $nivel;
	public $direccion_envio;
	
	
	//INFORMACION DE FACTURACION
	
	public $fis_razonsocial;
	public $fis_rfc;
	public $fis_direccion;
	public $fis_no_int;
	public $fis_no_ext;
	public $fis_col;
	public $fis_ciudad;
	public $fis_estado;
	public $fis_cp;
	
	
	public $idcliente_monedero;
	
	public $mes;
	public $ano;
	
	public $selected;
	public $cp;
	
	public $idsucursales;
	
	//funcion para guarda una nueva empresas
	public function GuardarNewCliente()
	{
		$query="INSERT INTO clientes (nombre,paterno,materno,direccion,telefono,fax,email,sexo,f_nacimiento,fis_razonsocial,fis_rfc,fis_direccion,fis_no_int,fis_no_ext,fis_col,fis_ciudad,fis_estado,fis_cp,estatus,idniveles) VALUES ('$this->nombre','$this->paterno','$this->materno','$this->direccion','$this->telefono','$this->fax','$this->email','$this->sexo','$this->f_nacimiento','$this->fis_razonsocial','$this->fis_rfc','$this->fis_direccion','$this->fis_no_int','$this->fis_no_ext','$this->fis_col','$this->fis_ciudad','$this->fis_estado','$this->fis_cp','$this->estatus','$this->nivel')";
		$result=$this->db->consulta($query);
		$this->ultimoIDCliente=$this->db->id_ultimo();
	}
	
	
	//funcion para modificar los datos de la empresas
	public function ModificarCliente()
	{
		$query="UPDATE clientes SET 	
		nombre='$this->nombre',
		paterno='$this->paterno',
		materno='$this->materno',
		direccion='$this->direccion',
		telefono='$this->telefono',
		fax='$this->fax',
		email='$this->email',
		sexo='$this->sexo',
		f_nacimiento='$this->f_nacimiento',
		fis_razonsocial='$this->fis_razonsocial',
		fis_rfc='$this->fis_rfc',
		fis_direccion='$this->fis_direccion',
		fis_no_int='$this->fis_no_int',
		fis_no_ext='$this->fis_no_ext',
		fis_col='$this->fis_col',
		fis_ciudad='$this->fis_ciudad',
		fis_estado='$this->fis_estado',
		fis_cp='$this->fis_cp',
		estatus='$this->estatus',
		idniveles = '$this->nivel'
		WHERE idcliente = '$this->idCliente'";
		
		$result = $this->db->consulta($query);
	}
	
	

	
	//funcion para obtener la informacion de la empresa
	public function ObtenerInformacionCliente()
	{
		$Query="SELECT * FROM clientes WHERE idcliente=".$this->idCliente;		
		$resp=$this->db->consulta($Query);
		$rows=$this->db->fetch_assoc($resp);
		$total=$this->db->num_rows($resp);
		
		if($total==0)
		{ return 0;}
		else
		{ return $rows;}
	}
	
	
	//funcion para obtener la informacion de la empresa
	public function ObtenerInformacionClientes()
	{
	     $sql = "SELECT * FROM clientes";
		 $resp = $this->db->consulta($sql);
		 $rows_array = array();
	     while($result= $this->db->fetch_object($resp))
			{
			  $rows_array[] = $result;
			}
			return $rows_array;
	}
	
		public function ObtenerInformacionClientesResult()
				{
					 $sql = "SELECT * FROM clientes order by nombre asc";
					 $resp = $this->db->consulta($sql);
					 return $resp;
				}
				
		public function ObtenerInformacionClienteResult()
				{
					 $sql = "SELECT * FROM clientes order by nombre asc";
					 $resp = $this->db->consulta($sql);
					 return $resp;
				}		
	
	
	
	
	
	function validarUsuarioCliente ()
	{
		$r ;
		$sql_cliente = "SELECT * FROM clientes WHERE usuario = '$this->usuario'";
		$result_cliente = $this->db->consulta($sql_cliente);
		$result_cliente_row = $this->db->fetch_assoc($result_cliente);
		$result_cliente_row_num = $this->db->num_rows($result_cliente);
		
		
		if ($result_cliente_row_num != 0)
		{
			$r = 1 ;
			
		}
		else
		{
			$r = 0;
		
		}
		return $r ;
		
		
	}
	
	public function validarEmailCliente ()
	{
		$r ;
		$sql_client = "SELECT * FROM clientes WHERE email = '$this->email'";
		$result_cliente = $this->db->consulta($sql_client);
		$result_cliente_row = $this->db->fetch_assoc($result_cliente);
		$result_cliente_row_num = $this->db->num_rows($result_cliente);
		
		
		if ($result_cliente_row_num != 0)
		{
			$r = 1 ;
			
		}
		else
		{
			$r = 0;
		
		}
		return $r ;
		
		
	}
	
	
	public function buscarMovimientosMonederoAbonos()
	{
		$sql = "SELECT * FROM cliente_monedero WHERE idcliente = '$this->idCliente' AND tipo = '0' ORDER BY fecha DESC";
		$resp = $this->db->consulta($sql);
		return $resp;
	}
	
	public function buscarMovimientosMonederoCargos()
	{
		$sql = "SELECT * FROM cliente_monedero WHERE idcliente = '$this->idCliente' AND tipo = '1' ORDER BY fecha DESC";
		$resp = $this->db->consulta($sql);
		return $resp;
	}
	
	public function buscarMovimientoMonedero()
	{
		$sql = "SELECT * FROM cliente_monedero WHERE idcliente_monedero = '$this->idcliente_monedero'";
		$resp = $this->db->consulta($sql);
		return $resp;
	}
	
	//Funcion que sirve para obtener la cantidad en dinero vendida de un cliente
	public function ObtVentasCliente()
	{
		//$sql = "SELECT SUM(total) as total FROM nota_remision WHERE idcliente = '$this->idCliente' AND MONTH(fechapedido) = '$this->mes' AND estatus = '1'";
		
		$sql = "SELECT SUM(monto_efec+monto_transfer+monto_deposito+monto_cheque+monto_tc-cambio) as total FROM nota_remision WHERE idcliente = '$this->idCliente' AND MONTH(fechapedido) = '$this->mes' AND YEAR(fechapedido) = '$this->ano' AND estatus = '1'";
		$result = $this->db->consulta($sql);
		$result_row = $this->db->fetch_assoc($result);	
		return $result_row;
	}
	
	//Funcion que sirve para obtener la cantidad en dinero devuelta de un cliente
	public function obtDevolucionesCliente()
	{
		$sql = "SELECT SUM(cd.total) as total  FROM nota_remision nr, cliente_devolucion cd WHERE idcliente = '$this->idCliente' AND nr.idnota_remision = cd.idnota_remision AND MONTH(fechapedido) = '$this->mes'";
		$result = $this->db->consulta($sql);
		$result_row = $this->db->fetch_assoc($result);
		return $result_row;
	}
	
	//Funcion que sirve para actualizar el nivel del cliente a 60%
	public function actualizarNivel60()
	{
		$sql = "UPDATE clientes SET idniveles = '6' WHERE idcliente = '$this->idCliente'";
		$this->db->consulta($sql);
	}
	
	//Funcion que sirve actualizar el nivel del cliente a 50%
	public function actualizarNivel50()
	{
		$sql = "UPDATE clientes SET idniveles = '5' WHERE idcliente = '$this->idCliente'";
		$this->db->consulta($sql);
	}
	
	//Funcion que sirve para actualizar el nivel del cliente a 62%
	public function actualizarNivel62()
	{
		$sql = "UPDATE clientes SET idniveles = '7' WHERE idcliente = '$this->idCliente'";
		$this->db->consulta($sql);
	}
	
	
	//Funcion que nos sirve para obtener a todos los clientes que tienen dado de alta un numero telefonico
	public function clientesTelefono()
	{
		$sql = "SELECT * FROM clientes WHERE telefono != ''";
		$resp = $this->db->consulta($sql);
		return $resp;
	}
	
	
	//Funciones que sirve para obtener los cumpleañeros del dia
	public function obtener_cumpleanos_diario()
	{
		$sql = "SELECT * FROM clientes WHERE MONTH(f_nacimiento) = '$this->mes' AND DAY(f_nacimiento) = '$this->dia'";
		$result = $this->db->consulta($sql);
		return $result;
	}
}
?>