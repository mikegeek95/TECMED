<?php
require_once("../../clases/conexcion.php");
require_once("../../clases/class.EntradasySalidas.php");
require_once("../../clases/fpdf/fpdf.php");
require_once("../../clases/class.Fechas.php");

$db = new MySQL ();
$fecha = new Fechas ();
$eys = new EntradasySalidas();


$eys->db = $db;
$eys->idsalidas = $_GET['id'];


//metodo para ver los datos de la salida
$datos = $eys->verDatosSalida();
$tipo = array("Venta","Devolución","Producto Fallo","Caducado");


class PDF extends FPDF

{
	public $db;
// Cabecera de página

function Header()

{

	$id = $_GET['id'];

    	//Obtenemos logo
		$sql_logo = "SELECT logo FROM configuracion";
		$result_logo = $this->db->consulta($sql_logo);
		$result_logo_num = $this->db->num_rows($result_logo);
		$result_logo_row = $this->db->fetch_assoc($result_logo);
		
		
	$sucursal=$this->db->consulta("select idsucursales from salidas where idsalidas =".$_GET['id']);
		$sucursal_row = $this->db->fetch_assoc($sucursal);
		$idsucursal=$sucursal_row['idsucursales'];
		
		
		
	$result_mi_sucursal = $this->db->consulta("SELECT * FROM sucursales WHERE idsucursales = '$idsucursal'");
	$result_mi_sucursal_row = $this->db->fetch_assoc($result_mi_sucursal);
	

		
		

    	  
	$this->SetY(0);
	$this->SetX(0);
    $this->SetFont('Arial','B',20);
   
    // Salto de línea
    $this->Image('../../images/configuracion/logo.png',10,5,25);
	$this->SetFont('Arial','B',8);
		
	$this->Ln(5);
	$this->SetX(50);
	
	
	$this->SetFont('Arial','',8);
	$this->SetX(50);	
	$this->Cell(100,5,"Sucursal ".utf8_decode($result_mi_sucursal_row['sucursal']),0,1);	
	$this->SetX(50);
	$this->MultiCell(150,5,utf8_decode($result_mi_sucursal_row['direccion']),0,'J');
	$this->SetX(50);
	$this->Cell(100,5,utf8_decode($result_mi_sucursal_row['tel']),0,1);
	$this->SetX(50);
	$this->Cell(100,5,utf8_decode($result_mi_sucursal_row['email']),0,1);
	$this->Ln(8);
	$this->SetX(50);
		$this->SetFont('Arial','B',12);
	$this->Cell(100,5, utf8_decode("REPORTE DE SALIDA"),0,1,"C");
		$this->SetFont('Arial','',8);
	$count = 0;
		$this->Ln(5);
	$this->Line($this->GetX(),$this->GetY(),200,$this->GetY());
    $this->Ln(2);

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


$pdf->db = $db;
$pdf->AddPage();

$pdf->SetFontSize(10);





$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,8,utf8_decode("FECHA IMPRESIÓN :"));
$pdf->SetFont('Arial','',12);
$pdf->Cell(50,8,"   ".$fecha->fechaadd_mm_YYYY_entre());
$pdf->Ln();







$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,5,"FECHA SALIDA: ",0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,5," ".$fecha->fecha_texto($datos['fecha']),0,0);
$pdf->Line(45,58,200,58);//LINEA PARA EL CAMPO CLIENTE

$pdf->Ln(7);

/*$pdf->SetXY(111,65);

$pdf->Cell(0,0,".",0,1);*/





$pdf->SetFont('Arial','B',12);
$pdf->Cell(30,5,"ID SALIDA: ",0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(35,5," ".$datos['idsalidas']."",0,0);
$pdf->Line(35,65,200,65);//LINEA PARA EL CAMPO CLIENTE



$pdf->Ln(7);



$pdf->SetFont('Arial','B',12);
$pdf->Cell(13,5,"TIPO: ",0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,5," ".utf8_decode($tipo[$datos['tipo']])." ",0,0);
$pdf->Line(23,72,200,72);//LINEA PARA EL CAMPO CLIENTE



$pdf->Ln(7);





/*$pdf->Cell(40,5,"TOTAL A PAGAR: $".$datos['total']." PESOS",0,0);

$pdf->Line(41,84,200,84);//LINEA PARA EL CAMPO CLIENTE



$pdf->Ln(7);







$pdf->Cell(40,5,utf8_decode($m.$pago.$mdos.$ventas->id_notaremision." "),0,0);

$pdf->Line(52,91,200,91);//LINEA PARA EL CAMPO CLIENTE

$pdf->Ln(7);

*/







/*$pdf->Cell(40,5,utf8_decode("Por concepto de pago de compra JOYERÍA KL de la nota de remision : ".$ventas->id_notaremision),0,0);



$pdf->Ln(7);*/













$pdf->SetX(20);







$pdf->Ln(10);


$pdf->SetFont('Arial','B',12);
$pdf->SetX(10);

$pdf->Cell(40,7,"ID PRODUCTO",1,0,'C');

$pdf->Cell(100,7,"NOMBRE",1,0,'C');
$pdf->Cell(25,7,"CANTIDAD",1,0,'C');
$pdf->Cell(20,7,"PRECIO",1,0,'C');



$pdf->Ln();
$pdf->SetFont('Arial','',12);


 $productos = $eys->verSalidasDetalle();
 $total = 0;
$total_efectivo=0; 
	 

	     foreach($productos as $p )

    {

				$pdf->SetX(10);

				$pdf->SetFontSize(10);

				$pdf->Cell(40,5,$p->idproducto,1,0,'C');

				$pdf->Cell(100,5,utf8_decode($p->nombre),1,0,'C');
			 	$pdf->Cell(25,5,$p->cantidad,1,0,'C');
				$pdf->Cell(20,5,"$ ".$p->pv,1,0,'C');

				

				$pdf->Ln(5);
			 $total = $total + $p->cantidad;
			 $total_efectivo = $total_efectivo + ($p->pv * $p->cantidad);

      }

$pdf->SetX(10);

				$pdf->SetFontSize(10);

				$pdf->Cell(40,5,'',1,0,'C');

				$pdf->Cell(100,5,'',1,0,'C');
				$pdf->Cell(25,5,$total,1,0,'C');

				$pdf->Cell(20,5,'$ '.number_format($total_efectivo,2,'.',','),1,0,'C');

				
				
				/*$pdf->Cell(20,5," ",1,0,'L');
				
				$pdf->Cell(20,5," ",1,0,'L');*/

				$pdf->Ln(5);
$pdf->Ln(10);

$pdf->SetX(70);	  

	  

//$pdf->Cell(100,5,utf8_decode("JOYERÍA KL AGRADECE TU COMPRA "),0,0);	  

$pdf->Output();



?>