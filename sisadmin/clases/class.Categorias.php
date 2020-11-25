<?php
class Categoria
{
	public $db;//objeto de la clase de conexcion
	public $id_categoria;//identificador de la categoria
	public $nombre;//nombre de la categoria
	public $descripcion;//descripcion de la categoria
	public $depende;//dependiente, valor numerico 
	public $estatus;
	public $nivel;



	public $comentario;
	
	public $subcat;
	public $categoria;

	public $opciones;//para traer la cadena que se imprimira a lo ultimo 
	
	
	public function Categoria()
	{
			
		$this->opciones ="";
		
	}
	
	
	//funcion para guardar los estados 
	
	public function GuardarCategoria()
	{
		$query="INSERT INTO categorias (nombre,descripcion,nivel) VALUES ('$this->nombre','$this->descripcion','$this->nivel');";
		//die($query);
		$resp=$this->db->consulta($query);
		$this->id_categoria = $this->db->id_ultimo();
		
		
		
	}
	public function GuardarSubCategoria()
	{
		$query="INSERT INTO subcategoria (idcategoria,nombre,descripcion,estatus) VALUES ('$this->categoria','$this->nombre','$this->comentario','$this->estatus');";
		//die($query);
		$resp=$this->db->consulta($query);
		$this->subcat = $this->db->id_ultimo();
		
		
		
	}
	//funcion para modificar estado
	public function ModificarCategoria()
	{
		$query="UPDATE categorias SET  nombre='$this->nombre' , descripcion='$this->descripcion' ,  estatus = '$this->estatus', nivel = '$this->nivel'  WHERE idcategoria='$this->id_categoria'";
		//die($query);
		$resp=$this->db->consulta($query);
	}
	public function ModificarSubCategoria()
	{
		$query="UPDATE subcategoria SET  idcategoria='$this->categoria' , descripcion='$this->comentario' , nombre= '$this->nombre', estatus = '$this->estatus'   WHERE idsubcategoria='$this->subcat'";
		//die($query);
		$resp=$this->db->consulta($query);
	}
	
	///funcion para objeter datos de un usuario
	public function ObtenerDatosCategoria()
	{
		$query="SELECT * FROM categorias WHERE idcategoria=".$this->id_categoria;
		$resp=$this->db->consulta($query);
		$rows=$this->db->fetch_assoc($resp);
		$total = $this->db->num_rows($resp);
		//echo $total;
		return $rows;
	}
	
	
	
	
	public function lista($idcategoria,$nivel,$seleccionado)
	 {
		 
		$query= "SELECT * FROM subcategoria where idsubcategoria = '$idcategoria' AND estatus = '1'";
		$resp = $this->db->consulta($query);
		$fila = $this->db->fetch_assoc($resp);
		
		$espacio = "";
		
		for($x=1 ; $x<=$nivel ; $x++)
		{
			$espacios = $espacios."&nbsp;&nbsp;";
		}
		
			if($fila['depende'] == 0)
			{
			
				//$desactivado = ' disabled="disabled" ';
				$desactivado = "";
			}
			
			else 
			{
				$desactivado = "";
			}
			if($fila['idcategoria'] == $seleccionado )
			    {
				   $selec = ' selected="selected" ';
				}else
				{
					$selec='';
				}
				
			
			
		echo '<option'.$desactivado.' value="'.$fila['idsubcategoria'].'" '.$selec.' >'.$espacios.' '.$fila['nombre'].' '.'</option>';
		
		
		$query2= "SELECT * FROM subcategoria where  estatus = '1'";
		$resp2 = $this->db->consulta($query2);
		$fila2 = $this->db->fetch_assoc($resp2);
		$fila2_num = $this->db->num_rows($resp2);
		
		 if($fila2_num != 0)
		{
					
				do
				{
				 
				   $this->lista($fila2['idsubcategoria'],$nivel+1,$seleccionado);
					
				}while($fila2 = $this->db->fetch_assoc($resp2));
		}else
		{
			
			   $nivel-1;
			
			 
		}
		
		
			
	}
	
	
	
	public function lista_sub($idcategoria,$nivel,$seleccionado)
	 {
		 
		$query= "SELECT * FROM categorias where idcategoria = $idcategoria";
		$resp = $this->db->consulta($query);
		$fila = $this->db->fetch_assoc($resp);
		
		$espacio = "";
		
		for($x=1 ; $x<=$nivel ; $x++)
		{
			$espacios = $espacios."&nbsp;&nbsp;";
		}
		
			
		
			
			if($fila['idcategoria'] == $seleccionado )
			    {
				   $selec = ' selected="selected" ';
				}else
				{
					$selec='';
				}
				
			
			
		echo '<option'.$desactivado.' value="'.$fila['idcategoria'].'" '.$selec.' >'.$espacios.' '.$fila['nombre'].' '.'</option>';
		
		
		$query2= "SELECT * FROM categorias where depende = $idcategoria";
		$resp2 = $this->db->consulta($query2);
		$fila2 = $this->db->fetch_assoc($resp2);
		$fila2_num = $this->db->num_rows($resp2);
		
		 if($fila2_num != 0)
		{
					
				do
				{
				 
				   $this->lista($fila2['idcategoria'],$nivel+1,$seleccionado);
					
				}while($fila2 = $this->db->fetch_assoc($resp2));
		}else
		{
			
			   $nivel-1;
			
			 
		}
		
		
			
	}
			
		public function obtenersubcategorias($id)
	{
		$query="select * from subcategoria where idcategoria='$id'";
		//die($query);
		$resp=$this->db->consulta($query);
		return $resp;
	} 
	
		public function buscar_subcat($id)
	{
		$query="select * from subcategoria where idsubcategoria='$id'";
		//die($query);
		$resp=$this->db->consulta($query);
		return $resp;
	} 
		 
	
}
?>