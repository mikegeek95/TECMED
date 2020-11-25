<?php
require_once("../clases/conexcion.php");
require_once("../clases/class.Clientes.php");

$db = new  MySQL();
$cl = new Clientes();

$cl->db = $db;

$tipopago = array('Efectivo','TC','TD','Cheque','Depósito','Transferencia');
$estatus  = array('Pendiente','Pagado','Cancela','Créditos');

$sql_pedidos = "SELECT * FROM apartados WHERE estatus = 1 ORDER BY idapartados DESC";

$result_pedidos = $db->consulta($sql_pedidos);
$result_pedidos_row = $db->fetch_assoc($result_pedidos);
$result_pedidos_num = $db->num_rows($result_pedidos);


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
?>


<article class="module width_full">
		<header>
			<h3 class="tabs_involved">APARTADOS</h3>
            <ul class="tabs">
                <li><a href="#" onClick="aparecermodulos('ventas/fa_apartado.php','main');">Agregar Apartado</a></li>
			</ul>
            
             
		</header>
		
		  <div id="li_pedidos" class="tab_container">

<!--INCERTAMOS SKINK PARA EL MANEJO DE LAS TABLAS--> 

        <style type="text/css" title="currentStyle">
			@import "js/grid/css/demo_page.css";
			@import "js/grid/css/demo_table.css";
		</style>
		<script type="text/javascript" language="javascript" src="js/grid/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="js/grid/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="js/grid/js/FixedColumns.js"></script>
		<script type="text/javascript" language="javascript" src="js/grid/js/FixedColumns.min.js"></script>
    
    <!--TERMINAMOS SKIN DE EL MANEJO DE LAS TABLAS--> 


		<script type="text/javascript" charset="utf-8">
		
			$(document).ready(function() {
				
				var oTable = $('#d_modulos').dataTable( {		
					
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
		               "bScrollCollapse": true
					  
					  
						
				} );
				} );
				
				</script>
       
			<table  class="tablesorter" cellspacing="0" id="d_modulos"> 
			<thead> 
				<tr> 
   					<th>NO. AP.</th> 
    				<th>FECHA</th>
    				<th>F. FIN</th>
                    <th>CLIENTE</th>
                    <th>ABONO</th>
                    <!--<th>TiPO PAGO</th>
                    <th>ESTATUS</th>-->
                    <th>ACCI&Oacute;N</th>
				</tr> 
			</thead> 
			<tbody> 
             <?php 
	 if($result_pedidos_num != 0){
	     
	 
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
   				  <td style="text-align:center"><?php echo $result_pedidos_row['idapartados']; ?></td> 
   				  <td><?php echo $result_pedidos_row['fecha']; ?></td>
                  <td><?php echo $result_pedidos_row['fecha_fin']; ?></td>
   				  <td align="center"><?php echo utf8_encode($cliente); ?></td>
                  <td align="center"><?php echo $result_pedidos_row['abono']; ?></td>
                  <!--<td align="center">$ <?php echo number_format($result_pedidos_row['total'],2,'.',','); ?></td>
                  <td align="center"><?PHP echo $tipopago[$result_pedidos_row['tipo_pago']]; ?></td>
                  <td align="center"><?PHP echo $estatus[$result_pedidos_row['estatus']]; ?></td>-->
                  <td align="center">
                    <input type="image" src="images/print.png" title="IMPRIMIR" onclick="imprimirPDF('ventas/pdf/apartado.php?id=<?php echo $result_pedidos_row['idapartados']; ?>')"> 
                    
                    
                    
                    <input type="image" src="images/icn_logout.png" title="CANCELAR" onclick="cancelarApartado('<?php echo  $result_pedidos_row['idapartados'];?>')">
                   
                  </td> 
				</tr>
                
                <?php
				}while($result_pedidos_row = $db->fetch_assoc($result_pedidos));
	 }
				?>
 
            	
			</tbody> 
			</table>
            
            </div>
            
 </article>          
 
 <div class="clear"></div>
 
 




