<?php	
require_once ("../clases/conexcion.php");
require_once ("../clases/class.Credito.php");

try
{

$db = new MySQL ();
$credito = new creditos ();

$credito->db = $db ;



$id = $credito->idnota_remision = $_POST['idnota_remision'];
		
        	 $sql_historial = "SELECT  cd.idcredito , c.idnota_remision ,  DATE(cd.fecha_deposito) AS fecha, 
cd.deposito , CONCAT(cl.nombre,' ',cl.paterno,' ',cl.materno) AS cliente, cd.descripcion FROM credito c , credito_detalle cd , clientes cl WHERE c.idcredito = cd.idcredito AND c.idcliente = cl.idcliente AND c.idnota_remision = '$id'";
			
			$result_historial = $db->consulta($sql_historial);
			$result_historial_row = $db->fetch_assoc($result_historial);
			$result_historial_row_num = $db->num_rows($result_historial);
		
		?>
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
				
				var oTable = $('#tbl_historial').dataTable( {		
					
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

       <header><ul class="tabs">
            <li><a href="#"  onclick="reciboCreditoH('<?php //echo $credito->idcretdito ?>')">Imprimir</a></li>
        </ul></header><br /> 
        <table  class="tablesorter" cellspacing="0" id="tbl_historial"> 
			<thead> 
				<tr>
				  <th>&nbsp;</th> 
   					<th align="center">ID CRÉDITO</th> 
    				<th align="center">FECHA</th>
                    <th align="center">ORD. COMPRA.</th>
                    <th align="center">CLIENTE</th>
                    <th align="center">DESC.</th>
                    <th align="center">PAGO</th>
				</tr> 
			</thead> 
			<tbody> 
             <?php 
			 
	 	if ($result_historial_row_num != 0 ){
	    do{
	 
					?>
            
          
            
				<tr>
				  <td style="text-align:center"><img src="images/print.png" width="17" height="17"  onclick="ventanaSecundaria('ventas/pdf/recibo_pago.php?id=<?php echo $result_historial_row['idcredito']; ?>','COMPROBANTE DE PAGO',"location=1,status=1,scrollbars=1",600,500,'true');"/></td> 
   				  <td style="text-align:center"><?php echo $result_historial_row['idcredito']; ?></td> 
   				  <td><?php echo $result_historial_row['fecha']; ?></td>
                  <td style="text-align:center"><?php echo $result_historial_row['idnota_remision']; ?></td> 
                  <td align="center"><?PHP echo utf8_encode ($result_historial_row['cliente']) ?></td>
                  <td align="center"><?PHP echo utf8_encode ($result_historial_row['descripcion']) ?></td>
                  
                  <td align="center">$ <?php echo number_format($result_historial_row['deposito'],2,'.',','); ?></td>
                  
				</tr>
                
                <?php
				}while ($result_historial_row = $db->fetch_assoc($result_historial));
		}//fin del if ($result_historial_row_num != 0 )
		else
          {
			  ?>
              
                <tr>
				    <th></th> 
   					<th></th> 
    				<th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
				</tr>               
              <?php
			  
			  
		}				?>
 
 
 
 
            	
			</tbody> 
			</table>
        
        
        
        
   <?php
}//fin del try
catch (Exception $e)
{
	$v = explode ('|',$e);
		// echo $v[1];
	     $n = explode ("'",$v[1]);
		 $n[0];
	$result = $db->m_error($n[0]);
	echo $result ;
	
}




?>     
        
        