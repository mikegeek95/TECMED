<?php
session_start();
 require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}

//Exportar datos de php a Excel

header("Content-Type: application/vnd.ms-excel");

header("Expires: 0");

header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

header("content-disposition: attachment;filename=ReportesEntrada.xls");



require_once("../../clases/conexcion.php");

require_once("../../clases/class.EntradasySalidas.php");
require_once("../../clases/class.Funciones.php");



$db = new MySQL();

$eys = new EntradasySalidas();

$fu = new Funciones();



$eys->db = $db;


//$sql = $_GET['id'];

//$sql_desencriptado = $fu->decrypt($sql,'123');

$sql2 = $_SESSION['sql_invetario_excel'];

//die($sql2);
//$idproducto = $_GET['id'];

/*$sql = "SELECT 
p.idproducto AS CODIGOPRODUCTO , p.cod_proveedor AS CODIGOPROVEEDOR,p.nombre AS NOMBREPRODUCTO ,p.pv AS COSTOACTUAL , i.existencia AS EXISTENCIA, s.sucursal as SUCURSAL

FROM productos p, inventario i, sucursales s

WHERE
p.idproducto = i.idproducto AND i.idsucursales = s.idsucursales AND i.idproducto = '$idproducto'";*/

$result = $db->consulta($sql2);
$result_row = $db->fetch_assoc($result);


	if($_SESSION['se_sas_SO']=="Mac OS"){
	$valid=1;
}
else if($_SESSION['se_sas_SO']=="Windows"){
	$valid=0;
}
else{
	$valid=0;
}
                



?>

<HTML LANG="es">

<TITLE>::. Reporte de Entrada con el Id =  .::</TITLE>

</head>

<body>





<TABLE width="845" BORDER=1 align="center" CELLPADDING=1 CELLSPACING=1>

<TR style="background-color:#333; color:#FFF; font-size:14px">

<TD width="99">CODIGO</TD>

<TD width="328">COD.PROVEEDOR</TD>

<TD width="211">NOMBRE</TD>

<TD width="184">VALOR/UNIDAD</TD>

<TD width="184">COSTO</TD>

<TD width="184">EXISTENCIA</TD>

<TD width="184">SUCURSAL</TD>

<!--<TD>PREGUNTA DOS</TD>

<TD>OTROS DOS</TD>

<TD>PREGUNTA TRES</TD>

<TD>OTROS TRES</TD>

<TD>PREGUNTA CUATRO</TD>

<TD>PREGUNTA CINCO</TD>-->





</TR>

<?php
	do
	{
?>

<tr>

    <TD style="mso-number-format:'@';"><?PHP echo $result_row['CODIGOPRODUCTO'];?></TD>

    <TD style="mso-number-format:'@';"><?PHP echo $result_row['CODIGOPROVEEDOR'];?></TD>
    
     <TD style="mso-number-format:'@';"><?PHP echo $fu->imprimir_cadena_utf8_2($result_row['NOMBREPRODUCTO'],$valid);?></TD>

     <TD style="mso-number-format:'@';"><?PHP echo $result_row['valor']." ".$result_row['unidad'];?></TD>

    <TD style="mso-number-format:'\#\,\#\#0\.00';"><?PHP echo $result_row['COSTOACTUAL'];?></TD>

    <TD style="mso-number-format:'0';"><?PHP echo $result_row['EXISTENCIA'];?></TD>

	<TD style="mso-number-format:'@';"><?PHP echo $fu->imprimir_cadena_utf8_2($result_row['SUCURSAL'],$valid);?></TD>
   

</tr>



<?php

	}while($result_row = $db->fetch_assoc($result));

?>



<!--<tr>

<td></td>

<td></td>

<td align="right">TOTAL: $<?php echo $contadorP ;?></td>

<td align="right">CANTIDAD: <?php echo $contadorC;?></td>



</tr>-->



</table>

</body>

</html>