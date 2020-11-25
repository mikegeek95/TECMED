<?php
/*=============================*
*  Proyecto: CALZADO DAYANARA *
*     CAPSE - 12/02/2019      *
* I.S.C José Carlos Santillán *
*=============================*/

//Importamos las clases que vamos a utilizar
require_once("../../clases/conexcion.php");
require_once("../../clases/class.Sobrepedidos.php");
require_once("../../clases/fpdf/fpdf.php");
require_once("../../clases/class.Fechas.php");
require_once("../../clases/class.Configuracion.php");
require_once("../../clases/class.Sesion.php");
require_once("../../clases/class.Sucursales.php");

//Declaramos los objetos de clases
$se = new Sesion();
$db = new MySQL();
$fecha = new Fechas();
$sp = new Sobrepedidos();
$conf = new Configuracion();
$su = new Sucursales();

//Enviamos el objeto de conexión a las clases que lo requieren
$sp->db = $db;
$conf->db = $db;

//Declaramos variables a utilizar
$idsucursales = $_SESSION['se_sas_Sucursal'];


//Recibimos parametros enviados por metodo GET
$idsobrepedido = $_GET['id'];

$sp->idsobrepedido = $idsobrepedido;
$result_sobrepedido = $sp->buscar_sobrepedido();
$result_sobrepedido_row = $db->fetch_assoc($result_sobrepedido);

$sql_cliente = "SELECT * FROM clientes WHERE idcliente = '".$result_sobrepedido_row['idcliente']."'";
$result_cliente = $db->consulta($sql_cliente);
$result_cliente_row = $db->fetch_assoc($result_cliente);
 
 $idniveles = $result_cliente_row['nivel'];
 
 $sql = "SELECT * FROM niveles WHERE idniveles = '$idniveles'";
 $result_nivel = $db->consulta($sql);
 $result_nivel_row = $db->fetch_assoc($result_nivel);
 
 $nivel = utf8_encode($result_nivel_row['nombre']);
 
$estatus = array('Pendiente','Autorizado','Cancelado','Despachado');



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

    $this->SetFont('Arial','I',8);
	
	if($this->nombre_completo != "")
	{
		$this->SetX(80);
		$this->Line($this->GetX(),$this->GetY(),140,$this->GetY());
	
		$this->SetX(90);
		$this->MultiCell(190,5,$this->nombre_completo,0,'J');
	}

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


//parsear la informacion de la empresa.

//datos de la empresa

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
//$pdf->Ln();

$pdf->Cell(100,5,utf8_decode("NO. PEDIDO : ").$idsobrepedido);
$pdf->Cell(40,5,utf8_decode("FECHA: ").$result_sobrepedido_row['fecha']);
$pdf->Ln();


if($result_nivel_num != 0){
$pdf->Cell(100,7,"NIVEL: ".strtoupper($nivel),0,0);
}
$pdf->Cell(40,7,"SOCIO: ".strtoupper($result_cliente_row['nombre']." ".$result_cliente_row['paterno']." ".$result_cliente_row['materno']),0,0);
$pdf->Ln();

$pdf->Cell(40,7,"ESTATUS: ".strtoupper($estatus[$result_sobrepedido_row['estatus']]),0,0);
$pdf->Ln();


$pdf->SetX(20);
$pdf->Ln();
	$pdf->SetFontSize(8);
	$pdf->SetX(10);
	$pdf->Cell(25,7,"CLAVE",1,0,'C');
	$pdf->Cell(20,7,"CAT",1,0,'C');
	$pdf->Cell(80,7,"PRODUCTO",1,0,'C');
	$pdf->Cell(12,7,"CANT.",1,0,'C');
	$pdf->Cell(20,7,"PRECIO",1,0,'C');
	$pdf->Cell(20,7,"TOTAL",1,0,'C');
$pdf->Ln();


$productos = $sp->obtener_detalle_sobrepedido();
$productos_row = $db->fetch_assoc($productos);
$cantidaddeproductos = 0;
$total = 0;
$count = 0;


do
{
					
	$sql2 = "SELECT cp.nombre as cat, cp.idcategoria_precio as idcategoria_precio FROM productos p, categoria_precio cp WHERE p.idproducto = '".$productos_row['idproducto']."' AND p.idcategoria_precio = cp.idcategoria_precio";
	$result_cat = $db->consulta($sql2);
	$result_cat_row = $db->fetch_assoc($result_cat);

	$cat = $result_cat_row['cat'];
	$idcategoria_precio = $result_cat_row['idcategoria_precio'];


	$sql_talla = "SELECT * FROM tallas WHERE idtallas = '".$productos_row['talla']."'";
	$tallas = $db->consulta($sql_talla);
	$tallas_row = $db->fetch_assoc($tallas);
	
	$pdf->SetX(10);
	$pdf->SetFontSize(7);
	$pdf->Cell(25,5,$productos_row['idproducto'],1,0,'C');
	$pdf->Cell(20,5," ".strtoupper($cat),1,0,'L');
	$pdf->Cell(80,5," ".strtoupper(/*substr(*/$productos_row['nombre']." - #".$tallas_row['talla']/*,0,5)*/),1,0,'L');
	$pdf->Cell(12,5,$productos_row['cantidad'],1,0,'C');
	$pdf->Cell(20,5,"$".number_format($productos_row['pv']),1,0,'C');
	
	$tota_cantidad = ($productos_row['cantidad'] * $productos_row['pv']);
	$pdf->Cell(20,5,"$ ".number_format($tota_cantidad,2,'.',','),1,0,'R');
				
	$pdf->Ln(5);										
				
	$cantidaddeproductos = $cantidaddeproductos + $productos_row['cantidad'];
	$total = $total + $productos_row['subtotal'];
	$count++;
 }while($productos_row = $db->fetch_assoc($productos));


$pdf->Ln();
$pdf->SetX(20);
					$pdf->SetFontSize(9);
					$pdf->Cell(35,5,'',0,0,'C');
					$pdf->Cell(70,5," Cantidad: ",0,0,'R');
					$pdf->Cell(12,5,$cantidaddeproductos,0,0,'C');
					
					
	/*$pdf->SetX(20);					
					$pdf->Cell(35,5,'',0,0,'C');
					$pdf->Cell(70,5," ",0,0,'R');
					$pdf->Cell(12,5," ",0,0,'C');
					$pdf->Cell(30,5," ",0,0,'C');		
					$pdf->Cell(10,5," ",0,0,'C');			
					$pdf->Cell(20,5,"TOTAL A PAGAR $ ".number_format($datos['total'],2,'.',','),0,0,'R');
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
	*/
	
					$pdf->Cell(35,5,'',0,0,'C');
					$pdf->Cell(70,5," ",0,0,'R');
					$pdf->Cell(12,5," ",0,0,'C');
					$pdf->Cell(30,5," ",0,0,'C');		
					$pdf->Cell(10,5," ",0,0,'C');			
					$pdf->Cell(20,5,"TOTAL A PAGAR $ ".number_format($total,2,'.',','),0,0,'R');


		if($datos['monto_efec'] > 0){	
	$pdf->SetX(0);
			
					$pdf->Cell(35,5,'',0,0,'C');
					$pdf->Cell(70,5," ",0,0,'R');
					$pdf->Cell(12,5," ",0,0,'C');
					$pdf->Cell(30,5," ",0,0,'C');		
					$pdf->Cell(10,5," ",0,0,'C');			
					$pdf->Cell(20,5,"PAGO EFECTIVO $ ".number_format($datos['monto_efec'],2,'.',','),0,0,'R');
			
					$pdf->Ln();	
				}
				
				
				if($datos['monto_tc'] > 0){	
	$pdf->SetX(0);					
					
					$pdf->Cell(35,5,'',0,0,'C');
					$pdf->Cell(70,5," ",0,0,'R');
					$pdf->Cell(12,5," ",0,0,'C');
					$pdf->Cell(30,5," ",0,0,'C');		
					$pdf->Cell(10,5," ",0,0,'C');			
					$pdf->Cell(20,5,"PAGO CON TARJETA $ ".number_format($datos['monto_tc'],2,'.',','),0,0,'R');
					
					$pdf->Ln();	
				}
				
				
				if($datos['cambio'] > 0){	
	$pdf->SetX(0);					
					$pdf->Cell(9,3,'',0,0,'C');
					$pdf->Cell(14,3," ",0,0,'R');
					$pdf->Cell(8,3," ",0,0,'C');
					$pdf->Cell(12,3," ",0,0,'C');		
					$pdf->Cell(12,3," ",0,0,'C');			
					$pdf->Cell(12,3,"CAMBIO $".number_format($datos['cambio'],2,'.',','),0,0,'R');
					
					$pdf->Cell(35,5,'',0,0,'C');
					$pdf->Cell(70,5," ",0,0,'R');
					$pdf->Cell(12,5," ",0,0,'C');
					$pdf->Cell(30,5," ",0,0,'C');		
					$pdf->Cell(10,5," ",0,0,'C');			
					$pdf->Cell(20,5,"CAMBIO $ ".number_format($datos['cambio'],2,'.',','),0,0,'R');
					
					$pdf->Ln();	
				}


$pdf->Ln(3);
//$pdf->MultiCell(70,3,"Comentarios: ".$datos['comentario'],0,'J');

$pdf->Ln(10);

$pdf->SetX(20);
$pdf->Ln();
	
/*//bUSCAMOS EL REGISTRO EN CLIENTE MONEDERO
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