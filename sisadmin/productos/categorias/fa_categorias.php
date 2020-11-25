<?php

require_once("../../clases/class.Sesion.php");
//creamos nuestra sesion.
$se = new Sesion();


if(!isset($_SESSION['se_SAS']))
{
	header("Location: ../../login.php");
	exit;
}


if (!isset($_SESSION)) 

{

  session_start();

}

$idmenu=$_GET['idmenumodulo'];

require_once("../../clases/conexcion.php");
require_once("../../clases/class.Categorias.php");
require_once("../../clases/class.Funciones.php");

   //creacion de objetos
   $db = new MySQL();
   $fu = new Funciones();

   $categoria = new Categoria();
   $categoria->db = $db;

   

   //recibimos variables id para su busqueda
if(isset($_GET['id']))
{
   $categoria->id_categoria = $_GET['id'];

   $titulo=$fu->imprimir_cadena_utf8("MODIFICACIÓN DE CATEGORÍA");

   //obtengo valores de la categoria

   $result_categoria = $categoria->ObtenerDatosCategoria();
	$id=$_GET['id'];
	$nombre=$fu->imprimir_cadena_utf8($result_categoria['nombre']);
	$descripcion=$fu->imprimir_cadena_utf8($result_categoria['descripcion']);
	$nivel=$fu->imprimir_cadena_utf8($result_categoria['nivel']);
	$estatus=$fu->imprimir_cadena_utf8($result_categoria['estatus']);

}
else{
	$titulo=$fu->imprimir_cadena_utf8("ALTA DE CATEGORÍA");
	$id=0;
	$nombre="";
	$descripcion="";
	$nivel="";
	$estatus="";
	
}




?>

<form id="form_categoria" method="post" action="">
	<div class="card mb-3">
		<div class="card-header">
			<h5 class="m-0 font-weight-bold text-primary" style="float: left; "><?php echo ($titulo);?></h5>
			<button type="button" onClick="aparecermodulos('productos/categorias/vi_categorias.php?idmenumodulo=<?php echo $idmenu; ?>','main');" class="btn btn-outline-primary" style="float: right;"> <i class="fas fa-undo"></i>  VER CATEGOR&Iacute;AS</button>
			<div style="clear: both;"></div>
		</div>
	
	
	
		
		
		<div class="card-body">
			<div class="form-group m-t-20">
				<label>Nombre de la Categor&iacute;a:</label>
				<input type="text" name="nombre" id="nombre" class="form-control" title="Campo Nombre de la Categor&iacute;a" onkeypress="bloquearMas(event.keyCode);"  value="<?php echo $nombre; ?>" />
			</div>

			<div class="form-group m-t-20">
				<label>Descripci&oacute;n de la Categor&iacute;a:</label>
				<textarea name="descripcion" rows="7" id="descripcion" class="form-control"  title="Campo Descripci&oacute;n"><?php echo $descripcion; ?></textarea>
			</div>
		
			<div class="form-group m-t-20">
				<label>Nivel:</label>
				<input type="text" name="nivel" id="nivel" class="form-control" title="Nivel" onkeypress="bloquearMas(event.keyCode);" placeholder="1" value="<?php echo $nivel; ?>" />
			</div>
			
			<div class="form-group m-t-20">
				<label>Estatus:</label>
				<select id="estatus" name="estatus" class="form-control" title="Estatus">
					<option value="1" <?php if($estatus == 1){ echo "selected"; } ?>>ACTIVADO</option>
					<option value="0" <?php if($estatus == 0){ echo "selected"; } ?>>DESACTIVADO</option>
				</select>
			</div>
		</div>
		
		<div class="card-footer text-muted">
			<input name="id" type="hidden" id="id" value="<?php echo $id ; ?>" />
			<button type="button" onClick="GuardarEspecial('form_categoria','productos/categorias/ga_categorias.php','productos/categorias/vi_categorias.php?idmenumodulo=<?php echo ($idmenu);?>','main');" class="btn btn-outline-success alt_btn" style="float: right;"> <i class="far fa-save"></i> GUARDAR</button>
	  	</div>
	</div>
</form>

<script type="text/javascript"	src="js/validaciones/categorias.js"></script>