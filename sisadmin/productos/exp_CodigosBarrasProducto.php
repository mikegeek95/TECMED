<?php
require_once("../clases/class.codebar128.php");
require_once("../clases/class.Funciones.php");
require_once("../clases/class.MovimientoBitacora.php");

try
{

	$fn= new Funciones();
	$mb= new MovimientoBitacora();
	$pdf=new PDF_Code128();//objeto de el pdf
		
	//consulta para sacar los rangos de creacion
	$limiteCod=40; //limite de codigos en una hoja del documento pdf
		

		$no_paginas = 3; //esto lo obtenderemos desde un combo.
		$inicio = 1;//inicio de las etiquetas a generar
		$fin = $no_paginas * 40;//fin de las tarjetas
		$codpro = $_GET['idproducto']; //codigo del producto
		
		
		$cordenadaY1=5;
		$cordenadaX1=5;
		
		$cordenadaY2=27;
		$cordenadaX2=5;
		
		$contadortotal=1;
		$contadorcol=0;
		
		//$pdf->SetMargins(10,10,5);
		
		$pdf->SetTopMargin(10);
		$pdf->SetLeftMargin(10);
		$pdf->SetAutoPageBreak(true,5);		
		
		$pdf->AddPage();//agregamos una pagina en el pdf
		
		$pdf->SetFont('Arial','',10);
		
		
		
		for($i=$inicio;$i<=$fin;$i++)
		{
			$long=strlen($i);
			//aumentarle cerros aun codigo $code=$codpro." ".$fn->aumentarceros($long,8,$i);
			$code=$codpro;
			
			$pdf->Code128($cordenadaX1,$cordenadaY1,$code,48,20); //CONVIERTO A CODIGO DE BARRA Y LO COLOCO EN LAS CORDENAS
			$pdf->SetXY($cordenadaX2,$cordenadaY2);
			$pdf->Write(2,$code);
			
			$contadorcol=$contadorcol+1;
			
			if($contadorcol==4)
			{
				$cordenadaX1=5;
				$cordenadaX2=5;
				$cordenadaY1=$cordenadaY1+27;
				$cordenadaY2=$cordenadaY2+27;
				
				$contadorcol=0;
			}
			else
			{
			
				$cordenadaX1=$cordenadaX1+53;
				$cordenadaX2=$cordenadaX2+53;		
			
			}
					
			if($contadortotal == $limiteCod)
			{
				if($fin>$contadortotal)
				{
					$pdf->AddPage();//agregamos una pagina en el pdf
					$pdf->SetFont('Arial','',10);
				}
				$cordenadaY1=5;
				$cordenadaX1=5;
				
				$cordenadaY2=27;
				$cordenadaX2=5;
				
				$contadortotal=1;
				$contadorcol=0;
				
				
				
			}
			else
			{
				$contadortotal=$contadortotal+1;
			}
			
			
		} //TERMINA FOR DE FOLIOS.
		
		
		$mb->guardarMovimiento(utf8_decode("Código de Barras"),"Productos",utf8_decode("Exportación de códigos de barras para el producto ".$codpro));
			
		//$pdf->Output($codpro."_".$inicio."_".$fin.".pdf","D");//generando  el pdf
		$pdf->Output();//generando  el pdf
	

	
}//TERMINA EL IF DEL CASH
catch(Exception $e)
{
	echo $e;
}
?>