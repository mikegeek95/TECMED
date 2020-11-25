<?php
require_once("../clases/class.Sesion.php");
require_once("../clases/conexcion.php");
require_once("../clases/class.Ventas.php");
require_once("../clases/class.ShoppingCar.php");
require_once("../clases/class.Configuracion.php");
require_once('../clases/class.MovimientoBitacora.php');
require_once('../clases/class.Fechas.php');

$sesion = new Sesion();


try
{
	$db = new MySQL();
	$db->begin();
	
	$idorden = $_POST['idorden'];
	$clave = $_POST['clave'];
	$permiso = "si";

	$sql = "SELECT * FROM configuracion WHERE clave_caja = '$clave'";
	$result_sql = $db->consulta($sql);
	$result_sql_num = $db->num_rows($result_sql);
	
	if($result_sql_num != 0){	

	//$db->commit();	

		echo "1|".$idorden;
	}else{
		echo "0|".$idorden;
	}

}catch(Exception $e) {
  $db->rollback();	
  $v = explode ('|',$e);
  $n = explode ("'",$v[1]);
  echo "Se hizo rollback ". $db->m_error($n[0]);   }

?>