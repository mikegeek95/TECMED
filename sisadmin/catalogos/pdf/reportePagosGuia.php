<?php
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Ventas.php");
require_once("../../clases/class.Guias.php");
require_once("../../clases/fpdf/fpdf.php");
require_once("../../clases/class.Fechas.php");
require_once("../../clases/class.Configuracion.php");
require_once("../../clases/class.Sesion.php");
require_once("../../clases/class.Sucursales.php");
require_once("../../clases/class.Funciones.php");
      
   $se = new Sesion();



$db = new MySQL ();
$fecha = new Fechas ();
$guias = new Guias();
$conf = new Configuracion();
$su = new Sucursales();
$ventas = new Ventas();

$f = new Funciones();


$idsucursales = $_SESSION['se_sas_Sucursal'];

$guias->db = $db;
$conf->db = $db;
$ventas->db = $db;

$sql = $f->desconver_especial($_GET['sql']);

//die($sql);

$result_guias = $db->consulta($sql);
$result_guias_row = $db->fetch_assoc($result_guias);






$moneda = array('USD','MXN');
$metodo = array('EFECTIVO','D. BANCARIO','MONEY GRAM','WESTER UNION','PAYPAL');
$pagoTarjeta = array('PENDIENTE','PAGADO');


/*$ventas->id_notaremision = $_GET['id'];
$datos = $ventas->verDatosReciboCaja();
$cliente = $ventas->verClientePedido();*/

class PDF extends FPDF

{
	
	public $empresa;
	public $direccion;
	public $telefono;
	public $email;
	public $www;
	public $idsucursales;
	public $su;
	public $db;

// Cabecera de página

function Header()

{

	//$id = $_GET['id'];

	$tipo = $_GET['tipo'];

	$titulo ;

	

	if ($tipo == 0)

	{

		$titulo = $this->empresa;

		

	}

	else if ($tipo == 5)

	{

		$titulo = "GENERA CREDITO ".$this->empresa; ;

	}

	
	$this->su->db = $this->db;
	$this->su->idsucursales = $this->idsucursales;
	$result_mi_sucursal = $this->su->buscarSucursal();
	$result_mi_sucursal_row = $this->db->fetch_assoc($result_mi_sucursal);
	
	$result_sucursales = $this->su->obtenerotrasSucursales();
	$result_sucursales_row = $this->db->fetch_assoc($result_sucursales);

    // Logo

    

    // Arial bold 15
    
	$this->SetY(0);
	$this->SetX(0);
    $this->SetFont('Arial','B',20);
   
    // Salto de línea
   // $this->Image('logo.png',10,5,33);
	$this->SetFont('Arial','B',8);
		
	$this->Ln(5);
	$this->SetX(50);
	if($this->idsucursales == 1){	
	//$this->Cell(100,5,"Matriz",0,1);
	}else{
	//$this->Cell(100,5,"Sucursal",0,1);
	}
	$this->SetFont('Arial','',8);
	$this->SetX(50);	
	//$this->Cell(100,5,$result_mi_sucursal_row['sucursal'],0,1);	
	$this->SetX(50);
	//$this->Cell(100,5,$result_mi_sucursal_row['direccion'],0,1);
	$this->SetX(50);
	//$this->Cell(100,5,$result_mi_sucursal_row['tel'],0,1);
	$this->SetX(50);
	//$this->Cell(100,5,$result_mi_sucursal_row['email'],0,1);
	
	$count = 0;
	do
	{
		if($count == 0){
			$x = 90;
		}else{
			$x = $x + 40;
		}
	$this->SetFont('Arial','B',8);
	$this->SetY(0);
	$this->Ln(5);
	$this->SetX($x);
	if($result_sucursales_row['idsucursales'] == 1){
		//$this->Cell(100,5,"Matriz",0,1);
	}else{
		//$this->Cell(100,5,"Sucursal",0,1);
	}
	$this->SetFont('Arial','',8);
	$this->SetX($x);	
	//$this->Cell(100,5,$result_sucursales_row['sucursal'],0,1);	
	$this->SetX($x);
	//$this->Cell(100,5,$result_sucursales_row['direccion'],0,1);
	$this->SetX($x);
	//$this->Cell(100,5,$result_sucursales_row['tel'],0,1);
	$this->SetX($x);
	//$this->Cell(100,5,$result_sucursales_row['email'],0,1);
	
	$count++;
	
	}while($result_sucursales_row = $this->db->fetch_assoc($result_sucursales));
	
	
	$this->Ln(5);
	//$this->Line($this->GetX(),$this->GetY(),200,$this->GetY());
    $this->Ln(2);
    
}



// Pie de página

function Footer()

{

    // Posición: a 1,5 cm del final

   /* $this->SetY(-18);

    // Arial italic 8

    $this->SetFont('Arial','I',8);

    // Número de página
    $this->MultiCell(190,5,utf8_decode("- Le invitamos a revisar su mercancia antes de salir de la tienda."),0,'J');
	$this->MultiCell(190,5,utf8_decode("- Para poder realizar la devolución de producto es necesario presentar este comprobante de pago."),0,'J');
	$this->MultiCell(190,5,utf8_decode("- Las piezas deberán de venir en su empaque original."),0,'J');
    $this->Cell(0,10,utf8_decode('Página').$this->PageNo().'',0,0,'C');*/

}



//termina pie de página

}//TERMINA EXPENDEN DE PDF





// Creación del objeto de la clase heredada

$pdf =& new PDF ('P', 'mm', 'letter');


//parsear la informacion de la empresa.

//datos de la empresa

$empresa = $conf->ObtenerInformacionConfiguracion();

$pdf->empresa = $empresa['nombre_empresa'];
$pdf->direccion = $empresa['direccion'];
$pdf->telefono = $empresa['telefonos'];
$pdf->email = $empresa['email'];
$pdf->www = $empresa['url'];
$pdf->idsucursales = $idsucursales;
$pdf->su = $su;
$pdf->db = $db;


$pdf->AddPage();
$pdf->SetMargins(10,1,0);
$pdf->SetFontSize(9);


	$pdf->Ln(10);

	

/*
$pdf->Cell(30,7,"MONTO $ ".number_format($result_guias_row['monto'],2,'.',','),0,0);
$pdf->Cell(35,7,"MONTO LIB: ".strtoupper("$ ".$result_guias_row['monto_liberacion']),0,0);*/



$pdf->SetX(20);
$pdf->Ln();
	$pdf->SetFontSize(7);
	$pdf->SetX(10);
	$pdf->Cell(12,5,"LOTE",1,0,'C');
	$pdf->Cell(30,5,"FECHA PAGO",1,0,'C');
	$pdf->Cell(17,5,"MONTO",1,0,'C');
	$pdf->Cell(17,5,"MXN",1,0,'C');
	$pdf->Cell(20,5,"MONEDA",1,0,'C');
	$pdf->Cell(30,5,"METODO",1,0,'C');
	$pdf->Cell(35,5,"REFERENCIA",1,0,'C');
	$pdf->Cell(35,5,"P. TARJETA",1,0,'C');
	
$pdf->Ln();


do
{					
				$pdf->SetX(10);
					$pdf->SetFontSize(7);
					$pdf->Cell(12,5,$result_guias_row['idguias_pedidos'],1,0,'C');
					$pdf->Cell(30,5,$result_guias_row['fecha_pago'],1,0,'C');
					$pdf->Cell(17,5,"$ ".$result_guias_row['monto'],1,0,'C');
					$pdf->Cell(17,5,"$ ".$result_guias_row['monto_mxn'],1,0,'C');
					$pdf->Cell(20,5,$moneda[$result_guias_row['moneda']],1,0,'C');
					$pdf->Cell(30,5,$metodo[$result_guias_row['metodo']],1,0,'C');
					$pdf->Cell(35,5,$result_guias_row['referencia'],1,0,'C');
					$pdf->Cell(35,5,$pagoTarjeta[$result_guias_row['pagoTarjeta']],1,0,'C');
				$pdf->Ln(5);
				$cantidaddeproductos = $cantidaddeproductos + $p->cantidad;
				
						$total = $total + $result_guias_row['monto'];
				
				$sumapagos = $sumapagos + $p->monto;
 }while($result_guias_row = $db->fetch_assoc($result_guias));     

$pdf->Ln();
$pdf->SetX(20);
					/*$pdf->SetFontSize(9);
					$pdf->Cell(35,5,'',0,0,'C');
					$pdf->Cell(70,5," Cantidad: ",0,0,'R');
					$pdf->Cell(12,5,$cantidaddeproductos,0,0,'C');
					/*$pdf->Cell(30,5," ",0,0,'C');
					$pdf->Cell(20,5,"SUBTOTAL $ ".number_format(($datos['total']+$datos['desc_directo']),2,'.',','),0,0,'R');*/
					//$pdf->Ln();
/*$pdf->SetX(20);					
					$pdf->Cell(35,5,'',0,0,'C');
					$pdf->Cell(70,5," ",0,0,'R');
					$pdf->Cell(12,5," ",0,0,'C');
					$pdf->Cell(30,5," ",0,0,'C');					
					$pdf->Cell(20,5,"DESCUENTO $ ".number_format($datos['desc_directo'],2,'.',','),0,0,'R');
					$pdf->Ln();*/
					
	/*$pdf->SetX(20);					
					$pdf->Cell(35,5,'',0,0,'C');
					$pdf->Cell(70,5," ",0,0,'R');
					$pdf->Cell(12,5," ",0,0,'C');
					$pdf->Cell(30,5," ",0,0,'C');		
					$pdf->Cell(10,5," ",0,0,'C');			
					$pdf->Cell(20,5,"MONTO $ ".number_format($result_guias_row['monto'],2,'.',','),0,0,'R');
					$pdf->Ln(3);*/
					
	$pdf->SetX(20);				
					$pdf->Cell(35,3,'',0,0,'C');
					$pdf->Cell(70,3," ",0,0,'R');
					$pdf->Cell(12,3," ",0,0,'C');
					$pdf->Cell(30,3," ",0,0,'C');		
					$pdf->Cell(10,3," ",0,0,'C');			
					$pdf->Cell(20,3,"PAGO $ ".number_format($total,2,'.',','),0,0,'R');
					$pdf->Ln(3);
					
$pdf->Ln(5);
$pdf->SetX(10);

/*$pdf->Line($pdf->GetX(),$pdf->GetY(),200,$pdf->GetY());

$sumaMonto = $sumaMonto + $result_guias_row['monto_liberacion'];



	$pdf->SetX(20);
	$pdf->Cell(35,1,'',0,0,'C');
					$pdf->Cell(70,5," ",0,0,'R');
					$pdf->Cell(12,5," ",0,0,'C');
					$pdf->Cell(30,5," ",0,0,'C');		
					$pdf->Cell(10,5," ",0,0,'C');			
					$pdf->Cell(20,5,"TOTAL (MONTO LIB) $".number_format($sumaMonto,2,'.',','),0,0,'R');
					$pdf->Ln(4);
					
	$pdf->SetX(20);	
	
	
	$pdf->Cell(35,1,'',0,0,'C');
					$pdf->Cell(70,5," ",0,0,'R');
					$pdf->Cell(12,5," ",0,0,'C');
					$pdf->Cell(30,5," ",0,0,'C');		
					$pdf->Cell(10,5," ",0,0,'C');			
					$pdf->Cell(20,5,"TOTAL (PAGOS) $".number_format($sumapagos,2,'.',','),0,0,'R');
					$pdf->Ln(4);*/
					
	$pdf->SetX(20);	
//$pdf->MultiCell(190,5,utf8_decode("- Comprobante de pago en la Joyeria KL. Para cualquier cambio o aclaración es necesario el traer este comprobante de pago para poder realizarlo. Las piezas deberán de venir en su empaque original. - No se recibirá producto dañado."),0,'J');

$pdf->Output();

?>