<?php
/*=============================*
*  Proyecto: CALZADO DAYANARA *
*     CAPSE - 12/02/2019      *
* I.S.C José Carlos Santillán *
*=============================*/

//Importamos clase de sesión y declaramos el objeto de la clase
require_once("../clases/class.Sesion.php");
$se = new Sesion();

//Validamos si esta iniciada la sesion para poder continuar
if(!isset($_SESSION['se_SAS']))
{
	//Si no esta iniciada la sesion, enviamos a login.
	header("Location: ../login.php");
	exit;
}

//Al incluir este header nos olvidamos de colocar el utf8_encode para visualizar caracteres especiales á ñ etc.
header("Content-Type: text/text; charset=ISO-8859-1");
    
//Importamos las clases que vamos a utilizar
require_once("../clases/conexcion.php");	 
require_once("../clases/class.Guias_pedidos.php");
require_once("../clases/class.Paqueterias.php");
require_once("../clases/class.Fechas.php");


//Declaramos los objetos de clase
$db = new MySQL();
$gu = new Guias_pedido();
$fe = new Fechas();
$pa = new Paqueterias();

//Enviamos el objeto de la conexión a las clases que lo requieren.
$gu->db = $db;
$pa->db = $db;

$id = $_GET['id'];


$result_paqueterias = $pa->obtener_activas();
$result_paqueterias_num = $db->num_rows($result_paqueterias);
$result_paqueterias_row = $db->fetch_assoc($result_paqueterias);


//Validamos si recibimos parametro por GET
if(isset($_GET['idguias'])){
	//Si viene el id recibimos el parametro y cargamos los datos en el formulario
	$idguias = $_GET['idguias'];
	
	$gu->idguias = $idguias;
	
	$result = $gu->buscar_guia();
	$result_row = $db->fetch_assoc($result);
	
	$no_guia = $result_row['idguias'];
	$idpaqueterias = $result_row['idpaqueterias'];
	$fecha_envio = $result_row['fecha_envio'];
	$comentario = $result_row['comentario'];
	$estatus = $result_row['estatus'];
	
}else{
	$no_guia = "";
	$idpaqueterias = "";
	$fecha_envio = "";
	$comentario = "";
	$estatus = "";
	
	$idguias = 0;
}

?>

<script type="text/javascript">
	$('#titulo-visor').html("GUIAS DE PEDIDO # <?php echo $id; ?>");
</script>

<div class="row">
	<div class="col-md-12">
		<button type="button" onclick="aparecermodulos('ventas/vi_guias_pedido.php?id=<?php echo $id; ?>','contenedor-visor-modal');" class="btn btn-primary" style="float: right;">REGRESAR</button>
		<div style="clear: both;"></div>
	</div>
</div>

<br>

<div class="row">
	<div class="col-md-12">
		
		
		<div class="form-group m-t-20">
			<label>PAQUETER&Iacute;A:</label>
			<select id="idpaqueterias" name="idpaqueterias" class="form-control">
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
			<input name="no_guia" id="no_guia" title="No. GU&Iacute;A" type="text" class="form-control" placeholder="No. GU&Iacute;A" value="<?php echo $no_guia; ?>"  required>
		</div>
		
		<div class="form-group m-t-20">
			<label>FECHA DE ENVO:</label>
			<input name="fecha_envio" id="fecha_envio" title="FECHA DE ENVIO" type="text" class="form-control" placeholder="FECHA DE ENVIO" value="<?php echo $fecha_envio; ?>" required>
			<span id="mensaje-ref" style="font-size: 11px; display: none; color:#F00;"></span>
		</div>
		
		<div class="form-group m-t-20">
			<label>COMENTARIOS:</label>
			<input name="comentario" id="comentario" title="COMENTARIO" type="text" class="form-control" placeholder="COMENTARIO" value="<?php echo $comentario; ?>"  required>
		</div>
		
		<div class="form-group m-t-20">
			<label>ESTATUS:</label>
			<select id="estatus" name="estatus" class="form-control">
				<option <?php if($estatus == 0){ echo "selected"; } ?> value="0">Pendiente</option>
				<option <?php if($estatus == 1){ echo "selected"; } ?> value="1">En curso</option>
				<option <?php if($estatus == 2){ echo "selected"; } ?> value="2">Entregado</option>
				<option <?php if($estatus == 3){ echo "selected"; } ?> value="3">Cancelado</option>
			</select>
		</div>
		
		<div style="width: 100%;">
			<input type="hidden" id="idnota_remision" name="idnota_remision" value="<?php echo $id; ?>" />
			<input type="hidden" id="idguias" name="idguias" value="<?php echo $idguias; ?>" />
			<button id="btn_deposito" type="button" onclick="guardar_guia();" class="btn btn-success alt_btn btn_deposito" style="float: right;">GUARDAR</button>				
		</div>
	</div>
</div>

<script>
	jQuery('#fecha_envio').datepicker({
			format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
</script>