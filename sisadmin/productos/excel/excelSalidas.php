<?php

if (!isset($_SESSION)) 

{

  session_start();

}

//Exportar datos de php a Excel

header("Content-Type: application/vnd.ms-excel");

header("Expires: 0");

header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

header("content-disposition: attachment;filename=ReportesSalida.xls");



require_once("../../clases/conexcion.php");

require_once("../../clases/class.EntradasySalidas.php");
require_once("../../clases/class.Funciones.php");


$db = new MySQL();

$eys = new EntradasySalidas();
$f = new Funciones();


$eys->db = $db;



$eys->idsalidas = $_GET['id'];



$result = $eys->verSalidasDetalle();




	if($_SESSION['se_sas_SO']=="Mac OS"){
	$valid=1;
}
else if($_SESSION['se_sas_SO']=="Windows"){
	$valid=0;
}
else{
	$valid=1;
}
   
                



?>

<HTML LANG="es">

<TITLE>::. Reporte de Salida con el Id =  .::</TITLE>

</head>

<body>





<TABLE width="845" BORDER=1 align="center" CELLPADDING=1 CELLSPACING=1>

<TR style="background-color:#333; color:#FFF; font-size:14px">

<TD width="99">ID PRODUCTO</TD>

<TD width="328">NOMBRE</TD>

<TD width="184">CANTIDAD</TD>

<TD width="211">PRECIO</TD>
	
<!--<TD>PREGUNTA DOS</TD>

<TD>OTROS DOS</TD>

<TD>PREGUNTA TRES</TD>

<TD>OTROS TRES</TD>

<TD>PREGUNTA CUATRO</TD>

<TD>PREGUNTA CINCO</TD>-->





</TR>

<?php





 $contadorP = 0;

 $contadorC = 0;                

foreach($result as $r) 

    {

		$contadorP = $contadorP + $r->pv;

		$contadorC = $contadorC + $r->cantidad;

		

		

		?>

<tr >

    <TD style="mso-number-format:'@';"><?PHP echo  $r->idproducto;?></TD>

    <TD style="mso-number-format:'@';"><?PHP echo $f->imprimir_cadena_utf8_2($r->nombre,$valid);?></TD>

	<TD style="mso-number-format:'0';"><?PHP echo $r->cantidad;?></TD>	
	
    <TD style="mso-number-format:'\#\,\#\#0\.00';">$<?PHP echo $r->pv;?></TD>

    

   

</tr>



<?php

	}

?>



<tr>

<td></td>

<td></td>

<td align="right">CANTIDAD: <?php echo $contadorC;?></td>
	
<td align="right">TOTAL: $<?php echo $contadorP ;?></td>



</tr>



</table>

</body>

</html>