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

header("content-disposition: attachment;filename=ReporteVentaCliente.xls");



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

$sql_venta = $fu->desconver_especial($_GET['sql_venta']);
$sql_devo = $fu->desconver_especial($_GET['sql_devo']);


$result_venta = $db->consulta($sql_venta);
$result_venta_row = $db->fetch_assoc($result_venta);

//$result_devo = $db->consulta($sql_devo);
//$result_devo_row = $db->fetch_assoc($result_devo);



if($_SESSION['se_sas_SO']=="Mac OS"){
	$valid=1;
}
else if($_SESSION['se_sas_SO']=="Windows"){
	$valid=0;
}
else{
	$valid=0;
}

$estatus  = array('Pendiente','Pagado','Cancelado','Créditos','Crédito Pagado','Transferencia');
?>

<HTML LANG="es">
	<head>

<TITLE>::. Reporte de Venta por Cliente  .::</TITLE>

	<style type="text/css">
		table thead tr td{
			border: solid 1px #eaeaea;
		}
		
		table tbody tr td{
			border: solid 1px #eaeaea;
		}
    </style>

</head>

<body>
<h2 align="center">VENTAS </h2>
<table  class="display" cellspacing="0" id="d_modulos"> 
			<thead> 
				<tr style="background-color: #eaeaea"> 
   					<th style="border-right: 1px solid #eaeaea;">ORD. COMP.</th> 
    				<th style="border-right: 1px solid #eaeaea;">FECHA</th>
    				<th style="border-right: 1px solid #eaeaea;">NOMBRE</th>
                    <th style="border-right: 1px solid #eaeaea;">ESTATUS</th>
                    <th style="border-right: 1px solid #eaeaea;">TOTAL</th>
				</tr> 
			</thead> 
			<tbody> 
             <?php 
			//Validamos que existan registros en la consulta
	     		do
				{
					
				?>
 
				<tr style=" color:#000;"> 
   				  <td style="text-align:center"><?php echo $result_venta_row['idnota_remision']; ?></td> 
   				  <td><?php echo $result_venta_row['fechapedido']; ?></td>
   				  <td align="left"><?php echo ($fu->imprimir_cadena_utf8_2($result_venta_row['nombre']." ".$result_venta_row['paterno']." ".$result_venta_row['materno'],$valid)); ?></td>
                  <td align="center"><?PHP echo $estatus[$result_venta_row['estatus']]; ?></td>
                  <td align="center">$ <?php echo number_format($result_venta_row['total'],2,'.',','); ?></td>
				</tr>
                
                <?php
					$total = $total + $result_venta_row['total'];
				}while($result_venta_row = $db->fetch_assoc($result_venta));
			
				?>
                
                <tr style="color:#FFF; background:white;">
                	<td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td align="right">TOTAL: </td>
                    <td align="center">$ <?php echo number_format($total,2,'.',','); ?> </td>
                </tr>
 
            	
			</tbody> 
			</table>
            
            
            
            
            <br><br><br>
            
    <!--                    <h2 align="center">DEVOLUCIONES </h2>

            <table  class="display" cellspacing="0" id="d_modulos2"> 
			<thead> 
				<tr>
                	<th>NO DEV.</th> 
   					<th>ORD. COMP.</th> 
    				<th>FECHA</th>
    				<th>NOMBRE</th>
                    <th>TOTAL</th>
				</tr> 
			</thead> 
			<tbody> 
             <?php 
			//Validamos que existan registros en la consulta
	     		do
				{
					?>
            
          
            
				<tr style="color:#000;"> 
                	<td style="text-align:center"><?php echo $result_devo_row['idcliente_devolucion']; ?></td> 
   				  <td style="text-align:center"><?php echo $result_devo_row['idnota_remision']; ?></td> 
   				  <td><?php echo $result_devo_row['fecha']; ?></td>
   				  <td align="left"><?php echo ($result_devo_row['nombre']." ".$result_devo_row['paterno']." ".$result_devo_row['materno']); ?></td>
                  <td align="center">$ <?php echo number_format($result_devo_row['total'],2,'.',','); ?></td>
				</tr>
                
                <?php
					$total2 = $total2 + $result_devo_row['total'];
				}while($result_devo_row = $db->fetch_assoc($result_devo));
				?>
                
                <tr style="color:#FFF; background:#000;">
                	<td>&nbsp;</td>
                	<td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td align="right">TOTAL: </td>
                    <td align="center">$ <?php echo number_format($total2,2,'.',','); ?> </td>
                </tr>
 
            	
			</tbody> 
			</table>
   -->         
   <!--         <br><br><br>
            
            <h2 align="center">DESGLOSE DE TOTALES </h2>
            <table  class="display" cellspacing="0" id="d_modulos3" style=" width:100%;"> 
			<thead> 
				<tr>
                	<th colspan="2">VENTAS</th> 
   					<th colspan="2">DEVOLUCION</th> 
    				<th>TOTAL</th>
				</tr> 
			</thead> 
			<tbody style="color:#FFF; background:#000;">
            	<tr style="color:#FFF; background:#000;"> 
				<td colspan="2" align="center"><?php echo "$ ".number_format($total,2,'.',','); ?></td>
                <td colspan="2" align="center"><?php echo "$ ".number_format($total2,2,'.',','); ?></td>
                <td align="center"><?php echo "$ ".number_format(($total - $total2),2,'.',',');?></td>
                <tr>
			</tbody> 
			</table>

-->


</body>

</html>