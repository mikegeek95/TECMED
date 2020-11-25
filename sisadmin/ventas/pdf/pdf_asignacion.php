<?php
if (!isset($_SESSION)) 
{
  session_start();
}
if(!isset($_SESSION['se_SAS']))
{
	header("Location: login.php");
	exit;
}
   require_once("../../clases/conexcion.php");
   require_once("../../clases/fpdf/fpdf.php"); 
   require_once("../../clases/class.Consignacion.php");
   require_once("../../clases/class.Fechas.php");	
   
	$db = new MySQL();
	
	$con = new Consignacion();
	$con->db = $db;
	
	$f = new Fechas();
	
   
   $id = $_GET['id'];
   
   
   	$row_consignacion = $con->ObtenerDatosdeConsignacionID($id);
	
	$row_consignacion_detalle = $con->ObtenerDetallesdeConsignacionID($id);
	
	
	//sacamos los valores del array
	
	foreach($row_consignacion as $row)
	  {
		  $nombre = $row->nombre;
		  $idcliente = $row->idcliente;
		  $fecha = $row->fecha;
		  $estatus = $row->estatus;
	  }
   
  
	$num = count($row_consignacion);
   
   
   $db = new MySQL();
   $pdf = new FPDF( 'P','mm','Letter');
   $pdf->AddPage();
   
   $pdf->y = 8;
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(80,5,'ID SOCIO: '.$id,1,2);
   $pdf->MultiCell(80,5,utf8_decode('7 Ote. entre 1 y 2 Sur 251 Tuxtla Gutiérrez, Chiapas, C.P 29000 '),1,2);
   $pdf->Cell(80,5,utf8_decode('Teléfono: (961) 61-37757'),1,1);

  
  
  // Logo
    $pdf->Image('../../images/logo1.png',175,8,33);



    $pdf->Ln(4);
	
	$pdf->SetFont('Arial','B',14);
	
    $pdf->cell(120,15,'Socio: '.$nombre,0,0,'C',false);
	$pdf->x = 160;
	
	$pdf->SetFont('Arial','B',8);
	$pdf->SetTextColor(149,147,147);
	//$pdf->Cell(w,h,t,b,ln,al,fill,link)
	$pdf->SetFillColor(240,239,239);
	$pdf->Cell(15,7,'ID #',1,0,'',true);
	
	$pdf->SetTextColor(149,147,147);
	$pdf->Cell(30,7,$id,1,1,'',false);
	$pdf->x = 160;
	$pdf->Cell(15,7,'Fecha ',1,0,'',true);
	$pdf->SetTextColor(149,147,147);
	$pdf->Cell(30,7,$f->fecha_esp($fecha),1,1,'',false);
	
	 $pdf->Ln(10);
	
	
	//titulo de la grafica
	
	$pdf->SetFillColor(240,239,239);
	
	$pdf->Cell(37,7,utf8_decode('Código'),1,0,'C',true);
	$pdf->Cell(78,7,utf8_decode('Descripción'),1,0,'C',true);
	$pdf->Cell(30,7,utf8_decode('Costo'),1,0,'C',true);
	$pdf->Cell(27,7,utf8_decode('Cantidad'),1,0,'C',true);
	$pdf->Cell(27,7,utf8_decode('Precio'),1,1,'C',true);
	
	
	      $montoapagar = 0;
		  $cantidadprodu = 0;
		  
		  foreach($row_consignacion_detalle as $detalle)
		  {
			  
			  $idproducto = $detalle->idproducto;
			  $nombre_producto = $detalle->nombre;
			  $descripcion_producto = $detalle->descripcion;
			  $pv = $detalle->pv;
			  $cantidad = $detalle->cantidad;
			  
			  $precio = $pv * $cantidad;
			  
			  $montoapagar = $montoapagar + $precio;
			  
			  $cantidadprodu = $cantidadprodu + $cantidad;
		  
		      $pdf->SetDrawColor(0, 0, 0);
			  
			  $x = $pdf->GetX();
			  $y = $pdf->GetY();
			  $y2 = $y+7;
			  
			  
			  $pdf->Line( $x,$y,$x,$y2);
		  
		        $pdf->Cell(37,7,utf8_decode($idproducto),0,0,'C',false);
				$pdf->Cell(78,7,$nombre_producto,0,0,'C',false);
				$pdf->Cell(30,7,'$ '. number_format(utf8_decode($pv),2,'.',','),0,0,'C',false);
				$pdf->Cell(27,7,utf8_decode($cantidad),0,0,'C',false);
				$pdf->Cell(27,7,'$ '. number_format(utf8_decode($precio),2,'.',','),0,0,'C',false);
		  
		      $x = $pdf->GetX();
			  $y = $pdf->GetY();
			  $y2 = $y+7;
			  
			   $pdf->Line($x,$y,$x,$y2);
			   
			   $pdf->Ln();
		  
		  }
		  	  
          //terminamos 
		  
		  //obtendremos el iva y el subtotal
		  $x = $pdf->GetX();
		  $y = $pdf->GetY();
		  
		  
		  $pdf->Line($x,$y,209,$y2);
		  $pdf->Ln(5);
		  
		  
		  $iva = $montoapagar-($montoapagar / 1.16);
		  $subtotal = $montoapagar-$iva;
	
	
	            $pdf->Cell(37,7,'',0,0,'C',false);
				$pdf->Cell(78,7,'',0,0,'C',false);
				$pdf->Cell(30,7,'CANTIDAD PRODUCTO',0,0,'C',false);
				$pdf->Cell(27,7,$cantidadprodu,0,0,'C',false);
				$pdf->Cell(27,7,' ',0,0,'C',false);
				$pdf->Ln();
				
	            $pdf->Cell(37,7,'',0,0,'C',false);
				$pdf->Cell(78,7,'',0,0,'C',false);
				$pdf->Cell(30,7,'',0,0,'C',false);
				$pdf->Cell(27,7,'SUBTOTAL:',0,0,'C',false);
				$pdf->Cell(27,7,'$ '.number_format($subtotal,2,'.',','),0,0,'C',false);
				
				$pdf->Ln();
				
				$pdf->Cell(37,7,'',0,0,'C',false);
				$pdf->Cell(78,7,'',0,0,'C',false);
				$pdf->Cell(30,7,'',0,0,'C',false);
				$pdf->Cell(27,7,'IVA',0,0,'C',false);
				$pdf->Cell(27,7,'$ '.number_format($iva,2,'.',','),0,0,'C',false);
				
				$pdf->Ln();
				
				$pdf->Cell(37,7,'',0,0,'C',false);
				$pdf->Cell(78,7,'',0,0,'C',false);
				$pdf->Cell(30,7,'',0,0,'C',false);
				$pdf->Cell(27,7,'TOTAL',0,0,'C',false);
				$pdf->Cell(27,7,'$ '.number_format($montoapagar,2,'.',','),0,0,'C',false);
				
	
	
 
    $pdf->Output();
   
   
   

   


?>