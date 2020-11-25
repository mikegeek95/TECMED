<?php

class Proveedor

{

	public $db;//objeto de la clase de conexcion
	public $id_proveedores;//identificador del proveedor
	public $nombre;//nombre del proveedor
	public $direccion;//direccion del proveedor
	public $telefono;//telefono del proveedor
	public $email;//email del proveedor
	public $contacto;//contacto del proveedor
	public $url;


	//funcion para guardar los estados 


	public function GuardarProveedor()
	 {
		$query="INSERT INTO proveedores (nombre,direccion,telefono,email,contacto,url) VALUES ('$this->nombre','$this->direccion','$this->telefono','$this->email','$this->contacto','$this->url')";

		$resp=$this->db->consulta($query);
		$this->id_proveedores = $this->db->id_ultimo();
     }

	//funcion para modificar estado

	public function ModificarProveedor()
	{
		$query="UPDATE proveedores SET  nombre='$this->nombre' , direccion='$this->direccion' , telefono='$this->telefono' , email='$this->email' , contacto='$this->contacto', url = '$this->url'  WHERE idproveedores=$this->id_proveedores";
		$resp=$this->db->consulta($query);

	}

	

	///funcion para objeter datos de un usuario

	public function ObtenerDatosProveedores()

	{

		$query="SELECT * FROM proveedores WHERE idproveedores=".$this->id_proveedores;
		$resp=$this->db->consulta($query);
		$rows=$this->db->fetch_assoc($resp);
		$total = $this->db->num_rows($resp);
		return $rows;

	}
	
	
		public function ObtenerDatosProveedores_Fetch()
		{
			$query="SELECT * FROM proveedores";
			$resp = $this->db->consulta($query);
			return $resp;
	    }

	

	

}

?>