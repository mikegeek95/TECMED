<?php

require_once("../../clases/conexcion.php");

require_once("../../clases/class.Entregas.php");

require_once("../../clases/fpdf/fpdf.php");

require_once("../../clases/class.Fechas.php");



$db = new MySQL ();

$entrega = new Entregas (); 

$fecha = new Fechas ();



$entrega->db = $db;





$entrega->idnota_remision = $_GET['idnota_remision'];



$productos = $entrega->verProductos();

$cliente = $entrega->datosCliente();

$usuario = $entrega->datosUsuario();





class PDF extends FPDF

{

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

	

	$this->Cell(100,5,"REPORTE ENTREGA JOYERIA KL",0,1);

	

	$this->Image('logo.png',150,18,33);

	$this->Cell(100,5,'Calle 7a Oriente entre 1a y 2a Sur ',0,1);

	$this->Cell(100,5,'Telefono: 96116545418',0,1);

	$this->Cell(100,5,'Correo: info@joyeriakl.com',0,0);

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

$pdf->AddPage();



$pdf->SetFontSize(10);



$pdf->Cell(100,10,'Fecha : '.$fecha->fechaadd_mm_YYYY_entre(),0,1);

$pdf->Cell(100,10,'Elaborado por:   '.strtoupper($usuario['nombreU']),0,1);

$pdf->Line(35,76,200,76);





$pdf->Cell(100,10,'Cliente:   '.strtoupper($cliente['cliente']),0,1);

$pdf->Line(24,86,200,86);



$pdf->Ln();

//encabezado de la tabla 

$pdf->SetX(20);

$pdf->SetFontSize(13);

$pdf->Cell(50,10,'Id Producto',1,0,'C');

$pdf->Cell(70,10,'Nombre Producto',1,0,'C');

$pdf->Cell(50,10,'Cantidad',1,0,'C');

$pdf->Ln();















	

	

	//hago un foreach con larreglo de verproductos y guardo en la tabla nota_entrega_detalle

	foreach ($productos as $p )

	{

		

		//datos de la tabla

		$pdf->setX(20);

		$pdf->SetFontSize(10);

				

		$pdf->Cell(50,10,$p->idproducto ,1,0,'C');

		$pdf->Cell(70,10,$p->nombre,1,0,'C');

		$pdf->Cell(50,10,$p->cantidad,1,0,'C');

		$pdf->Ln();

		

		

		

		

	}//fin del foreach











$pdf->Output();



?>