<?php
require_once("../clases/class.Sesion.php");
$se = new Sesion();

require_once("../clases/conexcion.php");
require_once("../clases/class.Fechas.php");
require_once("../clases/class.Clientes.php");
require_once("../clases/class.Configuracion.php");
require_once("../clases/class.Funciones.php");


$db = new MySQL();
$fe = new Fechas();
$cl = new Clientes();
$conf = new Configuracion();
$fu = new Funciones();

$conf->db = $db;
$cl->db = $db;


$tipo = $_SESSION['se_sas_Tipo'];

$nombre = trim($fu->guardar_cadena_utf8($_POST['nombre']));
$idnota_remision = $_POST['v_no_pedido'];
$estatus = 1;

$b_where = 0;

$sql_pedidos = "SELECT nota_remision.idnota_remision, 
					   clientes.idcliente, 
					   nota_remision.idusuarios, 
					   nota_remision.fechapedido, 
					   nota_remision.fecha_pago, 
					   nota_remision.idcliente, 
					   nota_remision.total, 
					   nota_remision.estatus, 
					   nota_remision.tipo_pago, 
					   nota_remision.idsucursales,
					   nota_remision.autorizado,
					   clientes.nombre, 
					   clientes.paterno, 
					   clientes.materno
				FROM nota_remision  LEFT OUTER JOIN clientes ON nota_remision.idcliente = clientes.idcliente WHERE nota_remision.estatus = '$estatus' ";


$sql_pedidos .= ($nombre != "") ? " AND CONCAT(clientes.nombre,' ',clientes.paterno,' ',clientes.materno) LIKE TRIM('%$nombre%')":"";	
$sql_pedidos .= ($idnota_remision !="") ? " AND nota_remision.idnota_remision =  '$idnota_remision'  ":" ";	
 
//Validamos que sea superUsuario
if($tipo == 0){
}else{
	$idsucursales = $_SESSION['se_sas_Sucursal'];
	$sql_pedidos.= "AND nota_remision.idsucursales = '$idsucursales'";	
}
$sql_pedidos.= "ORDER BY nota_remision.idnota_remision DESC";


$result_pedidos = $db->consulta($sql_pedidos);
$result_row_num = $db->num_rows($result_pedidos);
$result_pedidos_row = $db->fetch_assoc($result_pedidos);


?>
<script type="text/javascript" charset="utf-8">
	var oTable = $('#d_guias').dataTable( {	
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
	   "sScrollX": "100%",
	   "sScrollXInner": "100%",
	   "bScrollCollapse": true,
	} );
</script>
       
<table  class="table table-bordered" cellspacing="0" id="d_campanas"> 
	<thead> 
		<tr> 
			<th align="center=">No. PEDIDO</th>
            <th align="center">CLIENTE</th>
            <th align="center">DIRECCI&Oacute;N DE ENV&Iacute;O</th>
            <th align="center">ACCI&Oacute;N</th>
		</tr> 
	</thead> 
	<tbody> 
		<?php
		if($result_row_num != 0){
			do
			{
				if($result_pedidos_row['idcliente'] != 0)
				{
					$cl->idCliente = $result_pedidos_row['idcliente'];								
					$result_cliente = $cl->ObtenerInformacionCliente();					
					$cliente = $result_cliente['nombre'].' '.$result_cliente['paterno'] .' '.$result_cliente['materno'];
			    }else{
			       	$cliente = "VENTANILLA";			
				}
		?>
			<tr> 
				<td><?php echo $result_pedidos_row['idnota_remision']; ?></td> 
				<td><?php echo $fu->imprimir_cadena_utf8($cliente); ?></td>
				<td><?php echo $fu->imprimir_cadena_utf8($result_cliente['direccion_envio']);  ?></td>
				<td align="center">
					
					<a class="iconped" href="#" onClick="abrir_detalle_sobrepedido('ventas/vi_guias_pedido.php?id=<?php echo $result_pedidos_row['idnota_remision']; ?>');" title="GUIAS" style="font-size: 13px;">
                    	<i class="mdi mdi-truck-delivery"></i>
                    </a>
                    
                    <a class="iconped" href="#" onClick="imprimirPDF('ventas/pdf/reporte_guias.php?id=<?php echo $result_pedidos_row['idnota_remision']; ?>')" title="IMPRIMIR ETIQUETA DE PEDIDO">
                    	<i class="mdi mdi-printer"></i>
                    </a>
					
				</td> 
			</tr>
		<?php	
			}while($result_pedidos_row = $db->fetch_assoc($result_pedidos));
		}else{
		?>
        	<tr>
                <td align="center" colspan="4">LO SENTIMOS, NO EXISTEN PEDIDOS DISPONIBLES</td>
            </tr>
        <?php
		}
		?>
	</tbody> 
</table>