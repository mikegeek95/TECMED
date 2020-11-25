<?php

require_once("../../clases/conexcion.php");

require_once("../../clases/class.Compras.php");

require_once("../../clases/fpdf/fpdf.php");





$db = new MySQL ();

$compras = new Compras ();







$compras->id_compra = $_GET['id'];



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







$sql_comprasDetalle = "SELECT * FROM compra_detalle WHERE idcompras = $compras->id_compra ";

$result_comprasDetalle = $db->consulta($sql_comprasDetalle);

$result_comprasDetalle_row = $db->fetch_assoc($result_comprasDetalle);



class PDF extends FPDF

{

// Cabecera de página

function Header()

{

	$id = $_GET['id'];

    // Logo

    

    // Arial bold 15

	$this->SetX(80);

    $this->SetFont('Arial','B',20);

    // Movernos a la derecha

   

    // Título

    $this->Cell(30,10,'ORDEN DE COMPRA',0,0,'C');

	

    // Salto de línea

	$this->Ln(18);

	

	$this->SetFont('Arial','',14);

	

	$this->Cell(100,5,"Orden de Compra",0,1);

	

	//$this->Image('logo.png',150,18,33);

	$this->Cell(100,5,' ',0,1);

	$this->Cell(100,5,' ',0,1);

	$this->Cell(100,5,' ',0,0);

	$this->SetX(150);

	$this->Cell(100,5,utf8_decode( "Id de Compra N° $id"),0,1);

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



//funcion para la tabla



function BasicTable($header, $data)

{

    // Cabecera

    foreach($header as $col)

        $this->Cell(40,7,$col,1,0,'c');

    $this->Ln();

    // Datos

    foreach($data as $row)

    {

        foreach($row as $col)

            $this->Cell(40,6,$col,1);

        $this->Ln();

    }

}





//termina funcino para la tabla







// Una tabla más completa

function ImprovedTable($header, $data)

{

    // Anchuras de las columnas

    $w = array(40, 35, 45, 40);

    // Cabeceras

    for($i=0;$i<count($header);$i++)

        $this->Cell($w[$i],7,$header[$i],1,0,'C');

    $this->Ln();

    // Datos

    foreach($data as $row)

    {

        $this->Cell($w[0],6,$row[0],'LR');

        $this->Cell($w[1],6,$row[1],'LR');

        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');

        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');

        $this->Ln();

    }

    // Línea de cierre

    $this->Cell(array_sum($w),0,'','T');

}





}







// Creación del objeto de la clase heredada

$pdf = new PDF();

$cabeceraTabla = array ('id de Compra','producto','cantidad','estatus');

$pdf->AliasNbPages();

$pdf->AddPage();

$pdf->Ln(2);

$pdf->Cell(50,0,"Usuario: ".$result_compras_row['usuario'],0,0);

$pdf->Line(30,62,58,62);

$pdf->Cell(40,0,"Fecha:".date('d/m/y'),0,0);

$pdf->Line(76,62,95,62);



$pdf->Ln(10);

if ($result_compras_row['descripcion'] != ""){

$pdf->Cell(200,5,"DESCRIPCION: ",0,1);

$pdf->Ln(2);

$pdf->SetX(20);

$pdf->MultiCell(200,5,$result_compras_row['descripcion'],0,1);



$pdf->Ln(10);

}

/*$pdf->SetX(20);

$pdf->BasicTable($cabeceraTabla ,$result_comprasDetalle_row );

$pdf->SetX(20);

$pdf->ImprovedTable($cabeceraTabla , $result_comprasDetalle_row );*/

$pri = array ("Normal","Urgente","Alta");

$pdf->Cell(0,2,"Prioridad: ".$pri[$result_compras_row['prioridad']],0);

$pdf->Ln(8);

$pdf->SetX(22);

$pdf->Cell(50,10,'ID DE COMPRA',1,0,'C');



$pdf->Cell(50,10,'ID PRODUCTO ',1,0,'C');



$pdf->Cell(30,10,'CANTIDAD ',1,0,'C');



$pdf->Cell(30,10,'ESTATUS ',1,0,'C');

$pdf->Ln(10);

$pdf->SetX(22);

do

{



$pdf->Cell(50,10,$result_comprasDetalle_row['idcompras'],1,0,'C');



$pdf->Cell(50,10,$result_comprasDetalle_row['idproducto'],1,0,'C');



$pdf->Cell(30,10,$result_comprasDetalle_row['cantidad'],1,0,'C');



$pdf->Cell(30,10,$result_comprasDetalle_row['estatus'],1,0,'C');	

$pdf->Ln(10);

$pdf->SetX(22);

	

}while ($result_comprasDetalle_row = $db->fetch_assoc($result_comprasDetalle));

$pdf->Output();

?>

