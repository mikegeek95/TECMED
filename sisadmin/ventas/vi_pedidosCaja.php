<?php
     header("Content-Type: text/text; charset=ISO-8859-1");
    
	 require_once("../clases/conexcion.php");	 
     require_once("../clases/class.Ventas.php");
	 require_once("../clases/class.Clientes.php");
	

	  $db = new MySQL();
	  $vent = new Ventas();
	  $client = new Clientes();
		
	  $vent->db = $db;
	  $client->db = $db;
	  
	  $tipopago = array('Efectivo','TC','TD','Cheque','Depósito','Transferencia');
	
	  $estatus  = array('Pendiente','Pagado','Cancelado','Créditos','Crédito Pagado','Transferencia');



     
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



			<table  class="tablesorter" cellspacing="0" id="d_modulos"> 
			<thead> 
				<tr> 
   					<th>ID PEDIDO</th> 
    				<!--<th>FECHA</th>-->
                    <th>TOTAL</th>
                    <!--<th>TiPO PAGO</th>-->
                    <th>ACCIddd&Oacute;N</th>
				</tr> 
			</thead> 
			<tbody> 
             <?php 
	 
	     $pedidos = $vent->Lista_Pedidos_Pendientes();
	 
	     foreach($pedidos as $pedidos)
				{
					
					
					if($pedidos->idcliente != 0)
					{
						$pedidos->idcliente ;
						$client->idCliente = $pedidos->idcliente;								
						$result_cliente = $client->ObtenerInformacionCliente();					
						$cliente = $result_cliente['nombre'].' '.$result_cliente['paterno'] .' '.$result_cliente['materno'];
				    }else
					{
			           $cliente = "VENTANILLA";			
						}
					
					
					?>
            
          
            
				<tr> 
   				  <td style="text-align:center">P-<?php echo $pedidos->idnota_remision; ?></td> 
   				  <!--<td><?php/* echo $pedidos->fechapedido;*/ ?></td>-->
                  <td align="center">$ <?php echo number_format($pedidos->total,2,'.',','); ?></td>
                  <!--<td align="center"><?PHP /*echo $tipopago[$pedidos->tipo_pago];*/ ?></td>-->
                  <td align="center">
                    <input type="button" value="COLOCAR" onClick="colocarIdNotaCaja(<?php echo $pedidos->idnota_remision?>);verDatosPagoCaja();datosClienteCaja();"/>
                   
                    </td> 
				</tr>
                
                <?php
				}
				?>
 
            	
			</tbody> 
			</table>