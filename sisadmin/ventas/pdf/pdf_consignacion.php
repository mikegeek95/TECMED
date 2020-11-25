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
	

	
	
	class PDF extends FPDF
		{
		
		public $idcliente;	
		public $nombre;
		public $idconsignacion;
			
		// Cabecera de página
		function Header()
		{
			
			// Logo
			
			// Arial bold 15
			$this->SetX(80);
		   
			// Salto de línea
			$this->Ln(5);
			
			$this->SetFont('Arial','B',11);
			
			$this->Cell(100,5,"CONSIGNACION DE PRODUCTO, JOYERIA KL",0,1);
			
			$this->SetFont('Arial','',11);
			
			$this->Image('logo.png',150,18,33);
			
			$this->Cell(100,7,'ID SOCIO: '.$this->idcliente,1,2);
			$this->Cell(100,7,$this->nombre,1,2);
		    $this->MultiCell(100,5,utf8_decode('7 Ote. entre 1 y 2 Sur 251 Tuxtla Gutiérrez, Chiapas, C.P 29000, Teléfono: 96116545418, Email: info@joyeriakl.com'),1,1);
	
		 
			$this->Ln(10);
		}
		
		// Pie de página
		function Footer()
		{
			// Posición: a 1,5 cm del final
			$this->SetY(-15);
			// Arial italic 8
			$this->SetFont('Arial','I',8);
			// Número de página
			$this->Cell(0,10,utf8_decode('Página').$this->PageNo()." / Consignación: ".$idconsignacion ,0,0,'C');
		}

//termina pie de página
}//TERMINA EXPENDEN DE PDF
	
	
  
   $pdf = new PDF( 'P','mm','Letter');
   $pdf->idcliente = $idcliente;
   $pdf->nombre = $nombre;
   $pdf->idconsignacion = $id;
   $pdf->AddPage();


    $pdf->Ln(2);
	
	$pdf->SetFont('Arial','B',14);
	
  
	$pdf->x = 160;
	
	$pdf->SetFont('Arial','B',8);
	$pdf->SetTextColor(0,0,0);
	//$pdf->Cell(w,h,t,b,ln,al,fill,link)
	$pdf->SetFillColor(240,239,239);
	$pdf->Cell(15,7,'ID #',1,0,'',true);
	
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(30,7,$id,1,1,'',false);
	$pdf->x = 160;
	$pdf->Cell(15,7,'Fecha ',1,0,'',true);
	$pdf->SetTextColor(0,0,0);
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