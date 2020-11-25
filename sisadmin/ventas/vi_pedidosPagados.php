<?php
require_once("../clases/class.Sesion.php");
$se = new Sesion();

if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}


require_once("../clases/conexcion.php");
require_once("../clases/class.Clientes.php");
require_once("../clases/class.Configuracion.php");

$db = new  MySQL();
$cl = new Clientes();
$conf = new Configuracion();

$cl->db = $db;

$conf->db = $db;


$tipo = $_SESSION['se_sas_Tipo'];


$tipopago = array('Efectivo','TC','TD','Cheque','Depósito','Transferencia');
$estatus  = array('Pendiente','Pagado','Cancela','Créditos');

$fecha = ($_POST['inicio'] != '' ) ? explode("-",$_POST['inicio']) : '';
	$fecha_fin =($_POST['f_fin'] != '' ) ? explode("-",$_POST['f_fin']) : '';

$sql_pedidos = "SELECT n.idnota_remision , n.fechapedido , n.idcliente , n.total , n.tipo_pago ,n.estatus, n.idsucursales FROM nota_remision n WHERE n.estatus = 1";

$sql_pedidos.= ($fecha && $fecha_fin)   ? " AND n.fechapedido BETWEEN '$fecha[0]-$fecha[1]-$fecha[2]'
                                                        AND '$fecha_fin[0]-$fecha_fin[1]-$fecha_fin[2]' " : "";
														

//Validamos que sea superUsuario
if($tipo == 0){
	//die("superusuario TODAS");
}else{
	$idsucursales = $_SESSION['se_sas_Sucursal'];
	$sql_pedidos.= " AND n.idsucursales = '$idsucursales'";	
}


$sql_pedidos.= " ORDER BY
	n.idnota_remision DESC";
//echo $sql_pedidos ;

//die($sql_pedidos);

$result_pedidos = $db->consulta($sql_pedidos);
$result_pedidos_row = $db->fetch_assoc($result_pedidos);



if(isset($_GET['ac']))
{
	if($_GET['ac']==1)
	{
		$msj='<div id="mens" class="alert_success">'.$_GET['msj'].'</div>';
	}
	else
	{
		$msj='<div id="mens" class="alert_error">Error. Intentar mas Tarde '.$_GET['msj'].'</div>';
	}
	
	echo '<script type="text/javascript">OcultarDiv(\'mens\')</script>';
	
	echo $msj;
}



//Consultamos configuracion para impresion
//$result_conf = $conf->ObtenerInformacionConfiguracion();
//$impresion = $result_conf['notas_print'];

//Consultamos configuracion de impresion por sucursal
$suc = $_SESSION['se_sas_Sucursal'];
$sql_imp = "SELECT * FROM sucursales WHERE idsucursales = '$suc'";
$result_imp = $db->consulta($sql_imp);
$result_imp_row = $db->fetch_assoc($result_imp);
$impresion = $result_imp_row['notas_print'];

?>


<article class="module width_full">
		<header>
			<h3 class="tabs_involved">PEDIDOS PAGOS PAGADOS</h3>
            <ul class="tabs">
                <li><a href="#" onClick="aparecermodulos('ventas/fa_ventas.php','main');">Agregar Pedido</a></li>
			</ul>
            
             
		</header>
		
		  <div id="li_pedidos" class="tab_container">

<!--INCERTAMOS SKINK PARA EL MANEJO DE LAS TABLAS--> 

        <style type="text/css" title="currentStyle">
			@import "js/grid/css/demo_page.css";
			@import "js/grid/css/demo_table.css";
		</style>
		<!--<script type="text/javascript" language="javascript" src="js/grid/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="js/grid/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="js/grid/js/FixedColumns.js"></script>
		<script type="text/javascript" language="javascript" src="js/grid/js/FixedColumns.min.js"></script>-->
        
         
        <!-- jQuery -->
            <script type="text/javascript" charset="utf8" src="js/media/js/jquery.js"></script> 
        <!-- DataTables -->
            <script type="text/javascript" charset="utf8" src="js/media/js/jquery.dataTables.js"></script>
    
    <!--TERMINAMOS SKIN DE EL MANEJO DE LAS TABLAS--> 


		<script type="text/javascript" charset="utf-8">
		
			$(document).ready(function() {
				
				var oTable = $('#d_modulos').dataTable( {	
				       "ordering": false,
					   "lengthChange": true,
					   "oLanguage": {
									"sLengthMenu": "Mostrar _MENU_ Registros por p&aacute;gina",
									"sZeroRecords": "Lo sentimos - Ningun registro encontrado",
									"sInfo": "Mostrar _START_ a _END_ de _TOTAL_ Registros",
									"sInfoEmpty": "desde 0 a 0 de 0 records",
									"sInfoFiltered": "(filtered desde _MAX_ total Registros)",
									"sSearch": "Buscar",
									"oPaginate": {
												 "sFirst":    "Inicio",
												 "sPrevious": "Anterior",
												 "sNext":     "Siguiente",
												 "sLast":     "&Uacute;ltimo"
												 }
                                    },
			           "sPaginationType": "full_numbers",
					   "sScrollX": "100%",
		               "sScrollXInner": "100%",
		               "bScrollCollapse": true,
					} );
				} );
				
				</script>
       
			<table  class="tablesorter" cellspacing="0" id="d_modulos"> 
			<thead> 
				<tr> 
   					<th>NO. PED.</th> 
    				<th>FECHA</th>
    				<th>NOMBRE</th>
                    <th>TOTAL</th>
                    <th>TiPO PAGO</th>
                    <th>ESTATUS</th>
                    <th>SUCURSALES</th>
                    <th>ACCI&Oacute;N</th>
				</tr> 
			</thead> 
			<tbody> 
             <?php 
	 
	     
	 
	     do
				{
					
					
					
					
					if($result_pedidos_row['idcliente'] != 0)
					{
						$result_pedidos_row['idcliente'];
						$cl->idCliente = $result_pedidos_row['idcliente'];								
						$result_cliente = $cl->ObtenerInformacionCliente();					
						$cliente = $result_cliente['nombre'].' '.$result_cliente['paterno'] .' '.$result_cliente['materno'];
				    }else
					{
			           $cliente = "VENTANILLA";			
						}
					
					
					?>
            
          
            
				<tr> 
   				  <td style="text-align:center"><?php echo $result_pedidos_row['idnota_remision']; ?></td> 
   				  <td><?php echo $result_pedidos_row['fechapedido']; ?></td>
   				  <td align="center"><?php echo utf8_encode($cliente); ?></td>
                  <td align="center">$ <?php echo number_format($result_pedidos_row['total'],2,'.',','); ?></td>
                  <td align="center"><?PHP echo $tipopago[$result_pedidos_row['tipo_pago']]; ?></td>
                  <td align="center"><?PHP echo $estatus[$result_pedidos_row['estatus']]; ?></td>
                  <?php
				  $idsucursal = $result_pedidos_row['idsucursales'];
				  $sql_sucursal = "SELECT * FROM sucursales WHERE idsucursales = '$idsucursal'";
				   $result_sucursal = $db->consulta($sql_sucursal);
				   $result_sucursal_row = $db->fetch_assoc($result_sucursal);
				  ?>
                  <td align="center"><?php echo utf8_encode($result_sucursal_row['sucursal']); ?></td>
                  <td align="center">
                  
                  
                    <!--<input type="image" src="images/print.png" title="IMPRIMIR" onclick="imprimirPDF('ventas/pdf/pedidoPagado.php?id=<?php echo $result_pedidos_row['idnota_remision']; ?>')">-->
                    
                    <?php
					if($impresion == 0){ 
					?>
                    <input type="image" src="images/printer.png" width="16" title="IMPRIMIR" onclick="imprimirPDF('ventas/pdf/pedidoPagado.php?id=<?php echo $result_pedidos_row['idnota_remision']; ?>')">
                    <?Php
					}else{
						if($impresion == 1){
					?>
                    <input type="image" src="images/printer.png" width="16" title="IMPRIMIR" onclick="imprimirPDF('ventas/pdf/pedidoPagado_termico.php?id=<?php echo $result_pedidos_row['idnota_remision']; ?>')">
                    
                    <?Php
						}else{
						 ?>
                         <input type="image" src="images/printer.png" width="16" title="IMPRIMIR" onclick="imprimirPDF('ventas/pdf/pedidoPagado_termico2.php?id=<?php echo $result_pedidos_row['idnota_remision']; ?>')">
                         <?php
						}
					}
					?> 
                    
                    
                    
                   <!-- <input type="image" src="images/icn_logout.png" title="CANCELAR" onclick="cancelarPedidoPagado('<?php echo  $result_pedidos_row['idnota_remision'];?>')">-->
                   
                  </td> 
				</tr>
                
                <?php
				}while($result_pedidos_row = $db->fetch_assoc($result_pedidos));
				?>
 
            	
			</tbody> 
			</table>
            
            </div>
            
 </article>          
 
 <div class="clear"></div>
 
 




