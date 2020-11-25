<?php
require_once('../../clases/conexcion.php');
require_once('../../clases/class.Gastos.php');
require_once('../../clases/class.MovimientoBitacora.php');
require_once('../../clases/class.Funciones.php');


$db = new MySQL(); 
$gas = new Gastos();
$md = new MovimientoBitacora();
$f= new Funciones();



try
{
	
$gas->db = $db;
$md->db = $db;
$db->begin();


$gas->idgastos_detalles = $f->guardar_cadena_utf8($_POST['idgasto']);
$gas->idgastos_categoria= $f->guardar_cadena_utf8($_POST['v_cod_gasto']);
$gas->estatus = $f->guardar_cadena_utf8($_POST['v_estatus']);
$gas->fechadelgasto =  $f->guardar_cadena_utf8($_POST['v_fechaingreso']);
$gas->descripcion_gasto =  $f->guardar_cadena_utf8($_POST['v_descripcion']);
$gas->montodelgasto = $f->guardar_cadena_utf8($_POST['v_monto']);

	if($gas->idgastos_detalles==0){
		
		$gas->GuardarIngresoGasto();
		$md->guardarMovimiento(utf8_decode('Gastos'),'gastos',utf8_decode('se agrego una Ingreso de Gasto con el id '.$gas->ultimoIDGastoDetalles));
	}
	else{
		$gas->ModificarIngresoGasto();
		$md->guardarMovimiento(utf8_decode('Gastos'),'gastos',utf8_decode('se Modifico el Movimiento del Gasto con el id '.$gas->idgastos_detalles));
	}
	
$db->commit();
echo 1;
}
catch(Exception $e)
{
	echo 'error MySQL '.$e;
    $db->rollback();
}



?>