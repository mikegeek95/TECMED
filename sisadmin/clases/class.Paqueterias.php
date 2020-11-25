<?php
class Paqueterias
{
	public $db;
	public $idpaqueterias;
	public $nombre;
	public $direccion;
	public $email;
	public $tel;
	public $estatus;
	public $urlrastreo;
	
	
	//Funcion que sirve para buscar una paqueteria
	public function buscar_paqueteria()
	{
		$sql = "SELECT * FROM paqueterias WHERE idpaqueterias = '$this->idpaqueterias'";
		$result = $this->db->consulta($sql);
		return $result;
	}
	
	//Funcion que sirve para guardar una paqueteria
	public function guardar_paqueteria()
	{
		$sql = "INSERT INTO paqueterias (nombre,direccion,email,tel,estatus,urlrastreo) VALUES ('$this->nombre','$this->direccion','$this->email','$this->tel','$this->estatus','$this->urlrastreo');";
		$this->db->consulta($sql);
		$this->idpaqueterias = $this->db->id_ultimo();
	}
	
	//Funcion que sirve para modifcar una paqueteria
	public function modificar_paqueteria()
	{
		$sql = "UPDATE paqueterias SET nombre = '$this->nombre', direccion = '$this->direccion', email = '$this->email', tel = '$this->tel', estatus = '$this->estatus', urlrastreo = '$this->urlrastreo' WHERE idpaqueterias = '$this->idpaqueterias'";
		$this->db->consulta($sql);
	}
	
	public function obtener_activas()
	{
		$sql = "SELECT * FROM paqueterias WHERE estatus = '1'";
		$result = $this->db->consulta($sql);
		return $result;
	}
}
?>