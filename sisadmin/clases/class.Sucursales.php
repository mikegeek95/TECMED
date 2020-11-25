<?php
class Sucursales
{
	
	/*============ DECLARACIÓN DE VARIABLES ===============*/
	
	public $db;
	public $idsucursales;
	public $nombre ;
	public $direccion ;
	public $tel ;
	public $email ;
	public $notas_print;
	public $estatus;
	public $tipo;
	

	/*=====================================================*/
	
	/*============ INICIAN METODOS DE CLASE ===============*/
	
	//funcion que sirve para obtener las sucursales que pertenecen a una empresa
	public function todasSucursales()
	{
		$query = "SELECT * FROM sucursales ";
		$result = $this->db->consulta($query);
		return $result;
	}
	
	//funcion que sirve para buscar una sucursal por su id
	public function buscar_sucursal()
	{
		$query = "SELECT * FROM sucursales WHERE idsucursales = '$this->idsucursales'";
		$result = $this->db->consulta($query);
		return $result;
	}
	
	//funcion que sirve para guardar una sucursal 
	public function guardar_sucursal()
	{

		$sql = "INSERT INTO sucursales (sucursal, direccion, tel, email, tipo, notas_print, estatus) VALUES 	('$this->nombre', '$this->direccion', '$this->tel', '$this->email', '$this->tipo', '$this->notas_print', '$this->estatus');";

		$this->db->consulta($sql);
		$this->idsucursales = $this->db->id_ultimo();
	}
	
	//funcion que sirve para modificar una sucursal
	public function modificar_sucursal()
	{
		$query = "UPDATE sucursales SET 

		      
		      sucursal='$this->nombre', 
		      direccion='$this->direccion', 
		      tel='$this->tel', 
		      email='$this->email', 
		      tipo='$this->tipo', 
		      notas_print='$this->notas_print', 
		      
		      estatus='$this->estatus'
		      	
		WHERE idsucursales = '$this->idsucursales'";

		$this->db->consulta($query);
	}
}
?>