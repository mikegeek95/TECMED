<?php

require_once ("../../clases/conexcion.php");

require_once ("../../clases/class.Compras.php");
require_once ("../../clases/class.Funciones.php");

require_once('../../clases/class.MovimientoBitacora.php');



try {



$compra = new Compras ();

$db = new MySQL ();
$f=new Funciones();
$md = new MovimientoBitacora ();



$compra->db = $db ;
$md->db=$db;


$compra->fecha_compra = $f->guardar_cadena_utf8($_POST['fecha_c']);

$compra->estatus = $f->guardar_cadena_utf8($_POST['estatus']);

$compra->prioridad = $f->guardar_cadena_utf8($_POST['prioridad']);

$compra->descripcion = $f->guardar_cadena_utf8($_POST['descripcion']);
	
$compra->sucursal = $f->guardar_cadena_utf8($_POST['sucursal']);
	
$compra->id_compra = $f->guardar_cadena_utf8($_POST['id']);

//echo $compra->idusuarios.$compra->fecha_compra.$compra->prioridad.$compra->estatus.$compra->descripcion.$compra->id_compra;

//exit;

$compra->modificarCompra();

$md->guardarMovimiento(utf8_decode('Compras'),'compras',utf8_decode('Se modifico la compra con el id :'.$compra->id_compra));


echo "1";
 



}

catch (Exception $e)

{

	echo "Error:".$e;

}









?>