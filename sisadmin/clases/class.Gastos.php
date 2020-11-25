<?php
class Gastos
{
	public $db;//objeto de conecxion con la base de datos
	
	public $ultimoIDGasto;//ultimo id ultimo gasto
	public $ultimoIDGastoDetalles; //ultimo id gasto detalles
	
	//datos del empleado
	
	public $idgastos_categoria;
	public $categoria;
	public $descripcion;
	public $tipo;
	public $estatus;
	
	
	
	//datos para poder ingresar los gastos
	
	public $idgastos_detalles;
	public $fechadelgasto;
	public $descripcion_gasto;
	public $montodelgasto;
	
	
	
	
	
	
	//funcion para guarda una nueva empresas
	public function GuardarNewGasto()
	{
		$query="INSERT INTO gastos_categorias(categoria,descripcion,tipo) VALUES ('$this->categoria','$this->descripcion',$this->tipo)";
		
		$result=$this->db->consulta($query);
		$this->ultimoIDGasto= $this->db->id_ultimo();
	}
	
	
	//funcion para modificar los datos de la empresas
	public function ModificarGasto()
	{
		$query="UPDATE gastos_categorias SET 
		categoria = '$this->categoria',	
		descripcion = '$this->descripcion',
		tipo = '$this->tipo',
		estatus = '$this->estatus'
		WHERE idgastos_categorias='$this->idgastos_categoria'";
		
		$result = $this->db->consulta($query);
	}
	
	

	
	//funcion para obtener la informacion del puesto
	public function ObtenerInformacionGasto()
	{
		$Query_empresa="SELECT * FROM gastos_categorias WHERE idgastos_categorias='".$this->idgastos_categoria."'";
		$resp=$this->db->consulta($Query_empresa);

		  return $resp;	
	}
	
	
	
	
	
	//funcion para guarda una nueva empresas
	public function GuardarIngresoGasto()
	{
		$query="INSERT INTO gastos_detalles(fecha,idgastos_categorias,monto,descripcion,estatus) VALUES ('$this->fechadelgasto','$this->idgastos_categoria','$this->montodelgasto','$this->descripcion_gasto','$this->estatus')";
		$result=$this->db->consulta($query);
		$idultimo = $this->db->id_ultimo();
		$this->ultimoIDGastoDetalles = $idultimo;
	}
	
	
	
	
	 public function VerGastosMes($mesactual,$anho,$tipo)
	 {
		 try
		 {
			 if($mesactual != 0)
			 {
				 $b_mes = " MONTH(fecha) = $mesactual AND";
				 
				 }else
			 {
				 $b_mes = "";
				 
				}
			 
			 if($tipo == "todo")
			 {
				 $v_tipo = "";
				 }
			 else
			 {
				$v_tipo = " AND gd.estatus = $tipo"; 
				}
			   
			 
		    $sql_cortes_mes = "SELECT gd.*,gc.categoria FROM gastos_detalles gd , gastos_categorias gc WHERE  $b_mes YEAR(fecha) = $anho AND gd.idgastos_categorias = gc.idgastos_categorias $v_tipo";
			$result_corte = $this->db->consulta($sql_cortes_mes);	
						   	
			 $rows_array = array();

			 while($result= $this->db->fetch_object($result_corte))
				{
				  $rows_array[] = $result;
				}
			
			
			return $rows_array;
		  
		   
		 }// fin de try
		 catch (Exception $e)
		 {
			 echo $e;
			 
		 }// fin de catch
	 }// fin de guardarMovimiento
	
	
	
	
	 public function VerGastosDatos($idgasto)
	 {
		 try
		 {
			 
		    $sql = "SELECT gc.categoria , gd.*   FROM gastos_categorias gc, gastos_detalles gd WHERE gc.idgastos_categorias = gd.idgastos_categorias AND  idgastos_detalles = " .$idgasto;
			$result = $this->db->consulta($sql);	
			$result_gasto = $this->db->fetch_assoc($result);
           //$result_gasto_num = $db->num_rows($result);			   	
			return $result_gasto;	   
		   
		 }// fin de try
		 catch (Exception $e)
		 {
			 echo $e;
			 
		 }// fin de catch
	 }// fin de guardarMovimiento
	
	
	public function ModificarIngresoGasto()
	{
		$query="UPDATE gastos_detalles SET
		fecha= '$this->fechadelgasto',
		idgastos_categorias = '$this->idgastos_categoria',
		monto = $this->montodelgasto,
		descripcion = '$this->descripcion_gasto',
		estatus = '$this->estatus'
		WHERE idgastos_detalles = $this->idgastos_detalles";
		
		$result=$this->db->consulta($query);
	}
	
	
	
	
	
		
}
?>