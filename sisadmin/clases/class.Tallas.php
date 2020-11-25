<?php
class Tallas
{
	public $db;//objeto de la clase de conexcion
	public $idtallas;
	public $talla;
	public $unidad;
	public $estatus;
	public $descripcion;
			
	//Funcion que sirve para obtener todo el listado de tallas
	public function listadoTallas()
	{
		$sql = "SELECT * FROM tallas";
		$result = $this->db->consulta($sql);
		return $result;
	}
	
	//Funcion que sirve para obtener todo el listado de tallas activas
	public function TallasActivas()
	{
		$sql = "SELECT * FROM tallas WHERE estatus = '1'";
		$result = $this->db->consulta($sql);
		return $result;
	}
	
	//Funcion que sirve para buscar una talla
	public function buscarTalla()
	{
		$sql = "SELECT * FROM tallas WHERE idtallas = '$this->idtallas'";
		
		$result = $this->db->consulta($sql);
		return $result;
	}
	
	//Funcion que sirve para guardar una talla
	public function guardarTalla()
	{
		$sql = "INSERT INTO tallas (unidad,valor,estatus,descripcion) VALUES ('$this->unidad','$this->talla','$this->estatus','$this->descripcion');";
		$this->db->consulta($sql);
		$this->idtallas = $this->db->id_ultimo();
	}
	
	//Funcion que sirve para modificar una talla
	public function modificarTalla()
	{
		$sql = "UPDATE tallas SET unidad = '$this->unidad', valor = '$this->talla', estatus = '$this->estatus', descripcion = '$this->descripcion' WHERE idtallas = '$this->idtallas'";
		$this->db->consulta($sql);
	}	
}
?>