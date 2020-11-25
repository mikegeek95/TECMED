<?php
require_once("../clases/conexcion.php");
require_once("../clases/class.Clientes.php");
require_once("../clases/class.Fechas.php");
require_once("../clases/class.Funciones.php");


$db = new MySQL();
$cl = new Clientes();
$fe = new Fechas();
$f = new Funciones();

$cl->db = $db;


$fecha_actual = $fe->fechaaYYYY_mm_dd_guion();
$fi=explode("/",$_POST['f_inicio']);
$ff=explode("/",$_POST['f_fin']);
$fecha = ($_POST['f_inicio'] != '' ) ? $fi[2]."-".$fi[0]."-".$fi[1] : '1900-01-01';
$fecha_fin =($_POST['f_fin'] != '' ) ? $ff[2]."-".$ff[0]."-".$ff[1] : $fecha_actual;


$nombre = (trim($f->guardar_cadena_utf8($_POST['nombre'])));


$b_where = 0;

$sql_pedidos ="SELECT nota_remision.*, clientes.idcliente, clientes.nombre, clientes.paterno, clientes.materno FROM nota_remision  LEFT OUTER JOIN clientes ON nota_remision.idcliente = clientes.idcliente ";


//$sql_devo = "SELECT cdd.idnota_remision, cd.idcliente_devolucion, cd.fecha, cd.total, c.nombre, c.paterno, c.materno, nr.idcliente FROM cliente_devolucion cd, nota_remision nr, clientes c, cliente_devolucion_detalle cdd WHERE cd.idcliente_devolucion = cdd.idcliente_devolucion AND cdd.idnota_remision = nr.idnota_remision AND nr.idcliente = c.idcliente";


$sql_pedidos.= ($fecha && $fecha_fin) ? " WHERE date(nota_remision.fechapedido)>= date('$fecha') AND date(nota_remision.fechapedido) <= date('$fecha_fin') " : " WHERE date(nota_remision.fechapedido)>= '1900-01-01' AND DATE(nota_remision.fechapedido) <= '$fecha_actual' ";

//$sql_devo.= ($fecha && $fecha_fin) ? " AND date(cd.fecha)>= date('$fecha') AND date(cd.fecha) <= date('$fecha_fin') " : " AND date(cd.fecha)>= '1900-01-01' AND DATE(cd.fecha) <= '$fecha_actual' ";

$sql_pedidos.=($nombre != "") ? " AND CONCAT(clientes.nombre,' ',clientes.paterno,' ',clientes.materno) LIKE TRIM('%$nombre%')":"";

//$sql_devo.=($nombre != "") ? " AND CONCAT(c.nombre,' ',c.paterno,' ',c.materno) LIKE TRIM('%$nombre%')":"";

	
$sql_pedidos.= "AND nota_remision.estatus = '1' ORDER BY nota_remision.idnota_remision DESC";
//$sql_devo.= "GROUP BY cd.idcliente_devolucion ORDER BY cd.idcliente_devolucion DESC";

//echo $sql_pedidos ;

//die($sql_pedidos);

//$sql = "SELECT * FROM nota_remision";

$result_pedidos = $db->consulta($sql_pedidos);
$result_pedidos_row = $db->fetch_assoc($result_pedidos);
$result_pedidos_num = $db->num_rows($result_pedidos);

//$result_devo = $db->consulta($sql_devo);
//$result_devo_row = $db->fetch_assoc($result_devo);
//$result_devo_num = $db->num_rows($result_devo);


$sql_ventas_mandar = $f->conver_especial($f->imprimir_cadena_utf8($sql_pedidos));
//$sql_devo_mandar = $f->conver_especial($sql_devo);

$tipopago = array('Efectivo','TC','TD','Cheque','Depósito','Transferencia');
$estatus  = array('Pendiente','Pagado','Cancelado','Créditos','Crédito Pagado','Transferencia');




//die("Cantidad de registros es : ".$result_row_num);
if($result_pedidos_num==0){
?>
<div align="center"><h3><label>NO HAY REGISTROS PARA ESTE CLIENTE</label></h3></div>

<?php
	}
else{
?>

<!--INCERTAMOS SKINK PARA EL MANEJO DE LAS TABLAS--> 

        	 <style type="text/css" title="currentStyle">
			@import "js/grid/css/demo_page.css";
			@import "js/grid/css/demo_table.css";
			.impp{ padding:3px; background:none; border:1px solid green; border-radius: 8px;}
			.impp:hover{ background:green; border:1px solid green;color: white;}
			.impe img{ z-index: 2;}

			.impe{ padding:3px; background:none; border:1px solid red;  border-radius: 8px;}
			.impe:hover{ background: rgba(255,0,0); border:1px solid red; color: white}

		</style>
	
		<!--<script type="text/javascript" language="javascript" src="js/grid/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="js/grid/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="js/grid/js/FixedColumns.js"></script>
		<script type="text/javascript" language="javascript" src="js/grid/js/FixedColumns.min.js"></script>-->
        
        
        <!-- DataTables CSS -->
            <!--<link rel="stylesheet" type="text/css" href="js/media/css/jquery.dataTables.css">-->
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
					   "pageLength": 100,	
					   "columns": [{ "title": "ORD. COMP." },
									null,
									null,
									null,
									null,
									null
								  ],				
					   "oLanguage": {
									"sLengthMenu": "Mostrar _MENU_ Registros por p&aacute;gina",
									"sZeroRecords": "Nada Encontrado - Disculpa",
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
				
				
				var oTable = $('#d_modulos2').dataTable( {	
				       "ordering": false,	
					   "lengthChange": true,
					   "pageLength": 100,	
					   "columns": [{ "title": "No. DEV." },
									null,
									null,
									null,
									null,
									null
								  ],				
					   "oLanguage": {
									"sLengthMenu": "Mostrar _MENU_ Registros por p&aacute;gina",
									"sZeroRecords": "Nada Encontrado - Disculpa",
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
                
                <div style="padding:2px; width:100%;">
            	<button class="impe" type="button" class="btn btn-outline-danger" onclick="imprimirPDF('ventas/pdf/reporteventa_cliente.php?sql_venta=<?php echo $sql_ventas_mandar;?>&sql_devo=<?php echo $sql_devo_mandar; ?>');" > <img src="./images/pdf.png" width="30" height="30" >    Imprimir Reporte</button>
               
                <a  href="ventas/excel/excelventa_cliente.php?sql_venta=<?php echo $sql_ventas_mandar;?>&sql_devo=<?php echo $sql_devo_mandar; ?>">
                <button class="impp"  type="button" >
      
	                <img  width="30" height="30" src="./images/excel.png" title="GUARDAR EN EXCEL" />
	            	Exportar a Excel</button>
	            	 </a>
            </a>
                
			</div>
            
                
                        <h2 align="center">VENTAS </h5>

        <div class="col-12 table-responsive">
			<table   cellspacing="0" id="d_modulos" class="table table-bordered" > 
			<thead> 
				<tr> 
   					<th>ORD. COMP.</th> 
    				<th>FECHA</th>
    				<th>NOMBRE</th>
                    <th>ESTATUS</th>
                    <th>T. EFEC</th>
                    <th>T. MON</th>
                    <th>TOTAL</th>
                    <th>ACCI&Oacute;N</th>
				</tr> 
			</thead> 
			<tbody> 
             <?php 
			//Validamos que existan registros en la consulta
			if($result_pedidos_num!=0){ 
	     		do
				{
					
					if($result_pedidos_row['idcliente'] != 0)
					{
						$cl->idCliente = $result_pedidos_row['idcliente'];								
						$result_cliente = $cl->ObtenerInformacionCliente();					
						$cliente = $result_cliente['nombre'].' '.$result_cliente['paterno'] .' '.$result_cliente['materno'];
				    }
					else
					{
			           $cliente = "VENTANILLA";			
					}
					
					
					/*if($result_pedidos_row['estatus'] == 2){
						//Cancelado
						$color = "#F00";
					}else{
						if($result_pedidos_row['estatus'] == 1){
							//Pagado
							$color = "#00a65a";
						}else{
							if($result_pedidos_row['estatus'] == 0){
								//pendientes
								$color = '#f9ed32';
							}else{
								$color = "";
							}
						}
					}*/
							
							$efectivo = $result_pedidos_row['monto_efec'] + $result_pedidos_row['monto_transfer'] + $result_pedidos_row['monto_deposito'] + $result_pedidos_row['monto_cheque'] + $result_pedidos_row['monto_tc'] - $result_pedidos_row['cambio'];
					?>
            
          
            
				<tr style="color:black;"> 
   				  <td style="text-align:center"><?php echo $result_pedidos_row['idnota_remision']; ?></td> 
   				  <td><?php echo $result_pedidos_row['fechapedido']; ?></td>
   				  <td align="left"><?php echo utf8_encode($cliente); ?></td>
                  <td align="center"><?PHP echo $estatus[$result_pedidos_row['estatus']]; ?></td>
                  <td align="center">$ <?php echo number_format($efectivo,2,'.',','); ?></td>
                  <td align="center">$ <?php echo number_format($result_pedidos_row['monto_virtual'],2,'.',','); ?></td>
                  <td align="center">$ <?php echo number_format($result_pedidos_row['total'],2,'.',','); ?></td>
                  <td align="center">
                  	<input type="image" src="images/printer.png" width="16" title="IMPRIMIR" onclick="imprimirPDF('ventas/pdf/pedidoPagado.php?id=<?php echo $result_pedidos_row['idnota_remision']; ?>')">
                    
                    <!--<input type="image" src="images/icn_categories.png" title="LISTAR PRODUCTOS" onclick="aparecermodulos('ventas/vi_productosPedido.php?id=<?php echo $result_pedidos_row['idnota_remision'];?>','main');">-->
                    &nbsp;
                    
                    <?php
					if($result_pedidos_row['estatus'] != 2){ 
					?>
                <!--<input type="image" src="images/icn_logout.png" title="CANCELAR" onclick="cancelarPedidoPagado('<?php echo $result_pedidos_row['idnota_remision'] ?>')"> -->  
                <?php
					}
				?>   
                  </td> 
				</tr>
                
                <?php
					$total_efectivo = $total_efectivo + $efectivo;
					$total_monedero = $total_monedero + $result_pedidos_row['monto_virtual'];
					$total = $total + $result_pedidos_row['total'];
				}while($result_pedidos_row = $db->fetch_assoc($result_pedidos));
			}
				?>
                
                <tr style="color:black;">
                	<td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td align="right">TOTALES: </td>
					<td align="right">$ <?php echo number_format($total_efectivo,2,'.',','); ?></td>
                    <td align="right">$ <?php echo number_format($total_monedero,2,'.',','); ?></td>
                    <td align="center">$ <?php echo number_format($total,2,'.',','); ?> </td>
                    <td>&nbsp;</td>
                </tr>
 
            	
			</tbody> 
			</table>
            </div>
            
            
         <!--  
            <br><br><br>
            
                        <h2 align="center">DEVOLUCIONES </h5>
             <div class="table-responsive">        	
            <table   cellspacing="0" id="d_modulos2" class="table table-bordered"> 
			<thead> 
				<tr>
                	<th>NO DEV.</th> 
   					<th>ORD. COMP.</th> 
    				<th>FECHA</th>
    				<th>NOMBRE</th>
                    <th>TOTAL</th>
                   <th>ESTATUS</th>
                    <th>ACCI&Oacute;N</th>
				</tr> 
			</thead> 
			<tbody> 
             <?php 
			//Validamos que existan registros en la consulta
			if($result_devo_num != 0){ 
	     		do
				{
					
					if($result_devo_row['idcliente'] != 0)
					{
						$cl->idCliente = $result_devo_row['idcliente'];								
						$result_cliente2 = $cl->ObtenerInformacionCliente();					
						$cliente2 = $result_cliente2['nombre'].' '.$result_cliente2['paterno'] .' '.$result_cliente2['materno'];
				    }
					else
					{
			           $cliente2 = "VENTANILLA";			
					}
					
					?>
            
          
            
				<tr style="color:#black;"> 
                	<td style="text-align:center"><?php echo $result_devo_row['idcliente_devolucion']; ?></td> 
   				  <td style="text-align:center"><?php echo $result_devo_row['idnota_remision']; ?></td> 
   				  <td><?php echo $result_devo_row['fecha']; ?></td>
   				  <td align="left"><?php echo utf8_encode($cliente2); ?></td>
                  <td align="center">$ <?php echo number_format($result_devo_row['total'],2,'.',','); ?></td>
                  <td align="center"><?PHP echo $estatus[$result_pedidos_row['estatus']]; ?></td>
                  <td align="center">
                  	<input type="image" src="images/printer.png" width="16" title="IMPRIMIR" onclick="imprimirPDF('ventas/pdf/devolucion.php?id=<?php echo $result_devo_row['idcliente_devolucion']; ?>')">
                    
                   <input type="image" src="images/icn_categories.png" title="LISTAR PRODUCTOS" onclick="aparecermodulos('ventas/vi_productosPedido.php?id=<?php echo $result_pedidos_row['idnota_remision'];?>','main');">
                    &nbsp;
                    
                    <?php
					if($result_pedidos_row['estatus'] != 2){ 
					?>
               <input type="image" src="images/icn_logout.png" title="CANCELAR" onclick="cancelarPedidoPagado('<?php echo $result_pedidos_row['idnota_remision'] ?>')">   
                <?php
					}
				?>   
                  </td> 
				</tr>
                
                <?php
					$total2 = $total2 + $result_devo_row['total'];
				}while($result_devo_row = $db->fetch_assoc($result_devo));
			}
				?>
                
                <tr style="color:black;">
                	<td>&nbsp;</td>
                	<td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td align="right">TOTAL: </td>
                    <td align="center">$ <?php echo number_format($total2,2,'.',','); ?> </td>
                    <td>&nbsp;</td>
                </tr>
 
            	
			</tbody> 
			</table>
			</div>   
         -->
     <!--       <br><br><br>
            
            <h2 align="center">DESGLOSE DE TOTALES </h5>
            	<div class="table-responsive">
            <table   cellspacing="0" id="d_modulos3"> 
			<thead> 
				<tr>
                	<th>VENTAS</th> 
   					<th>DEVOLUCION</th> 
    				<th>TOTAL</th>
                    <th>TOTAL EFECTIVO</th>
                    <th>TOTAL MONEDERO</th>
				</tr> 
			</thead> 
			<tbody style="color:#black; "> 
				<td align="center"><?php echo "$ ".number_format($total,2,'.',','); ?></td>
                <td align="center"><?php echo "$ ".number_format($total2,2,'.',','); ?></td>
                <td align="center"><?php echo "$ ".number_format(($total - $total2),2,'.',',');?></td>
                <td align="center"><?php echo "$ ".number_format($total_efectivo,2,'.',',');?></td>
                <td align="center"><?php echo "$ ".number_format($total_monedero,2,'.',',');?></td>
			</tbody> 
			</table>
			</div>

-->
<?php 
}
?>
