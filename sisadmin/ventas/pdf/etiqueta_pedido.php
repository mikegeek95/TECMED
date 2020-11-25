<?php
//Importación de clases
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Ventas.php");
require_once("../../clases/fpdf/fpdf.php");
require_once("../../clases/class.Fechas.php");
require_once("../../clases/class.Configuracion.php");
require_once("../../clases/class.Sesion.php");
require_once("../../clases/class.Sucursales.php");
require_once("../../clases/class.Funciones.php");
      
//Declaraciones de objetos de clase
$se = new Sesion();
$db = new MySQL ();
$fecha = new Fechas ();
$ventas = new Ventas();
$conf = new Configuracion();
$su = new Sucursales();
$f = new Funciones();

//Enviamos la conexión a las clases que lo requieren
$ventas->db = $db ;
$conf->db = $db;

//Recibimos parametro
$idnota_remision = $_GET['id'];

//Realizamos consultas
$ventas->id_notaremision = $idnota_remision;
$datos = $ventas->verDatosReciboCaja();
$cliente = $ventas->verClientePedido();
 
//Establecemos el tamaño del PDF
$pdf =& new FPDF ('P', 'mm', 'media');


$pdf->AddPage();
$pdf->SetMargins(2,1,0);
$pdf->SetFontSize(24);
$pdf->SetX(2);
$pdf->Ln(35);
//$pdf->Cell(40,3,utf8_decode("NO. PEDIDO : ").$ventas->id_notaremision);
$pdf->MultiCell(55,10,"No. PEDIDO: ".$ventas->id_notaremision,0,'C');
$pdf->Ln(10);

if ($cliente['clientes'] != "")
{
	$clientes = $cliente['clientes'];
}else{
	$clientes = "PUBLICO GENERAL"; 
}

$pdf->MultiCell(55,10,($clientes),0,'C');
$pdf->Ln();

$pdf->Output();
?>