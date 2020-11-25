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

header("content-disposition: attachment;filename=ReportesGuia.xls");



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

$sql2 = $_GET['sql'];

//die($sql2);

$result_guias = $db->consulta($sql2);
$result_guias_row = $db->fetch_assoc($result_guias);
$result_guias_num = $db->num_rows($result_guias);



$paqueteria = array('DHL','UPS','FEDEX','ESTAFETA');
$est_recibido = array ('PENDIENTE','TRANSITO','ADUANA','RECIBIDO');
$est_pago = array ('PENDIENTE PAGO','PAGADO','CANCELADO');

?>

<HTML LANG="es">

<TITLE>::. Reporte de Entrada con el Id =  .::</TITLE>

</head>

<body>



<?php
do
{

	$idguias_pedidos = $result_guias_row['idguias_pedidos'];
	
	$idproveedor = $result_guias_row['idproveedores'];
	
	$result_proveedor = $db->consulta("SELECT * FROM proveedores WHERE idproveedores = '$idproveedor'");
	$result_proveedor_row = $db->fetch_assoc($result_proveedor);
	
	$proveedor = utf8_encode($result_proveedor_row['nombre']);
?>	
<table>
	<tr>
    	<td colspan="11" align="center" bgcolor="#000000" style="color:#fff;">GUIA</td>
    </tr>
	<tr style="text-align:center;">
		<td style="border: solid 1px #000;">NO. PEDIDO</td>
		<td style="border: solid 1px #000;">PROVEEDOR</td>
		<td style="border: solid 1px #000;">NO. GUIA</td>        
		<td style="border: solid 1px #000;">PAQUETERIA</td>
		<td style="border: solid 1px #000;">EST. PAGO</td>
		<td style="border: solid 1px #000;">EST. RECIBO</td>
		<td style="border: solid 1px #000;">F. RECIBIDO</td>
		<td style="border: solid 1px #000;">RECIBIO</td>
		<td style="border: solid 1px #000;">NO. FACTURA</td>
		<td style="border: solid 1px #000;">MONTO</td>
		<td style="border: solid 1px #000;">MONTO LIB.</td>
	</tr>
    
    <tr>
    	<td style="border: solid 1px #000;"><?php echo $result_guias_row['no_pedido']; ?></td>
		<td style="border: solid 1px #000;"><?php echo strtoupper($proveedor); ?></td>
        <td style="border: solid 1px #000;"><?php echo $result_guias_row['no_guia']; ?></td>
		<td style="border: solid 1px #000;"><?php echo strtoupper($paqueteria[$result_guias_row['paqueteria']]) ?></td>
		<td style="border: solid 1px #000;"><?php echo strtoupper($est_pago[$result_guias_row['est_pago']]) ?></td>
		<td style="border: solid 1px #000;"><?php echo strtoupper($est_recibido[$result_guias_row['est_recibido']]) ?></td>
		<td style="border: solid 1px #000;"><?php echo strtoupper($result_guias_row['f_recibido']); ?></td>
		<td style="border: solid 1px #000;"><?php echo strtoupper(utf8_encode($result_guias_row['recibio'])); ?></td>
		<td style="border: solid 1px #000;"><?php echo strtoupper($result_guias_row['no_factura']); ?></td>
		<td style="border: solid 1px #000;"><?php echo "$ ".number_format($result_guias_row['monto'],2,'.',','); ?></td>
		<td style="border: solid 1px #000;"><?php echo strtoupper("$ ".$result_guias_row['monto_liberacion']); ?></td>
    </tr>
</table>	

<table style="margin-left:30px;">
	<tr>
    	<td colspan="6" align="center" bgcolor="#000000" style="color:#fff;">PAGOS</td>
    </tr>
	<tr>
    	<td style="border: solid 1px #000;">LOTE</td>
        <td style="border: solid 1px #000;">FECHA PAGO</td>
        <td style="border: solid 1px #000;">MONTO</td>
        <td style="border: solid 1px #000;">MONEDA</td>
        <td style="border: solid 1px #000;">METODO</td>
        <td style="border: solid 1px #000;">REFERENCIA</td>
    </tr>
    
    <?php
	$guias->idguias_pedidos = $idguias_pedidos;
	$pagos = $guias->listaPagoenGuias();
	$total = 0; 
	
	foreach($pagos as $p )
    {
		$moneda = array('USD','MXN');
		$metodo = array('EFECTIVO','DEPOSITO BANCARIO','MONEY GRAM','WESTER UNION','PAYPAL');
	?>
    <tr>
    	<td style="border: solid 1px #000;"><?php echo $p->idguias_pedidos; ?></td>
        <td style="border: solid 1px #000;"><?php echo $p->fecha_pago;?></td>
        <td style="border: solid 1px #000;"><?php echo $p->monto;?></td>
        <td style="border: solid 1px #000;"><?php echo $moneda[$p->moneda];?></td>
        <td style="border: solid 1px #000;"><?php echo $metodo[$p->metodo];?></td>
        <td style="border: solid 1px #000;"><?php echo $p->referencia;?></td>
    </tr>
    <?php
			$cantidaddeproductos = $cantidaddeproductos + $p->cantidad;
				$total = $total + $p->monto;
				$sumapagos = $sumapagos + $p->monto;
	}
	?>
    
</table>

<br>
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


}while($result_guias_row = $db->fetch_assoc($result_guias));
?>

</body>

</html>