<?php
require_once("../clases/class.Sesion.php");
$se = new Sesion();

require_once("../clases/conexcion.php");
require_once("../clases/class.Fechas.php");
require_once("../clases/class.Configuracion.php");
require_once("../clases/class.Campanas.php");


$db = new MySQL();
$fe = new Fechas();
$conf = new Configuracion();
$cam = new Campanas();

$conf->db = $db;
$cam->db = $db;

$tipo = $_SESSION['se_sas_Tipo'];

$cam->nombre = utf8_decode($_POST['v_nombre']);
$cam->fecha_inicio = $_POST['v_f_inicio'];
$cam->fecha_fin = $_POST['v_f_fin'];

$result_campanas = $cam->obtener_filtro();
$result_campanas_num = $db->num_rows($result_campanas);
$result_campanas_row = $db->fetch_assoc($result_campanas);

?>
<script type="text/javascript" charset="utf-8">
	var oTable = $('#d_campanas').dataTable( {	
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
			<th align="center">NOMBRE</th> 
			<th align="cealign=">F. INICIO</th>
			<th align="center">F. FIN</th>
			<th align="center">ACCI&Oacute;N</th>
		</tr> 
	</thead> 
	<tbody> 
		<?php
		if($result_campanas_num != 0){
			do
			{
		?>
			<tr> 
				<td><?php echo utf8_encode($result_campanas_row['nombre']); ?></td> 
				<td><?php echo $fe->f_esp($result_campanas_row['fecha_inicio']); ?></td>
				<td><?php echo $fe->f_esp($result_campanas_row['fecha_fin']); ?></td>
				<td align="center">
					
					<button type="button" onClick="imprimirPDF('ventas/pdf/reporteProduccion.php?id=<?php echo $result_campanas_row['idsobrepedido_camp']; ?>')" title="REPORTE DE PRODUCCI&Oacute;N" class="btn btn-outline-danger"><i class="mdi mdi-printer"></i></button>
					
					<button type="button" onClick="aparecermodulos('ventas/fa_campanas.php?id=<?php echo $result_campanas_row['idsobrepedido_camp']?>','main');" title="EDITAR" class="btn btn-outline-info"><i class="mdi mdi-table-edit"></i></button>
							
					<button type="button" onClick="BorrarDatos('<?php echo $result_campanas_row['idsobrepedido_camp']?>','idsobrepedido_camp','sobrepedido_camp','n','ventas/vi_campanas.php','main')" title="BORRAR" class="btn btn-outline-danger"><i class="mdi mdi-delete-empty"></i></button>
					
				</td> 
			</tr>
		<?php	
			}while($result_campanas_row = $db->fetch_assoc($result_campanas));
		}
		?>
	</tbody> 
</table>