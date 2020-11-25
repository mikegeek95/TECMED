<?php
require_once("../../clases/class.Sesion.php");
require_once("../../clases/conexcion.php");
require_once("../../clases/fpdf/fpdf.php");
require_once("../../clases/class.Fechas.php");
require_once("../../clases/class.Configuracion.php");
require_once("../../clases/class.Sucursales.php");
require_once("../../clases/class.Clientes.php");

 $se = new Sesion();


$db = new MySQL ();
$fecha = new Fechas ();
$conf = new Configuracion();
$su = new Sucursales();
$cli = new Clientes();

$idsucursales = $_SESSION['se_sas_Sucursal'];

$tipo = array('ABONO','CARGO');

$cli->db = $db;
$conf->db = $db;



class PDF extends FPDF

{
	
	public $empresa;
	public $direccion;
	public $telefono;
	public $email;
	public $www;
	public $logo;
	public $idsucursales;
	public $su;
	public $db;

// Cabecera de página

function Header()

{

	//$id = $_GET['id'];

	$titulo = $this->empresa;;
   
   //Obtenemos logo
	$sql_logo = "SELECT logo FROM configuracion";
	$result_logo = $this->db->consulta($sql_logo);
	$result_logo_num = $this->db->num_rows($result_logo);
	$result_logo_row = $this->db->fetch_assoc($result_logo);
   
   $this->su->db = $this->db;
	$this->su->idsucursales = $this->idsucursales;
	$result_mi_sucursal = $this->su->buscarSucursal();
	$result_mi_sucursal_row = $this->db->fetch_assoc($result_mi_sucursal);
	
	$result_sucursales = $this->su->obtenerotrasSucursales();
	$result_sucursales_row = $this->db->fetch_assoc($result_sucursales);

    // Logo

    

    // Arial bold 15
	$this->SetMargins(0,0,0);
    // Salto de línea
	if($result_logo_num != 0){
    $this->Image('../../images/configuracion/'.$result_logo_row['logo'],25,2,25);
	}
	$this->SetY(29);
	$this->SetX(33);
		/*if($this->idsucursales == 1){	
		$this->Cell(100,5,"Matriz",0,1);
		}else{
		$this->Cell(100,5,"Sucursal",0,1);
		}*/
	$this->SetFont('Arial','B',6);
	$this->Cell(0,3,$result_mi_sucursal_row['sucursal'],0,1);	
	$this->SetFont('Arial','',6);
	$this->SetX(20);
	$this->MultiCell(35,3,$result_mi_sucursal_row['direccion'],0,'C');
	$this->SetX(30);
	$this->Cell(0,3,$result_mi_sucursal_row['tel'],0,1);
	$this->SetX(26);
	$this->Cell(0,3,$result_mi_sucursal_row['email'],0,1);
	
	/*$count = 0;
	do
	{
		if($count == 0){
			$x = 42;
		}else{
			$x = $x + 40;
		}
	$this->SetY($x);
		/*if($result_sucursales_row['idsucursales'] == 1){
			$this->Cell(100,5,"Matriz",0,1);
		}else{
			$this->Cell(100,5,"Sucursal",0,1);
		}*/
	/*$this->SetX(22);
	$this->SetFont('Arial','B',6);
	$this->Cell(0,3,$result_sucursales_row['sucursal'],0,1);	
	$this->SetFont('Arial','',6);
	$this->SetX(10);
	$this->MultiCell(35,3,utf8_decode($result_sucursales_row['direccion']),0,'C');
	$this->SetX(21);
	$this->Cell(0,3,$result_sucursales_row['tel'],0,1);
	$this->SetX(16);
	$this->Cell(0,3,$result_sucursales_row['email'],0,1);

	$count++;
	
	}while($result_sucursales_row = $this->db->fetch_assoc($result_sucursales));*/
	
	
	$this->Ln(3);
	$this->SetX(2);
	$this->Line($this->GetX(),$this->GetY(),70,$this->GetY());
    $this->Ln(2);
    
}



// Pie de página

function Footer()

{

    /*// Posición: a 1,5 cm del final

    $this->SetY(-18);

    // Arial italic 8

    $this->SetFont('Arial','I',7);

    // Número de página
    $this->MultiCell(190,5,utf8_decode("- Le invitamos a revisar su mercancia antes de salir de la tienda."),0,'J');
	$this->MultiCell(190,5,utf8_decode("- Para poder realizar la devolución de producto es necesario presentar este comprobante de pago."),0,'J');
	$this->MultiCell(190,5,utf8_decode("- Las piezas deberán de venir en su empaque original."),0,'J');
    $this->Cell(0,10,utf8_decode('Página').$this->PageNo().'',0,0,'C');*/

}



//termina pie de página

}//TERMINA EXPENDEN DE PDF




$height = 195;
$height_productos = 5 * $cantidaddeproductos;

$height = $height + $height_productos;

//height 245

$pdf =& new PDF ('P', 'mm', array(80,$height));


// Creación del objeto de la clase heredada

//$pdf =& new PDF ('P', 'mm', 'letter');


//parsear la informacion de la empresa.

//datos de la empresa

$idcliente_monedero = $_GET['id'];

$cli->idcliente_monedero = $idcliente_monedero;

$empresa = $conf->ObtenerInformacionConfiguracion();


$pdf->empresa = $empresa['nombre_empresa'];
$pdf->direccion = $empresa['direccion'];
$pdf->telefono = $empresa['telefonos'];
$pdf->email = $empresa['email'];
$pdf->www = $empresa['url'];
$pdf->logo = $empresa['logo'];
$pdf->idsucursales = $idsucursales;
$pdf->su = $su;
$pdf->db = $db;

//Obtenemos nombre del cliente
$sql = "SELECT c.nombre, c.paterno, c.materno FROM  clientes c, cliente_monedero cm WHERE c.idcliente = cm.idcliente AND cm.idcliente_monedero = '$idcliente_monedero'";
$result_nombre = $db->consulta($sql);
$result_nombre_row = $db->fetch_assoc($result_nombre);

$clientes = utf8_encode($result_nombre_row['nombre']." ".$result_nombre_row['paterno']." ".$result_nombre_row['materno']);



$pdf->AddPage();
$pdf->SetMargins(2,1,0);
$pdf->SetFontSize(6);
$pdf->SetX(2);
$pdf->Cell(40,3,utf8_decode("COMPROBANTE DE DEPOSITO (SIN EFECTOS FISCALES)"));
$pdf->Ln();
$pdf->Cell(40,3,utf8_decode("FECHA IMPRESIÓN: ").$fecha->fechaadd_mm_YYYY_entre());
$pdf->Ln();
//$pdf->Cell(40,3,utf8_decode("NO. DEVOLUCION : ").$iddevolucion);
//$pdf->Ln();
//$pdf->Cell(40,3,utf8_decode("DESCUENTO SOCIO: ").$porc_cliente."%");
//$pdf->Ln();

//$clientes = "PUBLICO GENERAL";

/*if ($cliente['clientes'] != "")
{
	//utf8_decode($clientes = $cliente['clientes']);
	$clientes = "PUBLICO GENERAL";
}
else 
{
    $clientes = "PUBLICO GENERAL"; 
}
*/

$clientes = utf8_decode($clientes);

$pdf->Cell(40,3,"SOCIO: ".strtoupper($clientes),0,0);
$pdf->Ln();


$pdf->SetX(0);
$pdf->Ln();
	$pdf->SetX(2);
	$pdf->Cell(17,3,"FECHA",0,0,'C');
	//$pdf->Cell(40,5,"CONCEPTO",1,0,'C');
	$pdf->Cell(17,3,"MONTO",0,0,'C');
	$pdf->Cell(17,3,"SALDO ANT.",0,0,'C');
	$pdf->Cell(17,3,"SALDO ACTUAL",0,0,'C');
	/*$pdf->Cell(27,5,"PRECIO",1,0,'C');
	$pdf->Cell(15,5,"% DESC",1,0,'C');
	$pdf->Cell(18,5,"DESC",1,0,'C');
	$pdf->Cell(20,5,"TOTAL",1,0,'C');*/
$pdf->Ln();

$pdf->SetX(2);
	$pdf->Cell(70,3,"=======================================================",0,0,'C');
	$pdf->Ln();


$result_mov = $cli->buscarMovimientoMonedero();
$result_mov_row = $db->fetch_assoc($result_mov);
$result_mov_num = $db->num_rows($result_mov);

//die($result_mov_num." dfdf");

$cantidaddeproductos = 0;
if($result_mov_num!=0)
{
	do
	{
				$idcliente = $result_mov_row['idcliente'];
				
				//$cli->idCliente = $idcliente;
				//$result_cliente = $cli->ObtenerInformacionCliente();
					
	            $pdf->SetX(2);
					$pdf->SetFontSize(5.5);
					$pdf->Cell(17,3,$result_mov_row['fecha'],0,0,'C');
					//$pdf->Cell(40,5,$result_mov_row['concepto'],1,0,'C');
					$pdf->Cell(17,3,"$ ".$result_mov_row['monto'],0,0,'C');
					$pdf->Cell(17,3,"$ ".$result_mov_row['saldo_ant'],0,0,'C');
					$pdf->Cell(17,3,"$ ".$result_mov_row['saldo_act'],0,0,'C');
					/*$pdf->Cell(27,5,"$ ".number_format($row_devolucion['pv'],2,'.',','),1,0,'C');
					$tota_cantidad = $row_devolucion['cantidad'] * $row_devolucion['pv'];
					$pdf->Cell(15,5,$row_devolucion['porc_desc'],1,0,'C');
					$pdf->Cell(18,5,$row_devolucion['total_descuento'],1,0,'C');
					$pdf->Cell(20,5,"$ ".number_format($row_devolucion['total'],2,'.',','),1,0,'R');*/
				$pdf->Ln();
				$cantidaddeproductos = $cantidaddeproductos + $row_devolucion['cantidad'];
				$concepto = $result_mov_row['concepto'];
				$tip = $result_mov_row['tipo'];
	}while($result_mov_row = $db->fetch_assoc($result_mov));
}

$pdf->SetFontSize(6);
$pdf->SetX(2);
	$pdf->Cell(70,3,"=======================================================",0,0,'C');
	$pdf->Ln();



$pdf->Ln();
/*$pdf->SetX(20);
					$pdf->SetFontSize(7);
					$pdf->Cell(35,3,'',0,0,'C');
					$pdf->Cell(70,3," Cantidad: ",0,0,'R');
					$pdf->Cell(12,3,$cantidaddeproductos,0,0,'C');
					$pdf->Cell(30,3," ",0,0,'C');
					$pdf->Cell(20,3,"SUBTOTAL $ ".number_format($subtotal,2,'.',','),0,0,'R');
					$pdf->Ln();
$pdf->SetX(20);					
					$pdf->Cell(35,3,'',0,0,'C');
					$pdf->Cell(70,3," ",0,0,'R');
					$pdf->Cell(12,3," ",0,0,'C');
					$pdf->Cell(30,3," ",0,0,'C');					
					$pdf->Cell(20,3,"DESCUENTO $ ".number_format($descuento,2,'.',','),0,0,'R');
					$pdf->Ln();
$pdf->SetX(20);					
					$pdf->Cell(35,3,'',0,0,'C');
					$pdf->Cell(70,3," ",0,0,'R');
					$pdf->Cell(12,3," ",0,0,'C');
					$pdf->Cell(30,3," ",0,0,'C');					
					$pdf->Cell(20,3,"TOTAL $ ".number_format($total,2,'.',','),0,0,'R');	*/				
/**/
$pdf->Ln(10);

$pdf->SetX(2);
$pdf->Ln();
	//$pdf->SetX(10);
	$pdf->Cell(40,3,strtoupper("TIPO: ".$tipo[$tip]));
	$pdf->Ln();
	$pdf->Cell(40,3,strtoupper("CONCEPTO: ".$concepto));
	$pdf->Ln();/*
	$pdf->Cell(40,3,utf8_decode("SALDO ANTERIOR: ").($saldo_monedero - $total));
	$pdf->Ln();
	$pdf->Cell(40,3,utf8_decode("SALDO ACTUAL: ").$saldo_monedero);
	$pdf->Ln();

$pdf->SetX(10);
$pdf->MultiCell(190,5,utf8_decode("- Comprobante de pago en la Joyeria KL. Para cualquier cambio o aclaración es necesario el traer este comprobante de pago para poder realizarlo. Las piezas deberán de venir en su empaque original. - No se recibirá producto dañado."),0,'J');*/

$pdf->Output();

?>