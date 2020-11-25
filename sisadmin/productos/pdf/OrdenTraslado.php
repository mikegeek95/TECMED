<?php
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Ventas.php");
require_once("../../clases/fpdf/fpdf.php");
require_once("../../clases/class.Fechas.php");
require_once("../../clases/class.Configuracion.php");
require_once("../../clases/class.Traspaso.php");
require_once("../../clases/class.Sesion.php");
require_once("../../clases/class.Sucursales.php");

$se = new Sesion();

$db = new MySQL ();
$fecha = new Fechas ();
$ventas = new Ventas();
$conf = new Configuracion();
$tra = new Traspaso();
$suc = new Sucursales();


$ventas->db = $db ;
$conf->db = $db;
$tra->db = $db;
$suc->db = $db;

$idsucursales = $_SESSION['se_sas_Sucursal'];

$ventas->id_notaremision = $_GET['id'];
$datos = $ventas->verDatosReciboCaja();
$cliente = $ventas->verClientePedido();

$tra->idtraspaso = $_GET['id'];

$result_traspaso = $tra->buscarTraspaso();
$result_traspaso_row = $db->fetch_assoc($result_traspaso);

$de = $result_traspaso_row['de'];
$para = $result_traspaso_row['para'];
$idusuarios = $result_traspaso_row['idusuarios'];
$observaciones = $result_traspaso_row['observaciones'];

$suc->idsucursales = $de;
$result_sucursal1 = $suc->buscarSucursal();
$result_sucursal1_row = $db->fetch_assoc($result_sucursal1);

$sucursal1 = utf8_encode($result_sucursal1_row['sucursal']);


$suc->idsucursales = $para;
$result_sucursal2 = $suc->buscarSucursal();
$result_sucursal2_row = $db->fetch_assoc($result_sucursal2);

$sucursal2 = utf8_encode($result_sucursal2_row['sucursal']);

$sql = "SELECT * FROM usuarios WHERE idusuarios = '$idusuarios'";
$result_usuario = $db->consulta($sql);
$result_usuario_row = $db->fetch_assoc($result_usuario);

$nombre = utf8_encode($result_usuario_row['nombre']);
$paterno = utf8_encode($result_usuario_row['paterno']);
$materno = utf8_encode($result_usuario_row['materno']);

$nombre_completo = $nombre." ".$paterno." ".$materno;

class PDF extends FPDF

{
	
	public $empresa;
	public $direccion;
	public $telefono;
	public $email;
	public $www;
	public $idsucursales;
	public $suc;
	public $db;
	public $nombre_completo;

// Cabecera de página

function Header()

{

	//$id = $_GET['id'];

	$tipo = $_GET['tipo'];

	$titulo ;
	
	//Obtenemos logo
	$sql_logo = "SELECT logo FROM configuracion";
	$result_logo = $this->db->consulta($sql_logo);
	$result_logo_num = $this->db->num_rows($result_logo);
	$result_logo_row = $this->db->fetch_assoc($result_logo);
	

	if ($tipo == 0)

	{

		$titulo = $this->empresa;

		

	}

	else if ($tipo == 5)

	{

		$titulo = "GENERA CREDITO ".$this->empresa; ;

	}

	

    // Logo

    $this->suc->db = $this->db;
	$this->suc->idsucursales = $this->idsucursales;
	$result_mi_sucursal = $this->suc->buscarSucursal();
	$result_mi_sucursal_row = $this->db->fetch_assoc($result_mi_sucursal);
	
	$result_sucursales = $this->suc->obtenerotrasSucursales();
	$result_sucursales_row = $this->db->fetch_assoc($result_sucursales);

    // Logo

    

    // Arial bold 15
    
	$this->SetY(0);
	$this->SetX(0);
    $this->SetFont('Arial','B',20);
   
    // Salto de línea
	if($result_logo_num != 0){
		$this->Image('../../images/configuracion/'.$result_logo_row['logo'],10,5,33);
	}
    //$this->Image('logo.png',10,5,33);
	$this->SetFont('Arial','B',8);
		
	$this->Ln(5);
	$this->SetX(50);
	if($this->idsucursales == 1){	
	$this->Cell(100,5,"Matriz",0,1);
	}else{
	$this->Cell(100,5,"Sucursal",0,1);
	}
	$this->SetFont('Arial','',8);
	$this->SetX(50);	
	$this->Cell(100,5,$result_mi_sucursal_row['sucursal'],0,1);	
	$this->SetX(50);
	//$this->Cell(100,5,$result_mi_sucursal_row['direccion'],0,1);
	$this->MultiCell(35,5,$result_mi_sucursal_row['direccion'],0,'J');
	$this->SetX(50);
	$this->Cell(100,5,$result_mi_sucursal_row['tel'],0,1);
	$this->SetX(50);
	$this->Cell(100,5,$result_mi_sucursal_row['email'],0,1);
	
	$count = 0;
	/*do
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
		$this->Cell(100,5,"Matriz",0,1);
	}else{
		$this->Cell(100,5,"Sucursal",0,1);
	}
	$this->SetFont('Arial','',8);
	$this->SetX($x);	
	$this->Cell(100,5,$result_sucursales_row['sucursal'],0,1);	
	$this->SetX($x);
	//$this->Cell(100,5,$result_sucursales_row['direccion'],0,1);
	$this->MultiCell(35,5,utf8_decode($result_sucursales_row['direccion']),0,'J');
	$this->SetX($x);
	$this->Cell(100,5,$result_sucursales_row['tel'],0,1);
	$this->SetX($x);
	$this->Cell(100,5,$result_sucursales_row['email'],0,1);
	
	$count++;
	
	}while($result_sucursales_row = $this->db->fetch_assoc($result_sucursales));*/
	
	
	$this->Ln(5);
	$this->Line($this->GetX(),$this->GetY(),200,$this->GetY());
    $this->Ln(2);
    
}



// Pie de página

function Footer()

{

    // Posición: a 1,5 cm del final
    $this->SetY(-18);

    // Arial italic 8

    $this->SetFont('Arial','I',8);
	
	
	


    // Número de página
   // $this->MultiCell(190,5,utf8_decode("- Le invitamos a revisar su mercancia antes de salir de la tienda."),0,'J');
	//$this->MultiCell(190,5,utf8_decode("- Para poder realizar la devolución de producto es necesario presentar este comprobante de pago."),0,'J');
	$this->SetX(80);
	$this->Line($this->GetX(),$this->GetY(),140,$this->GetY());

	$this->SetX(90);
	$this->MultiCell(190,5,utf8_decode($this->nombre_completo),0,'J');

    //$this->Cell(0,10,utf8_decode('Página').$this->PageNo().'',0,0,'C');

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
$pdf->suc = $suc;
$pdf->db = $db;
$pdf->nombre_completo = $nombre_completo;



$pdf->AddPage();
$pdf->SetMargins(10,1,0);
$pdf->SetFontSize(10);
$pdf->Cell(40,5,utf8_decode("FECHA: ").$fecha->fechaadd_mm_YYYY_entre());
$pdf->Ln();
$pdf->Cell(40,5,utf8_decode("TRASPASO : ").$tra->idtraspaso);
$pdf->Ln();
$pdf->Cell(40,5,"USUARIO : ".utf8_decode($nombre_completo));
$pdf->Ln();
$pdf->Cell(40,5,utf8_decode("DE : ").$sucursal1);
$pdf->Ln();
$pdf->Cell(40,5,utf8_decode("PARA : ").$sucursal2);
$pdf->Ln();




$pdf->SetX(20);
$pdf->Ln();
	$pdf->SetX(10);
	$pdf->Cell(35,7,"ID PRODUCTO",1,0,'C');
	$pdf->Cell(100,7,"NOMBRE",1,0,'C');
	$pdf->Cell(12,7,"CANT.",1,0,'C');
	$pdf->Cell(30,7,"PRECIO",1,0,'C');
	//$pdf->Cell(70,7,"OBSERVACIONES",1,0,'C');
	//$pdf->Cell(20,7,"TOTAL",1,0,'C');
$pdf->Ln();



$productos = $tra->listarProdctosenTraspaso();
$cantidaddeproductos = 0;

$row_productos = $db->fetch_assoc($result_productos);

/* do
{
	           $pdf->SetX(20);
					$pdf->SetFontSize(10);
					$pdf->Cell(35,5,$row_productos['idproducto'],1,0,'C');
					$pdf->Cell(70,5," ".strtoupper($row_productos['nombre']),1,0,'L');
					$pdf->Cell(12,5,$row_productos['cantidad'],1,0,'C');
					$pdf->Cell(30,5,"$ ".number_format($row_productos['pv'],2,'.',','),1,0,'C');
					$tota_cantidad = $row_productos['cantidad'] * $row_productos['pv'];
					//$pdf->Cell(20,5,"$ ".number_format($tota_cantidad,2,'.',','),1,0,'R');
				$pdf->Ln(5);
	
	
	
}while($row_productos = $db->fetch_assoc($result_productos));
*/
 foreach($productos as $p )


    {
				$pdf->SetX(10);
					$pdf->SetFontSize(10);
					$pdf->Cell(35,5,$p->idproducto,1,0,'C');
					$pdf->Cell(100,5," ".strtoupper($p->nombre),1,0,'L');
					$pdf->Cell(12,5,$p->cantidad,1,0,'C');
					$pdf->Cell(30,5,"$ ".number_format($p->pv,2,'.',','),1,0,'C');
					//$pdf->Cell(70,5," ".strtoupper($observaciones),1,0,'L');
					$tota_cantidad = $p->cantidad * $p->pv;
					//$pdf->Cell(20,5,"$ ".number_format($tota_cantidad,2,'.',','),1,0,'R');
				$pdf->Ln(5);
				$cantidaddeproductos = $cantidaddeproductos + $p->cantidad;
				$total_dev = $total_dev + ($p->cantidad * $p->pv);
      }
	  

$pdf->Ln();
$pdf->SetX(20);
					$pdf->SetFontSize(10);
					$pdf->Cell(35,5,'',0,0,'C');
					$pdf->Cell(70,5," Total: ",0,0,'R');
					$pdf->Cell(12,5,$cantidaddeproductos,0,0,'C');
					$pdf->Cell(20,5,"$ ".number_format($total_dev,2,'.',','),0,0,'R');
					$pdf->Ln();
$pdf->SetX(20);					
					/*$pdf->Cell(35,5,'',0,0,'C');
					$pdf->Cell(70,5," ",0,0,'R');
					$pdf->Cell(12,5," ",0,0,'C');
					$pdf->Cell(30,5," ",0,0,'C');					
					$pdf->Cell(20,5,"DESCUENTO $ ".number_format($datos['desc_directo'],2,'.',','),0,0,'R');
					$pdf->Ln();
$pdf->SetX(20);					
					$pdf->Cell(35,5,'',0,0,'C');
					$pdf->Cell(70,5," ",0,0,'R');
					$pdf->Cell(12,5," ",0,0,'C');
					$pdf->Cell(30,5," ",0,0,'C');					
					$pdf->Cell(20,5,"TOTAL $ ".number_format($datos['total'],2,'.',','),0,0,'R');	*/	

$pdf->Ln(10);
$pdf->SetX(10);
$pdf->MultiCell(190,5,utf8_decode("OBSERVACIONES: ".utf8_encode($observaciones)),0,'J');

$pdf->Output();

?>