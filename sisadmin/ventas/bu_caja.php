<?php
require_once("../clases/class.Sesion.php");
$se = new Sesion();

require_once("../clases/conexcion.php");
require_once("../clases/class.Clientes.php");
require_once("../clases/class.Fechas.php");
require_once("../clases/class.Configuracion.php");
require_once("../clases/class.Ventas.php");
require_once("../clases/class.Funciones.php");


$db = new MySQL();
$cl = new Clientes();
$fe = new Fechas();
$conf = new Configuracion();
$ve = new Ventas();
$fu = new Funciones();

$conf->db = $db;
$ve->db = $db;
$cl->db = $db;

$tipo = $_SESSION['se_sas_Tipo'];


$fecha = ($_POST['inicio'] != '' ) ? $_POST['inicio'] : '';
$fecha_fin =($_POST['f_fin'] != '' ) ? $_POST['f_fin'] : '';
$fecha_actual = $fe->fechaaYYYY_mm_dd_guion();

$nombre = trim($_POST['nombre']);
$estatust = $_POST['estatust'];
$idorden = $_POST['v_idventa'];
$autorizados = $_POST['autorizados'];


$ve->fecha = $fecha;
$ve->fecha_fin = $fecha_fin;
$ve->fecha_actual = $fecha_actual;
$ve->nombre = utf8_decode($nombre);
$ve->estatust = $estatust;
$ve->idorden = $idorden;
$ve->autorizados = $autorizados;
$ve->tipo = $tipo;


$pedidos = $ve->pendientes_filtro();
$pedidos_num = $db->num_rows($pedidos);


$pedidos_row = $db->fetch_assoc($pedidos);

$tipopago = array('Efectivo','TC','TD','Cheque','Depósito','Transferencia');
$estatus  = array('Pendiente','Pagado','Cancelado','Créditos','Crédito Pagado','Transferencia','Autorizados');

?>

<!--INCERTAMOS SKINK PARA EL MANEJO DE LAS TABLAS--> 

        <style type="text/css" title="currentStyle">
			@import "js/grid/css/demo_page.css";
			@import "js/grid/css/demo_table.css";
		</style>
		<!--<script type="text/javascript" language="javascript" src="js/grid/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="js/grid/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="js/grid/js/FixedColumns.js"></script>
		<script type="text/javascript" language="javascript" src="js/grid/js/FixedColumns.min.js"></script>-->
        
        
        <!-- DataTables CSS -->
            <link rel="stylesheet" type="text/css" href="js/media/css/jquery.dataTables.css">
        <!-- jQuery -->
            <script type="text/javascript" charset="utf8" src="js/media/js/jquery.js"></script> 
        <!-- DataTables -->
            <script type="text/javascript" charset="utf8" src="js/media/js/jquery.dataTables.js"></script>
    
    <!--TERMINAMOS SKIN DE EL MANEJO DE LAS TABLAS--> 


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
			if($pedidos_num != 0){
				do
				{
					if($pedidos_row['idcliente'] != 0)
					{
						$cl->idCliente = $pedidos_row['idcliente'];								
						$result_cliente = $cl->ObtenerInformacionCliente();					
						$cliente = utf8_encode($result_cliente['nombre'].' '.$result_cliente['paterno'] .' '.$result_cliente['materno']);
					}else{
						$cliente = "VENTANILLA";			
					}	
			?>
				<tr> 
					<td style="text-align:center"><?php echo $pedidos_row['idnota_remision']; ?></td> 
					<td><?php echo $pedidos_row['fechapedido']; ?></td>
					<td align="left"><?php echo $cliente; ?></td>
					<td align="center">$ <?php echo number_format($pedidos_row['total'],2,'.',','); ?></td>
					<td align="center"><?PHP echo $estatus[$pedidos_row['estatus']]; ?></td>
					  <?php
						$idsucursal = $pedidos_row['idsucursales'];
						$sql_sucursal = "SELECT * FROM sucursales WHERE idsucursales = '$idsucursal'";
						$result_sucursal = $db->consulta($sql_sucursal);
						$result_sucursal_row = $db->fetch_assoc($result_sucursal); 
					   ?>

					<td align="center"><?php echo utf8_encode($result_sucursal_row['sucursal']); ?></td>

					<td align="center">
						<input type="button" class="btn btn-success" value="PAGAR" onclick="verCaja('<?php echo $pedidos_row['idnota_remision']; ?>','0')"/>
					</td> 
				</tr>
		<?php
			}while($pedidos_row = $db->fetch_assoc($pedidos));
		}
		?>
	</tbody> 
</table>


