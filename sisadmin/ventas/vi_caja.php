<?php
require_once("../clases/class.Sesion.php");
$se = new Sesion();

if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}

     header("Content-Type: text/text; charset=ISO-8859-1");
    
	 require_once("../clases/conexcion.php");	 
     require_once("../clases/class.Ventas.php");
	 require_once("../clases/class.Clientes.php");

	  $db = new MySQL();
	  $vent = new Ventas();
	  $client = new Clientes();
		
	  $vent->db = $db;
	  $client->db = $db;
	  
	  $tipo = $_SESSION['se_sas_Tipo'];
	  
	  $tipopago = array('Efectivo','TC','TD','Cheque','Depósito','Transferencia');
	  $estatus  = array('Pendiente','Pagado','Cancelado','Créditos','Crédito Pagado','Transferencia');
	 
	
	if(isset($_GET['ac']))
{
	if($_GET['ac']==1)
	{
		$msj='<div id="mens" class="alert_success">'.$_GET['msj'].'</div>';
	}
	else
	{
		$msj='<div id="mens" class="alert_error">Error. Intentar mas Tarde '.$_GET['ac'].'</div>';
	}
	
	echo '<script type="text/javascript">OcultarDiv(\'mens\')</script>';
 
    echo $msj;
}
     
 ?>


<div class="card mb-3">
	<div class="card-header">
		<h5 class="card-title" style="float: left; margin-top: 5px;">PEDIDOS PENDIENTES DE PAGOS</h5>
		<!--<button type="button" onClick="aparecermodulos('catalogos/fa_paqueteria.php','main');" class="btn btn-info" style="float: right;">AGREGAR PAQUETER&Iacute;A</button>
		<div style="clear: both;"></div>-->
	</div>
  	<div class="card-body">
		<form action="" name="filtro" id="filtro">
			<div class="row">

					<div class="col-md-3">
						<div class="form-group">
							<label>No. Pedido:</label>
							<input class="form-control" type="text" id="v_idventa" name="v_idventa" >
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<label>Fecha Inicio:</label>
							<input class="form-control" type="text" id="inicio" name="inicio" >
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<label>Fecha Fin:</label>
							<input class="form-control" type="text" id="f_fin" name="f_fin">
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<label>Nombre:</label>
							<div class="input-group">
								<input class="form-control" type="text" id="n_nombre" name="nombre">
								<div class="input-group-append" onClick="L_Clientes_venta_cliente();">
									<span class="input-group-text"><i class="mdi mdi-account-search"></i></span>
								</div>
								<input type="hidden" id="nombre" />
							</div>
						</div>
					</div>

					<div class="col-md-3" style="display: none;">
						<div class="form-group">
							<label>Estatus:</label>
							<select name="estatust" id="estatust" class="form-control">
								<option value="t">TODOS</option>
								<option selected value="0">PENDIENTE DE PAGO</option>
								<option value="1">PAGADO</option>
								<option value="2">CANCELADO</option>
								<option value="3">CREDITO</option>
								<option value="4">CREDITO PAGADO</option>
								<option value="5">TRANSFERENCIA</option>
								<option value="6">AUTORIZADOS</option>
							</select>
						</div>
					</div>
				
					<div class="col-md-3">
						<div class="form-group">
							<label>Autorizados:</label>
							<select name="autorizados" id="autorizados" class="form-control">
								<option value="t">TODOS</option>
								<option value="1">AUTORIZADOS</option>
								<option value="0">NO AUTORIZADOS</option>
							</select>
						</div>
					</div>
			</div>
		</form>
  	</div>
	
	<div class="card-footer text-muted" style="text-align: right;">
		<input type="button" value="BUSCAR" class="btn btn-info" onClick="buscarCaja('filtro');" style="margin-top: 5px;" >
	</div>
</div>

<div class="card">
	<div class="card-body">
		<div id="li_modulos" class="module_content">
    		<div id="li_pedidos" class="tab_container">
    			<table  class="table table-bordered" cellspacing="0" id="d_modulos"> 
        			<thead> 
            			<tr> 
							<th>ORD. COMP.</th> 
							<th>FECHA</th>
							<th>NOMBRE</th>
							<th>TOTAL</th>
							<th>ESTATUS</th>
							<th>SUCURSAL</th>
							<th>ACCI&Oacute;N</th>
            			</tr> 
        			</thead>
					
        			<tbody> 
						<?php 	 
	 						if($tipo == 0){
	    						$pedidos = $vent->Lista_Pedidos_Pendientes();
							}else{
								$idsucursales = $_SESSION['se_sas_Sucursal'];
								$vent->idsucursales = $idsucursales;
								$pedidos = $vent->Lista_Pedidos_Pendientes_sucursal();
							}
			 
	     					foreach($pedidos as $pedidos)
							{
								if($pedidos->idcliente != 0)
								{
									$pedidos->idcliente ;
									$client->idCliente = $pedidos->idcliente;								
									$result_cliente = $client->ObtenerInformacionCliente();					
									$cliente = $result_cliente['nombre'].' '.$result_cliente['paterno'] .' '.$result_cliente['materno'];
				    			}else{
			           				$cliente = "VENTANILLA";			
								}	
							?>
						<tr> 
   				  			<td style="text-align:center"><?php echo $pedidos->idnota_remision; ?></td> 
   				  			<td><?php echo $pedidos->fechapedido; ?></td>
   				  			<td align="left"><?php echo $cliente; ?></td>
                  			<td align="center">$ <?php echo number_format($pedidos->total,2,'.',','); ?></td>
                  			<td align="center"><?PHP echo $estatus[$pedidos->estatus]; ?></td>
							  <?php
								$idsucursal = $pedidos->idsucursales;
								$sql_sucursal = "SELECT * FROM sucursales WHERE idsucursales = '$idsucursal'";
								$result_sucursal = $db->consulta($sql_sucursal);
								$result_sucursal_row = $db->fetch_assoc($result_sucursal); 
							   ?>
                   
                   			<td align="center"><?php echo utf8_encode($result_sucursal_row['sucursal']); ?></td>
              
                  			<td align="center">
                    			<input type="button" class="btn btn-success" value="PAGAR" onclick="verCaja('<?php echo $pedidos->idnota_remision?>','0')"/>
							</td> 
						</tr>
						<?php
						}
						?>
        			</tbody> 
        		</table>
			</div>
		</div>	
	</div>
</div>


<script type="text/javascript" charset="utf-8">
		
			$(document).ready(function() {
				
				var oTable = $('#d_modulos').dataTable( {	
				       //"ordering": false,
					"order": [[ 2, 'asc' ]],
					   "lengthChange": true,
					   "pageLength": 100,	
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
       