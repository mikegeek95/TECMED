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
     require_once("../clases/class.Funciones.php");

	  $db = new MySQL();
	  $vent = new Ventas();
	  $client = new Clientes();
      $fu = new Funciones();
		
	  $vent->db = $db;
	  $client->db = $db;
	  
	  $tipopago = array('Efectivo','TC','TD','Cheque','Depósito','Transferencia');
      $tipoenvio = array('RECOGER EN TIENDA','A DOMICILIO');
	  $estatus  = array('Pendiente','Pagado','Cancelado','Créditos','Crédito Pagado','Transferencia','Autorizados');
	  
	  $tipo = $_SESSION['se_sas_Tipo'];
	  
if(isset($_GET['ac']))
	{
		if($_GET['ac']==1)
		{
			$msj='<div id="mens" class="alert alert-success" role="alert">'.$_GET['msj'].'</div>';
		}
		else
		{
			$msj='<div id="mens" class="alert alert-danger" role="alert">Error. Intentar mas Tarde '.$_GET['msj'].'</div>';
		}

		echo '<script type="text/javascript">OcultarDiv(\'mens\')</script>';

		echo $msj;
	}	



 ?>
  
 <script>
	 
	 jQuery('#inicio').datepicker({
			format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
			orientation: "bottom"
        });
	 
	 jQuery('#f_fin').datepicker({
			format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
			orientation: "bottom"
        });
	   
	 var oTable = $('#d_modulos').dataTable( {	
		 	 //"ordering": false,
		 "order": [[ 2, 'asc' ]],
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
			   "bScrollCollapse": true



		} );
	
  </script>

<div class="card mb-3">
	<div class="card-header">
		<h5 class="card-title" style="float: left; margin-top: 5px;">FILTRAR ORD. DE COMPRA</h5>
		<button type="button" onClick="aparecermodulos('ventas/fa_ventas.php','main');" class="btn btn-info" style="float: right;">AGREGAR ORD. DE COMPRA</button>
		<div style="clear: both;"></div>
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

				<div class="col-md-3">
					<div class="form-group">
						<label>Estatus:</label>
						<select name="estatust" id="estatust" class="form-control">
							<option value="n">Seleccione un estatus</option>
							<option value="0">PENDIENTE DE PAGO</option>
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
		<input type="button" value="BUSCAR" class="btn btn-info" onClick="buscarPedido('filtro');" style="margin-top: 5px;" >
	</div>
</div>


<div class="card">
	<div class="card-body">
		<div id="li_modulos" class="module_content">
    		<div id="li_pedidos" class="tab_container">
    			<table  class="table table-bordered" cellspacing="0" id="d_modulos"> 
        			<thead> 
            			<tr> 
							<th align="center">ORD. COMP.</th> 
							<th align="cealign=">FECHA</th>
							<th align="center">NOMBRE</th>
							<th align="center">TOTAL</th>
							<th align="center">ESTATUS</th>
							<th align="center">TIPO ENVIO</th>
							<th align="center">DIRECCION ENVIO</th>
							<th align="center">SUCURSAL</th>
							<th align="center">ACCI&Oacute;N</th>
            			</tr> 
        			</thead>
					
        			<tbody> 
        			<?php 
						$idsucursales = $_SESSION['se_sas_Sucursal'];
						if($tipo == 0){
							$pedidos = $vent->Lista_Pedidos_Pendientes();
						}else{
							$vent->idsucursales = $idsucursales;
							$pedidos = $vent->Lista_Pedidos_Pendientes_sucursal();
						}


						$sql_imp = "SELECT * FROM sucursales WHERE idsucursales = '$idsucursales'";
						$result_imp = $db->consulta($sql_imp);
						$result_imp_row = $db->fetch_assoc($result_imp);
						$impresion = $result_imp_row['notas_print'];

			
	     				foreach($pedidos as $pedidos)
            			{
							if($pedidos->idcliente != 0)
                			{
								$pedidos->idcliente ;
								$client->idCliente = $pedidos->idcliente;								
								$result_cliente = $client->ObtenerInformacionCliente();					
								$cliente = $result_cliente['nombre'].' '.$result_cliente['paterno'] .' '.$result_cliente['materno'];
                                $direccionenvio = $pedidos->direccion_envio;
                                $tipo_envio = $pedidos->tipo_envio;
;                			}else{
                   				$cliente = "VENTANILLA";			
                 			}
							
							if($pedidos->autorizado == 0){
								$icon = 'mdi mdi-close-circle';
							}else{
								$icon = 'mdi mdi-check-circle';
							}
							
							if($result_pedidos_row['estatus'] == 2){
						//Cancelado
						$color = "#F25781";
					}else{
						if($result_pedidos_row['estatus'] == 1){
							//Pagado
							$color = "#07D9B2";
						}else{
							if($result_pedidos_row['estatus'] == 0){
								//pendientes
								$color = '#F2E74B';
							}else{
								$color = "";
							}
						}
					}
                	?>
            			<tr> 
					  		<td style="text-align:center"><?php echo $fu->imprimir_cadena_utf8($pedidos->idnota_remision); ?> <i class="<?php echo $icon; ?>"></i></td> 
					  		<td><?php echo $pedidos->fechapedido; ?></td>
					  		<td align="left"><?php echo ($cliente); ?></td>
					  		<td align="center">$ <?php echo $fu->imprimir_cadena_utf8(number_format($pedidos->total,2,'.',',')); ?></td>
					  		<td align="center" style="background:<?php echo $color; ?>; color:#000;"><?PHP echo $fu->imprimir_cadena_utf8($estatus[$pedidos->estatus]); ?></td>
					  		<td align="center"><?PHP echo $fu->imprimir_cadena_utf8($tipoenvio[$tipo_envio]); ?></td>
					  		<td align="center"><?php echo $fu->imprimir_cadena_utf8($direccionenvio); ?></td>
				  		  <?php
			  			$idsucursal = $pedidos->idsucursales;
						$sql_sucursal = "SELECT * FROM sucursales WHERE idsucursales = '$idsucursal'";
						$result_sucursal = $db->consulta($sql_sucursal);
						$result_sucursal_row = $db->fetch_assoc($result_sucursal); 
			  		?>
              				<td align="center"><?php echo utf8_encode($result_sucursal_row['sucursal']); ?></td>
              				<td align="center">
								
								
								<!--<a href="#" onClick="BorrarDatos(<?php echo $fu->imprimir_cadena_utf8($result_proveedor_row['idproveedores']); ?>,'idproveedores','proveedores','n','catalogos/vi_proveedores.php','main')" title="BORRAR"><i class="mdi mdi-delete-empty"></i></a>-->
               
								
							<a href="#" onClick="imprimirPDF('ventas/pdf/etiqueta_pedido.php?id=<?php echo $fu->imprimir_cadena_utf8($pedidos->idnota_remision); ?>')" title="IMPRIMIR ETIQUETA DE PEDIDO"><i class="mdi mdi-tag-outline"></i></a>

								
               				<!-- BOTONES DE IMPRESION VALIDANDO TERMICO O CARTA --> 
                			<?php
							if($impresion == 0){ 
							?>
								<a href="#" onClick="imprimirPDF('ventas/pdf/pedidoPagado.php?id=<?php echo $fu->imprimir_cadena_utf8($pedidos->idnota_remision); ?>')" title="IMPRIMIR"><i class="mdi mdi-printer"></i></a>
                    		<?php
							}else{
								if($impresion == 1){
							?>
									<a href="#" onClick="imprimirPDF('ventas/pdf/pedidoPagado_termico.php?id=<?php echo $fu->imprimir_cadena_utf8($pedidos->idnota_remision); ?>')" title="IMPRIMIR"><i class="mdi mdi-printer"></i></a>
                    		<?php
								}else{
							?>
									<a href="#" onClick="imprimirPDF('ventas/pdf/pedidoPagado_termico2.php?id=<?php echo $fu->imprimir_cadena_utf8($pedidos->idnota_remision); ?>')" title="IMPRIMIR"><i class="mdi mdi-printer"></i></a>
                            <?php
								}
							}
							?>
								
								
								<a href="#" onClick="abrir_detalle_sobrepedido('ventas/vi_anticipos_pedido.php?id=<?php echo $fu->imprimir_cadena_utf8($pedidos->idnota_remision); ?>');" title="VER ANTICIPOS" style="font-size: 11px;"><i class="mdi mdi-square-inc-cash"></i></a>
																
								<a href="#" onClick="abrir_detalle_sobrepedido('ventas/vi_depositos_pedido.php?id=<?php echo $fu->imprimir_cadena_utf8($pedidos->idnota_remision); ?>');" title="DEPOSITOS" style="font-size: 11px;"><i class="mdi mdi-credit-card-plus"></i></a>
								
								<a href="#" onClick="abrir_detalle_sobrepedido('ventas/vi_guias_pedido.php?id=<?php echo $fu->imprimir_cadena_utf8($pedidos->idnota_remision); ?>');" title="GUIAS" style="font-size: 12px;"><i class="mdi mdi-truck-delivery"></i></a>
								
								<!--<a href="#" onclick="aparecermodulos('ventas/fc_ventas.php?id=<?php echo $fu->imprimir_cadena_utf8($pedidos->idnota_remision); ?>','main')" title="EDITAR" style="font-size: 12px;"><i class="mdi mdi-table-edit"></i></a>-->
								
								<a href="#" onClick="cancelarPedidoPagado('<?php echo $fu->imprimir_cadena_utf8($pedidos->idnota_remision); ?>')" title="CANCELAR" style="font-size: 11px;"><i class="mdi mdi-block-helper"></i></a>
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