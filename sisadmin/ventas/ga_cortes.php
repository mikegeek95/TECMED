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
require_once('../clases/class.MovimientoBitacora.php');
require_once("../clases/class.Corte.php");
require_once("../clases/class.Fechas.php");

try

{

	$db= new MySQL();
	$md = new MovimientoBitacora();
	$c = new Cortes();
	$fec = new Fechas();
	
	$c->db = $db;
	$md->db = $db;
	
	$db->begin();
	
	$idusuarios = $se->obtenerSesion('se_sas_Usuario');
	//Recibimos parametros
	$caja_chica = $_POST['caja_chica'];
	$sucursal = $_POST['sucursal'];
	
	$fecha_actual = $fec->fechaaYYYY_mm_dd_guion();
	$hora_actual = $fec->hh_mm_ss();
		
	$c->caja_chica = $caja_chica;
	$c->sucursal = $sucursal;
	$c->f_inicio = $fecha_actual;
	$c->h_inicio = $hora_actual;
	$c->idusuarios = $idusuarios;
	
	
	//Antes de iniciar caja validamos que no se puedan iniciar dos veces caja en una misma fecha mientras este activa una
	
	$result_caja = $c->buscarCajaenCorte();
	$result_caja_num = $db->num_rows($result_caja);
	$result_caja_row = $db->fetch_assoc($result_caja);	
	
	if($result_caja_num == 0){
		$c->iniciarCaja();
		$md->guardarMovimiento(utf8_decode('Cortes'),'cortes',utf8_decode('Nuevo Inicio de caja creado con el ID :'.$c->ultimoidcaja));
		
	
	
	
	
		$db->commit();
		echo 1;	
	}else{
		echo "NO ES POSIBLE INICIAR CAJA, DEBIDO A QUE NO SE HA GENERADO EL CORTE NO. ".$result_caja_row['idcorte'];
	}
}
catch(Exception $e)
{
	$db->rollback();
	$v = explode ('|',$e);
	// echo $v[1];
	 $n = explode ("'",$v[1]);
	 $n[0];
	$result = $db->m_error($n[0]);
	echo $result ;
}

?>