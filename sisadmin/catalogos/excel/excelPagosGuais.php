<?php
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

header("content-disposition: attachment;filename=ReportesPagos.xls");



require_once("../../clases/conexcion.php");
require_once("../../clases/class.Guias.php");
require_once("../../clases/class.EntradasySalidas.php");
require_once("../../clases/class.Funciones.php");
require_once("../../clases/class.Proveedores.php");



$db = new MySQL();

$eys = new EntradasySalidas();

$fu = new Funciones();

$proveedores = new Proveedor();

$guias = new Guias();



$eys->db = $db;

$guias->db = $db;

//$sql = $_GET['id'];

//$sql_desencriptado = $fu->decrypt($sql,'123');

$sql2 = $fu->desconver_especial($_GET['sql']);

//die($sql2);

$result_guias = $db->consulta($sql2);
$result_guias_row = $db->fetch_assoc($result_guias);
$result_guias_num = $db->num_rows($result_guias);



$moneda = array('USD','MXN');
$metodo = array('EFECTIVO','DEPOSITO BANCARIO','MONEY GRAM','WESTER UNION','PAYPAL');
$pagoTarjeta = array('PENDIENTE','PAGADO');

?>

<HTML LANG="es">

<TITLE>::. Reporte de pagos =  .::</TITLE>

</head>

<body>




<table>
	<tr>
    	<td colspan="8" align="center" bgcolor="#000000" style="color:#fff;">PAGOS GUIA</td>
    </tr>
    
	<tr style="text-align:center;">
		<td style="border: solid 1px #000;">LOTE</td>
		<td style="border: solid 1px #000;">FECHA PAGO</td>
		<td style="border: solid 1px #000;">MONTO</td>        
		<td style="border: solid 1px #000;">MXN</td>
		<td style="border: solid 1px #000;">MONEDA</td>
		<td style="border: solid 1px #000;">METODO</td>
		<td style="border: solid 1px #000;">REFERENCIA</td>
		<td style="border: solid 1px #000;">P. TARJETA</td>
	</tr>
    <?php
do
{
?>	
    <tr>
    	<td style="border: solid 1px #000;"><?php echo $result_guias_row['idguias_pedidos']; ?></td>
		<td style="border: solid 1px #000;"><?php echo $result_guias_row['fecha_pago']; ?></td>
        <td style="border: solid 1px #000;"><?php echo "$ ".$result_guias_row['monto']; ?></td>
		<td style="border: solid 1px #000;"><?php echo "$ ".$result_guias_row['monto_mxn']; ?></td>
		<td style="border: solid 1px #000;"><?php echo $moneda[$result_guias_row['moneda']]; ?></td>
		<td style="border: solid 1px #000;"><?php echo $metodo[$result_guias_row['metodo']]; ?></td>
		<td style="border: solid 1px #000;"><?php echo $result_guias_row['referencia']; ?></td>
		<td style="border: solid 1px #000;"><?php echo $pagoTarjeta[$result_guias_row['pagoTarjeta']]; ?></td>
    </tr>
    
    <?php
						$total = $total + $result_guias_row['monto'];

	}while($result_guias_row = $db->fetch_assoc($result_guias));
 
	?>
    <tr>
        <td colspan="6" align="center">&nbsp;</td>
        <td width="90" align="center">TOTAL :</td>
        <td width="60" align="center"><?php echo "$ ".number_format($total,2,'.',''); ?></td>
   </tr>
               
</table>	


<?php 




					
	/*$pdf->SetX(20);				
					$pdf->Cell(35,3,'',0,0,'C');
					$pdf->Cell(70,3," ",0,0,'R');
					$pdf->Cell(12,3," ",0,0,'C');
					$pdf->Cell(30,3," ",0,0,'C');		
					$pdf->Cell(10,3," ",0,0,'C');			
					$pdf->Cell(20,3,"PAGO $ ".number_format($total,2,'.',','),0,0,'R');
					$pdf->Ln(3);
					
	$pdf->SetX(20);	
					
					
					if(($result_guias_row['monto']-$total) > 0){
					$pdf->Cell(35,3,'',0,0,'C');
					$pdf->Cell(70,3," ",0,0,'R');
					$pdf->Cell(12,3," ",0,0,'C');
					$pdf->Cell(30,3," ",0,0,'C');		
					$pdf->Cell(10,3," ",0,0,'C');			
					$pdf->Cell(20,3,"A PAGAR $ ".number_format($result_guias_row['monto'] - $total,2,'.',','),0,0,'R');
					}
					*/


$sumaMonto = $sumaMonto + $result_guias_row['monto_liberacion'];


?>

</body>

</html>