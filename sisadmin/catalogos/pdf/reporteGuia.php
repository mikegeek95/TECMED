<?php
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Ventas.php");
require_once("../../clases/class.Guias.php");
require_once("../../clases/fpdf/fpdf.php");
require_once("../../clases/class.Fechas.php");
require_once("../../clases/class.Configuracion.php");
require_once("../../clases/class.Sesion.php");
require_once("../../clases/class.Sucursales.php");
      
   $se = new Sesion();



$db = new MySQL ();
$fecha = new Fechas ();
$guias = new Guias();
$conf = new Configuracion();
$su = new Sucursales();
$ventas = new Ventas();

$idsucursales = $_SESSION['se_sas_Sucursal'];

$guias->db = $db;
$conf->db = $db;
$ventas->db = $db;

$idguias_pedidos = $_GET['id'];

$guias->idguias_pedidos = $idguias_pedidos;

$result_guias = $guias->buscarGuia();
$result_guias_row = $db->fetch_assoc($result_guias);

$idproveedores = $result_guias_row['idproveedores'];

$sql_proveedor = "SELECT * FROM proveedores WHERE idproveedores = '$idproveedores'";
$result_proveedor = $db->consulta($sql_proveedor);
$result_proveedor_row = $db->fetch_assoc($result_proveedor);

$proveedor = utf8_encode($result_proveedor_row['nombre']);


$paqueteria = array('DHL','UPS','FEDEX','ESTAFETA');
$est_recibido = array ('PENDIENTE','EN TRANSITO','EN ADUANA','RECIBIDO');
$est_pago = array ('PENDIENTE PAGO','PAGADO','CANCELADO');


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
//$pdf->Ln();
$pdf->Cell(70,5,utf8_decode("NO. PEDIDO : ").$result_guias_row['no_pedido']);
$pdf->Cell(70,5,utf8_decode("PROVEEDOR : ").strtoupper($proveedor));
$pdf->Cell(70,5,utf8_decode("NO. GUIA : ").$result_guias_row['no_guia']);
//$pdf->Cell(40,5,utf8_decode("FECHA: ").$fecha->fechaadd_mm_YYYY_entre());
$pdf->Ln();

$pdf->Cell(70,7,"PAQUETERIA: ".strtoupper($paqueteria[$result_guias_row['paqueteria']]),0,0);
$pdf->Cell(70,7,"EST. PAGO: ".strtoupper($est_pago[$result_guias_row['est_pago']]),0,0);
$pdf->Cell(70,7,"EST. RECIBO: ".strtoupper($est_recibido[$result_guias_row['est_recibido']]),0,0);
$pdf->Ln();

if($result_guias_row['est_recibido'] == 3){
	$pdf->Cell(70,7,"F. RECIBIDO: ".strtoupper($result_guias_row['f_recibido']),0,0);
	$pdf->Cell(70,7,"RECIBIO: ".strtoupper(utf8_encode($result_guias_row['recibio'])),0,0);
	$pdf->Ln();
}



//$pdf->Cell(70,7,"F. RECIBIDO: ".strtoupper($paqueteria[$result_guias_row['paqueteria']]),0,0);
if($result_guias_row['facturado'] == 1){
	$pdf->Cell(70,7,"NO. FACTURA: ".strtoupper($result_guias_row['no_factura']),0,0);
	$pdf->Ln();
}



$pdf->SetX(20);
$pdf->Ln();
	$pdf->SetFontSize(9);
	$pdf->SetX(10);
	$pdf->Cell(15,7,"LOTE",1,0,'C');
	$pdf->Cell(35,7,"FECHA PAGO",1,0,'C');
	$pdf->Cell(35,7,"MONTO",1,0,'C');
	$pdf->Cell(30,7,"MONEDA",1,0,'C');
	$pdf->Cell(40,7,"METODO",1,0,'C');
	$pdf->Cell(35,7,"REFERENCIA",1,0,'C');
	/*$pdf->Cell(18,7,"DESC",1,0,'C');
	$pdf->Cell(20,7,"TOTAL",1,0,'C');*/
$pdf->Ln();


$productos = $ventas->listarProdctosenPedido();
$cantidaddeproductos = 0;

$pagos = $guias->listaPagoenGuias();

foreach($pagos as $p )
    {
				$moneda = array('USD','MXN');
				$metodo = array('EFECTIVO','DEPOSITO BANCARIO','MONEY GRAM','WESTER UNION','PAYPAL');
					
				$pdf->SetX(10);
					$pdf->SetFontSize(9);
					$pdf->Cell(15,5,$p->idguias_pedidos,1,0,'C');
					$pdf->Cell(35,5," ".strtoupper($p->fecha_pago),1,0,'L');
					$pdf->Cell(35,5," $ ".strtoupper($p->monto),1,0,'L');
					$pdf->Cell(30,5,$moneda[$p->moneda],1,0,'C');
					$pdf->Cell(40,5,$metodo[$p->metodo],1,0,'C');
					$pdf->Cell(35,5,$p->referencia,1,0,'C');
					/*$pdf->Cell(18,5,"$ ".$p->descuento,1,0,'C');
					$tota_cantidad = ($p->cantidad * $p->pv) - $p->descuento;
					$pdf->Cell(20,5,"$ ".number_format($tota_cantidad,2,'.',','),1,0,'R');*/
				$pdf->Ln(5);
				$cantidaddeproductos = $cantidaddeproductos + $p->cantidad;
				
				$total = $total + $p->monto;
      }

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
					
	$pdf->SetX(20);					
					$pdf->Cell(35,5,'',0,0,'C');
					$pdf->Cell(70,5," ",0,0,'R');
					$pdf->Cell(12,5," ",0,0,'C');
					$pdf->Cell(30,5," ",0,0,'C');		
					$pdf->Cell(10,5," ",0,0,'C');			
					$pdf->Cell(20,5,"MONTO $ ".number_format($result_guias_row['monto'],2,'.',','),0,0,'R');
					$pdf->Ln(7);
					
	$pdf->SetX(20);				
					$pdf->Cell(35,5,'',0,0,'C');
					$pdf->Cell(70,5," ",0,0,'R');
					$pdf->Cell(12,5," ",0,0,'C');
					$pdf->Cell(30,5," ",0,0,'C');		
					$pdf->Cell(10,5," ",0,0,'C');			
					$pdf->Cell(20,5,"TOTAL (PAGOS) $".number_format($total,2,'.',','),0,0,'R');
					$pdf->Ln(7);
					
	$pdf->SetX(20);	
					
					
					if(($result_guias_row['monto']-$total) > 0){
					$pdf->Cell(35,5,'',0,0,'C');
					$pdf->Cell(70,5," ",0,0,'R');
					$pdf->Cell(12,5," ",0,0,'C');
					$pdf->Cell(30,5," ",0,0,'C');		
					$pdf->Cell(10,5," ",0,0,'C');			
					$pdf->Cell(20,5,"TOTAL A PAGAR $ ".number_format($result_guias_row['monto'] - $total,2,'.',','),0,0,'R');
					}

$pdf->Ln(10);
$pdf->SetX(10);
//$pdf->MultiCell(190,5,utf8_decode("- Comprobante de pago en la Joyeria KL. Para cualquier cambio o aclaración es necesario el traer este comprobante de pago para poder realizarlo. Las piezas deberán de venir en su empaque original. - No se recibirá producto dañado."),0,'J');

$pdf->Output();

?>