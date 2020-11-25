<?php
class Sesion 
{
	//funcion contructora de la clase
	public function Sesion() 
	{
		if(!isset($_SESSION))
		{
			session_start();

			//$inactivo = 20;
		 	$inactivo = 28800;
		 
			if(isset($_SESSION['tiempo']) ) {
			$vida_session = time() - $_SESSION['tiempo'];
				if($vida_session > $inactivo)
				{
					session_destroy();
					//header("Location: login.php");
					/*echo '<script type="text/javascript">iraLogin();</script>'; */
				}
			}
		 
			$_SESSION['tiempo'] = time();
		}
		
		//echo $vida_session." - ".$inactivo."  ".$_SESSION['tiempo']." sd";

	}
	//funcion para crear una nueva varibles de secion y asignar un valor
	public function crearSesion($nombre, $valor) 
	{
		$_SESSION [$nombre] = $valor;
	}
	//funcion que busca y regresa el valor de una varibles de sesion
	public function obtenerSesion($nombre)
	{
		if (isset ( $_SESSION [$nombre] ))
		{
			return $_SESSION [$nombre];
		}
		else
		{
			return false;
		}
	}
	//funcion para eliminar una sesion
	public function eliminarSesion($nombre)
	{
		unset ($_SESSION [$nombre] );
	}
	
	//funcion para matar todas la varibles de sesion que existan
	public function terminarSesion() 
	{
		$_SESSION = array();
		session_destroy ();
	}
}
?>