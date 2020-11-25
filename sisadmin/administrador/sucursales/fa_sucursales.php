<?php

require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();

$idmenu=$_GET['idmenumodulo'];

if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../../login.php");
	exit;
}

require_once("../../clases/conexcion.php");
require_once("../../clases/class.Sucursales.php");
require_once("../../clases/class.Funciones.php");



try
{
	$db= new MySQL();
	$su = new Sucursales();
	$f=new Funciones();
	
	$su->db = $db;
	
	if(!isset($_GET['id'])){
		$id = 0;
		$titulo=$f->imprimir_cadena_utf8("ALTA DE SUCURSAL");
		$nombre = "";
		$direccion = "";
		$tel =  "";
		$email = "";
		$tipo = "";
		$estatus = "";
		$notas_print = "";
	}else{
		$id = $_GET['id'];
		
		$su->idsucursales = $id;
		
		//Buscamos sucursal
		$result_sucursal = $su->buscar_sucursal();
		$result_sucursal_row = $db->fetch_assoc($result_sucursal);
		$titulo=$f->imprimir_cadena_utf8("MODIFICACIÓN DE SUCURSAL");
		$nombre = $f->imprimir_cadena_utf8($result_sucursal_row['sucursal']);
		$direccion = $f->imprimir_cadena_utf8($result_sucursal_row['direccion']);
		$tel = $f->imprimir_cadena_utf8($result_sucursal_row['tel']);
		$email = $f->imprimir_cadena_utf8($result_sucursal_row['email']);
		$tipo = $f->imprimir_cadena_utf8($result_sucursal_row['tipo']);
		$estatus = $f->imprimir_cadena_utf8($result_sucursal_row['estatus']);
		$notas_print = $f->imprimir_cadena_utf8($result_sucursal_row['notas_print']);
	}
	
	
?>
<form id="alta_sucursales" method="post" action="">
	<div class="card">
		<div class="card-header">
			<h5 class=" m-b-0 font-weight-bold text-primary" style="float: left;"><?php echo ($titulo);?></h5>

			
				<button type="button" onClick="aparecermodulos('administrador/sucursales/vi_sucursales.php?idmenumodulo=<?php echo ($idmenu);?>','main');" class="btn btn-outline-primary" style="float: right;"><i class="fas fa-undo"></i> Ver Sucursales</button>
				<div style="clear: both;"></div>
			</div>
<div class="card-body">
			<div class="form-group m-t-20">
				<label>Nombre de la Sucursal:</label>
				<input type="text" name="nombre" id="nombre" class="form-control" title="Nombre"  value="<?php echo $nombre; ?>" />
			</div>
			
			<div class="form-group m-t-20">
				<label>Direcci&oacute;n:</label>
				<textarea type="text"  name="direccion" id="direccion" class="form-control" title="Direcci&oacute;n" ><?php echo $direccion; ?></textarea>
			</div>
			
			<div class="form-group m-t-20">
				<label>Tel&eacute;fono:</label>
				<input type="text" name="tel" id="tel" class="form-control" title="Tel&eacute;fono"  value="<?php echo $tel; ?>" />
			</div>
			
			<div class="form-group m-t-20">
				<label>Email:</label>
				<input type="text" name="email" id="email" class="form-control" title="Email"  value="<?php echo $email; ?>" />
			</div>
			
			<div class="form-group m-t-20">
				<label>Tipo de impresi&oacute;n:</label>
				<select id="notas_print" name="notas_print" class="form-control">
					<option value="0" <?php if($notas_print == 0){ echo "selected";} ?>>Carta</option>
					<option value="1" <?php if($notas_print == 1){ echo "selected";} ?>>T&eacute;rmica 80mm</option>
					<!--<option value="2" <?php if($notas_print == 2){ echo "selected";} ?>>T&eacute;rmica 57mm</option>-->
				</select>
			</div>
	
			<div class="form-group m-t-20">
				<label>Estatus:</label>
				<select id="estatus" name="estatus" class="form-control">
					<option value="0" <?php if($estatus == 0){ echo "selected";} ?>>Desactivado</option>
					<option value="1" <?php if($estatus == 1){ echo "selected";} ?>>Activado</option>
					
				</select>
			</div> 
            
		</div>

		<div class="card-footer">			
			<input type="hidden" name="tipo" id="tipo" value="1" />
			<input type="hidden" id="v_id" name="v_id" value="<?php echo $id; ?>" />
			<button type="button" onClick=" GuardarEspecial('alta_sucursales','administrador/sucursales/ga_sucursales.php','administrador/sucursales/vi_sucursales.php?idmenumodulo=<?php echo ($idmenu);?>','main');" class="btn btn-outline-success alt_btn" style="float: right;" ><i class="far fa-save"></i> Guardar</button>
		</div>
	</div>
</form>

<?php
}
catch(Exception $e)
{
	echo $e;
}
?>
<script type="text/javascript"	src="js/validaciones/sucursales.js"></script>