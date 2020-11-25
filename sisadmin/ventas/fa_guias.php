<?php
require_once("../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../login.php");
	exit;
}

require_once("../clases/conexcion.php");
require_once("../clases/class.Guias_pedidos.php");
require_once("../clases/class.Paqueterias.php");
require_once("../clases/class.Funciones.php");

$db = new MySQL();
$gp = new Guias_pedido();
$pa = new Paqueterias();
$fu = new Funciones();

$gp->db = $db;
$pa->db = $db;

$result_paqueterias = $pa->obtener_activas();
$result_paqueterias_num = $db->num_rows($result_paqueterias);
$result_paqueterias_row = $db->fetch_assoc($result_paqueterias);

if(!isset($_GET['id'])){
	$id = 0;
	$idnota_remision = "";
	$idpaqueterias = "";
	$fecha_envio = "";
	$comentario = "";
	$no_guia = "";
	$estatus = 1;
	
	$disabled = 'disabled';
	
	
	$disabled2 = '';
	
}else{
	$id = $_GET['id'];
	
	$gp->idguias = $id;
	
	$guia = $gp->buscar_guia();
	$guia_row = $db->fetch_assoc($guia);
	
	$idnota_remision = $guia_row['idnota_remision'];
	$idpaqueterias = $guia_row['idpaqueterias'];
	$no_guia = $guia_row['idguias'];
	$fecha_envio = $guia_row['fecha_envio'];
	$comentario = $fu->imprimir_cadena_utf8($guia_row['comentario']);
	$estatus = $guia_row['estatus'];
	
	$disabled = '';
	
	$disabled2 = 'disabled';
}

?>


<form id="alta_guias" method="post" action="">
	
	<div class="card mb-3">
		<div class="card-header">
			<h5 class="card-title" style="float: left; margin-top: 5px;">ALTA DE GU&Iacute;AS</h5>
			<button type="button" onClick="aparecermodulos('ventas/vi_guias.php','main');" class="btn btn-info" style="float: right;">VER GU&Iacute;AS</button>
			<div style="clear: both;"></div>
		</div>
	</div>
	
	<div class="card mb-3">
		<div class="card-header">
			<h5 class="card-title" style="float: left; margin-top: 5px;">DATOS GENERALES</h5>
		</div>
		
		<div class="card-body">
			
			<div class="form-group m-t-20">
				<label>No. PEDIDO:</label>
				<input name="idnota_remision" id="idnota_remision" <?php echo $disabled2; ?> title="No. PEDIDO" type="text" class="form-control" onKeyUp="validar_nota();" placeholder="No. PEDIDO" value="<?php echo $idnota_remision; ?>"  required>
				<span id="msj" style="font-size: 11px; color: #F00;"></span>
			</div>
			
			<div class="form-group m-t-20">
				<label>PAQUETER&Iacute;A:</label>
				<select id="idpaqueterias" name="idpaqueterias" class="form-control dis" <?php echo $disabled; ?>>
					<?php
					do
					{
					?>	
						<option <?php if($idpaqueterias == $result_paqueterias_row['idpaqueterias']){ echo "selected"; } ?> value="<?php echo $result_paqueterias_row['idpaqueterias']; ?>"><?php echo $result_paqueterias_row['nombre']; ?></option>
					<?php
					}while($result_paqueterias_row = $db->fetch_assoc($result_paqueterias));
					?>
				</select>
			</div>
			
			<div class="form-group m-t-20">
				<label>No. GU&Iacute;A:</label>
				<input name="no_guia" id="no_guia" title="No. GU&Iacute;A" type="text" class="form-control dis" <?php echo $disabled; ?> placeholder="No. GU&Iacute;A" value="<?php echo $no_guia; ?>"  required>
			</div>

			<div class="form-group m-t-20">
				<label>FECHA DE ENVO:</label>
				<input name="fecha_envio" id="fecha_envio" title="FECHA DE ENVIO" type="text" class="form-control dis" <?php echo $disabled; ?> placeholder="FECHA DE ENVIO" value="<?php echo $fecha_envio; ?>" required>
				<span id="mensaje-ref" style="font-size: 11px; display: none; color:#F00;"></span>
			</div>

			<div class="form-group m-t-20">
				<label>COMENTARIOS:</label>
				<input name="comentario" id="comentario" title="COMENTARIO" type="text" class="form-control dis" <?php echo $disabled; ?> placeholder="COMENTARIO" value="<?php echo $comentario; ?>"  required>
			</div>

			<div class="form-group m-t-20">
				<label>ESTATUS:</label>
				<select id="estatus" name="estatus" class="form-control dis" <?php echo $disabled; ?>>
					<option <?php if($estatus == 0){ echo "selected"; } ?> value="0">Pendiente</option>
					<option <?php if($estatus == 1){ echo "selected"; } ?> value="1">En curso</option>
					<option <?php if($estatus == 2){ echo "selected"; } ?> value="2">Entregado</option>
					<option <?php if($estatus == 3){ echo "selected"; } ?> value="3">Cancelado</option>
				</select>
			</div>
			
		</div>
		
		<div class="card-footer text-muted">
			<input type="hidden" id="idguias" name="idguias" value="<?php echo $id; ?>" />
			<button type="button" onClick="var resp=MM_validateForm('no_guia','','R','idnota_remision','','R'); if(resp==1){ GuardarEspecial('alta_guias','ventas/guardar_guias.php','ventas/vi_guias.php','main');}" class="btn btn-success alt_btn dis" <?php echo $disabled; ?> style="float: right;">GUARDAR</button>
	  	</div>
	</div>
</form>


<script>
	jQuery('#fecha_envio').datepicker({
			format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
</script>