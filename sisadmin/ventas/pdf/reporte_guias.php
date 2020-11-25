<?php
//Importación de clases
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Ventas.php");
require_once("../../clases/fpdf/fpdf.php");
require_once("../../clases/class.Fechas.php");
require_once("../../clases/class.Guias_pedidos.php");
require_once("../../clases/class.Configuracion.php");
require_once("../../clases/class.Sesion.php");
require_once("../../clases/class.Sucursales.php");
      
//Declaraciones de objetos de clase
$se = new Sesion();
$db = new MySQL ();
$fecha = new Fechas ();
$ventas = new Ventas();
$gu = new Guias_pedido();
$conf = new Configuracion();
$su = new Sucursales();

//Enviamos la conexión a las clases que lo requieren
$ventas->db = $db ;
$conf->db = $db;
$gu->db = $db;

//Recibimos parametro
$idnota_remision = $_GET['id'];

$gu->idnota_remision = $idnota_remision;

//Realizamos consultas
$ventas->id_notaremision = $idnota_remision;
$datos = $ventas->verDatosReciboCaja();
$cliente = $ventas->verClientePedido();
 
 
$result = $gu->todas_guias_pedido();
$result_num = $db->num_rows($result);
$result_row = $db->fetch_assoc($result);
 
//Establecemos el tamaño del PDF
$pdf =& new FPDF ('P', 'mm', 'media');


$pdf->AddPage();
$pdf->SetMargins(10,1,0);
$pdf->SetFont('Arial','B',16);
$pdf->SetFontSize(15);
$pdf->SetX(2);
$pdf->Ln(5);

// Centered text in a framed 20*10 mm cell and line break

$pdf->Cell(140,7,"No. PEDIDO: ".$ventas->id_notaremision,0,0);
$pdf->Cell(40,7,"ESTATUS: ".strtoupper($estatus[$datos['estatus']]),0,0);

$pdf->Ln(10);

if ($cliente['clientes'] != "")
{
	$clientes = $cliente['clientes'];
}else{
	$clientes = "PUBLICO GENERAL"; 
}

$fecha_pedido = explode(" ",$datos['fechapedido']);

$pdf->Cell(140,7,"NOMBRE:".($clientes),0,0);
$pdf->Cell(40,7,"FECHA: ".strtoupper($fecha_pedido[0]),0,0);

$pdf->Ln(10);

$pdf->MultiCell(180,7,utf8_decode("DIRECCIÓN ENVÍO: ").strtoupper($cliente['direccion_envio']),0,'L');

$pdf->Ln(15);

$pdf->SetFontSize(13);
$pdf->Cell(60,7,"LISTA",1,0,'C');
$pdf->Cell(60,7,utf8_decode("GUÍA"),1,0,'C');
$pdf->Cell(70,7,utf8_decode("PAQUETERÍA"),1,0,'C');

$pdf->Ln(7);

$count = 0001;
if($result_num != 0){
	do
	{
		
		$pdf->Cell(60,7,$count,1,0,'C');
		$pdf->Cell(60,7,$result_row['idguias'],1,0,'C');
		$pdf->Cell(70,7,$result_row['nombre'],1,0,'C');
		
		$pdf->Ln(7);
		
		$count++;
	}while($result_row = $db->fetch_assoc($result));
}
$pdf->Output();
?>