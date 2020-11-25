<?php
/*=============================*
 *  Proyecto: CALZADO DAYANARA *
 *     CAPSE - 12/02/2019      *
 * I.S.C José Carlos Santillán *
 *=============================*/

//Importamos clase de sesión y declaramos el objeto de la clase
require_once("../clases/class.Sesion.php");
$se = new Sesion();

//Validamos si esta iniciada la sesion para poder continuar
if(!isset($_SESSION['se_SAS']))
{
	//Si no esta iniciada la sesion, enviamos a login.
	header("Location: ../login.php");
	exit;
}

//Importamos las clases que se van a utilizar
require_once("../clases/conexcion.php");
require_once("../clases/class.Ventas.php");
require_once('../clases/class.MovimientoBitacora.php');


//Declaramos los objetos de clase
$db = new MySQL ();
$ve = new Ventas();
$md = new MovimientoBitacora();


//Enviamos el objeto de conexión a la clase que lo requiere
$ve->db = $db;
$md->db = $db;

//Recibimos parametros por metodo POST
$idnota_remision = $_POST['idnota_remision'];
$idproducto = $_POST['idproducto'];
$idtallas = $_POST['idtallas'];

try{
	
	$db->begin();
	
	$ve->id_notaremision = $idnota_remision;
	$ve->idproduct = $idproducto;
	$ve->idtallas = $idtallas;
	$ve->id_NuevoNotaRemision = $idnota_remision;
	
	$ve->eliminar_de_nota();
	$md->guardarMovimiento(utf8_decode('nota_descripcion'),'nota_descripcion',utf8_decode('Se elimino de la nota #:'.$idnota_remision.' el producto con id: '.$idproducto.' y talla: '.$idtallas));
	
	
	$result_totales = $ve->obtenerTotalesVenta();
	
	$descuento = $result_totales['descuento'];
	$total = $result_totales['total'];
	$subtotal = number_format($result_totales['total']/1.16,2,'.',',');
	$iva = number_format(($total - $subtotal),2,'.',',');

	$ve->desc_producto = $descuento;
	$ve->total = $total;
	$ve->subtotal = $subtotal;
	$ve->iva = $iva;

	//Actualizamos totales
	$ve->actualizarTotales();
	
	$db->commit();
	
	echo 1;
	
}catch(Exception $e){
	
	$db->rollback();
	$v = explode ('|',$e);
	// echo $v[1];
    $n = explode ("'",$v[1]);
	$n[0];
	$result = $db->m_error($n[0]);
	echo $result;
	
}
?>