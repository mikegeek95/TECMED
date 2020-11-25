<?php

//require_once ("../clases/fpdf/fpdf.php");

require_once("../clases/class.codebar128.php");

require_once("../clases/conexcion.php");

require_once("../clases/class.Productos.php");

require_once("../clases/class.Etiquetas.php");

require_once("../clases/class.Funciones.php");









$producto = new Producto ();

$db = new MySQL ();

$fn = new Funciones ();

$etiquetas = new Etiquetas ();

$etiquetas->db = $db ;

//$id = $fn->desconver_especial($_GET['id']);



/*$producto->id_producto = "SS7475-8";*/



$etiquetas->idetiquetas = 1;

$result_producto_row = $etiquetas->verEtiqueta();





/*$producto->db = $db;

$producto->id_producto = $id ;

$result_producto_row = $producto->ObtenerDatosProducto();*/



/*echo $sql_etiqueta = "

SELECT

productos.nombre ,

productos.pv ,

etiqueta_detalle.idetiquetas,

etiqueta_detalle.idproducto

FROM

etiqueta_detalle

INNER JOIN productos ON etiqueta_detalle.idproducto = productos.idproducto WHERE idetiquetas = ".$id ;



$result_etiqueta = $db->consulta($sql_etiqueta);

$result_etiqueta_row = $db->fetch_assoc($result_etiqueta);

$result_etiqueta_row_num = $db->num_rows($result_etiqueta);*/



$pdf = new PDF_Code128();



//$pdf = new FPDF ('P','mm');//,array(260,279)













$limiteCod = 80; //limite de codigos en una hoja del documento pdf

		

		foreach($result_producto_row as $result_producto_row)

				{



		$no_paginas = 1; //esto lo obtenderemos desde un combo.

		$inicio = 1;//inicio de las etiquetas a generar

		$fin = $no_paginas * 80;//fin de las tarjetas

		

		$codpro = $result_producto_row->idproducto; //"#B816"; //$_GET['idproducto']; //codigo del producto

		$descripcion = $result_producto_row->nombre;  //"Pulsera Perla";

		$precio = $result_producto_row->pv;   //"$523";

		//$barra = $pdf->Code128($cordenadaX1,$cordenadaY1,"9899",8,11);

		

		$cordenadaY1=11;

		$cordenadaX1=8;

		

		$cordenadaY2=11;

		$cordenadaX2=8;

		

		$contadortotal=1;

		$contadorcol=0;

		

		$altofila = 3.9;

		$anchofila = 44;

		

		

		

		//$pdf->SetTopMargin(13);

		$pdf->SetLeftMargin(8);

		$pdf->SetAutoPageBreak(true,10);//ES PARA EL SALTO DE PAGINA		

		

		$pdf->AddPage('P','letter');//agregamos una pagina en el pdf

		

		$pdf->SetFont('Arial','',7);

		

		

		

		for($i=$inicio;$i<=$fin;$i++)

		{

			

			$code=$codpro;

			

			$pdf->SetXY($cordenadaX2,$cordenadaY2);

			//$pdf->Write(2,$code);

			

			$pdf->Code128($cordenadaX1+5,$cordenadaY1+$altofila,$code,30,$altofila);

			$pdf->Cell($anchofila,$altofila,$code."  ".$descripcion,0,2,'C');

			$pdf->Cell($anchofila,$altofila,"",0,2,'C');

			$pdf->Cell($anchofila,$altofila,$precio,0,2,'C');

			

			/*$pdf->MultiCell(44,12.7,

				$pdf->Cell(0,0,"#B816",1,1).

				$pdf->Cell(0,0,"Pulsera Perla",1,1).

				$pdf->Cell(0,0,"$523",1,1)				

				,1);

		*/

			$contadorcol=$contadorcol+1;

			

			if($contadorcol==4)

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

				if($fin>$contadortotal)

				{

					$pdf->AddPage('P','letter');//agregamos una pagina en el pdf

					$pdf->SetFont('Arial','',7);

				}

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

			

			

		} //TERMINA FOR DE FOLIOS.

		

				}//termina foreach

				

				

		//$pdf->Output($codpro."_".$inicio."_".$fin.".pdf","D");//generando  el pdf

		$pdf->Output();//generando  el pdf

	



















?>