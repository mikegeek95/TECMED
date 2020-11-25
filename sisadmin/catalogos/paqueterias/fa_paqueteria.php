<?php

require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../../login.php");
	exit;
}

$idmenu=$_GET['idmenumodulo'];

require_once("../../clases/conexcion.php");
require_once("../../clases/class.Paqueterias.php");
require_once("../../clases/class.Funciones.php");

$db = new MySQL();
$pa = new Paqueterias();
$fu = new Funciones();

$pa->db = $db;

if(isset($_GET['idpaqueterias']))
{
	$idpaqueterias = $_GET['idpaqueterias'];
	
	$pa->idpaqueterias = $idpaqueterias;
	
	$result_paqueteria = $pa->buscar_paqueteria();
	$result_paqueteria_row = $db->fetch_assoc($result_paqueteria);

	$titulo=$fu->imprimir_cadena_utf8("MODIFICACIÓN DE PAQUETERÍA");
	$nombre = $fu->imprimir_cadena_utf8($result_paqueteria_row['nombre']);
	$direccion = $fu->imprimir_cadena_utf8($result_paqueteria_row['direccion']);
	$email = $fu->imprimir_cadena_utf8($result_paqueteria_row['email']);
	$tel = $fu->imprimir_cadena_utf8($result_paqueteria_row['tel']);
	$estatus = $fu->imprimir_cadena_utf8($result_paqueteria_row['estatus']);
	$urlrastreo = $fu->imprimir_cadena_utf8($result_paqueteria_row['urlrastreo']);
	
}else{
	$titulo=$fu->imprimir_cadena_utf8("ALTA DE PAQUETERÍA");
	$nombre = "";
	$direccion = "";
	$email = "";
	$tel = "";
	$estatus = 1;
	$urlrastreo = "";
	
	$idpaqueterias = 0;
}


?>

<form id="form_paqueteria" method="post" action="">

	
	<div class="card">
		<div class="card-header">
			<h5 class="m-0 font-weight-bold text-primary" style="float: left; "><?php echo ($titulo);?></h5>
			
			<div style="">
				<button type="button" onClick="aparecermodulos('catalogos/paqueterias/vi_paqueteria.php?idmenumodulo=<?php echo $idmenu; ?>','main');" class="btn btn-outline-primary" style="float: right;"> <i class="fas fa-undo"></i> Ver Modulos</button>
				<div style="clear: both;"></div>
			</div>
			
		</div>
		
		<div class="card-body">
			<div class="form-group m-t-20">
				<label>Nombre:</label>
				<input type="text" name="nombre" id="nombre" class="form-control" title="Campo Nombre de la paqueter&iacute;a" value="<?php echo $nombre; ?>"  />
			</div>

			<div class="form-group m-t-20">
				<label>Direcci&oacute;n:</label>
				<textarea  name="direccion" id="direccion" class="form-control"><?php echo $direccion; ?></textarea>
			</div>
			
			<div class="form-group m-t-20">
				<label>Tel&eacute;fono:</label>
				<input type="text" name="telefono" id="telefono" class="form-control" title="Campo Tel&eacute;fono Del Proveedor" value="<?php echo $tel; ?>" />
			</div>
			
			<div class="form-group m-t-20">
				<label>E-mail:</label>
				<input type="text" name="email" id="email" class="form-control" title="Campo E-mail Del Proveedor" value="<?php echo $email; ?>"  />
			</div>
			
			<div class="form-group m-t-20">
				<label>Url de rastreo:</label>
				<input type="text" name="urlrastreo" id="urlrastreo" class="form-control" title="Campo Url de rastreo" value="<?php echo $urlrastreo; ?>"  />
			</div>
			
			<div class="form-group m-t-20">
				<label>Estatus:</label>
				<select name="estatus" id="estatus" class="form-control">
					<option <?php if($estatus == 0){ echo "selected"; } ?> value="0">DESACTIVADO</option>
					<option <?php if($estatus == 1){ echo "selected"; } ?> value="1">ACTIVADO</option>
				</select>
			</div>
		</div>
		
		<div class="card-footer text-muted">
			<input type="hidden" id="idpaqueterias" name="idpaqueterias" value="<?php echo $idpaqueterias ?>" />
			<button type="button" onClick="GuardarEspecial('form_paqueteria','catalogos/paqueterias/ga_paqueteria.php','catalogos/paqueterias/vi_paqueteria.php?idmenumodulo=<?php echo ($idmenu);?>','main');" class="btn btn-outline-success alt_btn" style="float: right;" >  <i class="far fa-save"></i>  GUARDAR</button>
	  	</div>
	</div>
</form>

<script type="text/javascript"	src="js/validaciones/paqueterias.js"></script>