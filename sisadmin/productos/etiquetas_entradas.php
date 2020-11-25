<?php
//require_once ("../clases/fpdf/fpdf.php");
require_once("../clases/class.codebar128.php");
require_once("../clases/conexcion.php");
require_once("../clases/class.Productos.php");
//require_once("../clases/class.Etiquetas.php");
require_once("../clases/class.EntradasySalidas.php");
require_once("../clases/class.Funciones.php");


$producto = new Producto ();
$db = new MySQL ();
$fn = new Funciones ();
//$etiquetas = new Etiquetas ();
//$etiquetas->db = $db ;

$etiquetas = new EntradasySalidas();
$etiquetas->db = $db;

$etiquetas->identrada = $_GET['id']; //recibimos los datos de la entrada....

$result_producto_row = $etiquetas->verEntradasDetalle();
$no_registros = count($result_producto_row);


$pdf = new PDF_Code128();

$limiteCod = 80; //limite de codigos en una hoja del documento pdf
		
		$cordenadaY1=12.7;
		$cordenadaX1=8;
		
		$cordenadaY2=12.7;
		$cordenadaX2=8;
		
		
		
		$altofila = 3.9;
		$anchofila = 40;
		
		$contadortotal= 1;
		$contadorcol=0;
		
	    //$pdf->SetTopMargin(13);
		$pdf->SetLeftMargin(8);
		$pdf->SetAutoPageBreak(true,10);//ES PARA EL SALTO DE PAGINA		
		
		$pdf->AddPage('P','letter');//agregamos una pagina en el pdf
		
		$pdf->SetFont('Arial','',6);
		
		
		
		foreach($result_producto_row as $result_producto_row)
				{

		//$no_paginas = $result_producto_row->total/$limiteCod; //esto lo obtenderemos desde un combo.
		//$inicio = 1;//inicio de las etiquetas a generar
		//$fin = $no_paginas * 80;//fin de las tarjetas
		
		$codpro = $result_producto_row->idproducto; //"#B816"; //$_GET['idproducto']; //codigo del producto
		$descripcion = $result_producto_row->nombre;  //"Pulsera Perla";
		$unidad = $result_producto_row->valor." ".$result_producto_row->unidad;
		$precio = $result_producto_row->pv;   //"$523";
		$cantidad = $result_producto_row->cantidad; //cantidad de producto ingresado.
		//$barra = $pdf->Code128($cordenadaX1,$cordenadaY1,"9899",8,11);
		
		//for($x=1; $x<= $cantidad; $x++);
		$x=1;
	    while($x <= $cantidad)
		 {
			
			$code=$codpro." ";
			
			$pdf->SetXY($cordenadaX2,$cordenadaY2);
			//$pdf->Write(2,$code);
			
			$pdf->Code128($cordenadaX1+5,$cordenadaY1+$altofila,$code,30,$altofila);
			$pdf->Cell($anchofila,$altofila,$code.$descripcion." ".$unidad,0,2,'C');
			$pdf->Cell($anchofila,$altofila,"",0,2,'C');
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell($anchofila,$altofila,"$".$precio,0,2,'C');
			$pdf->SetFont('Arial','',6);
			/*$pdf->MultiCell(44,12.7,
				$pdf->Cell(0,0,"#B816",1,1).
				$pdf->Cell(0,0,"Pulsera Perla",1,1).
				$pdf->Cell(0,0,"$523",1,1)				
				,1);
		*/
			$contadorcol = $contadorcol + 1;
			
			if($contadorcol == 4)
			{
				
				$cordenadaX1=8;
				$cordenadaX2=8;
				$cordenadaY1=$cordenadaY1+12.7;
				$cordenadaY2=$cordenadaY2+12.7;
				
				$contadorcol=0;
			}
			else
			{
				//distancia derecha de rectangulos
				$cordenadaX1=$cordenadaX1+52;
				$cordenadaX2=$cordenadaX2+52;		
			
			}
			
					
			if($contadortotal == $limiteCod)
			{
				
					$pdf->AddPage('P','letter');//agregamos una pagina en el pdf
					$pdf->SetFont('Arial','',6);
				
				
				$cordenadaY1=12.7;
				$cordenadaX1=8;
				
				$cordenadaY2=12.7;
				$cordenadaX2=8;
				
				$contadortotal=1;
				$contadorcol=0;
				
				
			}
			else
			{
				$contadortotal=$contadortotal+1;
			}
		$x++;
		 }//terminamos cantidad de etiquetas por producto.
			
				}//termina foreach
				
				
		//$pdf->Output($codpro."_".$inicio."_".$fin.".pdf","D");//generando  el pdf
		$pdf->Output();//generando  el pdf
	









?>