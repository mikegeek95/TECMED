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

$idapartados = $_GET['id'];


$ventas->idapartados = $idapartados;
$datos = $ventas->verDatosApartado();

$cliente = $ventas->verClienteApartado();
 
 //$idniveles = $cliente['nivel'];
 
 //$sql = "SELECT * FROM niveles WHERE idniveles = '$idniveles'";
 //$result_nivel = $db->consulta($sql);
 //$result_nivel_row = $db->fetch_assoc($result_nivel);
 
 //$nivel = utf8_encode($result_nivel_row['nombre']);
 

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
	$this->SetX(20);
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
*/
}



//termina pie de página

}//TERMINA EXPENDEN DE PDF


$productos = $ventas->listaProductosenApartado();
$cantidaddeproductos = 0;

foreach($productos as $p )
    {				
		$cantidaddeproductos = $cantidaddeproductos + 1;
     }

// Creación del objeto de la clase heredada
$height = 215;
$height_productos = 5 * $cantidaddeproductos;

$height = $height + $height_productos;

//height 245

$pdf =& new PDF ('P', 'mm', array(80,$height));


//$pdf =& new PDF ('P', 'mm', 'letter');


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
$pdf->SetMargins(2,1,0);
$pdf->SetFontSize(6);
//$pdf->Ln();
$pdf->SetX(2);
$pdf->Cell(40,3,utf8_decode("NO. APARTADO : ").$ventas->idapartados);
$pdf->Ln();
$pdf->Cell(40,3,utf8_decode("FECHA: ").$datos['fecha']);
$pdf->Ln();


if ($cliente['clientes'] != "")
{utf8_decode($clientes = $cliente['clientes']);
}else {$clientes = "PUBLICO GENERAL"; }

//$pdf->Cell(100,7,"NIVEL: ".strtoupper($nivel),0,0);
$fecha_fin = $fecha->f_esp($datos['fecha_fin']);
$pdf->Cell(40,3,"F. FIN: ".strtoupper($fecha_fin),0,0);
$pdf->Ln();
$pdf->Cell(40,3,"SOCIO: ".strtoupper($clientes),0,0);
$pdf->Ln();

/*$pdf->Cell(100,7,"F. FIN: ".strtoupper($datos['fecha']),0,0);
$pdf->Ln();*/
/*if($pago > $total)
{
	$cambio =   $pago - $total;	
	$pdf->Cell(40,5,utf8_decode("CAMBIO: $".$cambio." PESOS"),0,0);	
	$pdf->Line(28,106,200,106);//LINEA PARA EL CAMPO CLIENTE	
	$pdf->Ln();
}*/
$pdf->SetX(0);
$pdf->Ln();
	$pdf->SetFontSize(6);
	$pdf->SetX(1);
	$pdf->Cell(11,3,"#",0,0,'C');
	$pdf->Cell(22,3,"COD",0,0,'C');
	$pdf->Cell(18,3,"CP",0,0,'C');
	$pdf->Cell(19,3,"PV",0,0,'C');
	$pdf->Ln();
	$pdf->Cell(11,3,"",0,0,'C');
	$pdf->Cell(22,3,"",0,0,'C');
	$pdf->Cell(18,3,"",0,0,'C');
	$pdf->Cell(19,3,"NOM",0,0,'L');
	
	//$pdf->Cell(13,3,"TOTAL",0,0,'C');
	
	/*$pdf->SetX(10);
	$pdf->Cell(34,7,"CLAVE",0,0,'C');
	$pdf->Cell(29,7,"CAT",0,0,'C');
	$pdf->Cell(74,7,"PRODUCTO",0,0,'C');
	$pdf->Cell(21,7,"CANT.",0,0,'C');
	$pdf->Cell(27,7,"PRECIO",0,0,'C');*/
	/*$pdf->Cell(15,7,"% DESC",1,0,'C');
	$pdf->Cell(18,7,"DESC",1,0,'C');
	$pdf->Cell(20,7,"TOTAL",1,0,'C');*/
$pdf->Ln();

	$pdf->SetX(2);
	$pdf->Cell(70,3,"=======================================================",0,0,'C');
	$pdf->Ln();
	

$productos = $ventas->listaProductosenApartado();
$cantidaddeproductos = 0;
$total = 0;
$count = 0;
foreach($productos as $p )
    {
					
					$sql2 = "SELECT cp.nombre as cat FROM productos p, categoria_precio cp WHERE p.idproducto = '".$p->idproducto."' AND p.idcategoria_precio = cp.idcategoria_precio";
					$result_cat = $db->consulta($sql2);
					$result_cat_row = $db->fetch_assoc($result_cat);
					
					$cat = $result_cat_row['cat'];
					
					$pdf->SetX(1);
					$pdf->SetFontSize(6);
	
					if($count != 0){
						$pdf->Cell(73,1,"_______________________________________________________",0,0,'C');
						$pdf->Ln(5);
					}
	
					$pdf->Cell(11,3,$p->cantidad,0,0,'C');
					$pdf->Cell(22,3,$p->idproducto,0,0,'C');
					$pdf->Cell(18,3," ".strtoupper($cat),0,0,'C');
					$pdf->Cell(19,3,"$ ".number_format($p->pv,2,'.',','),0,0,'C');
					
					$pdf->Ln();
					/*$pdf->Cell(15,3,"",0,0,'C');
					$pdf->Cell(10,3,"",0,0,'C');
					$pdf->Cell(18,3," ".strtoupper($p->nombre),0,0,'C');*/
					$pdf->MultiCell(65,3," ".strtoupper(/*substr(*/$p->nombre." - #".$p->talla/*,0,5)*/),0,0);
	
					$pdf->Ln();
					
					
					/*$pdf->Cell(15,5,$p->descuento_porc." %",1,0,'C');
					$pdf->Cell(18,5,"$ ".$p->descuento,1,0,'C');
					$tota_cantidad = ($p->cantidad * $p->pv) - $p->descuento;
					$pdf->Cell(20,5,"$ ".number_format($tota_cantidad,2,'.',','),1,0,'R');*/
				$cantidaddeproductos = $cantidaddeproductos + $p->cantidad;
				$total = $total + ($p->cantidad * $p->pv);
				//$total = $total + (($p->cantidad * $p->pv)-$p->descuento);
				$count++;
      }
	  

$pdf->Ln();

$pdf->SetFontSize(6);
$pdf->SetX(2);
$pdf->Cell(70,3,"=======================================================",0,0,'C');

$pdf->Ln();
$pdf->SetX(0);
					$pdf->SetFontSize(6);
					$pdf->SetX(0);
					$pdf->Cell(7,3," ",0,0,'R');
					$pdf->Cell(18,3," ",0,0,'R');
					$pdf->Cell(14,3," ",0,0,'R');
					$pdf->Cell(18,3," Cantidad: ",0,0,'R');
					$pdf->Cell(15,3,$cantidaddeproductos,0,0,'C');
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
		$pdf->Ln();			
	
	if($datos['abono'] > 0){
	$pdf->SetX(0);					
					$pdf->Cell(7,3,'',0,0,'C');
					$pdf->Cell(18,3," ",0,0,'R');
					$pdf->Cell(14,3," ",0,0,'C');
					$pdf->Cell(18,3," ",0,0,'C');		
					//$pdf->Cell(10,3," ",0,0,'C');			
					$pdf->Cell(15,3,"ABONO $ ".number_format($datos['abono'],2,'.',','),0,0,'R');
					$pdf->Ln();
	}
				
					
	$pdf->SetX(0);				
					$pdf->Cell(7,3,'',0,0,'C');
					$pdf->Cell(18,3," ",0,0,'R');
					$pdf->Cell(14,3," ",0,0,'C');
					$pdf->Cell(18,3," ",0,0,'C');		
					//$pdf->Cell(10,5," ",0,0,'C');			
					$pdf->Cell(15,3,"TOTAL SIN DESCUENTO $".number_format($total,2,'.',','),0,0,'R');
					$pdf->Ln();
					
					/*if($cliente['desc_producto'] > 0){
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
	
$pdf->Ln(7);


$pdf->SetX(2);

if($cliente['clientes'] != "")
	{
		$pdf->SetX(2);
		$pdf->Line($pdf->GetX(),$pdf->GetY(),70,$pdf->GetY());
	
		$pdf->SetX(0);
		$pdf->MultiCell(70,3,$cliente['clientes'],0,'C');
	}
	
	$pdf->Ln(3);

    // Número de página
   /* $pdf->MultiCell(70,3,utf8_decode("- Le invitamos a revisar su mercancia antes de salir de la tienda."),0,'J');
	$pdf->MultiCell(70,3,utf8_decode("- Para poder realizar la devolución de producto es necesario presentar este comprobante de pago."),0,'J');
	$pdf->MultiCell(70,3,utf8_decode("- Las piezas deberán de venir en su empaque original."),0,'J');
	*/
//$pdf->MultiCell(190,5,utf8_decode("- Comprobante de pago en la Joyeria KL. Para cualquier cambio o aclaración es necesario el traer este comprobante de pago para poder realizarlo. Las piezas deberán de venir en su empaque original. - No se recibirá producto dañado."),0,'J');

$pdf->Output();

?>