<?php


//Importamos clase de sesión y declaramos el objeto de la clase
require_once("../../clases/class.Sesion.php");
$se = new Sesion();

//Validamos si esta iniciada la sesion para poder continuar
if(!isset($_SESSION['se_SAS']))
{
	//Si no esta iniciada la sesion, enviamos a login.
	header("Location: ../../login.php");
	exit;
}


    
//Importamos las clases que vamos a utilizar
require_once("../../clases/conexcion.php");	 
require_once("../../clases/class.Categorias.php");
require_once("../../clases/class.Paqueterias.php");
require_once("../../clases/class.Fechas.php");


//Declaramos los objetos de clase
$db = new MySQL();
$gu = new Categoria();
$fe = new Fechas();
$pa = new Paqueterias();

//Enviamos el objeto de la conexión a las clases que lo requieren.
$gu->db = $db;
$pa->db = $db;

$id = $_GET['id'];
$idmenu=$_GET['idmenumodulo'];

$result_paqueterias = $pa->obtener_activas();
$result_paqueterias_num = $db->num_rows($result_paqueterias);
$result_paqueterias_row = $db->fetch_assoc($result_paqueterias);


//Validamos si recibimos parametro por GET
if(isset($_GET['subcategoria'])){
	//Si viene el id recibimos el parametro y cargamos los datos en el formulario
	$subcat = $_GET['subcategoria'];
	
	
	$result = $gu->buscar_subcat($subcat);
	$result_row = $db->fetch_assoc($result);
	
	$no_guia = $subcat;
	$nombre = $result_row['nombre'];
	$comentario = $result_row['descripcion'];
	$estatus = $result_row['estatus'];
	
}else{
	$no_guia ="";
	$nombre ="";
	
	$comentario ="";
	$estatus ="";
	
	$subcat = 0;
}

?>

<script type="text/javascript">
	$('#titulo-visor').html("SUBCATEGORIAS DE LA CATEGORIA # <?php echo $id; ?>");
</script>
<form id="form_subcategoria" method="post" action="">
<div class="row">
	<div class="col-md-12">
		<button type="button" onclick="aparecermodulos('productos/categorias/li_subcategorias.php?id=<?php echo $id; ?>&idmenumodulo=<?php echo $idmenu; ?>','contenedor-modal-forms');" class="btn btn-outline-primary" style="float: right;"> <i class="fas fa-undo"></i> REGRESAR</button>
		<div style="clear: both;"></div>
	</div>
</div>

<br>

<div class="row">
	<div class="col-md-12">
		
		
		<div class="form-group m-t-20">
			<label>NOMBRE:</label>
			<input name="nombre" id="nombre" title="NOMBRE" type="text" class="form-control"  value="<?php echo $nombre; ?>"  >
		</div>
		
		
		
		
		<div class="form-group m-t-20">
			<label>COMENTARIOS:</label>
			<input name="comentario" id="comentario" title="COMENTARIO" type="text" class="form-control"  value="<?php echo $comentario; ?>"  >
		</div>
		
		<div class="form-group m-t-20">
			<label>ESTATUS:</label>
			<select id="estatus" name="estatus" class="form-control">
				<option <?php if($estatus == 0){ echo "selected"; } ?> value="0">DESACTIVADO</option>
				<option <?php if($estatus == 1){ echo "selected"; } ?> value="1">ACTIVADO</option>
				
			</select>
		</div>
		
		<div style="width: 100%;">
			<input type="hidden" id="categoria" name="categoria" value="<?php echo $id; ?>" />
			<input type="hidden" id="subcategoria" name="subcategoria" value="<?php echo $subcat; ?>" />
			<button id="btn_deposito" type="button" onClick="GuardarEspecial('form_subcategoria','productos/categorias/ga_subcategorias.php','productos/categorias/li_subcategorias.php?idmenumodulo=<?php echo ($idmenu);?>&id=<?php echo ($id);?>','contenedor-modal-forms');" class="btn btn-outline-success alt_btn" style="float: right;">  <i class="far fa-save"></i>  GUARDAR</button>				
		</div>
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


<script type="text/javascript"	src="js/validaciones/subcategorias.js"></script>