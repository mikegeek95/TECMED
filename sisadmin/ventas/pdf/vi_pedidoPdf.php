<?php
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Ventas.php");
require_once("../../clases/fpdf/fpdf.php");
require_once("../../clases/class.Fechas.php");
require_once("../../clases/class.Configuracion.php");

$db = new MySQL ();
$fecha = new Fechas ();
$ventas = new Ventas();
$conf = new Configuracion();

$ventas->db = $db ;
$conf->db = $db;
$ventas->id_notaremision = $_GET['id'];

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
   
	
    // Salto de línea
	$this->Ln(18);
	
	$this->SetFont('Arial','',11);
	
	$this->Cell(100,5,"ORDEN DE PEDIDO".$this->empresa,0,1);	
	$this->Image('logo.png',150,18,33);
	$this->Cell(100,5,$this->direccion,0,1);
	$this->Cell(100,5,$this->telefono,0,1);
	$this->Cell(100,5,$this->email,0,1);
	$this->Cell(100,5,$this->www,0,0);
	$this->SetX(150);
	$this->Cell(100,5, utf8_decode(" "),0,1);
	$this->Line(10,55,200,55);
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
$pdf->SetX(20);
$cliente = $ventas->verClientePedido();

$pdf->SetFont('Arial','B',10);
$pdf->Cell(100,5,"Cliente : ".$cliente['clientes'],0,1);
$pdf->SetX(20);
$pdf->Cell(100,5,"Id pedido :".$ventas->id_notaremision,0,1);

$pdf->SetX(20);
$pdf->Cell(19,7,"COD.",1,0,'C');
$pdf->Cell(70,7,"PRODUCTO",1,0,'C');
$pdf->Cell(20,7,"PRECIO",1,0,'C');
$pdf->Cell(30,7,"CANTIDAD",1,0,'C');
$pdf->Cell(30,7,"TOTAL",1,0,'C');
$pdf->Ln();


$suma = 0;

 $productos = $ventas->listarProdctosenPedido();
	 
	     foreach($productos as $p )
    {
				$pdf->SetX(20);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(19,6,$p->idproducto,1,0,'C');
				$pdf->Cell(70,6,$p->nombre,1,0,'C');
				$pdf->Cell(20,6,"$ ".$p->pv,1,0,'C');
				$pdf->Cell(30,6,$p->cantidad,1,0,'C');
				$pdf->Cell(30,6,"$ ".$p->subtotal,1,0,'C');
				$pdf->Ln();
				
				$suma = $suma + $p->subtotal;
      }
	
	  
$pdf->SetX(20);
$pdf->Cell(139,5,"TOTAL SUMA",0,0,'R');
$pdf->Cell(30,5,"$ ".number_format($suma,2,'.',','),1,0,'R');
$pdf->Ln();
$pdf->Ln();

$pdf->SetX(20);
$pdf->Cell(139,5,"",0,0,'R');
$pdf->Cell(30,5,"",0,0,'C');	  
$pdf->Ln();	  


$pdf->SetX(20);
$pdf->Cell(139,5,"SUBTOTAL",0,0,'R');
$pdf->Cell(30,5,"$ ".number_format($cliente['subtotal'],2,'.',','),1,0,'R');	  
$pdf->Ln();	  

$pdf->SetX(20);
$pdf->Cell(139,5,"DEC. DIRECTO",0,0,'R');
$pdf->Cell(30,5,"$ ".number_format($cliente['desc_directo'],2,'.',','),1,0,'R');	  
$pdf->Ln();	

$pdf->SetX(20);
$pdf->Cell(139,5,"IVA",0,0,'R');
$pdf->Cell(30,5,"$ ".number_format($cliente['iva'],2,'.',','),1,0,'R');	  
$pdf->Ln();	  

$pdf->SetX(20);
$pdf->Cell(139,5,"TOTAL",0,0,'R');
$pdf->Cell(30,5,"$ ".number_format($cliente['total'],2,'.',','),1,0,'R');	  
$pdf->Ln();	  
	  
$pdf->Output();

?>