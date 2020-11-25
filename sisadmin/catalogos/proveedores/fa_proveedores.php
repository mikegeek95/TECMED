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


//conecto a la base de datos

require_once("../../clases/conexcion.php");
require_once("../../clases/class.Proveedores.php");
require_once("../../clases/class.Funciones.php");



$db = new MySQL();
$proveedor = new Proveedor();
$f= new Funciones();

$proveedor->db = $db;

if(isset($_GET['id'])){
$proveedor->id_proveedores = $_GET['id'];
$result_proveedor = $proveedor->ObtenerDatosProveedores();
	$titulo=$f->imprimir_cadena_utf8("MODIFICACIÓN DE PROVEEDOR");
	$empresa=$f->imprimir_cadena_utf8($result_proveedor['nombre']);
	$direccion=$f->imprimir_cadena_utf8($result_proveedor['direccion']);
	$telefono=$f->imprimir_cadena_utf8($result_proveedor['telefono']);
	$email=$f->imprimir_cadena_utf8($result_proveedor['email']);
	$contacto=$f->imprimir_cadena_utf8($result_proveedor['contacto']);
	$url=$f->imprimir_cadena_utf8($result_proveedor['url']);
	
}else{
	$titulo=$f->imprimir_cadena_utf8("ALTA DE PROVEEDOR");
	$proveedor->id_proveedores="0";
	$empresa="";
	$direccion="";
	$telefono="";
	$email="";
	$contacto="";
	$url="";
}
?>

<form id="proveedor" method="post" action="">
	

	
	<div class="card mb-3">
		
			<div class="card-header">
			<h5 class="m-0 font-weight-bold text-primary" style="float: left; margin-top: 5px;"><?php echo ($titulo);?></h5>
			<button type="button" onClick="aparecermodulos('catalogos/proveedores/vi_proveedores.php?idmenumodulo=<?php echo ($idmenu);?>','main');" class="btn btn-outline-primary" style="float: right;">  <i class="fas fa-undo"></i>  VER PROVEEDORES</button>
			
		</div>
		
		
		<div class="card-body">
			<div class="form-group m-t-20">
				<label>Nombre de la Empresa:</label>
				<input type="text" name="nombre" id="nombre" class="form-control" title="Campo Nombre del Proveedor"  value="<?php echo $empresa; ?>" />
			</div>

			<div class="form-group m-t-20">
				<label>Direcci&oacute;n:</label>
				<textarea name="direccion" id="direccion" class="form-control"><?php echo $direccion; ?></textarea>
			</div>
			
			<div class="form-group m-t-20">
				<label>Tel&eacute;fono:</label>
				<input type="text" name="telefono" id="telefono" class="form-control" title="Campo Tel&eacute;fono Del Proveedor"  <?php echo $telefono; ?> />
			</div>
			
			<div class="form-group m-t-20">
				<label>E-mail:</label>
				<input type="text" name="email" id="email" class="form-control" title="Campo E-mail Del Proveedor" value="<?php echo $email; ?>" />
			</div>
			
			<div class="form-group m-t-20">
				<label>Contacto:</label>
				<input type="text" name="contacto" id="contacto" class="form-control" title="Campo Contacto Del Proveedor"  value="<?php echo 
				$contacto; ?>" />
			</div>
			
			<div class="form-group m-t-20">
				<label>URL:</label>
				<input type="text" name="url" id="url" class="form-control" title="URL"  value="<?php echo $url; ?>" />
			</div>
		</div>
		
		<div class="card-footer text-muted">
			<input name="id" type="hidden" id="id" value="<?php echo $proveedor->id_proveedores; ?>" />
			<button type="button" onClick="GuardarEspecial('proveedor','catalogos/proveedores/ga_proveedores.php','catalogos/proveedores/vi_proveedores.php?idmenumodulo=<?php echo ($idmenu);?>','main');" class="btn btn-outline-success alt_btn" style="float: right;" >  <i class="far fa-save"></i>  GUARDAR</button>
	  	</div>
	</div>
</form>

<script type="text/javascript"	src="js/validaciones/proveedores.js"></script>