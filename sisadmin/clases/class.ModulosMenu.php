<?php
class ModulosMenu
{
	public $db;//objeto de la clase de texto
	
	//varibles para dar de alta los modulos
	public $modulo;//nombre del modulo
	public $estatusmodulo;//estatus del modulo
	public $idmodulo;//id del modulo para el caso de modificacion y mostrado de informacion
	public $nivel;
	public $icono;
	//varibles para el alta de un nuevo menu
	public $menu;//nombre del menu
	public $archvio;//nombre del archivo
	public $ubi_archivo;//ruta donde se encuentra el archivo
	public $estatusMenu;//estatus del menu
	public $idmenu;//id del menu para casos de modificacion y mostrado de informacion
	
	//funcion para darte alta un nuevo modulo
	public function GuardarNewModulo()
	{
		$query="INSERT INTO modulos(modulo,estatus,nivel,icono)VALUES('$this->modulo',$this->estatusmodulo,$this->nivel,'$this->icono')";
		$resp=$this->db->consulta($query);		
	}
	
	//funcion para modificar los modulos
	public function ModificarModulos()
	{
		$query="UPDATE modulos SET modulo='$this->modulo',estatus=$this->estatusmodulo,nivel = $this->nivel,icono='$this->icono'  WHERE idmodulos=$this->idmodulo";
		$resp=$this->db->consulta($query);
	}
	
	//funcion para obtener la informacion de un modulo
	public function ObtenerInfoModulo()
	{
		$query="SELECT * FROM modulos WHERE idmodulos=$this->idmodulo";
		$resp=$this->db->consulta($query);
		$rows=$this->db->fetch_assoc($resp);
		$total=$this->db->num_rows($resp);
		
		if($total!=0)
		{
			return $rows;
		}
		else
		{
			return 0;
		}
	}
	
	/********************************************************************/
	
	//funcion para dar de alta un nuevo menu
	public function GuardarNewMenu()
	{
		$query="INSERT INTO modulos_menu(idmodulos,menu,archivo,ubicacion_archivo,nivel,estatus,icono)VALUES($this->idmodulo,'$this->menu','$this->archvio','$this->ubi_archivo',$this->nivel,$this->estatusMenu,'$this->icono')";
		$resp=$this->db->consulta($query);	
	}
	
	//funcion para modificar lainformacion de un menu
	public function ModificarMenu()
	{
		$query="UPDATE modulos_menu SET idmodulos=$this->idmodulo,menu='$this->menu',archivo='$this->archvio',ubicacion_archivo='$this->ubi_archivo',nivel=$this->nivel,estatus=$this->estatusMenu,icono='$this->icono' WHERE idmodulos_menu=$this->idmenu";
		
		$resp=$this->db->consulta($query);	
	}
	
	//function para obtener la informacion de un menu
	public function ObtenerInfoMenu()
	{
		$query="SELECT * FROM modulos_menu WHERE idmodulos_menu=$this->idmenu";
		$resp=$this->db->consulta($query);
		$rows=$this->db->fetch_assoc($resp);
		$total=$this->db->num_rows($resp);
		
		if($total!=0)
		{
			return $rows;
		}
		else
		{
			return 0;
		}
	}
}
?>