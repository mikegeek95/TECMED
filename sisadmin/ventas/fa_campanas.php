<?php
header("Content-Type: text/text; charset=ISO-8859-1");
require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}

require_once("../clases/conexcion.php");
require_once("../clases/class.Campanas.php");

$db = new MySQL();
$cam = new Campanas();

$cam->db = $db;

if(!isset($_GET['id'])){
	$id = 0;
	$nombre = '';
	$fecha_inicio = '';
	$fecha_fin = '';
}else{
	$id = $_GET['id'];
	
	$cam->idsobrepedido_camp = $id;
	
	$result_campana = $cam->buscar_campana();
	$result_campana_row = $db->fetch_assoc($result_campana);
	
	$nombre = $result_campana_row['nombre'];
	$fecha_inicio = $result_campana_row['fecha_inicio'];
	$fecha_fin = $result_campana_row['fecha_fin'];
}

?>


<form id="alta_campanas" method="post" action="">
	
	<div class="card mb-3">
		<div class="card-header">
			<h5 class="card-title" style="float: left; margin-top: 5px;">ALTA DE CAMPA&Ntilde;A</h5>
			<button type="button" onClick="aparecermodulos('ventas/vi_campanas.php','main');" class="btn btn-info" style="float: right;">VER CAMPA&Ntilde;AS</button>
			<div style="clear: both;"></div>
		</div>
	</div>
	
	<div class="card mb-3">
		<div class="card-header">
			<h5 class="card-title" style="float: left; margin-top: 5px;">DATOS GENERALES</h5>
		</div>
		
		<div class="card-body">
			<div class="form-group m-t-20">
				<label>Nombre:</label>
				<input type="text" name="v_nombre" id="v_nombre" class="form-control" title="Campo Nombre de la Categor&iacute;a" onkeypress="bloquearMas(event.keyCode);" placeholder="Abarrotes" value="<?php  echo $nombre;?>" />
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group m-t-20">
						<label>Fecha inicio:</label>
						<div class="input-group">
							<input type="text" class="form-control" name="v_fecha_inicio" id="v_fecha_inicio" placeholder="yyyy-mm-dd" value="<?php echo $fecha_inicio; ?>">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-calendar"></i></span>
							</div>
						</div>
					</div>
				</div>
			
				<div class="col-md-6">
					<div class="form-group m-t-20">
						<label>Fecha fin:</label>
						<div class="input-group">
							<input type="text" class="form-control" name="v_fecha_fin" id="v_fecha_fin" placeholder="yyyy-mm-dd" value="<?php echo $fecha_fin; ?>">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-calendar"></i></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="card-footer text-muted">
			<input type="hidden" id="v_id" name="v_id" value="<?php echo $id; ?>" />
			<button type="button" onClick="var resp=MM_validateForm('v_nombre','','R','v_fecha_inicio','','R','v_fecha_fin','','R'); if(resp==1){ GuardarEspecial('alta_campanas','ventas/ga_campanas.php','ventas/vi_campanas.php','main');}" class="btn btn-success alt_btn" style="float: right;">GUARDAR</button>
	  	</div>
	</div>
</form>


<!--<link rel="stylesheet" type="text/css" href="assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<script src="assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>-->

<script>
	jQuery('#v_fecha_inicio').datepicker({
			format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
	
	jQuery('#v_fecha_fin').datepicker({
			format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
</script>