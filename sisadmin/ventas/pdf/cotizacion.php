<?php
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Ventas.php");
require_once("../../clases/fpdf/fpdf.php");
require_once("../../clases/class.Fechas.php");
require_once("../../clases/class.Configuracion.php");
require_once("../../clases/class.Sesion.php");
require_once("../../clases/class.Sucursales.php");
      
   $se = new Sesion();



$db = new MySQL ();
$fecha = new Fechas ();
$ventas = new Ventas();
$conf = new Configuracion();
$su = new Sucursales();

$idsucursales = $_SESSION['se_sas_Sucursal'];

$ventas->db = $db ;
$conf->db = $db;

$idcotizacion = $_GET['id'];

$ventas->idcotizacion = $idcotizacion;
$datos = $ventas->verDatosReciboCotizacion();
$cliente = $ventas->verClienteCotizacion();
 
 $idniveles = $cliente['nivel'];
 
 $sql = "SELECT * FROM niveles WHERE idniveles = '$idniveles'";
 $result_nivel = $db->consulta($sql);
 $result_nivel_row = $db->fetch_assoc($result_nivel);
 
 $nivel = utf8_encode($result_nivel_row['nombre']);
 

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
	public $nombre_completo;

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
    $this->Image('logo.png',10,5,33);
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
	$this->MultiCell(35,5,utf8_decode($result_mi_sucursal_row['direccion']),0,'J');
	$this->SetX(50);
	$this->Cell(100,5,$result_mi_sucursal_row['tel'],0,1);
	$this->SetX(50);
	$this->Cell(100,5,$result_mi_sucursal_row['email'],0,1);
	
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
	
	}while($result_sucursales_row = $this->db->fetch_assoc($result_sucursales));
	
	
	$this->Ln(5);
	$this->Line($this->GetX(),$this->GetY(),200,$this->GetY());
    $this->Ln(2);
    
}



// Pie de página

function Footer()

{

    // Posición: a 1,5 cm del final

    $this->SetY(-20);

    // Arial italic 8

    $this->SetFont('Arial','I',8);
	
	if($this->nombre_completo != "")
	{
		$this->SetX(80);
		$this->Line($this->GetX(),$this->GetY(),140,$this->GetY());
	
		$this->SetX(90);
		$this->MultiCell(190,5,$this->nombre_completo,0,'J');
	}

    // Número de página
    $this->MultiCell(190,5,utf8_decode("- Le invitamos a revisar su mercancia antes de salir de la tienda."),0,'J');
	$this->MultiCell(190,5,utf8_decode("- Para poder realizar la devolución de producto es necesario presentar este comprobante de pago."),0,'J');
	$this->MultiCell(190,5,utf8_decode("- Las piezas deberán de venir en su empaque original."),0,'J');
    $this->Cell(0,10,utf8_decode('Página').$this->PageNo().'',0,0,'C');

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
$pdf->nombre_completo = $cliente['clientes'];


$pdf->AddPage();
$pdf->SetMargins(10,1,0);
$pdf->SetFontSize(9);
$pdf->Cell(40,3,utf8_decode("COTIZACIÓN"));
$pdf->Ln(5);
$pdf->Cell(100,5,utf8_decode("NO. COTIZACIÓN : ").$ventas->idcotizacion);
$pdf->Cell(40,5,utf8_decode("FECHA: ").$fecha->fechaadd_mm_YYYY_entre());
$pdf->Ln();


if ($cliente['clientes'] != "")
{utf8_decode($clientes = $cliente['clientes']);
}else {$clientes = "PUBLICO GENERAL"; }

$pdf->Cell(100,7,"NIVEL: ".strtoupper($nivel),0,0);
$pdf->Cell(40,7,"SOCIO: ".strtoupper($clientes),0,0);
$pdf->Ln();

$idsucursal = $datos['idsucursales'];
$sql_suc = "SELECT * FROM sucursales WHERE idsucursales = '$idsucursal'";
$result_suc = $db->consulta($sql_suc);
$result_suc_row = $db->fetch_assoc($result_suc);

$pdf->Cell(100,7,"SUCURSAL: ".strtoupper($result_suc_row['sucursal']),0,0);
$pdf->Ln();

if($pago > $total)
{
	$cambio =   $pago - $total;	
	$pdf->Cell(40,5,utf8_decode("CAMBIO: $".$cambio." PESOS"),0,0);	
	$pdf->Line(28,106,200,106);//LINEA PARA EL CAMPO CLIENTE	
	$pdf->Ln();
}
$pdf->SetX(20);
$pdf->Ln();
	$pdf->SetFontSize(8);
	$pdf->SetX(10);
	$pdf->Cell(25,7,"CLAVE",1,0,'C');
	$pdf->Cell(20,7,"CAT",1,0,'C');
	$pdf->Cell(55,7,"PRODUCTO",1,0,'C');
	$pdf->Cell(12,7,"CANT.",1,0,'C');
	$pdf->Cell(27,7,"PRECIO",1,0,'C');
	$pdf->Cell(15,7,"% DESC",1,0,'C');
	$pdf->Cell(18,7,"DESC",1,0,'C');
	$pdf->Cell(20,7,"TOTAL",1,0,'C');
$pdf->Ln();


$productos = $ventas->listaProdctosenCotizacion();
$cantidaddeproductos = 0;

foreach($productos as $p )
    {
					
					$sql2 = "SELECT cp.nombre as cat FROM productos p, categoria_precio cp WHERE p.idproducto = '".$p->idproducto."' AND p.idcategoria_precio = cp.idcategoria_precio";
					$result_cat = $db->consulta($sql2);
					$result_cat_row = $db->fetch_assoc($result_cat);
					
					$cat = $result_cat_row['cat'];
					
				$pdf->SetX(10);
					$pdf->SetFontSize(7);
					$pdf->Cell(25,5,$p->idproducto,1,0,'C');
					$pdf->Cell(20,5," ".strtoupper($cat),1,0,'L');
					$pdf->Cell(55,5," ".strtoupper($p->nombre),1,0,'L');
					$pdf->Cell(12,5,$p->cantidad,1,0,'C');
					$pdf->Cell(27,5,"$ ".number_format($p->pv,2,'.',','),1,0,'C');
					$pdf->Cell(15,5,$p->descuento_porc." %",1,0,'C');
					$pdf->Cell(18,5,"$ ".$p->descuento,1,0,'C');
					$tota_cantidad = ($p->cantidad * $p->pv) - $p->descuento;
					$pdf->Cell(20,5,"$ ".number_format($tota_cantidad,2,'.',','),1,0,'R');
				$pdf->Ln(5);
				$cantidaddeproductos = $cantidaddeproductos + $p->cantidad;
      }

$pdf->Ln();
$pdf->SetX(20);
					$pdf->SetFontSize(9);
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
					$pdf->Cell(20,5,"TOTAL $ ".number_format($datos['total'],2,'.',','),0,0,'R');
					$pdf->Ln(10);
					
	$pdf->SetX(20);				
					$pdf->Cell(35,5,'',0,0,'C');
					$pdf->Cell(70,5," ",0,0,'R');
					$pdf->Cell(12,5," ",0,0,'C');
					$pdf->Cell(30,5," ",0,0,'C');		
					$pdf->Cell(10,5," ",0,0,'C');			
					$pdf->Cell(20,5,"TOTAL SIN DESCUENTO $".number_format($cliente['total'] + $cliente['desc_producto'] + $cliente['desc_directo'],2,'.',','),0,0,'R');
					$pdf->Ln();
					
					if($cliente['desc_producto'] > 0){
	$pdf->SetX(20);					
					$pdf->Cell(35,5,'',0,0,'C');
					$pdf->Cell(70,5," ",0,0,'R');
					$pdf->Cell(12,5," ",0,0,'C');
					$pdf->Cell(30,5," ",0,0,'C');		
					$pdf->Cell(10,5," ",0,0,'C');			
					$pdf->Cell(20,5,"DESC NIVEL $".number_format($cliente['desc_producto'],2,'.',','),0,0,'R');
					$pdf->Ln();	
					}
				
				if($cliente['desc_directo'] > 0){	
	$pdf->SetX(20);					
					$pdf->Cell(35,5,'',0,0,'C');
					$pdf->Cell(70,5," ",0,0,'R');
					$pdf->Cell(12,5," ",0,0,'C');
					$pdf->Cell(30,5," ",0,0,'C');		
					$pdf->Cell(10,5," ",0,0,'C');			
					$pdf->Cell(20,5,"DESC DIRECTO $".number_format($cliente['desc_directo'],2,'.',','),0,0,'R');
					$pdf->Ln();	
				}
				
				
				if($datos['monto_virtual'] > 0){	
	$pdf->SetX(20);					
					$pdf->Cell(35,5,'',0,0,'C');
					$pdf->Cell(70,5," ",0,0,'R');
					$pdf->Cell(12,5," ",0,0,'C');
					$pdf->Cell(30,5," ",0,0,'C');		
					$pdf->Cell(10,5," ",0,0,'C');			
					$pdf->Cell(20,5,"PAGO CON MONEDERO $".number_format($datos['monto_virtual'],2,'.',','),0,0,'R');
					$pdf->Ln();	
				}
				
				$total = $datos['total'];
				if($datos['monto_virtual'] != 0){
					$total = $total - $datos['monto_virtual'];
				}

	$pdf->SetX(20);
	
					$pdf->Cell(35,5,'',0,0,'C');
					$pdf->Cell(70,5," ",0,0,'R');
					$pdf->Cell(12,5," ",0,0,'C');
					$pdf->Cell(30,5," ",0,0,'C');		
					$pdf->Cell(10,5," ",0,0,'C');			
					$pdf->Cell(20,5,"TOTAL A PAGAR $ ".number_format($total,2,'.',','),0,0,'R');				

$pdf->Ln(10);

$pdf->SetX(20);
$pdf->Ln();

/*
	//bUSCAMOS EL REGISTRO EN CLIENTE MONEDERO
	$sql_monedero = "SELECT * FROM cliente_monedero WHERE idnota_remision = '$idnota_remision'";
	$result_monedero = $db->consulta($sql_monedero);
	$result_monedero_row = $db->fetch_assoc($result_monedero);
	$result_monedero_num = $db->num_rows($result_monedero);
	
	if($result_monedero_num != 0){
	//$pdf->SetX(10);
	$pdf->Cell(40,5,utf8_decode("MONEDERO ELETRÓNICO"));
	$pdf->Ln();
	$pdf->Cell(40,5,utf8_decode("SALDO ANTERIOR: $").($result_monedero_row['saldo_ant']));
	$pdf->Ln();
	$pdf->Cell(40,5,utf8_decode("SALDO ACTUAL: $").$result_monedero_row['saldo_act']);
	$pdf->Ln();
	}*/
	
$pdf->SetX(10);
//$pdf->MultiCell(190,5,utf8_decode("- Comprobante de pago en la Joyeria KL. Para cualquier cambio o aclaración es necesario el traer este comprobante de pago para poder realizarlo. Las piezas deberán de venir en su empaque original. - No se recibirá producto dañado."),0,'J');

$pdf->Output();

?>