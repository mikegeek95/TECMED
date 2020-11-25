<?php
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Credito.php");
require_once("../../clases/fpdf/fpdf.php");
require_once("../../clases/class.Fechas.php");
require_once("../../clases/class.Configuracion.php");


$db = new MySQL ();
$credito = new creditos ();
$fecha = new Fechas ();
$conf = new Configuracion();

$credito->db = $db ;
$conf->db = $db;

$credito->idcretdito = $_GET['id'];
$comprobante = $credito->obtenerDatosCreditoComprobante();
$deuda = $credito->obtenerDeuda();
$pagos = $credito->totalPagos();


class PDF extends FPDF

{
	
	public $empresa;
	public $direccion;
	public $telefono;
	public $email;
	public $www;

// Cabecera de página

function Header()

{

	//$id = $_GET['id'];

	

    // Logo

    

    // Arial bold 15

	$this->SetX(80);

    $this->SetFont('Arial','B',20);

    // Movernos a la derecha

   

    // Título

    //$this->Cell(30,10,'ORDEN DE COMPRA',0,0,'C');

	

    // Salto de línea

	$this->Ln(18);

	

	$this->SetFont('Arial','',14);

	$this->Cell(100,5,"RECIBO DE PAGO ".$this->empresa,0,1);
	$this->Image('logo.png',150,18,33);
	$this->Cell(100,5,$this->direccion,0,1);
	$this->Cell(100,5,$this->telefono,0,1);
	$this->Cell(100,5,$this->email,0,0);
	$this->SetX(150);
	$this->Cell(100,5, utf8_decode(" "),0,1);
	$this->Line(10,50,200,50);
    $this->Ln(10);

}



// Pie de página

function Footer()

{

    // Posición: a 1,5 cm del final

    $this->SetY(-15);

    // Arial italic 8

    $this->SetFont('Arial','I',8);

    // Número de página

    $this->Cell(0,10,utf8_decode('Página').$this->PageNo().'/{nb}',0,0,'C');

}



//termina pie de página

}//TERMINA EXPENDEN DE PDF





// Creación del objeto de la clase heredada

$pdf = new PDF ();


//parsear la informacion de la empresa.

//datos de la empresa

$empresa = $conf->ObtenerInformacionConfiguracion();

$pdf->empresa = $empresa['nombre_empresa'];
$pdf->direccion = $empresa['direccion'];
$pdf->telefono = $empresa['telefonos'];
$pdf->email = $empresa['email'];
$pdf->www = $empresa['url'];

$pdf->AddPage();

$pdf->Cell(40,10,"FECHA: ".$fecha->fecha_texto($comprobante['fecha']));

$pdf->Ln();



$pdf->Cell(40,10,"CLIENTE: ".utf8_decode($comprobante['cliente']),0,0);

$pdf->Line(35,76,200,76);//LINEA PARA EL CAMPO CLIENTE

$pdf->Ln(12);

/*$pdf->SetXY(111,65);

$pdf->Cell(0,0,".",0,1);*/

$pdf->Cell(40,10,utf8_decode("PAGO LA CANTIDAD DE: $".$comprobante['deposito']." PESOS"),0,0);

$pdf->Line(70,88,200,88);//LINEA PARA EL CAMPO CLIENTE

$pdf->Ln(12);





$pdf->Cell(40,10,utf8_decode("Por concepto de abono de compra JOYERÍA KL de la nota de remision : ".$comprobante['idnota_remision']),0,0);



$pdf->Ln(12);





$pdf->Cell(40,10,"ADEUDO TOTAL: $".$comprobante['cantidad']." PESOS",0,0);

$pdf->Line(51,112,200,112);//LINEA PARA EL CAMPO CLIENTE

$pdf->Ln(12);





$pdf->Cell(40,10,utf8_decode("RESTA LA CANTIDAD DE: $".$comprobante['debe']." PESOS"),0,0);

$pdf->Line(72,124,200,124);//LINEA PARA EL CAMPO CLIENTE

$pdf->Ln(12);













$pdf->Output();







?>