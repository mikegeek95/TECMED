<?php

require_once("../clases/conexcion.php");

require_once("../clases/class.Compras.php");

require_once("../clases/fpdf/fpdf.php");





$db = new MySQL ();

$compras = new Compras ();







$compras->id_compra = 2 ; //$_GET['id'];



$sql_compras = "SELECT

usuarios.nombre AS usuario,

compras.idcompras,

compras.idusuarios,

compras.fecha,

compras.fecha_compra,

compras.prioridad,

compras.descripcion,

compras.estatus

FROM

compras

INNER JOIN usuarios ON compras.idusuarios = usuarios.idusuarios WHERE idcompras = $compras->id_compra" ;

$result_compras = $db->consulta($sql_compras);

$result_compras_row = $db->fetch_assoc($result_compras);





class PDF extends FPDF

{

// Cabecera de página

function Header()

{

    // Logo

    //$this->Image('logo_pb.png',10,8,33);

    // Arial bold 15

    $this->SetFont('Arial','B',15);

    // Movernos a la derecha

    $this->Cell(80);

    // Título

    $this->Cell(30,10,'ORDEN DE COMPRA',1,0,'C');

    // Salto de línea

    $this->Ln(20);

}



// Pie de página

function Footer()

{

    // Posición: a 1,5 cm del final

    $this->SetY(-15);

    // Arial italic 8

    $this->SetFont('Arial','I',8);

    // Número de página

    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');

}

}







// Creación del objeto de la clase heredada

$pdf = new PDF();

$pdf->AliasNbPages();

$pdf->AddPage();









$pdf->SetFont('Times','',12);

for($i=1;$i<=40;$i++)

    $pdf->Cell(0,10,'Imprimiendo línea número '.$i,0,1);

$pdf->Output();

?>

