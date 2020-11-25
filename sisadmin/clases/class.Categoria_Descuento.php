<?php
class categoria_descuento
{
	public $db;
	public $nombre;
	public $estatus;
	public $ultimoidcategoria;
	public $ultimoidnivel;
	public $idniveles;
	public $idcategoria_precio;
	public $desc;
	public $ultimoidcatprenivel;
	public $niveles;
	public $categoria_precio;
	
	public function todasCategoriasPrecio()
	{
		$sql = "SELECT * FROM categoria_precio ORDER BY idcategoria_precio";
		$resp = $this->db->consulta($sql);
		return $resp;
	}
	
	public function todosNiveles()
	{
		$sql = "SELECT * FROM niveles ORDER BY nombre";
		$resp = $this->db->consulta($sql);
		return $resp;
	}
	
	
	public function todosCatPreNiveles()
	{
		$sql = "SELECT n.nombre as nombreNivel, cp.nombre as nombreCat, cpn.descuento as descuento, cpn.idniveles, cpn.idcategoria_precio FROM categoria_precios_niveles cpn, niveles n, categoria_precio cp WHERE cp.idcategoria_precio = cpn.idcategoria_precio AND n.idniveles = cpn.idniveles";
		$resp = $this->db->consulta($sql);
		return $resp;
	}
	
	public function guardarCatPreNiveles()
	{
		$sql = "INSERT INTO categoria_precios_niveles (idcategoria_precio,idniveles,descuento) VALUES ('$this->categoria_precio','$this->niveles','$this->desc');";
		$resp = $this->db->consulta($sql);
		$this->ultimoidcatprenivel = $this->db->id_ultimo();
	}
	
	public function guardarCategoriaPrecio()
	{
		$sql = "INSERT INTO categoria_precio (nombre,estatus) VALUES ('$this->nombre','$this->estatus');";
		$resp = $this->db->consulta($sql);
		
		$this->ultimoidcategoria = $this->db->id_ultimo();
	}
	
	public function guardarNivel()
	{
		$sql = "INSERT INTO niveles (nombre,estatus) VALUES ('$this->nombre','$this->estatus');";
		$resp = $this->db->consulta($sql);
		$this->ultimoidnivel = $this->db->id_ultimo();
	}
	
	public function modificarCatPreNiveles()
	{
		$sql = "UPDATE categoria_precios_niveles SET idniveles = '$this->niveles', idcategoria_precio = '$this->categoria_precio', descuento = '$this->desc' WHERE idcategoria_precio = '$this->idcategoria_precio' AND idniveles = '$this->idniveles'";
		$resp = $this->db->consulta($sql);
	}
	
	public function modificarCategoriaPrecio()
	{
		$sql = "UPDATE categoria_precio SET nombre = '$this->nombre', estatus = '$this->estatus' WHERE idcategoria_precio = '$this->idcategoria_precio'";
		$resp = $this->db->consulta($sql);
	}
	
	public function modificarNivel()
	{
		$sql = "UPDATE niveles SET nombre = '$this->nombre', estatus = '$this->estatus' WHERE idniveles = '$this->idniveles'";
		$resp = $this->db->consulta($sql);
	}
	
	public function buscarCategoriaPrecio()
	{
		$sql = "SELECT * FROM categoria_precio WHERE idcategoria_precio = '$this->idcategoria_precio'";
		
		$resp = $this->db->consulta($sql);
		return $resp;
	}
	
	public function buscarNivel()
	{
		$sql = "SELECT * FROM niveles WHERE idniveles = '$this->idniveles'";
		$resp = $this->db->consulta($sql);
		return $resp;
	}
	
	public function buscarCategoriaPrecioNiveles()
	{
		$sql = "SELECT * FROM categoria_precios_niveles WHERE idniveles = '$this->idniveles' AND idcategoria_precio = '$this->idcategoria_precio'";
		$resp = $this->db->consulta($sql);
		return $resp;
	}
	
	public function eliminarCategoriaPrecioNiveles()
	{
		$sql = "DELETE FROM categoria_precios_niveles WHERE idcategoria_precio = '$this->idcategoria_precio' AND idniveles = '$this->idniveles'";
		$this->db->consulta($sql);
	}
}
?>