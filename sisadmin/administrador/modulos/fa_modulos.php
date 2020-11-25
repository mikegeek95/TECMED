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
require_once("../../clases/class.ModulosMenu.php");
require_once("../../clases/class.Funciones.php");

try
{
	$db = new MySQL();
	$mm = new ModulosMenu();
	$fu = new Funciones();
	
	$mm->db=$db;
	
	if(isset($_GET['id'])){
	$idmodulo=$_GET['id'];
	
	$mm->idmodulo=$idmodulo;
	$datos=$mm->ObtenerInfoModulo();
		$titulo=$fu->imprimir_cadena_utf8("MODIFICACIÓN DE MÓDULO");
		$modulo=$fu->imprimir_cadena_utf8($datos['modulo']);
		$nivel=$fu->imprimir_cadena_utf8($datos['nivel']);
		$estatus=$datos['estatus'];
		$icono=$fu->imprimir_cadena_utf8($datos['icono']);
		$tipo=2;
	}
	   else {
		   $titulo=$fu->imprimir_cadena_utf8("ALTA DE MÓDULO");
		$idmodulo=0;
		$modulo="";
		$nivel="";
		 $estatus="";
		   $icono ="";
		   $tipo=1;
	}
?>
<form id="alta_modulos" method="post" action="">
	<div class="card">
		<div class="card-header">
			<h5 class="m-0 font-weight-bold text-primary" style="float: left;"><?php echo ($titulo);?></h5>
			<button type="button" onClick="aparecermodulos('administrador/modulos/vi_modulos.php?idmenumodulo=<?php echo ($idmenu);?>','main');" class="btn btn-outline-primary" style="float: right;"><i class="fas fa-undo"></i>  Ver Modulos</button>
			<div style="clear: both;"></div>
		</div>
		
		<div class="card-body row">
			<div class="form-group m-t-20 col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
				<label>Nombre del M&oacute;dulo:</label>
				<input type="text" name="nombre" id="nombre" class="form-control" title="Nombre" value="<?php echo $modulo ?>" />
			</div>
			
			<div class="form-group m-t-20 col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
				<label>Nivel en el Orden:</label>
				<input type="text" name="nivel" id="nivel" class="form-control" title="Nivel de Orden"  value="<?php echo $nivel; ?>" />
			</div>
			
			<div class="form-group m-t-20 col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
				<label>Estatus:</label>
				<select id="estatus" name="estatus" class="form-control">
					<option value="1" <?php if($estatus==1){echo 'selected="selected"';}?> >Activo</option>
					<option value="0" <?php if($estatus==0){echo 'selected="selected"';}?> >Inactivo</option>
				</select>
			</div>
			
			<div class="form-group m-t-20 col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
				<label>&Iacute;cono:</label>
				<div class="input-group mb-3">
			  <div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon1"><div id="mostraricono" class ="col-4"><i class="<?php echo $icono; ?>"></i></div></span>
			  </div>
				<input type="text" name="icono" id="icono" class="form-control" title="Icono" onchange="actualizaricono();" placeholder="fas fa-bars" value="<?php echo $icono; ?>" />
				
			</div>
			</div>
			<div class="form-group m-t-20 col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<label>* Para asignar un &iacute;cono a tu men&uacute; <a href="https://fontawesome.com/icons?d=gallery&m=free" target="_blank"> click aqui </a> </label><br>
				<label>* Asegurece de usar los &iacute;conos gratuitos, estos se pueden diferenciar por su tono oscuro </label><br>
				<label>* Al seleccionar un icono, este se mostrara de forma individual, en la parte superior encontrara la siguiente referencia:  <?php echo ('<-i class="fas fa-bars" ></-i>');?> </label><br>
				<label>* Asegurece solo de copiar el texto dentro de las comillas class: class"este texto" </label><br>
				<label>* Al introducir el c&oacute;digo podra ver cambiar el icono de la izquierda;</label><br>
			</div>
			
		</div>
		
		<div class="card-footer">
			<input type="hidden" name="tipo" id="tipo" value="<?php echo ($tipo); ?>" />
    		<input type="hidden" name="idmodulo" id="idmodulo" value="<?php echo $idmodulo;?>" />
			<button type="button" onClick=" GuardarEspecial('alta_modulos','administrador/modulos/ga_modulosMenu.php','administrador/modulos/vi_modulos.php?idmenumodulo=<?php echo ($idmenu); ?>','main');" class="btn btn-outline-success alt_btn" style="float: right;" ><i class="far fa-save"></i>  Guardar</button>
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
<script type="text/javascript" charset="utf-8">
 function actualizaricono(){
	
	var icono = $("#icono").val();
	
	$("#mostraricono").html("<i class='"+icono+"' > </i>")
	
}
</script>
<script type="text/javascript"	src="js/validaciones/modulos.js"></script>