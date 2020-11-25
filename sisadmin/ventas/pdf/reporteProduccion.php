<?php
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Campanas.php");
require_once("../../clases/class.Tallas.php");
require_once("../../clases/fpdf/fpdf.php");
require_once("../../clases/class.Fechas.php");

$db = new MySQL();
$fecha = new Fechas();
$cam = new Campanas();
$ta = new Tallas();

$ta->db = $db;
$cam->db = $db;
$cam->idsobrepedido_camp = $_GET['id'];

//Obtenemos los datos de la campaña
$campana = $cam->buscar_campana();
$campana_row = $db->fetch_assoc($campana);

//Obtenemos el listado de productos ordenados de la campaña
$productos = $cam->productos_sobrepedido_campana();
$productos_num = $db->num_rows($productos);
$productos_row = $db->fetch_assoc($productos);

class PDF extends FPDF
{
	public $db;
	
	
	//Cabecera de página
	function Header()
	{
		
    	//Obtenemos logo
		$sql_logo = "SELECT logo FROM configuracion";
		$result_logo = $this->db->consulta($sql_logo);
		$result_logo_num = $this->db->num_rows($result_logo);
		$result_logo_row = $this->db->fetch_assoc($result_logo);

		$this->SetY(2);
		$this->SetX(80);
		$this->SetFont('Arial','B',20);

		$this->Ln(18);

		$this->SetFont('Arial','B',10);
		
		$this->Cell(100,5, utf8_decode("REPORTE DE PRODUCCIÓN"),0,1);
		$this->Line(10,30,200,30);
	
		if($result_logo_num != 0){
			$this->Image('../../images/configuracion/'.$result_logo_row['logo'],170,5,20);
		}

		$this->Cell(100,5,' ',0,1);

		$this->Cell(100,5,' ',0,1);

		$this->Cell(100,5,' ',0,0);

		$this->SetX(150);

		$this->Cell(100,5, utf8_decode(" "),0,1);

		//$this->Line(10,43,200,43);

		$this->Ln(10);

		$this->SetFont('Arial','',10);

	}


	//Pie de página
	function Footer()
	{
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Número de página
		$this->Cell(0,10,utf8_decode('Página').$this->PageNo().'',0,0,'C');
	}
	//termina pie de página
}//TERMINA EXPENDEN DE PDF


// Creación del objeto de la clase heredada
$pdf = new PDF();

$pdf->db = $db;
$pdf->AddPage();

$pdf->SetFontSize(10);


$pdf->Cell(40,5,utf8_decode("FECHA IMPRESIÓN: ").$fecha->fechaadd_mm_YYYY_entre());
$pdf->Line(46,56,200,56);//LINEA PARA EL CAMPO CLIENTE

$pdf->Ln(7);

$pdf->Cell(40,5,utf8_decode("FECHA DE CAMPAÑA: ").$fecha->f_esp($campana_row['fecha_inicio'])." - ".$fecha->f_esp($campana_row['fecha_fin']),0,0);

$pdf->Line(49,63,200,63);//LINEA PARA EL CAMPO CLIENTE

$pdf->Ln(7);

$pdf->Cell(40,5,utf8_decode("CAMPAÑA: ").$campana_row['nombre']."",0,0);

$pdf->Line(30,70,200,70);//LINEA PARA EL CAMPO CLIENTE

$pdf->Ln(5);


$pdf->SetX(20);

$pdf->Ln(10);

$pdf->SetX(10);

$pdf->Cell(40,7,"CODIGO",1,0,'C');

$pdf->Cell(100,7,"NOMBRE",1,0,'C');

$pdf->Cell(20,7,"TALLA",1,0,'C');

$pdf->Cell(30,7,"CANTIDAD",1,0,'C');

/*$pdf->Cell(20,7," ",1,0,'L');

$pdf->Cell(20,7," ",1,0,'L');*/

$pdf->Ln();


$pdf->SetX(10);
$pdf->SetFontSize(10);
if($productos_num == 0)
{
	$pdf->Cell(190,7,"LO SENTIMOS, NO SE HAN ENCONTRADO PRODUCTOS",1,0,'C');
}else{
	do
	{
		$idtallas = $productos_row['talla'];
		$ta->idtallas = $idtallas;
		
		$tallas = $ta->buscarTalla();
		$tallas_row = $db->fetch_assoc($tallas);
		
		$pdf->Cell(40,5,$productos_row['idproducto'],1,0,'C');
		$pdf->Cell(100,5,$productos_row['nombre'],1,0,'C');
		$pdf->Cell(20,5,$tallas_row['talla'],1,0,'C');
		$pdf->Cell(30,5,$productos_row['cantidad'],1,0,'C');
		$pdf->Ln(5);
		
		$total_cantidad = $total_cantidad + $productos_row['cantidad'];
		
	}while($productos_row = $db->fetch_assoc($productos));
}

$pdf->SetX(10);

$pdf->SetFontSize(10);

$pdf->Cell(40,5,'',1,0,'C');

$pdf->Cell(100,5,'',1,0,'C');

$pdf->Cell(20,5,'',1,0,'C');

$pdf->Cell(30,5,$total_cantidad,1,0,'C');

$pdf->Ln(5);
$pdf->Ln(10);


$pdf->SetX(70);	  

$pdf->Output();
?>