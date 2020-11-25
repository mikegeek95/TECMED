<?php
require_once("../clases/class.Sesion.php");
$se = new Sesion();

require_once("../clases/conexcion.php");
require_once("../clases/class.Fechas.php");
require_once("../clases/class.Configuracion.php");
require_once("../clases/class.Tipo_entrega.php");
require_once("../clases/class.Clientes.php");


$db = new MySQL();
$fe = new Fechas();
$conf = new Configuracion();
$te = new Tipo_entrega();
$cl = new Clientes();

$conf->db = $db;
$te->db = $db;
$cl->db = $db;

$tipo = $_SESSION['se_sas_Tipo'];


$te->estatus = $_POST['estatus'];
$te->tipo_envio = $_POST['tipo_entrega'];

$result_entregas = $te->obtener_filtro_entregas();
$result_entregas_num = $db->num_rows($result_entregas);
$result_entregas_row = $db->fetch_assoc($result_entregas);

$suc = $_SESSION['se_sas_Sucursal'];
$sql_imp = "SELECT * FROM sucursales WHERE idsucursales = '$suc'";
$result_imp = $db->consulta($sql_imp);
$result_imp_row = $db->fetch_assoc($result_imp);
$impresion = $result_imp_row['notas_print'];

$estatus  = array('Pendiente de pago','Pagado','Cancelado','Créditos','Crédito Pagado','Transferencia');

?>
<script type="text/javascript" charset="utf-8">
	var oTable = $('#d_entregas').dataTable( {	
	   "ordering": false,
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
	} );
</script>
       
<table  class="table table-bordered table-hover" cellpadding="0" cellspacing="0" id="d_entregas"> 
	<thead> 
		<tr> 
			<th align="center"># PEDIDO</th> 
			<th align="center">CLIENTE</th>
			<th align="center">T. ENTREGA</th>
			<th align="center">ESTATUS</th>
			<th align="center">TOTAL</th>
			<th align="center">ACCI&Oacute;N</th>
		</tr> 
	</thead> 
	<tbody> 
		<?php
		if($result_entregas_num != 0){
			do
			{
				$idcliente = $result_entregas_row['idcliente'];
				
				if($idcliente == 0){
					$nombre_cliente = "PUBLICO GENERAL";
				}else{
					$cl->idCliente = $idcliente;
					$cliente = $cl->ObtenerInformacionCliente();
					$nombre_cliente = utf8_encode($cliente['nombre']." ".$cliente['paterno']." ".$cliente['materno']);
				}
				
				if($result_entregas_row['tipo_envio'] == 0){
					$t_entrega = 'RECOGER EN TIENDA';
				}else{
					$t_entrega = 'ENVIAR A '.$result_entregas_row['direccion_envio'];
				}
		?>
			<tr> 
				<td><?php echo $result_entregas_row['idnota_remision']; ?></td> 
				<td><?php echo $nombre_cliente; ?></td>
				<td style="text-transform: uppercase"><?php echo $t_entrega; ?></td>
				<td><?php echo $estatus[$result_entregas_row['estatus']]; ?></td>
				<td><?php echo "$ ".$result_entregas_row['total']; ?></td>
				<td align="center">
					<?php
					if($impresion == 0){ 
					?>
					<button type="button" onClick="imprimirPDF('ventas/pdf/pedidoPagado.php?id=<?php echo $result_entregas_row['idnota_remision']; ?>')" title="IMPRIMIR" class="btn btn-outline-danger"><i class="mdi mdi-printer"></i></button>
                    <?Php
					}else{
						if($impresion == 1){
					?>
						<button type="button" onClick="imprimirPDF('ventas/pdf/pedidoPagado_termico.php?id=<?php echo $result_entregas_row['idnota_remision']; ?>')" title="IMPRIMIR" class="btn btn-outline-danger"><i class="mdi mdi-printer"></i></button>
                    
                    <?Php
						}else{
							?>
							<button type="button" onClick="imprimirPDF('ventas/pdf/pedidoPagado_termico2.php?id=<?php echo $result_entregas_row['idnota_remision']; ?>')" title="IMPRIMIR" class="btn btn-outline-danger"><i class="mdi mdi-printer"></i></button>
                            <?php
						}
					}
					?>
				</td> 
			</tr>
		<?php	
			}while($result_entregas_row = $db->fetch_assoc($result_entregas));
		}
		?>
	</tbody> 
</table>