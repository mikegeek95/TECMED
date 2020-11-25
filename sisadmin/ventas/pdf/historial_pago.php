<?php

require_once("../../clases/conexcion.php");

require_once("../../clases/class.Credito.php");

require_once("../../clases/fpdf/fpdf.php");

require_once("../../clases/class.Fechas.php");



$db = new MySQL ();

$credito = new creditos ();

$fecha = new Fechas ();



$credito->db = $db ;



$credito->idcretdito = $_GET['id'];



$sql_historial = "SELECT 

 cd.idcredito ,

 c.idnota_remision , 

 DATE(cd.fecha_deposito) AS fecha, 

cd.deposito ,

c.estatus,

 CONCAT(cl.nombre,' ',cl.paterno,' ',cl.materno) AS cliente





 FROM credito c , credito_detalle cd , clientes cl 

WHERE

c.idcredito = cd.idcredito 

AND

c.idcliente = cl.idcliente AND c.idcredito = '$credito->idcretdito'";

			

			$result_historial = $db->consulta($sql_historial);

			$result_historial_row = $db->fetch_assoc($result_historial);

			$result_historial_row_num = $db->num_rows($result_historial);







$comprobante = $credito->obtenerDatosCreditoComprobante();

$deuda = $credito->obtenerDeuda();

$pagos = $credito->totalPagos();





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

	

	$this->Cell(100,5,"HISTORIAL DE PAGO JOYERIA KL",0,1);

	

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

$pdf->Cell(40,10,utf8_decode("FECHA DE IMPRESIÓN: ").$fecha->fechaadd_mm_YYYY_guion() );



$pdf->Ln(14);



$pdf->SetX(25);

$pdf->SetFontSize(10);

$pdf->Cell(25,10,utf8_decode("ID CRÉDITO"),1,0,'C');

$pdf->Cell(25,10,"FECHA",1,0,'C');

$pdf->Cell(30,10,utf8_decode("NOTA REMISIÓN"),1,0,'C');

$pdf->Cell(60,10,"CLIENTE",1,0,'C');

$pdf->Cell(25,10,"PAGO",1,0,'C');



do

{

	$pdf->Ln();

	$pdf->SetX(25);

	$pdf->SetFontSize(10);

	$pdf->Cell(25,10,$result_historial_row['idcredito'],1,0,'C');

	$pdf->Cell(25,10,$result_historial_row['fecha'],1,0,'C');

	$pdf->Cell(30,10,$result_historial_row['idnota_remision'],1,0,'C');

	$pdf->Cell(60,10,utf8_decode($result_historial_row['cliente']),1,0,'C');

	$pdf->Cell(25,10,"$".$result_historial_row['deposito'],1,0,'C');

	

	

	

}while($result_historial_row = $db->fetch_assoc($result_historial));







$pdf->Output();







?>