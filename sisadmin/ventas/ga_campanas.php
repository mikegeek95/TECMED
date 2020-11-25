<?php
require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}

require_once("../clases/conexcion.php");
require_once("../clases/class.Campanas.php");
require_once('../clases/class.MovimientoBitacora.php');


try

{

	$db = new MySQL();
	$cam = new Campanas();
	$md = new MovimientoBitacora();

	$cam->db = $db;
	$md->db = $db;
	
	$db->begin();

	//enviamos datos a las variables de la tablas	
	$cam->nombre = utf8_decode($_POST['v_nombre']);
	$cam->fecha_inicio = utf8_decode($_POST['v_fecha_inicio']);
	$cam->fecha_fin = $_POST['v_fecha_fin'];
	$cam->idsobrepedido_camp = $_POST['v_id'];
	

	if($cam->idsobrepedido_camp == 0){
		//guardando
		$cam->guardar_campana();
		$md->guardarMovimiento(utf8_decode('Sobrepedido_camp'),'sobrepedido_camp',utf8_decode('Nueva Campaña sobre pedido con el ID :'.$cam->idsobrepedido_camp));
	}else{
		$cam->modificar_campana();
		$md->guardarMovimiento(utf8_decode('Sobrepedido_camp'),'sobrepedido_camp',utf8_decode('Se modifico Campaña sobre pedido con el ID :'.$cam->idsobrepedido_camp));
	}

	$db->commit();
	echo 1;

}catch(Exception $e){

	$db->rollback();
	$v = explode ('|',$e);

		// echo $v[1];

	     $n = explode ("'",$v[1]);

		 $n[0];

	$result = $db->m_error($n[0]);

	echo $result ;


}

?>