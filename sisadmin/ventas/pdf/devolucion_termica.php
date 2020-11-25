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
    $this->MultiCell(190,5,utf8_decode("- Le invitamos a revisar su mercancia antes de salir de la tienda."),0,'J');
	$this->MultiCell(190,5,utf8_decode("- Para poder realizar la devolución de producto es necesario presentar este comprobante de pago."),0,'J');
	$this->MultiCell(190,5,utf8_decode("- Las piezas deberán de venir en su empaque original."),0,'J');
    $this->Cell(0,10,utf8_decode('Página').$this->PageNo().'',0,0,'C');*/

}



//termina pie de página

}//TERMINA EXPENDEN DE PDF


$iddevolucion = $_GET['id'];
$devolucion->iddevolucion = $iddevolucion;

$empresa = $conf->ObtenerInformacionConfiguracion();


$result_devolucion = $devolucion->BuscarDevolucionDescripcion();
$row_devolucion = $db->fetch_assoc($result_devolucion);
$row_num_devolucion = $db->num_rows($result_devolucion);

$cantidaddeproductos = 0;
if($row_num_devolucion!=0)
{
	do
	{
		$cantidaddeproductos = $cantidaddeproductos + $row_devolucion['cantidad'];
	}while($row_devolucion = $db->fetch_assoc($result_devolucion));
}


// Creación del objeto de la clase heredada
$height = 244;
$height_productos = 11 * $cantidaddeproductos;

$height = $height + $height_productos;

//height 245

$pdf =& new PDF ('P', 'mm', array(72,$height));
//$pdf =& new FPDF('P', 'mm', array(58, 500)); 


//parsear la informacion de la empresa.

//datos de la empresa




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

$sql = "SELECT c.nombre, c.paterno, c.materno, c.idcliente, c.saldo_monedero, c.idniveles FROM nota_remision nr, clientes c WHERE nr.idnota_remision = '$idnota_remision' AND nr.idcliente = c.idcliente";
$result_sql = $db->consulta($sql);
$result_sql_row = $db->fetch_assoc($result_sql);
$result_sql_num = $db->num_rows($result_sql);
$clientes = $result_sql_row['nombre']." ".$result_sql_row['paterno']." ".$result_sql_row['materno'];
$idniveles = $result_sql_row['idniveles'];


$pdf->cliente = $clientes;

 
 $saldo_monedero = $result_sql_row['saldo_monedero'];



$pdf->AddPage();
$pdf->SetMargins(2,1,0);

$pdf->SetFontSize(6);

$pdf->SetX(2);
$pdf->Cell(40,3,utf8_decode("DEVOLUCIÓN"));
$pdf->Ln();
$pdf->Cell(40,3,utf8_decode("COMPROBANTE DE PAGO (SIN EFECTOS FISCALES)"));
$pdf->Ln();
$pdf->Cell(40,3,utf8_decode("FECHA: ").$row_devolucion_cabeza['fecha']);
$pdf->Ln();
$pdf->Cell(40,3,utf8_decode("NO. DEVOLUCION : ").$iddevolucion);
$pdf->Ln();
//$pdf->Cell(40,3,utf8_decode("NO. VENTA : ").$idnota_remision);
//$pdf->Ln();
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


$pdf->SetX(0);
$pdf->Ln();
	//$pdf->SetX(1);
	
	//PRIMER RENGLON
	$pdf->SetX(4);
	$pdf->SetFontSize(6);$pdf->Cell(7,5,"NOTA",0,0,'C');
	$pdf->Cell(14,5,"COD",0,0,'C');
	$pdf->Cell(20,5,"NOM",0,0,'C');
	
	$pdf->Ln();

	//SEGUNDO RENGLON
	$pdf->SetX(4);
	$pdf->Cell(7,5,"#",0,0,'C');
	$pdf->Cell(15,5,"CP",0,0,'C');
	$pdf->Cell(10,5,"PV",0,0,'C');
	$pdf->Cell(10,5,"% DESC",0,0,'C');
	$pdf->Cell(10,5,"DESC",0,0,'C');
	//$pdf->Cell(15,5,$row_devolucion['porc_desc'],0,0,'C');
	//$pdf->Cell(18,5,$row_devolucion['total_descuento'],0,0,'C');
	$pdf->Cell(10,5,"TOTAL",0,0,'R');
	/*$pdf->Cell(9,5,"#",0,0,'C');
	$pdf->Cell(14,5,"COD",0,0,'C');
	$pdf->Cell(8,5,"CP",0,0,'C');
	$pdf->Cell(12,5,"NOM",0,0,'C');
	$pdf->Cell(12,5,"PV",0,0,'C');
	$pdf->Cell(12,5,"TOTAL",0,0,'C');*/
	//$pdf->Cell(18,5,"DESC",0,0,'C');
	//$pdf->Cell(20,5,"TOTAL",0,0,'C');
	/*$pdf->Cell(25,5,"CLAVE",1,0,'C');
	$pdf->Cell(20,5,"CAT",1,0,'C');
	$pdf->Cell(55,5,"PRODUCTO",1,0,'C');
	$pdf->Cell(12,5,"CANT.",1,0,'C');
	$pdf->Cell(27,5,"PRECIO",1,0,'C');
	$pdf->Cell(15,5,"% DESC",1,0,'C');
	$pdf->Cell(18,5,"DESC",1,0,'C');
	$pdf->Cell(20,5,"TOTAL",1,0,'C');*/
$pdf->Ln();

	$pdf->SetX(1);
	$pdf->Cell(70,3,"==================================================",0,0,'C');
	$pdf->Ln();

$result_devolucion = $devolucion->BuscarDevolucionDescripcion();
$row_devolucion = $db->fetch_assoc($result_devolucion);
$row_num_devolucion = $db->num_rows($result_devolucion);

$cantidaddeproductos = 0;
if($row_num_devolucion!=0)
{
	$count = 0;
	do
	{
				$idproducto = $row_devolucion['idproducto'];
				$sql2 = "SELECT cp.nombre as cat, cp.idcategoria_precio as id FROM productos p, categoria_precio cp WHERE p.idproducto = '$idproducto' AND p.idcategoria_precio = cp.idcategoria_precio";
					$result_cat = $db->consulta($sql2);
					$result_cat_row = $db->fetch_assoc($result_cat);
					
					$cat = $result_cat_row['cat'];
					$idcategoria_precio = $result_cat_row['id'];
					
		
		$sql_tallas = "SELECT * FROM tallas WHERE idtallas = '".$row_devolucion['idtallas']."'";
		$result_tallas = $db->consulta($sql_tallas);
		$result_tallas_row = $db->fetch_assoc($result_tallas);
		
					//$ab = array('','EL','MA','LG','BO','CR','RO');
					//$cate = array('','E. LIBRE','MARCA','LOGUEADO','BOLSAS','CAJ. REG.','RODIO');
					
	            	$pdf->SetX(3);
					$pdf->SetFontSize(6);
					
					if($count != 0){
						$pdf->Cell(63,1,"____________________________________________________",0,0,'C');
						$pdf->Ln(3);
					}
					
					
					$pdf->Cell(7,5,$row_devolucion['idnota_remision'],0,0,'C');
					$pdf->Cell(14,5,$row_devolucion['idproducto'],0,0,'C');
					$pdf->Cell(20,5," ",0,0,'C');
					

					$pdf->Ln();
					
					$pdf->SetFontSize(6);
					$pdf->Cell(7,5," ",0,0,'C');
					$pdf->Cell(7,5," ",0,0,'C');
					$pdf->Cell(36,5," ".strtoupper(/*substr(*/$row_devolucion['nombre']." #".$result_tallas_row['talla']/*,0,5)*/),0,0,'C');
					
					$pdf->Ln();
					
					$pdf->SetX(4);				
					$pdf->Cell(7,5,$row_devolucion['cantidad'],0,0,'C');
					$pdf->Cell(15,5," ".$cat,0,0,'C');
					$pdf->Cell(10,5,"$".number_format($row_devolucion['pv'],2,'.',','),0,0,'C');
					$tota_cantidad = $row_devolucion['cantidad'] * $row_devolucion['pv'];
					//$pdf->Cell(15,5,$row_devolucion['porc_desc'],0,0,'C');
					//$pdf->Cell(18,5,$row_devolucion['total_descuento'],0,0,'C');
					$pdf->Cell(10,5,$row_devolucion['porc_desc']."%",0,0,'C');
					$pdf->Cell(10,5,"$".$row_devolucion['total_descuento'],0,0,'C');
					$pdf->Cell(10,5,"$".number_format($row_devolucion['total'],2,'.',','),0,0,'R');
					
					/*$pdf->Cell(25,5,$row_devolucion['idproducto'],1,0,'C');
					$pdf->Cell(20,5," ".strtoupper($cat),1,0,'L');
					$pdf->Cell(55,5," ".strtoupper($row_devolucion['nombre']),1,0,'L');
					$pdf->Cell(12,5,$row_devolucion['cantidad'],1,0,'C');
					$pdf->Cell(27,5,"$ ".number_format($row_devolucion['pv'],2,'.',','),1,0,'C');
					$tota_cantidad = $row_devolucion['cantidad'] * $row_devolucion['pv'];
					$pdf->Cell(15,5,$row_devolucion['porc_desc'],1,0,'C');
					$pdf->Cell(18,5,$row_devolucion['total_descuento'],1,0,'C');
					$pdf->Cell(20,5,"$ ".number_format($row_devolucion['total'],2,'.',','),1,0,'R');*/
				$pdf->Ln();
				$cantidaddeproductos = $cantidaddeproductos + $row_devolucion['cantidad'];
			$count++;
	}while($row_devolucion = $db->fetch_assoc($result_devolucion));
}

$pdf->SetFontSize(6);
$pdf->SetX(1);
	$pdf->Cell(70,3,"==================================================",0,0,'C');

$pdf->Ln();
$pdf->SetX(0);
					$pdf->SetFontSize(6);
					$pdf->Cell(9,3,'',0,0,'C');
					$pdf->Cell(14,3," Cantidad: ",0,0,'R');
					$pdf->Cell(8,3,$cantidaddeproductos,0,0,'C');
					$pdf->Cell(12,3," ",0,0,'C');
					$pdf->Cell(12,3," ",0,0,'C');
					$pdf->Cell(12,3,"SUBTOTAL $ ".number_format($subtotal,2,'.',','),0,0,'R');
					$pdf->Ln();
$pdf->SetX(0);					
					$pdf->Cell(9,3,'',0,0,'C');
					$pdf->Cell(14,3," ",0,0,'R');
					$pdf->Cell(8,3," ",0,0,'C');
					$pdf->Cell(12,3," ",0,0,'C');	
					$pdf->Cell(12,3," ",0,0,'C');				
					$pdf->Cell(12,3,"DESCUENTO $ ".number_format($descuento,2,'.',','),0,0,'R');
					$pdf->Ln();
$pdf->SetX(0);					
					$pdf->Cell(9,3,'',0,0,'C');
					$pdf->Cell(14,3," ",0,0,'R');
					$pdf->Cell(8,3," ",0,0,'C');
					$pdf->Cell(12,3," ",0,0,'C');	
					$pdf->Cell(12,3," ",0,0,'C');				
					$pdf->Cell(12,3,"TOTAL $ ".number_format($total,2,'.',','),0,0,'R');					
/**/
$pdf->Ln(8);

$pdf->SetX(0);
if($result_sql_num != 0){
	$pdf->Ln();

	//bUSCAMOS EL REGISTRO EN CLIENTE MONEDERO
		$sql_monedero = "SELECT * FROM cliente_monedero WHERE idcliente_devolucion = '$iddevolucion'";
		$result_monedero = $db->consulta($sql_monedero);
		$result_monedero_row = $db->fetch_assoc($result_monedero);
		$result_monedero_num = $db->num_rows($result_monedero);

		$pdf->SetFontSize(6);
		//$pdf->SetX(10);
		$pdf->Cell(40,3,utf8_decode("MONEDERO ELETRÓNICO"));
		$pdf->Ln();
		$pdf->Cell(40,3,utf8_decode("SALDO ANTERIOR: ").($result_monedero_row['saldo_ant']));
		$pdf->Ln();
		$pdf->Cell(40,3,utf8_decode("SALDO ACTUAL: ").$result_monedero_row['saldo_act']);
		$pdf->Ln(7);

	$pdf->SetX(0);
}

$pdf->Ln(10);


$pdf->Line($pdf->GetX(),$pdf->GetY(),70,$pdf->GetY());
$pdf->MultiCell(70,5,strtoupper($clientes),0,'C');


$pdf->Ln(15);
	

$pdf->Line($pdf->GetX(),$pdf->GetY(),70,$pdf->GetY());
$pdf->MultiCell(70,5,strtoupper($nombre),0,'C');

	
$pdf->Ln(15);

// Número de página
$pdf->SetX(0);

/*$pdf->MultiCell(69,3,utf8_decode("- Le invitamos a revisar su mercancia antes de salir de la tienda."),0,'C');
$pdf->SetX(0);

$pdf->MultiCell(69,3,utf8_decode("- Para poder realizar la devolución de producto es necesario presentar este comprobante de pago."),0,'C');
$pdf->SetX(0);
$pdf->MultiCell(69,3,utf8_decode("- Las piezas deberán de venir en su empaque original."),0,'C');

$pdf->Ln(5);

$pdf->SetX(0);
$pdf->MultiCell(69,3,utf8_decode("- No se recibirá producto dañado."),0,'J');*/
if($result_sql_num != 0){
	$sql_nivel = "SELECT * FROM categoria_precios_niveles WHERE idniveles = $idniveles";
	$result_nivel = $db->consulta($sql_nivel);
	$result_nivel_row = $db->fetch_assoc($result_nivel);


	$cadena = '';
	$count = 0;
	do{
		if($cadena == ''){
			$cadena = $ab[$result_nivel_row['idcategoria_precio']]." - ".$cate[$result_nivel_row['idcategoria_precio']]." ".$result_nivel_row['descuento']."%";
		}else{
			$cadena = $cadena."     ".$ab[$result_nivel_row['idcategoria_precio']]." - ".$cate[$result_nivel_row['idcategoria_precio']]." ".$result_nivel_row['descuento']."%";

			if($count == 1){
				$cadena = $cadena."\n";
			}

			if($count == 3){
				$cadena = $cadena."\n";
			}
		}

		$count = $count + 1;	
	}while($result_nivel_row = $db->fetch_assoc($result_nivel));
}
/*$pdf->Ln(5);
$pdf->SetX(0);
$pdf->MultiCell(70,3,"COD - CODIGO DE PRODUCTO  CP - CATEGORIA PRODUCTO  NOM - NOMBRE  PV - PRECIO VENTA",0,'C');
$pdf->Ln(3);
$pdf->MultiCell(70,3,$cadena,0,'C');<br>*/


$pdf->Output();

?>