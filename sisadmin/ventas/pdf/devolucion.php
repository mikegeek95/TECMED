<?php
require_once("../../clases/class.Sesion.php");
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Devoluciones.php");
require_once("../../clases/fpdf/fpdf.php");
require_once("../../clases/class.Fechas.php");
require_once("../../clases/class.Configuracion.php");
require_once("../../clases/class.Sucursales.php");

 $se = new Sesion();


$db = new MySQL ();
$fecha = new Fechas ();
$devolucion = new Devoluciones();
$conf = new Configuracion();
$su = new Sucursales();

$idsucursales = $_SESSION['se_sas_Sucursal'];

//$idusuario = $se->obtenerSesion('se_sas_Usuario');

$devolucion->db = $db ;
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
	public $cliente;

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
    
	$this->SetY(0);
	$this->SetX(0);
    $this->SetFont('Arial','B',20);
   
    // Salto de línea
	if($result_logo_num != 0){
    $this->Image('../../images/configuracion/'.$result_logo_row['logo'],10,5,33);
	}
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

    $this->SetY(-20);

    // Arial italic 8

    $this->SetFont('Arial','I',7);
	
	$this->SetX(100);
	$this->Line($this->GetX(),$this->GetY(),60,$this->GetY());
	
	$this->SetX(120);
	$this->Line($this->GetX(),$this->GetY(),160,$this->GetY());
		
	$this->SetX(65);
	$this->MultiCell(190,5,$this->nombre_completo,0,'J');
	
	$this->SetX(122);
	$this->MultiCell(190,-5,$this->cliente,0,'J');
	
	
	$this->Ln(5);

    // Número de página
    /*$this->MultiCell(190,5,utf8_decode("- Le invitamos a revisar su mercancia antes de salir de la tienda."),0,'J');
	$this->MultiCell(190,5,utf8_decode("- Para poder realizar la devolución de producto es necesario presentar este comprobante de pago."),0,'J');
	$this->MultiCell(190,5,utf8_decode("- Las piezas deberán de venir en su empaque original."),0,'J');
    $this->Cell(0,10,utf8_decode('Página').$this->PageNo().'',0,0,'C');*/

}



//termina pie de página

}//TERMINA EXPENDEN DE PDF





// Creación del objeto de la clase heredada

$pdf =& new PDF ('P', 'mm', 'letter');
//$pdf =& new FPDF('P', 'mm', array(58, 500)); 


//parsear la informacion de la empresa.

//datos de la empresa

$iddevolucion = $_GET['id'];
$devolucion->iddevolucion = $iddevolucion;

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


//OBTENEMOS EL TOTAL DE LA DEVOLUCION


$result_devolucion_cabeza = $devolucion->BuscarDevolucion();
$row_devolucion_cabeza = $db->fetch_assoc($result_devolucion_cabeza);


$idnota_remision = $row_devolucion_cabeza['idnota_remision'];
$subtotal = $row_devolucion_cabeza['subtotal'];
$descuento = $row_devolucion_cabeza['descuento'];
$total = $row_devolucion_cabeza['total'];
$porc_cliente = $row_devolucion_cabeza['porc_descuento'];
$idusuario = $row_devolucion_cabeza['idusuarios'];

$sql_usuario = "SELECT * FROM usuarios WHERE idusuarios = '$idusuario'";
$result_usuario = $db->consulta($sql_usuario);
$result_usuario_row = $db->fetch_assoc($result_usuario);

$nombre = $result_usuario_row['nombre']." ".$result_usuario_row['paterno']." ".$result_usuario_row['materno'];

$pdf->nombre_completo = $nombre;


$sql = "SELECT c.nombre, c.paterno, c.materno, c.idcliente, c.saldo_monedero FROM nota_remision nr, clientes c WHERE nr.idnota_remision = '$idnota_remision' AND nr.idcliente = c.idcliente";
$result_sql = $db->consulta($sql);
$result_sql_row = $db->fetch_assoc($result_sql);

$clientes = $result_sql_row['nombre']." ".$result_sql_row['paterno']." ".$result_sql_row['materno'];

$pdf->cliente = $clientes;

 
 $saldo_monedero = $result_sql_row['saldo_monedero'];



$pdf->AddPage();
$pdf->SetMargins(10,1,0);
$pdf->SetFontSize(7);
$pdf->Cell(40,3,utf8_decode("DEVOLUCIÓN"));
$pdf->Ln();

$pdf->Cell(40,3,utf8_decode("COMPROBANTE DE PAGO (SIN EFECTOS FISCALES)"));
$pdf->Ln();
$pdf->Cell(40,3,utf8_decode("FECHA: ").$row_devolucion_cabeza['fecha']);
$pdf->Ln();
$pdf->Cell(40,3,utf8_decode("NO. DEVOLUCION : ").$iddevolucion);
$pdf->Ln();
$pdf->Cell(40,3,utf8_decode("NO. VENTA : ").$idnota_remision);
$pdf->Ln();
$idsuc = $row_devolucion_cabeza['idsucursales'];
$sql_suc = "SELECT * FROM sucursales WHERE idsucursales = '$idsuc'";
$result_suc = $db->consulta($sql_suc);
$result_suc_row = $db->fetch_assoc($result_suc);

$pdf->Cell(40,3,utf8_decode("SUCURSAL : ").strtoupper($result_suc_row['sucursal']));
$pdf->Ln();
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

$pdf->Cell(40,3,"SOCIO: ".strtoupper($clientes),0,0);
$pdf->Ln();


$pdf->SetX(20);
$pdf->Ln();
	$pdf->SetX(10);
	$pdf->Cell(15,5,"NOTA",1,0,'C');
	$pdf->Cell(24,5,"CLAVE",1,0,'C');
	$pdf->Cell(19,5,"CAT",1,0,'C');
	$pdf->Cell(80,5,"PRODUCTO",1,0,'C');
	$pdf->Cell(11,5,"CANT.",1,0,'C');
	$pdf->Cell(16,5,"PRECIO",1,0,'C');
	//$pdf->Cell(14,5,"% DESC",1,0,'C');
	$pdf->Cell(17,5,"DESC",1,0,'C');
	$pdf->Cell(15,5,"TOTAL",1,0,'C');
$pdf->Ln();



$result_devolucion = $devolucion->BuscarDevolucionDescripcion();
$row_devolucion = $db->fetch_assoc($result_devolucion);
$row_num_devolucion = $db->num_rows($result_devolucion);

$cantidaddeproductos = 0;
if($row_num_devolucion!=0)
{
	do
	{
				$idproducto = $row_devolucion['idproducto'];
				$sql2 = "SELECT cp.nombre as cat FROM productos p, categoria_precio cp WHERE p.idproducto = '$idproducto' AND p.idcategoria_precio = cp.idcategoria_precio";
					$result_cat = $db->consulta($sql2);
					$result_cat_row = $db->fetch_assoc($result_cat);
					
					$cat = $result_cat_row['cat'];
		
		$sql_tallas = "SELECT * FROM tallas WHERE idtallas = '".$row_devolucion['idtallas']."'";
		$result_tallas = $db->consulta($sql_tallas);
		$result_tallas_row = $db->fetch_assoc($result_tallas);
					
	            $pdf->SetX(10);
					$pdf->SetFontSize(6);
					$pdf->Cell(15,5,$row_devolucion['idnota_remision'],1,0,'C');
					$pdf->Cell(24,5,$row_devolucion['idproducto'],1,0,'C');
					$pdf->Cell(19,5," ".strtoupper($cat),1,0,'L');
					$pdf->Cell(80,5," ".strtoupper($row_devolucion['nombre']." #".$result_tallas_row['talla']),1,0,'L');
					$pdf->Cell(11,5,$row_devolucion['cantidad'],1,0,'C');
					$pdf->Cell(16,5,"$ ".number_format($row_devolucion['pv'],2,'.',','),1,0,'C');
					$tota_cantidad = $row_devolucion['cantidad'] * $row_devolucion['pv'];
					//$pdf->Cell(14,5,$row_devolucion['porc_desc'],1,0,'C');
					$pdf->Cell(17,5,$row_devolucion['total_descuento'],1,0,'C');
					$pdf->Cell(15,5,"$ ".number_format($row_devolucion['total'],2,'.',','),1,0,'C');
				$pdf->Ln(5);
				$cantidaddeproductos = $cantidaddeproductos + $row_devolucion['cantidad'];
	}while($row_devolucion = $db->fetch_assoc($result_devolucion));
}





$pdf->Ln();
$pdf->SetX(20);
					$pdf->SetFontSize(7);
					$pdf->Cell(35,3,'',0,0,'C');
					$pdf->Cell(70,3," Cantidad: ",0,0,'R');
					$pdf->Cell(12,3,$cantidaddeproductos,0,0,'C');
					$pdf->Cell(30,3," ",0,0,'C');
					$pdf->Cell(10,3," ",0,0,'C');
					$pdf->Cell(20,3,"SUBTOTAL $ ".number_format($subtotal,2,'.',','),0,0,'R');
					$pdf->Ln();
$pdf->SetX(20);					
					$pdf->Cell(35,3,'',0,0,'C');
					$pdf->Cell(70,3," ",0,0,'R');
					$pdf->Cell(12,3," ",0,0,'C');
					$pdf->Cell(30,3," ",0,0,'C');	
					$pdf->Cell(10,3," ",0,0,'C');				
					$pdf->Cell(20,3,"DESCUENTO $ ".number_format($descuento,2,'.',','),0,0,'R');
					$pdf->Ln();
$pdf->SetX(20);					
					$pdf->Cell(35,3,'',0,0,'C');
					$pdf->Cell(70,3," ",0,0,'R');
					$pdf->Cell(12,3," ",0,0,'C');
					$pdf->Cell(30,3," ",0,0,'C');	
					$pdf->Cell(10,3," ",0,0,'C');				
					$pdf->Cell(20,3,"TOTAL $ ".number_format($total,2,'.',','),0,0,'R');					
/**/
$pdf->Ln(10);

$pdf->SetX(20);
$pdf->Ln();

//bUSCAMOS EL REGISTRO EN CLIENTE MONEDERO
	$sql_monedero = "SELECT * FROM cliente_monedero WHERE idcliente_devolucion = '$iddevolucion'";
	$result_monedero = $db->consulta($sql_monedero);
	$result_monedero_row = $db->fetch_assoc($result_monedero);
	$result_monedero_num = $db->num_rows($result_monedero);
	

	//$pdf->SetX(10);
	$pdf->Cell(40,3,utf8_decode("MONEDERO ELETRÓNICO"));
	$pdf->Ln();
	$pdf->Cell(40,3,utf8_decode("SALDO ANTERIOR: ").($result_monedero_row['saldo_ant']));
	$pdf->Ln();
	$pdf->Cell(40,3,utf8_decode("SALDO ACTUAL: ").$result_monedero_row['saldo_act']);
	$pdf->Ln();

$pdf->SetX(10);
//$pdf->MultiCell(190,5,utf8_decode("- Comprobante de pago. Para cualquier cambio o aclaración es necesario el traer este comprobante de pago para poder realizarlo. Las piezas deberán de venir en su empaque original. - No se recibirá producto dañado."),0,'J');

$pdf->Output();

?>