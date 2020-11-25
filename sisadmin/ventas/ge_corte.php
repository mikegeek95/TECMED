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
	
	//Recibo el id del corte
	$idcorte = $_POST['idcorte'];
	
	$idsucursales = $_SESSION['se_sas_Sucursal'];
	$idusuarios = $se->obtenerSesion('se_sas_Usuario');
	
	$fecha_actual = $fec->fechaaYYYY_mm_dd_guion();
	$hora_actual = $fec->hh_mm_ss();
	
	//Buscamos el corte activo
	$c->idcorte = $idcorte;
	$result_corte = $c->buscarCorteporID();
	$result_corte_row = $db->fetch_assoc($result_corte);
	$result_corte_num = $db->num_rows($result_corte);
	
	$f_inicio = $result_corte_row['f_inicio'];
	$caja_chica = $result_corte_row['cajachica'];
	$sucursal = $result_corte_row['idsucursales'];
	
	$c->f_inicio = $f_inicio;
	$c->f_actual = $fecha_actual;
	$c->sucursal = $sucursal;
	
	//Obtenemos la cantidad de dinero que hay en caja desde que la caja fue abierta hasta la fecha actual (CIERRE)
	$result_caja = $c->obtenercantidadenCaja();
	$total_caja = $result_caja['total'];
	
	$result_efectivo = $c->obtenerEfectivo();
	$efectivo = $result_efectivo['total'];
	
	if($efectivo == ''){
		$efectivo = '0.00';
	}
	
	$result_tc = $c->obtenerTarjeta();
	$tarjeta = $result_tc['total'];
	
	if($tarjeta == ''){
		$tarjeta = '0.00';
	}
	
	$result_virtual = $c->obtenerVirtual();
	$virtual = $result_virtual['total'];
	
	if($virtual == ''){
		$virtual = '0.00';
	}
	
	$result_transfer = $c->obtenerTrasfer();
	$transfer = $result_transfer['total'];
	
	if($transfer == ''){
		$transfer = '0.00';
	}
	
	$result_deposito = $c->obtenerDeposito();
	$deposito = $result_deposito['total'];
	
	if($deposito == ''){
		$deposito = '0.00';
	}
	
	$result_cheque = $c->obtenerCheque();
	$cheque = $result_cheque['total'];
	
	if($cheque == ''){
		$cheque = '0.00';
	}
	
	//if($total_caja != '')
	//{	
		$total_caja = $total_caja + $caja_chica;
		$ganancia = $total_caja - $caja_chica;	
	
		//$efectivo = $efectivo + $caja_chica;
	
		//cerramos caja
		$c->f_corte = $fecha_actual;
		$c->h_corte = $hora_actual;
		$c->cajacorte = $total_caja;
		$c->cajafinal = $ganancia;
		$c->efectivo = $efectivo;
		$c->tarjeta = $tarjeta;
		$c->virtual = $virtual;
		$c->transfer = $transfer;
		$c->deposito = $deposito;
		$c->cheque = $cheque;
		
		$c->cerrarCaja();
		
		$md->guardarMovimiento(utf8_decode('Cortes'),'cortes',utf8_decode('Cierra de caja con el ID :'.$idcorte));
		
		$db->commit();
		echo 1;	
	//}else{
		//echo "NO ES POSIBLE CERRAR CAJA, NO EXISTEN VENTAS DESDE QUE SE ABRIO LA CAJA.";
	//}
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