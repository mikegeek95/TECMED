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
require_once("../clases/class.Ventas.php");
require_once('../clases/class.MovimientoBitacora.php');


try
{
	$db = new MySQL();
	$ven = new Ventas();
	$md = new MovimientoBitacora();
	
	$ven->db = $db;
	$md->db = $db;
		
	
	$idsucursales = $_SESSION['se_sas_Sucursal'];

	
	$db->begin();
	
	//enviamos datos a las variables de la tablas
	$hora = $_POST['hora'];
	$minutos = $_POST['minutos'];
	$fecha_deposito = $_POST['fecha_deposito']." ".$hora.":".$minutos.":00";
	$referencia = utf8_decode($_POST['referencia']);
	$monto = $_POST['monto'];
	$banco = utf8_decode($_POST['banco']);
	$idnota_remision_depositos = $_POST['idnota_remision_depositos'];
	$idnota_remision = $_POST['idnota_remision'];
	
	$ven->fecha_deposito = $fecha_deposito;
	$ven->referencia = $referencia;
	$ven->monto = $monto;
	$ven->banco = $banco;
	$ven->idnota_remision_depositos = $idnota_remision_depositos;
	$ven->id_notaremision = $idnota_remision;
	
	if($ven->idnota_remision_depositos == 0){
		$ven->guardar_deposito();
		$md->guardarMovimiento(utf8_decode('nota_remision_depositos'),'nota_remision_depositos',utf8_decode('Nuevo deposito creado con el ID :'.$ven->idnota_remision_depositos));
	}else{
		$ven->modificar_deposito();
		$md->guardarMovimiento(utf8_decode('nota_remision_depositos'),'nota_remision_depositos',utf8_decode('Modificacion de deposito creado con el ID :'.$ven->idnota_remision_depositos));
	}	
	
	$db->commit();
	echo 1;
}
catch(Exception $e)
{
	$db->rollback();
	     $v = explode ('|',$e);

		// echo $v[1];

	     $n = explode ("'",$v[1]);

		 $n[0];

		 echo $db->m_error($n[0]);	
}
?>