<?php

require_once("../../clases/conexcion.php");
require_once("../../clases/class.Ventas.php");
require_once("../../clases/fpdf/fpdf.php");
require_once("../../clases/class.Fechas.php");
require_once("../../clases/class.Configuracion.php");


$db = new MySQL ();
$fecha = new Fechas ();
$ventas = new Ventas();
$conf->db = $db;

$ventas->db = $db ;
$ventas->id_notaremision = $_GET['id'];

$pago = $_GET['pago'];
$total = $_GET['total'];
$tipo = $_GET['tipo'];


if ($_GET['pago'] != "")
{
	$pago = $_GET['pago'];
}else {
	$pago = $total;
      }

$datos = $ventas->verDatosReciboCaja();
$cliente = $ventas->verClientePedido();

if ($tipo != 5)
	{
		$m = "PAGÓ LA CANTIDAD DE: $";
		$mdos = " PESOS Por concepto de pago de compra JOYERÍA KL de la nota de remision :"; 
	}else if ($tipo == 5){
		$m = "DEBE LA CANTIDAD DE: $" ;
		$mdos = " PESOS Por concepto de crédito de compra JOYERÍA KL de la nota de remision :";
	}


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
	$tipo = $_GET['tipo'];
	$titulo ;
	
	if ($tipo !=5)
	{
		$titulo = "PAGO CAJA JOYERÍA KL";
	}
	else if ($tipo == 5)
	{
		$titulo = "GENERA CREDITO JOYEÍA KL" ;
    }

	// Logo
    // Arial bold 15

	$this->SetY(2);
	$this->SetX(80);
    $this->SetFont('Arial','B',20);
 
    // Movernos a la derecha
    // Título
    //$this->Cell(30,10,'ORDEN DE COMPRA',0,0,'C');
    // Salto de línea

	$this->Ln(18);
    $this->SetFont('Arial','',10);
    $this->Cell(100,5, utf8_decode($titulo),0,1);
    $this->Image('logo.png',150,18,33);
	$this->Cell(100,5,$this->direccion,0,1);
	$this->Cell(100,5,$this->telefono,0,1);
	$this->Cell(100,5,$this->email,0,0);
	$this->SetX(150);
	$this->Cell(100,5, utf8_decode(" "),0,1);
	$this->Line(10,43,200,43);
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

    $this->Cell(0,10,utf8_decode('Página').$this->PageNo().'',0,0,'C');

}



//termina pie de página

}//TERMINA EXPENDEN DE PDF





// Creación del objeto de la clase heredada

$pdf = new PDF ();



//datos de la empresa

$empresa = $conf->ObtenerInformacionConfiguracion();

$pdf->empresa = $empresa['nombre_empresa'];
$pdf->direccion = $empresa['direccion'];
$pdf->telefono = $empresa['telefonos'];
$pdf->email = $empresa['email'];
$pdf->www = $empresa['url'];


$pdf->AddPage();

$pdf->SetFontSize(10);





$pdf->Cell(40,8,"FECHA: ".$fecha->fechaadd_mm_YYYY_entre());

$pdf->Ln();



if ($cliente['clientes'] != "")

{

	utf8_decode($clientes = $cliente['clientes']);

}

else $clientes = "Venta General";



$pdf->Cell(40,5,"CLIENTE: ".$clientes,0,0);

$pdf->Line(27,63,200,63);//LINEA PARA EL CAMPO CLIENTE

$pdf->Ln(7);

/*$pdf->SetXY(111,65);

$pdf->Cell(0,0,".",0,1);*/





$pdf->Cell(40,5,"TOTAL: $".$total." PESOS",0,0);

$pdf->Line(25,70,200,70);//LINEA PARA EL CAMPO CLIENTE



$pdf->Ln(7);



$pdf->Cell(40,5,"DESCUENTO: $".$datos['desc_directo']." PESOS",0,0);

$pdf->Line(35,77,200,77);//LINEA PARA EL CAMPO CLIENTE



$pdf->Ln(7);





$pdf->Cell(40,5,"TOTAL A PAGAR: $".$datos['total']." PESOS",0,0);

$pdf->Line(41,84,200,84);//LINEA PARA EL CAMPO CLIENTE



$pdf->Ln(7);







$pdf->Cell(40,5,utf8_decode($m.$pago.$mdos.$ventas->id_notaremision." "),0,0);

$pdf->Line(52,91,200,91);//LINEA PARA EL CAMPO CLIENTE

$pdf->Ln(7);









/*$pdf->Cell(40,5,utf8_decode("Por concepto de pago de compra JOYERÍA KL de la nota de remision : ".$ventas->id_notaremision),0,0);



$pdf->Ln(7);*/









if($pago > $total){

	

	$cambio =   $pago - $total;

$pdf->Cell(40,5,utf8_decode("CAMBIO: $".$cambio." PESOS"),0,0);

$pdf->Line(28,106,200,106);//LINEA PARA EL CAMPO CLIENTE

$pdf->Ln(12);

}



$pdf->SetX(20);







$pdf->Ln(10);



$pdf->SetX(20);

$pdf->Cell(45,7,"ID PRODUCTO",1,0,'C');

$pdf->Cell(70,7,"NOMBRE",1,0,'C');

$pdf->Cell(20,7,"PRECIO",1,0,'C');

$pdf->Cell(30,7,"CANTIDAD",1,0,'C');

$pdf->Ln();



 $productos = $ventas->listarProdctosenPedido();

	 

	     foreach($productos as $p )

    {

				$pdf->SetX(20);

				$pdf->SetFontSize(10);

				$pdf->Cell(45,5,$p->idproducto,1,0,'C');

				$pdf->Cell(70,5,$p->nombre,1,0,'C');

				$pdf->Cell(20,5,$p->pv,1,0,'C');

				$pdf->Cell(30,5,$p->cantidad,1,0,'C');

				$pdf->Ln(5);

      }

$pdf->Ln(10);

$pdf->SetX(70);	  

	  

$pdf->Cell(100,5,$pdf->empresa." AGRADECE TU COMPRA ",0,0);	  

$pdf->Output();



?>